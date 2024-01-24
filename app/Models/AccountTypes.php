<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static inRandomOrder()
 * @method static create(string[] $array)
 */
class AccountTypes extends Model
{
    use HasFactory;

    protected $primaryKey = 'type';
    public $incrementing = false ;


}
