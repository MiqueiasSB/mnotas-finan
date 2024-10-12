<?php

namespace App\Models;

use App\Notifications\CustomResetPasswordNotification;
use App\Notifications\CustomVerifyEmail;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use Stripe\Product;
use Stripe\Stripe;
use Laravel\Cashier\Subscription;
use Stripe\Plan;

class User extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'terms_accepted',
        'password',
        'config',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
        'subscribed',
        'subscription_ends_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'config' => 'array',
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
    ];

    public function activeSubscription() {
        return $this->subscriptions()->where('stripe_status', 'active')->first();
    }

    public function subscriptionDaysLeft() {
        $subscription = $this->activeSubscription();

        if (!$subscription) {
            return 0;
        }

        $endDate = Carbon::parse($subscription->ends_at);

        return $endDate->diffInDays(Carbon::now());
    }

    public function getProductName() {

        $subscription = $this->activeSubscription();

        if ($subscription) {
            $stripePriceId = $subscription->stripe_price;

            try {
                Stripe::setApiKey(env('STRIPE_SECRET'));

                $price = \Stripe\Price::retrieve($stripePriceId);

                $product = Product::retrieve($price->product);

                return $product->name;
            } catch (\Exception $e) {
                return 'Produto não encontrado';
            }
        }

        return 'Sem assinatura ativa';
    }
    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification() {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    /**
     * Get the transaction categories associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriasTransacao() {
        return $this->hasMany(CategoriaTransacao::class);
    }

    /**
     * Get the subscriptions for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Determine if the user has an active subscription.
     *
     * @return bool
     */
    public function hasActiveSubscription() {
        return $this->subscribed === true && $this->subscription_ends_at->isFuture();
    }

    public function cancelSubscriptionWithGracePeriod() {
        $this->subscription('default')->cancelAtPeriodEnd();
    }

    // Método para obter o valor do plano de assinatura ativo do usuário
    public function getPrecoAssinatura() {
        $subscription = $this->subscription('default'); // Nome do seu plano de assinatura

        if (!$subscription) {
            return null; // Nenhuma assinatura ativa encontrada
        }

        // Configure sua chave secreta da API do Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));
        
        // Recupere os detalhes do plano através da API do Stripe
        $plan = Plan::retrieve($subscription->stripe_plan);

        // Retorne o valor do plano
        return $plan->amount / 100; // Valor em dólares (divida por 100 para converter de centavos para dólares)
    }
}
