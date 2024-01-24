<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, int|string|null $id)
 * @method static create(array $array)
 * @method static findOrFail(mixed $input)
 */
class CryptoWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'crypto_code',
        'amount',
        'price_bought',

    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
