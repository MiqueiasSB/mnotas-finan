<div x-data="{ view: false }">

    @if (!empty($this->cliente))
        <x-caixa class="mt-3">
            <h5 class="m-0 fw-bold">
                Dívida Total: R$ {{ number_format($this->dividaTotal, 2, ',', '.') }}
            </h5>
        </x-caixa>
    @endif 

   
    <x-caixa loading="true" class="mt-4">


        <x-slot name="header">
            <div class="d-none d-sm-block">
                
                <x-transacao.formCreate></x-transacao.formCreate>
            </div>

            <div class="d-block d-sm-none">
                <x-transacao.formCreateSm></x-transacao.formCreateSm>
            </div>
        </x-slot>



        <x-transacao.indexTransacao></x-transacao.indexTransacao>

    </x-caixa>

</div>
