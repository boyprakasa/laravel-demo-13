@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">
            <h1 class="h4 fw-bold mb-4">Pengaturan Profil</h1>

            <x-alert />

            <!-- 1. Kartu Informasi Profil (2 Kolom Sejajar) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-semibold mb-1">Informasi Profil</h2>
                    <p class="text-muted small mb-4">Perbarui nama lengkap dan alamat email akun Anda.</p>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-6">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                                    required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    required />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            <!-- 2. Kartu Ubah Kata Sandi (Kolom Terbatas & Password Baru Bersebelahan) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-semibold mb-1">Perbarui Kata Sandi</h2>
                    <p class="text-muted small mb-4">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar
                        tetap aman.</p>

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-6">
                                <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                                <input type="password"
                                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                    id="current_password" name="current_password" autocomplete="current-password"
                                    required />
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-6">
                                <label for="password" class="form-label">Kata Sandi Baru</label>
                                <input type="password"
                                    class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                    id="password" name="password" autocomplete="new-password" required />
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                                    required />
                                @error('password_confirmation', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Ubah Kata Sandi</button>
                    </form>
                </div>
            </div>

            <!-- 3. Kartu Hapus Akun (Teks & Tombol Sejajar Kiri-Kanan) -->
            <div class="card border-0 shadow-sm rounded-4 border-start border-danger border-4">
                <div
                    class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h2 class="h5 fw-semibold text-danger mb-1">Hapus Akun</h2>
                        <p class="text-muted small mb-0">
                            Setelah akun dihapus, semua data yang terkait akan dihapus secara permanen.
                        </p>
                    </div>

                    <button type="button" class="btn btn-outline-danger flex-shrink-0" data-bs-toggle="modal"
                        data-bs-target="#confirmDeleteAccountModal">
                        Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Akun -->
    <div class="modal fade" id="confirmDeleteAccountModal" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-header border-0 pb-0">
                        <h3 class="h5 modal-title fw-bold" id="deleteModalLabel">Yakin ingin menghapus akun?</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted small mb-3">
                            Masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun secara permanen.
                        </p>
                        <div>
                            <label for="delete_password" class="form-label visually-hidden">Kata Sandi</label>
                            <input type="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                id="delete_password" name="password" placeholder="Masukkan kata sandi Anda" required />
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
