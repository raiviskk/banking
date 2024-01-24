<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stock_symbol',
        'amount',
        'price_bought',

    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
