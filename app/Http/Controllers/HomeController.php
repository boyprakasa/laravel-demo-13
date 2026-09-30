<?php

namespace App\Http\Controllers;

use App\Models\Book;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil statistik sederhana (opsional)
        $totalBooks = Book::count();
        $recentBooks = Book::latest()->take(5)->get();

        // Kirim data ke view
        return view('home', [
            'totalBooks' => $totalBooks,
            'recentBooks' => $recentBooks,
        ]);
    }
}
