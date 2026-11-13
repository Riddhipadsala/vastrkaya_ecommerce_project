<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'final_price',
        'discount_price',
        'discount_percentage'
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Str::title($value)
        );
    }
 
    protected function brand(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Str::ucfirst($value)
        );
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value)
        );
    }

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
