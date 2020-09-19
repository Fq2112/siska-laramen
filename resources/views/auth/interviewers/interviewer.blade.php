@extends('layouts.mst_admin')
@section('title', ''.Auth::guard('admin')->user()->name.'\'s Dashboard &ndash; '.env('APP_NAME').' Interviewer | '.env('APP_TITLE'))
@push('styles')
    <style>
        .dataTables_filter {
            width: auto;
        }
    </style>
@endpush
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 id="panel_title">Psycho Test Room
                            <small>List</small>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-fixed-header" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Vacancy</th>
                                <th>Candidates</th>
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
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <ol style="margin-left: -20px">
                                            @foreach($info->room_codes as $room)
                                                @php
                                                    strtok($room, "_"); $seeker_id = strtok('');
                                                    $seeker = \App\Seekers::find($seeker_id);
                                                    $result = \App\PsychoTestResult::where('psychoTest_id', $info->id)
                                                    ->where('seeker_id', $seeker->id);
                                                    if(!$result->count()){
                                                        $kompetensi = null;
                                                        $karakter = null;
                                                        $attitude = null;
                                                        $grooming = null;
                                                        $komunikasi = null;
                                                        $anthusiasme = null;
                                                        $note = null;

                                                    } else{
                                                        $kompetensi = $result->first()->kompetensi;
                                                        $karakter = $result->first()->karakter;
                                                        $attitude = $result->first()->attitude;
                                                        $grooming = $result->first()->grooming;
                                                        $komunikasi = $result->first()->komunikasi;
                                                        $anthusiasme = $result->first()->anthusiasme;
                                                        $note = $result->first()->note;
                                                    }
                                                @endphp
                                                <li style="margin: 5px 0">
                                                    <button class="btn btn-{{!$result->count() ? 'primary' : 'dark'}} btn-sm pull-right"
                                                            data-placement="left" data-toggle="tooltip"
                                                            title="{{!$result->count() ? 'Start Interview' : 'Check Result'}}"
                                                            onclick="accessPsychoTest('{{encrypt($info->id)}}','{{$room}}',
                                                                    '{{$vacancy->judul}}','{{$vacancy->psychoTestDate_start}}',
                                                                    '{{$vacancy->id}}','{{$ava}}','{{$userAgency->name}}',
                                                                    '{{$psychoTestDate}}','{{$seeker_id}}',
                                                                    '{{$seeker->user->name}}','{{$result->count()}}',
                                                                    '{{$kompetensi}}','{{$karakter}}','{{$attitude}}',
                                                                    '{{$grooming}}','{{$komunikasi}}',
                                                                    '{{$anthusiasme}}','{{$note}}')">
                                                        <i class="fa fa-comments"></i>
                                                    </button>
                                                    <table>
                                                        <tr data-toggle="tooltip" data-placement="left"
                                                            title="Candidate">
                                                            <td><i class="fa fa-user-graduate"></i></td>
                                                            <td>&nbsp;</td>
                                                            <td><strong>{{$seeker->user->name}}</strong></td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" data-placement="left" title="Room">
                                                            <td><i class="fa fa-shield-alt"></i></td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$room}}</td>
                                                        </tr>
                                                    </table>
                                                </li>
                                            @endforeach
                                        </ol>
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
    <div id="psychoTestModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Hi {{Auth::guard('admin')->user()->name}},</h4>
                </div>
                <div class="modal-body">
                    <p style="font-size: 17px" align="justify" class="psychoTestDesc">
                        Before proceeding to the psycho test room with this following details, you have to click
                        the "Enter Room" button below.
                    </p>
                    <hr class="hr-divider psychoTestDesc">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="media">
                                <div class="media-left media-middle">
                                    <img width="100" class="media-object" id="agencyAva">
                                </div>
                                <div class="media-body">
                                    <small class="media-heading" style="font-size: 17px;">
                                        <a style="color: #00ADB5" id="vacJudul"></a>
                                        <sub style="color: #fa5555;text-transform: none" id="agencyName"></sub>
                                    </small>
                                    <blockquote style="font-size: 16px;color: #7f7f7f">
                                        <ul class="list-inline">
                                            <li><a class="myTag myTag-plans" id="psychoTestDate"></a></li>
                                            <li><a class="myTag myTag-plans" id="psychoTestCode"></a></li>
                                            <li><a class="myTag" id="psychoTestCandidate"></a></li>
                                        </ul>
                                        <div id="psychoTestResult"></div>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form id="form-access-psychoTest" method="post" action="{{route('join.psychoTest.room')}}">
                        {{csrf_field()}}
                        <input id="psychoTest_id" type="hidden" name="psychoTest_id">
                        <input id="seeker_id" type="hidden" name="seeker_id">
                        <input id="accessCode" type="hidden" name="accessCode">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Enter Room</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        function accessPsychoTest(encryptID, room, judul, start, vacID, ava, name, date, seeker_id, seeker_name, check, kompetensi, karakter, attitude, grooming, komunikasi, anthusiasme, note) {
            $("#agencyAva").attr('src', ava);
            $("#agencyName").html('&ndash; ' + name);
            $("#vacJudul").attr('href', '{{route('detail.vacancy',['id'=> ''])}}/' + vacID).text(judul);
            $("#psychoTestDate").html('<i class="fa fa-comments"></i>&ensp;Psycho Test Date: ' +
                '<strong>' + date + '</strong>');
            $("#psychoTestCode").html('<i class="fa fa-shield-alt"></i>&ensp;Room Code: ' +
                '<strong>' + room + '</strong>');
            $("#psychoTestCandidate").html('<i class="fa fa-user-graduate"></i>&ensp;Candidate: ' +
                '<strong>' + seeker_name + '</strong>');

            $("#psychoTest_id").val(encryptID);
            $("#seeker_id").val(seeker_id);
            $("#accessCode").val(room);

            if (check <= 0) {
                $("#psychoTestModal .modal-footer, #psychoTestModal .psychoTestDesc").show();
                $("#psychoTestResult").empty();

            } else {
                var $note = note != "" ? note : '(empty)';
                $("#psychoTestModal .modal-footer, #psychoTestModal .psychoTestDesc").hide();
                $("#psychoTestResult").html(
                    '<small style="font-size: 15px"><strong>Psycho Test Result:</strong></small>' +
                    '<hr style="margin-top: 0">' +
                    '<ul class="list-inline">' +
                    '<li><a class="myTag"><strong>Kompetensi:</strong> ' + kompetensi + '</a></li>' +
                    '<li><a class="myTag"><strong>Karakter:</strong> ' + karakter + '</a></li>' +
                    '<li><a class="myTag"><strong>Attitude:</strong> ' + attitude + '</a></li>' +
                    '<li><a class="myTag"><strong>Grooming:</strong> ' + grooming + '</a></li>' +
                    '<li><a class="myTag"><strong>Komunikasi:</strong> ' + komunikasi + '</a></li>' +
                    '<li><a class="myTag"><strong>Anthusiasme:</strong> ' + anthusiasme + '</a></li></ul>' +
                    '<p align="justify"><strong>Note: </strong><br>' + $note + '</p>'
                );
            }

            $("#psychoTestModal").modal('show');

            $("#form-access-psychoTest").on("submit", function (e) {
                e.preventDefault();
                if (start == null || '{{today()}}' < start) {
                    swal({
                        title: 'ATTENTION!',
                        text: 'The psycho test date of ' + judul + ' hasn\'t started yet.',
                        type: 'warning',
                        timer: '5500'
                    });
                } else {
                    $(this)[0].submit();
                }
            });
        }
    </script>
@endpush

