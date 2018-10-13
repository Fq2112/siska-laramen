<?php

namespace App\Http\Controllers\Api\Clients;

use App\PaymentCategory;
use App\PaymentMethod;
use App\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentAPIController extends Controller
{
    public function loadPlan()
    {
        $plan = Plan::all()->toArray();
        return $plan;
    }

    public function loadPaymentCategory()
    {
        $category = PaymentCategory::all()->toArray();
        return $category;
    }

    public function loadPaymentMethod()
    {
        $method = PaymentMethod::all()->toArray();
//        dd($method);
        $i = 0;
        foreach ($method as $meth){
            $category = array('category' => PaymentCategory::find($meth['payment_category_id'])->name);

            $paymentmethod[$i] = array_replace($method[$i],$category);
            $i = $i + 1;
        }

        return $paymentmethod;
    }
}
