<x-guest-layout>
    <h1 class="h4 fw-bold text-center mb-1">Verifikasi Email</h1>
    <p class="text-muted small mb-4">
        Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengeklik tautan yang
        baru saja kami kirimkan.
    </p>

    <!-- Alert jika tautan baru dikirim -->
    <!-- <div class="alert alert-success small" role="alert">Tautan verifikasi baru telah dikirim ke email Anda.</div> -->

    <div class="d-flex justify-content-between align-items-center gap-2">
        <form action="/email/verification-notification" method="POST">
            <!-- @csrf -->
            <button type="submit" class="btn btn-primary btn-sm">Kirim Ulang Email</button>
        </form>

        <form action="/logout" method="POST">
            <!-- @csrf -->
            <button type="submit" class="btn btn-link text-muted text-decoration-none btn-sm">Keluar</button>
        </form>
    </div>
</x-guest-layout>
