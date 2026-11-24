<?php

namespace App\Http\Controllers;

use App\DataTables\AuthorsDataTable;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthorController extends Controller
{
    /**
     * Menampilkan daftar penulis.
     *
     * @param  AuthorsDataTable  $dataTable  Instance DataTable untuk menangani query dan rendering.
     * @return View View untuk menampilkan halaman daftar penulis.
     *
     * Menggunakan DataTable class untuk otomatis menangani:
     * - Paginasi, sorting, dan filtering
     * - Render view 'author.index'
     */
    public function index(AuthorsDataTable $dataTable)
    {
        return $dataTable->render('author.index');
    }

    /**
     * Menampilkan form membuat penulis baru.
     *
     * @return View View untuk form penambah penulis.
     *
     * Render view 'author.create' untuk form input data penulis.
     */
    public function create()
    {
        return view('author.create');
    }

    /**
     * Menyimpan penulis baru ke storage.
     *
     * @param  AuthorRequest  $request  Request yang sudah divalidasi berisi data penulis.
     * @return JsonResponse Response JSON dengan pesan sukses dan redirect URL.
     *
     * Proses penyimpanan:
     * 1. Buat record penulis baru menggunakan Author::create()
     * 2. Kembalikan response JSON dengan pesan sukses
     */
    public function store(AuthorRequest $request)
    {
        Author::create($request->validated());

        return response()->json([
            'message' => 'Penulis berhasil ditambahkan.',
            'redirect' => route('author.index'),
        ]);
    }

    /**
     * Menampilkan detail penulis tertentu.
     *
     * @param  Author  $author  Model penulis yang akan ditampilkan detailnya.
     * @return View View untuk halaman detail penulis.
     *
     * Menyewakan view 'author.show' dengan data penulis.
     */
    public function show(Author $author)
    {
        return view('author.show', compact('author'));
    }

    /**
     * Menampilkan form edit penulis.
     *
     * @param  Author  $author  Model penulis yang akan diedit.
     * @return View View form edit penulis.
     *
     * Render view 'author.edit' dengan data penulis yang dipilih.
     */
    public function edit(Author $author)
    {
        return view('author.edit', compact('author'));
    }

    /**
     * Memperbarui data penulis di storage.
     *
     * @param  AuthorRequest  $request  Request yang sudah divalidasi berisi data penulis yang akan diupdate.
     * @param  Author  $author  Model penulis yang akan diperbarui.
     * @return JsonResponse Response JSON dengan pesan sukses dan redirect URL.
     *
     * Proses pengupdatean:
     * 1. Perbarui data penulis menggunakan $author->update()
     * 2. Kembalikan response JSON dengan pesan sukses
     */
    public function update(AuthorRequest $request, Author $author)
    {
        $author->update($request->validated());

        return response()->json([
            'message' => 'Penulis berhasil diperbarui.',
            'redirect' => route('author.index'),
        ]);
    }

    /**
     * Menghapus penulis dari storage.
     *
     * @param  Author  $author  Model penulis yang akan dihapus.
     * @return JsonResponse Response JSON dengan pesan sukses.
     *
     * Menghapus penulis dan mengembalikan response JSON dengan pesan sukses.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            'message' => 'Penulis berhasil dihapus.',
            'redirect' => route('author.index'),
        ]);
    }
}
