@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
    <h1 class="h3 mb-3">Tambah Buku</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('book.store') }}" method="POST" class="ajax-form" data-reset>
                @csrf
                @include('book._form')
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('book.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
