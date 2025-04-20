<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Avatar;

class MhsDBController extends Controller
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
            'list' => ['Dashboard', 'Mahasiswa', 'Dashboard'],
        ];

        $page = (object) [
            'title' => 'Dashboard Mahasiswa'
        ];

        $user = Auth::user();
        if ($user) {
            $mahasiswa = MahasiswaModel::with('prodi')->where('user_id', $user->user_id)->first();
        }

        if ($user->foto_profile) {
            $avatar = asset('storage/foto_profile/' . $user->foto_profile);
        } else {
            $avatar = $this->avatar->create($mahasiswa->mahasiswa_nama)->toBase64();
        }

        $activeMenu = 'dashboard';
        return view('mahasiswa.dashboard', compact('page', 'breadcrumb', 'activeMenu', 'mahasiswa', 'user', 'avatar'));
    }

    public function profile()
    {
        $breadcrumb = (object) [
            'title' => 'Edit Profile',
            'list' => ['Mahasiswa', 'Edit Profile'],
        ];

        $page = (object) [
            'title' => 'Edit Profile Mahasiswa'
        ];

        $user = Auth::user();
        $mahasiswa = MahasiswaModel::with('prodi')->where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Data mahasiswa tidak ditemukan');
        }

        if ($user->foto_profile) {
            $avatar = asset('storage/foto_profile/' . $user->foto_profile);
        } else {
            $avatar = $this->avatar->create($mahasiswa->mahasiswa_nama)->toBase64();
        }

        $activeMenu = 'profile';
        return view('Mahasiswa.edit-profile', compact('page', 'breadcrumb', 'activeMenu', 'mahasiswa', 'user', 'avatar'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();
        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Data mahasiswa tidak ditemukan');
        }

        $request->validate([
            'mahasiswa_nama' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:20',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Update data mahasiswa
            $mahasiswa->update([
                'mahasiswa_nama' => $request->mahasiswa_nama,
                'no_telepon' => $request->no_telepon
            ]);

            // Prepare user data for update
            $userData = [];
            
            // Handle profile photo upload
            if ($request->hasFile('foto_profile')) {
                if ($user->foto_profile) {
                    Storage::disk('public')->delete('foto_profile/' . $user->foto_profile);
                }

                $photoName = time() . '_' . $user->user_id . '.' . $request->foto_profile->extension();
                $request->foto_profile->storeAs('foto_profile', $photoName, 'public');
                $userData['foto_profile'] = $photoName;
            }

            // Update email if changed
            if ($request->email && $request->email !== $user->email) {
                $request->validate([
                    'email' => 'required|string|email|max:50|unique:users,email,' . $user->user_id . ',user_id',
                ]);
                $userData['email'] = $request->email;
            }

            // Update user data if we have changes
            if (!empty($userData)) {
                UserModel::where('user_id', $user->user_id)->update($userData);
            }

            showNotification('success', 'Profile berhasil diperbarui');
            return redirect()->route('mahasiswa.profile')
                ->with('success', 'Profile berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profile: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function deleteProfile()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            if ($user->foto_profile) {
                // Delete the photo from storage
                Storage::disk('public')->delete('foto_profile/' . $user->foto_profile);

                // Update the user record directly using the query builder
                UserModel::where('user_id', $user->user_id)
                    ->update(['foto_profile' => null]);

                showNotification('success', 'Foto profil berhasil dihapus');
                return redirect()->route('mahasiswa.profile')
                    ->with('success', 'Foto profil berhasil dihapus');
            } else {
                return redirect()->route('mahasiswa.profile')
                    ->with('info', 'Tidak ada foto profil untuk dihapus');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus foto profil: ' . $e->getMessage());
        }
    }
}
