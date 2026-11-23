<x-guest-layout>
    <h1 class="h4 fw-bold text-center mb-1">Lupa Kata Sandi</h1>
    <p class="text-muted text-center small mb-4">
        Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
    </p>

    {{-- Notifikasi Sukses Kirim Link Reset Password --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show small" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Notifikasi Gagal (misalnya email tidak terdaftar atau tunggu beberapa saat) --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif


    <form action="/forgot-password" method="POST">
        <!-- @csrf -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="nama@contoh.com"
                required autofocus />
        </div>

        <button type="submit" class="btn btn-primary w-100">Kirim Tautan Reset</button>
    </form>

    <p class="text-center text-muted small mt-4 mb-0">
        <a href="/login" class="text-decoration-none">Kembali ke halaman masuk</a>
    </p>

</x-guest-layout>
