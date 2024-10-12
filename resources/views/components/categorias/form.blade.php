<form wire:submit="save()" x-data="{ classAtiva: 'success' }">
    <div class="row rounded border px-1 py-3 gy-md-0 gy-2 mt-0" :class="' border-' + classAtiva">
        @if ($errors->any())
            <div class="col-12">
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <div class="col-lg-2 col-md-3 order-md-1 order-2">
            <select wire:model="tipo" class="form-select text-light" :class="'bg-' + classAtiva" x-model="classAtiva">
                @foreach ($this->tipos as $key => $tipo)
                    <option value="{{ $this->cores[$key] }}">{{ $tipo }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-8 col-md-6 order-md-2 order-1">
            <input required type="text" wire:model="nome" class="form-control text-capitalize"
                id="exampleFormControlInput1" placeholder="Nome da Categoria">
        </div>

        <div class="col-lg-2 col-md-3 order-md-3 order-3">
            <button type="submit" @if (!Auth::user()->subscription('default')) disabled @endif
                class="w-100 btn text-light mt-md-0 mt-3" :class="' btn-' + classAtiva">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>

    </div>

</form>
