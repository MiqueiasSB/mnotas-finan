<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionItem extends Model
{
    use HasFactory;

    // Especifique a tabela associada, caso o nome não siga a convenção padrão
    protected $table = 'subscription_items';

    // Permitir preenchimento em massa dos campos especificados
    protected $fillable = [
        'subscription_id',
        'stripe_id',
        'stripe_price',
        'stripe_product',
        'quantity',
    ];

    // Relacionamento com o modelo Subscription
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
