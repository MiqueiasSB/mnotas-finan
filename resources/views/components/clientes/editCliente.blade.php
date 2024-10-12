@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <x-caixa>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row align-items-center justify-content-between">

                <div class="col">
                    <h1><i class="bi bi-person-fill-gear"></i> Editar cliente</h1>
                </div>
                <div class="col text-end">
                    <button type="submit" form="formCreateCliente" class="btn btn-lg btn-primary text-white fw-bold">Salvar <i
                            class="bi bi-check-lg"></i>
                    </button> 
                </div>

            </div>


            <form id="formCreateCliente" method="POST"
                action="{{ route('clientes.update', ['cliente' => $cliente->id]) }}">
                @method('PUT')
                @csrf

                <div class="row gx-4 gy-2">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="col-lg-7 form-group">
                        <label for="nome">Nome</label>
                        <input type="text" required class="form-control" value="{{ $cliente->nome }}" name="nome"
                            id="nome" placeholder="Digite seu nome">
                    </div>

                    <!-- Campo CPF -->
                    <div class="col-lg-5 form-group" x-data="{ cpf: '' }">
                        <label for="cpf">CPF</label>
                        <input type="text" class="form-control" value="{{ $cliente->cpf }}" x-on:keyup="applyCpfMask"
                            id="cpf" name="cpf" placeholder="Digite seu CPF">
                    </div>

                    <script>
                        function applyCpfMask() {
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
                    <div class="col-lg-4 form-group">
                        <label for="telefone">Telefone</label>
                        <input type="tel" onkeyup="handlePhone(event)" value="{{ $cliente->telefone }}" required
                            class="form-control" id="telefone" name="telefone" placeholder="Digite seu telefone">
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
                    <!-- Campo Telefone -->
                    <div class="col-lg-8 form-group">
                        <label for="endereco">Endereço</label>
                        <input type="text" value="{{ $cliente->endereco }}" class="form-control" id="endereco"
                            name="endereco" placeholder="Digite seu endereco">
                    </div>

                    <!-- Campo Descrição -->
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Digite uma descrição">{{ $cliente->descricao }}</textarea>
                    </div>
                </div>

            </form>

        </x-caixa>
    </div>
@endsection
