<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\JurusanModel;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            switch ($user->role->role_code) {
                case 'ADM':
                    if ($user) {
                        $admin = AdminModel::where('user_id', $user->user_id)->first();
                    }
                    session()->flash('notification', [
                        'message' => 'Login Berhasil, Selamat datang ' . $admin->admin_nama,
                        'type' => 'success'
                    ]);
                    return redirect()->route('admin.dashboard');

                default:
                    if ($user) {
                        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();
                    }
                    session()->flash('notification', [
                        'message' => 'Login Berhasil Selamat datang ' . $mahasiswa->mahasiswa_nama,
                        'type' => 'success'
                    ]);
                    return redirect()->route('mahasiswa.dashboard');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function registerForm()
    {
        $jurusans = JurusanModel::all();
        $prodis = ProdiModel::all();
        return view('auth.register', compact('jurusans', 'prodis'));
    }

    public function register(Request $request)
    {
        $request->validate([
            // Validasi User
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

        $role = RoleModel::where('role_code', 'MHS')->firstOrFail();

        $user = UserModel::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->role_id,
        ]);

        MahasiswaModel::create([
            'nim' => $request->nim,
            'mahasiswa_nama' => $request->mahasiswa_nama,
            'angkatan' => $request->angkatan,
            'mahasiswa_alamat' => $request->mahasiswa_alamat,
            'no_telepon' => $request->no_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'prodi_id' => $request->prodi_id,
            'user_id' => $user->user_id,
        ]);

        Auth::login($user);

        showNotification('Registrasi Berhasil', 'success');
        return redirect()->route('mahasiswa.dashboard')->with('success', 'Registrasi Berhasil');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        showNotification('Logout Berhasil', 'success');
        return redirect()->route('login');
    }
}
