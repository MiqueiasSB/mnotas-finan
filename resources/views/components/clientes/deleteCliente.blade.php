<div>
    {{-- MODAL AVISO 1 --}}
    <div class="modal fade" id="aviso1" tabindex="-1" aria-labelledby="aviso1Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="aviso1Label">Excluir Cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Deseja excluir este cliente?
                </div>
                <div class="modal-footer "> 
                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Sair</button>
                    <button type="button" class="btn btn-danger text-white" data-bs-toggle="modal"
                        data-bs-target="#aviso2">Excluir</button>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL AVISO 2 --}}
    <div class="modal fade" id="aviso2" tabindex="-1" aria-labelledby="aviso2Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h1 class="modal-title fs-5 text-light" id="aviso2Label">Excluir Cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-danger">
                    <h4>
                        Ao excluir <b>{{ $cliente->nome }}</b> perderá todos os seus dados pessoais e histórico de
                        transações.
                    </h4>

                </div>
                <div class="modal-footer">
                    <h5 class="text-start">Você tem certeza disso?</h5>
                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Sair</button>
                    
                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger text-white">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
