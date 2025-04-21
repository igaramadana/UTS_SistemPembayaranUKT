<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Mahasiswa;
use App\Models\PembayaranModel;
use App\Models\Ukt;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PembayaranController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Riwayat Pembayaran',
            'list' => ['Pembayaran', 'Riwayat'],
        ];

        $page = (object) [
            'title' => 'Riwayat Pembayaran UKT'
        ];

        $activeMenu = 'pembayaran';

        return view('Admin.pembayaran.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list()
    {
        $pembayaran = PembayaranModel::with([
            'mahasiswa' => function ($query) {
                $query->with(['prodi' => function ($q) {
                    $q->with('jurusan');
                }]);
            },
            'ukt'
        ]);

        return DataTables::of($pembayaran)
            ->addIndexColumn()
            ->addColumn('order_id', function ($pembayaran) {
                return $pembayaran->order_id;
            })
            ->addColumn('tanggal_pembayaran', function ($pembayaran) {
                return date('d-m-Y', strtotime($pembayaran->tanggal_pembayaran));
            })
            ->addColumn('nim', function ($pembayaran) {
                return $pembayaran->mahasiswa->nim;
            })
            ->addColumn('mahasiswa_nama', function ($pembayaran) {
                return $pembayaran->mahasiswa->mahasiswa_nama;
            })
            ->addColumn('jurusan', function ($pembayaran) {
                return $pembayaran->mahasiswa->prodi->jurusan->jurusan_nama ?? '-';
            })
            ->addColumn('prodi', function ($pembayaran) {
                return $pembayaran->mahasiswa->prodi->prodi_nama ?? '-';
            })
            ->addColumn('jenis_masuk', function ($pembayaran) {
                return $pembayaran->ukt->jenis_masuk ?? '-';
            })
            ->addColumn('nominal', function ($pembayaran) {
                return 'Rp ' . number_format($pembayaran->ukt->nominal_ukt ?? 0, 0, ',', '.');
            })
            ->addColumn('semester', function ($pembayaran) {
                return $pembayaran->semester;
            })
            ->addColumn('action', function ($pembayaran) {
                $btn = '<a href="#" class="btn btn-primary btn-sm">Detail</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
