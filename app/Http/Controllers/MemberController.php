<?php

namespace App\Http\Controllers;

use App\DataTables\MembersDataTable;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Menampilkan daftar anggota.
     *
     * @param  MembersDataTable  $dataTable  Instance DataTable untuk menangani query dan rendering.
     * @return View View untuk menampilkan halaman daftar anggota.
     *
     * Menggunakan DataTable class untuk otomatis menangani:
     * - Paginasi, sorting, dan filtering
     * - Render view 'member.index'
     */
    public function index(MembersDataTable $dataTable)
    {
        return $dataTable->render('member.index');
    }

    /**
     * Menampilkan form membuat anggota baru.
     *
     * @return View View untuk form penambah anggota.
     *
     * Render view 'member.create' untuk form input data anggota.
     */
    public function create()
    {
        return view('member.create');
    }

    /**
     * Menyimpan anggota baru ke storage.
     *
     * @param  Request  $request  Request dari form anggota yang sudah divalidasi.
     * @return RedirectResponse Response redirect dengan pesan sukses.
     *
     * Proses penyimpanan:
     * 1. Validasi input: name, email (harus unique), phone_number dan address opsional.
     * 2. Buat record anggota baru menggunakan Member::create()
     * 3. Redirect ke halaman index dengan pesan sukses
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'string',
            'max:255',
            'email' => 'required',
            'email',
            'unique:members,email',
            'phone_number' => 'nullable',
            'string',
            'max:20',
            'address' => 'nullable',
            'string',
        ]);

        Member::create($validated);

        return redirect()->route('member.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail anggota tertentu.
     *
     * @param  Member  $member  Model anggota yang akan ditampilkan detailnya.
     * @return View View untuk halaman detail anggota.
     *
     * Menyewakan view 'member.show' dengan data anggota.
     */
    public function show(Member $member)
    {
        return view('member.show', compact('member'));
    }

    /**
     * Menampilkan form edit anggota.
     *
     * @param  Member  $member  Model anggota yang akan diedit.
     * @return View View form edit anggota.
     *
     * Render view 'member.edit' dengan data anggota yang dipilih.
     */
    public function edit(Member $member)
    {
        return view('member.edit', compact('member'));
    }

    /**
     * Memperbarui data anggota di storage.
     *
     * @param  Request  $request  Request dari form edit anggota yang sudah divalidasi.
     * @param  Member  $member  Model anggota yang akan diperbarui.
     * @return RedirectResponse Response redirect dengan pesan sukses.
     *
     * Proses pengupdatean:
     * 1. Validasi input termasuk check unique tanpa menyiarkan ID sendiri.
     * 2. Perbarui data anggota menggunakan $member->update()
     * 3. Redirect ke halaman index dengan pesan sukses
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required',
            'string',
            'max:255',
            'email' => 'required',
            'email',
            'unique:members,email,'.$member->id,
            'phone_number' => 'nullable',
            'string',
            'max:20',
            'address' => 'nullable',
            'string',
        ]);

        $member->update($validated);

        return redirect()->route('member.index')
            ->with('success', 'Anggota berhasil diperbarui.');
    }

    /**
     * Menghapus data anggota dari storage.
     *
     * @param  Member  $member  Model anggota yang akan dihapus.
     * @return RedirectResponse Response redirect dengan pesan sukses.
     *
     * Menghapus anggota dan Redirect ke halaman index dengan pesan sukses.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('member.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
