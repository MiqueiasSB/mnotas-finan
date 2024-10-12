<div class="row">
    <div class="accordion my-4 px-0" id="accordionCategorias">

        @foreach ($this->tipos as $key => $tipo)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button bg-{{ $this->cores[$key] }}-light" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $key }}" aria-expanded="true"
                        aria-controls="collapse{{ $key }}">
                        {{ $tipo }}
                    </button>
                </h2>
                <div id="collapse{{ $key }}" class="accordion-collapse collapse"
                    data-bs-parent="#accordionCategorias">
                    <div class="accordion-body">

                        <div class="row gy-2 justify-content-center">
                            @if ($this->categoriasPorTipo[$tipo] ?? false)
                                @foreach ($this->categoriasPorTipo[$tipo] as $categoria)
                                    <div class="col-12 cursor-pointer" wire:key="{{ $categoria->id }}">
                                        <div class="row p-3 border border-{{ $this->cores[$key] }} rounded"
                                            wire:click="criaViewModal({{ $categoria->id }})" x-data="{ hover: false }"
                                            x-bind:class="{ 'shadow': hover }" @mouseover="hover = true"
                                            @mouseout="hover = false">

                                            <span class="col text-capitalize">{{ $categoria->nome }}</span>

                                        </div>

                                    </div>
                                @endforeach
                            @else
                                <small class="opacity-25">Nenhuma Categoria</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
