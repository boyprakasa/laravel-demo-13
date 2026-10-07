@extends('layouts.app')

@section('title', 'Detail Anggota: {{ $member->name }}')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">Detail Anggota</h3>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ $member->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Email:</strong> {{ $member->email }}</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Nomor Telepon:</strong> {{ $member->phone_number ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Alamat:</strong> {{ $member->address ?? '-' }}</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Tanggal Bergabung:</strong> {{ $member->joined_date }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Pinjaman Aktif:</strong>
                        <span class="badge bg-info">{{ $member->loans->where('status', 'on_loan')->count() }}</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Total Denda:</strong>
                        Rp {{ number_format($member->loans->sum('fine'), 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <h5>Riwayat Pinjaman</h5>
                @if ($member->loans->isNotEmpty())
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th class="text-end">Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($member->loans as $index => $loan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $loan->book->title }}</td>
                                    <td>{{ $loan->loan_date }}</td>
                                    <td>{{ $loan->actual_return_date ? $loan->actual_return_date : 'Belum dikembalikan' }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $loan->status === 'on_loan' ? 'warning' : ($loan->status === 'overdue' ? 'danger' : 'success') }}">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        Rp {{ number_format($loan->fine, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center text-muted py-3">Tidak ada riwayat pinjaman.</p>
                @endif
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <a href="{{ route('member.index') }}" class="btn btn-secondary me-md-2">Kembali ke Daftar</a>
                <a href="{{ route('member.edit', $member) }}" class="btn btn-warning">Edit Anggota</a>
            </div>
        </div>
    </div>
@endsection
