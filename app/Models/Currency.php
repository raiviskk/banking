<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static inRandomOrder()
 * @method static create(string[] $array)
 * @method static where(string $string, string $fromCurrency)
 */
class Currency extends Model
{
    protected $primaryKey = 'code';
    public $incrementing = false;

    protected $table = 'currencies';

    use HasFactory;
    protected $fillable = ['code', 'rate'];

}


