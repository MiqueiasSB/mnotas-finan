@extends('layouts.email')

@section('content')
    <div class="row justify-content-center text-center gy-3">
        <div class="col-10">
            <h1 class="mb-0 logo text-primary">
                {{ config('app.name', 'MNOTAS') }}
            </h1>
        </div>

        <div class="col-6">
            <a href="{{ $url }}" class="w-100 fw-bold btn btn-lg btn-primary">Redefnir Senha</a>
        </div>

        <div class="col-10">
            <p>Click para redefinir sua senha na plataforma <strong>MNOTAS</strong>!
                <br>
                <small class="text-warning">Se não foi você que solicitou apenas desconsidere este e-mail</small>
            </p>
        </div>
    </div>
@endsection
