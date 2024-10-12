@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8 col-sm-10 col-12">
                <x-caixa>
                    <header>
                        <h1 class="mb-5 fw-bold">{{ __('Entrar') }}</h1>
                    </header>
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

                        <div class=" mb-3">

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                    id="floatinEmail" placeholder="name@example.com" value="{{ old('email') }}" required
                                    autocomplete="email" name="email" autofocus>
                                <label for="floatinEmail">{{ __('Email') }}</label>
                            </div>
                        </div>

                        <div class="mb-3">


                            <div class="form-floating mb-3">
                                <input type="password" class="form-control  @error('password') is-invalid @enderror"
                                    id="floatinpassword" placeholder="name@example.com" value="{{ old('password') }}"
                                    required autocomplete="current-password" name="password" autofocus>
                                <label for="floatinpassword">{{ __('Senha') }}</label>
                            </div>


                        </div>

                        <div class="row justify-content-betwen mt-3">
    
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
                </x-caixa>
            </div>


        </div>
    </div>
@endsection
