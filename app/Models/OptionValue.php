<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    protected $fillable = [
        'option_id',
        'name',
        'sort_order',
        'option_image'
    ]; 

    public function option(){
        return $this->belongsTo(Option::class);
    }   
}
