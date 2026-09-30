@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h3">{{ $book->title }}</h1>
            <p class="text-muted">
                {{ $book->writer }} &middot; {{ $book->publication_year }} &middot;
                {{ $book->category->name ?? 'Tanpa Kategori' }}
            </p>
            <p>{{ $book->description ?: 'Tidak ada deskripsi.' }}</p>
            <a href="{{ route('book.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
