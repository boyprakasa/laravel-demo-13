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

<body class="bg-light">

    <!-- Tampilkan komponen navigasi -->
    <x-nav-menu :items="[
        ['label' => 'Beranda', 'url' => '/'],
        ['label' => 'Kategori', 'route' => 'category.index'],
        ['label' => 'Penulis', 'route' => 'author.index'],
        [
            'label' => 'Buku',
            'children' => [
                ['label' => 'Daftar Buku', 'route' => 'book.index'],
                ['label' => 'Tambah Buku', 'route' => 'book.create'],
            ],
        ],
        ['label' => 'Anggota', 'route' => 'member.index'],
        ['label' => 'Peminjaman', 'route' => 'loan.index'],
    ]" />

    <main class="container pb-4">
        @yield('content')
    </main>
</body>

</html>
