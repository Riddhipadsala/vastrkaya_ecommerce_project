<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartContactInformation extends Model
{
    protected $fillable = [
        'cart_id',
        'name',
        'contact_number',
        'address_type_line_1',
        'address_type_line_2',
        'city',
        'state',
        'pincode',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }
}
