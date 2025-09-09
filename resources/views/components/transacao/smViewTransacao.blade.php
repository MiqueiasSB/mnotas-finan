<!-- Button trigger modal -->
<div wire:ignore.self class="modal fade" id="smViewTransacao" tabindex="-1" aria-labelledby="smViewTransacaoLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" x-on:click.away="view = false">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class=" modal-title fs-5 text-capitalize" id="smViewTransacaoLabel">
                    Editar Transação
                </h1>
                <button id="smFecharViewModal" x-on:click="view = !view" type="button" wire:click="limparModal()" class=" text-end btn-close"
                    data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body row g-4">

                <!-- Formulário completo -->
                <div class="col-12">
                    <form wire:submit.prevent="save" id="saveTransaction" x-data="{ tipoSelecionado: @entangle('tipoSelecionado') }">
                        <div class="d-flex flex-column gap-4">

                            <!-- Item -->
                            <div>
                                <label for="inputItem" class="form-label">Item</label>
                                <input id="inputItem" required type="text"
                                    class="form-control form-control-lg py-4 fw-semibold fs-2 text-capitalize @error('item') is-invalid @enderror"
                                    placeholder="Descrição do item"
                                    wire:model="item">
                                @error('item')
                                <span class="display-2 invalid-feedback">Descrição Obrigatória</span>
                                @enderror
                            </div>

                            <!-- Quantidade e Valor -->
                            <div class="d-flex gap-3">
                                {{-- Quantidade --}}
                                <div class="flex-fill">
                                    <label for="inputQuantidade" class="form-label">Quantidade</label>
                                    <input id="inputQuantidade"
                                        type="number"
                                        class="form-control form-control-lg py-4 fs-1 fw-semibold @error('quantidade') is-invalid @enderror"
                                        wire:model.live="quantidade">
                                    @error('quantidade')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Valor --}}
                                <div class="flex-fill" x-data="app">
                                    <label for="inputValor" class="form-label">Valor (R$)</label>
                                    <div class="input-group">
                                        <input id="inputValor"
                                            x-mask:dynamic="$money($input, ',', '.')"
                                            placeholder="0,00"
                                            required
                                            type="text"
                                            wire:model.live="valor"
                                            class="form-control form-control-lg py-4 fs-1 fw-semibold @error('valor') is-invalid @enderror">
                                        @error('valor')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Valor Total Dinâmico -->
                            @if ($this->quantidade>1)
                            <div class="d-flez my-3">
                                Valor Total: R$
                                <span class="fw-bold fs-5">
                                    @php
                                    $valorFloat = floatval(str_replace(',', '.', str_replace('.', '', $this->valor ?? '0')));
                                    $quantidade = $this->quantidade ?? 0;
                                    $total = $valorFloat * $quantidade;
                                    @endphp
                                    {{ number_format($total, 2, ',', '.') }}
                                </span>
                            </div>
                            @endif

                            <!-- Categoria -->
                            <div class="my-3">
                                <label class="form-label fw-bold">Tipo</label>
                                <x-transacao.smSelectCategoria />
                            </div>

                            <!-- Forma de Pagamento -->
                            <div>
                                <label class="form-label">Forma de Pagamento</label>
                                <x-smSelectFormaPagamento />
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Valor Total e Datas -->
                <div class="col-sm-6 text-end">
                    <small>
                        Dia Definído:
                        {{ !is_null($this->transacao) ? (new DateTime($this->transacao->data))->format('d/m/Y') : '' }}
                    </small>
                    <br>
                    <small>
                        Data de Criação:
                        {{ !is_null($this->transacao) ? $this->transacao->created_at->format('d/m/Y H:i:s') : '' }}
                    </small>
                    @if (!is_null($this->transacao))
                    @if ($this->transacao->updated_at != $this->transacao->created_at)
                    <br>
                    <small>
                        Última Atualização:
                        {{ !is_null($this->transacao) ? $this->transacao->updated_at->format('d/m/Y H:i:s') : '' }}
                    </small>
                    @endif
                    @endif
                </div>
            </div>

            <div class="modal-footer row z-3 p-0">
                <div class="btn-group m-0 p-0" role="group" aria-label="Basic example">
                    <button wire:click="destroy()"
                        class="btn btn-lg btn-light w-100 fw-bold py-4 rounded-0">
                        Cancelar
                    </button>
                    <button type="submit" form="saveTransaction"
                        wire:click="up()"
                        class="btn btn-lg btn-info w-100 fw-bold py-4 rounded-0">
                        Atualizar
                    </button>
                </div>
            </div>
        </div>
    </div>


    @script
    <script>
        $wire.on('fecharViewModal', () => {
            $('#fecharViewModal').click()
            $('#smFecharViewModal').click()
            $('.btnPlus').removeClass('d-none')
        })
    </script>
    @endscript
</div>
