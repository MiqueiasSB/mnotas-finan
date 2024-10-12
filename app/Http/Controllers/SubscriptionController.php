<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Laravel\Cashier\Subscription;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Customer;
use Stripe\Price;
use Stripe\Product;
use Stripe\StripeClient;

class SubscriptionController extends Controller {
    public function showPlans() {
       
        $stripe = Cashier::stripe(); // Obtenha a instância do Stripe

        try { // PRODUÇÂO

         
            $prices = $stripe->prices->all(['product' => 'prod_QBmoHKZoIh9u6s']);
          

            $plans = [
                'mensal' => [
                    //'id' => 'price_1PLPF3RprhF6uunETuEhtGaZ', // Substitua pelo ID do seu plano Stripe
                    'id' => $prices->data[2]->id, // TESTE
                    'name' =>  'Plano Mensal',
                    'descricao' => 'Exploração Contínua: Acesso Total!',
                    'equivalente_mensal' => $prices->data[2]->unit_amount / 100,
                    'desconto' => '',
                    'price' => $prices->data[2]->unit_amount / 100
                ],
                'anual' => [
                    'id' => $prices->data[1]->id, // Substitua pelo ID do seu plano Stripe
                    'name' => 'Plano Anual',
                    'descricao' => 'Economia Anual: Desconto Garantido por Um Ano!',
                    'desconto' => '20% off',
                    'equivalente_mensal' => 59.99,
                    'price' =>  $prices->data[1]->unit_amount / 100
                ],

                'bianual' => [
                    'id' => $prices->data[0]->id, // Substitua pelo ID do seu plano Stripe
                    'name' => 'Plano Bianual',
                    'descricao' => 'Oferta Exclusiva: Dois Anos Inteiros com Grande Desconto!',
                    'desconto' => '35% off',
                    'equivalente_mensal' => 45.49,
                    'price' =>  $prices->data[0]->unit_amount / 100
                ],
            ];
        } catch (\Throwable $th) { //TESTE

            $prices = $stripe->prices->all(['product' => 'prod_QBoWSjhcgGeWFZ']);
           
            $plans = [
                'mensal' => [
                    //'id' => 'price_1PLPF3RprhF6uunETuEhtGaZ', // Substitua pelo ID do seu plano Stripe
                    'id' => $prices->data[2]->id, // TESTE
                    'name' =>  'Plano Mensal',
                    'descricao' => 'Exploração Contínua: Acesso Total!',
                    'equivalente_mensal' => $prices->data[2]->unit_amount / 100,
                    'desconto' => '',
                    'price' => $prices->data[2]->unit_amount / 100
                ],
                'anual' => [
                    'id' => $prices->data[1]->id, // Substitua pelo ID do seu plano Stripe
                    'name' => 'Plano Anual',
                    'descricao' => 'Economia Anual: Desconto Garantido por Um Ano!',
                    'desconto' => '20% off',
                    'equivalente_mensal' => 59.99,
                    'price' =>  $prices->data[1]->unit_amount / 100
                ],

                'bianual' => [
                    'id' => $prices->data[0]->id, // Substitua pelo ID do seu plano Stripe
                    'name' => 'Plano Bianual',
                    'descricao' => 'Oferta Exclusiva: Dois Anos Inteiros com Grande Desconto!',
                    'desconto' => '35% off',
                    'equivalente_mensal' => 45.49,
                    'price' =>  $prices->data[0]->unit_amount / 100
                ],
            ];
        }


        return view('planos', compact('plans'));
    }

    public function checkout(Request $request) {

        if (Auth::check()) {

            return $request->user()
                ->newSubscription('default', $request->plan)
                ->trialDays(31)
                ->allowPromotionCodes()
                ->checkout([
                    'success_url' => route('painel'),
                    'cancel_url' => route('planos'),
                ]);

        } else {
            return redirect()->route('register');
        }
    }
    
    public function cancel(Request $request) {
        $user = Auth::user();

        $subscription = $user->subscription('default'); // 'default' é o nome da assinatura, ajuste conforme necessário

        if ($subscription && $subscription->valid()) {
            $subscription->cancel();
            return redirect()->back()->with('success', 'Sua assinatura foi cancelada com sucesso.');
        }

        return redirect()->back()->with('error', 'Não foi possível cancelar a assinatura.');
    }
}
