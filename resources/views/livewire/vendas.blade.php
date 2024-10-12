<div>
    <x-caixa class="mb-3">
        <x-vendas.graficoVenda></x-vendas.graficoVenda>
    </x-caixa>
  
    <x-vendas.somaVendas></x-vendas.somaVendas>
    
    <livewire:transacoes :dataAtual="$dataAtual"></livewire:transacoes>

</div>
