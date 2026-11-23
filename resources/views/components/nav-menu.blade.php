@props(['items' => []])

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
    <div class="container">
        <!-- Brand / Logo -->
        <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">📚 Perpustakaan Mini</a>

        <!-- Tombol toggler untuk layar kecil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Item menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @foreach ($items as $item)
                    {{-- Lewati item logout dari list kiri karena sudah dipindah ke dropdown kanan --}}
                    @continue(($item['route'] ?? '') === 'logout')

                    @if (isset($item['children']))
                        <!-- Item menu dengan dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $loop->index }}"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $item['label'] }}
                            </a>
                            <ul class="dropdown-menu shadow-sm border-0"
                                aria-labelledby="navbarDropdown{{ $loop->index }}">
                                @foreach ($item['children'] as $child)
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ isset($child['url']) ? $child['url'] : route($child['route']) }}">
                                            {{ $child['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <!-- Item menu biasa -->
                        <li class="nav-item">
                            <a class="nav-link {{ $isActive($item) ? 'active' : '' }}"
                                href="{{ isset($item['url']) ? $item['url'] : route($item['route']) }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>

            <!-- Bagian Kanan: Profil User & Logout -->
            @auth
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-white" href="#"
                            id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- Avatar Inisial Sederhana -->
                            <span
                                class="badge rounded-circle bg-primary d-inline-flex align-items-center justify-content-center"
                                style="width: 28px; height: 28px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span>{{ Auth::user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="userDropdown">
                            <li class="px-3 py-2">
                                <div class="fw-semibold small text-dark">{{ Auth::user()->name }}</div>
                                <div class="text-muted small">{{ Auth::user()->email }}</div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('profile*') ? 'active' : '' }}"
                                    href="{{ Route::has('profile.edit') ? route('profile.edit') : route('profile') }}">
                                    Profil Saya
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-medium">
                                        Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>
