<div wire:ignore.self class="modal fade" id="modalCriarTrsc" tabindex="-1" aria-labelledby="modalCriarTrscLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCriarTrscLabel">Nova Transação</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body">
                <form id="formSave" wire:submit="save()">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error) 
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row gy-5">


                        <div class="col-12" x-data="{ opc: '1' }">
                            <div class="btn-group w-100 " role="group" aria-label="Basic example">
                                <button type="button" wire:click="$set('tipo', 0)"
                                    class="btn btn-danger text-white fw-bold"
                                    :class="{ 'opacity-25': {{ $this->tipo }} == '1' }">Compra <i
                                        class="bi bi-arrow-down-right"></i></button>
                                <button type="button" wire:click="$set('tipo', 1)"
                                    class="btn btn-success text-white fw-bold"
                                    :class="{ 'opacity-25': {{ $this->tipo }} == '0' }">Pagamento <i
                                        class="bi bi-arrow-up-right"></i></button>
                            </div>
                        </div>

                        @if (!$this->tipo)
                            {{-- Pra Compra --}}

                            <div class="row mt-5">


                                <div class="col-lg-2 form-group text-start">
                                    <label for="quantidade">Quantidade</label>
                                    <input type="number" required class="form-control" wire:model="quantidade"
                                        name="quantidade" id="quantidade">

                                </div>
                                <div class="col-lg-7 form-group text-start">
                                    <label for="item">Item</label>
                                    <input type="text" required class="form-control" wire:model="item" name="item"
                                        id="item" placeholder="Nome do item">

                                </div>

                                <div class="col-lg-3 form-group text-start">
                                    <label for="valor">Valor</label>
                                    <div class="input-group">
                                        <div class="input-group-text">R$</div>
                                        <input id="inputValor" placeholder="0,00" type="text" required class="form-control" wire:model="valor"
                                            name="valor">
                                    </div>
                                </div> 

                            </div>
                        @else{{-- Pra Pagamento --}}
                            <div class="row align-items-end mt-3">
                                <div class="col-lg-3 form-group text-start">
                                    <label for="valor">Valor</label>
                                    <div class="input-group">
                                        <div class="input-group-text">R$</div>
                                        <input type="text" required class="form-control" wire:model="valor"
                                        id="inputValor"  x-mask:dynamic="$money($input, ',', '.')" placeholder="0,00" name="valor" >
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <x-selectFormaPagamento></x-selectFormaPagamento>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="formSave" class="btn btn-success" wire:click="$refresh">Salvar</button>
                <button type="button" id="fecharModal" class="btn btn-secondary d-none"
                    data-bs-dismiss="modal">Close</button>

            </div>

        </div>
    </div>
</div>
 