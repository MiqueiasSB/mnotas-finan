<x-caixa>


    @if (Auth::user()->subscription('default'))
        <div class="subscription-info">
            <div class="d-flex justify-content-between">
                <h3 class="">Plano MNOTAS</h3>
                <div class="">
                    @php
                        $status = Auth::user()->subscription('default')->stripe_status;
                        $statusCust = [];

                        switch ($status) {
                            case 'incomplete':
                                $statusCust = ['Incompleta', 'warning', 'bi bi-circle-half'];
                                break;
                            case 'incomplete_expired':
                                $statusCust = ['Expirou', 'danger', 'bi bi-hourglass-bottom'];
                                break;
                            case 'trialing':
                                $statusCust = ['Período de Teste', 'success', 'bi bi-clock-history'];
                                break;
                            case 'active':
                                $statusCust = ['Ativa', 'success', 'bi bi-check-lg'];
                                break;
                            case 'past_due':
                                $statusCust = ['Vencida', 'danger', 'bi bi-hourglass-bottom'];
                                break;
                            case 'canceled':
                                $statusCust = ['Cancelada', 'danger', 'bi bi-x-lg'];
                                break;
                            case 'unpaid':
                                $statusCust = ['Paga', 'success', 'bi bi-check-lg'];
                                break;
                            default:
                                $statusCust = ['Desconhecido', 'success', 'bi bi-question'];
                                break;
                        }

                    @endphp

                    <span
                        class="text-light px-3 py-2 badge rounded-pill text-bg-{{ $statusCust[1] }}">{{ $statusCust[0] }}
                        <i class="{{ $statusCust[2] }}"></i>
                    </span>
                </div>
            </div>

        </div>
        <div class="d-flex-row">
            @if (Auth::user()->subscription('default')->onTrial())
                <p>Você está no Periodo De Teste Gratuito</p>
                <p>Expira dia: {{ Auth::user()->subscription('default')->trial_ends_at->format('d/m/Y') }}</p>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($status == 'trialing' || $status == 'active' || $status == 'past_due' || $status == 'unpaid')
            <form action="{{ route('subscription.cancel') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Tem certeza que deseja cancelar sua assinatura?')">
                    Cancelar Assinatura
                </button>
            </form>
        @endif
    @else
        <div class="no-subscription">
            <p>Você não possui um plano ativo. <a href="{{ route('planos') }}">Clique aqui para escolher um plano</a>
            </p>
        </div>
    @endif




</x-caixa>
