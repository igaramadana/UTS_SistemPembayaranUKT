<?php

namespace App\Http\Controllers;

use App\Models\JurusanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Jurusan',
            'list' => ['Data Master', 'Jurusan'],
        ];

        $page = (object) [
            'title' => 'Daftar Jurusan',
        ];

        $activeMenu = 'jurusan';

        return view('Admin.jurusan.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $jurusan = JurusanModel::select('jurusan_id', 'jurusan_kode', 'jurusan_nama');

        return DataTables::of($jurusan)
            ->addIndexColumn()
            ->addColumn('action', function ($jurusan) {
                $btn = '<a href="' . route('jurusan.show', $jurusan->jurusan_id) . '" class="btn btn-primary btn-sm btn-edit">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . route('jurusan.edit', $jurusan->jurusan_id) . '\')" class="btn btn-warning btn-sm btn-edit">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . route('jurusan.confirm', $jurusan->jurusan_id) . '\')" class="btn btn-danger btn-sm btn-delete">Hapus</button>';
                return $btn;
            })->rawColumns(['action'])->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jurusan_kode' => 'required|string|max:5|min:2|unique:jurusan,jurusan_kode',
            'jurusan_nama' => 'required|string|max:50|min:3',
        ]);

        try {
            JurusanModel::create([
                'jurusan_kode' => $request->jurusan_kode,
                'jurusan_nama' => $request->jurusan_nama,
            ]);

            showNotification('success', 'Data jurusan berhasil ditambahkan');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            showNotification('error', 'Gagal menambahkan data jurusan');
            return response()->json(['success' => false], 500);
        }
    }

    public function show(string $id)
    {
        $jurusan = JurusanModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Role',
            'list' => ['Data Master', 'Jurusan', 'Detail', $jurusan->jurusan_nama],
        ];

        $page = (object) [
            'title' => 'Detail Jurusan ' . $jurusan->jurusan_nama,
        ];

        $activeMenu = 'jurusan';
        if ($jurusan) {
            return view('Admin.jurusan.show', compact('jurusan', 'breadcrumb', 'page', 'activeMenu'));
        } else {
            showNotification('error', 'Data jurusan tidak ditemukan');
            return redirect()->route('jurusan.index');
        }
    }

    public function edit(string $id)
    {
        $jurusan = JurusanModel::find($id);

        return view('Admin.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'jurusan_kode' => 'required|string|max:5|min:2|unique:jurusan,jurusan_kode,' . $id . ',jurusan_id',
                'jurusan_nama' => 'required|string|max:50|min:3',
            ];

            $validator  = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            $check = JurusanModel::find($id);

            if ($check) {
                $check->update([
                    'jurusan_kode' => $request->jurusan_kode,
                    'jurusan_nama' => $request->jurusan_nama,
                ]);
                showNotification('success', 'Data jurusan berhasil diubah');
                return response()->json(['success' => true]);
            } else {
                showNotification('error', 'Data jurusan tidak ditemukan');
                return response()->json(['success' => false], 404);
            }
        }
    }

    public function confirm(string $id)
    {
        $jurusan = JurusanModel::find($id);
        if ($jurusan) {
            return view('Admin.jurusan.confirm', compact('jurusan'));
        } else {
            showNotification('error', 'Data jurusan tidak ditemukan');
            return redirect()->route('jurusan.index');
        }
    }

    public function delete(Request $request, string $id)
    {
        $jurusan = JurusanModel::find($id);

        if (!$jurusan) {
            showNotification('error', 'Data jurusan tidak ditemukan');
            return response()->json([
                'success' => false,
                'message' => 'Data jurusan tidak ditemukan'
            ], 404);
        }

        try {
            $jurusan->delete();
            showNotification('success', 'Data jurusan berhasil dihapus');
            return response()->json([
                'success' => true,
                'message' => 'Data jurusan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            showNotification('error', 'Gagal menghapus data jurusan');
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data jurusan',
            ], 500);
        }
    }
}
