<?php

namespace App\Http\Controllers;

use App\Models\ProdiModel;
use App\Models\JurusanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProdiController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Program Studi',
            'list' => ['Data Master', 'Program Studi'],
        ];

        $page = (object) [
            'title' => 'Daftar Program Studi',
        ];
        $activeMenu = 'prodi';

        $jurusan = JurusanModel::select('jurusan_id', 'jurusan_kode', 'jurusan_nama')->get();
        return view('prodi.index', compact('breadcrumb', 'page', 'activeMenu', 'jurusan'));
    }

    public function list(Request $request)
    {
        $prodi = ProdiModel::select('prodi_id', 'prodi_kode', 'prodi_nama', 'jurusan_id')->with('jurusan');

        return DataTables::of($prodi)
            ->addIndexColumn()
            ->addColumn('action', function ($prodi) {
                $btn = '<a href="' . route('prodi.show', $prodi->prodi_id) . '" class="btn btn-primary btn-sm btn-edit">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . route('prodi.edit', $prodi->prodi_id) . '\')" class="btn btn-warning btn-sm btn-edit">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/prodi/' . $prodi->prodi_id . '/delete') . '\')" class="btn btn-danger btn-sm btn-delete">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'prodi_kode' => 'required|string|max:5|min:2|unique:prodi,prodi_kode',
            'prodi_nama' => 'required|string|max:50|min:3',
            'jurusan_id' => 'required|exists:jurusan,jurusan_id',
        ]);

        try {
            ProdiModel::create([
                'prodi_kode' => $request->prodi_kode,
                'prodi_nama' => $request->prodi_nama,
                'jurusan_id' => $request->jurusan_id,
            ]);

            showNotification('success', 'Data prodi berhasil ditambahkan');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            showNotification('error', 'Gagal menambahkan data prodi');
            return response()->json(['success' => false], 500);
        }
    }

    public function show(string $id)
    {
        $prodi = ProdiModel::find($id);
        $jurusan = JurusanModel::select('jurusan_id', 'jurusan_kode', 'jurusan_nama')->get();
        $breadcrumb = (object) [
            'title' => 'Program Studi',
            'list' => ['Data Master', 'Program Studi'],
        ];

        $page = (object) [
            'title' => 'Detail Program Studi',
        ];
        $activeMenu = 'prodi';

        return view('prodi.show', compact('breadcrumb', 'page', 'activeMenu', 'prodi', 'jurusan'));
    }

    public function edit(string $id)
    {
        $prodi = ProdiModel::find($id);
        $jurusan = JurusanModel::select('jurusan_id', 'jurusan_kode', 'jurusan_nama')->get();

        return view('prodi.edit', compact('prodi', 'jurusan'));
    }

    public function update(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'prodi_kode' => 'required|string|max:5|min:2|unique:prodi,prodi_kode,' . $id . ',prodi_id',
                'prodi_nama' => 'required|string|max:50|min:3',
                'jurusan_id' => 'required|exists:jurusan,jurusan_id',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            $check = ProdiModel::find($id);
            if ($check) {
                $check->update([
                    'prodi_kode' => $request->prodi_kode,
                    'prodi_nama' => $request->prodi_nama,
                    'jurusan_id' => $request->jurusan_id,
                ]);
                showNotification('success', 'Data prodi berhasil diubah');
                return response()->json(['success' => true]);
            } else {
                showNotification('error', 'Data prodi tidak ditemukan');
                return response()->json(['success' => false], 404);
            }
        }
    }

    public function confirm(string $id)
    {
        $prodi = ProdiModel::find($id);
        if ($prodi) {
            return view('prodi.confirm', compact('prodi'));
        } else {
            showNotification('error', 'Data prodi tidak ditemukan');
            return redirect()->route('prodi.index');
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $prodi = ProdiModel::find($request->id);
            if ($prodi) {
                $prodi->delete();
                showNotification('success', 'Data prodi berhasil dihapus');
                return response()->json(['success' => true]);
            } else {
                showNotification('error', 'Data jurusan tidak ditemukan');
                return response()->json(['success' => false], 404);
            }
        }
        showNotification('error', 'Gagal menghapus data prodi');
        return redirect()->route('prodi.index');
    }
}
