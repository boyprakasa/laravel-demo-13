@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-6 ">
                    <h1 class="h3 mb-0">Daftar Peminjaman</h1>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('loan.create') }}" class="btn btn-primary">+ Tambah Penulis</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table table-striped table-bordered w-100']) }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
