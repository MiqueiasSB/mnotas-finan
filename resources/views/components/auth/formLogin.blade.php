<div class=" my-md-0 my-5 mx-md-5 px-md-5">
    <h1 class="mb-5 display-4 fw-bold">{{ __('Entrar') }}</h1>

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

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                    id="floatinEmail" placeholder="name@example.com" value="{{ old('email') }}" required
                    autocomplete="email" name="email" autofocus>
                <label for="floatinEmail">{{ __('Email') }}</label>
            </div>
        </div>

        <div class="mb-3">
            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                    id="floatinpassword" placeholder="Senha" required
                    autocomplete="current-password" name="password">
                <label for="floatinpassword">{{ __('Senha') }}</label>
            </div>
        </div>

        <div class="row justify-content-between mt-3">
            <div class="col-md-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Lembrar-me') }}
                    </label>
                </div>
            </div>
            <div class="col-md-7 text-end mt-sm-0 mt-5">
                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
                @endif
                <button type="submit" class="btn btn-primary text-white">
                    {{ __('Entrar') }}
                </button>
            </div>
        </div>
    </form>
</div>
