@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <h1 class="h3 mb-3">Edit Kategori</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('category.update', $category) }}" method="POST" class="ajax-form">
                @csrf
                @method('PUT')
                @include('category._form')
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('category.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
