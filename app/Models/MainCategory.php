<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}

