<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\AdminModel;
use Laravolt\Avatar\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected $avatar;
    public function __construct()
    {
        $this->avatar = new Avatar();
    }
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Admin',
            'list' => ['Data Master', 'Admin'],
        ];
        $page = (object) [
            'title' => 'Daftar Admin',
        ];
        $activeMenu = 'admin';
        return view('admin.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list()
    {
        $admins = AdminModel::with('user')->select('admin_id', 'admin_nama', 'user_id')->get();

        return DataTables::of($admins)
            ->addIndexColumn()
            ->addColumn('foto_profile', function ($admin) {
                $adminImage = AdminModel::where('user_id', $admin->user_id)->first();
                $avatarImage = $adminImage ? $this->avatar->create($adminImage->admin_nama)->setTheme('colorful')->toBase64() : '';
                return '<img src="' . $avatarImage . '" width="50" class="avatar border border-3 border-primary">';
            })
            ->addColumn('action', function ($admin) {
                $btn = '<a href="' . route('admin.show', $admin->admin_id) . '" class="btn btn-primary btn-sm btn-edit">Detail</a> ';
                // $btn .= '<button onclick="modalAction(\'' . route('admin.edit', $admin->admin_id) . '\')" class="btn btn-warning btn-sm btn-edit">Edit</button> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/admin/' . $admin->admin_id . '/delete') . '\')" class="btn btn-danger btn-sm btn-delete">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['foto_profile', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Validasi user
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',

            // Validasi admin
            'admin_nama' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $user = UserModel::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 1,
            ]);
            AdminModel::create([
                'user_id' => $user->user_id,
                'admin_nama' => $request->admin_nama,
            ]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data admin berhasil ditambahkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Data admin gagal ditambahkan']);
        }
    }

    public function show(string $id)
    {
        $admin = AdminModel::find($id);
        $user = UserModel::find($admin->user_id);

        $avatar = $this->avatar->create($admin->admin_nama)->toBase64();

        $breadcrumb = (object) [
            'title' => 'Admin',
            'list' => ['Data Master', 'Admin', 'Detail Admin'],
        ];
        $page = (object) [
            'title' => 'Detail Admin',
        ];
        $activeMenu = 'admin';
        return view('admin.show', compact('breadcrumb', 'page', 'activeMenu', 'admin', 'user', 'avatar'));
    }
}
