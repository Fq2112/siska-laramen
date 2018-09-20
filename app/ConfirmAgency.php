<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfirmAgency extends Model
{
    use SoftDeletes;

    protected $table = 'confirm_agencies';

    protected $guarded = ['id'];

    protected $casts = ['vacancy_ids' => 'array'];

    protected $dates = ['deleted_at'];

    public function GetAgency()
    {
        return $this->belongsTo('App\Agencies','agency_id');
    }

    public function GetVacancy()
    {
        return $this->belongsTo('App\Vacancy','vacancy_id');
    }

    public function GetPaymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

}
