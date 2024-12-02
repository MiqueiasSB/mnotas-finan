<div>
    {{-- MENU SIMPLES TOPO --}}
    <nav class="z-3 navbar navbar-expand-md bg-primary shadow">
        <!-- Div para a versão -->
        <div class="text-white text-end position-absolute top-0 end-0 opacity-25 pb-1 pe-1">
            <small>{{ config('app.version') }}</small>
        </div>
        <div class="container">

            <a class="navbar-brand text-light logo pe-2" href="{{ url('/') }}">
                <x-icons.imgLogo largura="130"></x-icons.imgLogo>
            </a>

            @guest
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse " id="navbarSupportedContent">

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto ">
                        <!-- Authentication Links -->

                        <x-menu.linkMenu label="Entrar" rota="login"></x-menu.linkMenu>
                        {{--  <x-menu.linkMenu label="Cadastrar-se" rota="register"></x-menu.linkMenu> --}}
                        <x-menu.linkMenu label="Planos" rota="planos"></x-menu.linkMenu>

                    </ul>
                </div>
            @else
                <div class="dropdown">
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
                </div>
            @endguest
        </div>


    </nav>

    {{-- MENU PRINCIPAL FIXO BUTTON --}}
    @auth
        @if (auth()->user()->hasVerifiedEmail())
            <nav class="fixed-bottom shadow-lg border-top">
                <div class="bg-light py-3 d-flex flex-row text-center">
                    <x-menu.linkMenuMobile label="Categorias" rota="categorias"
                        icon="bi bi-archive-fill"></x-menu.linkMenuMobile>
                    <x-menu.linkMenuMobile label="Painel" rota="painel" icon="bi bi-grid-1x2-fill"></x-menu.linkMenuMobile>
                    <x-menu.linkMenuMobile label="Transações" rota="vendas"
                        icon="bi bi-arrow-left-right"></x-menu.linkMenuMobile>
                    <x-menu.linkMenuMobile label="Clientes" rota="clientes.index"
                        icon="bi bi-people-fill"></x-menu.linkMenuMobile>
                    @if (!auth()->user()->subscribed)
                        <x-menu.linkMenuMobile label="Planos" rota="planos" icon="bi bi-bag-fill"></x-menu.linkMenuMobile>
                    @endif
                </div>
            </nav>
        @endif
    @endauth


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
                        <i>Você está aproveitando o periodo gratuito!</i>
                    </a>
                </div>
            </div>
        @endif
    @endif
</div>
