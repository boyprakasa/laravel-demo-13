@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">Tambah Peminjaman</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('loan.store') }}" method="POST">
                @csrf
                @include('loan._form')
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('loan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
