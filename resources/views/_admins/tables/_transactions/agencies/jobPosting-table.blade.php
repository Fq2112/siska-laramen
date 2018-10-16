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
                                <th>Invoice Number</th>
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
                                    $vacancies = \App\Vacancies::whereIn('id',$posting->vacancy_ids)->get();
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
                                    <td style="vertical-align: middle"><strong>{{$invoice}}</strong></td>
                                    <td style="vertical-align: middle">
                                        <table style="margin: 0">
                                            <tr style="border-bottom: 1px solid #eee">
                                                <td>
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
                                                    <strong>{{count($vacancies) > 1 ? 'Vacancies' : 'Vacancy'}}</strong>
                                                    <ul>
                                                        @foreach($vacancies as $vacancy)
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
                                        @if($posting->isPaid == false)
                                            <a onclick="approval('{{$posting->id}}','{{$invoice}}')"
                                               class="btn btn-success btn-sm" style="font-size: 16px"
                                               data-toggle="tooltip"
                                               title="Approval"><i class="fa fa-clipboard-check"></i></a>
                                            <hr style="margin: 5px auto">
                                        @endif
                                        <a href="{{route('table.jobPostings.delete',['id'=>encrypt($posting->id)])}}"
                                           class="btn btn-danger btn-sm delete-data" style="font-size: 16px"
                                           data-toggle="tooltip"
                                           title="Delete"
                                           data-placement="{{$posting->isPaid == false ? 'bottom' : 'top'}}">
                                            <i class="fa fa-trash-alt"></i></a>
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
    <div id="approvalModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 40%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="invoice"></h4>
                </div>
                <div id="approvalModalContent"></div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        function paymentProofModal(asset) {
            $("#paymentProof").attr('src', asset);
            $("#paymentProofModal").modal('show');
        }

        function approval(id, invoice) {
            $("#invoice").html('Vacancy Approval: <strong>' + invoice + '</strong>');
            $('#approvalModalContent').html(
                '<form method="post" id="' + id + '" action="{{url('admin/tables/agencies/job_postings')}}/' + id +
                '/update">{{csrf_field()}} {{method_field('PUT')}}' +
                '<input type="hidden" name="invoice" value="' + invoice + '">' +
                '<div class="modal-body">' +
                '<div class="row form-group">' +
                '<div class="col-lg-2">' +
                '<div class="row"><div class="col-lg-12">' +
                '<label for="paid' + id + '">Status <span class="required">*</span></label><br>' +
                '<label><input name="isPaid" value="1" type="checkbox" class="flat iCheck" ' +
                'id="paid' + id + '" required> Paid</label><br>' +
                '<label><input name="isPost" value="1" type="checkbox" class="flat iCheck" ' +
                'id="active' + id + '" required> Active</label>' +
                '</div></div></div>' +
                '<div class="col-lg-10">' +
                '<div class="row"><div class="col-lg-12 has-feedback">' +
                '<label for="active_period' + id + '">Active Period <span class="required">*</span></label>' +
                '<input type="text" class="form-control" id="active_period' + id + '" ' +
                'name="active_period" placeholder="yyyy-mm-dd" required>' +
                '<span class="fa fa-calendar-check form-control-feedback right" aria-hidden="true"></span>' +
                '</div></div></div>' +
                '</div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Submit</button></div></form>'
            );
            $('.iCheck').iCheck({checkboxClass: 'icheckbox_flat-green', radioClass: 'iradio_flat-green'});

            $('#active_period' + id).datepicker({
                format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true, startDate: '{{today()}}'
            });

            $("#approvalModal").modal('show');
        }
    </script>
@endpush