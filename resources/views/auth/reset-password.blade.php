<x-guest-layout>
    <h1 class="h4 fw-bold text-center mb-1">Kata Sandi Baru</h1>
    <p class="text-muted text-center small mb-4">Silakan buat kata sandi baru untuk akun Anda</p>

    <form action="/reset-password" method="POST">
        <!-- @csrf -->
        <input type="hidden" name="token" value="" />

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="nama@contoh.com"
                required />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi Baru</label>
            <input type="password" class="form-control" id="password" name="password" required autofocus />
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                required />
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan Kata Sandi</button>
    </form>
</x-guest-layout>
