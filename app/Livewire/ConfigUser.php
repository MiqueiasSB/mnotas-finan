<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Stripe\Product;
use Stripe\Stripe;

class ConfigUser extends Component {

    public
        $user,
        $userName,
        $limiteInicial,
        $limiteFinal,

        $productName,
        $subscription,
        $daysLeft;

    public function mount() {

        $this->user = Auth::user();

        $this->subscription = $this->user->activeSubscription();
        $this->daysLeft = $this->user->subscriptionDaysLeft();

       
        $this->productName = $this->user->getProductName();
        

        $this->userName = $this->user->name;

        $this->limiteInicial = $this->converterParaInteiro($this->user->config['horarioDeTrabalho'][0]);
        $this->limiteFinal = $this->converterParaInteiro($this->user->config['horarioDeTrabalho'][1]);
    }
    public function render() {
      
       // dd($this->user->getPrecoAssinatura());
        return view('livewire.config-user');
    }

    protected function fetchProductName($priceId) {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $price = \Stripe\Price::retrieve($priceId);
            $product = Product::retrieve($price->product);
            $this->productName = $product->name;
        } catch (\Exception $e) {
            $this->productName = 'Produto não encontrado';
        }
    }

    public function save() {

        // Faz uma cópia do array de configuração atual do usuário
        $config = $this->user->config;

        // Modifica a cópia do array com os limites de horário convertidos para tempo
        $config['horarioDeTrabalho'] = [
            $this->converterParaTempo($this->limiteInicial),
            $this->converterParaTempo($this->limiteFinal)
        ];

        // Atribui a cópia modificada de volta à propriedade 'config'
        $this->user->config = $config;

        if ($this->userName != '') {
            $this->user->name = $this->userName;
        }


        // Salva as alterações no banco de dados
        $this->user->save();

        $this->dispatch('feedback');
    }

    function converterParaInteiro($tempo) {
        // Divide o tempo em horas e minutos
        list($horas, $minutos) = explode(':', $tempo);

        // Converte as horas e minutos para inteiros
        $horas = intval($horas);
        $minutos = intval($minutos);

        // Calcula o total de horas
        $totalHoras = $horas + ($minutos / 60);

        return $totalHoras;
    }

    function converterParaTempo($horas) {
        // Extrai a parte inteira das horas
        $horasInteiras = floor($horas);

        // Calcula os minutos restantes
        $minutos = ($horas - $horasInteiras) * 60;

        // Formata o tempo no formato 'HH:MM'
        $tempoFormatado = sprintf("%02d:%02d", $horasInteiras, $minutos);

        return $tempoFormatado;
    }
}
