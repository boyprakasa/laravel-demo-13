@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <h1 class="h3 mb-3">Edit Anggota</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('member.update', $member) }}" method="POST">
                @csrf
                @method('PUT')
                @include('member._form')
                <button class="btn btn-primary">Perbarui</button>
                <a href="{{ route('member.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
