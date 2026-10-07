@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">Edit Peminjaman</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('loan.update', $loan) }}" method="POST">
                @csrf
                @method('PUT')
                @include('loan._form')
                <button class="btn btn-primary">Perbarui</button>
                <a href="{{ route('loan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
