@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
    <h1 class="h3 mb-3">Tambah Anggota</h1>
    <div class="card">

        <div class="card-body">
            <form action="{{ route('member.store') }}" method="POST">
                @csrf
                @include('member._form')
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('member.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
