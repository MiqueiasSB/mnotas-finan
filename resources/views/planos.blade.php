@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="container">
            <h1 class="fw-bold ">Planos MNotas</h1>
            <h5 class="mb-4"><i>Você tem direito á <b> 30 dias grátis</b> em qualter plano!</i> </h5>
            <div class="row gy-3">
                @foreach ($plans as $plan)
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body h-100">
                                <div class="mb-5">
                                    <h5 class="card-title fw-bold">{{ $plan['name'] }}</h5>
                                    <small style="font-size: 90%"><i>{{ $plan['descricao'] }}</i></small>
                                </div>


                                @php
                                    // Separa o preço em inteiro e decimal para tratar no layoute
                                    [$inteiro, $decimal] = explode(
                                        ',',
                                        number_format($plan['equivalente_mensal'], 2, ',', '.'),
                                    );
                                @endphp 

                                @if ($plan['price'] != $plan['equivalente_mensal'])
                                    <small>Valor equivalente mensal</small>
                                    
                                @else
                                    <small>Seu plano com pagamento mês a mês!</small>
                                @endif
                                <br>

                                <span>R$</span>
                                <span class="display-2"><b>{{ $inteiro }}</b></span>
                                <b>,{{ $decimal }}/mês*</b>
                                <br>

                                @if ($plan['price'] != $plan['equivalente_mensal'])
                                    <span>Total: R${{ number_format($plan['price'], 2, ',', '.') }}</span>
                                @endif

                                <div class="text-end">
                                    <i class="text-danger">{{ $plan['desconto'] }}</i>
                                </div>


                            </div>
                            <div class="position-relative mt-5 mb-2 ms-2">
                                <form method="POST" action="{{ route('checkout') }}">
                                    @csrf
                                    <input type="hidden" name="plan" value="{{ $plan['id'] }}">
                                    <button type="submit"
                                        class="btn btn-primary position-absolute bottom-0">Assinar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>




    </div>
@endsection
