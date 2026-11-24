<?php

namespace App\Http\Controllers;

use App\DataTables\CategoriesDataTable;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori.
     *
     * @param  CategoriesDataTable  $dataTable  Instance DataTable untuk menangani query dan rendering.
     * @return View View untuk menampilkan halaman daftar kategori.
     *
     * Menggunakan DataTable class untuk otomatis menangani:
     * - Paginasi, sorting, dan filtering
     * - Render view 'category.index'
     */
    public function index(CategoriesDataTable $dataTable)
    {
        return $dataTable->render('category.index');
    }

    /**
     * Menampilkan form membuat kategori baru.
     *
     * @return View View untuk form penambah kategori.
     *
     * Render view 'category.create' untuk form input data kategori.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Menyimpan kategori baru ke storage.
     *
     * @param  CategoryRequest  $request  Request yang sudah divalidasi berisi data kategori.
     * @return JsonResponse Response JSON dengan pesan sukses dan redirect URL.
     *
     * Proses penyimpanan:
     * 1. Buat record kategori baru menggunakan Category::create()
     * 2. Kembalikan response JSON dengan pesan sukses
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        return response()->json([
            'message' => 'Kategori berhasil ditambahkan.',
            'redirect' => route('category.index'),
        ]);
    }

    /**
     * Menampilkan detail kategori tertentu.
     *
     * @param  Category  $category  Model kategori yang akan ditampilkan detailnya.
     * @return View View untuk halaman detail kategori.
     *
     * Menyewakan view 'category.show' dengan data kategori.
     */
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    /**
     * Menampilkan form edit kategori.
     *
     * @param  Category  $category  Model kategori yang akan diedit.
     * @return View View form edit kategori.
     *
     * Render view 'category.edit' dengan data kategori yang dipilih.
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Memperbarui data kategori di storage.
     *
     * @param  CategoryRequest  $request  Request yang sudah divalidasi berisi data kategori yang akan diupdate.
     * @param  Category  $category  Model kategori yang akan diperbarui.
     * @return JsonResponse Response JSON dengan pesan sukses dan redirect URL.
     *
     * Proses pengupdatean:
     * 1. Perbarui data kategori menggunakan $category->update()
     * 2. Kembalikan response JSON dengan pesan sukses
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json([
            'message' => 'Kategori berhasil diperbarui.',
            'redirect' => route('category.index'),
        ]);
    }

    /**
     * Menghapus kategori dari storage.
     *
     * @param  Category  $category  Model kategori yang akan dihapus.
     * @return JsonResponse Response JSON dengan pesan sukses.
     *
     * Menghapus kategori dan mengembalikan response JSON dengan pesan sukses.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus.']);
    }
}
