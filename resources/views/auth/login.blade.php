<x-guest-layout>
    <h1 class="h4 fw-bold text-center mb-1">Masuk</h1>
    <p class="text-muted text-center small mb-4">Gunakan akun Anda untuk melanjutkan</p>

    <form action="/login" method="POST">
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

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" placeholder="nama@contoh.com" required autofocus />
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <label for="password" class="form-label">Kata Sandi</label>
                <a href="/forgot-password" class="small text-decoration-none">Lupa sandi?</a>
            </div>
            <input type="password" class="form-control" id="password" name="password" required />
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" />
            <label class="form-check-label small" for="remember">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </form>

    <p class="text-center text-muted small mt-4 mb-0">
        Belum punya akun? <a href="/register" class="text-decoration-none">Daftar</a>
    </p>
</x-guest-layout>
