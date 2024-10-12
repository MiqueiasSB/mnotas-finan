<div>
    <div class="row gy-md-2 gy-3">
        <div class="col-12">
            <div class="row justify-content-between align-items-center mb-3">
                <div class="col">
                    <h1><i class="bi bi-gear-fill"></i> Configurações</h1>
                </div>
                <div class="col-12 col-md-3 col-lg-2 text-end mt-3 mt-md-0" x-data="{salvo: false}">
                    <button id="btnSalvar" type="submit" wire:click="save()" class="btn btn-primary w-100 w-md-auto"
                        x-bind:disabled="salvo" 
                        @click="salvo = true; setTimeout(() => salvo = false, 2500)">
                        <div x-show="!salvo"> Salvar</div>
                        <div x-show="salvo"> Salvo <i class="bi bi-check-lg"></i></div>
                    </button>
                </div>
            </div>
        </div>
    
        <div class="col-lg-8 col-md-7">
            <x-configuracoes.perfil></x-configuracoes.perfil>
        </div>
    
        <div class="col-lg-4 col-md-5">
            <x-configuracoes.horaDeTrabalho></x-configuracoes.horaDeTrabalho>
        </div>
    
        <div class="col-12">
            <x-configuracoes.statusPlano></x-configuracoes.statusPlano>
        </div>

        <div class="col-12 text-end">
            <a href="{{ route('politicas') }}" class="pe-4">Politicas de Privacidade</a>
            <a href="{{ route('termos') }}">Termos</a>
        </div>
    
    </div>
     
</div>
