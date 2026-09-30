@extends('layouts.app')

@section('title', $category->title)

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h3">{{ $category->name }}</h1>
            <a href="{{ route('category.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
