<div wire:key="{{ $item->id }}" class="col-12">

    @php
    $categoria = $this->categorias->find($item->categoria_id);
    @endphp

    <div
        class="card ItemLista animate text-light"
        x-data="{ hoverItem: false, view: false }"
        x-on:mouseenter="hoverItem = true"
        x-on:mouseleave="hoverItem = false"
        x-bind:class="{ 'border-black shadow': hoverItem }"
        style="{{ isset($categoria) ? $this->corItem($categoria->tipo) : 'background-color: #333;' }}"


        {{-- Clique principal: alterna visualização com Alpine e executa Livewire --}}
        x-on:click="view = !view"
        wire:click="view({{ $item->id }})"

        {{-- Redireciona para cliente se tiver cliente_id e nenhum cliente selecionado --}}
        @if (!empty($item->cliente_id) && empty($this->cliente))
        x-on:click.stop="window.location.href = '/clientes/{{ $item->cliente_id }}'"
        @else
        data-bs-toggle="modal"
        data-bs-target="#viewTransacao"
        @endif
        >


        <div class="card-body py-2 gy-2 row align-items-center">
            {{-- Quantidade --}}
            <div class="col-md-1 col-2 px-sm-2 px-0 ps-1">
                <div class="" data-bs-toggle="modal" data-bs-target="#viewTransacao">
                    <span> {{ $item->quantidade }}</span>
                </div>
            </div>

            <div class="col-md-9 col-7">
                <div class="row gy-2 align-items-center">

                    {{-- Item --}}
                    <div class="col-md-3 col-10 text-capitalize fw-bold order-sm-1">
                        <span> {{ $item->item }}</span>
                    </div>
                    {{-- Forma de pagamento --}}
                    <div class="col-md-1 col-2 text-center order-sm-4">
                        <i class="{{ $this->pagamentoNomepraClasse($item->forma_pagamento) }}"></i>
                    </div>

                    {{-- Categoria --}}
                    <div class="col text-md-center text-start text-capitalize order-sm-2">
                        @if (!is_null($categoria))
                            <small>
                                @if ($categoria->tipo == 'Receita')
                                <i class="bi bi-arrow-up-right-circle-fill"></i>
                                @elseif ($categoria->tipo == 'Despesa')
                                <i class="bi bi-arrow-down-right-circle-fill"></i>
                                @else
                                <i class="bi bi-hourglass-split"></i>
                                @endif
                                <span>{{ $categoria->nome }}</span>
                            </small>
                        @endif

                    </div>

                    {{-- Data e Hora --}}
                    <div class="col-md-3 col-6 text-start order-sm-3" data-bs-toggle="modal"
                        data-bs-target="#viewTransacao">
                        <small>
                            @if (empty($this->cliente))
                            <div class="row align-items-center">
                                <span class="col-12 ">
                                    @switch($this->tipoPeriodo)
                                    @case('Diário')
                                    <i class="bi bi-clock"></i>
                                    {{ $item->created_at->format(' H:i') }}
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
                                </span>



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
                        </small>

                    </div>
                </div>
            </div>

            {{-- Preço --}}
            <div class="col-md-2 col-3 p-sm-2 p-1" data-bs-toggle="modal" data-bs-target="#viewTransacao">
                <div class="row ">
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

        </div>

    </div>
</div>
