@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">



                    <div class="card-header">{{ __('Verifique seu endereço de e-mail') }}</div>

                    <div class="card-body">



                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('Um novo link de verificação foi enviado para o seu endereço de e-mail.') }}
                            </div>
                        @endif

                        {{ __('Antes de prosseguir, verifique seu e-mail para obter um link de verificação.') }}
                        {{ __('Se você não recebeu o e-mail') }},
                        <form id="sendEmail" class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button for="sendEmail" type="submit" id="link-reenviar"
                                class="btn btn-link p-0 m-0 align-baseline">{{ __('clique aqui para solicitar outro') }}</button>.
                        </form>

                        @if (session('resend'))
                            <script>
                                document.getElementById('sendEmail').submit();
                            </script>
                        @endif

                        <form id="formAtualizaEmail" method="POST" action="{{ route('upEmail') }}">
                            @csrf
                            @method('PUT')
                            <div class="row gy-3 mt-4">
                                <div class="col-md-8">
                                    <input name="novoEmail" class="form-control @error('novoEmail') is-invalid @enderror"
                                        type="email" value="{{ Auth::user()->email }}">
                                    @error('novoEmail')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" for="formAtualizaEmail" class="btn btn-primary w-100"><i
                                            class="bi bi-pencil-fill"></i> Corrigir</button>
                                </div>
                            </div>

                            @if (session('resend'))
                                <div class="alert alert-success mt-3">
                                    {{ session('resend') }}
                                </div>
                            @endif

                            @if (count($errors) > 0)
                                <div class="alert alert-danger mt-3">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                        </form>


                        <script>
                            function cronometro() {
                                return {
                                    segundos: 60,
                                    start() {
                                        $('#link-reenviar').addClass('disabled');

                                        setInterval(() => {
                                            $('#link-reenviar').removeClass('disabled');

                                            if (this.segundos > 0) {
                                                this.segundos--;
                                            }
                                        }, 1000);
                                    }
                                }
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
