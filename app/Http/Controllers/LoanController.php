<?php

namespace App\Http\Controllers;

use App\DataTables\LoansDataTable;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman buku.
     *
     * @param  LoansDataTable  $dataTable  Instance DataTable untuk menangani query dan rendering.
     * @return View View untuk menampilkan halaman daftar peminjaman.
     *
     * Menggunakan DataTable class untuk otomatis menangani:
     * - Paginasi, sorting, dan filtering
     * - Render view 'loan.index'
     */
    public function index(LoansDataTable $dataTable)
    {
        return $dataTable->render('loan.index');
    }

    /**
     * Menampilkan form membuat peminjaman baru.
     *
     * @return View View untuk form pembuatan peminjaman.
     *
     * Mengambil semua member dan book untuk ditampilkan di form peminjaman.
     */
    public function create()
    {
        $members = Member::all();
        $books = Book::all();

        return view('loan.create', compact('members', 'books'));
    }

    /**
     * Menyimpan peminjaman baru ke storage.
     *
     * @param  Request  $request  Request dari form peminjaman yang sudah divalidasi.
     * @return RedirectResponse Response redirect dengan pesan sukses.
     *
     * Proses penyimpanan:
     * 1. Validasi input: member_id, book_id, loan_date, expected_return_date
     * 2. Buat record peminjaman baru menggunakan Loan::create()
     * 3. Redirect ke halaman index dengan pesan sukses
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'expected_return_date' => 'required|date|after_or_equal:loan_date',
        ]);

        Loan::create($validated);

        return redirect()->route('loan.index')
            ->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail peminjaman tertentu.
     *
     * @param  Loan  $loan  Model peminjaman yang akan ditampilkan detailnya.
     * @return View View untuk halaman detail peminjaman.
     *
     * Menyewakan view 'loan.show' dengan data peminjaman beserta relationship-nya.
     */
    public function show(Loan $loan)
    {
        return view('loan.show', compact('loan'));
    }

    /**
     * Menampilkan form edit peminjaman.
     *
     * @param  Loan  $loan  Model peminjaman yang akan diedit.
     * @return View View form edit peminjaman.
     *
     * Mengambil semua member dan book untuk form pengeditan.
     */
    public function edit(Loan $loan)
    {
        $members = Member::all();
        $books = Book::all();

        return view('loan.edit', compact('loan', 'members', 'books'));
    }

    /**
     * Memperbarui data peminjaman di storage.
     *
     * @param  Request  $request  Request dari form edit peminjaman yang sudah divalidasi.
     * @param  Loan  $loan  Model peminjaman yang akan diperbarui.
     * @return RedirectResponse Response redirect dengan pesan sukses.
     *
     * Proses pengupdatean:
     * 1. Validasi input termasuk actual_return_date dan status
     * 2. Perbarui data peminjaman menggunakan $loan->update()
     * 3. Redirect ke halaman index dengan pesan sukses
     */
    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'expected_return_date' => 'required|date|after_or_equal:loan_date',
            'actual_return_date' => 'nullable|date|after_or_equal:loan_date',
            'status' => 'required|in:on_loan,returned,overdue',
        ]);

        $loan->update($validated);

        return redirect()->route('loan.index')
            ->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Menghapus data peminjaman dari storage.
     *
     * @param  Loan  $loan  Model peminjaman yang akan dihapus.
     * @return RedirectResponse Response redirect dengan pesan sukses.
     *
     * Menghapus peminjaman dan Redirect ke halaman index dengan pesan sukses.
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();

        return redirect()->route('loan.index')
            ->with('success', 'Peminjaman berhasil dihapus.');
    }
}
