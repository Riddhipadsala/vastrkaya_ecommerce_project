<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'coupon_name',
        'code',
        'discount',
        'type',
        'uses_total',
        'used_total',
        'start_date',
        'end_date',
        'status'
    ];
}
