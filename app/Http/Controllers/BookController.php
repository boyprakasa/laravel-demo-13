<?php

namespace App\Http\Controllers;

use App\DataTables\BooksDataTable;
use App\Http\Requests\BookRequest;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BooksDataTable $dataTable)
    {
        return $dataTable->render('book.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        Book::create($request->validated());

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'redirect' => route('book.index'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('book.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('book.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return response()->json([
            'message'  => 'Buku berhasil diperbarui.',
            'redirect' => route('book.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Buku berhasil dihapus.']);
    }
}
