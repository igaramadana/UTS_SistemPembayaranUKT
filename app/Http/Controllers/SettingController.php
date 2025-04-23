<?php

namespace App\Http\Controllers;

use App\Models\JurusanModel;
use App\Models\ProdiModel;
use App\Models\UktModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Settings',
            'list' => ['Settings', 'Tarif UKT'],
        ];
        $page = (object) [
            'title' => 'Tarif UKT',
        ];
        $activeMenu = 'tarif';

        $prodis = ProdiModel::all();
        $jurusans = JurusanModel::all();
        return view('Admin.tarif.index', compact('breadcrumb', 'page', 'activeMenu', 'prodis', 'jurusans'));
    }

    public function list()
    {
        $ukt = UktModel::select('ukt_id', 'prodi_id', 'jenis_masuk', 'nominal_ukt')->with(['prodi.jurusan']);

        return DataTables::of($ukt)
            ->addIndexColumn()
            ->addColumn('nominal_ukt', function ($ukt) {
                return 'Rp. ' . number_format($ukt->nominal_ukt, 0, ',', '.');
            })
            ->addColumn('action', function ($ukt) {
                $btn = '<a href="' . route('settings.show', $ukt->ukt_id) . '" class="btn btn-primary btn-sm btn-edit">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . route('settings.edit', $ukt->ukt_id) . '\')" class="btn btn-warning btn-sm btn-edit">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . route('settings.confirm', $ukt->ukt_id) . '\')" class="btn btn-danger btn-sm btn-delete">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'prodi_id' => 'required|exists:prodi,prodi_id',
            'jenis_masuk' => 'required',
            'nominal_ukt' => 'required|numeric',
        ]);

        try {
            UktModel::create([
                'prodi_id' => $request->prodi_id,
                'jenis_masuk' => $request->jenis_masuk,
                'nominal_ukt' => $request->nominal_ukt,
            ]);

            showNotification('success', 'Data Tarif UKT berhasil ditambahkan');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            showNotification('error', 'Data Tarif UKT gagal ditambahkan');
            return response()->json(['success' => false]);
        }
    }

    public function show(string $id)
    {
        $ukt = UktModel::find($id);
        $prodi = ProdiModel::with('jurusan')->find($ukt->prodi_id);

        $breadcrumb = (object) [
            'title' => 'Settings',
            'list' => ['Settings', 'Tarif UKT', 'Detail'],
        ];
        $page = (object) [
            'title' => 'Detail Tarif UKT',
        ];
        $activeMenu = 'tarif';

        if ($ukt) {
            return view('Admin.tarif.show', compact('breadcrumb', 'page', 'activeMenu', 'ukt', 'prodi'));
        } else {
            showNotification('error', 'Data Tarif UKT tidak ditemukan');
            return redirect()->route('tarif.index');
        }
    }

    public function edit(string $id)
    {
        $ukt = UktModel::find($id);
        $prodi = ProdiModel::with('jurusan')->find($ukt->prodi_id);
        $jurusans = JurusanModel::all();
        $prodis = ProdiModel::all();

        return view('Admin.tarif.edit', compact('ukt', 'prodi', 'jurusans', 'prodis'));
    }

    public function update(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'prodi_id' => 'required|exists:prodi,prodi_id',
                'jenis_masuk' => 'required',
                'nominal_ukt' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }

            $check = UktModel::find($id);
            if ($check) {
                $check->update([
                    'prodi_id' => $request->prodi_id,
                    'jenis_masuk' => $request->jenis_masuk,
                    'nominal_ukt' => $request->nominal_ukt,
                ]);
                showNotification('success', 'Data Tarif UKT berhasil diupdate');
                return response()->json(['success' => true]);
            } else {
                showNotification('error', 'Data Tarif UKT gagal diupdate');
                return response()->json(['success' => false]);
            }
        }
    }

    public function confirm(string $id)
    {
        $ukt = UktModel::find($id);
        $prodi = ProdiModel::with('jurusan')->find($ukt->prodi_id);

        if ($ukt) {
            return view('Admin.tarif.confirm', compact('ukt', 'prodi'));
        } else {
            showNotification('error', 'Data Tarif UKT tidak ditemukan');
            return redirect()->route('tarif.index');
        }
    }

    public function delete(string $id)
    {
        $ukt = UktModel::find($id);

        if (!$ukt) {
            showNotification('error', 'Data Tarif UKT tidak ditemukan');
            return response()->json([
                'success' => false,
                'message' => 'Data Tarif UKT tidak ditemukan',
            ], 404);
        }

        try {
            $ukt->delete();
            showNotification('success', 'Data Tarif UKT berhasil dihapus');
            return response()->json([
                'success' => true,
                'message' => 'Data Tarif UKT berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            showNotification('error', 'Data Tarif UKT gagal dihapus');
            return response()->json([
                'success' => false,
                'message' => 'Data Tarif UKT gagal dihapus',
            ], 500);
        }
    }
}
