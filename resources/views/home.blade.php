@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Selamat Datang di Aplikasi Laravel Anda</h3>
                    </div>

                    <div class="card-body">
                        <p>
                            Ini adalah halaman beranda dari aplikasi Laravel yang Anda bangun.
                            Dari sini Anda dapat mengakses berbagai fitur yang telah Anda pelajari.
                        </p>

                        <!-- Statistik Sederhana -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <h5 class="mb-0">Total Buku</h5>
                                    <p class="fs-4 mb-0">{{ $totalBooks }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <h5 class="mb-0">Buku Baru</h5>
                                    <p class="fs-4 mb-0">{{ $recentBooks->count() }} buku</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tautan ke Fitur Utama -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <a href="{{ route('book.index') }}" class="btn btn-primary me-md-2">
                                📚 Daftar Buku
                            </a>
                            <a href="{{ route('book.create') }}" class="btn btn-success me-md-2">
                                ➕ Tambah Buku
                            </a>
                            @if (Route::has('category.index'))
                                <a href="{{ route('category.index') }}" class="btn btn-info me-md-2">
                                    🏷️ Kelola Kategori
                                </a>
                            @endif
                            @if (Route::has('author.index'))
                                <a href="{{ route('author.index') }}" class="btn btn-outline-secondary">
                                    � Penulis
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
