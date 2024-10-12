<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierWebhookController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
//use Laravel\Cashier\PaymentMethod;
use Laravel\Cashier\Subscription;
use Stripe\Stripe;
use Stripe\PaymentMethod;


class StripeWebhookController extends CashierWebhookController {
    
    public function handleCustomerSubscriptionUpdated($payload) {
        Log::info('Payload recebido em handleCustomerSubscriptionUpdated:', $payload);

        $customer = $payload['data']['object']['customer'];
        $subscription = $payload['data']['object'];
        //$customer_email = $payload['data']['customer_email'];
        
        try {

            $user = User::where('stripe_id', $customer)->first();
            if ($user) {
                $user->subscribed = $subscription['status'] == 'active';

                // Obter detalhes do método de pagamento padrão
                $paymentMethodId = $subscription['default_payment_method'];
                if ($paymentMethodId) {
                    Stripe::setApiKey(env('STRIPE_SECRET'));
                    $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
                    $user->pm_type = $paymentMethod->type;
                    if (isset($paymentMethod->card)) {
                        $user->pm_last_four = $paymentMethod->card->last4;
                    }
                }

                // Atualizar trial_ends_at apenas se estiver presente
                if (isset($subscription['trial_end'])) {
                    $user->trial_ends_at = Carbon::createFromTimestamp($subscription['trial_end']);
                } else {
                    $user->trial_ends_at = null;
                }

                $user->subscription_ends_at = Carbon::createFromTimestamp($subscription['current_period_end']);
                $user->save();

                $trialEndsAt = isset($subscription['trial_end']) ? Carbon::createFromTimestamp($subscription['trial_end']) : null;


                // Atualizar ou criar assinatura na tabela `subscriptions`
                $sub = Subscription::updateOrCreate(
                    ['stripe_id' => $subscription['id']],
                    [
                        'user_id' => $user->id,
                        'stripe_status' => $subscription['status'],
                        'stripe_price' => $subscription['items']['data'][0]['price']['id'],
                        'quantity' => $subscription['items']['data'][0]['quantity'],
                        'trial_ends_at' => $trialEndsAt,
                        'ends_at' => $subscription['current_period_end'] ? Carbon::createFromTimestamp($subscription['current_period_end']) : null,
                    ]
                );

                // Atualizar ou criar itens de assinatura na tabela `subscription_items`
                foreach ($subscription['items']['data'] as $item) {

                    SubscriptionItem::updateOrCreate(
                        ['stripe_id' => $item['id']],
                        [
                            'subscription_id' => $sub->id,
                            'stripe_product' => $item['price']['product'],
                            'stripe_price' => $item['price']['id'],
                            'quantity' => $item['quantity'],
                        ]
                    );
                }

                Log::info("Assinatura atualizada para o usuário: {$user->id}");
            } else {
                Log::warning("Usuário não encontrado para o ID do cliente: {$customer}");
            }
        } catch (\Exception $e) {
            Log::error('Erro em handleCustomerSubscriptionUpdated:', ['erro' => $e->getMessage()]);
        }

        return response()->json(['status' => 'sucesso']);
    }

    public function handleCustomerSubscriptionDeleted($payload) {
        Log::info('Payload recebido em handleCustomerSubscriptionDeleted:', $payload);

        $customer = $payload['data']['object']['customer'];

        try {
            $user = User::where('stripe_id', $customer)->first();
            if ($user) {
                $user->subscribed = false;
                $user->subscription_ends_at = null;
                $user->save();
                Log::info("Assinatura deletada para o usuário: {$user->id}");
            } else {
                Log::warning("Usuário não encontrado para o ID do cliente: {$customer}");
            }
        } catch (\Exception $e) {
            Log::error('Erro em handleCustomerSubscriptionDeleted:', ['erro' => $e->getMessage()]);
        }

        return response()->json(['status' => 'sucesso']);
    }

    public function handleWebhook(Request $request) {
        Log::info('Webhook Stripe Recebido:', $request->all());

        return parent::handleWebhook($request);
    }
} 
