@extends('layouts.mst_user')
@section('title', 'Job Posting Process | '.env('APP_TITLE'))
@push('styles')
    <link href="{{ asset('css/mySearchFilter.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myMultiStepForm.css') }}" rel="stylesheet">
    <link href="{{ asset('css/countdown.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fileUploader.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cc.css') }}" rel="stylesheet">
    <style>
        [data-scrollbar], .nicescrolls {
            max-height: 400px
        }

        .accordion .panel-heading .accordion-toggle::before,
        .accordion .panel-heading .accordion-toggle.collapsed::before {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        .list-group {
            font-size: 16px;
        }

        .list-group-item {
            padding: 5px 0;
            border: 0;
        }

        .msform .action-button {
            text-transform: uppercase;
        }
    </style>
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
                                                    <small>Total Ads & Vacancy List</small>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-briefcase"></i></span>
                                                        <input id="total_ads" name="total_ads" type="number"
                                                               class="form-control" placeholder="0" style="width: 25%"
                                                               value="{{$totalAds}}" min="{{$totalAds}}" required>
                                                        <select id="vacancy_id" class="form-control selectpicker"
                                                                title="-- Select Vacancy --" data-live-search="true"
                                                                multiple data-max-options="{{$totalAds}}"
                                                                data-selected-text-format="count > 2"
                                                                name="vacancy_ids[]" data-container="body"
                                                                data-width="75%" required>
                                                            @foreach($vacancies as $vacancy)
                                                                <option value="{{$vacancy->id}}">
                                                                    {{$vacancy->judul}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <span class="help-block">
                                                        <small class="vacancy_errorTxt"
                                                               style="text-transform: none;float: left"></small>
                                                    </span>
                                                </div>
                                            </div>
                                            <hr class="hr-divider" id="vacancySetupDivider" style="display:none">
                                            <img src="{{asset('images/loading3.gif')}}" id="image"
                                                 class="img-responsive ld ld-fade" style="display:none;margin: 0 auto">
                                            <div id="input_quiz_psychoTest"></div>
                                            <div class="row form-group" style="margin-top: -1em">
                                                <div class="col-lg-6" id="quiz_error">
                                                    <span class="help-block"><small
                                                                style="text-transform: none;float: left;text-align: justify"></small></span>
                                                </div>
                                                <div class="col-lg-6" id="psychoTest_error">
                                                    <span class="help-block"><small
                                                                style="text-transform: none;float: left;text-align: justify"></small></span>
                                                </div>
                                            </div>
                                            <hr class="hr-divider">
                                            <input type="button" name="next" class="next action-button" value="Next"
                                                   style="display: table">
                                        </fieldset>

                                        <fieldset id="order_summary">
                                            <h2 class="fs-title text-center">Order Summary</h2>
                                            <h3 class="fs-subtitle text-center">
                                                Make sure your order details and the vacancy that you want
                                                to post is correct</h3>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-6 col-sm-6">
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
                                                                Total Participant for Quiz:
                                                                <strong class="quiz_applicant">
                                                                    {{$plan->quiz_applicant}}</strong> persons
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="tag tag-plans">
                                                                <i class="fa fa-comments"></i>&ensp;
                                                                Total Participant for Psycho Test:
                                                                <strong class="psychoTest_applicant">
                                                                    {{$plan->psychoTest_applicant}}</strong> persons
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
                                                <div class="col-lg-5 col-md-6 col-sm-6">
                                                    <small>Billing Details
                                                        <span id="show_billing_settings" class="pull-right ld ld-breath"
                                                              style="color: #fa5555;cursor: pointer; font-size: 15px">
                                                            <i class="fa fa-ticket-alt"></i>&nbsp;VOUCHER</span>
                                                    </small>
                                                    <hr class="hr-divider mb-0">
                                                    <ul class="stats-billing list-group list-group-flush mb-0">
                                                        <li class="list-group-item border-none">
                                                            <strong class="plans_name text-uppercase">
                                                                {{$plan->name}}</strong>
                                                            <b class="float-right plan_price">
                                                                Rp{{number_format($price,2,',','.')}}</b>
                                                        </li>
                                                        <li class="list-group-item border-none">
                                                            Job Ads [<strong
                                                                    class="total_vacancy">{{$totalAds}}</strong>]
                                                            <b class="float-right total_price_vacancy">
                                                                Rp{{number_format(0,2,',','.')}}</b>
                                                        </li>
                                                        <li class="list-group-item border-none" data-placement="left"
                                                            data-toggle="tooltip" title="Total Participant for">
                                                            Quiz [<strong
                                                                    class="bill_quiz_applicant">{{$plan->quiz_applicant}}</strong>]
                                                            <b class="float-right total_price_quiz">
                                                                Rp{{number_format(0,2,',','.')}}</b>
                                                        </li>
                                                        <li class="list-group-item border-none" data-placement="left"
                                                            data-toggle="tooltip" title="Total Participant for">
                                                            Psycho Test [<strong
                                                                    class="bill_psychoTest_applicant">{{$plan->psychoTest_applicant}}</strong>]
                                                            <b class="float-right total_price_psychoTest">
                                                                Rp{{number_format(0,2,',','.')}}</b>
                                                        </li>
                                                        <li class="discount list-group-item border-none" style="display: none">
                                                            Discount <strong></strong>
                                                            <i class="icon-trash-o ml-1" data-toggle="tooltip"
                                                               data-placement="right" title="HAPUS"
                                                               style="cursor:pointer;float:none"></i>
                                                            <b class="float-right" style="color: #fa5555">
                                                                -Rp{{number_format($price,2,',','.')}}</b>
                                                        </li>
                                                    </ul>
                                                    <hr class="stats-billing hr-divider my-0"
                                                        style="border: 1px solid #eee">
                                                    <ul class="stats-billing list-group list-group-flush mb-0">
                                                        <li class="list-group-item border-none">
                                                            TOTAL<b class="float-right subtotal"
                                                                    style="font-size: large;color: #00adb5"></b>
                                                        </li>
                                                    </ul>
                                                    <div id="billing_settings" style="display: none;margin-top: 20px">
                                                        <div class="row form-group">
                                                            <div class="col-lg-12">
                                                                <div class="input-group">
                                                                    <input id="promo_code" type="text" name="promo_code"
                                                                           style="font-size: 14px" class="form-control"
                                                                           placeholder="Masukkan kode promo Anda...">
                                                                    <span class="input-group-btn">
                                                                        <button id="btn_set" class="btn btn-primary"
                                                                                type="button" style="font-size: 13px"
                                                                                disabled>SET</button>
                                                                    </span>
                                                                </div>
                                                                <span id="error_promo" class="help-block">
                                                                    <b style="text-transform: none"></b>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 1em;">
                                                <div class="col-lg-12">
                                                    <small>Vacancy Details
                                                        <span class="show_vacancy_setup pull-right"
                                                              style="color: #00ADB5;cursor: pointer; font-size: 15px">
                                                <i class="fa fa-edit"></i>&nbsp;EDIT</span>
                                                    </small>
                                                    <hr class="hr-divider">
                                                    <div class="nicescrolls">
                                                        <div id="vacancy_data"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="button" name="previous" class="previous action-button"
                                                   value="Previous">
                                            <input type="button" name="next" class="next action-button" value="Next">
                                        </fieldset>

                                        <fieldset id="payment_method">
                                            <h2 class="fs-title text-center">Payment Method</h2>
                                            <h3 class="fs-subtitle text-center">Select one of the following payment
                                                methods before completing your payment</h3>
                                            <hr class="hr-divider">
                                            <img src="{{asset('images/loading.gif')}}" id="image2"
                                                 class="img-responsive ld ld-fade" style="display:none;margin: 0 auto">
                                            <input type="button" name="previous" class="previous action-button"
                                                   value="Previous">
                                            <input type="button" name="next" class="next action-button" value="Checkout">
                                        </fieldset>

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
                                                    <strong>to any party</strong> except {{env('APP_NAME')}}.
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="row" id="stats_payment">
                                                        <div class="col-lg-12">
                                                            <small>Payment Method</small>
                                                            <hr class="hr-divider">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <img width="100" class="media-object" src="#" alt="icon">
                                                                </div>
                                                                <div class="media-body">
                                                                    <blockquote style="font-size:12px;color:#7f7f7f"></blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="isPaid">
                                                        <div class="col-lg-12">
                                                            <small>Payment Status</small>
                                                            <hr class="hr-divider">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <img width="100" class="media-object" src="#" alt="icon">
                                                                </div>
                                                                <div class="media-body">
                                                                    <blockquote style="font-size:12px;color:#7f7f7f"></blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" id="stats_billing">
                                                    <small>
                                                        <a class="invoice-route" target="_blank" href="#"
                                                           style="text-decoration: none;color: #00adb5">
                                                            <strong></strong></a>
                                                    </small>
                                                    <hr class="hr-divider">
                                                    <ul class="stats-billing list-group list-group-flush mb-0">
                                                        <li class="list-group-item border-none">
                                                            <strong class="plans_name text-uppercase">
                                                                {{$plan->name}}</strong>
                                                            <b class="float-right plan_price">
                                                                Rp{{number_format($price,2,',','.')}}</b>
                                                        </li>
                                                        <li class="list-group-item border-none">
                                                            Job Ads [<strong
                                                                    class="total_vacancy">{{$totalAds}}</strong>]
                                                            <b class="float-right total_price_vacancy">
                                                                Rp{{number_format(0,2,',','.')}}</b>
                                                        </li>
                                                        <li class="list-group-item border-none" data-placement="left"
                                                            data-toggle="tooltip" title="Total Participant for">
                                                            Quiz [<strong
                                                                    class="bill_quiz_applicant">{{$plan->quiz_applicant}}</strong>]
                                                            <b class="float-right total_price_quiz">
                                                                Rp{{number_format(0,2,',','.')}}</b>
                                                        </li>
                                                        <li class="list-group-item border-none" data-placement="left"
                                                            data-toggle="tooltip" title="Total Participant for">
                                                            Psycho Test [<strong
                                                                    class="bill_psychoTest_applicant">{{$plan->psychoTest_applicant}}</strong>]
                                                            <b class="float-right total_price_psychoTest">
                                                                Rp{{number_format(0,2,',','.')}}</b>
                                                        </li>
                                                        <li class="discount list-group-item border-none" style="display: none">
                                                            Discount <strong></strong>
                                                            <b class="float-right" style="color: #fa5555">
                                                                -Rp{{number_format($price,2,',','.')}}</b>
                                                        </li>
                                                    </ul>
                                                    <hr class="stats-billing hr-divider my-0"
                                                        style="border: 1px solid #eee">
                                                    <ul class="stats-billing list-group list-group-flush mb-0">
                                                        <li class="list-group-item border-none">
                                                            TOTAL<b class="float-right subtotal"
                                                                    style="font-size: large;color: #00adb5"></b>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <a class="invoice-route" target="_blank" href="#">
                                                <input type="button" class="btn-upload" value="GET YOUR INVOICE HERE!">
                                            </a>
                                        </fieldset>

                                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                                        <input type="hidden" id="total_quiz" name="total_quiz">
                                        <input type="hidden" id="total_psychoTest" name="total_psychoTest">
                                        <input type="hidden" name="discount">
                                        <input type="hidden" name="discount_price">
                                        <input type="hidden" name="total_payment" id="total_payment">
                                        <input type="hidden" name="transaction_id">
                                        <input type="hidden" name="pdf_url">
                                    </form>
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
    <script src="{{asset('js/TweenMax.min.js')}}"></script>
    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{env('MIDTRANS_SERVER_KEY')}}"></script>
    <script>
        $(function () {
            $(".nicescrolls").niceScroll({
                cursorcolor: "{{Auth::guard('admin')->check() || Auth::check() && Auth::user()->isAgency() ? 'rgb(0,173,181)' : 'rgb(255,85,85)'}}",
                cursorwidth: "8px",
                background: "rgba(222, 222, 222, .75)",
                cursorborder: 'none',
                // cursorborderradius:0,
                autohidemode: 'leave',
            });
        });

        var isQuiz = '{{$plan->isQuiz}}', isPsychoTest = '{{$plan->isPsychoTest}}', plan_price = '{{$price}}',
            subtotal = parseInt(plan_price), harga_diskon = 0,

            $attr_passingGrade = '{{$plan->isQuiz == false ? 'readonly' : ''}}',
            $attr_quiz = '{{$plan->isQuiz == false ? 'readonly' : ''}}',
            $attr_psychoTest = '{{$plan->isPsychoTest == false ? 'readonly' : ''}}',

            old_total_ads = '{{$totalAds}}',
            new_total_ads = '{{$totalAds}}',
            price_per_ads = '{{\App\Plan::find(1)->price - (\App\Plan::find(1)->price * \App\Plan::find(1)->discount/100)}}',

            total_quiz_applicant = 0,
            old_total_quiz = '{{$plan->quiz_applicant}}',
            price_per_quiz = '{{$plan->price_quiz_applicant}}',

            total_psychoTest_applicant = 0,
            old_total_psychoTest = '{{$plan->psychoTest_applicant}}',
            price_per_psychoTest = '{{$plan->price_psychoTest_applicant}}',

            current_fs, next_fs, previous_fs, left, opacity, scale, animating;

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

        $(".subtotal").text("Rp" + number_format(subtotal, 2, ',', '.'));

        $("#show_plans_settings").click(function () {
            $(".stats_plans").toggle(300);
            $("#plans_settings").toggle(300);
        });

        $("#show_billing_settings").click(function () {
            $(".stats-billing").toggle(300);
            $("#billing_settings").toggle(300);
        });

        $("#promo_code").on('keyup', function (e) {
            if (!$(this).val()) {
                $("#btn_set").attr('disabled', 'disabled');
            } else {
                $("#btn_set").removeAttr('disabled');
                if (e.keyCode === 13) {
                    $("#btn_set").click();
                }
            }

            $("#promo_code").css('border-color', '#ced4da');
            $("#error_promo").hide().find('b').text(null);
        });

        $("#btn_set").on('click', function () {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: '{{route('get.promo',['kode'=>''])}}/' + $("#promo_code").val() + '?subtotal=' + subtotal,
                    type: "GET",
                    success: function (data) {
                        if (data == 0) {
                            swal({
                                title: 'Kode Promo',
                                text: 'Kode promo yang Anda masukkan tidak ditemukan.',
                                type: 'error',
                                timer: '3500',
                                confirmButtonColor: '#fa5555',
                            });
                            $("#promo_code").css('border-color', '#dc3545');
                            $("#error_promo").show().find('b').text("Kode promo yang Anda masukkan tidak ditemukan.").css('color', '#dc3545');
                            $("#btn_set").attr('disabled', 'disabled');
                            resetter();

                        } else if (data == 1) {
                            swal({
                                title: 'Kode Promo',
                                text: 'Anda telah menggunakan kode promo itu!',
                                type: 'error',
                                timer: '3500',
                                confirmButtonColor: '#fa5555',
                            });
                            $("#promo_code").css('border-color', '#dc3545');
                            $("#error_promo").show().find('b').text("Anda telah menggunakan kode promo itu!").css('color', '#dc3545');
                            $("#btn_set").attr('disabled', 'disabled');
                            resetter();

                        } else if (data == 2) {
                            swal({
                                title: 'Kode Promo',
                                text: 'Kode promo yang Anda masukkan telah kedaluwarsa.',
                                type: 'error',
                                timer: '3500',
                                confirmButtonColor: '#fa5555',
                            });
                            $("#promo_code").css('border-color', '#dc3545');
                            $("#error_promo").show().find('b').text("Kode promo yang Anda masukkan telah kedaluwarsa.").css('color', '#dc3545');
                            $("#btn_set").attr('disabled', 'disabled');
                            resetter();

                        } else {
                            swal({
                                title: 'Kode Promo',
                                text: data.caption,
                                type: 'success',
                                confirmButtonColor: '#00adb5',
                                timer: '3500'
                            });

                            harga_diskon = data.discount_price;
                            $("#promo_code").css('border-color', '#ced4da');
                            $("#error_promo").show().find('b').text(data.caption).css('color', '#00adb5');
                            $("#btn_set").removeAttr('disabled');

                            $(".discount").show().find('strong').text(data.discount + '%');
                            $(".discount b").text(data.str_discount);
                            $(".subtotal").text(data.str_total);
                            $("#pm-form input[name=discount]").val(data.discount);
                            $("#pm-form input[name=discount_price]").val(harga_diskon);
                            $("#pm-form input[name=total_payment]").val(data.total);

                            $("#show_billing_settings").click();
                        }
                    },
                    error: function () {
                        swal({
                            title: 'Oops..',
                            text: 'Terjadi kesalahan! Silahkan, segarkan browser Anda.',
                            type: 'error',
                            timer: '3500',
                            confirmButtonColor: '#fa5555',
                        });
                    }
                });
            }.bind(this), 800);
        });

        $(".discount i").on("click", function () {
            swal({
                title: "Apakah Anda yakin?",
                text: "Anda tidak dapat mengembalikannya!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Ya',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        swal({
                            type: 'success',
                            timer: '3500',
                            showConfirmButton: false,
                        });
                        resetter();
                    });
                },
                allowOutsideClick: false
            });
        });

        function resetter() {
            harga_diskon = 0;
            $(".discount").hide().find('b').text(null);
            $(".subtotal").text('Rp' + number_format(subtotal,2,',','.'));
            $("#pm-form input[name=discount], #pm-form input[name=discount_price]").val(null);
            $("#pm-form input[name=total_payment]").val(subtotal);
        }

        $(".show_vacancy_setup").click(function () {
            $("#order_summary .previous").click();
        });

        $("#total_ads").on("change", function () {
            if ($(this).val() == "" || parseInt($(this).val()) < old_total_ads) {
                $(this).val(old_total_ads);
                $("#vacancy_list").addClass('has-error');
                $(".vacancy_errorTxt").text("The ads/vacancy amount you've entered doesn't meet " +
                    "the minimum requirements of this package (" + old_total_ads + " job ads).");

            } else if (parseInt($(this).val()) > '{{count($vacancies)}}') {
                $(this).val('{{count($vacancies)}}');
                $("#vacancy_list").addClass('has-error');
                $(".vacancy_errorTxt").text("The ads/vacancy amount you've entered is more than that you have " +
                    "({{count($vacancies) > 1 ? count($vacancies).' vacancies' : count($vacancies).' vacancy'}}).");
            } else {
                $("#vacancy_list").removeClass('has-error');
                $(".vacancy_errorTxt").text('');
            }

            new_total_ads = $(this).val();

            if (parseInt(new_total_ads - old_total_ads) > 0) {
                $(".total_vacancy").text(old_total_ads + ' (+' + parseInt(new_total_ads - old_total_ads) + ')');
                $(".total_price_vacancy").text('Rp' +
                    number_format(parseInt((new_total_ads - old_total_ads) * price_per_ads), 2, ',', '.'));
            } else {
                $(".total_vacancy").text(old_total_ads);
                $(".total_price_vacancy").text('Rp0,00');
            }

            total_quiz_applicant = 0;
            total_psychoTest_applicant = 0;

            $("#vacancy_data").html('');
            $("#input_quiz_psychoTest").html('');
            $("#quiz_error, #psychoTest_error").removeClass('has-error');
            $("#quiz_error small, #psychoTest_error small").text('');
            $("#vacancySetupDivider").css('display', 'none');
            $("#vacancy_id").val('default').selectpicker({maxOptions: new_total_ads}).selectpicker('refresh');

            resetter();
        });

        $("#vacancy_id").on('change', function () {
            var $id = $(this).val();

            $('#vacancy_id option:selected').each(function (i, selected) {
                setTimeout(loadVacancyReviewData($id), 1000);
            });

            total_quiz_applicant = 0;
            total_psychoTest_applicant = 0;

            $("#vacancySetupDivider").css('display', 'block');
            $("#vacancy_list").removeClass('has-error');
            $(".vacancy_errorTxt").text('');

            resetter();
            $('html, body').animate({
                scrollTop: $('#job-posting').offset().top
            }, 500);
        });

        function loadVacancyReviewData($id) {
            $.ajax({
                url: '{{route('get.vacancyReviewData',['vacancy'=>''])}}/' + $id,
                type: "GET",
                data: $("#vacancy_id"),
                beforeSend: function () {
                    $('#image').show();
                    $('#input_quiz_psychoTest').hide();
                },
                complete: function () {
                    $('#image').hide();
                    $('#input_quiz_psychoTest').show();
                },
                success: function (data) {
                    var $vacancy_list = '', input_quiz_psychoTest = '', $pengalaman;

                    $.each(data, function (i, val) {
                        $pengalaman = val.pengalaman > 1 ? 'At least ' + val.pengalaman + ' years' :
                            'At least ' + val.pengalaman + ' year';
                        $vacancy_list +=
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
                            '<li><a class="tag"><i class="fa fa-briefcase"></i>&ensp;' + $pengalaman + '</a></li>' +
                            '<li><a class="tag tag-plans"><i class="fa fa-grin-beam"></i>&ensp;' +
                            'Quiz with <strong id="detail_passing_grade' + val.id + '">0.00</strong> ' +
                            'passing grade &ndash; for &ndash; <strong id="detail_quiz_applicant' + val.id + '">' +
                            '' + old_total_quiz + '</strong> participants</a></li>' +
                            '<li><a class="tag tag-plans"><i class="fa fa-comments"></i>&ensp;Psycho Test for ' +
                            '<strong id="detail_psychoTest_applicant' + val.id + '">' +
                            '' + old_total_psychoTest + '</strong> participants</a></li>' +
                            '</ul>' +
                            '<small>Requirements</small>' + val.syarat +
                            '<small>Responsibilities</small>' + val.tanggungjawab + '</blockquote>' +
                            '</div></div><hr class="hr-divider">';

                        input_quiz_psychoTest +=
                            '<div class="row form-group" style="margin-bottom: 0">' +
                            '<div class="col-lg-12">' +
                            '<small><strong>' + val.judul + '</strong></small></div></div>' +
                            '<div class="row form-group" style="margin-bottom: 1.5em">' +
                            '<div class="col-lg-6 quiz_setup">' +
                            '<small>Passing Grade & Total Participant for Quiz</small>' +
                            '<div class="input-group">' +
                            '<span class="input-group-addon"><i class="fa fa-grin-beam"></i></span>' +
                            '<input id="passing_grade' + val.id + '" name="passing_grade[]" ' +
                            'type="number" class="form-control input_passing_grade" style="width: 30%" ' +
                            'placeholder="0.00" value="0.00" min="0" onchange="passingGrade(' + val.id + ')" ' +
                            'step=".01" ' + $attr_passingGrade + '  required>' +
                            '<input id="quiz_applicant' + val.id + '" name="quiz_applicant[]" style="width: 70%" ' +
                            'type="number" class="form-control input_quiz_applicant" placeholder="0" value="0" ' +
                            'min="0" ' + $attr_quiz + ' onchange="quizApplicant(' + val.id + ')" required>' +
                            '</div></div>' +
                            '<div class="col-lg-6 psychoTest_setup">' +
                            '<small>Total Participant for Psycho Test</small>' +
                            '<div class="input-group">' +
                            '<span class="input-group-addon"><i class="fa fa-comments"></i></span>' +
                            '<input id="psychoTest_applicant' + val.id + '" ' +
                            'name="psychoTest_applicant[]" type="number" class="form-control input_psychoTest_applicant" ' +
                            'placeholder="0" value="0" min="0" ' + $attr_psychoTest + ' ' +
                            'onchange="psychoTestApplicant(' + val.id + ')" required></div>' +
                            '</div></div>'
                    });
                    $("#vacancy_data").html($vacancy_list);
                    $("#input_quiz_psychoTest").html(input_quiz_psychoTest);
                },
                error: function () {
                    swal({
                        title: 'Oops...',
                        text: 'Something went wrong! Please refresh the page.',
                        type: 'error',
                        timer: '1500',
                        confirmButtonColor: '#fa5555',
                    })
                }
            });
            return false;
        }

        function passingGrade(id) {
            if ($("#passing_grade" + id).val() == "" || parseFloat($("#passing_grade" + id).val()) < 0.00) {
                $("#passing_grade" + id).val(0.00);
            } else if (parseFloat($("#passing_grade" + id).val()) > 100) {
                $("#passing_grade" + id).val(75.5);
            }
            $("#detail_passing_grade" + id).text(parseFloat($("#passing_grade" + id).val()));
        }

        function quizApplicant(id) {
            if ($("#quiz_applicant" + id).val() == "" || parseInt($("#quiz_applicant" + id).val()) < 0) {
                $("#quiz_applicant" + id).val(0);
            }
            $("#detail_quiz_applicant" + id).text(parseInt($("#quiz_applicant" + id).val()));
        }

        function psychoTestApplicant(id) {
            if ($("#psychoTest_applicant" + id).val() == "" || parseInt($("#psychoTest_applicant" + id).val()) < 0) {
                $("#psychoTest_applicant" + id).val(0);
            }
            $("#detail_psychoTest_applicant" + id).text(parseInt($("#psychoTest_applicant" + id).val()));
        }

        function totalQuiz() {
            total_quiz_applicant = 0;
            obj = $('.input_quiz_applicant');
            for (i = 0; i < obj.length; i++) {
                total_quiz_applicant += parseInt(obj.eq(i).val());
            }

            if (parseInt(total_quiz_applicant - old_total_quiz) > 0) {
                $(".bill_quiz_applicant").text(old_total_quiz + ' (+' + parseInt(total_quiz_applicant - old_total_quiz) + ')');
                $(".total_price_quiz").text('Rp' +
                    number_format(parseInt((total_quiz_applicant - old_total_quiz) * price_per_quiz), 2, ',', '.'));
            } else {
                $(".bill_quiz_applicant").text(old_total_quiz);
                $(".total_price_quiz").text('Rp0,00');
            }

            $("#total_quiz").val(total_quiz_applicant);
        }

        function totalPsychoTest() {
            total_psychoTest_applicant = 0;
            obj = $('.input_psychoTest_applicant');
            for (i = 0; i < obj.length; i++) {
                total_psychoTest_applicant += parseInt(obj.eq(i).val());
            }

            if (parseInt(total_psychoTest_applicant - old_total_psychoTest) > 0) {
                $(".bill_psychoTest_applicant").text(old_total_psychoTest + ' (+' +
                    parseInt(total_psychoTest_applicant - old_total_psychoTest) + ')');
                $(".total_price_psychoTest").text('Rp' +
                    number_format(parseInt((total_psychoTest_applicant - old_total_psychoTest) * price_per_psychoTest), 2, ',', '.'));
            } else {
                $(".bill_psychoTest_applicant").text(old_total_psychoTest);
                $(".total_price_psychoTest").text('Rp0,00');
            }

            $("#total_psychoTest").val(total_psychoTest_applicant);
        }

        function subtotalJobPosting() {
            totalQuiz();
            totalPsychoTest();

            var price_total_ads = parseInt((new_total_ads - old_total_ads) * price_per_ads),
                price_total_quiz = parseInt((total_quiz_applicant - old_total_quiz) * price_per_quiz),
                price_total_psychoTest = parseInt((total_psychoTest_applicant - old_total_psychoTest) * price_per_psychoTest);

            subtotal = parseInt(plan_price);
            subtotal += price_total_ads + price_total_quiz + price_total_psychoTest;

            $(".subtotal").text("Rp" + number_format(subtotal, 2, ',', '.'));
        }

        $("#vacancy_setup .next").on("click", function () {
            subtotalJobPosting();
            resetter();

            if (!$("#vacancy_id").val()) {
                $("#vacancy_list").addClass('has-error');
                $(".vacancy_errorTxt").text('Please select some vacancy that you\'re going to post.');

            } else if ($("#vacancy_id :selected").length < new_total_ads) {
                $("#vacancy_list").addClass('has-error');
                $(".vacancy_errorTxt").text('The ads/vacancy amount you\'ve entered doesn\'t match ' +
                    'with the vacancy that you select!');

            } else {
                if (isQuiz == 1) {
                    if (parseFloat($(".input_passing_grade").val()) <= 0.00) {
                        $(".quiz_setup, #quiz_error").addClass('has-error');
                        $("#quiz_error small").text("Passing grade value can't be 0.00! " +
                            "Please fill it correctly for each vacancy that you've selected.");

                    } else {
                        if (parseInt($(".input_quiz_applicant").val()) > 0 && total_quiz_applicant >= old_total_quiz) {
                            $(".quiz_setup").removeClass('has-error');
                            $("#quiz_error small").text('');

                        } else if (parseInt($(".input_quiz_applicant").val()) <= 0) {
                            $(".quiz_setup, #quiz_error").addClass('has-error');
                            $("#quiz_error small").text("Quiz applicant value can't be 0! " +
                                "Please fill it correctly for each vacancy that you've selected.");

                        } else if (total_quiz_applicant < old_total_quiz) {
                            $(".quiz_setup, #quiz_error").addClass('has-error');
                            $("#quiz_error small").text("The applicant amount you've entered doesn't meet " +
                                "the requirements for total applicant (" + old_total_quiz + " applicants).");
                        }
                    }
                }

                if (isPsychoTest == 1) {
                    if (parseFloat($(".input_passing_grade").val()) <= 0.00) {
                        $(".quiz_setup, #quiz_error").addClass('has-error');
                        $("#quiz_error small").text("Passing grade value can't be 0.00! " +
                            "Please fill it correctly for each vacancy that you've selected.");

                    } else {
                        if (parseInt($(".input_psychoTest_applicant").val()) > 0 &&
                            total_psychoTest_applicant >= old_total_psychoTest) {
                            $(".psychoTest_setup").removeClass('has-error');
                            $("#psychoTest_error small").text('');

                        } else if (parseInt($(".input_psychoTest_applicant").val()) <= 0) {
                            $(".psychoTest_setup, #psychoTest_error").addClass('has-error');
                            $("#psychoTest_error small").text("Psycho test applicant value can't be 0! " +
                                "Please fill it correctly for each vacancy that you've selected.");

                        } else if (total_psychoTest_applicant < old_total_psychoTest) {
                            $(".psychoTest_setup, #psychoTest_error").addClass('has-error');
                            $("#psychoTest_error small").text("The applicant amount you've entered doesn't meet " +
                                "the requirements for total applicant (" + old_total_psychoTest + " applicants).");
                        }
                    }
                }
            }

            if ($("#vacancy_list").hasClass('has-error') || $(".quiz_setup").hasClass('has-error') || $(".psychoTest_setup").hasClass('has-error')) {
                $("#order_summary .previous").click();
            }
        });

        $("#plans_id").on('change', function () {
            $.get('{{route('get.plansReviewData',['plan'=>''])}}/' + $(this).val(), function (data) {
                if (data.total_vac < data.job_ads) {
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
                    isQuiz = data.isQuiz;
                    isPsychoTest = data.isPsychoTest;
                    $attr_passingGrade = isQuiz == 0 ? 'readonly' : '';
                    $attr_quiz = isQuiz == 0 ? 'readonly' : '';
                    $attr_psychoTest = isPsychoTest == 0 ? 'readonly' : '';
                    old_total_quiz = data.quiz_applicant;
                    price_per_quiz = data.price_quiz_applicant;
                    old_total_psychoTest = data.psychoTest_applicant;
                    price_per_psychoTest = data.price_psychoTest_applicant;
                    total_quiz_applicant = 0;
                    total_psychoTest_applicant = 0;
                    subtotal = parseInt(plan_price);
                    $("#vacancy_data").html('');
                    $("#input_quiz_psychoTest").html('');
                    $("#vacancySetupDivider").css('display', 'none');

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
                    $(".subtotal").text("Rp" + number_format(subtotal, 2, ',', '.'));

                    if (data.id == 1) {
                        swal({
                            title: 'ATTENTION!',
                            text: 'You\'ve just select ' + data.name + ' Package, it means you have to ' +
                                'select at least ' + data.job_ads + ' vacancy!',
                            type: 'warning',
                            timer: '7000',
                            confirmButtonColor: '#fa5555',
                        });

                    } else if (data.id == 2) {
                        swal({
                            title: 'ATTENTION!',
                            text: 'You\'ve just select ' + data.name + ' Package, it means you have to ' +
                                'select at least ' + data.job_ads + ' vacancies!',
                            type: 'warning',
                            timer: '7000',
                            confirmButtonColor: '#fa5555',
                        });

                    } else if (data.id == 3) {
                        swal({
                            title: 'ATTENTION!',
                            text: 'You\'ve just select ' + data.name + ' Package, it means you have to ' +
                                'select at least ' + data.job_ads + ' vacancies!',
                            type: 'warning',
                            timer: '7000',
                            confirmButtonColor: '#fa5555',
                        });
                    }
                    $("#total_ads").val(data.job_ads).prop('min', data.job_ads);
                    $("#vacancy_id").val('default').selectpicker({maxOptions: data.job_ads}).selectpicker('refresh');
                    $("#order_summary .previous").click();
                }
                $(".accordion-toggle").addClass('collapsed');
                $(".panel-collapse").removeClass('in');
                $('html, body').animate({
                    scrollTop: $('#job-posting').offset().top
                }, 500);

                resetter();
            });
        });

        $("#order_summary .next").on("click", function () {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: '{{route('get.midtrans.snap')}}',
                    type: "GET",
                    data: $("#pm-form").serialize(),
                    beforeSend: function () {
                        $('#image2').show();
                    },
                    complete: function () {
                        $('#image2').hide();
                    },
                    success: function (data) {
                        snap.pay(data, {
                            onSuccess: function (result) {
                                responseMidtrans('{{route('get.midtrans-callback.finish')}}', result);
                            },
                            onPending: function (result) {
                                responseMidtrans('{{route('get.midtrans-callback.unfinish')}}', result);
                            },
                            onError: function (result) {
                                swal({
                                    title: 'Error!',
                                    text: result.status_message,
                                    type: 'error',
                                    timer: '3500',
                                    confirmButtonColor: '#fa5555',
                                });
                            },
                            onClose: function () {
                                $("#payment_method .previous").click();
                            }
                        });
                    },
                    error: function () {
                        swal({
                            title: 'Oops..',
                            text: 'Terjadi kesalahan! Silahkan, segarkan browser Anda.',
                            type: 'error',
                            timer: '3500',
                            confirmButtonColor: '#fa5555',
                        });
                    }
                });
            }.bind(this), 800);
        });

        function responseMidtrans(url, result) {
            if (result.payment_type == 'credit_card' || result.payment_type == 'bank_transfer' ||
                result.payment_type == 'echannel' || result.payment_type == 'gopay' || result.payment_type == 'cstore') {

                $("#pm-form input[name=transaction_id]").val(result.transaction_id);
                $("#pm-form input[name=pdf_url]").val(result.pdf_url);

                clearTimeout(this.delay);
                this.delay = setTimeout(function () {
                    $.ajax({
                        url: url,
                        type: "GET",
                        data: $("#pm-form").serialize(),
                        beforeSend: function () {
                            $('#image2').show();
                        },
                        complete: function () {
                            $('#image2').hide();
                        },
                        success: function (data) {
                            var tags = '', pm = data.data.payment_type2, isPaid = data.data.isPaid;

                            swal({
                                title: "Success!",
                                text: data.message,
                                type: 'success',
                                allowOutsideClick: false,
                                closeOnEsc: false,
                                closeOnClickOutside: false,
                                confirmButtonColor: '#00adb5',

                                preConfirm: function () {
                                    return new Promise(function (resolve) {
                                        $(".countdown-h2").html('<sub>Expired <strong>Time</strong>: '+data.data.expDay+' at ' +data.data.expTime+'</sub>');
                                        $(".invoice-route").attr('href', '{{route('invoice.job.posting', ['id' => ''])}}/' + data.data.encryptID);
                                        $("#stats_billing a strong").text(data.data.invoice);

                                        $("#stats_payment img").attr('src', data.data.payment_icon);
                                        if(pm == 'credit_card' || pm == 'bank_transfer' || pm == 'cstore') {
                                            tags +=
                                                '<li><a class="tag tag-plans" style="font-size: 15px">' +
                                                '<strong data-toggle="tooltip" data-placement="left" ' +
                                                'title="Payment Code">'+data.data.payment_number+'</strong></a></li>';

                                            if(pm == 'bank_transfer') {
                                                tags +=
                                                    '<li><a class="tag tag-plans" style="font-size: 15px">' +
                                                    '<strong data-toggle="tooltip" data-placement="left" ' +
                                                    'title="Account Name">a/n {{env('APP_NAME')}}</strong></a></li>';
                                            }

                                            $("#stats_payment blockquote").html('<ul class="list-inline">'+tags+'</ul>');
                                        }

                                        if(isPaid == 1) {
                                            $("#isPaid img").attr('src', '{{asset('images/stamp_paid.png')}}');
                                            $("#isPaid blockquote").html(
                                                '<ul class="list-inline">'+
                                                '<li><a class="tag tag-plans" style="font-size: 15px">' +
                                                '<strong>Payment Received</strong></a></li></ul>');
                                        } else {
                                            $("#isPaid img").attr('src', '{{asset('images/stamp_unpaid.png')}}');
                                            $("#isPaid blockquote").html(
                                                '<ul class="list-inline">'+
                                                '<li><a class="tag" style="font-size: 14px">' +
                                                '<strong>Waiting for Payment</strong></a></li></ul>');
                                        }

                                        swal.close();
                                        $("#payment_method .next").click();
                                        $(".msform").css('width', '75%');

                                        if(isPaid == 1) {
                                            swal({
                                                title: "Payment Succeed!",
                                                type: 'success',
                                                allowOutsideClick: false,
                                                closeOnEsc: false,
                                                closeOnClickOutside: false,
                                                confirmButtonColor: '#00adb5',

                                                preConfirm: function () {
                                                    return new Promise(function (resolve) {
                                                        location.href = '{{route('agency.vacancy.status')}}'
                                                    });
                                                },
                                            });
                                        }
                                    });
                                },
                            });
                        },
                        error: function () {
                            swal({
                                title: 'Oops..',
                                text: 'Terjadi kesalahan! Silahkan, segarkan browser Anda.',
                                type: 'error',
                                timer: '3500',
                                confirmButtonColor: '#fa5555',
                            });
                        }
                    });
                }.bind(this), 800);

            } else {
                swal({
                    title: 'Oops..',
                    text: 'Maaf kanal pembayaran yang Anda pilih masih maintenance, silahkan pilih kanal lainnya.',
                    type: 'error',
                    timer: '5500',
                    confirmButtonColor: '#fa5555',
                });
            }
        }

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
                    } else {
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
                } else {
                    if (fig_1_value !== '0') this.animateFigure($el_1, 0);
                    if (fig_2_value !== val_1) this.animateFigure($el_2, val_1);
                }
            }
        };
        Countdown.init();
    </script>
@endpush
