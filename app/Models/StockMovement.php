<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type', // 'in' ou 'out'
        'quantity',
        'total_value',
        'note',
        'movement_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
