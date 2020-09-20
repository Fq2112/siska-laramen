<!DOCTYPE html>
<html lang="id">
<head>
    <title>Invoice #{{$invoice}}</title>
    <style>
        body {
            font-family: open sans, tahoma, sans-serif;
            margin: 0;
            -webkit-print-color-adjust: exact;
        }

        @if($confirmAgency->isPaid == true)
        .container {
            background: linear-gradient(rgba(255, 255, 255, .9), rgba(255, 255, 255, .9)),
            url({{asset('images/stamp_paid.png')}}) center no-repeat;
            background-size: contain;
            width: 790px;
        }

        @else
        .container {
            background: linear-gradient(rgba(255, 255, 255, .9), rgba(255, 255, 255, .9)),
            url({{asset('images/stamp_unpaid.png')}}) center no-repeat;
            background-size: contain;
            width: 790px;
        }

        @endif
        a {
            font-size: 14px;
            text-decoration: none;
        }

        .paid {
            color: #00adb5;
        }

        .unpaid {
            color: #fa5555;
        }
    </style>
</head>
<body onload="window.print()">
<div class="container">
    <table width="790" cellspacing="0" cellpadding="0" class="container" style="width: 790px; padding: 20px;">
        <tr>
            <td>
                <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; padding-bottom: 20px;">
                    <tbody>
                    <tr style="margin-top: 8px; margin-bottom: 8px;">
                        <td>
                            <img src="{{asset('images/logo/logotype.png')}}" alt="{{env('APP_NAME')}}" width="200">
                        </td>
                        <td style="text-align: right; padding-right: 15px;">
                            <a href="javascript:window.print()"
                               class="{{$confirmAgency->isPaid == true ? 'paid' : 'unpaid'}}">
                                <span style="vertical-align: middle;font-weight: 600">Print</span>
                                <img src="https://ecs7.tokopedia.net/img/print.png" alt="Print"
                                     style="vertical-align: middle;">
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; padding-bottom: 15px;">
                    <tbody>
                    <tr style="font-size: 20px; font-weight: 600;">
                        <td width="30%" style="padding: 0 10px;">
                            <span>Bill to</span>
                            <table style="width: 100%; border-collapse: collapse;" width="100%" cellspacing="0"
                                   cellpadding="0">
                                <tr>
                                    <td>
                                        <table style="width: 100%; border-collapse: collapse;" width="100%"
                                               cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td style="font-size: 16px;padding: 3px 0;font-weight: 600">{{$user->name}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="font-size: 13px;">
                                    <td>
                                        <table style="width: 100%; border-collapse: collapse;" width="100%"
                                               cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td>{{$agency->alamat}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="font-size: 13px;">
                                    <td>
                                        <table style="width: 100%; border-collapse: collapse;" width="100%"
                                               cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td>{{$agency->phone}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="40%" style="padding: 0 10px;">
                            <span>Invoice</span>
                            <table style="width: 100%; border-collapse: collapse;" width="100%" cellspacing="0"
                                   cellpadding="0">
                                <tr style="font-size: 13px;">
                                    <td>
                                        <table style="width: 100%; border-collapse: collapse;" width="100%"
                                               cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td style="width: 80px; font-weight: 600; padding: 3px 20px 3px 0;"
                                                    width="80">Number
                                                </td>
                                                <td style="padding: 3px 0;">{{$invoice}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="font-size: 13px;">
                                    <td>
                                        <table style="width: 100%; border-collapse: collapse;" width="100%"
                                               cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td style="width: 80px; font-weight: 600; padding: 3px 20px 3px 0;"
                                                    width="80">Date
                                                </td>
                                                <td style="padding: 3px 0;">{{$confirmAgency->created_at->format('j F Y')}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="font-size: 13px;">
                                    <td>
                                        <table style="width: 100%; border-collapse: collapse;" width="100%"
                                               cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td style="width: 80px; font-weight: 600; padding: 3px 20px 3px 0;"
                                                    width="80">Due Date
                                                </td>
                                                <td style="padding: 3px 0;">{{$confirmAgency->created_at->addDay()->format('j F Y')}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                        <td width="30%" style="padding: 0 10px;">
                            <span>Payment</span>
                            <table style="width: 100%; border-collapse: collapse;" width="100%" cellspacing="0"
                                   cellpadding="0">
                                <tr>
                                    <td style="font-size: 16px;padding: 3px 0;font-weight: 600">{{strtoupper(str_replace('_',' ',$confirmAgency->payment_type))}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td style="font-size: 13px">
                                                    <img src="{{asset('images/paymentMethod/'.$confirmAgency->payment_name.'.png')}}"
                                                         style="width: 35%;float:left;margin-right: 10px" alt="icon">
                                                    @if($confirmAgency->payment_type == 'credit_card' || $confirmAgency->payment_type == 'bank_transfer' || $confirmAgency->payment_type == 'cstore')
                                                        {{$confirmAgency->payment_number}}<br>
                                                        {{$confirmAgency->payment_type == 'bank_transfer' ? 'a/n '.env('APP_NAME') : 'Payment Code'}}
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table style="width: 100%; text-align: center; border-top: 1px solid rgba(0,0,0,0.1); border-bottom: 1px solid rgba(0,0,0,0.1); padding: 15px 0;"
                       width="100%" cellspacing="0" cellpadding="0">
                    <thead style="font-size: 14px;">
                    <tr>
                        <th style="width: 270px; font-weight: 700; text-align: left; padding: 0 5px 15px 15px;">Item
                            Details
                        </th>
                        <th colspan="2" style="width: 120px; font-weight: 700; padding: 0 5px 15px;">Qty.</th>
                        <th style="width: 115px; font-weight: 700; padding: 0 5px 15px;">Price</th>
                        <th style="width: 115px; font-weight: 700; text-align: right; padding: 0 30px 15px 5px;">
                            Subtotal
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="font-size: 13px;">
                        <td style="width: 270px;font-weight: 600; text-align: left; padding: 8px 0 8px 15px;">
                            <span style="text-transform: uppercase">{{$pl->name}} Package</span>
                            <ul style="margin: 0 auto">
                                <li><strong>{{$pl->job_ads}}</strong></li>
                                <li>Quiz for <strong>{{$pl->quiz_applicant}}</strong> participants</li>
                                <li>Psycho Test for <strong>{{$pl->psychoTest_applicant}}</strong> participants</li>
                            </ul>
                        </td>
                        <td colspan="2" style="width: 120px;padding: 8px 5px;text-transform: uppercase">
                            <strong>&ndash;</strong></td>
                        <td style="width: 115px; padding: 8px 5px;" width="115">
                            Rp{{number_format($plan_price,2,",",".")}}</td>
                        <td style="width: 115px; text-align: right; padding: 8px 30px 8px 5px;" width="115">
                            Rp{{number_format($plan_price,2,",",".")}}</td>
                    </tr>
                    <tr style="font-size: 13px; background-color: rgba(0,0,0,0.1);" bgcolor="#F1F1F1">
                        <td colspan="4"
                            style="width: 270px;font-weight: 600; text-align: left; padding: 8px 5px 8px 15px;">Subtotal
                        </td>
                        <td style="width: 115px; font-weight: 600; text-align: right; padding: 8px 30px 8px 5px;"
                            width="115">Rp{{number_format($plan_price,2,",",".")}}</td>
                    </tr>
                    </tbody>
                </table>
                <table style="width: 100%; text-align: center; border-top: 1px solid rgba(0,0,0,0.1); border-bottom: 1px solid rgba(0,0,0,0.1); padding: 0 0 15px 0;"
                       width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr style="font-size: 13px;">
                        <td style="width: 270px;font-weight: 600; text-align: left; padding: 8px 0 8px 15px;">
                            <span style="text-transform: uppercase">Job Vacancy</span>
                            <ol style="margin: 0 auto">
                                @foreach($vacancies as $vacancy)
                                    <li style="margin-bottom: .5em">
                                        {{$vacancy->judul}}
                                        <ul>
                                            <li>
                                                Quiz with <strong>{{$vacancy->passing_grade != null ?
                                                $vacancy->passing_grade : 0}}</strong> passing grade&nbsp;&ndash;&nbsp;for&nbsp;&ndash;
                                                <strong>{{$vacancy->quiz_applicant != null ?
                                                $vacancy->quiz_applicant : 0}}</strong> participants
                                            </li>
                                            <li>
                                                Psycho Test for <strong>{{$vacancy->psychoTest_applicant != null ?
                                                $vacancy->psychoTest_applicant : 0}}</strong> participants
                                            </li>
                                        </ul>
                                    </li>
                                @endforeach
                            </ol>
                        </td>
                        <td colspan="2" style="width: 120px;padding: 8px 5px;text-transform: uppercase">
                            <strong>{{$totalVacancy}}</strong></td>
                        <td style="width: 115px; padding: 8px 5px;" width="115">
                            Rp{{number_format($price_per_ads,2,",",".")}}</td>
                        <td style="width: 115px; text-align: right; padding: 8px 30px 8px 5px;" width="115">
                            Rp{{number_format($price_totalVacancy,2,",",".")}}</td>
                    </tr>
                    <tr style="font-size: 13px; background-color: rgba(0,0,0,0.1);" bgcolor="#F1F1F1">
                        <td colspan="4"
                            style="width: 270px;font-weight: 600; text-align: left; padding: 8px 5px 8px 15px;">Subtotal
                        </td>
                        <td style="width: 115px; font-weight: 600; text-align: right; padding: 8px 30px 8px 5px;"
                            width="115">Rp{{number_format($plan_price + $price_totalVacancy,2,",",".")}}</td>
                    </tr>
                    </tbody>
                </table>
                <table style="width: 100%; text-align: center; padding: 0 0 15px 0;" width="100%" cellspacing="0"
                       cellpadding="0">
                    <tbody>
                    <tr style="font-size: 13px;">
                        <td style="width: 270px;font-weight: 600; text-align: left; padding: 8px 0 8px 15px;">
                            Online Quiz (TPA & TKD)
                        </td>
                        <td colspan="2" style="width: 120px;padding: 8px 5px;text-transform: uppercase">
                            <strong>{{$totalQuizApplicant}}</strong></td>
                        <td style="width: 115px; padding: 8px 5px;" width="115">
                            Rp{{number_format($pl->price_quiz_applicant,2,",",".")}}</td>
                        <td style="width: 115px; text-align: right; padding: 8px 30px 8px 5px;" width="115">
                            Rp{{number_format($price_totalQuiz,2,",",".")}}</td>
                    </tr>
                    <tr style="font-size: 13px;">
                        <td style="width: 270px;font-weight: 600; text-align: left; padding: 8px 0 8px 15px;">Psycho
                            Test (Online Interview)
                        </td>
                        <td colspan="2" style="width: 120px;padding: 8px 5px;text-transform: uppercase">
                            <strong>{{$totalPsychoTest}}</strong></td>
                        <td style="width: 115px; padding: 8px 5px;" width="115">
                            Rp{{number_format($pl->price_psychoTest_applicant,2,",",".")}}</td>
                        <td style="width: 115px; text-align: right; padding: 8px 30px 8px 5px;" width="115">
                            Rp{{number_format($price_totalPsychoTest,2,",",".")}}</td>
                    </tr>
                    <tr style="font-size: 13px; background-color: rgba(0,0,0,0.1);" bgcolor="#F1F1F1">
                        <td colspan="4" style="font-weight: 600; text-align: left; padding: 8px 5px 8px 15px;">
                            Subtotal
                        </td>
                        <td style="width: 115px; font-weight: 600; text-align: right; padding: 8px 30px 8px 5px;" width="115">Rp{{number_format($confirmAgency->is_discount == true ?
                            $confirmAgency->total_payment + $confirmAgency->discount :
                            $confirmAgency->total_payment,2,",",".")}}</td>
                    </tr>
                    </tbody>
                </table>

                @if($confirmAgency->is_discount == true)
                    @php $promo = \App\PromoCode::where('promo_code', $confirmAgency->promo_code)->first(); @endphp
                    <table style="width: 100%; text-align: center; padding: 0 0 15px 0;" width="100%" cellspacing="0"
                           cellpadding="0">
                        <tbody>
                        <tr style="font-size: 13px;">
                            <td style="width: 270px;font-weight: 600; text-align: left; padding: 8px 0 8px 15px;">Discount Voucher<br>Code: <strong>{{$promo->promo_code}}</strong></td>
                            <td colspan="2" style="width: 120px;padding: 8px 5px;"><strong>1</strong></td>
                            <td style="width: 115px; padding: 8px 5px;" width="115">-{{$promo->discount}}%</td>
                            <td style="width: 115px; text-align: right; padding: 8px 30px 8px 5px;" width="115">
                                -Rp{{number_format($confirmAgency->discount,2,",",".")}}</td>
                        </tr>
                        <tr style="font-size: 13px; background-color: rgba(0,0,0,0.1);" bgcolor="#F1F1F1">
                            <td colspan="4" style="font-weight: 600; text-align: left; padding: 8px 5px 8px 15px;">
                                Subtotal
                            </td>
                            <td style="width: 115px; font-weight: 600; text-align: right; padding: 8px 30px 8px 5px;"
                                width="115">Rp{{number_format($confirmAgency->total_payment,2,",",".")}}</td>
                        </tr>
                        </tbody>
                    </table>
                @endif

                <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; padding: 0 0 20px;">
                    <tbody>
                    <tr>
                        <td width="35%" valign="top" style="width: 35%; vertical-align: top; padding-right: 5px;"></td>
                        <td width="65%" valign="top" style="width: 65%; vertical-align: top; padding-left: 5px;">
                            <table width="100%" cellspacing="0" cellpadding="0"
                                   style="width: 100%; border-collapse: collapse;">
                                <tr bgcolor="#F1F1F1"
                                    class="{{$confirmAgency->isPaid == true ? 'paid' : 'unpaid'}}"
                                    style="font-size: 15px; background-color: rgba(0,0,0,0.1);">
                                    <td style="padding: 15px 0 15px 30px; font-weight: 600;">Total</td>
                                    <td style="padding: 15px 30px 15px 0; font-weight: 600; text-align: right;">
                                        Rp{{number_format($confirmAgency->total_payment,2,",",".")}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="35%" valign="top" style="width: 35%; vertical-align: top; padding-right: 5px;"></td>
                        <td width="65%" valign="top" style="width: 65%; vertical-align: top; padding-left: 5px;">
                            <table width="100%" cellspacing="0" cellpadding="0"
                                   style="width: 100%; border-collapse: collapse;">
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
