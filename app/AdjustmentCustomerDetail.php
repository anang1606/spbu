<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdjustmentCustomerDetail extends Model
{
    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function group(){
        return $this->hasOne(CustomerGroup::class,'id','customer_id');
    }
}
