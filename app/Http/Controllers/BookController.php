<?php

namespace App\Http\Controllers;

use App\DataTables\BooksDataTable;
use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;

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
        $categories = Category::all();
        $authors = Author::orderBy('name')->get();
        return view('book.create', compact('categories', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $validated = $request->validated();

        // Ambil author_ids sebelum membuat buku
        $authorIds = $validated['author_ids'] ?? [];
        unset($validated['author_ids']);

        $book = Book::create($validated);

        // Sinkronkan penulis
        $book->authors()->sync($authorIds);

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
        $categories = Category::all();
        $authors = Author::orderBy('name')->get();
        return view('book.edit', compact('book', 'categories', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $validated = $request->validated();

        // Ambil author_ids sebelum memperbarui buku
        $authorIds = $validated['author_ids'] ?? [];
        unset($validated['author_ids']);

        $book->update($validated);

        // Sinkronkan penulis
        $book->authors()->sync($authorIds);

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
