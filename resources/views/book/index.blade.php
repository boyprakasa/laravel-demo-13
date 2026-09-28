@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Daftar Buku</h1>
        <a href="{{ route('book.create') }}" class="btn btn-primary">+ Tambah Buku</a>
    </div>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                placeholder="Cari judul atau penulis...">
            <button class="btn btn-outline-secondary">Cari</button>
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($book as $item)
                        <tr>
                            <td>{{ $book->firstItem() + $loop->index }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->writer }}</td>
                            <td>{{ $item->publication_year }}</td>
                            <td class="text-end">
                                <a href="{{ route('book.show', $item) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('book.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('book.destroy', $item) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $book->links() }}
    </div>
@endsection
