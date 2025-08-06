<div class="col-12">

    @php
        $categoria = $this->categorias->find($item->categoria_id);
    @endphp

    <div wire:key="{{ $item->id }}" class="card ItemLista animate text-light " x-on:click="view = !view" wire:click="view({{ $item->id }})"
        x-data="{ hoverItem: false }" x-bind:class="{
            'border-black shadow': hoverItem,
        }"
        style="{{ isset($categoria) ? $this->corItem($categoria->tipo) : 'background-color: #333;' }}" x-on:mouseenter="hoverItem = true"
        x-on:mouseleave="hoverItem = false"
        @if (!empty($item->cliente_id) && empty($this->cliente))
        @click="window.location.href = '/clientes/{{ $item->cliente_id }}'"
        @else
        data-bs-toggle="modal" data-bs-target="#viewTransacao"
        @endif>

        <div class="card-body py-2 gy-2 row align-items-center">
            <div class="col-8">
                <div class="d-flex align-items-center mb-2">
                    <div class="pe-2 fw-bold text-start">
                        {{ $item->quantidade }}
                    </div>
                    <div class="flex-fill">
                        {{ $item->item }}
                    </div>
                    <div class="ps-2">
                        <i class="{{ $this->pagamentoNomepraClasse($item->forma_pagamento) }}"></i>
                    </div>
                </div>
                <div class="row align-items-end">
                    <div class="col">
                        @if (!is_null($categoria))
                        @if ($categoria->tipo == 'Receita')
                        <i class="bi bi-arrow-up-right-circle-fill"></i>
                        @elseif ($categoria->tipo == 'Despesa')
                        <i class="bi bi-arrow-down-right-circle-fill"></i>
                        @else
                        <i class="bi bi-hourglass-split"></i>
                        @endif
                        <span>{{ $categoria->nome }}</span>
                        @endif
                    </div>

                    <div class="col">
                        <small>
                            @if (empty($this->cliente))
                            <div class="row align-items-center">
                                <span>
                                    @if (empty($this->cliente))
                                    <div class="row align-items-center">
                                        <spam class="col-12 ">
                                            @switch($this->tipoPeriodo)
                                            @case('Diário')
                                            <i class="bi bi-clock"></i>
                                            {{ $item->created_at->format('H:i') }}
                                            @break

                                            @case('Mensal')
                                            <i class="bi bi-calendar-event-fill"></i>
                                            {{ \Carbon\Carbon::parse($item->data)->format('d -') }}
                                            {{ $item->created_at->format('H:i') }}
                                            @break

                                            @case('Anual')
                                            <i class="bi bi-calendar-event-fill"></i>
                                            {{ \Carbon\Carbon::parse($item->data)->format('d/m -') }}
                                            {{ $item->created_at->format('H:i') }}
                                            @break

                                            @case('Personalizado')
                                            <i class="bi bi-calendar-event-fill"></i>
                                            {{ \Carbon\Carbon::parse($item->data)->format('d/m/y -') }}
                                            {{ $item->created_at->format('H:i') }}
                                            @break
                                            @endswitch
                                        </spam>

                                        @if (!empty($item->cliente_id))
                                        <a class="col-12 link-underline link-underline-opacity-0 text-light text-capitalize"
                                            href="/clientes/{{ $item->cliente_id }}">

                                            <i class="bi bi-person-circle"></i>
                                            {{ $this->clientesArrayId[$item->cliente_id]->nome ?? '' }}

                                        </a>
                                        @endif
                                    </div>
                                    @else
                                    <small>
                                        <i class="bi bi-calendar-event"></i>
                                        {{ $item->created_at->format('d/m/Y H:i') }}
                                    </small>
                                    @endif
                                </span>

                            </div>
                            @else
                            <small>
                                <i class="bi bi-calendar-event"></i>
                                {{ $item->created_at->format('d/m/Y H:i') }}
                            </small>
                            @endif
                        </small>

                    </div>
                </div>

            </div>

            <div class="col-4" style="font-size: 1.2em !important;">
                <div class="row">
                    <strong class="col-12 text-end">
                        R$ {{ number_format($item->valor * $item->quantidade, 2, ',', '.') }}
                    </strong>

                </div>
                @if ($item->quantidade != 1)
                <span class="row">
                    <small class="col-12 text-end">R$ {{ number_format($item->valor, 2, ',', '.') }}</small>
                </span>
                @endif

            </div>

            {{-- CLIENTE --}}
            <div class="col-12 text-end">

                @if (!empty($item->cliente_id) && empty($this->cliente))
                <a class="link-underline link-underline-opacity-0 text-light"
                    href="/clientes/{{ $item->cliente_id }}">

                    <small>
                        {{ $this->clientesArrayId[$item->cliente_id]->nome ?? '' }}
                        <i class="bi bi-person-circle"></i>
                    </small>

                </a>
                @endif
            </div>
        </div>
    </div>
</div>
