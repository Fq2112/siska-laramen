@extends('layouts.mst_admin')
@section('title', 'Psycho Test List &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 id="panel_title">Psycho Test
                            <small>List</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="btn_psychoTest" data-toggle="tooltip" title="Create" data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" id="content1">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Vacancy</th>
                                <th>Rooms</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($infos as $info)
                                @php
                                    $vacancy = $info->getVacancy;
                                    $psychoTestDate = $vacancy->psychoTestDate_start &&
                                    $vacancy->psychoTestDate_end != "" ?
                                    \Carbon\Carbon::parse($vacancy->psychoTestDate_start)->format('j F Y')." - ".
                                    \Carbon\Carbon::parse($vacancy->psychoTestDate_end)->format('j F Y') : '-';
                                    $agency = $vacancy->agencies;
                                    $userAgency = $agency->user;
                                    $ava = $userAgency->ava == ""||$userAgency->ava == "agency.png" ?
                                    asset('images/agency.png') : asset('storage/users/'.$userAgency->ava);
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="{{route('agency.profile',['id' => $agency->id])}}"
                                                       target="_blank"
                                                       style="float: left;margin-right: .5em;margin-bottom: 0">
                                                        <img class="img-responsive" width="100" src="{{$ava}}">
                                                    </a>
                                                    <table style="margin: 0">
                                                        <tr>
                                                            <td>
                                                                <a href="{{route('detail.vacancy',['id' =>
                                                                $vacancy->id])}}" target="_blank">
                                                                    <strong>{{$vacancy->judul}}</strong>
                                                                </a> &ndash;
                                                                <a href="{{route('agency.profile',['id' => $agency->id])}}"
                                                                   target="_blank">
                                                                    {{$userAgency->name}}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span data-toggle="tooltip" data-placement="left"
                                                                      title="Recruitment Date"
                                                                      class="label label-default">
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
                                                                <span data-toggle="tooltip" data-placement="right"
                                                                      title="Online Quiz (TPA & TKD) Date"
                                                                      class="label label-default">
                                                                        <strong><i class="fa fa-grin-beam"></i>&ensp;
                                                                            {{$vacancy->quizDate_start != "" &&
                                                                            $vacancy->quizDate_end != "" ?
                                                                            \Carbon\Carbon::parse
                                                                            ($vacancy->quizDate_start)->format('j F Y')
                                                                            .' - '.\Carbon\Carbon::parse
                                                                            ($vacancy->quizDate_end)->format('j F Y') :
                                                                            'Unknown'}}
                                                                        </strong>
                                                                    </span>&nbsp;
                                                                <hr style="margin: .5em auto">
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Psycho Test (Online Interview) Date"
                                                                      class="label label-danger">
                                                                        <strong><i class="fa fa-comments"></i>&ensp;
                                                                            {{$psychoTestDate}}
                                                                        </strong>
                                                                    </span>&nbsp;|
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Job Interview Date"
                                                                      class="label label-default">
                                                                    <strong><i class="fa fa-user-tie"></i>&ensp;
                                                                        {{$vacancy->interview_date != "" ?
                                                                        \Carbon\Carbon::parse($vacancy->interview_date)
                                                                        ->format('l, j F Y') : 'Unknown'}}
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
                                                <td><i class="fa fa-paper-plane"></i>&nbsp;</td>
                                                <td>Total Applicant</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{\App\Accepting::where('vacancy_id',$vacancy->id)
                                                ->where('isApply',true)->count()}} applicants
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-grin-beam"></i>&nbsp;</td>
                                                <td>Total Participant for Quiz with {{$vacancy->passing_grade}} passing
                                                    grade
                                                </td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$vacancy->quiz_applicant}} persons
                                                </td>
                                            </tr>
                                            <tr style="font-weight: 600">
                                                <td><i class="fa fa-comments"></i>&nbsp;</td>
                                                <td>Total Participant for Psycho Test</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$vacancy->psychoTest_applicant}} persons</td>
                                            </tr>
                                            <tr style="font-weight: 600">
                                                <td><i class="fa fa-user-tie"></i>&nbsp;</td>
                                                <td>Interviewer</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$info->getAdmin->name}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <ol style="margin-left: -20px">
                                            @foreach($info->room_codes as $room)
                                                @php strtok($room, "_"); $seeker_id = strtok(''); @endphp
                                                <li>{{$room}}</li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick="editPsychoTest('{{$info->id}}','{{implode(",",$info->room_codes)}}',
                                                '{{$vacancy->id}}', '{{$info->admin_id}}')"
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="{{route('psychoTest.delete.info',['id'=>encrypt($info->id)])}}"
                                           class="btn btn-danger btn-sm delete-data" style="font-size: 16px"
                                           data-toggle="tooltip"
                                           title="Delete" data-placement="right"><i class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="x_content" id="content2" style="display: none">
                        <form method="post" action="{{route('psychoTest.create.info')}}" id="form-psychoTest-setup">
                            {{csrf_field()}}
                            <input type="hidden" name="_method">
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="vacancy_id">Vacancy <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                        <select id="vacancy_id" class="form-control selectpicker"
                                                title="-- Select Vacancy --" data-live-search="true"
                                                data-selected-text-format="count > 3" name="vacancy_ids[]"
                                                multiple required>
                                            @foreach($vacancies as $vacancy)
                                                <option value="{{$vacancy->id}}">{{$vacancy->judul}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span style="color: #fa5555">P.S.: You can only select vacancy that its psycho test hasn't
                                        been set yet and its quiz date has been ended (except when editing).</span>
                                </div>
                            </div>
                            <div class="row form-group" id="interviewer_input" style="display: none;">
                                <div class="col-lg-12">
                                    <label for="interviewer_id">Interviewer <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user-tie"></i></span>
                                        <select id="interviewer_id" class="form-control selectpicker"
                                                title="-- Select Interviewer --" data-live-search="true"
                                                name="admin_id" disabled required>
                                            @foreach($interviewers as $interviewer)
                                                @php
                                                    $total = \App\PsychoTestInfo::whereHas('getVacancy', function ($vac){
                                                        $vac->where('psychoTestDate_end','>=',today());
                                                    })->where('admin_id', $interviewer->id)->count();
                                                @endphp
                                                <option data-subtext="{{$total}} agency(s)"
                                                        value="{{$interviewer->id}}" {{$total >= 10 ? 'disabled' : ''}}>
                                                    {{$interviewer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span style="color: #fa5555">P.S.: You can only select interviewer who hasn't handled 10 agencies.</span>
                                </div>
                            </div>
                            <hr class="hr-divider" id="vacancySetupDivider" style="display:none">
                            <img src="{{asset('images/loading2.gif')}}" id="image"
                                 class="img-responsive ld ld-fade" style="display:none">
                            <div id="input-psychoTest-setup"></div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary btn-block" id="btn_psychoTest_submit">
                                        <strong>SUBMIT</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        @if($findVac != null)
        $(function () {
            $(".btn_psychoTest").click();
            @foreach($findVac as $row)
            $("#vacancy_id option[value='{{$row}}']").attr('selected', 'selected');
            @endforeach
            $('#vacancy_id option:selected').each(function (i, selected) {
                setTimeout(loadVacancyData('{{implode(',',$findVac->toArray())}}'), 1000);
            });
            $("#vacancy_id").selectpicker('refresh');
            $("#vacancySetupDivider").css('display', 'block');
        });
        @endif

        $(".btn_psychoTest").on("click", function () {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $(".btn_psychoTest i").toggleClass('fa-plus fa-th-list');

            $(".btn_psychoTest[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            }).tooltip('show');

            $("#panel_title").html(function (i, v) {
                return v === "Psycho Test Setup<small>Form</small>" ? "Psycho Test <small>List</small>" :
                    "Psycho Test Setup<small>Form</small>";
            });

            $("#vacancySetupDivider").css('display', 'none');
            $("#input-psychoTest-setup").html('');
            $("#btn_psychoTest_submit").html("<strong>SUBMIT</strong>");

            @foreach($vacancies as $vacancy)
            var options = $("#vacancy_id option[value='{{$vacancy->id}}']");
            @if($vacancy->getPsychoTestInfo != null)
            options.attr("disabled", "disabled");
            @else
            options.removeAttr("disabled");
            @endif
            @endforeach
            $("#vacancy_id").val('default').attr('name', 'vacancy_ids[]')
                .selectpicker({maxOptions: '{{count($vacancies)}}'}).selectpicker('refresh');

            $("#form-psychoTest-setup").attr('action', '{{route('psychoTest.create.info')}}');

            $("#interviewer_input").hide();
            $("#interviewer_id").val('default').prop('disabled', true).selectpicker('refresh');
        });

        $("#vacancy_id").on("change", function () {
            var $id = $(this).val();
            $('#vacancy_id option:selected').each(function (i, selected) {
                setTimeout(loadVacancyData($id), 1000);
                $("#vacancySetupDivider").css('display', 'block');
            });
        });

        function loadVacancyData($id) {
            $.ajax({
                url: '{{route('psychoTest.vacancy.info',['id' => ''])}}/' + $id,
                type: "GET",
                data: $("#vacancy_id"),
                beforeSend: function () {
                    $('#image').show();
                    $('#input-psychoTest-setup').hide();
                },
                complete: function () {
                    $('#image').hide();
                    $('#input-psychoTest-setup').show();
                },
                success: function (data) {
                    $("#input-psychoTest-setup").empty();
                    $.each(data, function (i, val) {
                        $("#input-psychoTest-setup").append(
                            '<div class="row form-group" style="margin-bottom: 0;margin-top: 1.5em">' +
                            '<div class="col-lg-12">' +
                            '<label style="font-size: 18px">' + val.judul + '</label></div></div>' +
                            '<div class="row form-group">' +
                            '<div class="col-lg-12">' +
                            '<label for="admin_id">Interviewer <span class="required">*</span></label>' +
                            '<div class="input-group">' +
                            '<span class="input-group-addon"><i class="fa fa-user-tie"></i></span>' +
                            '<select id="admin_id" class="form-control selectpicker" title="-- Select Interviewer --" ' +
                            'data-live-search="true" name="admin_ids[]" required>' +
                            '@foreach($interviewers as $interviewer)' +
                            '@php $total = \App\PsychoTestInfo::whereHas('getVacancy', function ($vac){
                                $vac->where('psychoTestDate_end','>=',today());
                            })->where('admin_id', $interviewer->id)->count();@endphp' +
                            '<option data-subtext="{{$total}} agency(s)" value="{{$interviewer->id}}" ' +
                            '{{$total >= 10 ? 'disabled' : ''}}>{{$interviewer->name}}</option>@endforeach' +
                            '</select></div></div></div>' +
                            '<div class="row form-group" id="input_roomCode' + val.id + '"></div>'
                        );

                        var input_roomCode = '';
                        $.each(val.participant, function (x, nilai) {
                            x = x + 1;
                            input_roomCode +=
                                '<div class="col-lg-4">' +
                                '<label for="room_code">Room Code #' + x + '<span class="required">*</span></label>' +
                                '<div class="input-group">' +
                                '<span class="input-group-btn">' +
                                '<button type="button" class="btn btn-dark psychoTestCodes" ' +
                                'onclick="generateCodeBtn(' + val.id + ', ' + nilai.seeker_id + ')">' +
                                '<i class="fa fa-sync"></i></button></span>' +
                                '<input id="room_code' + val.id + '-' + nilai.seeker_id + '" ' +
                                'name="room_codes[' + val.id + '][]" type="text" class="form-control" readonly required>' +
                                '<span class="input-group-addon"><i class="fa fa-shield-alt"></i></span></div></div>';
                        });
                        $("#input_roomCode" + val.id).html(input_roomCode);
                    });
                    $(".selectpicker").selectpicker('render');
                    $(".psychoTestCodes").click();
                },
                error: function () {
                    swal({
                        title: 'Oops...',
                        text: 'Something went wrong! Please refresh the page.',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
            return false;
        }

        function editPsychoTest(id, room_codes, vacID, adminID) {
            $(".btn_psychoTest i").toggleClass('fa-plus fa-th-list');
            $(".btn_psychoTest[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            });
            $("#panel_title").html(function (i, v) {
                return v === "Psycho Test Edit<small>Form</small>" ? "Psycho Test <small>List</small>" :
                    "Psycho Test Edit<small>Form</small>";
            });
            $("#vacancySetupDivider").css('display', 'none');
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $("#vacancy_id option[value=" + vacID + "]").removeAttr('disabled');
            $("#vacancy_id").val(vacID).attr('name', 'vacancy_id').selectpicker({maxOptions: 1}).selectpicker('refresh');

            $("#input-psychoTest-setup").html('<div class="row form-group" id="input_roomCode' + id + '"></div>');

            var input_roomCode = '';
            $.each(room_codes.split(","), function (i, val) {
                i = i + 1;
                input_roomCode +=
                    '<div class="col-lg-4">' +
                    '<label for="room_code">Room Code #' + i + '<span class="required">*</span></label>' +
                    '<div class="input-group">' +
                    '<span class="input-group-btn">' +
                    '<button type="button" class="btn btn-dark psychoTestCodes" ' +
                    'onclick="generateCodeBtn(' + vacID + ', ' + i + ')">' +
                    '<i class="fa fa-sync"></i></button></span>' +
                    '<input id="room_code' + vacID + '-' + i + '" name="room_codes[]" type="text" ' +
                    'class="form-control" value="' + val + '" readonly required>' +
                    '<span class="input-group-addon"><i class="fa fa-shield-alt"></i></span>' +
                    '</div></div>';
            });
            $("#input_roomCode" + id).html(input_roomCode);

            $("#interviewer_input").show();
            $("#interviewer_id").prop('disabled', false).val(adminID).selectpicker('refresh');
            $("#form-psychoTest-setup input[name='_method']").val('PUT');
            $("#btn_psychoTest_submit").html("<strong>SAVE CHANGES</strong>");

            $("#form-psychoTest-setup").attr("action", "{{ url('admin/psychoTest') }}/" + id + "/update");
        }

        function generateCodeBtn(vacID, participantID) {
            $("#room_code" + vacID + "-" + participantID).val(vacID + generateCode() + participantID);
        }

        $("#form-psychoTest-setup").on("submit", function (e) {
            e.preventDefault();
            if ($("#input-psychoTest-setup").find('.has-error').length == 0) {
                $(this)[0].submit();
            }
        });

        function generateCode() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

            for (var i = 0; i < 3; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text + "_";
        }
    </script>
@endpush

