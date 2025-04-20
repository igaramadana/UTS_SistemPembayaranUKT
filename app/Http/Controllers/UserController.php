<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\AdminModel;
use Laravolt\Avatar\Avatar;
use Illuminate\Http\Request;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\DB;
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
        return view('Admin.user.index', compact('breadcrumb', 'page', 'activeMenu', 'role'));
    }

    public function list()
    {
        $users = UserModel::select('user_id', 'role_id', 'email', 'foto_profile')->with('role')->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('foto_profile', function ($user) {
                if ($user->foto_profile) {
                    return '<img src="' . asset('storage/foto_profile/' . $user->foto_profile) . '" width="50" height="50" class="avatar border border-3 border-primary rounded-circle">';
                }
                if ($user->role_id == 1) {
                    $admin = AdminModel::where('user_id', $user->user_id)->first();
                    $nama = $admin ? $admin->admin_nama : $user->username;
                } else if ($user->role_id == 2) {
                    $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();
                    $nama = $mahasiswa ? $mahasiswa->mahasiswa_nama : $user->username;
                } else {
                    $nama = $user->email;
                }

                $avatarImage = $this->avatar->create($nama)->setTheme('colorful')->toBase64();
                return '<img src="' . $avatarImage . '" width="50" class="avatar border border-3 border-primary rounded-circle">';
            })
            ->addColumn('action', function ($user) {
                $btn = '<a href="' . route('user.show', $user->user_id) . '" class="btn btn-primary btn-sm btn-edit">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . route('user.confirm', $user->user_id) . '\')" class="btn btn-danger btn-sm btn-delete">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['foto_profile', 'action'])
            ->make(true);
    }

    public function show(string $id)
    {
        $user = UserModel::find($id);
        $role = RoleModel::select('role_id', 'role_code', 'role_nama')->get();

        if ($user->role_id == 1) { // Asumsi role_id 1 adalah admin
            $admin = AdminModel::where('user_id', $id)->first();

            if (!$admin) {
                return redirect()->route('user.index')->with('error', 'Data admin tidak ditemukan.');
            }

            $detailData = $admin;
            $avatar = $this->avatar->create($admin->admin_nama)->toBase64();
        } elseif ($user->role_id == 2) {
            $mahasiswa = MahasiswaModel::where('user_id', $id)->with('prodi')->first();

            if (!$mahasiswa) {
                return redirect()->route('user.index')->with('error', 'Data mahasiswa tidak ditemukan.');
            }

            $detailData = $mahasiswa;
            if ($user->foto_profile) {
                $avatar = asset('storage/foto_profile/' . $user->foto_profile);
            } else {
                $avatar = $this->avatar->create($mahasiswa->mahasiswa_nama)->toBase64();
            }
        } else {
            $avatar = $this->avatar->create($user->email)->toBase64();
        }

        $breadcrumb = (object) [
            'title' => 'User',
            'list' => ['Data Master', 'User', 'Detail'],
        ];
        $page = (object) [
            'title' => 'Detail User',
        ];
        $activeMenu = 'user';

        return view('Admin.user.show', compact('breadcrumb', 'page', 'activeMenu', 'user', 'detailData', 'role', 'avatar'));
    }

    public function confirm(string $id)
    {
        $users = UserModel::find($id);
        $avatar = $this->avatar->create($users->email)->toBase64();
        if ($users) {
            return view('Admin.user.confirm', compact('users', 'avatar'));
        } else {
            showNotification('error', 'Data user tidak ditemukan');
            return redirect()->route('user.index');
        }
    }

    public function delete(Request $request, string $id)
    {
        $currentUser = auth()->user();
        if ($currentUser->user_id == $id) {
            showNotification('error', 'Anda tidak dapat menghapus akun sendiri');
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun sendiri'
            ], 403);
        }

        $user = UserModel::find($id);

        if (!$user) {
            showNotification('error', 'Data user tidak ditemukan');
            return response()->json(['success' => false, 'message' => 'Data user tidak ditemukan'], 404);
        }

        try {
            DB::beginTransaction();
            $user = UserModel::find($request->id);

            if (!$user) {
                showNotification('error', 'Data user tidak ditemukan');
                return response()->json(['success' => false], 404);
            }

            if ($user->role_id == 1) {
                AdminModel::where('user_id', $user->user_id)->delete();
            } elseif ($user->role_id == 2) {
                MahasiswaModel::where('user_id', $user->user_id)->delete();
            }
            $user->delete();
            DB::commit();
            showNotification('success', 'Berhasil menghapus data user');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            showNotification('error', 'Gagal menghapus data user: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
