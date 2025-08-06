<div x-data="{
    categoriaSelecionada: @entangle('categoriaSelecionada'),
    tipoSelecionado: @entangle('tipoSelecionado'),
    topCategorias: @entangle('topCategorias'),
}" class="d-flex flex-column gap-3">

    <!-- Hidden inputs para envio Livewire -->
    <input type="hidden" wire:model="tipoSelecionado">
    <input type="hidden" wire:model="categoriaSelecionada">

   <div class="btn-group btn-group-lg w-100" role="group">
    <!-- Receita -->
    <button type="button"
        class="btn py-4"
        :class="{
            'btn-success': tipoSelecionado === 0,
            'btn-outline-success': tipoSelecionado !== 0,
            'fw-bold text-white': tipoSelecionado === 0
        }"
        x-on:click="
            tipoSelecionado = 0;
            categoriaSelecionada = topCategorias[0][0];
        ">
        <i :class="topCategorias[0][1]" class="me-1"></i>
        <span class="h5" x-text="topCategorias[0][0]"></span>
    </button>

    <!-- Despesa (somente se NÃO existir um 3º botão) -->
    <template x-if="!topCategorias[2]">
        <button type="button"
            class="btn py-4 rounded-end"
            :class="{
                'btn-danger': tipoSelecionado === 1,
                'btn-outline-danger': tipoSelecionado !== 1,
                'fw-bold text-white': tipoSelecionado === 1
            }"
            x-on:click="
                tipoSelecionado = 1;
                categoriaSelecionada = topCategorias[1][0];
            ">
            <i :class="topCategorias[1][1]" class="me-1"></i>
            <span class="h5" x-text="topCategorias[1][0]"></span>
        </button>
    </template>

    <!-- A Receber (se existir) -->
    <template x-if="topCategorias[2]">
        <button type="button"
            class="btn py-4 rounded-end"
            :class="{
                'btn-secondary': tipoSelecionado === 2,
                'btn-outline-secondary': tipoSelecionado !== 2,
                'fw-bold text-white': tipoSelecionado === 2
            }"
            x-on:click="
                tipoSelecionado = 2;
                categoriaSelecionada = topCategorias[2][0];
            ">
            <i :class="topCategorias[2][1]" class="me-1"></i>
            <span class="h5" x-text="topCategorias[2][0]"></span>
        </button>
    </template>
</div>



    <!-- Select de categorias associadas -->
    @php
    $categoriasValidas = $this->categorias->filter(fn($cat) => !in_array($cat->id, [1,2,3]));
    @endphp

    <template x-if="
        [
            @foreach ($categoriasValidas as $cat)
                '{{ $cat->tipo }}',
            @endforeach
        ].includes(topCategorias[tipoSelecionado][0])
    ">
        <div class="mb-3">
            <label class="form-label">Categoria (opcional)</label>
            <select class="form-select form-select-lg text-capitalize"
                x-on:change="categoriaSelecionada = $event.target.value">

                <option value="">-----</option>

                @foreach ($categoriasValidas as $categoria)
                <template x-if="topCategorias[tipoSelecionado][0] === '{{ $categoria->tipo }}'">
                    <option class="text-capitalize" value="{{ $categoria->nome }}">
                        {{ $loop->iteration }}. {{ $categoria->nome }}
                    </option>
                </template>
                @endforeach

            </select>
        </div>
    </template>
</div>
