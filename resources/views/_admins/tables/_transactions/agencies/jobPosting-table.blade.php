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
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="agency_id">Agency Filter</label>
                                <select id="agency_id" class="form-control selectpicker" title="-- Select Agency --"
                                        data-live-search="true" data-max-options="1" multiple>
                                    @foreach(\App\Agencies::all() as $ag)
                                        <option value="{{$ag->user->name}}">{{$ag->user->name}}</option>
                                    @endforeach
                                </select>
                                <span class="fa fa-user-tie form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
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
                            @php $no = 1;  @endphp
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
                                    $invoice = 'INV/'.$date->format('Ymd').'/'.$romanDate.'/'.$posting->id;
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <table style="margin: 0">
                                            <tr style="border-bottom: 1px solid #eee">
                                                <td>
                                                    <span style="font-size: 15px">INVOICE
                                                        <a target="_blank" href="{{route('table.jobPostings.invoice',
                                                        ['id'=> encrypt($posting->id)])}}">
                                                            <strong>#{{$invoice}}</strong>
                                                        </a>
                                                    </span>
                                                    <hr style="margin-top: 0">
                                                    <a href="{{route('agency.profile',['id' => $posting->agency_id])}}"
                                                       target="_blank"
                                                       style="float: left;margin-right: .5em;margin-bottom: 1.2em">
                                                        @if($user->ava == "" || $user->ava == "agency.png")
                                                            <img class="img-responsive" width="64" alt="agency.png"
                                                                 src="{{asset('images/agency.png')}}">
                                                        @else
                                                            <img class="img-responsive" width="64" alt="{{$user->ava}}"
                                                                 src="{{asset('storage/users/'.$user->ava)}}">
                                                        @endif
                                                    </a>
                                                    <table style="margin: 0">
                                                        <tr>
                                                            <td>
                                                                <a href="{{route('agency.profile',['id' =>
                                                                $posting->agency_id])}}" target="_blank">
                                                                    <strong>{{$user->name}}</strong></a>
                                                            </td>
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
                                                    <ol style="margin: 0 auto">
                                                        @foreach($vacancies as $vacancy)
                                                            <li style="margin-bottom: .5em">
                                                                <a href="{{route('detail.vacancy',['id' => $vacancy->id])}}"
                                                                   target="_blank">{{$vacancy->judul}}</a>
                                                                <ul>
                                                                    <li>Quiz with <strong>{{$vacancy->passing_grade !=
                                                                    null ? $vacancy->passing_grade : 0}}
                                                                        </strong> passing grade&nbsp;&ndash;&nbsp;for&nbsp;&ndash;
                                                                        <strong>{{$vacancy ->quiz_applicant != null ?
                                                                        $vacancy->quiz_applicant : 0}}
                                                                        </strong> applicants
                                                                    </li>
                                                                    <li>Psycho Test for <strong>{{$vacancy
                                                                    ->psychoTest_applicant != null ? $vacancy
                                                                    ->psychoTest_applicant : 0}}</strong> applicants
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    </ol>
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
                                            <input type="hidden" name="isPaid" id="input_isPaid{{$posting->id}}">
                                            <input type="hidden" name="isAbort" id="input_isAbort{{$posting->id}}">
                                            <input type="hidden" name="isQuiz" id="input_isQuiz{{$posting->id}}">
                                            <input type="hidden" name="isPsychoTest"
                                                   id="input_isPsychoTest{{$posting->id}}">
                                        </form>
                                        <div class="btn-group">
                                            @if(now() <= $posting->created_at->addDay())
                                                <button type="button" class="btn btn-success btn-sm"
                                                        style="font-weight: 600"
                                                        onclick="approving('{{$posting->id}}','{{$invoice}}',
                                                                '{{$plan->isQuiz}}','{{$plan->isPsychoTest}}')"
                                                        {{$posting->isPaid == false ? '' : 'disabled'}}>
                                                    {{$posting->isPaid == false ? 'APPROVE' : 'APPROVED'}}
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-danger btn-sm"
                                                        style="font-weight: 600"
                                                        onclick="aborting('{{$posting->id}}','{{$invoice}}')"
                                                        {{$posting->isAbort == true ? 'disabled' : ''}}>
                                                    {{$posting->isAbort == true ? 'ABORTED' : 'ABORT'}}
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-{{now() <= $posting->created_at->addDay()
                                            ? 'success' : 'danger'}} btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                @if($posting->isPaid == true)
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
        $(function () {
            @if($findAgency != "")
            $("#agency_id").val('{{$findAgency}}').selectpicker('refresh');
            $(".dataTables_filter input[type=search]").val('{{$findAgency}}').trigger('keyup');
            @endif

            @if(old('isQuiz') == 1)
            swal({
                title: 'Quiz Setup #{{old('invoice')}}',
                text: 'For each vacancy in this invoice requires a quiz!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00adb5',
                confirmButtonText: 'Yes, setup now!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        window.location.href = '{{route('quiz.info')}}?vac_ids={{session('vac_ids')}}&psychoTest={{old('isPsychoTest')}}&invoice={{old('invoice')}}';
                    });
                },
                allowOutsideClick: false
            });
            return false;
            @endif
        });

        $("#agency_id").on("change", function () {
            $(".dataTables_filter input[type=search]").val($(this).val()).trigger('keyup');
        });

        function paymentProofModal(asset) {
            $("#paymentProof").attr('src', asset);
            $("#paymentProofModal").modal('show');
        }

        function approving(id, invoice, isQuiz, isPsychoTest) {
            swal({
                title: 'Vacancy Approval #' + invoice,
                text: 'The status of the vacancy in this invoice will be change into "ACTIVE". Are you sure to approve it?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00adb5',
                confirmButtonText: 'Yes, approve it!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $("#input_isPaid" + id).val(1);
                        $("#input_isAbort" + id).val(0);
                        $("#input_isQuiz" + id).val(isQuiz);
                        $("#input_isPsychoTest" + id).val(isPsychoTest);
                        $("#form-approval" + id)[0].submit();
                    });
                },
                allowOutsideClick: false
            });
            return false;
        }

        function revertApproval(id, invoice) {
            swal({
                title: 'Revert Approval #' + invoice,
                text: 'The status of the vacancy in this invoice will be change into "INACTIVE". Are you sure to revert it?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, revert it!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $("#input_isPaid" + id).val(0);
                        $("#input_isAbort" + id).val(0);
                        $("#form-approval" + id)[0].submit();
                    });
                },
                allowOutsideClick: false
            });
            return false;
        }

        function aborting(id, invoice) {
            swal({
                title: 'Aborting #' + invoice,
                text: 'Are you sure to abort it? You won\'t be able to revert this!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, abort it!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $("#input_isPaid" + id).val(0);
                        $("#input_isAbort" + id).val(1);
                        $("#form-approval" + id)[0].submit();
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