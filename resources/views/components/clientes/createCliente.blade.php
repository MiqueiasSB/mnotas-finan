@extends('layouts.app')

@section('content')

    <x-tituloPagina label="Novo Cliente" icon="bi bi-person-fill-add"></x-tituloPagina>

    <x-caixa>

        <form id="formCreateCliente" method="POST" action="{{ route('clientes.store') }}">
            @csrf

            <div class="row gx-4 gy-md-2 gy-3">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif


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

                <div class="col-lg-7 ">
                    <div class="form-floating">
                        <input type="text" required class="form-control text-capitalize" value="{{ old('nome') }}" name="nome"
                            id="nome" placeholder="Digite seu nome">
                        <label for="nome">Nome</label>
                    </div>

                </div>

                <!-- Campo CPF -->
                <div class="col-lg-5">
                    <div class="form-floating">
                        <input type="text" class="form-control" onkeyup="applyCpfMask(event)" value="{{ old('cpf') }}"
                            id="cpf" name="cpf" placeholder="Digite seu CPF">
                        <label for="cpf">CPF</label>
                    </div>
                </div>

                <script>
                    function applyCpfMask(event) {
                        var input = event.target;
                        var cpf = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos

                        // Aplica a máscara do CPF (###.###.###-##)
                        cpf = cpf.replace(/^(\d{3})(\d)/, '$1.$2');
                        cpf = cpf.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
                        cpf = cpf.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');

                        input.value = cpf;
                    }
                </script>

                <!-- Campo Telefone -->
                <div class="col-lg-4">
                    <div class="form-floating">
                        <input type="tel" onkeyup="handlePhone(event)" required value="{{ old('telefone') }}"
                            class="form-control" id="telefone" name="telefone" placeholder="Digite seu telefone">
                        <label for="telefone">Telefone</label>
                    </div>
                </div>

                <script>
                    const handlePhone = (event) => {
                        let input = event.target
                        input.value = phoneMask(input.value)
                    }

                    const phoneMask = (value) => {
                        if (!value) return ""
                        value = value.replace(/\D/g, '')
                        value = value.replace(/(\d{2})(\d)/, "($1) $2")
                        value = value.replace(/(\d)(\d{4})$/, "$1-$2")
                        return value
                    }
                </script>

                <!-- Campo Endereço -->
                <div class="col-lg-8">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="endereco" value="{{ old('endereco') }}"
                            name="endereco" placeholder="Digite seu endereço">
                        <label for="endereco">Endereço</label>
                    </div>
                </div>

                <!-- Campo Descrição -->
                <div class="col">
                    <div class="form-floating">
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Digite uma descrição">{{ old('descricao') }}</textarea>
                        <label for="descricao">Descrição</label>
                    </div>
                </div>
            </div>
        </form>


        <div class="row align-items-center justify-content-end mt-3">

            <div class="col-md-4 col-12 text-end">
                <button type="submit" form="formCreateCliente"
                    class="w-100 btn btn-lg btn-success text-white fw-bold">Salvar <i class="bi bi-check-lg"></i>
                </button>
            </div>

        </div>
    </x-caixa>

@endsection
