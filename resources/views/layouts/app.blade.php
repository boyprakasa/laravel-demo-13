<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Perpustakaan Mini')</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Tampilkan komponen navigasi -->
    <x-nav-menu :items="[
        ['label' => 'Beranda', 'route' => 'dashboard'],
        ['label' => 'Kategori', 'route' => 'category.index'],
        ['label' => 'Penulis', 'route' => 'author.index'],
        ['label' => 'Buku', 'route' => 'book.index'],
        ['label' => 'Anggota', 'route' => 'member.index'],
        ['label' => 'Peminjaman', 'route' => 'loan.index'],
        ['label' => 'Keluar', 'route' => 'logout'],
        // [
        //     'label' => 'Some Module',
        //     'children' => [
        //         ['label' => 'Label One', 'route' => 'some.index'],
        //         ['label' => 'Label Two', 'route' => 'some.create'],
        //     ],
        // ],
    ]" />

    <main class="container flex-grow-1 pb-5">
        <!-- Flash Message Global (Sukses / Error dari Controller) -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <!-- Slot Konten Halaman -->
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="bg-white border-top py-3 mt-auto">
        <div class="container text-center text-muted small">
            &copy; {{ date('Y') }} Perpustakaan Mini. Dibuat untuk pembelajaran Laravel.
        </div>
    </footer>
</body>

</html>
