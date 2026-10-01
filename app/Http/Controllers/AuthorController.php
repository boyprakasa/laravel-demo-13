<?php

namespace App\Http\Controllers;

use App\DataTables\AuthorsDataTable;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AuthorsDataTable $dataTable)
    {
        return $dataTable->render('author.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('author.create');
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return view('author.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return view('author.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
