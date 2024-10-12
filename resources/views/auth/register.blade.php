@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-10 col-12">
                <x-caixa>
                    <header>
                        <h1 class="mb-5 fw-bold">{{ __('Cadastro') }}</h1>
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

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class=" mb-3">

                            <div class="form-floating mb-3">
                                <input type="name" class="form-control  @error('name') is-invalid @enderror"
                                    id="floatinname" name="name" value="{{ old('name') }}" required autocomplete="name"
                                    autofocus>
                                <label for="floatinname">{{ __('Nome') }}</label>
                            </div>

                        </div>

                        <div class="mb-3">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                    id="floatinemail" value="{{ old('email') }}" required autocomplete="email"
                                    name="email" autofocus>
                                <label for="floatinemail">{{ __('E-mail') }}</label>
                            </div>
 
                        </div>

                        <div class="mb-3">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control  @error('password') is-invalid @enderror"
                                    id="floatinpassword" value="{{ old('password') }}" required autocomplete="new-password"
                                    name="password" autofocus>
                                <label for="floatinpassword">{{ __('Senha') }}</label>
                            </div>

                        </div>

                        <div class=" mb-3">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control  @error('password-confirm') is-invalid @enderror"
                                    id="floatinpassword-confirm" value="{{ old('password-confirm') }}" required
                                    autocomplete="new-password" name="password_confirmation" autofocus>
                                <label for="floatinpassword-confirm">{{ __('Confirme sua Senha') }}</label>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" required name="terms_accepted" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">
                                Eu concordo com os <a href="{{ route('termos') }}" target="_blank">Termos de Serviço</a> e <a href="{{ route('politicas') }}" target="_blank">Políticas de Privacidade</a>.
                            </label>
                          </div>

                        <div class="row text-end mb-0 mt-5">
                            <div class="col">
                                <button type="submit" class="btn btn-primary text-light">
                                    {{ __('Cadastrar-se') }}
                                </button>
    
                            </div>
                           
                        </div>
                    </form>
                </x-caixa>




            </div>
        </div>
    </div>
@endsection
