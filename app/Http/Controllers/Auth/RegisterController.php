<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Customer;
use Stripe\Stripe;

class RegisterController extends Controller {

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/vendas';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms_accepted' => ['required', 'accepted']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data) {

        
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Verificar se o e-mail já está registrado
        $existingUser = User::where('email', $data['email'])->first();
        if ($existingUser) {
            // Lidar com a situação, como lançar uma exceção ou retornar uma resposta
            throw new \Exception('O e-mail já está registrado.');
        }
 
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'terms_accepted' => true,
            //'stripe_id' => $customer->id,
            'config' => [
                'horarioDeTrabalho' => ['08:00', '18:00'],
                'theme' => 'light', // Tema padrão
                'language' => 'pt-br', // Idioma padrão
            ]
        ]);
      
        $user->createAsStripeCustomer();
        
        $user->save();

        return $user;

    }
}
