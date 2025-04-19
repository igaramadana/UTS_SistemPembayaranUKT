<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Role',
            'list' => ['Data Master', 'Role'],
        ];

        $page = (object) [
            'title' => 'Daftar Role',
        ];

        $activeMenu = 'role';

        return view('Admin.role.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $roles = RoleModel::select('role_id', 'role_code', 'role_nama');

        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('action', function ($role) {
                $btn = '<a href="' . route('role.show', $role->role_id) . '" class="btn btn-primary btn-sm btn-edit">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . route('role.edit', $role->role_id) . '\')" class="btn btn-warning btn-sm btn-edit">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . route('role.confirm', $role->role_id) . '\')" class="btn btn-danger btn-sm btn-delete">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_code' => 'required|string|max:5|min:2|unique:role,role_code',
            'role_nama' => 'required|string|max:50|min:3',
        ]);

        try {
            RoleModel::create([
                'role_code' => $request->role_code,
                'role_nama' => $request->role_nama,
            ]);

            showNotification('success', 'Data role berhasil ditambahkan');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            showNotification('error', 'Gagal menambahkan data role');
            return response()->json(['success' => false], 500);
        }
    }

    public function show(string $id)
    {
        $role = RoleModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Role',
            'list' => ['Data Master', 'Role', 'Detail', $role->role_nama],
        ];

        $page = (object) [
            'title' => 'Detail Role ' . $role->role_nama,
        ];

        $activeMenu = 'role';

        if ($role) {
            return view('Admin.role.show', compact('breadcrumb', 'page', 'activeMenu', 'role'));
        } else {
            showNotification('error', 'Data role tidak ditemukan');
            return redirect()->route('role.index');
        }
    }

    public function edit(string $id)
    {
        $role = RoleModel::find($id);

        return view('Admin.role.edit', compact('role'));
    }

    public function update(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'role_code' => 'required|string|max:5|min:2|unique:role,role_code,' . $id . ',role_id',
                'role_nama' => 'required|string|max:50|min:3',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            $check = RoleModel::find($id);

            if ($check) {
                $check->update([
                    'role_code' => $request->role_code,
                    'role_nama' => $request->role_nama,
                ]);

                showNotification('success', 'Data role berhasil diubah');
                return response()->json(['success' => true]);
            } else {
                showNotification('error', 'Data role tidak ditemukan');
                return response()->json(['success' => false], 404);
            }
        }
    }

    public function confirm(string $id)
    {
        $role = RoleModel::find($id);

        if ($role) {
            return view('Admin.role.confirm', compact('role'));
        } else {
            showNotification('error', 'Data role tidak ditemukan');
            return redirect()->route('role.index');
        }
    }

    public function delete(Request $request, string $id)
    {
        $role = RoleModel::find($id);

        if (!$role) {
            showNotification('error', 'Data role tidak ditemukan');
            return response()->json([
                'success' => false,
                'message' => 'Data role tidak ditemukan'
            ], 404);
        }

        try {
            $role->delete();
            showNotification('success', 'Data role berhasil dihapus');
            return response()->json([
                'success' => true,
                'message' => 'Data role berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            showNotification('error', 'Gagal menghapus data role');
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data role'
            ], 500);
        }
    }
}
