<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand',
        'name',
        'description',
        'image',
        'status',
        'stock',
        'descrese_stock',
        'price',
        'discount_price',
        'discount_percentage'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productOptions()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function productOptionValues()
    {
        return $this->hasMany(ProductOptionValue::class);
    }

    public function wishLists()
    {
        return $this->hasMany(WishList::class);
    }

    public function cartItems() {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);  
    }

}
