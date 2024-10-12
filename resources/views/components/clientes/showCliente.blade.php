@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <x-caixa>
                <x-clientes.dadosCliente :cliente="$cliente"></x-clientes.dadosCliente>
            </x-caixa>

           

            <livewire:Transacoes :cliente="$cliente"></livewire:Transacoes>

        </div>
    </div>
@endsection
