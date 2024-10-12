<div {{ $attributes->merge(['class' => 'card px-0 shadow shadow-sm animate__animated']) }}>

    @if ($header ?? false)
        <div class="card-header bg-primary">
            {{ $header }}
        </div>
    @endif
    <div class="card-body p-sm-3 p-2 {{ $bodyClass ?? '' }}">
        {{ $slot }}
    </div>

    @if($loading ?? false)
        <x-loading></x-loading>
    @endif

</div>
 