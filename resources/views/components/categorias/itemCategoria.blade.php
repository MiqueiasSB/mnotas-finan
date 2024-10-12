<div class="row gx-5 gy-md-0 gy-5 my-md-5 my-1">

    @foreach ($this->tipos as $key => $tipo)
        <div class="col-md-4">

            <div class="row gy-2 justify-content-center">
                <h4 class="col ps-md-1 p-0">{{ $tipo }}</h4>

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
    @endforeach

</div>