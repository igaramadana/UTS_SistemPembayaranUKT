<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use Laravolt\Avatar\Avatar;
use Illuminate\Http\Request;
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
                return '<img src="' . $this->avatar->create($user->email)->tobase64() . '" width="50" class="avatar border border-3 border-primary">';
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

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'role_id' => 'required|exists:role,role_id',
        ]);

        try {
            UserModel::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);

            showNotification('success', 'Data user berhasil ditambahkan');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            showNotification('error', 'Gagal menambahkan data user');
            return response()->json(['success' => false], 500);
        }
    }

    public function show(string $id)
    {
        $users = UserModel::find($id);
        $role = RoleModel::select('role_id', 'role_code', 'role_nama')->get();

        $avatar = new Avatar();
        $avatar->create($users->email)->toBase64();

        $breadcrumb = (object) [
            'title' => 'User',
            'list' => ['Data Master', 'User', 'Detail'],
        ];
        $page = (object) [
            'title' => 'Detail User',
        ];
        $activeMenu = 'user';

        return view('user.show', compact('breadcrumb', 'page', 'activeMenu', 'users', 'role', 'avatar'));
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
