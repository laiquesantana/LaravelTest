<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'ref' ,
            'quantity' ,
            'category' ,
            'quantity' ,
            'price_ht' ,
            'image' ,
            'price_ttc' ,
            'active' ,
            'resume' ,
            'description' 
    ];
}
