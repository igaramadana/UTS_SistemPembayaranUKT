<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use Laravolt\Avatar\Avatar;
use Illuminate\Http\Request;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $avatar;

    public function __construct()
    {
        $this->avatar = new Avatar();
    }
    public function index()
    {
        $mahasiswa = MahasiswaModel::where('user_id')->with('prodi')->first();
        $breadcrumb = (object) [
            'title' => 'User',
            'list' => ['Data Master', 'User'],
        ];

        $page = (object) [
            'title' => 'Daftar User',
        ];

        $activeMenu = 'user';

        $role = RoleModel::select('role_id', 'role_code', 'role_nama')->get();
        return view('user.index', compact('breadcrumb', 'page', 'activeMenu', 'role'));
    }

    public function list()
    {
        $users = UserModel::select('user_id', 'role_id', 'email')->with('role')->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('foto_profile', function ($user) {
                $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();
                $avatarImage = $mahasiswa ? $this->avatar->create($mahasiswa->mahasiswa_nama)->toBase64() : '';
                return '<img src="' . $avatarImage . '" width="50" class="avatar border border-3 border-primary">';
            })
            ->addColumn('action', function ($user) {
                $btn = '<a href="' . route('user.show', $user->user_id) . '" class="btn btn-primary btn-sm btn-edit">Detail</a> ';
                // $btn .= '<button onclick="modalAction(\'' . route('user.edit', $user->user_id) . '\')" class="btn btn-warning btn-sm btn-edit">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete') . '\')" class="btn btn-danger btn-sm btn-delete">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['foto_profile', 'action'])
            ->make(true);
    }

    public function show(string $id)
    {
        $users = UserModel::find($id);
        $role = RoleModel::select('role_id', 'role_code', 'role_nama')->get();

        $mahasiswa = MahasiswaModel::where('user_id', $id)->with('prodi')->first();

        if (!$mahasiswa) {
            return redirect()->route('user.index')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $avatar = $this->avatar->create($mahasiswa->mahasiswa_nama)->toBase64();

        $breadcrumb = (object) [
            'title' => 'User',
            'list' => ['Data Master', 'User', 'Detail'],
        ];
        $page = (object) [
            'title' => 'Detail User',
        ];
        $activeMenu = 'user';

        return view('user.show', compact('breadcrumb', 'page', 'activeMenu', 'users', 'role', 'avatar', 'mahasiswa'));
    }

    public function confirm(string $id)
    {
        $users = UserModel::find($id);
        $avatar = $this->avatar->create($users->email)->toBase64();
        if ($users) {
            return view('user.confirm', compact('users', 'avatar'));
        } else {
            showNotification('error', 'Data user tidak ditemukan');
            return redirect()->route('user.index');
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $users = UserModel::find($request->id);
            if ($users) {
                $users->delete();
                showNotification('success', 'Data user berhasil dihapus');
                return response()->json(['success' => true]);
            } else {
                showNotification('error', 'Data user tidak ditemukan');
                return response()->json(['success' => false], 404);
            }
        }
        showNotification('error', 'Gagal menghapus data user');
        return redirect()->route('user.index');
    }
}
