<button class="btn btn-light position-relative" data-bs-toggle="modal" data-bs-target="#modalFiltroTipo">
    <i class="bi-filter fs-3"></i>
    @if ($this->filtro != $this->filtroModelo)
        <span
            class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">New alerts</span>
        </span>
    @endif

</button>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="modalFiltroTipo" tabindex="-1" aria-labelledby="modalFiltroTipoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="mb-0">Fitrar por:</h4>
                <button id="btnModalTransacaoSm" type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <h4>Categorias</h4>
                @foreach (['Receita', 'Despesa'] as $tipo)
                <div class="pt-2 ps-3" wire:key="{{ $tipo }}">
                    {{-- Check TIPO Principal --}}
                    <div class="form-check fs-5">
                        <input class="form-check-input" type="checkbox" id="check{{ $tipo }}"
                            @change="
                                document.querySelectorAll('.check-filho-{{ $tipo }}').forEach(el => {
                                    if (el.checked !== $event.target.checked) {
                                        el.click(); // Simula o clique nos filhos
                                    }
                                })
                            "
                            wire:model.live="filtro.tipo.{{ $tipo }}.status"
                            x-ref="checkPai{{ $tipo }}">
                        <label class="form-check-label" for="check{{ $tipo }}">
                            {{ 'Todas as ' . $tipo . 's' }}
                        </label>
                    </div>
            
                    {{-- Categoria Genérica em destaque --}}
                    <div class="form-check ms-5">
                        <input class="form-check-input check-filho-{{ $tipo }}" type="checkbox"
                            id="check{{ $tipo }}SemCategoria"
                            wire:model.live="filtro.tipo.{{ $tipo }}.categorias.{{ $this->idsTipoSemCategorias[$tipo] }}.status"
                            wire:ignore
                            @change="
                                if ($event.target.checked) { 
                                    $refs.checkPai{{ $tipo }}.checked = true; 
                                    $refs.checkPai{{ $tipo }}._skip = true; 
                                } else {
                                    let allUnchecked = [...document.querySelectorAll('.check-filho-{{ $tipo }}')].every(el => !el.checked);
                                    if (allUnchecked) {
                                        $refs.checkPai{{ $tipo }}.checked = false; 
                                    }
                                }
                            ">
                        <label class="form-check-label" for="check{{ $tipo }}SemCategoria">
                            {{ $tipo . 's sem categorias' }}
                        </label>
                    </div>
            
                    {{-- Lista checks para categorias específicas --}}
                    @foreach ($this->filtro['tipo'][$tipo]['categorias'] as $key => $categoria)
                        @if ($categoria['id'] != 1 && $categoria['id'] != 2)
                            <div class="form-check ms-5" wire:key="{{ 'check_'.$key }}">
                                <input class="form-check-input check-filho-{{ $tipo }}" type="checkbox"
                                    id="check{{ $categoria['nome'] }}"
                                    wire:model.live="filtro.tipo.{{ $tipo }}.categorias.{{ $key }}.status"
                                    wire:ignore
                                    @change="
                                        if ($event.target.checked) { 
                                            $refs.checkPai{{ $tipo }}.checked = true; 
                                            $refs.checkPai{{ $tipo }}._skip = true; 
                                        } else {
                                            let allUnchecked = [...document.querySelectorAll('.check-filho-{{ $tipo }}')].every(el => !el.checked);
                                            if (allUnchecked) {
                                                $refs.checkPai{{ $tipo }}.checked = false; 
                                            }
                                        }
                                    ">
                                <label class="form-check-label" for="check{{ $categoria['nome'] }}">
                                    {{ $categoria['nome'] }}
                                </label>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
            
            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('toggleChecks', () => ({
                        init() {
                            this.$watch('$store.livewire', () => {
                                this.setupListeners();
                            });
                        },
                        setupListeners() {
                            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                                checkbox.addEventListener('change', (event) => {
                                    // Skip if marked to avoid recursion
                                    if (event.target._skip) {
                                        event.target._skip = false;
                                        return;
                                    }
                                });
                            });
                        }
                    }));
                });
            </script>
            


            </div>
            <div class="modal-footer">
                @if ($this->filtro != $this->filtroModelo)
                    <button type="button" class="btn btn-secondary" wire:click="limparFiltro">
                        Limpar Filtro
                    </button>
                @endif
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
