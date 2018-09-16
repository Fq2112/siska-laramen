<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentCategory extends Model
{
    protected $table = 'payment_category';

    protected $guarded = ['id'];

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class, 'payment_category_id');
    }
}
