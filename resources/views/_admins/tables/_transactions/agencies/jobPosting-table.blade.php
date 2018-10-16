@extends('layouts.mst_admin')
@section('title', 'Job Postings Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Job Postings
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link" data-toggle="tooltip" title="Close" data-placement="right">
                                    <i class="fa fa-times"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Order Details</th>
                                <th>Payment Details</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($postings as $posting)
                                @php
                                    $agency = \App\Agencies::find($posting->agency_id);
                                    $user = \App\User::find($agency->user_id);
                                    $vacancies = \App\Vacancies::whereIn('id',$posting->vacancy_ids);
                                    $plan = \App\Plan::find($posting->plans_id);
                                    $pm = \App\PaymentMethod::find($posting->payment_method_id);
                                    $pc = \App\PaymentCategory::find($pm->payment_category_id);
                                    $date = $posting->created_at;
                                    $romanDate = \App\Support\RomanConverter::numberToRoman($date->format('y')).'/'.
                                    \App\Support\RomanConverter::numberToRoman($date->format('m'));
                                    $invoice = '#INV/'.$date->format('Ymd').'/'.$romanDate.'/'.$posting->id;
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <table style="margin: 0">
                                            <tr style="border-bottom: 1px solid #eee">
                                                <td>
                                                    <span style="font-size: 15px">INVOICE <strong>{{$invoice}}</strong></span>
                                                    <hr style="margin-top: 0">
                                                    @if($user->ava == "" || $user->ava == "agency.png")
                                                        <img style="float: left;margin-right: .5em;margin-bottom: 1.2em"
                                                             class="img-responsive" width="64" alt="agency.png"
                                                             src="{{asset('images/agency.png')}}">
                                                    @else
                                                        <img style="float: left;margin-right: .5em;margin-bottom: 1.2em"
                                                             class="img-responsive" width="64" alt="{{$user->ava}}"
                                                             src="{{asset('storage/users/'.$user->ava)}}">
                                                    @endif
                                                    <table style="margin: 0">
                                                        <tr>
                                                            <td><strong>{{$user->name}}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="mailto:{{$user->email}}">{{$user->email}}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="tel:{{$agency->phone}}">
                                                                    {{$agency->phone}}</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="label label-primary">
                                                                    <strong style="text-transform: uppercase">{{$plan->name}}</strong> Package
                                                                </span>&nbsp;|
                                                                <span class="label label-info">{{$plan->job_ads}}</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>{{$vacancies->count() > 1 ? 'Vacancies' : 'Vacancy'}}</strong>
                                                    <ul>
                                                        @foreach($vacancies->get() as $vacancy)
                                                            <li>{{$vacancy->judul}}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <table style="margin: 0">
                                            <tr data-toggle="tooltip" data-placement="left" title="Payment Category">
                                                <td><i class="fa fa-university"></i></td>
                                                <td>&nbsp;</td>
                                                <td><strong>{{$pc->name}}</strong></td>
                                            </tr>
                                            <tr data-toggle="tooltip" data-placement="left" title="Payment Method">
                                                <td><i class="fa fa-credit-card"></i></td>
                                                <td>&nbsp;</td>
                                                <td><img width="64" src="{{asset('images/paymentMethod/'.$pm->logo)}}">
                                                    &ndash; {{$pm->name}}
                                                </td>
                                            </tr>
                                            <tr data-toggle="tooltip" data-placement="left" title="Payment Code">
                                                <td><i class="fa fa-code"></i></td>
                                                <td>&nbsp;</td>
                                                <td>{{$posting->payment_code}}</td>
                                            </tr>
                                            <tr data-toggle="tooltip" data-placement="left" title="Payment Date">
                                                <td><i class="fa fa-calendar-alt"></i></td>
                                                <td>&nbsp;</td>
                                                <td>{{$posting->isPaid == true ? \Carbon\Carbon::parse
                                                ($posting->date_payment)->format('j F Y') : 'Payment Date (-)'}}</td>
                                            </tr>
                                        </table>
                                        <hr style="margin: .5em auto">
                                        @if($posting->payment_proof != "")
                                            <img class="img-responsive" width="128" alt="Payment Proof"
                                                 src="{{asset('storage/users/agencies/payment/'.$posting->payment_proof)}}"
                                                 style="margin:0 auto;cursor: pointer" onclick="paymentProofModal('{{asset
                                                 ('storage/users/agencies/payment/'.$posting->payment_proof)}}')"
                                                 data-toggle="tooltip" data-placement="left" title="Payment Proof">
                                        @else
                                            <img class="img-responsive" width="128" alt="Payment Proof"
                                                 src="{{asset('images/no_image.png')}}" style="margin:0 auto">
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle;" align="center">
                                        @if($posting->isPaid == true)
                                            <img width="100" class="media-object"
                                                 src="{{asset('images/stamp_paid.png')}}">
                                        @else
                                            <img width="100" class="media-object"
                                                 src="{{asset('images/stamp_unpaid.png')}}">
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <form method="post" action="{{route('table.jobPostings.update',['id' =>
                                            $posting->id])}}" id="form-approval{{$posting->id}}">
                                            {{csrf_field()}} {{method_field('PUT')}}
                                            <input type="hidden" name="invoice" value="{{$invoice}}">
                                            <input type="hidden" name="isPost" value="1">
                                        </form>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success btn-sm"
                                                    style="font-weight: 600"
                                                    onclick="approving('{{$posting->id}}','{{$invoice}}')"
                                                    {{$vacancies->first()->isPost == false ? '' : 'disabled'}}>
                                                {{$vacancies->first()->isPost == false ? 'APPROVE' : 'APPROVED'}}
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                @if($vacancies->first()->isPost == true)
                                                    <form method="post"
                                                          action="{{route('table.jobPostings.update',['id' =>
                                                          $posting->id])}}" id="form-revert{{$posting->id}}">
                                                        {{csrf_field()}} {{method_field('PUT')}}
                                                        <input type="hidden" name="invoice" value="{{$invoice}}">
                                                        <input type="hidden" name="isPost" value="0">
                                                    </form>
                                                    <li><a onclick="revertApproval('{{$posting->id}}','{{$invoice}}')">
                                                            <i class="fa fa-undo"></i>&ensp;Revert</a></li>
                                                @endif
                                                <li>
                                                    <a href="{{route('table.jobPostings.delete',['id'=> encrypt
                                                       ($posting->id)])}}" class="delete-approval">
                                                        <i class="fa fa-trash-alt"></i>&ensp;Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="paymentProofModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="width: 50%">
            <img style="margin: 0 auto" class="img-responsive" id="paymentProof" src="">
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        function paymentProofModal(asset) {
            $("#paymentProof").attr('src', asset);
            $("#paymentProofModal").modal('show');
        }

        function approving(id, invoice) {
            swal({
                title: 'Vacancy Approval ' + invoice,
                text: 'The status of the vacancy in this invoice will be change into "ACTIVE". Are you sure to approve it?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00adb5',
                confirmButtonText: 'Yes, approve it!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $("#form-approval" + id)[0].submit();
                    });
                },
                allowOutsideClick: false
            });
            return false;
        }

        function revertApproval(id, invoice) {
            swal({
                title: 'Revert Approval ' + invoice,
                text: 'The status of the vacancy in this invoice will be change into "INACTIVE". Are you sure to revert it?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, revert it!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $("#form-revert" + id)[0].submit();
                    });
                },
                allowOutsideClick: false
            });
            return false;
        }

        $(".delete-approval").on("click", function () {
            var linkURL = $(this).attr("href");
            swal({
                title: 'Delete Approval',
                text: 'Are you sure? You won\'t be able to revert this!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        window.location.href = linkURL;
                    });
                },
                allowOutsideClick: false
            });
            return false;
        });
    </script>
@endpush