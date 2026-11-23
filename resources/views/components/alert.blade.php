{{-- 1. Status khusus halaman Profil & Reset Password --}}
@if (session('status') === 'profile-updated')
    <div class="alert alert-success alert-dismissible fade show small" role="alert">
        Profil berhasil diperbarui.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@elseif (session('status') === 'password-updated')
    <div class="alert alert-success alert-dismissible fade show small" role="alert">
        Kata sandi berhasil diperbarui.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@elseif (session('status'))
    <div class="alert alert-success alert-dismissible fade show small" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

{{-- 2. Flash Message Custom --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show small" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show small" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

{{-- 3. Validasi Error Default --}}
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

{{-- 4. Validasi Error Bag Khusus Update Password & Hapus Akun --}}
@if ($errors->updatePassword->any())
    <div class="alert alert-danger alert-dismissible fade show small" role="alert">
        <ul class="mb-0 ps-3">
            @foreach ($errors->updatePassword->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

@if ($errors->userDeletion->any())
    <div class="alert alert-danger alert-dismissible fade show small" role="alert">
        <ul class="mb-0 ps-3">
            @foreach ($errors->userDeletion->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif
