<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $fillable = [
        'product_id',
        'option_id',
        'status'
    ];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function productOptionValues()
    {
        return $this->hasMany(ProductOptionValue::class);
    }
}
