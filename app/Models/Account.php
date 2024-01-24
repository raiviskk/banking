<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static findOrFail(mixed $from_account_id)
 * @method static create(array $array)
 * @method static where(string $string, int|string|null $id)
 */
class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_number',
        'account_type',
        'balance',
        'currency_code',
        'opened_at',
        'closed_at',
        'is_active',
        'notes',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accountType(): BelongsTo
    {
        return $this->belongsTo(AccountTypes::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function getFormattedBalanceAttribute(): string
    {
        return number_format($this->attributes['balance']/100, 2);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
