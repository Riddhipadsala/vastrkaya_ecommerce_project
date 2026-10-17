<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    protected $fillable = [
        'product_id',
        'option_id',
        'product_option_id',
        'option_value_id',
        'status',
        'image'
    ];

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class);
    }

    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
