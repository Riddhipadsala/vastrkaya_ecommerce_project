<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'main_category_id',
        'name',
        'description',
        'image',
        'status'
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Str::title($value)
        );
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    // Helper function to safely get the name
    public function getNameSafeAttribute()
    {
        return $this->name ?: 'N/A';
    }

    public function main_category()
    {
        return $this->belongsTo(MainCategory::class);
    }


}
