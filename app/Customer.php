<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable =[
        "customer_group_id", "user_id", "name", "company_name",
        "email", "phone_number", "tax_no", "address", "city",
        "state", "postal_code", "country", "points", "deposit", "expense", "is_active","product_id","plat_nomor"
    ];

    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function customerGroup()
    {
        return $this->hasOne(CustomerGroup::class,'id','customer_group_id');
    }
    // public function customerGroup()
    // {
    //     return $this->belongsTo('App\CustomerGroup');
    // }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function discountPlans()
    {
        return $this->belongsToMany('App\DiscountPlan', 'discount_plan_customers');
    }
}
