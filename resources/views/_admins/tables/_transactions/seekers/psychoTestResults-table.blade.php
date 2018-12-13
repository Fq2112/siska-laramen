@extends('layouts.mst_admin')
@section('title', 'Psycho Test Results Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Psycho Test Results
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
                                <label for="vacancy_id">Vacancy Filter</label>
                                <select id="vacancy_id" class="form-control selectpicker" title="-- Select Vacancy --"
                                        data-live-search="true" data-max-options="1" multiple>
                                    @foreach($vacancies as $vacancy)
                                        <option value="{{$vacancy->judul}}">{{$vacancy->judul}}</option>
                                    @endforeach
                                </select>
                                <span class="fa fa-briefcase form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <table id="myDataTable" class="table table-striped table-bordered bulk_action">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="check-all" class="flat"></th>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Details</th>
                                <th>Result</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($psychoTestResults as $result)
                                @php
                                    $info = $result->getPsychoTestInfo;
                                    $admin = \App\Admin::find($result->admin_id);
                                    $seeker = \App\Seekers::find($result->seeker_id);
                                    $room = '';
                                    foreach($info->room_codes as $code){
                                        strtok($code, '_');
                                        $participantID = strtok('');
                                        if($seeker->id == $participantID){
                                            $room = $code;
                                        }
                                    }
                                    $userSeeker = \App\User::find($seeker->user_id);
                                    $last_edu = \App\Education::where('seeker_id', $seeker->id)
                                    ->wherenotnull('end_period')->orderby('tingkatpend_id', 'desc')->take(1)->get();
                                    $vacancy = $info->getVacancy;
                                    $agency = $vacancy->agencies;
                                    $userAgency = $agency->user;
                                    $city = \App\Cities::find($vacancy->cities_id)->name;
                                    $degrees = \App\Tingkatpend::find($vacancy->tingkatpend_id);
                                    $majors = \App\Jurusanpend::find($vacancy->jurusanpend_id);
                                @endphp
                                <tr>
                                    <td class="a-center" style="vertical-align: middle" align="center">
                                        <input type="checkbox" class="flat">
                                    </td>
                                    <td style="vertical-align: middle">{{$result->id}}</td>
                                    <td style="vertical-align: middle">{{$room}}</td>
                                    <td style="vertical-align: middle">
                                        <i class="fa fa-shield-alt"></i> Room Code:
                                        <strong>{{$room}}</strong>&ensp;|&ensp;<i class="fa fa-user-tie"></i>
                                        Interviewer: <strong>{{$admin->name}}</strong>
                                        <hr style="margin: .5em auto">
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="{{route('seeker.profile',['id' => $seeker->id])}}"
                                                       target="_blank"
                                                       style="float: left;margin-right: .5em;margin-bottom: .5em">
                                                        @if($userSeeker->ava == "" || $userSeeker->ava == "seeker.png")
                                                            <img class="img-responsive" width="100" alt="seeker.png"
                                                                 src="{{asset('images/seeker.png')}}">
                                                        @else
                                                            <img class="img-responsive" width="100"
                                                                 alt="{{$userSeeker->ava}}"
                                                                 src="{{asset('storage/users/'.$userSeeker->ava)}}">
                                                        @endif
                                                    </a>
                                                    <table style="margin: 0">
                                                        <tr>
                                                            <td>
                                                                <a href="{{route('seeker.profile',['id' => $seeker->id])}}"
                                                                   target="_blank">
                                                                    <strong>{{$userSeeker->name}}</strong></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="mailto:{{$userSeeker->email}}">
                                                                    {{$userSeeker->email}}</a>
                                                                <a href="tel:{{$seeker->phone}}">
                                                                    {{$seeker->phone != "" ? ' | '.$seeker->phone : ''}}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{$seeker->address}} &ndash; {{$seeker->zip_code}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @if($seeker->total_exp != "")
                                                                    <span class="label label-default"
                                                                          style="background: #fa5555"
                                                                          data-toggle="tooltip" data-placement="left"
                                                                          title="Work Experience">
                                                                        <i class="fa fa-briefcase"></i>&ensp;
                                                                        {{$seeker->total_exp > 1 ?
                                                                        $seeker->total_exp.' years' :
                                                                        $seeker->total_exp.' year'}}</span>
                                                                @else
                                                                    <span class="label label-default"
                                                                          style="background: #fa5555"
                                                                          data-toggle="tooltip" data-placement="left"
                                                                          title="Work Experience">
                                                                        <i class="fa fa-briefcase"></i>&ensp;0 year
                                                                    </span>
                                                                @endif|
                                                                <span data-toggle="tooltip"
                                                                      title="Latest Education Degree"
                                                                      class="label label-primary">
                                                                        <strong><i class="fa fa-graduation-cap"></i>&ensp;
                                                                            {{$last_edu->count() ?
                                                                            \App\Tingkatpend::find($last_edu->first()
                                                                            ->tingkatpend_id)->name : '-'}}
                                                                        </strong></span>&nbsp;|
                                                                <span data-toggle="tooltip" data-placement="right"
                                                                      title="Latest Education Major"
                                                                      class="label label-info">
                                                                        <strong><i class="fa fa-user-graduate"></i>&ensp;
                                                                            {{$last_edu->count() ?
                                                                            \App\Jurusanpend::find($last_edu->first()
                                                                            ->jurusanpend_id)->name : '-'}}
                                                                        </strong>
                                                                    </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <hr style="margin: .5em auto">
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="{{route('agency.profile',['id' => $agency->id])}}"
                                                       target="_blank"
                                                       style="float: left;margin-right: .5em;margin-bottom: 0">
                                                        @if($userAgency->ava == "" || $userAgency->ava == "agency.png")
                                                            <img class="img-responsive" width="100" alt="agency.png"
                                                                 src="{{asset('images/agency.png')}}">
                                                        @else
                                                            <img class="img-responsive" width="100"
                                                                 alt="{{$userAgency->ava}}"
                                                                 src="{{asset('storage/users/'.$userAgency->ava)}}">
                                                        @endif
                                                    </a>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <a href="{{route('detail.vacancy',['id' =>
                                                                $vacancy->id])}}" target="_blank">
                                                                    <strong>{{$vacancy->judul}}</strong></a>&nbsp;&ndash;
                                                                @if($vacancy->isPost == true)
                                                                    <span data-toggle="tooltip" data-placement="bottom"
                                                                          title="Plan" class="label label-info">
                                                                        <strong style="text-transform: uppercase">
                                                                            <i class="fa fa-thumbtack"></i>&ensp;
                                                                            {{\App\Plan::find($vacancy->plan_id)->name}}
                                                                        </strong> Package</span>&nbsp;|
                                                                @endif
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Status" class="label label-default"
                                                                      style="background: {{$vacancy->isPost == true ?
                                                                      '#00adb5' : '#fa5555'}}">
                                                                    <strong style="text-transform: uppercase">{{$vacancy->isPost == true ?
                                                                    'Active' : 'Inactive'}}</strong></span>&nbsp;|
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Active Period"
                                                                      style="text-transform: uppercase"
                                                                      class="label label-{{$vacancy->active_period != "" ?
                                                                      'primary' : 'warning'}}">
                                                                    {{$vacancy->active_period != "" ? 'Until '.
                                                                    \Carbon\Carbon::parse($vacancy->active_period)
                                                                    ->format('j F Y') : 'Unknown'}}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="{{route('agency.profile',['id' => $agency->id])}}"
                                                                   target="_blank">{{$userAgency->name}}</a>&nbsp;&ndash;
                                                                <a href="mailto:{{$userAgency->email}}">
                                                                    {{$userAgency->email}}</a>&nbsp;&ndash;
                                                                {{substr($city, 0, 2) == "Ko" ? substr($city,5) :
                                                                substr($city,10)}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span data-toggle="tooltip" data-placement="left"
                                                                      title="Recruitment Date" style="line-height: 0">
                                                                    {{$vacancy->recruitmentDate_start != "" &&
                                                                    $vacancy->recruitmentDate_end != "" ?
                                                                    \Carbon\Carbon::parse
                                                                    ($vacancy->recruitmentDate_start)
                                                                    ->format('j F Y').' - '.\Carbon\Carbon::parse
                                                                    ($vacancy->recruitmentDate_end)
                                                                    ->format('j F Y') : 'Unknown'}}
                                                                </span> |
                                                                <span data-toggle="tooltip" data-placement="right"
                                                                      title="Quiz (Online TPA & TKD) Date">
                                                                        {{$vacancy->quizDate_start != "" &&
                                                                        $vacancy->quizDate_end != "" ?
                                                                        \Carbon\Carbon::parse($vacancy->quizDate_start)
                                                                        ->format('j F Y').' - '.\Carbon\Carbon::parse
                                                                        ($vacancy->quizDate_end)->format('j F Y') :
                                                                        'Unknown'}}
                                                                    </span><br>
                                                                <strong data-toggle="tooltip" data-placement="left"
                                                                        title="Psycho Test (Online Interview) Date"
                                                                        style="line-height: 0">
                                                                    {{$vacancy->psychoTestDate_start != "" &&
                                                                    $vacancy->psychoTestDate_end != "" ?
                                                                    \Carbon\Carbon::parse
                                                                    ($vacancy->psychoTestDate_start)
                                                                    ->format('j F Y').' - '.\Carbon\Carbon::parse
                                                                    ($vacancy->psychoTestDate_end)
                                                                    ->format('j F Y') : 'Unknown'}}
                                                                </strong> |
                                                                <span data-toggle="tooltip" data-placement="right"
                                                                      title="Job Interview Date" style="line-height: 0">
                                                                    {{$vacancy->interview_date != "" ?
                                                                    \Carbon\Carbon::parse($vacancy->interview_date)
                                                                    ->format('l, j F Y') : 'Unknown'}}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span data-toggle="tooltip" title="Work Experience"
                                                                      data-placement="bottom" class="label label-info"
                                                                      style="background: #fa5555">
                                                                    <strong><i class="fa fa-briefcase"></i>&ensp;
                                                                        At least {{$vacancy->pengalaman > 1 ?
                                                                        $vacancy->pengalaman.' years' :
                                                                        $vacancy->pengalaman.' year'}}
                                                                    </strong></span>&nbsp;|
                                                                <span data-toggle="tooltip" title="Education Degree"
                                                                      data-placement="bottom"
                                                                      class="label label-primary">
                                                                    <strong><i class="fa fa-graduation-cap"></i>&ensp;
                                                                        {{$degrees->name}}</strong></span>&nbsp;|
                                                                <span data-toggle="tooltip" title="Education Major"
                                                                      data-placement="bottom" class="label label-info">
                                                                    <strong><i class="fa fa-user-graduate"></i>&ensp;
                                                                        {{$majors->name}}</strong></span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <table>
                                            <tr>
                                                <td>Total Participant for Quiz with <strong>{{$vacancy
                                                    ->passing_grade}}</strong> passing grade
                                                </td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>
                                                    <span>{{$vacancy->quiz_applicant}}</span> participants
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Total Participant for Psycho Test</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>
                                                            <span style="font-weight: 800">
                                                                {{$vacancy->psychoTest_applicant}}</span>
                                                    participants
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <table>
                                            <tr>
                                                <td><i class="fa fa-user-check"></i>&nbsp;</td>
                                                <td>Kompetensi</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="font-weight: 700">{{$result->kompetensi}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-user-shield"></i>&nbsp;</td>
                                                <td>Karakter</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="font-weight: 700">{{$result->karakter}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-user-plus"></i>&nbsp;</td>
                                                <td>Attitude</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="font-weight: 700">{{$result->attitude}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-male"></i>&nbsp;<i class="fa fa-female"></i>&nbsp;
                                                </td>
                                                <td>Grooming</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="font-weight: 700">{{$result->grooming}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-users"></i>&nbsp;</td>
                                                <td>Komunikasi</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="font-weight: 700">{{$result->komunikasi}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-users-cog"></i>&nbsp;</td>
                                                <td>Anthusiasme</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="font-weight: 700">{{$result->anthusiasme}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-user-tag"></i>&nbsp;</td>
                                                <td>Note</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="font-weight: 700">{{$result->note != "" ? $result->note : '-'}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row form-group">
                            <div class="col-sm-4" id="action-btn">
                                <div class="btn-group" style="float: right">
                                    <button id="btn_send_app" type="button" class="btn btn-success btn-sm"
                                            style="font-weight: 600" disabled>
                                        <i class="fa fa-envelope"></i>&ensp;SEND
                                    </button>
                                    <button id="btn_remove_app" type="button" class="btn btn-danger btn-sm"
                                            style="font-weight: 600" disabled>
                                        <i class="fa fa-trash"></i>&ensp;REMOVE
                                    </button>
                                </div>
                            </div>
                            <form method="post" id="form-psychoTest-result">
                                {{csrf_field()}}
                                <input id="psychoTestResult_ids" type="hidden" name="psychoTestResult_ids">
                                <input id="psychoTestCodes" type="hidden" name="codes">
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
                    },
                    {
                        targets: [2],
                        visible: false,
                        searchable: false
                    }
                ]
            }), toolbar = $("#myDataTable_wrapper").children().eq(0);

            toolbar.children().toggleClass("col-sm-6 col-sm-4");
            $('#action-btn').appendTo(toolbar);

            @if($findAgency != "")
            $("#vacancy_id").val('{{$findAgency}}').selectpicker('refresh');
            $(".dataTables_filter input[type=search]").val('{{$findAgency}}').trigger('keyup');
            @endif

            $("#vacancy_id").on('change', function () {
                $(".dataTables_filter input[type=search]").val($(this).val()).trigger('keyup');
            });

            $("#check-all").on("ifToggled", function () {
                if ($(this).is(":checked")) {
                    $("#myDataTable tbody tr").addClass("selected").find('input[type=checkbox]').iCheck("check");
                    $("#btn_send_app, #btn_remove_app").removeAttr("disabled");
                } else {
                    $("#myDataTable tbody tr").removeClass("selected").find('input[type=checkbox]').iCheck("uncheck");
                    $("#btn_send_app, #btn_remove_app").attr("disabled", "disabled");
                }
            });

            $("#myDataTable tbody").on("click", "tr", function () {
                $(this).toggleClass("selected");
                $(this).find('input[type=checkbox]').iCheck("toggle");
            });

            $("#myDataTable tbody tr").find('input[type=checkbox]').on("ifToggled", function () {
                var selected = table.rows('.selected').data().length;

                if ($(this).is(":checked") || selected > 0) {
                    $("#btn_send_app, #btn_remove_app").removeAttr("disabled");
                } else {
                    $("#btn_send_app, #btn_remove_app").attr("disabled", "disabled");
                }
            });

            $('#btn_send_app').on("click", function () {
                var ids = $.map(table.rows('.selected').data(), function (item) {
                    return item[1]
                }), codes = $.map(table.rows('.selected').data(), function (item) {
                    return item[2]
                });
                $("#psychoTestResult_ids").val(ids);
                $("#psychoTestCodes").val(codes);
                $("#form-psychoTest-result").attr("action", "{{route('table.psychoTestResults.massSend')}}");

                swal({
                    title: 'Send Psycho Test Results',
                    text: 'Are you sure to send this ' + ids.length + ' selected records to the Agency\'s email? ' +
                        'You won\'t be able to revert this!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#00adb5',
                    confirmButtonText: 'Yes, send it!',
                    showLoaderOnConfirm: true,

                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            $("#form-psychoTest-result")[0].submit();
                        });
                    },
                    allowOutsideClick: false
                });
                return false;
            });

            $('#btn_remove_app').on("click", function () {
                var ids = $.map(table.rows('.selected').data(), function (item) {
                    return item[1]
                });
                $("#psychoTestResult_ids").val(ids);
                $("#form-psychoTest-result").attr("action", "{{route('table.psychoTestResults.massDelete')}}");

                swal({
                    title: 'Remove Psycho Test Results',
                    text: 'Are you sure to remove this ' + ids.length + ' selected records? ' +
                        'You won\'t be able to revert this!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#fa5555',
                    confirmButtonText: 'Yes, delete it!',
                    showLoaderOnConfirm: true,

                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            $("#form-psychoTest-result")[0].submit();
                        });
                    },
                    allowOutsideClick: false
                });
                return false;
            });
        });
    </script>
@endpush