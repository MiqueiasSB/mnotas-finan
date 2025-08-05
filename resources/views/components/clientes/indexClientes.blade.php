<div>

    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="d-flex flex-column flex-sm-row align-items-center mt-2 mb-5">
        <div class="flex-sm-fill w-100 pe-sm-3 mb-2 mb-sm-0">
            <div class="input-group">
                <input type="text" wire:model.live="pesquisa" class="form-control form-control-lg" placeholder="Nome, CPF, Numero"
                    aria-describedby="button-addon2">
                <button class="btn btn-lg btn-primary text-white" type="button" id="button-addon2">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <div class="d-none d-sm-block w-25 text-end">
            <a href="{{ route('clientes.create') }}" class="btn btn-lg btn-primary  text-white fw-bold w-100 w-sm-auto @if(!Auth::user()->subscription('default')) disabled @endif">
                Novo <i class="bi bi-plus-lg"></i>
            </a>
        </div>
    </div>


    <div class="d-block d-sm-none ">
        <div class="row justify-content-end pe-2 fixed-bottom z-3" style="margin-bottom: 5em !important;">
            <div class="col-4 text-end">
                <a href="{{ route('clientes.create') }}"
                    class="btn btn-lg btn-primary text-white fw-bold @if (!Auth::user()->subscription('default')) disabled @endif">
                    <i class="display-6 bi bi-person-fill-add"></i></a>
            </div>
        </div>
    </div>



    @if ($clientes->isEmpty() && !empty($this->pesquisa))
    <div class="my-3 text-center opacity-75">
        <hr class="mb-4">
        Nenhum usuario encontrado...
    </div>
    @elseif ($clientes->isEmpty())
    <div class="my-3 text-center opacity-75">
        <hr class="mb-4">
        Nenhum usuario cadastrado...
    </div>
    @else
    @foreach ($clientes as $cliente)
    <x-clientes.itemListaCliente
        :cliente="$cliente"
        :class="$loop->index % 2 == 0 ? 'bg-light' : 'bg-white'">
    </x-clientes.itemListaCliente>
    @endforeach


    <div class="row mt-3">
        <div class="pagination justify-content-center">
            <ul class="pagination">
                {{-- Link para a página anterior --}}
                @if ($clientes->onFirstPage())
                <li class="page-item disabled"><span class="page-link"><i
                            class="bi bi-caret-left-fill"></i></span></li>
                @else
                <li class="page-item"><a class="page-link" href="{{ $clientes->previousPageUrl() }}"
                        rel="prev"><i class="bi bi-caret-left-fill"></i></a></li>
                @endif

                {{-- Links para as páginas --}}
                @foreach ($clientes->links()->elements[0] as $page => $url)
                @if ($page == $clientes->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                <li class="page-item"><a class="page-link"
                        href="{{ $url }}">{{ $page }}</a></li>
                @endif
                @endforeach

                {{-- Link para a próxima página --}}
                @if ($clientes->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $clientes->nextPageUrl() }}"
                        rel="next"><i class="bi bi-caret-right-fill"></i></a></li>
                @else
                <li class="page-item disabled"><span class="page-link"><i
                            class="bi bi-caret-right-fill"></i></span></li>
                @endif
            </ul>
        </div>



    </div>
    @endif


</div>
