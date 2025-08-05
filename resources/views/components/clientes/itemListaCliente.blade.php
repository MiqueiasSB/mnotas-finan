<x-caixa
    x-data="{ hover: false }"
    {{ $attributes }}
    class="mb-2"
    bodyClass="d-flex flex-row align-items-center flex-wrap align-content-between"
    x-on:click="window.location.href = '/clientes/{{ $cliente->id }}'"
    @mouseover="hover = true"
    @mouseout="hover = false"
    x-bind:class="{ 'bg-gray-300': hover }"
    style="cursor: pointer;">


   <div class="px-2 flex-fill fw-bold fs-5">
        <i x-bind:class="{ 'bi bi-person': !hover, 'bi bi-person-fill': hover }"></i>
        <span class="text-capitalize">{{ $cliente->nome }}</span>
   </div>

   <div class="p-2 flex-fill text-end">
     <small>
        <i class="bi bi-telephone-fill"></i>
        {{ $cliente->telefone }}
     </small>
   </div>

   <div class="px-2 flex-fill text-end">
        <small style="font-size: 70%">Última Atualização {{ $cliente->updated_at->format('d/m/Y H:i') }}</small>
   </div>
</x-caixa>
