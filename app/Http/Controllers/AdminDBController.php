<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\JurusanModel;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravolt\Avatar\Avatar;

class AdminDBController extends Controller
{
    protected $avatar;
    public function __construct()
    {
        $this->avatar = new Avatar();
    }
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'list' => ['Dashboard', 'Admin']
        ];

        $page = (object) [
            'title' => 'Dashboard Admin'
        ];

        $activeMenu = 'dashboard';

        $user = Auth::user();

        if ($user) {
            $admin = AdminModel::where('user_id', $user->user_id)->first();
        }

        $avatar = $this->avatar->create($admin->admin_nama)->toBase64();

        $totalMahasiswa = MahasiswaModel::count();
        $totalJurusan = JurusanModel::count();
        $totalProdi = ProdiModel::count();
        $totalUsers = UserModel::count();

        $recentMahasiswa = MahasiswaModel::with('prodi')->orderBy('created_at', 'desc')->take(5)->get();

        $jurusanList = JurusanModel::with('prodi')->get();

        return view('Admin.dashboard', compact('breadcrumb', 'page', 'activeMenu', 'totalMahasiswa', 'totalJurusan', 'totalProdi', 'totalUsers', 'recentMahasiswa', 'jurusanList', 'user', 'admin', 'avatar'));
    }
}
