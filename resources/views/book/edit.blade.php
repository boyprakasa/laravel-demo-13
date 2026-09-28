@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<h1 class="h3 mb-3">Edit Buku</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('book.update', $book) }}" method="POST">
            @csrf
            @method('PUT')
            @include('book._form')
            <button class="btn btn-primary">Perbarui</button>
            <a href="{{ route('book.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
