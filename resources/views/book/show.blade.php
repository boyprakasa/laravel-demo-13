@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <p class="text-muted">
        {{ $book->publication_year }} &middot;
        {{ $book->category->name ?? 'Tanpa Kategori' }}
    </p>

    <div class="mt-3">
        <h5>Penulis</h5>
        @if ($book->authors->isNotEmpty())
            <div>
                @foreach ($book->authors as $author)
                    <span class="badge bg-secondary me-1">{{ $author->name }}</span>
                @endforeach
            </div>
        @else
            <span class="text-muted">Belum ada penulis.</span>
        @endif
    </div>
@endsection
