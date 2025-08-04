@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-center mt-sm-5" style="height: 80vh;">
        <div class="row justify-content-center w-100">
            <div class="col-md-12 col-sm-10 col-12 ">
                <x-caixa bodyClass="row mx-1" >
                    <div class="col m-auto" >
                       {{ $slot }}
                    </div>
                    <div style="height:85vh" class="col d-md-block d-none ">
                        <img class="w-100 h-100 rounded rounded-4" src="{{ asset('img/devices.png') }}" alt="devices {{ config('app.name') }}">
                    </div>
                </x-caixa>
            </div>
        </div>
    </div>
</div>
@endsection
