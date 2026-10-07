<?php

namespace App\Http\Controllers;

use App\DataTables\LoansDataTable;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Book;

class LoanController extends Controller
{
    public function index(LoansDataTable $dataTable)
    {
        return $dataTable->render('loan.index');
    }

    public function create()
    {
        $members = Member::all();
        $books = Book::all();
        return view('loan.create', compact('members', 'books'));
    }

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

    public function show(Loan $loan)
    {
        return view('loan.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        $members = Member::all();
        $books = Book::all();
        return view('loan.edit', compact('loan', 'members', 'books'));
    }

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

    public function destroy(Loan $loan)
    {
        $loan->delete();

        return redirect()->route('loan.index')
            ->with('success', 'Peminjaman berhasil dihapus.');
    }
}
