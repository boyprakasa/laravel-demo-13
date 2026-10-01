@extends('layouts.app')

@section('title', 'Tambah Penulis')

@section('content')
    <h1 class="h3 mb-3">Tambah Penulis</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('author.store') }}" method="POST" class="ajax-form" data-reset>
                @csrf
                @include('author._form')
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('author.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
