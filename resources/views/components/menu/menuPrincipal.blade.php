<div>
    <nav class="z-3 navbar navbar-expand-md bg-primary shadow">
        <div class="container">
            <a class="navbar-brand text-light logo pe-2" href="{{ url('/') }}">
                <x-icons.imgLogo largura="150"></x-icons.imgLogo>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                @auth
                    <ul class="navbar-nav me-auto">

                        @if (auth()->user()->hasVerifiedEmail())
                            <x-menu.linkMenu label="Painel" rota="painel"></x-menu.linkMenu>
                            <x-menu.linkMenu label="Transações" rota="vendas"></x-menu.linkMenu>
                            <x-menu.linkMenu label="Clientes" rota="clientes.index"></x-menu.linkMenu>
                            <x-menu.linkMenu label="Categorias" rota="categorias"></x-menu.linkMenu>

                            @if (!Auth::user()->subscription('default'))
                                <x-menu.linkMenu label="Planos" rota="planos"></x-menu.linkMenu>
                            @endif
                        @else
                            <x-menu.linkMenu label="Verifique seu e-mail" rota="verification.notice"></x-menu.linkMenu>
                        @endif
                    </ul>
                @endauth

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto ">
                    <!-- Authentication Links -->
                    @guest
                        <x-menu.linkMenu label="Entrar" rota="login"></x-menu.linkMenu>
                        {{--  <x-menu.linkMenu label="Cadastrar-se" rota="register"></x-menu.linkMenu> --}}
                        <x-menu.linkMenu label="Planos" rota="planos"></x-menu.linkMenu>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('configUser') }}">
                                    <i class="bi bi-gear-fill"></i> {{ __('Configurações') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <i class="bi bi-x-lg"></i> {{ __('Sair') }}
                                </a>



                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

 
    @if (Auth::check())
        @if (is_Null(Auth::user()->subscription('default')))
            <div class="container">
                <div class="bg-success-light rounded-bottom text-center py-2">
                    <a class="text-underline-none text-light fw-bold" style="text-decoration: none"
                        href=" {{ route('planos') }}">
                        <i>Assine um plano para ter acesso á toda a plataforma!</i>
                    </a>
                </div>
            </div>
        @elseif (Auth::user()->subscription('default')->onTrial())
            <div class="container">
                <div class="bg-success-light rounded-bottom text-center py-2">
                    <a class="text-underline-none text-light fw-bold" style="text-decoration: none"
                        href=" {{ route('planos') }}">
                        <i>Você aproveitando o periodo gratuito!</i>
                    </a>
                </div>
            </div>
        @endif
    @endif
</div>
