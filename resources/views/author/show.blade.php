@extends('layouts.app')

@section('title', $author->title)

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h3">{{ $author->name }}</h1>
            <a href="{{ route('author.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
