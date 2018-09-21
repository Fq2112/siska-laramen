<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scaleable=no">
    <title>Payment Details! (#926639)</title>
    <style type="text/css">
        /*Bootstrap*/
        .alert {
            padding: 15px;
            margin: 0 1.5em 1em 1.5em;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert h4 {
            margin-top: 0;
            color: inherit;
        }

        .alert .alert-link {
            font-weight: bold;
        }

        .alert > p,
        .alert > ul {
            margin-bottom: 0;
        }

        .alert > p + p {
            margin-top: 5px;
        }

        .alert-dismissable,
        .alert-dismissible {
            padding-right: 35px;
        }

        .alert-dismissable .close,
        .alert-dismissible .close {
            position: relative;
            top: -2px;
            right: -21px;
            color: inherit;
        }

        .alert-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #3c763d;
        }

        .alert-success hr {
            border-top-color: #c9e2b3;
        }

        .alert-success .alert-link {
            color: #2b542c;
        }

        .alert-info {
            background-color: #d9edf7;
            border-color: #bce8f1;
            color: #31708f;
        }

        .alert-info hr {
            border-top-color: #a6e1ec;
        }

        .alert-info .alert-link {
            color: #245269;
        }

        .alert-warning {
            background-color: #fcf8e3;
            border-color: #faebcc;
            color: #8a6d3b;
        }

        .alert-warning hr {
            border-top-color: #f7e1b5;
        }

        .alert-warning .alert-link {
            color: #66512c;
        }

        .alert-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }

        .alert-danger hr {
            border-top-color: #e4b9c0;
        }

        .alert-danger .alert-link {
            color: #843534;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        blockquote {
            padding: 10px 20px;
            margin: 0 0 20px;
            font-size: 17.5px;
            border-left: 5px solid #eeeeee;
        }

        blockquote p:last-child,
        blockquote ul:last-child,
        blockquote ol:last-child {
            margin-bottom: 0;
        }

        blockquote footer,
        blockquote small,
        blockquote .small {
            display: block;
            font-size: 80%;
            line-height: 1.42857;
            color: #777777;
        }

        blockquote footer:before,
        blockquote small:before,
        blockquote .small:before {
            content: '\2014 \00A0';
        }

        .blockquote-reverse,
        blockquote.pull-right {
            padding-right: 15px;
            padding-left: 0;
            border-right: 5px solid #eeeeee;
            border-left: 0;
            text-align: right;
        }

        .blockquote-reverse footer:before,
        .blockquote-reverse small:before,
        .blockquote-reverse .small:before,
        blockquote.pull-right footer:before,
        blockquote.pull-right small:before,
        blockquote.pull-right .small:before {
            content: '';
        }

        .blockquote-reverse footer:after,
        .blockquote-reverse small:after,
        .blockquote-reverse .small:after,
        blockquote.pull-right footer:after,
        blockquote.pull-right small:after,
        blockquote.pull-right .small:after {
            content: '\00A0 \2014';
        }

        .list-inline {
            padding-left: 0;
            list-style: none;
            margin-left: -5px;
        }

        .list-inline > li {
            display: inline-block;
            padding-left: 5px;
            padding-right: 5px;
        }

        /*end:Bootstrap*/

        .tags {
            list-style: none;
            margin: 0;
            overflow: hidden;
            padding: 0 0 0 .2em;
        }

        .tags li {
            float: left;
        }

        .tags li a {
            text-decoration: none;
            cursor: pointer;
        }

        .tag {
            font-size: 12px;
            background: #eee;
            border-radius: 3px 0 0 3px;
            color: #999;
            display: inline-block;
            height: 26px;
            line-height: 26px;
            padding: 0 20px 0 23px;
            position: relative;
            margin: 0 10px 10px 0;
            -webkit-transition: color 0.2s;
            text-transform: none;
        }

        .tag::before {
            background: #fff;
            border-radius: 10px;
            box-shadow: inset 0 1px rgba(0, 0, 0, 0.25);
            content: '';
            height: 6px;
            left: 10px;
            position: absolute;
            width: 6px;
            top: 10px;
        }

        .tag::after {
            background: #fff;
            border-bottom: 13px solid transparent;
            border-left: 10px solid #eee;
            border-top: 13px solid transparent;
            content: '';
            position: absolute;
            right: 0;
            top: 0;
        }

        .tag:hover {
            background-color: #fa5555;
            color: white;
        }

        .tag:hover::after {
            border-left-color: #fa5555;
        }

        .tag-plans:hover {
            background-color: #00ADB5;
            color: white;
        }

        .tag-plans:hover::after {
            border-left-color: #00ADB5;
        }

        .tag:hover .tag-icon {
            display: none;
        }

        .tag:hover .tag-close::before {
            font-family: "Font Awesome 5 Free";
            content: '\f057';
            font-style: normal;
        }

        .hr-divider {
            margin: 0 0 .5em 0;
            border: 0;
            height: 1px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, .4), rgba(0, 0, 0, .1), rgba(0, 0, 0, 0));
        }

        #activate {
            color: #FFFFFF;
            background: #5bd3d1;
            -moz-border-radius: 9px;
            -webkit-border-radius: 9px;
            border-radius: 9px;
            padding-left: 20px;
            padding-right: 20px;
            width: 320px;
            display: block;
            font-size: 18px;
            font-weight: bold;
            line-height: 50px;
            text-align: center;
            text-decoration: none;
        }

        .zoom {
            transition: transform .3s;
        }

        .zoom:hover {
            -ms-transform: scale(1.1);
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

        small {
            font-size: 16px;
        }

        div, p, a, li, td {
            color: #666;
            -webkit-text-size-adjust: none;
        }

        .ExternalClass * {
            line-height: 100%
        }

        .ReadMsgBody {
            width: 100%
        }

        .ExternalClass {
            width: 100%
        }

        .appleLinks a {
            color: #646464;
            text-decoration: none;
        }

        table {
            border-collapse: collapse;
            font-size: 16px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: helvetica, arial, sans-serif;
            -webkit-text-size-adjust: none;
        }

        .appleLinksWhite a {
            color: #949494;
            text-decoration: none;
        }

        @media screen and (max-width: 480px) {
            /* Width Control */
            table[class=full-width], img[class=full-width], a[class=full-width], div[class=full-width] {
                width: 100% !important;
                height: auto !important;
            }

            div[class=line40] {
                line-height: 40px !important;
            }

            /* Hiding Elements */
            table[id=hide], td[class="hide"], img[id=hide] {
                display: none !important;
            }

            img[class=logo] {
                width: 240px !important;
                height: 75px !important;
            }
        }

        /* Medium Screen Tablets */
        @media screen and (max-width: 650px) {
            img[class=logo] {
                width: 240px !important;
                height: 75px !important;
            }

            a[class=footerlinks] {
                display: block !important;
                font-size: 16px !important;
                padding: 0px 4px 2px 4px !important;
                line-height: 14px !important;
                width: 70% !important;
                text-align: center !important;
                color: #F9F9F9 !important;
                text-decoration: none !important;
            }

            table[class=full-width], img[class=full-width], a[class=full-width], div[class=full-width] {
                width: 100% !important;
                height: auto !important;
            }

            table[class=hide], img[class=hide], td[class=hide], span[class=hide] {
                display: none !important;
            }

            div[class=line40] {
                line-height: 40px !important;
            }

            td[class=headline] {
                padding-left: 10px !important;
            }

            span[class=content2] {
                font-size: 18px !important;
            }

            span[class=appleLinksWhite] {
                color: #949494 !important;
            }

            td[class=body], span[class=body] {
                padding-right: 25px !important;
                padding-left: 25px !important;
                font-size: 20px !important;
            }

            td[class=footer-padding] {
                padding-right: 15px !important;
                padding-left: 15px !important;
            }

            img[class=social-icons] {
                height: 90px !important;
                width: auto !important;
            }
        }
    </style>
</head>
<body>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#FAFAFA" class="full-width">
    <tbody>
    <tr>
        <td>
            <div style="font-size:10px;line-height:10px;">&nbsp;</div>
        </td>
    </tr>
    </tbody>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FAFAFA">
    <tbody>
    <tr>
        <td align="center">
            <table width="700" border="0" align="center" cellspacing="0" cellpadding="0" class="full-width"
                   style="margin:0 auto;">
                <tbody>
                <tr>
                    <td width="700" align="center">
                        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0"
                               class="full-width" style="margin:0 auto;">
                            <tbody>
                            <tr>
                                <td width="14" bgcolor="#fafafa"></td>
                                <td width="2" bgcolor="#f9f9f9"></td>
                                <td width="2" bgcolor="#f7f7f7"></td>
                                <td width="2" bgcolor="#f3f3f3"></td>
                                <td width="660" valign="top" bgcolor="#fff">
                                    <table bgcolor="#fff" border="0" cellspacing="0" cellpadding="0" class="full-width"
                                           style="border-top: 2px solid #f3f3f3">
                                        <tbody>
                                        <tr>
                                            <td align="center" width="660">
                                                <a name="Logo" style="display:block" href="{{route('home-seeker')}}"
                                                   target="_blank">
                                                    <img src="http://i66.tinypic.com/2iux5ph.png" border="0"
                                                         style="display:block;width: 40%;" class="logo"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="border-top: 1px solid #e0e0e0; height: 2px"
                                                     class="full-width"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="10" cellspacing="0"
                                                       style="margin: .5em 1em">
                                                    <tr>
                                                        <td>
                                                            <small style="line-height: 2em">
                                                                <strong style="font-size: 22px">
                                                                    Please, complete your payment immediately</strong>
                                                                <br>Checkout was successfully
                                                                on {{$data['confirmAgency']->created_at->format('l,j F Y')}}
                                                                at {{$data['confirmAgency']->created_at->format('H:i')}}
                                                            </small>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="font-size:20px;line-height:20px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="660"
                                           align="center">
                                        <tr>
                                            <td valign="top" width="50%">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%"
                                                       style="margin-left: 1em">
                                                    <tr>
                                                        <td>
                                                            @php
                                                                $date = $data['confirmAgency']->created_at;
                                                                $romanDate = \App\Support\RomanConverter::numberToRoman($date->format('y')) . '/' . \App\Support\RomanConverter::numberToRoman($date->format('m'));
                                                                $total = number_format($data['total_payment'],0,"",".");
                                                                if($data['total_payment'] < 1000000){
                                                                    $first = substr($total,0,4);
                                                                } else{
                                                                    $first = substr($total,0,6);
                                                                }
                                                                $last = substr($total, -3);
                                                            @endphp
                                                            <small>
                                                                <a href="{{route('invoice.job.posting', ['id' =>
                                                                encrypt($data['confirmAgency']->id)])}}"
                                                                   style="text-decoration: none;color: #00adb5">
                                                                    <strong>{{'#INV/'.$data['confirmAgency']->created_at
                                                                    ->format('Ymd').'/'.$romanDate.'/'.
                                                                    $data['confirmAgency']->id}}</strong></a>
                                                            </small>
                                                            <hr class="hr-divider">
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <strong style="text-transform: uppercase">
                                                                            {{$data['plans']->name}}</strong> Package
                                                                    </td>
                                                                    <td>&emsp;</td>
                                                                    <td align="right">
                                                                        <strong>Rp{{number_format($data['plans']->price,0,"",".")}}</strong>
                                                                    </td>
                                                                </tr>
                                                                <tr style="border-bottom: 1px solid #ccc">
                                                                    <td>Unique Code</td>
                                                                    <td>&emsp;</td>
                                                                    <td align="right">
                                                                        <strong>-Rp{{$data['payment_code']}}</strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Amount to Transfer</td>
                                                                    <td>&emsp;</td>
                                                                    <td align="right">
                                                                        @if($data['payment_category']->id == 1)
                                                                            <strong style="font-size: 18px;color: #00adb5">Rp{{$first}}
                                                                                <span style="border:1px solid #fa5555;">{{$last}}</span></strong>
                                                                        @else
                                                                            <strong style="font-size: 18px;color: #00adb5">Rp{{$total}}</strong>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @if($data['payment_category']->id == 1)
                                                                    <tr>
                                                                        <td colspan="3" align="right"
                                                                            style="font-size:12px;color:#fa5555;font-weight:bold;">
                                                                            Transfer right up to the last 3 digits
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td valign="top" width="50%">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%"
                                                       style="margin-left: 1em">
                                                    <tr>
                                                        <td>
                                                            <small><strong>Payment Deadline</strong></small>
                                                            <hr class="hr-divider">
                                                            <span>{{$data['confirmAgency']->created_at->addDay()->format('l,j F Y')}}
                                                                at {{$data['confirmAgency']->created_at->addDay()->format('H:i')}}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="50%">
                                                <table border="0" cellpadding="10" cellspacing="0"
                                                       style="margin-left: 1em" width="100%">
                                                    <tr>
                                                        <td>
                                                            <small><strong>Payment Method</strong>
                                                                <sub>{{$data['payment_category']->name}}</sub></small>
                                                            <hr class="hr-divider">
                                                            <table>
                                                                <tr>
                                                                    <td width="50%">
                                                                        <img src="{{ $message->embed(public_path() . '/images/paymentMethod/' . $data['payment_method']->logo) }}"
                                                                             style="width: 90%;"
                                                                             alt="{{$data['payment_method']->name}}">
                                                                    </td>
                                                                    <td>
                                                                        <small style="line-height: 1.5em;font-size: 14px">
                                                                            @if($data['payment_category']->id == 1)
                                                                                <strong style="font-size: 16px">{{number_format($data['payment_method']->account_number,0," "," ")}}</strong>
                                                                                <br>
                                                                                a/n {{$data['payment_method']->account_name}}
                                                                            @elseif($data['payment_category']->id == 4)
                                                                                <strong style="font-size: 16px">
                                                                                    {{$data['confirmAgency']->payment_code}}
                                                                                </strong><br>Payment Code
                                                                            @endif
                                                                        </small>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td valign="top" width="50%">
                                                <table width="100%" border="0" cellpadding="10" cellspacing="0"
                                                       style="margin-left: 1em">
                                                    <tr>
                                                        <td>
                                                            <small><strong>Payment Status</strong></small>
                                                            <hr class="hr-divider">
                                                            <span>Waiting for Payment</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="660"
                                           align="center">
                                        <tr>
                                            <td>
                                                <div style="font-size:20px;line-height:20px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="font-size:20px;line-height:20px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="alert alert-info text-center">
                                                    <a href="{{route('agency.vacancy.status')}}" target="_blank"
                                                       style="color: #00ADB5;text-decoration: none">
                                                        <strong>Upload Payment Proof</strong></a> to speed up
                                                    verification
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="alert alert-warning text-center">
                                                    Make sure not to inform payment details and proof
                                                    <strong>to any party</strong> except SISKA.
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="font-size:20px;line-height:20px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="660"
                                           align="center" style="border-top: 2px solid #f3f3f3">
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="10" cellspacing="0"
                                                       style="margin: .5em 1em">
                                                    <tr>
                                                        <td>
                                                            <small style="line-height: 2em">
                                                                <strong style="font-size: 20px">
                                                                    Keep an eye for your payment on the Vacancy Status
                                                                    page</strong><br>To redirect you to the Vacancy
                                                                Status page, click the Vacancy Status button below
                                                            </small>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" width="600" class="full-width"
                                                            style="padding-left: 20px; padding-right:20px" valign="top">
                                                            <a class="zoom" id="activate"
                                                               href="{{route('agency.vacancy.status')}}"
                                                               target="_blank">VACANCY STATUS</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="2" bgcolor="#f3f3f3"></td>
                                <td width="2" bgcolor="#f7f7f7"></td>
                                <td width="2" bgcolor="#f9f9f9"></td>
                                <td width="14" bgcolor="#fafafa"></td>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
    <tbody>
    <tr>
        <td valign="top" align="center">
            <table width="700" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#ffffff"
                   class="full-width" style="margin:0 auto;">
                <tbody>
                <tr>
                    <td valign="top" width="20" class="hide" bgcolor="#1a1c21">
                        <div style="font-size:44px;line-height:44px;">&nbsp;</div>
                    </td>
                    <td valign="top" width="660" bgcolor="#FFFFFF" class="hide" height="40" alt="" border="0"></td>
                    <td valign="top" width="20" class="hide" bgcolor="#1a1c21">
                        <div style="font-size:44px;line-height:44px;">&nbsp;</div>
                    </td>
                </tr>
                </tbody>
            </table>
            <table width="700" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#1a1c21"
                   class="full-width" style="margin:0 auto;">
                <tbody>
                <tr>
                    <td valign="top" align="center">
                        <table width="700" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#1a1c21"
                               class="full-width">
                            <tbody>
                            <tr>
                                <td valign="top" align="center">
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:39px;line-height:39px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="20" class="hide">&nbsp;</td>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21"><a
                                                        name="Logo_1" style="display:block;"
                                                        href="{{route('home-seeker')}}" target="_blank"><img
                                                            src="http://i64.tinypic.com/2qn8tfp.png" alt="logo"
                                                            border="0"
                                                            style="display:block;width: 15%;"></a>
                                            </td>
                                            <td valign="top" width="20" class="hide">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="20" class="hide">&nbsp;</td>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:5px;line-height:5px;">&nbsp;</div>
                                            </td>
                                            <td valign="top" width="20" class="hide">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                                   bgcolor="#1a1c21" class="full-width">
                                                <tbody>
                                                <tr>
                                                    <td valign="top" width="20" class="hide">&nbsp;</td>
                                                    <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                        <div style="font-family:Helvetica, arial,helv,sans-serif;font-size:12px;color:#F9F9F9;">
                                                            Download our app here, free!
                                                        </div>
                                                    </td>
                                                    <td valign="top" width="20" class="hide">&nbsp;</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="700">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" bgcolor="#1a1c21" class="full-width">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center">
                                                            <table border="0" align="center" cellpadding="0"
                                                                   cellspacing="0" bgcolor="#1a1c21">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center" bgcolor="#1a1c21">
                                                                        <a href="https://play.google.com/store/apps/details?id=com.siska.mobile"><img
                                                                                    class="zoom"
                                                                                    src="http://i67.tinypic.com/2n8nadu.png"
                                                                                    style="width: 15%"></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <a href="https://itunes.apple.com/id/app/siska.com/id1143444473?mt=8"><img
                                                                                    class="zoom"
                                                                                    src="http://i67.tinypic.com/34sfhg7.png"
                                                                                    style="width: 15%"></a>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:25px;line-height:25px;">&nbsp;</div>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21"
                                                style="font-family:Helvetica, arial,helv,sans-serif;font-size:12px;color:#F9F9F9;">
                                                Keep in touch with us :)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="700">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" bgcolor="#1a1c21" class="full-width">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center">
                                                            <table border="0" align="center" cellpadding="0"
                                                                   cellspacing="0" bgcolor="#1a1c21">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center"><a
                                                                                href="https://www.facebook.com/siskaku"
                                                                                name="Facebook" target="_blank"><img
                                                                                    class="social-icons"
                                                                                    src="https://cdn.shazam.com/shazamauth/facebook.jpg"
                                                                                    width="34" height="50"
                                                                                    style="display:block" border="0"
                                                                                    alt="Facebook"></a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="https://twitter.com/siskaku"
                                                                           name="Twitter" target="_blank"><img
                                                                                    class="social-icons"
                                                                                    src="https://cdn.shazam.com/shazamauth/twitter.jpg"
                                                                                    width="36" height="50"
                                                                                    style="display:block" border="0"
                                                                                    alt="Twitter"></a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="https://www.instagram.com/siskaku/"
                                                                           name="Instagram" target="_blank"><img
                                                                                    class="social-icons"
                                                                                    src="https://cdn.shazam.com/shazamauth/instagram.jpg"
                                                                                    width="39" height="50"
                                                                                    style="display:block" border="0"
                                                                                    alt="Instagram"></a>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:25px;line-height:25px;">&nbsp;</div>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="700">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" bgcolor="#1a1c21" class="full-width">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <table border="0" cellspacing="0" cellpadding="0"
                                                                   width="700" class="full-width" bgcolor="#1a1c21">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center"
                                                                        style="font-family:Helvetica, arial,helv,sans-serif;font-size:16px;color:#F9F9F9; font-weight:bold;"
                                                                        bgcolor="#1a1c21">
                                                                        <a name="Privacy Policy"
                                                                           href="{{route('info.siska')}}#privacy-policy"
                                                                           class="footerlinks"
                                                                           style="color:#F9F9F9; text-decoration:none;"
                                                                           target="_blank">Privacy Policy</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <a name="Terms" class="footerlinks"
                                                                           style="color:#F9F9F9; text-decoration:none;"
                                                                           href="{{route('info.siska')}}#terms-conditions"
                                                                           target="_blank">Terms of Service</a>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:25px;line-height:25px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="620" bgcolor="#1a1c21">
                                                <table width="93%" border="0" align="center" cellspacing="0"
                                                       cellpadding="0">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center" height="1">
                                                            <table width="660" border="0" align="center" cellspacing="0"
                                                                   cellpadding="0" class="full-width">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center" height="1" bgcolor="#646464">
                                                                        <div style="font-size:1px;line-height:1px;">
                                                                            &nbsp;
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:25px;line-height:25px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="700">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" bgcolor="#1a1c21" class="full-width">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <table border="0" cellspacing="0" cellpadding="0"
                                                                   width="700" class="full-width" bgcolor="#1a1c21">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center" class="footer-padding"
                                                                        style="font-family:Helvetica, arial,helv,sans-serif;font-size:10px; color:#949494; font-weight:bold; padding-left:20px; padding-right:20px"
                                                                        bgcolor="#1a1c21">
                                                                        This is an automatically generated notification
                                                                        - please do not reply to this message. You are
                                                                        receiving this email to complete the
                                                                        registration initiated on the SISKA
                                                                        application; if you did not enter your email
                                                                        address in SISKA then you can either ignore
                                                                        this message or contact info@karir.org for
                                                                        more information. <br><br> SISKA is incorporated
                                                                        in
                                                                        Indonesia under company number
                                                                        <span class="appleLinksWhite">+62318672552</span>.
                                                                        <span class="appleLinksWhite">Copyright © 2018 SISKA - Sistem Informasi Karier. All rights reserved. Ketintang, Gayungan, Ketintang, Gayungan, Surabaya, Jawa Timur — 60231.</span>
                                                                        <br>
                                                                        <div id="stat-div"
                                                                             style="visibility:hidden !important;"
                                                                             height="0px">
                                                                            <img id="stat-link"
                                                                                 src="https://www.shazam.com/validate-email/email-view?email=matt@reallygoodemails.com"
                                                                                 alt="" border="0" width="0px"
                                                                                 height="0px"
                                                                                 style="visibility:hidden !important;">
                                                                        </div>
                                                                        <br>
                                                                        <br>
                                                                        <br></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <!-- Footer END --> <!-- END Wrapper --></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>