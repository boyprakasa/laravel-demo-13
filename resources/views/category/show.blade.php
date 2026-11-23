@extends('layouts.app')

@section('title', $category->title)

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-6">
                    <h1 class="h3 mb-0">Detail Kategori</h1>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('category.edit', $category) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('category.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered mb-0">
                <tr>
                    <th style="width: 25%">Nama Kategori</th>
                    <td>{{ $category->name }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $category->description ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Buku</th>
                    <td>{{ $category->books_count ?? $category->books->count() }} buku</td>
                </tr>
                <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ $category->created_at?->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
