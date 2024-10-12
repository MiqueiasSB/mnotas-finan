@extends('layouts.email')

@section('content')
    <div class="row justify-content-center text-center gy-3">
        <div class="col-10">
            <h1 class="mb-0 logo text-primary">
                {{ config('app.name', 'MNOTAS') }}
            </h1>
        </div>

        <div class="col-sm-6 col-11">
            <a href="{{ $url }}" class="w-100 fw-bold btn btn-lg btn-primary">Verificar E-mail</a>
        </div>

        <div class="col-sm-10 col-11">
            <p>Click em verificar e-mail para confirmar seu cadastro na plataforma <strong>MNOTAS</strong>!
                <br>
                <small class="text-warning">Se não foi você que realizou o cadastro, apenas desconsidere este e-mail</small>
            </p>
        </div>
    </div>
@endsection
