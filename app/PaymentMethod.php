<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_method';

    protected $guarded = ['id'];

    public function paymentCategories()
    {
        return $this->belongsTo(PaymentCategory::class, 'payment_category_id');
    }
}
