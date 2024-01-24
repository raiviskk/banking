<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static pluck(string $string)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'address',
        'avatar',
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
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }


    protected static function booted(): void
    {
        static::created(function ($user) {

            $user->accounts()->create([
                'user_id'=>$user->id,
                'account_number' => random_int(10000000, 99999999),
                'account_type' => 'Debit',
                'balance'=> 1000000,
                'currency_code' => 'EUR',
                'opened_at' => now(),
                'is_active' => true,
            ]);
            $user->accounts()->create([
                'user_id'=>$user->id,
                'account_number' => random_int(10000000, 99999999),
                'account_type' => 'Saving',
                'balance'=> 1000000,
                'currency_code' => 'EUR',
                'opened_at' => now(),
                'is_active' => true,
            ]);
            $user->accounts()->create([
                'user_id'=>$user->id,
                'account_number' => random_int(10000000, 99999999),
                'account_type' => 'Investment',
                'balance'=> 1000000,
                'currency_code' => 'EUR',
                'opened_at' => now(),
                'is_active' => true,
            ]);
            $user->accounts()->create([
                'user_id'=>$user->id,
                'account_number' => random_int(10000000, 99999999),
                'account_type' => 'Crypto',
                'balance'=> 1000000,
                'currency_code' => 'EUR',
                'opened_at' => now(),
                'is_active' => true,

            ]);


        });
    }
}
