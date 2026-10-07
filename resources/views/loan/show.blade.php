@extends('layouts.app')

@section('title', 'Detail Peminjaman: {{ $loan->member->name }} - {{ $loan->book->title }}')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">Detail Peminjaman</h3>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Anggota:</strong> {{ $loan->member->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Email Anggota:</strong> {{ $loan->member->email }}</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Buku:</strong> {{ $loan->book->title }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Penulis Buku:</strong>
                        @foreach ($loan->book->authors as $author)
                            <span class="badge bg-secondary me-1">{{ $author->name }}</span>
                        @endforeach
                    </p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Tanggal Pinjam:</strong> {{ format_date($loan->loan_date) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Pengembalian yang Diperkirakan:</strong>
                        {{ format_date($loan->expected_return_date) }}</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Tanggal Pengembalian Sejati:</strong>
                        {{ $loan->actual_return_date ? format_date($loan->actual_return_date) : '<span class="text-danger">Belum dikembalikan</span>' }}
                    </p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Status:</strong>
                        <span
                            class="badge bg-{{ $loan->status === 'on_loan' ? 'warning' : ($loan->status === 'overdue' ? 'danger' : 'success') }}">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Denda:</strong> Rp {{ number_format($loan->fine, 0, ',', '.') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Detail Denda:</strong>
                        @if ($loan->status === 'overdue')
                            Terlambat {{ $loan->expected_return_date->diffInDays(now()->toDateString()) }} hari
                            × Rp1.000/hari
                        @else
                            Tidak ada denda (tepat waktu atau belum jatuh tempo)
                        @endif
                    </p>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <a href="{{ route('loan.index') }}" class="btn btn-secondary me-md-2">Kembali ke Daftar</a>
                <a href="{{ route('loan.edit', $loan) }}" class="btn btn-warning">Edit Peminjaman</a>
            </div>
        </div>
    </div>
@endsection
