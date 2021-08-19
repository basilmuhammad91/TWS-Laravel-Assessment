<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    use HasFactory;

    public function product()
    {
    	return $this->hasOne('App\Models\Product', 'product_id', 'product_id');
    }
}