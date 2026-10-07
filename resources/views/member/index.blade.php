@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-6 ">
                    <h1 class="h3 mb-0">Daftar Anggota</h1>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('member.create') }}" class="btn btn-primary">+ Tambah Anggota</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table table-striped table-bordered w-100']) }}
            </div>
            {{-- <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Bergabung</th>
                        <th class="text-end">Pinjaman Aktif</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone_number ?? '-' }}</td>
                            <td>{{ $item->joined_date }}</td>
                            <td class="text-end">
                                <span class="badge bg-info">{{ $item->loans->where('status', 'on_loan')->count() }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('member.edit', $item) }}" class="btn btn-sm btn-info">Edit</a>
                                <form action="{{ route('member.destroy', $item) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table> --}}
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
