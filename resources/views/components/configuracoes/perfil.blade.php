<x-caixa>
    <div class="row">

        <div class="col-12 mb-3">
            <h4><i class="bi bi-person-circle"></i> Perfil de Usuário</h4>
        </div>


        <div class="col-12">
           
                <label for="userName">Nome</label>
                <input id="userName" required type="text" class="form-control" wire:model="userName">
          
        </div>


        <form method="POST" id="formPassword" action="{{ route('password.email') }}">
            @csrf

            <div class="row mt-3">

                <label for="email" class="">{{ __('Email') }}</label>

                <div class="">
                    <input id="email" type="email" readonly
                        class=" form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ $this->user->email }}" autocomplete="email">

                    <button type="submit" for="formPassword" class="mt-2 w-100 btn btn-primary text-white">
                        {{ __('Enviar link de redefinição de senha') }}
                    </button>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    @if (session('status'))
                        <div class="alert alert-success mt-2" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>


            </div>

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">

                </div>
            </div>
        </form>

    </div>
</x-caixa>
