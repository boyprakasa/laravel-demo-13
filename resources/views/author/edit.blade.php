@extends('layouts.app')

@section('title', 'Edit Penulis')

@section('content')
    <h1 class="h3 mb-3">Edit Penulis</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('author.update', $author) }}" method="POST" class="ajax-form">
                @csrf
                @method('PUT')
                @include('author._form')
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('author.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
