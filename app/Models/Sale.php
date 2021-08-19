<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function customer()
    {
    	return $this->hasOne('App\Models\Customer', 'customer_id', 'customer_id');
    }

    public function product_sale()
    {
    	return $this->hasMany('App\Models\ProductSale', 'sale_id', 'sale_id');
    }

}
