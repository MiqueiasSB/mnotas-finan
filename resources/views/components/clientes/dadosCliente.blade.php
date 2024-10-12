<div>
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-9 col-md-9 col-sm-8">
            <h1 class="my-1 text-capitalize fw-bold"><i class="bi bi-person-fill"></i> {{ $cliente->nome }}</h1>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-4 mt-sm-0 mt-3 text-end">
            <div class="row g-2 ">
                <div class="col">

                    <!-- Button trigger modal -->
                    <button type="button" class="w-100 btn btn-danger text-white" data-bs-toggle="modal"
                    data-bs-target="#aviso1">
                        <i class="bi bi-trash-fill"></i>
                        Excluir
                    </button>

                    <x-clientes.deleteCliente :cliente="$cliente"></x-clientes.deleteCliente>

                </div>
                <div class="col">
                    <a class="w-100 btn btn-info text-light"
                        href="{{ route('clientes.edit', ['cliente' => $cliente->nome]) }}">
                        <i class="bi bi-pen-fill"></i>
                        Editar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <hr class="opacity-25">

    <div class="row align-items-center justify-content-between mt-4 gy-md-4">
        @if ( !is_null($cliente->telefone) )
        <div class="col-md-6">
            <h5><i class="bi bi-telephone-fill"></i> Contato: {{ $cliente->telefone }}</h5>
        </div>
        @endif
       
        @if ( !is_null($cliente->cpf) )
        <div class="col-md-6"> 
            <h5>
                <i class="bi bi-hash"></i> CPF: {{ $cliente->cpf }}
            </h5>
        </div>
        @endif

        @if ( !is_null($cliente->endereco) )
        <div class="col col-md">
            <h5><i class="bi bi-geo-fill text-capitalize"></i> Endereço: {{ $cliente->endereco }}</h5>
        </div>
        @endif
    </div>

    @if ( !is_null($cliente->descricao) )
    <div class="row align-items-center justify-content-between mt-2 gy-md-4">
        <p class="col-lg-8"><i class="bi bi-file-earmark-text"></i> Descrição: {{ $cliente->descricao }}</p>
    </div>
    @endif

    <div class="text-end mt-3">
        <small>Última Atualização: {{ $cliente->updated_at->format('d/m/Y H:i') }}</small>
        <br>
        <small>Criado em: {{ $cliente->created_at->format('d/m/Y H:i') }}</small>
    </div>
</div>
