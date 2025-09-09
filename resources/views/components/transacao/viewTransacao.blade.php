<!-- Button trigger modal -->
<div wire:ignore.self class="modal fade" id="viewTransacao" tabindex="-1" aria-labelledby="viewTransacaoLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" x-on:click.away="view = false">
        <div class="modal-content">
            <div class="modal-header">

                <h1 class=" modal-title fs-5 text-capitalize" id="viewTransacaoLabel">
                    {{ $this->transacao->item ?? '' }}
                </h1>
                <button id="fecharViewModal"  x-on:click="view = !view" type="button" wire:click="limparModal()" class=" text-end btn-close"
                    data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body row g-4">

                <div class="col-12">
                    <x-transacao.formCreate></x-transacao.formCreate>
                </div>

                <div class="col-sm-6 fw-bold text-sm-start text-center">
                    <span> Valor Total: R$
                        {{ number_format(($this->transacao->valor ?? 0) * ($this->transacao->quantidade ?? 0), 2, ',', '.') }}
                    </span>
                </div>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-danger text-white" wire:click="destroy()">Deletar</button>
                <button type="button" class="btn btn-info text-white" wire:click="up()">Atualizar</button>
            </div>
        </div>
    </div>


    @script
        <script>
            $wire.on('fecharViewModal', () => {
                $('#fecharViewModal').click()
                $('.btnPlus').removeClass('d-none')
            })
        </script>
    @endscript
</div>
