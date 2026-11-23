<x-guest-layout>
    <h1 class="h4 fw-bold text-center mb-1">Buat Akun</h1>
    <p class="text-muted text-center small mb-4">Lengkapi data diri untuk mendaftar</p>

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

    <form action="/register" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nama Anda" required
                autofocus />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="nama@contoh.com"
                required />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter"
                required />
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                placeholder="Ulangi kata sandi" required />
        </div>

        <button type="submit" class="btn btn-primary w-100">Daftar</button>
    </form>

    <p class="text-center text-muted small mt-4 mb-0">
        Sudah punya akun? <a href="/login" class="text-decoration-none">Masuk</a>
    </p>
</x-guest-layout>
