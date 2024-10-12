@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">

        <x-tituloPagina label="Transações" icon="bi bi-arrow-left-right"></x-tituloPagina>

        <livewire:vendas></livewire:vendas>

    </div>
@endsection
