<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    protected $fillable =[
        "name", "percentage", "is_active"
    ];

    public function details(){
        return $this->hasMany(CustomerGroupDetail::class,'customer_group_id')
        ->where('is_active', 1);
    }
}
