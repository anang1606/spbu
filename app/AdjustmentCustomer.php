<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdjustmentCustomer extends Model
{
    public function details(){
        return $this->hasMany(AdjustmentCustomerDetail::class,'adjustment_customer_id');
    }
}
