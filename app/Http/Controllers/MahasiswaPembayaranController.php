<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\MahasiswaModel;
use App\Models\PembayaranModel;
use App\Models\Ukt;
use App\Models\UktModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;

class MahasiswaPembayaranController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Pembayaran UKT',
            'list' => ['Dashboard', 'Pembayaran UKT'],
        ];

        $page = (object) [
            'title' => 'Form Pembayaran UKT'
        ];

        $activeMenu = 'pembayaran';
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', Auth::user()->user_id)->first();
        $ukt = UktModel::where('prodi_id', $mahasiswa->prodi_id)->first();

        if (!$ukt) {
            showNotification('danger', 'Maaf, UKT belum ditentukan');
            return redirect()->route('mahasiswa.pembayaran')->with('error', 'Maaf, UKT belum ditentukan');
        }

        return view('Mahasiswa.form-pembayaran', compact('breadcrumb', 'page', 'activeMenu', 'user', 'mahasiswa', 'ukt'));
    }

    public function pay(Request $request)
    {
        $request->validate([
            'semester' => 'required|numeric|min:1|max:8'
        ]);

        try {
            $user = Auth::user();
            $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();
            $ukt = UktModel::where('prodi_id', $mahasiswa->prodi_id)->first();

            // Setup Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            $orderId = 'UKT-' . $mahasiswa->nim . '-' . time();

            // Simpan data pembayaran ke database TERLEBIH DAHULU
            $pembayaran = PembayaranModel::create([
                'order_id' => $orderId,
                'mahasiswa_id' => $mahasiswa->mahasiswa_id,
                'ukt_id' => $ukt->ukt_id,
                'semester' => $request->semester,
                'status_pembayaran' => 'success',
                'tanggal_pembayaran' => now(),
            ]);

            // Parameter transaksi Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $ukt->nominal_ukt,
                ],
                'customer_details' => [
                    'first_name' => $mahasiswa->mahasiswa_nama,
                    'email' => $user->email,
                ],
                'item_details' => [
                    [
                        'id' => 'UKT-' . $mahasiswa->nim . '-SEM-' . $request->semester,
                        'price' => $ukt->nominal_ukt,
                        'quantity' => 1,
                        'name' => 'Pembayaran UKT Semester ' . $request->semester,
                    ]
                ],
                'callbacks' => [
                    'finish' => route('mahasiswa.pembayaran.status', ['order_id' => $orderId])
                ]
            ];

            $snapToken = Snap::getSnapToken($params);

            // Update snap token ke database
            $pembayaran->update(['snap_token' => $snapToken]);

            return response()->json([
                'status' => 'success',
                'snapToken' => $snapToken,
                'order_id' => $orderId
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memproses pembayaran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function paymentStatus(Request $request, $orderId)
    {
        $breadcrumb = (object) [
            'title' => 'Status Pembayaran',
            'list' => ['Dashboard', 'Pembayaran UKT', 'Status']
        ];

        $page = (object) ['title' => 'Status Pembayaran'];
        $activeMenu = 'pembayaran';

        // Ambil data pembayaran
        $pembayaran = PembayaranModel::with(['mahasiswa', 'ukt'])
            ->where('order_id', $orderId)
            ->first();

        if (!$pembayaran) {
            return redirect()->route('mahasiswa.pembayaran')
                ->with('error', 'Data pembayaran tidak ditemukan');
        }

        return view('Mahasiswa.payment-status', compact(
            'breadcrumb',
            'page',
            'activeMenu',
            'pembayaran'
        ));
    }

    // Controller
    public function handleNotification(Request $request)
    {
        try {
            $notif = new \Midtrans\Notification();

            $transaction = $notif->transaction_status;
            $orderId = $notif->order_id;
            $fraud = $notif->fraud_status;

            // Cari data pembayaran
            $pembayaran = PembayaranModel::where('order_id', $orderId)->first();

            if (!$pembayaran) {
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            // Update status pembayaran
            if ($transaction == 'capture') {
                if ($fraud == 'challenge') {
                    $pembayaran->status_pembayaran = 'challenge';
                } else if ($fraud == 'accept') {
                    $pembayaran->status_pembayaran = 'success';
                }
            } else if ($transaction == 'settlement') {
                $pembayaran->status_pembayaran = 'success';
            } else if ($transaction == 'pending') {
                $pembayaran->status_pembayaran = 'pending';
            } else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
                $pembayaran->status_pembayaran = 'failed';
            }

            $pembayaran->metode_pembayaran = $notif->payment_type;
            $pembayaran->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
