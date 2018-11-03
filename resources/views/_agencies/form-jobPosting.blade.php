@extends('layouts.mst_user')
@section('title', 'Job Posting Process | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <link href="{{ asset('css/mySearchFilter.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myMultiStepForm.css') }}" rel="stylesheet">
    <link href="{{ asset('css/countdown.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fileUploader.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cc.css') }}" rel="stylesheet">
@endpush
@section('content')
    <section id="fh5co-services" data-section="services">
        <div class="fh5co-services">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 section-heading">
                        <h2 class="to-animate text-center"><span>Job Posting Process</span></h2>
                        <div class="row text-center" id="job-posting">
                            <div class="col-md-8 col-md-offset-2 subtext">
                                <h3 class="to-animate">
                                    {{session('confirmAgency') ? 'To end this job posting process, please complete your payment with the following details' : 'Before proceeding to the next step, please fill in all the form fields with a valid data.'}}</h3>
                            </div>
                        </div>
                        <div class="row to-animate">
                            <div class="col-lg-12">
                                <div class="msform">
                                    <ul id="progressbar" class="to-animate-2 text-center">
                                        <li class="active">Vacancy Setup</li>
                                        <li>Order Summary</li>
                                        <li>Payment Method</li>
                                        <li>Proceeds</li>
                                    </ul>
                                    <form action="{{route('submit.job.posting')}}" method="post" id="pm-form">
                                        {{csrf_field()}}
                                        <input type="hidden" name="payment_code" id="payment_code">
                                        <fieldset id="vacancy_setup">
                                            <div class="row form-group text-center">
                                                <div class="col-lg-12">
                                                    <h2 class="fs-title">Vacancy Setup</h2>
                                                    <h3 class="fs-subtitle">You're only permitted to setup vacancy that
                                                        haven't been posted yet</h3>
                                                </div>
                                            </div>
                                            <div class="row form-group" id="vacancy_list">
                                                <div class="col-lg-12">
                                                    <small>Job Vacancy</small>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-briefcase"></i></span>
                                                        <input id="total_ads" name="total_ads" type="number"
                                                               class="form-control" placeholder="0" style="width: 15%"
                                                               value="{{$totalAds}}" min="{{$totalAds}}" required>
                                                        <select id="vacancy_id" class="form-control selectpicker"
                                                                title="-- Choose Vacancy --" data-live-search="true"
                                                                multiple data-max-options="{{$totalAds}}"
                                                                data-selected-text-format="count > 3"
                                                                name="vacancy_ids[]" data-container="body"
                                                                data-width="85%" required>
                                                            @foreach($vacancies as $vacancy)
                                                                <option value="{{$vacancy->id}}">
                                                                    {{$vacancy->judul}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <span class="help-block">
                                                        <small class="aj_vacancy"
                                                               style="text-transform: none;float: left"></small>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                @php
                                                    if($plan->id == 1){
                                                        $attr_quiz = 'readonly';
                                                        $attr_psychoTest = 'readonly';

                                                    } elseif($plan->id == 2){
                                                        $attr_quiz = '';
                                                        $attr_psychoTest = 'readonly';

                                                    } elseif($plan->id == 3){
                                                        $attr_quiz = '';
                                                        $attr_psychoTest = '';
                                                    }
                                                @endphp
                                                <div class="col-lg-6">
                                                    <small>Total Applicant for Quiz</small>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-grin-beam"></i></span>
                                                        <input id="total_quiz" name="total_quiz"
                                                               type="number" class="form-control"
                                                               placeholder="0" value="{{$plan->quiz_applicant}}"
                                                               min="{{$plan->quiz_applicant}}" {{$attr_quiz}} required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <small>Total Applicant for Psycho Test</small>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-comments"></i></span>
                                                        <input id="total_psychoTest" name="total_psychoTest"
                                                               type="number" class="form-control" placeholder="0"
                                                               value="{{$plan->psychoTest_applicant}}"
                                                               min="{{$plan->psychoTest_applicant}}"
                                                               {{$attr_psychoTest}} required>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="button" name="next" class="next action-button"
                                                   value="Next" style="display: table">
                                        </fieldset>
                                        <fieldset id="order_summary">
                                            <h2 class="fs-title text-center">Order Summary</h2>
                                            <h3 class="fs-subtitle text-center">
                                                Make sure your order details and the vacancy that you want
                                                to post is correct</h3>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <small>Plan Details
                                                        <span id="show_plans_settings" class="pull-right"
                                                              style="color: #00ADB5;cursor: pointer; font-size: 15px">
                                                <i class="fa fa-edit"></i>&nbsp;EDIT</span>
                                                    </small>
                                                    <hr class="hr-divider">
                                                    <ul class="list-inline stats_plans" style="margin-top: -1em">
                                                        <li>
                                                            <a class="tag tag-plans">
                                                                <i class="fa fa-thumbtack"></i>&ensp;
                                                                <strong style="text-transform: uppercase"
                                                                        class="plans_name">
                                                                    {{$plan->name}}</strong> &ensp;|&ensp;
                                                                <i class='fa fa-money-bill-wave'>
                                                                </i>&ensp;<strong class="plan_price">Rp{{number_format
                                                                ($price,2,',','.')}}</strong>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="tag tag-plans">
                                                                <i class="fa fa-briefcase"></i>&ensp;
                                                                <strong class="main_feature">{{$plan->job_ads}}</strong>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="tag tag-plans">
                                                                <i class="fa fa-grin-beam"></i>&ensp;
                                                                Total Applicant for Quiz:
                                                                <strong class="quiz_applicant">
                                                                    {{$plan->quiz_applicant}}</strong> applicants
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="tag tag-plans">
                                                                <i class="fa fa-comments"></i>&ensp;
                                                                Total Applicant for Psycho Test:
                                                                <strong class="psychoTest_applicant">
                                                                    {{$plan->psychoTest_applicant}}</strong> applicants
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <div id="plans_settings" style="display: none">
                                                        <div class="row form-group">
                                                            <div class="col-lg-12">
                                                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-thumbtack"></i>
                                                        </span>
                                                                    <select class="form-control selectpicker"
                                                                            name="plans_id"
                                                                            id="plans_id" required>
                                                                        @foreach(\App\Plan::all() as $row)
                                                                            <option value="{{$row->id}}" {{$row->id == $plan->id
                                                                    || (collect(old('plans_id'))->contains($row->id)) ?
                                                                    'selected' : ''}}>{{$row->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <small>Billing Details</small>
                                                    <hr class="hr-divider">
                                                    <table id="stats-billing" style="font-size: 16px">
                                                        <tr>
                                                            <td>
                                                                <strong style="text-transform: uppercase"
                                                                        class="plans_name">
                                                                    {{$plan->name}}</strong>
                                                            </td>
                                                            <td>&emsp;</td>
                                                            <td align="center"><strong>-</strong></td>
                                                            <td>&emsp;</td>
                                                            <td align="right">
                                                                <strong class="plan_price">
                                                                    Rp{{number_format($price,2,',','.')}}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Job Ad</td>
                                                            <td>&emsp;</td>
                                                            <td align="center">
                                                                <strong class="total_vacancy">{{$totalAds}}</strong>
                                                            </td>
                                                            <td>&emsp;</td>
                                                            <td align="right">
                                                                <strong class="total_price_vacancy">
                                                                    Rp{{number_format(0,2,',','.')}}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr data-placement="left" data-toggle="tooltip"
                                                            title="Total Applicant for">
                                                            <td>Quiz</td>
                                                            <td>&emsp;</td>
                                                            <td align="center">
                                                                <strong class="bill_quiz_applicant">
                                                                    {{$plan->quiz_applicant}}</strong></td>
                                                            <td>&emsp;</td>
                                                            <td align="right">
                                                                <strong class="total_price_quiz">
                                                                    Rp{{number_format(0,2,',','.')}}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr data-placement="left" data-toggle="tooltip"
                                                            title="Total Applicant for">
                                                            <td>Psycho Test</td>
                                                            <td>&emsp;</td>
                                                            <td align="center">
                                                                <strong class="bill_psychoTest_applicant">
                                                                    {{$plan->psychoTest_applicant}}</strong></td>
                                                            <td>&emsp;</td>
                                                            <td align="right">
                                                                <strong class="total_price_psychoTest">
                                                                    Rp{{number_format(0,2,',','.')}}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr style="border-top: 1px solid #eee">
                                                            <td><strong>SUBTOTAL</strong></td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td align="right">
                                                                <strong class="subtotal"
                                                                        style="font-size: 18px;color: #00adb5"></strong>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 1em;">
                                                <div class="col-lg-12">
                                                    <small>Vacancy List
                                                        <span id="show_vacancy_setup" class="pull-right"
                                                              style="color: #00ADB5;cursor: pointer; font-size: 15px">
                                                <i class="fa fa-edit"></i>&nbsp;EDIT</span>
                                                    </small>
                                                    <hr class="hr-divider">
                                                    <div id="vacancy_data"></div>
                                                </div>
                                            </div>
                                            <input type="button" name="previous" class="previous action-button"
                                                   value="Previous">
                                            <input type="button" name="next" class="next action-button"
                                                   value="Next">
                                        </fieldset>
                                        <fieldset id="payment_method">
                                            <h2 class="fs-title text-center">Payment Method</h2>
                                            <h3 class="fs-subtitle text-center">Select one of the following payment
                                                methods before completing your payment</h3>
                                            <hr class="hr-divider">
                                            <div class="panel-group accordion" style="margin-top: -1em">
                                                @foreach($paymentCategories as $row)
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle collapsed"
                                                                   href="#pc-{{$row->id}}" data-toggle="collapse"
                                                                   data-parent=".accordion"
                                                                   onclick="paymentCategory('{{$row->id}}')">
                                                                    &ensp;{{$row->name}}
                                                                    <sub>{{$row->caption}}</sub></a>
                                                            </h4>
                                                        </div>
                                                        <div id="pc-{{$row->id}}" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="pm-selector">
                                                                    @if($row->id==3)
                                                                        <input type="radio" id="pm-11" name="pm_id"
                                                                               value="11" style="display: none;">
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <div class="cc-wrapper"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row form-group">
                                                                            <div class="col-lg-6">
                                                                                <small>Credit Card Number</small>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-credit-card"></i>
                                                                                    </span>
                                                                                    <input class="form-control"
                                                                                           type="tel" required
                                                                                           id="cc_number" name="number"
                                                                                           placeholder="•••• •••• •••• ••••">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <small>Your Name</small>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-user"></i>
                                                                                    </span>
                                                                                    <input class="form-control"
                                                                                           type="text" required
                                                                                           name="name" id="cc_name"
                                                                                           placeholder="e.g: jQuinn">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row form-group">
                                                                            <div class="col-lg-6">
                                                                                <small>Expiration Date</small>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-calendar-minus"></i>
                                                                                    </span>
                                                                                    <input class="form-control"
                                                                                           type="tel" required
                                                                                           id="cc_expiry" name="expiry"
                                                                                           placeholder="MM/YYYY">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <small>Security Code</small>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-lock"></i></span>
                                                                                    <input class="form-control"
                                                                                           name="cvc" required
                                                                                           type="number" id="cc_cvc"
                                                                                           placeholder="***"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row form-group">
                                                                            <div class="col-lg-12">
                                                                                <div class="alert alert-info text-center"
                                                                                     role="alert"
                                                                                     style="font-size: 13px">
                                                                                    Your credit card will be charged
                                                                                    <strong class="subtotal"></strong>
                                                                                    every month to renew your Vacancy
                                                                                    Status.
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        @foreach($row->paymentMethods as $pm)
                                                                            @if($pm->payment_category_id != 3)
                                                                                <input class="pm-radioButton"
                                                                                       id="pm-{{$pm->id}}" type="radio"
                                                                                       name="pm_id" value="{{$pm->id}}">
                                                                                <label class="pm-label"
                                                                                       for="pm-{{$pm->id}}"
                                                                                       onclick="paymentMethod('{{$pm->id}}')"
                                                                                       style="background-image: url({{asset('images/paymentMethod/'.$pm->logo)}});"></label>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                                <div id="pm-details-{{$row->id}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="hr-divider" style="margin-bottom: 0">
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="total_payment" id="total_payment">
                                            <input type="button" name="previous" class="previous action-button"
                                                   value="Previous">
                                            <input type="button" class="submit action-button" value="Submit">
                                        </fieldset>
                                    </form>
                                    @if(session('confirmAgency'))
                                        @php
                                            $pm = \App\PaymentMethod::find(session('confirmAgency')->payment_method_id);
                                            $pl = \App\Plan::find(old('plans_id'));
                                            $plan_price = $pl->price - ($pl->price * $pl->discount/100);
                                            $price_per_ads = \App\Plan::find(1)->price -
                                            (\App\Plan::find(1)->price * \App\Plan::find(1)->discount/100);

                                            $old_totalVacancy = array_sum(str_split(filter_var
                                            ($pl->job_ads, FILTER_SANITIZE_NUMBER_INT)));
                                            $totalVacancy = $old_totalVacancy;
                                            $diffTotalVacancy = old('total_ads') - $old_totalVacancy;
                                            $price_totalVacancy = 0;
                                            if($diffTotalVacancy > 0){
                                                $totalVacancy = $old_totalVacancy."(+".$diffTotalVacancy.")";
                                                $price_totalVacancy = number_format
                                                ($diffTotalVacancy * $price_per_ads,0,',','.');
                                            }

                                            $old_totalQuizApplicant = $pl->quiz_applicant;
                                            $totalQuizApplicant = $old_totalQuizApplicant;
                                            $diffTotalQuizApplicant = old('total_quiz') - $old_totalQuizApplicant;
                                            $price_totalQuiz = 0;
                                            if($diffTotalQuizApplicant > 0){
                                                $totalQuizApplicant = $old_totalQuizApplicant.
                                                "(+".$diffTotalQuizApplicant.")";
                                                $price_totalQuiz = number_format
                                                ($diffTotalQuizApplicant * $pl->price_quiz_applicant,0,',','.');
                                            }

                                            $old_totalPsychoTest = $pl->psychoTest_applicant;
                                            $totalPsychoTest = $old_totalPsychoTest;
                                            $diffTotalPsychoTest = old('total_psychoTest') - $old_totalPsychoTest;
                                            $price_totalPsychoTest = 0;
                                            if($diffTotalPsychoTest > 0){
                                                $totalPsychoTest = $old_totalPsychoTest."(+".$diffTotalPsychoTest.")";
                                                $price_totalPsychoTest = number_format
                                                ($diffTotalPsychoTest * $pl->price_psychoTest_applicant,0,',','.');
                                            }
                                        @endphp
                                        <style>
                                            .msform {
                                                width: 75%;
                                            }
                                        </style>
                                        <fieldset id="proceeds" style="margin: 0 4%">
                                            <div class="row">
                                                <div class="col-lg-12 alert alert-info">
                                                    <div class="countdown">
                                                        <div class="bloc-time hours" data-init-value="24">
                                                            <span class="count-title">Hours</span>
                                                            <div class="figure hours hours-1">
                                                                <span class="top">2</span>
                                                                <span class="top-back"><span>2</span></span>
                                                                <span class="bottom">2</span>
                                                                <span class="bottom-back"><span>2</span></span>
                                                            </div>

                                                            <div class="figure hours hours-2">
                                                                <span class="top">4</span>
                                                                <span class="top-back"><span>4</span></span>
                                                                <span class="bottom">4</span>
                                                                <span class="bottom-back"><span>4</span></span>
                                                            </div>
                                                        </div>

                                                        <div class="bloc-time min" data-init-value="0">
                                                            <span class="count-title">Minutes</span>

                                                            <div class="figure min min-1">
                                                                <span class="top">0</span>
                                                                <span class="top-back"><span>0</span></span>
                                                                <span class="bottom">0</span>
                                                                <span class="bottom-back"><span>0</span></span>
                                                            </div>

                                                            <div class="figure min min-2">
                                                                <span class="top">0</span>
                                                                <span class="top-back"><span>0</span></span>
                                                                <span class="bottom">0</span>
                                                                <span class="bottom-back"><span>0</span></span>
                                                            </div>
                                                        </div>

                                                        <div class="bloc-time sec" data-init-value="0">
                                                            <span class="count-title">Seconds</span>

                                                            <div class="figure sec sec-1">
                                                                <span class="top">0</span>
                                                                <span class="top-back"><span>0</span></span>
                                                                <span class="bottom">0</span>
                                                                <span class="bottom-back"><span>0</span></span>
                                                            </div>

                                                            <div class="figure sec sec-2">
                                                                <span class="top">0</span>
                                                                <span class="top-back"><span>0</span></span>
                                                                <span class="bottom">0</span>
                                                                <span class="bottom-back"><span>0</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h2 class="countdown-h2"></h2>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 alert alert-warning text-center"
                                                     style="font-size: 16px">
                                                    Make sure not to inform payment details and proof
                                                    <strong>to any party</strong> except SISKA.
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6" id="stats_payment">
                                                    @if($pm->payment_category_id == 1)
                                                        <small>Banking Details</small>
                                                    @elseif($pm->payment_category_id == 4)
                                                        <small>Convenience Store Details</small>
                                                    @endif
                                                    <hr class="hr-divider">
                                                    <div class="media">
                                                        <div class="media-left media-middle">
                                                            <img width="100" class="media-object"
                                                                 src="{{asset('images/paymentMethod/'.$pm->logo)}}">
                                                        </div>
                                                        <div class="media-body">
                                                            <blockquote style="font-size: 12px;color: #7f7f7f">
                                                                <ul class="list-inline">
                                                                    <li>
                                                                        <a class="tag tag-plans"
                                                                           style="font-size: 16px">
                                                                            @if($pm->payment_category_id == 1)
                                                                                <strong>{{number_format($pm
                                                                                    ->account_number,0," "," ")}}
                                                                                </strong>
                                                                            @elseif($pm->payment_category_id == 4)
                                                                                <strong>{{session('confirmAgency')
                                                                                ->payment_code}}</strong>
                                                                            @endif
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="tag tag-plans">
                                                                            @if($pm->payment_category_id == 1)
                                                                                a/n <strong>{{$pm->account_name}}
                                                                                </strong>
                                                                            @elseif($pm->payment_category_id == 4)
                                                                                <strong>{{$pm->name}}</strong>
                                                                                Payment Code
                                                                            @endif
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </blockquote>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" id="stats_billing">
                                                    <small>Billing Details</small>
                                                    <hr class="hr-divider">
                                                    <table id="stats-billing" style="font-size: 16px">
                                                        <tr>
                                                            <td>
                                                                <strong style="text-transform: uppercase">{{$pl->name}}</strong>
                                                            </td>
                                                            <td>&emsp;</td>
                                                            <td align="center"><strong>-</strong></td>
                                                            <td>&emsp;</td>
                                                            <td align="right">
                                                                <strong>Rp{{number_format($plan_price,0,',','.')}}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Job Ad</td>
                                                            <td>&emsp;</td>
                                                            <td align="center">
                                                                <strong>{{$totalVacancy}}</strong>
                                                            </td>
                                                            <td>&emsp;</td>
                                                            <td align="right">
                                                                <strong>Rp{{$price_totalVacancy}}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr data-placement="left" data-toggle="tooltip"
                                                            title="Total Applicant for">
                                                            <td>Quiz</td>
                                                            <td>&emsp;</td>
                                                            <td align="center">
                                                                <strong>{{$totalQuizApplicant}}</strong></td>
                                                            <td>&emsp;</td>
                                                            <td align="right">
                                                                <strong>Rp{{$price_totalQuiz}}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr data-placement="left" data-toggle="tooltip"
                                                            title="Total Applicant for">
                                                            <td>Psycho Test</td>
                                                            <td>&emsp;</td>
                                                            <td align="center">
                                                                <strong>{{$totalPsychoTest}}</strong></td>
                                                            <td>&emsp;</td>
                                                            <td align="right">
                                                                <strong>Rp{{$price_totalPsychoTest}}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Unique Code</td>
                                                            <td>&emsp;</td>
                                                            <td align="center"><strong>-</strong></td>
                                                            <td>&emsp;</td>
                                                            <td align="right"><strong id="uCode"></strong></td>
                                                        </tr>
                                                        <tr style="border-top: 1px solid #eee">
                                                            <td><strong>TOTAL</strong></td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td align="right">
                                                                <strong id="toPay"
                                                                        style="font-size: 18px;color: #00adb5"></strong>
                                                            </td>
                                                        </tr>
                                                        @if($pm->payment_category_id == 1)
                                                            <tr>
                                                                <td colspan="5" align="right"
                                                                    style="font-size:12px;color:#fa5555;font-weight:bold;">
                                                                    Transfer right up to the last 3 digits
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <small>Payment Proof</small>
                                                    <hr class="hr-divider">
                                                    <form id="file-upload-form" method="post"
                                                          enctype="multipart/form-data">
                                                        {{csrf_field()}}
                                                        {{ method_field('put') }}
                                                        <input type="hidden" name="confirmAgency_id"
                                                               value="{{session('confirmAgency')->id}}">
                                                        <div class="uploader">
                                                            <input id="file-upload" type="file" name="payment_proof"
                                                                   accept="image/*">
                                                            <label for="file-upload" id="file-drag">
                                                                <img id="file-image" src="#" alt="Payment Proof"
                                                                     class="hidden img-responsive">
                                                                <div id="start">
                                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                                    <div>Select your payment proof file or drag it here
                                                                    </div>
                                                                    <div id="notimage" class="hidden">Please select an
                                                                        image
                                                                    </div>
                                                                    <span id="file-upload-btn" class="btn btn-primary">
                                                                    Select a file</span>
                                                                </div>
                                                                <div id="response" class="hidden">
                                                                    <div id="messages"></div>
                                                                </div>
                                                                <div id="progress-upload">
                                                                    <div class="progress-bar progress-bar-info progress-bar-striped active"
                                                                         role="progressbar" aria-valuenow="0"
                                                                         aria-valuemin="0" aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <a href="{{route('invoice.job.posting', ['id' =>
                                            encrypt(session('confirmAgency')->id)])}}" target="_blank">
                                                <input type="button" class="btn-upload" value="Get your invoice here!">
                                            </a>
                                        </fieldset>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push("scripts")
    <script src="{{asset('js/jquery.cc.js')}}"></script>
    <script src="{{asset('js/TweenMax.min.js')}}"></script>
    <script>
        var plan_price = '{{$price}}', subtotal = 0, payment_code_value = 0,
            old_total_ads = '{{$totalAds}}',
            new_total_ads = '{{$totalAds}}',
            price_per_ads = '{{\App\Plan::find(1)->price - (\App\Plan::find(1)->price * \App\Plan::find(1)->discount/100)}}',

            old_total_quiz = '{{$plan->quiz_applicant}}',
            new_total_quiz = '{{$plan->quiz_applicant}}',
            price_per_quiz = '{{$plan->price_quiz_applicant}}',

            old_total_psychoTest = '{{$plan->psychoTest_applicant}}',
            new_total_psychoTest = '{{$plan->psychoTest_applicant}}',
            price_per_psychoTest = '{{$plan->price_psychoTest_applicant}}';

        $(".subtotal").text("Rp" + thousandSeparator(plan_price) + ",00");

        $("#show_plans_settings").click(function () {
            $(".stats_plans").toggle(300);
            $("#plans_settings").toggle(300);
        });

        $("#show_vacancy_setup").click(function () {
            $("#order_summary .previous").click();
        });

        $("#total_ads").on("change", function () {
            var value = parseInt($(this).val());
            if (value == "" || value < old_total_ads) {
                $(this).val(old_total_ads);
            }

            new_total_ads = $(this).val();

            if (parseInt(new_total_ads - old_total_ads) > 0) {
                $(".total_vacancy").text(old_total_ads + '(+' + parseInt(new_total_ads - old_total_ads) + ')');
                $(".total_price_vacancy").text('Rp' +
                    thousandSeparator(parseInt((new_total_ads - old_total_ads) * price_per_ads)) + ',00');
            } else {
                $(".total_vacancy").text(old_total_ads);
                $(".total_price_vacancy").text('Rp0,00');
            }

            $("#vacancy_id").val('default').selectpicker({maxOptions: new_total_ads}).selectpicker('refresh');

            subtotal = parseInt(plan_price) + parseInt((new_total_ads - old_total_ads) * price_per_ads) +
                parseInt((new_total_quiz - old_total_quiz) * price_per_quiz) +
                parseInt((new_total_psychoTest - old_total_psychoTest) * price_per_psychoTest);
            $(".subtotal").text("Rp" + thousandSeparator(subtotal) + ",00");
        });

        $("#total_quiz").on("change", function () {
            var value = parseInt($(this).val());
            if (value == "" || value < old_total_quiz) {
                $(this).val(old_total_quiz);
            }

            new_total_quiz = $(this).val();

            if (parseInt(new_total_quiz - old_total_quiz) > 0) {
                $(".bill_quiz_applicant").text(old_total_quiz + '(+' + parseInt(new_total_quiz - old_total_quiz) + ')');
                $(".total_price_quiz").text('Rp' +
                    thousandSeparator(parseInt((new_total_quiz - old_total_quiz) * price_per_quiz)) + ',00');
            } else {
                $(".bill_quiz_applicant").text(old_total_quiz);
                $(".total_price_quiz").text('Rp0,00');
            }

            subtotal = parseInt(plan_price) + parseInt((new_total_ads - old_total_ads) * price_per_ads) +
                parseInt((new_total_quiz - old_total_quiz) * price_per_quiz) +
                parseInt((new_total_psychoTest - old_total_psychoTest) * price_per_psychoTest);
            $(".subtotal").text("Rp" + thousandSeparator(subtotal) + ",00");
        });

        $("#total_psychoTest").on("change", function () {
            var value = parseInt($(this).val());
            if (value == "" || value < old_total_psychoTest) {
                $(this).val(old_total_psychoTest);
            }

            new_total_psychoTest = $(this).val();

            if (parseInt(new_total_psychoTest - old_total_psychoTest) > 0) {
                $(".bill_psychoTest_applicant").text(old_total_psychoTest + '(+' +
                    parseInt(new_total_psychoTest - old_total_psychoTest) + ')');
                $(".total_price_psychoTest").text('Rp' +
                    thousandSeparator(parseInt((new_total_psychoTest - old_total_psychoTest) * price_per_psychoTest)) +
                    ',00');
            } else {
                $(".bill_psychoTest_applicant").text(old_total_psychoTest);
                $(".total_price_psychoTest").text('Rp0,00');
            }

            subtotal = parseInt(plan_price) + parseInt((new_total_ads - old_total_ads) * price_per_ads) +
                parseInt((new_total_quiz - old_total_quiz) * price_per_quiz) +
                parseInt((new_total_psychoTest - old_total_psychoTest) * price_per_psychoTest);
            $(".subtotal").text("Rp" + thousandSeparator(subtotal) + ",00");
        });

        $("#vacancy_id").on('change', function () {
            $('html, body').animate({
                scrollTop: $('#job-posting').offset().top
            }, 500);

            var $id = $(this).val();
            $("#vacancy_list").removeClass('has-error');
            $(".aj_vacancy").text('');

            $('#vacancy_id option:selected').each(function (i, selected) {
                $.get('{{route('get.vacancyReviewData',['vacancy'=>''])}}/' + $id, function (data) {
                    var $pengalaman;
                    $result = '';
                    $.each(data, function (i, val) {
                        if (val.pengalaman > 1) {
                            $pengalaman = 'At least ' + val.pengalaman + ' years';
                        } else {
                            $pengalaman = 'At least ' + val.pengalaman + ' year';
                        }
                        $result +=
                            '<div class="media">' +
                            '<div class="media-left media-middle">' +
                            '<a href="{{route('agency.profile',['id' => ''])}}/' + val.agency_id + '">' +
                            '<img width="100" class="media-object" src="' + val.user.ava + '"></a></div>' +
                            '<div class="media-body">' +
                            '<small class="media-heading">' +
                            '<a style="color: #00ADB5" ' +
                            'href="{{route('detail.vacancy',['id' => ''])}}/' + val.id + '">' + val.judul +
                            '</a> <sub>– <a href="{{route('agency.profile',['id' => ''])}}/' + val.agency_id + '">'
                            + val.user.name + '</a></sub></small>' +
                            '<blockquote style="font-size: 12px;color: #7f7f7f">' +
                            '<ul class="list-inline">' +
                            '<li><a class="tag" target="_blank" ' +
                            'href="{{route('search.vacancy',['loc'=>''])}}/' + val.city + '">' +
                            '<i class="fa fa-map-marked"></i>&ensp;' + val.city + '</a></li>' +
                            '<li><a class="tag" target="_blank" ' +
                            'href="{{route('search.vacancy',['jobfunc_ids' => ''])}}/' + val.fungsikerja_id + '">' +
                            '<i class="fa fa-warehouse"></i>&ensp;' + val.job_func + '</a></li>' +
                            '<li><a class="tag" target="_blank" ' +
                            'href="{{route('search.vacancy',['industry_ids' => ''])}}/' + val.industry_id + '">' +
                            '<i class="fa fa-industry"></i>&ensp;' + val.industry + '</a></li>' +
                            '<li><a class="tag" target="_blank" ' +
                            'href="{{route('search.vacancy',['salary_ids' => ''])}}/' + val.salary_id + '">' +
                            '<i class="fa fa-money-bill-wave"></i>&ensp;IDR ' + val.salary + '</a></li>' +
                            '<li><a class="tag" target="_blank" ' +
                            'href="{{route('search.vacancy',['degrees_ids' => ''])}}/' + val.tingkatpend_id + '">' +
                            '<i class="fa fa-graduation-cap"></i>&ensp;' + val.degrees + '</a></li>' +
                            '<li><a class="tag" target="_blank" ' +
                            'href="{{route('search.vacancy',['majors_ids' => ''])}}/' + val.jurusanpend_id + '">' +
                            '<i class="fa fa-user-graduate"></i>&ensp;' + val.majors + '</a></li>' +
                            '<li><a class="tag"><i class="fa fa-briefcase"></i>&ensp;' + $pengalaman +
                            '</a></li></ul><small>Requirements</small>' + val.syarat +
                            '<small>Responsibilities</small>' + val.tanggungjawab + '</blockquote>' +
                            '</div></div><hr class="hr-divider">'
                    });
                    $("#vacancy_data").empty().append($result);
                });
            });
        });

        $("#vacancy_setup .next").click(function () {
            if (!$("#vacancy_id").val()) {
                $("#vacancy_list").addClass('has-error');
                $(".aj_vacancy").text('Please select a vacancy in order to posting it.');
                swal({
                    title: 'ATTENTION!',
                    text: 'There\'s empty field! Please fill in all the form fields with a valid data.',
                    type: 'warning',
                    timer: '3500'
                });
                $("#order_summary .previous").click();
            }
        });

        $("#plans_id").on('change', function () {
            $.get('{{route('get.plansReviewData',['plan'=>''])}}/' + $(this).val(), function (data) {
                if (data == 0) {
                    $("#plans_id").val('default').selectpicker("refresh");
                    swal({
                        title: 'ATTENTION!',
                        text: "This package requires at least " + data.job_ads + " Vacancy that have not been posted yet. It seems that the amount of your vacancy doesn't meet the minimal amount of this package.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00ADB5',
                        confirmButtonText: 'Yes, redirect me to the Vacancy Setup page.',
                        showLoaderOnConfirm: true,

                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                window.location.href = '{{route('agency.vacancy.show')}}';
                            });
                        },
                        allowOutsideClick: false
                    });
                    return false;

                } else {
                    plan_price = data.price;
                    old_total_ads = data.job_ads;
                    old_total_quiz = data.quiz_applicant;
                    price_per_quiz = data.price_quiz_applicant;
                    old_total_psychoTest = data.psychoTest_applicant;
                    price_per_psychoTest = data.price_psychoTest_applicant;

                    $("#show_plans_settings").click();
                    $(".plans_name").text(data.name);
                    $(".main_feature").text(data.main_feature);
                    $(".total_vacancy").text(old_total_ads);
                    $(".quiz_applicant, .bill_quiz_applicant").text(old_total_quiz);
                    $(".psychoTest_applicant, .bill_psychoTest_applicant").text(old_total_psychoTest);
                    $(".total_price_vacancy").text('Rp0,00');
                    $(".total_price_quiz").text('Rp0,00');
                    $(".total_price_psychoTest").text('Rp0,00');
                    $(".plan_price").text('Rp' + data.rp_price);
                    $(".subtotal").text("Rp" + thousandSeparator(plan_price) + ",00");

                    if (data.id == 1) {
                        swal({
                            title: 'ATTENTION!',
                            text: 'You\'ve just select BASIC Package, it means you are only permitted to ' +
                                'select one of your vacancies.',
                            type: 'warning',
                            timer: '5000'
                        });
                        $("#total_ads").val(data.job_ads).prop('min', data.job_ads);
                        $("#total_quiz").val(data.quiz_applicant).prop('min', data.quiz_applicant).prop('readonly', true);
                        $("#total_psychoTest").val(data.psychoTest_applicant).prop('min', data.psychoTest_applicant).prop('readonly', true);
                        $("#vacancy_id").val('default').selectpicker({maxOptions: data.job_ads}).selectpicker('refresh');
                        $("#order_summary .previous").click();

                    } else if (data.id == 2) {
                        swal({
                            title: 'ATTENTION!',
                            text: 'You\'ve just select PLUS Package, it means you are permitted to perform ' +
                                'multi-select of your vacancies.',
                            type: 'warning',
                            timer: '5000'
                        });
                        $("#total_ads").val(data.job_ads).prop('min', data.job_ads);
                        $("#total_quiz").val(data.quiz_applicant).prop('min', data.quiz_applicant).prop('readonly', false);
                        $("#total_psychoTest").val(data.psychoTest_applicant).prop('min', data.psychoTest_applicant).prop('readonly', true);
                        $("#vacancy_id").val('default').selectpicker({maxOptions: data.job_ads}).selectpicker('refresh');
                        $("#order_summary .previous").click();

                    } else if (data.id == 3) {
                        swal({
                            title: 'ATTENTION!',
                            text: 'You\'ve just select ENTERPRISE Package, it means you are permitted to perform ' +
                                'multi-select of your vacancies.',
                            type: 'warning',
                            timer: '5000'
                        });
                        $("#total_ads").val(data.job_ads).prop('min', data.job_ads);
                        $("#total_quiz").val(data.quiz_applicant).prop('min', data.quiz_applicant).prop('readonly', false);
                        $("#total_psychoTest").val(data.psychoTest_applicant).prop('min', data.psychoTest_applicant).prop('readonly', false);
                        $("#vacancy_id").val('default').selectpicker({maxOptions: data.job_ads}).selectpicker('refresh');
                        $("#order_summary .previous").click();
                    }
                }
                $(".accordion-toggle").addClass('collapsed');
                $(".panel-collapse").removeClass('in');
                $('html, body').animate({
                    scrollTop: $('#job-posting').offset().top
                }, 500);
            });
        });

        function paymentCategory(id) {
            var $pm_1 = $("#pm-details-1"), $pm_2 = $("#pm-details-2"), $pm_3 = $("#pm-11"),
                $pm_4 = $("#pm-details-4"), $pm_5 = $("#pm-details-5"), $payment_code = $("#payment_code");

            $pm_1.html("");
            $pm_2.html("");
            $pm_4.html("");
            $pm_5.html("");
            payment_code_value = 0;

            $(".pm-radioButton").prop("checked", false).trigger('change');
            $pm_3.prop("checked", false).trigger('change');

            $("#cc_number, #cc_name, #cc_expiry, #cc_cvc").val("");
            $(".jp-card").attr("class", "jp-card jp-card-unknown");
            $(".jp-card-number").html("•••• •••• •••• ••••");
            $(".jp-card-name").html("Your Name");
            $(".jp-card-expiry").html("MM/YYYY");
            $(".jp-card-cvc").html("•••");
            $payment_code.val(0);

            if (id == 1) {
                $pm_1.html(
                    '<div class="row">' +
                    '<div class="col-lg-12">' +
                    '<div class="alert alert-info text-center" role="alert" style="font-size: 13px">' +
                    'You will receive an email about your payment details as soon as you finish the current step.' +
                    '</div></div></div>'
                );
                payment_code_value = Math.floor(Math.random() * (999 - 100 + 1) + 100);
                $payment_code.val(payment_code_value);

            } else if (id == 3) {
                $("#pm-11").prop("checked", true).trigger('change');

            } else if (id == 4) {
                $pm_4.html(
                    '<div class="row">' +
                    '<div class="col-lg-12">' +
                    '<div class="alert alert-info text-center" role="alert" style="font-size: 13px">' +
                    'You will receive an email about your payment details as soon as you finish the current step.' +
                    '</div></div></div>'
                );
                $payment_code.val('{{str_random(15)}}');
            }
        }

        function paymentMethod(id) {
            $.get('{{route('get.paymentMethod',['id'=>''])}}/' + id, function (data) {
                if (data.payment_category_id == 2) {
                    $("#pm-details-2").html(
                        '<div class="row">' +
                        '<div class="col-lg-12">' +
                        '<div class="alert alert-info text-center" role="alert" style="font-size: 13px">' +
                        'You will be redirected to the <strong>' + data.name + '</strong> page as soon as you finish ' +
                        'the current step.</div></div></div>'
                    );

                } else if (data.payment_category_id == 5) {
                    $("#pm-details-5").html(
                        '<div class="row">' +
                        '<div class="col-lg-12">' +
                        '<div class="alert alert-info text-center" role="alert" style="font-size: 13px">' +
                        'You will be redirected to the <strong>' + data.name + '</strong> page as soon as you finish ' +
                        'the current step.</div></div></div>'
                    );
                }
            });
        }

        $('.msform').card({
            container: '.cc-wrapper',
            placeholders: {
                number: '•••• •••• •••• ••••',
                name: 'Your Name',
                expiry: 'MM/YYYY',
                cvc: '•••'
            },
            messages: {
                validDate: 'expire\ndate',
                monthYear: 'mm/yy'
            }
        });

        var current_fs, next_fs, previous_fs;
        var left, opacity, scale;
        var animating;

        $(".next").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            $('html, body').animate({
                scrollTop: $('#job-posting').offset().top
            }, 500);

            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            next_fs.show();
            current_fs.animate({opacity: 0}, {
                step: function (now, mx) {
                    scale = 1 - (1 - now) * 0.2;
                    left = (now * 50) + "%";
                    opacity = 1 - now;
                    current_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'position': 'absolute'
                    });
                    next_fs.css({'left': left, 'opacity': opacity});
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                easing: 'easeInOutBack'
            });
        });

        $(".previous").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            $('html, body').animate({
                scrollTop: $('#job-posting').offset().top
            }, 500);

            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            previous_fs.show();
            current_fs.animate({opacity: 0}, {
                step: function (now, mx) {
                    scale = 0.8 + (1 - now) * 0.2;
                    left = ((1 - now) * 50) + "%";
                    opacity = 1 - now;
                    current_fs.css({'left': left});
                    previous_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'position': 'relative', 'opacity': opacity
                    });
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                easing: 'easeInOutBack'
            });
        });

        $(".submit").click(function () {
            if ($(".pm-radioButton").is(":checked") || ($("#pm-11").is(":checked") && $("#cc_number,#cc_name,#cc_expiry,#cc_cvc").val())) {
                $("#total_payment").val(parseInt(subtotal) - parseInt(payment_code_value));
                $("#pm-form")[0].submit();
                $('html, body').animate({
                    scrollTop: $('#job-posting').offset().top
                }, 500);
            } else {
                swal({
                    title: 'ATTENTION!',
                    text: 'You\'re not selecting any payment method!',
                    type: 'warning',
                    timer: '3500'
                });
            }
        });

        @if(session('confirmAgency'))
        $("#vacancy_setup,#order_summary,#payment_method").css("display", 'none');
        $("#progressbar li").addClass("active");
        $("#proceeds").css("display", 'block');

        @php
            $agency = \App\Agencies::where('user_id', Auth::user()->id)->firstOrFail();
            $vacancies = \App\Vacancies::whereIn('id',(array)old('vacancy_id'))->where('agency_id',$agency->id)->get();
            $confirm = session('confirmAgency');
            $expDay = \Carbon\Carbon::parse($confirm->created_at)->addDay()->format('l, j F Y');
            $expTime = \Carbon\Carbon::parse($confirm->created_at)->addDay()->format('H:i');
        @endphp
        @foreach($vacancies as $row)
        $("#vac_id option[value='{{$row->id}}']").attr('selected', 'selected');
        @endforeach
        $(".countdown-h2").html('<sub>Expired <strong>Time</strong>: {{$expDay." at ".$expTime}}</sub>');

        var code = '{{session('confirmAgency')->payment_code}}', billTotal = '{{old('total_payment')}}',
            $strTotal, $first, $last;
        @if(\App\PaymentMethod::find($confirm->payment_method_id)->payment_category_id == 1)
        $("#uCode").text("-Rp" + code);
        if (billTotal < 1000000) {
            $first = thousandSeparator(billTotal).substr(0, 4);
        }
        else {
            $first = thousandSeparator(billTotal).substr(0, 6);
        }
        $last = thousandSeparator(billTotal).substr(thousandSeparator(billTotal).length - 3);
        $strTotal = "Rp" + $first + "<span style='border:1px solid #fa5555;'>" + $last + "</span>";
        @else
        $("#uCode").text("-Rp0");
        $strTotal = "Rp" + thousandSeparator(billTotal);
        @endif
        $("#toPay").html($strTotal);

        var Countdown = {
            $el: $('.countdown'),

            countdown_interval: null,
            total_seconds: 0,

            init: function () {
                this.$ = {
                    hours: this.$el.find('.bloc-time.hours .figure'),
                    minutes: this.$el.find('.bloc-time.min .figure'),
                    seconds: this.$el.find('.bloc-time.sec .figure')
                };

                this.values = {
                    hours: this.$.hours.parent().attr('data-init-value'),
                    minutes: this.$.minutes.parent().attr('data-init-value'),
                    seconds: this.$.seconds.parent().attr('data-init-value'),
                };

                this.total_seconds = this.values.hours * 60 * 60 + (this.values.minutes * 60) + this.values.seconds;

                this.count();
            },

            count: function () {
                var that = this,
                    $hour_1 = this.$.hours.eq(0),
                    $hour_2 = this.$.hours.eq(1),
                    $min_1 = this.$.minutes.eq(0),
                    $min_2 = this.$.minutes.eq(1),
                    $sec_1 = this.$.seconds.eq(0),
                    $sec_2 = this.$.seconds.eq(1);

                this.countdown_interval = setInterval(function () {

                    if (that.total_seconds > 0) {

                        --that.values.seconds;

                        if (that.values.minutes >= 0 && that.values.seconds < 0) {

                            that.values.seconds = 59;
                            --that.values.minutes;
                        }

                        if (that.values.hours >= 0 && that.values.minutes < 0) {

                            that.values.minutes = 59;
                            --that.values.hours;
                        }

                        that.checkHour(that.values.hours, $hour_1, $hour_2);

                        that.checkHour(that.values.minutes, $min_1, $min_2);

                        that.checkHour(that.values.seconds, $sec_1, $sec_2);

                        --that.total_seconds;
                    }
                    else {
                        clearInterval(that.countdown_interval);
                    }
                }, 1000);
            },

            animateFigure: function ($el, value) {
                var that = this,
                    $top = $el.find('.top'),
                    $bottom = $el.find('.bottom'),
                    $back_top = $el.find('.top-back'),
                    $back_bottom = $el.find('.bottom-back');

                $back_top.find('span').html(value);

                $back_bottom.find('span').html(value);

                TweenMax.to($top, 0.8, {
                    rotationX: '-180deg',
                    transformPerspective: 300,
                    ease: Quart.easeOut,
                    onComplete: function () {

                        $top.html(value);

                        $bottom.html(value);

                        TweenMax.set($top, {rotationX: 0});
                    }
                });

                TweenMax.to($back_top, 0.8, {
                    rotationX: 0,
                    transformPerspective: 300,
                    ease: Quart.easeOut,
                    clearProps: 'all'
                });
            },

            checkHour: function (value, $el_1, $el_2) {
                var val_1 = value.toString().charAt(0),
                    val_2 = value.toString().charAt(1),
                    fig_1_value = $el_1.find('.top').html(),
                    fig_2_value = $el_2.find('.top').html();

                if (value >= 10) {
                    if (fig_1_value !== val_1) this.animateFigure($el_1, val_1);
                    if (fig_2_value !== val_2) this.animateFigure($el_2, val_2);
                }
                else {
                    if (fig_1_value !== '0') this.animateFigure($el_1, 0);
                    if (fig_2_value !== val_1) this.animateFigure($el_2, val_1);
                }
            }
        };
        Countdown.init();

        function ekUpload() {
            function Init() {
                var fileSelect = document.getElementById('file-upload'),
                    fileDrag = document.getElementById('file-drag');

                fileSelect.addEventListener('change', fileSelectHandler, false);

                var xhr = new XMLHttpRequest();
                if (xhr.upload) {
                    fileDrag.addEventListener('dragover', fileDragHover, false);
                    fileDrag.addEventListener('dragleave', fileDragHover, false);
                    fileDrag.addEventListener('drop', fileSelectHandler, false);
                }
            }

            function fileDragHover(e) {
                var fileDrag = document.getElementById('file-drag');

                e.stopPropagation();
                e.preventDefault();

                fileDrag.className = (e.type === 'dragover' ? 'hover' : 'modal-body file-upload');
            }

            function fileSelectHandler(e) {
                var files = e.target.files || e.dataTransfer.files;
                $("#file-upload").prop("files", files);

                fileDragHover(e);

                for (var i = 0, f; f = files[i]; i++) {
                    uploadPaymentProof(f);
                }
            }

            function uploadPaymentProof(file) {
                var files_size = file.size, max_file_size = 2000000, file_name = file.name,
                    allowed_file_types = (/\.(?=gif|jpg|png|jpeg)/gi).test(file_name);

                if (!window.File && window.FileReader && window.FileList && window.Blob) {
                    swal({
                        title: 'Attention!',
                        text: "Your browser does not support new File API! Please upgrade.",
                        type: 'warning',
                        timer: '3500'
                    });

                } else {
                    if (files_size > max_file_size) {
                        swal({
                            title: 'Payment Proof',
                            text: file_name + " with total size " + filesize(files_size) + ", Allowed size is " + filesize(max_file_size) + ", Try smaller file!",
                            type: 'error',
                            timer: '3500'
                        });
                        output('Please upload a smaller file (< ' + filesize(max_file_size) + ').');
                        document.getElementById('file-image').classList.add("hidden");
                        document.getElementById('start').classList.remove("hidden");
                        document.getElementById("file-upload-form").reset();

                    } else {
                        if (!allowed_file_types) {
                            swal({
                                title: 'Payment Proof',
                                text: file.name + " is unsupported file type!",
                                type: 'error',
                                timer: '3500'
                            });
                            document.getElementById('file-image').classList.add("hidden");
                            document.getElementById('notimage').classList.remove("hidden");
                            document.getElementById('start').classList.remove("hidden");
                            document.getElementById('response').classList.add("hidden");
                            document.getElementById("file-upload-form").reset();

                        } else {
                            $.ajax({
                                type: 'POST',
                                url: '{{route('upload.paymentProof')}}',
                                data: new FormData($("#file-upload-form")[0]),
                                contentType: false,
                                processData: false,
                                mimeType: "multipart/form-data",
                                xhr: function () {
                                    var xhr = $.ajaxSettings.xhr(),
                                        progress_bar_id = $("#progress-upload .progress-bar");
                                    if (xhr.upload) {
                                        xhr.upload.addEventListener('progress', function (event) {
                                            var percent = 0;
                                            var position = event.loaded || event.position;
                                            var total = event.total;
                                            if (event.lengthComputable) {
                                                percent = Math.ceil(position / total * 100);
                                            }
                                            progress_bar_id.css("display", "block");
                                            progress_bar_id.css("width", +percent + "%");
                                            progress_bar_id.text(percent + "%");
                                            if (percent == 100) {
                                                progress_bar_id.removeClass("progress-bar-info");
                                                progress_bar_id.addClass("progress-bar-success");
                                            } else {
                                                progress_bar_id.removeClass("progress-bar-success");
                                                progress_bar_id.addClass("progress-bar-info");
                                            }
                                        }, true);
                                    }
                                    return xhr;
                                },
                                success: function (data) {
                                    swal({
                                        title: 'Job Posting',
                                        text: 'Payment proof is successfully uploaded! To check whether ' +
                                            'your vacancy is already posted or not, please check ' +
                                            'Vacancy Status in your dashboard.',
                                        type: 'success',
                                        timer: '7000'
                                    });

                                    output('<strong>' + data + '</strong>');
                                    document.getElementById('start').classList.add("hidden");
                                    document.getElementById('response').classList.remove("hidden");
                                    document.getElementById('notimage').classList.add("hidden");
                                    document.getElementById('file-image').classList.remove("hidden");
                                    $("#file-image").attr('src', '{{asset('storage/users/agencies/payment/')}}/' + data);
                                    $("#progress-upload").css("display", "none");
                                },
                                error: function () {
                                    swal({
                                        title: 'Oops...',
                                        text: 'Something went wrong!',
                                        type: 'error',
                                        timer: '1500'
                                    })
                                }
                            });
                            return false;
                        }
                    }
                }
            }

            function output(msg) {
                var m = document.getElementById('messages');
                m.innerHTML = msg;
            }

            if (window.File && window.FileList && window.FileReader) {
                Init();
            } else {
                document.getElementById('file-drag').style.display = 'none';
            }
        }

        ekUpload();

        $(window).on('beforeunload', function () {
            return false;
        });
        @endif
    </script>
@endpush