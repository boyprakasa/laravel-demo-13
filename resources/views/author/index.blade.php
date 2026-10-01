@extends('layouts.app')

@section('title', 'Daftar Penulis')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-6 ">
                    <h1 class="h3 mb-0">Daftar Penulis</h1>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('author.create') }}" class="btn btn-primary">+ Tambah Penulis</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{ $dataTable->table(['class' => 'table table-striped table-bordered w-100']) }}
        </div>
    </div>

@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
