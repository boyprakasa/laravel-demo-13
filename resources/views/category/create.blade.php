@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <h1 class="h3 mb-3">Tambah Kategori</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('category.store') }}" method="POST" class="ajax-form" data-reset>
                @csrf
                @include('category._form')
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('category.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
