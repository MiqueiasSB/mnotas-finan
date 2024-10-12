@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">

        <x-tituloPagina label="Painel" icon="bi bi-grid-1x2-fill"></x-tituloPagina>

        <livewire:painel></livewire:painel>

    </div>
@endsection
