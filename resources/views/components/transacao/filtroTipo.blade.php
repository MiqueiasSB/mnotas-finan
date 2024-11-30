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
                    <div class="pt-2 ps-3" wire:key="{{ $tipo }}" x-data="{
                        isParentChecked: @entangle('filtro.tipo.' . $tipo . '.status').live,
                    }">
                        {{-- Check TIPO Principal --}}
                        <div class="form-check fs-5">
                            <input class="form-check-input" type="checkbox" id="check{{ $tipo }}"
                                wire:model.live="filtro.tipo.{{ $tipo }}.status"
                                @change="document.querySelectorAll('.check-filho-{{ $tipo }}').forEach(el => el.disabled = !$event.target.checked)"
                                x-bind:checked="isParentChecked">
                            <label class="form-check-label" for="check{{ $tipo }}">
                                {{ 'Todas as ' . $tipo . 's' }}
                            </label>
                        </div>

                        {{-- Categoria Genérica em destaque --}}
                        <div class="form-check ms-5">
                            <input class="form-check-input check-filho-{{ $tipo }}" type="checkbox"
                                id="check{{ $tipo }}SemCategoria"
                                wire:model.live="filtro.tipo.{{ $tipo }}.categorias.{{ $this->idsTipoSemCategorias[$tipo] }}.status"
                                wire:ignore :disabled="!isParentChecked">
                            <label class="form-check-label" for="check{{ $tipo }}SemCategoria">
                                {{ $tipo . 's sem categorias' }}
                            </label>
                        </div>

                        {{-- Lista checks para categorias específicas --}}
                        @foreach ($this->filtro['tipo'][$tipo]['categorias'] as $key => $categoria)
                            @if ($categoria['id'] != 1 && $categoria['id'] != 2)
                                <div class="form-check ms-5" wire:key="{{ 'check_' . $key }}">
                                    <input class="form-check-input check-filho-{{ $tipo }}" type="checkbox"
                                        id="check{{ $categoria['nome'] }}"
                                        wire:model.live="filtro.tipo.{{ $tipo }}.categorias.{{ $key }}.status"
                                        wire:ignore :disabled="!isParentChecked">
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
                                // Set the initial state of the checkboxes based on the parent checkbox
                                document.querySelectorAll('input[type="checkbox"]').forEach(el => {
                                    const parentCheckbox = el.closest('div').querySelector(
                                        '.form-check-input[type="checkbox"]');
                                    if (parentCheckbox && !parentCheckbox.checked) {
                                        el.disabled = true;
                                    }
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
