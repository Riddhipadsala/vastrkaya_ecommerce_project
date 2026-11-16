<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];
    
    protected function name(): Attribute {
        return Attribute::make(
            get: fn($value) => ucfirst($value)
        );
    } 


    public function categories()
    {
        return $this->hasMany(Category::class);
    }

}

