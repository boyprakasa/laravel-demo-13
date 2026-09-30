<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <!-- Brand / Logo -->
        <a class="navbar-brand" href="{{ url('/') }}">📚 Perpustakaan Mini</a>

        <!-- Tombol toggler untuk layar kecil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Item menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                @foreach ($items as $item)
                    @if (isset($item['children']))
                        <!-- Item menu dengan dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $loop->index }}"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $item['label'] }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $loop->index }}">
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
        </div>
    </div>
</nav>
