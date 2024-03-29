@section('title', ''.$user->name.'\'s Dashboard &ndash; Psycho Test (Online Interview) Invitation | '.env('APP_TITLE'))
@extends('layouts.auth.mst_seeker')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Psycho Test (Online Interview) Invitation</h4>
                            <small>Here is your psycho test invitation list.</small>
                            <hr>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: .5em">
                        <div class="col-lg-12 to-animate">
                            @if(count($psychoTestInv) > 1)
                                <small class="pull-right">Showing all <strong>{{count($psychoTestInv)}}</strong> psycho
                                    test invitations
                                </small>
                            @elseif(count($psychoTestInv) == 1)
                                <small class="pull-right">Showing a psycho test invitation</small>
                            @else
                                <small><em>There seems to be none of the psycho test invitation was found&hellip;</em>
                                </small>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($psychoTestInv as $row)
                                @php
                                    $vacancy = \App\Vacancies::find($row->vacancy_id);
                                    $psychoTestDate = $vacancy->psychoTestDate_start &&
                                    $vacancy->psychoTestDate_end != "" ?
                                    \Carbon\Carbon::parse($vacancy->psychoTestDate_start)->format('j F Y')." - ".
                                    \Carbon\Carbon::parse($vacancy->psychoTestDate_end)->format('j F Y') : '-';
                                    $agency = $vacancy->agencies;
                                    $userAgency = $agency->user;
                                    $ava = $userAgency->ava == ""||$userAgency->ava == "agency.png" ?
                                    asset('images/agency.png') : asset('storage/users/'.$userAgency->ava);
                                    $city = \App\Cities::find($vacancy->cities_id)->name;
                                    $salary = \App\Salaries::find($vacancy->salary_id);
                                    $jobfunc = \App\FungsiKerja::find($vacancy->fungsikerja_id);
                                    $joblevel = \App\JobLevel::find($vacancy->joblevel_id);
                                    $industry = \App\Industri::find($vacancy->industry_id);
                                    $degrees = \App\Tingkatpend::find($vacancy->tingkatpend_id);
                                    $majors = \App\Jurusanpend::find($vacancy->jurusanpend_id);
                                    $applicants = \App\Accepting::where('vacancy_id', $vacancy->id)
                                    ->where('isApply', true)->count();
                                    $psychoTest = $vacancy->getPsychoTestInfo;
                                    $room = '';
                                    foreach($psychoTest->room_codes as $code){
                                        strtok($code, '_');
                                        $participantID = strtok('');
                                        if($seeker->id == $participantID){
                                            $room = $code;
                                        }
                                    }

                                    $psychoTestResult = \App\PsychoTestResult::where('psychoTest_id', $psychoTest->id)
                                    ->where('seeker_id', $seeker->id)->count();
                                @endphp
                                <div class="media to-animate">
                                    <div class="media-left media-middle">
                                        <a href="{{route('agency.profile',['id'=>$agency->id])}}">
                                            @if($userAgency->ava == ""||$userAgency->ava == "agency.png")
                                                <img width="100" class="media-object"
                                                     src="{{asset('images/agency.png')}}">
                                            @else
                                                <img width="100" class="media-object"
                                                     src="{{asset('storage/users/'.$userAgency->ava)}}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <small class="media-heading">
                                            <a style="color: #00ADB5"
                                               href="{{route('detail.vacancy',['id'=>$vacancy->id])}}">
                                                {{$vacancy->judul}}</a>
                                            <sub>&ndash;
                                                <a href="{{route('agency.profile',['id'=>$agency->id])}}">
                                                    {{$userAgency->name}}</a></sub>
                                            <span class="pull-right" style="color: #fa5555">
                                                Applied on {{Carbon\Carbon::parse($row->created_at)->format('j F Y')}}
                                            </span>
                                        </small>
                                        <blockquote style="font-size: 12px;color: #7f7f7f">
                                            <div class="pull-right to-animate-2">
                                                <div class="anim-icon anim-icon-md psychoTest {{$psychoTestResult > 0 ||
                                                today() < $vacancy->psychoTestDate_start ? '' : 'ld ld-breath'}}"
                                                     onclick="showPsychoTest('{{$row->id}}','{{$room}}',
                                                             '{{$vacancy->judul}}','{{$vacancy->psychoTestDate_start}}',
                                                             '{{$ava}}','{{$userAgency->name}}','{{$vacancy->id}}',
                                                             '{{$psychoTestDate}}','{{encrypt($psychoTest->id)}}',
                                                             '{{$vacancy->psychoTest_applicant}}')"
                                                     data-toggle="tooltip" data-placement="bottom"
                                                     style="font-size: 25px" title="Enter Room">
                                                    <input id="psychoTest{{$row->id}}" type="checkbox" checked>
                                                    <label for="psychoTest{{$row->id}}"></label>
                                                </div>
                                            </div>
                                            <ul class="list-inline">
                                                <li>
                                                    <a class="tag" target="_blank"
                                                       href="{{route('search.vacancy',['loc' => substr($city, 0, 2)=="Ko" ? substr($city,5) : substr($city,10)])}}">
                                                        <i class="fa fa-map-marked"></i>&ensp;
                                                        {{substr($city, 0, 2)=="Ko" ? substr($city,5) : substr($city,10)}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="tag" target="_blank"
                                                       href="{{route('search.vacancy',['jobfunc_ids' => $vacancy->fungsikerja_id])}}">
                                                        <i class="fa fa-warehouse"></i>&ensp;
                                                        {{$jobfunc->nama}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="tag" target="_blank"
                                                       href="{{route('search.vacancy',['industry_ids' => $vacancy->industry_id])}}">
                                                        <i class="fa fa-industry"></i>&ensp;
                                                        {{$industry->nama}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="tag" target="_blank"
                                                       href="{{route('search.vacancy',['salary_ids' => $salary->id])}}">
                                                        <i class="fa fa-money-bill-wave"></i>
                                                        &ensp;IDR {{$salary->name}}</a>
                                                </li>
                                                <li>
                                                    <a class="tag" target="_blank"
                                                       href="{{route('search.vacancy',['degrees_ids' => $vacancy->tingkatpend_id])}}">
                                                        <i class="fa fa-graduation-cap"></i>
                                                        &ensp;{{$degrees->name}}</a>
                                                </li>
                                                <li>
                                                    <a class="tag" target="_blank"
                                                       href="{{route('search.vacancy',['majors_ids' => $vacancy->jurusanpend_id])}}">
                                                        <i class="fa fa-user-graduate"></i>
                                                        &ensp;{{$majors->name}}</a>
                                                </li>
                                                <li>
                                                    <a class="tag">
                                                        <i class="fa fa-briefcase"></i>
                                                        &ensp;At least {{$vacancy->pengalaman > 1 ?
                                                        $vacancy->pengalaman.' years' : $vacancy->pengalaman.' year'}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="tag tag-plans">
                                                        <i class="fa fa-paper-plane"></i>&ensp;
                                                        <strong>{{$applicants}}</strong> applicants
                                                    </a>
                                                </li>
                                            </ul>
                                            <table style="font-size: 14px;margin-top: -.5em">
                                                <tr>
                                                    <td><i class="fa fa-users"></i></td>
                                                    <td>&nbsp;Recruitment Date</td>
                                                    <td>:
                                                        {{$vacancy->recruitmentDate_start &&
                                                        $vacancy->recruitmentDate_end != "" ?
                                                        \Carbon\Carbon::parse($vacancy->recruitmentDate_start)
                                                        ->format('j F Y')." - ".\Carbon\Carbon::parse
                                                        ($vacancy->recruitmentDate_end)->format('j F Y') : '-'}}
                                                    </td>
                                                </tr>
                                                @if($vacancy->plan_id != "" && $vacancy->plan_id == 2)
                                                    <tr>
                                                        <td><i class="fa fa-grin-beam"></i></td>
                                                        <td>&nbsp;Online Quiz (TPA & TKD) Date</td>
                                                        <td>: {{$vacancy->quizDate_start &&
                                                                $vacancy->quizDate_end != "" ? \Carbon\Carbon::parse
                                                                ($vacancy->quizDate_start)->format('j F Y')." - ".
                                                                \Carbon\Carbon::parse($vacancy->quizDate_end)
                                                                ->format('j F Y') : '-'}}
                                                        </td>
                                                    </tr>
                                                @elseif($vacancy->plan_id != "" &&
                                                $vacancy->plan_id == 3)
                                                    <tr>
                                                        <td><i class="fa fa-grin-beam"></i></td>
                                                        <td>&nbsp;Online Quiz (TPA & TKD) Date</td>
                                                        <td>: {{$vacancy->quizDate_start &&
                                                                $vacancy->quizDate_end != "" ? \Carbon\Carbon::parse
                                                                ($vacancy->quizDate_start)->format('j F Y')." - ".
                                                                \Carbon\Carbon::parse($vacancy->quizDate_end)
                                                                ->format('j F Y') : '-'}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa fa-comments"></i></td>
                                                        <td>&nbsp;Psycho Test (Online Interview) Date</td>
                                                        <td>:
                                                            {{$vacancy->psychoTestDate_start &&
                                                            $vacancy->psychoTestDate_end != "" ?
                                                            \Carbon\Carbon::parse($vacancy->psychoTestDate_start)
                                                            ->format('j F Y')." - ".\Carbon\Carbon::parse
                                                            ($vacancy->psychoTestDate_end)->format('j F Y') : '-'}}
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td><i class="fa fa-user-tie"></i></td>
                                                    <td>&nbsp;Job Interview Date</td>
                                                    <td>:
                                                        {{$vacancy->interview_date != "" ? \Carbon\Carbon::parse
                                                        ($vacancy->interview_date)->format('l, j F Y') : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-clock"></i>
                                                    </td>
                                                    <td>&nbsp;Last Update</td>
                                                    <td>:
                                                        {{$vacancy->updated_at->diffForHumans()}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </blockquote>
                                    </div>
                                </div>
                                <hr class="hr-divider">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="font-family: 'PT Sans', Arial, serif" class="modal fade login" id="psychoTestModal">
        <div class="modal-dialog login animated">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Hi {{$user->name}},</h4>
                </div>
                <div class="modal-body">
                    <div class="box">
                        <div class="content">
                            <p style="font-size: 17px" align="justify">
                                Before proceeding to the psycho test room with this following details, you have to click
                                the "Enter Room" button below.
                            </p>
                            <hr class="hr-divider">
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
                                                    <li><a class="tag" id="psychoTestDate"></a></li>
                                                    <li><a class="tag" id="psychoTestCode"></a></li>
                                                </ul>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="card-read-more">
                        <form method="post" id="form-access-psychoTest" action="{{route('join.psychoTest.room')}}">
                            {{csrf_field()}}
                            <input id="psychoTest_id" type="hidden" name="psychoTest_id">
                            <input id="accessCode" type="hidden" name="accessCode">
                            <button class="btn btn-link btn-block" type="button">
                                <i class="fa fa-comments"></i>&ensp;Enter Room
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function showPsychoTest(id, code, judul, start, ava, name, vacID, date, encryptID) {
            $("#agencyAva").attr('src', ava);
            $("#agencyName").html('&ndash; ' + name);
            $("#vacJudul").attr('href', '{{route('detail.vacancy',['id'=> ''])}}/' + vacID).text(judul);
            $("#psychoTestDate").html('<i class="fa fa-comments"></i>&ensp;Psycho Test Date: <strong>' + date + '</strong>');
            $("#psychoTestCode").html('<i class="fa fa-users"></i>&ensp;Room Code: <strong>' + code + '</strong>');

            $("#psychoTest_id").val(encryptID);
            $("#accessCode").val(code);
            $("#psychoTestModal").modal('show');

            $(document).on('hide.bs.modal', '#psychoTestModal', function (event) {
                $("#psychoTest" + id).prop('checked', true);
            });

            $("#form-access-psychoTest button").on("click", function () {
                if (start == null || '{{today()}}' < start) {
                    swal({
                        title: 'ATTENTION!',
                        text: 'The psycho test date of ' + judul + ' hasn\'t started yet.',
                        type: 'warning',
                        timer: '5500',
                        confirmButtonColor: '#fa5555',
                    });
                } else {
                    $('#form-access-psychoTest')[0].submit();
                }
            });
        }
    </script>
@endpush
