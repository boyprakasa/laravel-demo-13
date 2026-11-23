<x-guest-layout>
    <h1 class="h4 fw-bold text-center mb-1">Konfirmasi Kata Sandi</h1>
    <p class="text-muted text-center small mb-4">
        Ini adalah area aman. Harap konfirmasi kata sandi Anda sebelum melanjutkan.
    </p>

    <form action="/confirm-password" method="POST">
        <!-- @csrf -->
        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" class="form-control" id="password" name="password" required
                autofocus />
        </div>

        <button type="submit" class="btn btn-primary w-100">Konfirmasi</button>
    </form>
</x-guest-layout>
