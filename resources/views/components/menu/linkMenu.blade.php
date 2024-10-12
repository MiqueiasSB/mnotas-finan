<li class="nav-item">
    <a class="nav-link mx-1 py-1 px-3 {{ request()->routeIs($rota) ? 'text-light fw-bold rounded bg-light-opacity-peimary' : 'text-white' }}"
        href="{{ route($rota) }}">{{ $label }}</a>
</li>