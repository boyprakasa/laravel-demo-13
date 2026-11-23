@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h1 class="h4 text-center mb-0">
                Selamat Datang, <span class="text-primary fw-bold">{{ auth()->user()->name }}</span> 👋
            </h1>
        </div>

        <div class="card-body p-4">
            <p class="text-muted text-center mb-4">
                Ini adalah halaman beranda <strong>Perpustakaan Mini</strong>. Dari sini Anda dapat memantau ringkasan
                koleksi dan mengakses berbagai fitur utama.
            </p>

            <!-- Statistik Sederhana -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6">
                    <div class="bg-light p-3 rounded-3 border-start border-primary border-4 h-100">
                        <div class="text-muted small">Total Buku</div>
                        <div class="fs-3 fw-bold mb-0">{{ $totalBooks }} <span
                                class="fs-6 fw-normal text-muted">judul</span></div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="bg-light p-3 rounded-3 border-start border-success border-4 h-100">
                        <div class="text-muted small">Buku Terbaru</div>
                        <div class="fs-3 fw-bold mb-0">{{ $recentBooks->count() }} <span
                                class="fs-6 fw-normal text-muted">buku</span></div>
                    </div>
                </div>
            </div>

            <!-- Tautan Cepat ke Fitur Utama -->
            <h2 class="h6 fw-semibold text-muted mb-2">Akses Cepat</h2>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('book.index') }}" class="btn btn-primary">
                    📚 Daftar Buku
                </a>
                <a href="{{ route('book.create') }}" class="btn btn-success">
                    ➕ Tambah Buku
                </a>
                @if (Route::has('category.index'))
                    <a href="{{ route('category.index') }}" class="btn btn-info text-white">
                        🏷️ Kelola Kategori
                    </a>
                @endif
                @if (Route::has('author.index'))
                    <a href="{{ route('author.index') }}" class="btn btn-outline-secondary">
                        👤 Kelola Penulis
                    </a>
                @endif
                @if (Route::has('member.index'))
                    <a href="{{ route('member.index') }}" class="btn btn-outline-primary">
                        🧑‍🤝‍🧑 Data Anggota
                    </a>
                @endif
                @if (Route::has('loan.index'))
                    <a href="{{ route('loan.index') }}" class="btn btn-outline-dark">
                        📖 Peminjaman
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Daftar Buku Terbaru (Relasi Many-to-Many: authors) -->
    @if ($recentBooks->isNotEmpty())
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h2 class="h5 fw-bold mb-0">🆕 Buku Terbaru Ditambahkan</h2>
                <a href="{{ route('book.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Judul Buku</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th class="text-end pe-4">Ditambahkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentBooks as $book)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $book->title }}</td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis">
                                            {{ $book->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $book->authors->pluck('name')->join(', ') ?: '-' }}
                                    </td>
                                    <td class="text-end pe-4 text-muted small">
                                        {{ $book->created_at?->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
