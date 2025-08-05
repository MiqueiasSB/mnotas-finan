<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\SubscriptionController;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Illuminate\Http\Request;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;

Route::redirect('/', '/home');
Route::view('/home', 'welcome');

Auth::routes(['verify' => true]);


Route::get('/planos', [SubscriptionController::class, 'showPlans'])->name('planos');
Route::post('/checkout', [SubscriptionController::class, 'checkout'])->name('checkout');
Route::post('/subscribe', [SubscriptionController::class, 'subscribeUser'])->name('subscribe');
Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');

Route::view('/politicas', 'politicas')->name('politicas');
Route::view('/termos', 'termos')->name('termos');


Route::middleware(['web'])->group(function () {
    Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook']);
});

// URL para reenvio do link de verificação de email
Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth'])->group(function () {
    Route::put('/upEmail', [HomeController::class, 'upEmail'])->name('upEmail');
});


// Rotas protegidas por autenticação 'subscription.active'
Route::middleware(['auth', 'verified'  ])->group(function () {
    Route::get('/painel', [HomeController::class, 'painel'])->name('painel');
    Route::get('/vendas', [HomeController::class, 'index'])->name('vendas');
    Route::get('/categorias', [HomeController::class, 'categorias'])->name('categorias');
    Route::resource('clientes', ClienteController::class);
    Route::get('/configuracoes', [HomeController::class, 'configUser'])->name('configUser');
});
