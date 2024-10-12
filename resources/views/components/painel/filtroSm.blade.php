<div class="row justify-content-end pe-2 fixed-bottom z-3" style="margin-bottom: 5em !important;">
    <div class="col-4 text-end">
        <button class="btn btn-lg btn-primary " data-bs-toggle="modal" data-bs-target="#modalFiltro">
            <i class="display-6 bi bi-funnel-fill"></i>
        </button>
    </div>
   
</div>
 <!-- Modal -->
 <div wire:ignore.self  class="modal fade" id="modalFiltro" tabindex="-1" aria-labelledby="modalFiltroLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-body">
                <x-painel.filtro></x-painel.filtro>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>