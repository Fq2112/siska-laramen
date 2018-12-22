@extends('layouts.mst_admin')
@section('title', 'Partners Vacancies Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Partners Vacancies
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
                                <label for="partner_id">Partner Filter</label>
                                <select id="partner_id" class="form-control selectpicker" title="-- Select Partner --"
                                        data-live-search="true" data-max-options="1" multiple>
                                    @foreach($partnership as $partner)
                                        <option value="{{$partner->name}}">{{$partner->name}}</option>
                                    @endforeach
                                </select>
                                <span class="fa fa-handshake form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <table id="myDataTable" class="table table-striped table-bordered bulk_action">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="check-all" class="flat"></th>
                                <th>ID</th>
                                <th>Details</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($partnerVacancies as $row)
                                @php
                                    $vacancy = $row->getVacancy;
                                    if($vacancy->plan_id != null){
                                        $plan = \App\Plan::find($vacancy->plan_id);
                                    }
                                    $agency = \App\Agencies::find($vacancy->agency_id);
                                    $user = \App\User::find($agency->user_id);
                                    $city = \App\Cities::find($vacancy->cities_id)->name;
                                    $salary = \App\Salaries::find($vacancy->salary_id);
                                    $jobfunc = \App\FungsiKerja::find($vacancy->fungsikerja_id);
                                    $joblevel = \App\JobLevel::find($vacancy->joblevel_id);
                                    $industry = \App\Industri::find($vacancy->industry_id);
                                    $degrees = \App\Tingkatpend::find($vacancy->tingkatpend_id);
                                    $majors = \App\Jurusanpend::find($vacancy->jurusanpend_id);
                                @endphp
                                <tr>
                                    <td class="a-center" style="vertical-align: middle" align="center">
                                        <input type="checkbox" class="flat">
                                    </td>
                                    <td style="vertical-align: middle">{{$row->id}}</td>
                                    <td style="vertical-align: middle">
                                        <table style="margin: 0">
                                            <tr>
                                                <td>
                                                    <table style="float: left;margin-right: .5em;margin-bottom: 0">
                                                        <tr>
                                                            <td style="vertical-align: middle;text-align: center">
                                                                <a href="{{route('agency.profile',['id' =>
                                                                $vacancy->agency_id])}}" target="_blank">
                                                                    <img class="img-responsive" width="100"
                                                                         style="margin: 0 auto"
                                                                         src="{{$user->ava == "" || $user->ava ==
                                                                         "agency.png" ? asset('images/agency.png') :
                                                                         asset('storage/users/'.$user->ava)}}">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;text-align: center">
                                                                <span data-toggle="tooltip" data-placement="left"
                                                                      title="Status" class="label label-default"
                                                                      style="background: {{$vacancy->isPost == true ?
                                                                      '#00adb5' : '#fa5555'}}"><strong
                                                                            style="text-transform: uppercase">{{$vacancy->isPost
                                                                      == true ? 'Active' : 'Inactive'}}</strong>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;text-align: center">
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Active Period"
                                                                      style="text-transform: uppercase"
                                                                      class="label label-{{$vacancy->active_period != ""
                                                                       ? 'primary' : 'warning'}}">
                                                                    {{$vacancy->active_period != "" ? 'Until '.
                                                                    \Carbon\Carbon::parse($vacancy->active_period)
                                                                    ->format('j F Y') : 'Unknown'}}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <a href="{{route('detail.vacancy',['id' =>
                                                                $vacancy->id])}}" target="_blank">
                                                                    <strong>{{$vacancy->judul}}</strong></a>&nbsp;&ndash;
                                                                @if($vacancy->isPost == true)
                                                                    <span data-toggle="tooltip" data-placement="bottom"
                                                                          title="Plan" class="label label-success">
                                                                        <strong style="text-transform: uppercase">
                                                                            <i class="fa fa-thumbtack"></i>&ensp;
                                                                            {{$plan->name}}
                                                                        </strong> Package</span>&nbsp;|
                                                                @endif
                                                                <span class="label label-default" data-toggle="tooltip"
                                                                      data-placement="bottom" title="Created at">
                                                                <i class="fa fa-calendar-alt"></i>&ensp;
                                                                    {{\Carbon\Carbon::parse($vacancy->created_at)
                                                                    ->format('j F Y')}}</span> |
                                                                <span class="label label-default" data-toggle="tooltip"
                                                                      data-placement="bottom" title="Last Update">
                                                                    <i class="fa fa-clock"></i>&ensp;{{$vacancy
                                                                    ->updated_at->diffForHumans()}}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="{{route('agency.profile',['id' =>
                                                            $vacancy->agency_id])}}" target="_blank">{{$user->name}}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{substr($city, 0, 2)=="Ko" ? substr($city,5) :
                                                            substr($city,10)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Recruitment Date" class="label label-info">
                                                                    <strong><i class="fa fa-users"></i>&ensp;
                                                                        {{$vacancy->recruitmentDate_start != "" &&
                                                                        $vacancy->recruitmentDate_end != "" ?
                                                                        \Carbon\Carbon::parse
                                                                        ($vacancy->recruitmentDate_start)
                                                                        ->format('j F Y').' - '.\Carbon\Carbon::parse
                                                                        ($vacancy->recruitmentDate_end)
                                                                        ->format('j F Y') : 'Unknown'}}
                                                                    </strong>
                                                                </span>&nbsp;|
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Job Interview Date"
                                                                      class="label label-primary">
                                                                    <strong><i class="fa fa-user-tie"></i>&ensp;
                                                                        {{$vacancy->interview_date != "" ?
                                                                        \Carbon\Carbon::parse($vacancy->interview_date)
                                                                        ->format('l, j F Y') : 'Unknown'}}
                                                                    </strong>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <hr style="margin: .5em auto">
                                                    <table>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Job Function">
                                                            <td><i class="fa fa-warehouse"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$jobfunc->nama}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Industry">
                                                            <td><i class="fa fa-industry"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$industry->nama}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Job Level">
                                                            <td><i class="fa fa-level-up-alt"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$joblevel->name}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Salary">
                                                            <td><i class="fa fa-money-bill-wave"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>IDR {{$salary->name}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Education Degree">
                                                            <td><i class="fa fa-graduation-cap"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$degrees->name}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Education Major">
                                                            <td><i class="fa fa-user-graduate"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$majors->name}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Work Experience">
                                                            <td><i class="fa fa-briefcase"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>At least {{$vacancy->pengalaman > 1 ?
                                                                $vacancy->pengalaman.' years' :
                                                                $vacancy->pengalaman.' year'}}</td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Total Applicant">
                                                            <td><i class="fa fa-paper-plane"></i></td>
                                                            <td>&nbsp;</td>
                                                            <td><strong>{{\App\Accepting::where
                                                            ('vacancy_id',$vacancy->id)->where('isApply',true)->count()}}
                                                                </strong> applicants
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <hr style="margin: .5em auto">
                                        <strong>Requirements</strong><br>{!! $vacancy->syarat !!}
                                        <hr style="margin: .5em auto">
                                        <strong>Responsibilities</strong><br>{!! $vacancy->tanggungjawab !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row form-group">
                            <div class="col-sm-4" id="action-btn">
                                <div class="btn-group" style="float: right">
                                    <button id="btn_post" type="button" class="btn btn-success btn-sm"
                                            style="font-weight: 600">
                                        <i class="glyphicon glyphicon-check"></i>&ensp;POST
                                    </button>
                                    <button id="btn_pdf" type="button" class="btn btn-primary btn-sm"
                                            style="font-weight: 600">
                                        <i class="fa fa-file-pdf"></i>&ensp;PDF
                                    </button>
                                    <button id="btn_remove_app" type="button" class="btn btn-danger btn-sm"
                                            style="font-weight: 600">
                                        <i class="fa fa-trash"></i>&ensp;REMOVE
                                    </button>
                                </div>
                            </div>
                            <form method="post" id="form-partnerVac">
                                {{csrf_field()}}
                                <input id="partnerVac_ids" type="hidden" name="partnerVac_ids">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        $(function () {
            var table = $("#myDataTable").DataTable({
                order: [[1, "asc"]],
                columnDefs: [
                    {
                        targets: [0],
                        orderable: false
                    },
                    {
                        targets: [1],
                        visible: false,
                        searchable: false
                    }
                ]
            }), toolbar = $("#myDataTable_wrapper").children().eq(0);

            toolbar.children().toggleClass("col-sm-6 col-sm-4");
            $('#action-btn').appendTo(toolbar);

            @if($findPartner != "")
            $("#partner_id").val('{{$findPartner}}').selectpicker('refresh');
            $(".dataTables_filter input[type=search]").val('{{$findPartner}}').trigger('keyup');
            @endif

            $("#partner_id").on('change', function () {
                $(".dataTables_filter input[type=search]").val($(this).val()).trigger('keyup');
            });

            $("#check-all").on("ifToggled", function () {
                if ($(this).is(":checked")) {
                    $("#myDataTable tbody tr").addClass("selected").find('input[type=checkbox]').iCheck("check");
                } else {
                    $("#myDataTable tbody tr").removeClass("selected").find('input[type=checkbox]').iCheck("uncheck");
                }
            });

            $("#myDataTable tbody").on("click", "tr", function () {
                $(this).toggleClass("selected");
                $(this).find('input[type=checkbox]').iCheck("toggle");
            });

            $('#btn_pdf').on("click", function () {
                var ids = $.map(table.rows('.selected').data(), function (item) {
                    return item[1]
                });
                $("#partnerVac_ids").val(ids);
                $("#form-partnerVac").attr("action", "{{route('partners.vacancies.massPDF')}}");

                if (ids.length > 0) {
                    swal({
                        title: 'Generate PDF',
                        text: 'Are you sure to generate this ' + ids.length + ' selected records into a pdf file? ' +
                            'You won\'t be able to revert this!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00adb5',
                        confirmButtonText: 'Yes, generate now!',
                        showLoaderOnConfirm: true,

                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                // $("#form-partnerVac")[0].submit();
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('partners.vacancies.massPDF')}}",
                                    data: new FormData($("#form-partnerVac")[0]),
                                    contentType: false,
                                    processData: false,
                                    success: function (data) {
                                        if (data == 0) {
                                            swal("Error!", "Couldn't zip the file! Please try again.", "error");
                                        } else {
                                            swal("Success!", "Pdf file(s) is successfully generated and " +
                                                "zipped into PDFs.zip file!", "success");
                                        }
                                    },
                                    error: function () {
                                        swal("Error!", "Something went wrong, please refresh the page.", "error");
                                    }
                                });
                            });
                        },
                        allowOutsideClick: false
                    });
                } else {
                    swal("Error!", "There's no any selected record!", "error");
                }
                return false;
            });

            $('#btn_remove_app').on("click", function () {
                var ids = $.map(table.rows('.selected').data(), function (item) {
                    return item[1]
                });
                $("#partnerVac_ids").val(ids);
                $("#form-partnerVac").attr("action", "{{route('partners.vacancies.massDelete')}}");

                if (ids.length > 0) {
                    swal({
                        title: 'Remove Partner Vacancies',
                        text: 'Are you sure to remove this ' + ids.length + ' selected records? ' +
                            'You won\'t be able to revert this!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#fa5555',
                        confirmButtonText: 'Yes, delete it!',
                        showLoaderOnConfirm: true,

                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                $("#form-partnerVac")[0].submit();
                            });
                        },
                        allowOutsideClick: false
                    });
                } else {
                    swal("Error!", "There's no any selected record!", "error");
                }
                return false;
            });
        });
    </script>
@endpush