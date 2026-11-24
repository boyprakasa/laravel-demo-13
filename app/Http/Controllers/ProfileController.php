<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan form profil pengguna.
     *
     * @param  Request  $request  Request dari pengguna yang sedang login.
     * @return View View untuk halaman edit profil.
     *
     * Menyewakan view 'profile.edit' dengan data user yang sedang login.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     *
     * @param  ProfileUpdateRequest  $request  Request yang sudah divalidasi berisi data profil yang akan diupdate.
     * @return RedirectResponse Response redirect ke halaman edit profil dengan status sukses.
     *
     * Proses update:
     * 1. Isi data user dengan validated data dari request.
     * 2. Jika email diubah, reset token verifikasi email.
     * 3. Simpan perubahan ke database.
     * 4. Redirect kembali ke halaman edit profil dengan status 'profile-updated'.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Menghapus akun pengguna.
     *
     * @param  Request  $request  Request validasi penghapusan akun beserta password.
     * @return RedirectResponse Response redirect ke halaman utama setelah penghapusan.
     *
     * Proses penghapusan:
     * 1. Validasi password yang benar menggunakan validateWithBag.
     * 2. Logout pengguna menggunakan Auth::logout().
     * 3. Hapus akun pengguna.
     * 4. Invalidate session dan regenerate token.
     * 5. Redirect ke halaman utama ('/').
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
