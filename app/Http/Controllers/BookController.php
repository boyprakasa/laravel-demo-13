<?php

namespace App\Http\Controllers;

use App\DataTables\BooksDataTable;
use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Menampilkan daftar buku.
     *
     * @param  BooksDataTable  $dataTable  Instance DataTable untuk menangani query dan rendering.
     * @return View View untuk menampilkan halaman daftar buku.
     *
     * Menggunakan DataTable class untuk otomatis menangani:
     * - Paginasi, sorting, dan filtering
     * - Render view 'book.index'
     */
    public function index(BooksDataTable $dataTable)
    {
        return $dataTable->render('book.index');
    }

    /**
     * Menampilkan form membuat buku baru.
     *
     * @return View View untuk form penambah buku.
     *
     * Mengambil semua kategori dan authors terurut berdasarkan name
     * untuk ditampilkan di form pembuatan buku.
     */
    public function create()
    {
        $categories = Category::all();
        $authors = Author::orderBy('name')->get();

        return view('book.create', compact('categories', 'authors'));
    }

    /**
     * Menyimpan buku baru ke storage.
     *
     * @param  BookRequest  $request  Request yang sudah divalidasi berisi data buku dan author_ids.
     * @return JsonResponse Response JSON dengan pesan sukses dan redirect URL.
     *
     * Proses penyimpanan:
     * 1. Ambil author_ids dari validated data
     * 2. Hapus author_ids dari validated sebelum membuat buku
     * 3. Buat buku baru menggunakan Book::create()
     * 4. Sinkronkan relationship authors dengan sync()
     * 5. Kembalikan response JSON dengan pesan sukses
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
     * Menampilkan detail buku tertentu.
     *
     * @param  Book  $book  Model buku yang akan ditampilkan detailnya.
     * @return View View untuk halaman detail buku.
     *
     * Menyewakan view 'book.show' dengan data buku beserta relationship-nya.
     */
    public function show(Book $book)
    {
        return view('book.show', compact('book'));
    }

    /**
     * Menampilkan form edit buku.
     *
     * @param  Book  $book  Model buku yang akan diedit.
     * @return View View form edit buku.
     *
     * Mengambil semua kategori dan authors terurut berdasarkan name
     * untuk ditampilkan di form pengeditan buku.
     */
    public function edit(Book $book)
    {
        $categories = Category::all();
        $authors = Author::orderBy('name')->get();

        return view('book.edit', compact('book', 'categories', 'authors'));
    }

    /**
     * Memperbarui buku di storage.
     *
     * @param  BookRequest  $request  Request yang sudah divalidasi berisi data buku yang akan diupdate.
     * @param  Book  $book  Model buku yang akan diperbarui.
     * @return JsonResponse Response JSON dengan pesan sukses dan redirect URL.
     *
     * Proses pengupdatean:
     * 1. Ambil author_ids dari validated data
     * 2. Hapus author_ids dari validated sebelum update
     * 3. Perbarui data buku menggunakan update()
     * 4. Sinkronkan relationship authors dengan sync()
     * 5. Kembalikan response JSON dengan pesan sukses
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
            'message' => 'Buku berhasil diperbarui.',
            'redirect' => route('book.index'),
        ]);
    }

    /**
     * Menghapus buku dari storage.
     *
     * @param  Book  $book  Model buku yang akan dihapus.
     * @return JsonResponse Response JSON dengan pesan sukses.
     *
     * Menghapus buku dan mengembalikan response JSON dengan pesan sukses.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Buku berhasil dihapus.']);
    }
}
