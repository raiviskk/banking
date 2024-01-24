<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static updateOrCreate(array $array, array $array1)
 * @method static where(string $string, $crypto_code)
 */
class Crypto extends Model
{

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $fillable = ['code', 'rate'];
}
