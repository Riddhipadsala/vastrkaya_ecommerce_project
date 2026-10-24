<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    protected $fillable = [
        'option_id',
        'name',
        'sort_order',
        'option_value_image'
    ]; 

    public function option(){
        return $this->belongsTo(Option::class);
    }   

    public function productOptionValues()
    {
        return $this->hasMany(ProductOptionValue::class);
    }
}
