<?php

namespace App\Http\Controllers;

use Log;
use App\Models\UserModel;
use App\Models\ProdiModel;
use Laravolt\Avatar\Avatar;
use Illuminate\Http\Request;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    protected $avatar;
    public function __construct()
    {
        $this->avatar = new Avatar();
    }
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Mahasiswa',
            'list' => ['Data Master', 'Mahasiswa'],
        ];

        $page = (object) [
            'title' => 'Daftar Mahasiswa',
        ];

        $activeMenu = 'mahasiswa';

        $user = UserModel::select('user_id', 'role_id', 'email')->with('role')->get();
        $prodi = ProdiModel::select('prodi_id', 'prodi_nama')->get();
        return view('mahasiswa.index', compact('breadcrumb', 'page', 'activeMenu', 'user', 'prodi'));
    }

    public function list()
    {
        $mahasiswa = MahasiswaModel::select('mahasiswa_id', 'user_id', 'nim', 'mahasiswa_nama', 'angkatan', 'mahasiswa_alamat', 'no_telepon', 'jenis_kelamin', 'prodi_id')
            ->with([
                'user' => function ($query) {
                    $query->select('user_id', 'email');
                },
                'prodi' => function ($query) {
                    $query->select('prodi_id', 'prodi_nama');
                },
            ])
            ->get();

        return DataTables::of($mahasiswa)
            ->addIndexColumn()
            ->addColumn('foto_profile', function ($mahasiswa) {
                return '<img src="' . $this->avatar->create($mahasiswa->mahasiswa_nama)->tobase64() . '" width="50" class="avatar border border-3 border-primary">';
            })
            ->addColumn('action', function ($mahasiswa) {
                $btn = '<a href="' . route('mahasiswa.show', $mahasiswa->mahasiswa_id) . '" class="btn btn-primary btn-sm btn-edit">Detail</a> ';
                // $btn .= '<button onclick="modalAction(\'' . route('mahasiswa.edit', $mahasiswa->mahasiswa_id) . '\')" class="btn btn-warning btn-sm btn-edit">Edit</button> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->mahasiswa_id . '/delete') . '\')" class="btn btn-danger btn-sm btn-delete">Hapus</button>';
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

            // Validasi mahasiswa
            'nim' => 'required|string|max:255|unique:mahasiswa,nim',
            'mahasiswa_nama' => 'required|string|max:255',
            'angkatan' => 'required|integer|digits:4',
            'mahasiswa_alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'prodi_id' => 'required|exists:prodi,prodi_id',
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
                'role_id' => 2
            ]);

            MahasiswaModel::create([
                'nim' => $request->nim,
                'mahasiswa_nama' => $request->mahasiswa_nama,
                'angkatan' => $request->angkatan,
                'mahasiswa_alamat' => $request->mahasiswa_alamat,
                'no_telepon' => $request->no_telepon,
                'jenis_kelamin' => $request->jenis_kelamin,
                'prodi_id' => $request->prodi_id,
                'user_id' => $user->user_id
            ]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data mahasiswa berhasil ditambahkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal menambahkan data mahasiswa'], 500);
        }
    }

    public function show(string $id)
    {
        $mahasiswa = MahasiswaModel::find($id);
        $prodi = ProdiModel::select('prodi_id', 'prodi_nama')->get();
        $user = UserModel::find($mahasiswa->user_id);

        $avatar = $this->avatar->create($mahasiswa->mahasiswa_nama)->toBase64();

        $breadcrumb = (object) [
            'title' => 'Mahasiswa',
            'list' => ['Data Master', 'Mahasiswa', 'Detail'],
        ];
        $page = (object) [
            'title' => 'Detail Mahasiswa',
        ];
        $activeMenu = 'mahasiswa';

        return view('mahasiswa.show', compact('breadcrumb', 'page', 'activeMenu', 'mahasiswa', 'prodi', 'user', 'avatar'));
    }
}
