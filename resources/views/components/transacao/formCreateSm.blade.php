<div>
    <!-- Botão flutuante -->
    <div class="row justify-content-end pe-4 fixed-bottom z-3" style="margin-bottom: 5em !important;">
        <button class="btn btn-lg btn-primary rounded-circle shadow shadow-lg" data-bs-toggle="modal" data-bs-target="#modalFiltro" style="width: 60px; height: 60px;">
            <i class="bi bi-plus-lg fs-3"></i>
        </button>
    </div>

    <!-- Modal de Nova Transação -->
    <div wire:ignore.self class="modal fade" id="modalFiltro" tabindex="-1" aria-labelledby="modalFiltroLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <!-- Cabeçalho -->
                <div class="modal-header">
                    <h4 class="fw-bold mb-0">Nova Transação</h4>
                    <button id="btnModalTransacaoSm" type="button" class="btn-close btn btn-lg" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Corpo do Modal -->
                <div class="modal-body">
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
                                        {{-- --}}
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
                            @if ($this->quantidade>1)
                            <div class="d-flez my-3">
                                Valor Total: R$
                                <span class="fw-bold fs-5">
                                    @php
                                    // Converte o valor formatado para float
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

                <div class="modal-footer row z-3 p-0">
                    <div class="btn-group m-0 p-0" role="group" aria-label="Basic example">
                        <button data-bs-dismiss="modal" aria-label="Close"
                            class="btn btn-lg btn-light w-100 fw-bold py-4 rounded-0">
                            Cancelar
                        </button>
                        <button type="submit" form="saveTransaction"
                            @if (!Auth::user()->subscription('default')) disabled @endif
                            class="btn btn-lg btn-primary w-100 fw-bold py-4 rounded-0">
                            Salvar
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('fecharFormModal', () => {
            $('#btnModalTransacaoSm').click()
        })
    </script>
    @endscript
</div>


<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('app', () => ({
            valorInput: '',
            valorFormatado: '0,00',

            formatarValor() {
                // Remove todos os caracteres que não sejam números
                let valorNumerico = this.valorInput.replace(/[^\d]/g, '');

                // Garante que temos pelo menos '00' para os centavos
                valorNumerico = valorNumerico.padStart(3, '0');

                // Separa reais e centavos
                const centavos = valorNumerico.slice(-2);
                const reais = valorNumerico.slice(0, -2) || '0';

                // Formata com separadores de milhar
                const reaisFormatados = reais.replace(/^0+/, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');

                // Atualiza o valor formatado
                this.valorFormatado = `${reaisFormatados || '0'},${centavos}`;
                this.valorInput = this.valorFormatado;
            }
        }))
    });
</script>
