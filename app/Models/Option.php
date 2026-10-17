<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'name',
        'type',
        'sort_order'
    ]; 

    public function optionValues() {
        return $this->hasMany(OptionValue::class)->orderBy('sort_order', 'asc');
    }

    public function productOptions() {
        return $this->hasMany(ProductOption::class);
    }

    public function productOptionValues()
    {
        return $this->hasMany(ProductOptionValue::class);
    }
}
