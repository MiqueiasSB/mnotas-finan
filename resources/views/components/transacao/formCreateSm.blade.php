<div>
    <div class="row justify-content-end pe-2 fixed-bottom z-3" style="margin-bottom: 5em !important;">
        <div class="col-4 text-end">
            <button class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#modalFiltro">
                <i class="display-6 bi bi-plus-lg"></i>
            </button>
        </div>



    </div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modalFiltro" tabindex="-1" aria-labelledby="modalFiltroLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="mb-0">Nova Transação</h4>
                    <button id="btnModalTransacaoSm" type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-transacao.formCreate></x-transacao.formCreate>
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
