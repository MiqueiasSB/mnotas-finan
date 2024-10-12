<div class="flex-fill nav-item">
    <a class="nav-link d-flex flex-column  {{ request()->routeIs($rota) ? 'text-primary fw-bold rounded' : 'text-dark' }}" href="{{ route($rota) }}">
        <i class="{{ $icon }}"></i>
        <small style="font-size: 0.6em">{{ $label }}</small>
    </a>
</div>