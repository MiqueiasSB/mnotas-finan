<div x-data="{
    open: false,
    categoriaSelecionada: @entangle('categoriaSelecionada'),
   
    topCategorias:  @entangle('topCategorias'), 
}" x-on:click.away="open = false" class="h-100 d-flex ">

   
    {{-- inputs para enviar valores para o controler ao salvar | SEM VISIBILIDADE--}}
    <input type="text" class="d-none" wire:model="tipoSelecionado" :value="topCategorias[tipoSelecionado][0]">
    <input type="text" class="d-none" wire:model="categoriaSelecionada" :value="categoriaSelecionada">
    
    {{-- Botão principal de seleção --}}
    <button x-on:click="open = !open" type="button" class=" btn text-light w-100 h-100"
        :class="'bg-' + topCategorias[tipoSelecionado][2]">

        <span class="fw-bold" x-text="categoriaSelecionada"></span>
        <i x-bind:class="topCategorias[tipoSelecionado]"></i>
    </button>

    {{-- Div de seleção --}}
    <div :class="larguraTela > responsivo.sm ? 'w-75' : 'w-100'" class="z-3 position-absolute start-0 shadow shadow-lg bg-light my-5 p-3 rounded row row-cols-{{ count($this->topCategorias) }} gx-2 z-1"
        x-show="open">

        {{-- Percorre os tipos de categorias --}}
        <template x-for="(topCategoria, index) in topCategorias" :key="index">

            <div class="col">
                <div :class="'p-1 rounded border border-2 border-' + topCategoria[2]">
                    {{-- Botão de cabeçalho, referente aos tipos de categoria --}}
                    <button type="button" :class="'w-100 text-light btn btn-sm btn-' + topCategoria[2]"
                        x-on:click="tipoSelecionado = index,
                                    categoriaSelecionada = topCategoria[0],
                                    open = false">

                        <i x-bind:class="topCategoria[1]"></i>
                        <small class="text-capitalize fw-bold" x-text="topCategoria[0]"></small>
                    </button>

                    {{-- Botões referêntes as categorias personalizadas, separadas por tipo --}}
                    @foreach ($this->categorias as $categoria)
                        {{-- Para não mostrar as genericas --}}
                        <template x-if="topCategoria[0] === '{{ $categoria->tipo }}' && {{ $categoria->id}} !== 1 && {{ $categoria->id}} !== 2 && {{ $categoria->id }} !== 3">

                            <div class="col mt-1">
                                <button type="button" class="btn btn-sm btn-light w-100 text-capitalize" 
                                    x-on:click="tipoSelecionado = index,
                                                open = false,
                                                categoriaSelecionada = '{{ $categoria->nome }}'">
                                                
                                     {{ $categoria->nome }}
                                </button>
                            </div>

                        </template>
                    @endforeach
                </div>
            </div>


        </template>


    </div>

</div>
