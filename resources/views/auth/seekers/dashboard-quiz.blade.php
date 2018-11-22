@section('title', ''.$user->name.'\'s Dashboard &ndash; Online Quiz (TPA and TKD) Invitation | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_seeker')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Online Quiz (TPA & TKD) Invitation</h4>
                            <small>Here is the current and previous status of your quiz invitations.</small>
                            <hr>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: .5em">
                        <div class="col-lg-3 to-animate-2">
                            <form id="form-time" action="{{route('seeker.invitation.quiz')}}">
                                <select class="form-control selectpicker" name="time" data-container="body">
                                    <option value="1" {{$time == 1 ? 'selected' : ''}}>All Time</option>
                                    <option value="2" {{$time == 2 ? 'selected' : ''}}>Today</option>
                                    <option value="3" {{$time == 3 ? 'selected' : ''}}>Last 7 Days</option>
                                    <option value="4" {{$time == 4 ? 'selected' : ''}}>Last 30 Days</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-lg-9 to-animate">
                            <small class="pull-right">
                                @if(count($invitations) > 1)
                                    Showing all <strong>{{count($invitations)}}</strong> quiz invitations
                                @elseif(count($invitations) == 1)
                                    Showing a quiz invitation
                                @else
                                    <em>There seems to be none of the quiz invitation was found&hellip;</em>
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($invitations as $row)
                                @php
                                    $vacancy = \App\Vacancies::find($row->vacancy_id);
                                    $quiz = \App\QuizInfo::where('vacancy_id',$vacancy->id)->first();
                                    $agency = \App\Agencies::find($vacancy->agency_id);
                                    $userAgency = \App\User::find($agency->user_id);
                                    $city = \App\Cities::find($vacancy->cities_id)->name;
                                    $salary = \App\Salaries::find($vacancy->salary_id);
                                    $jobfunc = \App\FungsiKerja::find($vacancy->fungsikerja_id);
                                    $joblevel = \App\JobLevel::find($vacancy->joblevel_id);
                                    $industry = \App\Industri::find($vacancy->industry_id);
                                    $degrees = \App\Tingkatpend::find($vacancy->tingkatpend_id);
                                    $majors = \App\Jurusanpend::find($vacancy->jurusanpend_id);
                                    $applicants = \App\Accepting::where('vacancy_id', $vacancy->id)
                                    ->where('isApply', true)->count();
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
                                                <div class="anim-icon anim-icon-md quiz ld ld-breath"
                                                     onclick="showQuiz('{{$row->id}}','{{$quiz->unique_code}}')"
                                                     data-toggle="tooltip"
                                                     title="Start Quiz" data-placement="bottom" style="font-size: 25px">
                                                    <input id="quiz{{$row->id}}" type="checkbox" checked>
                                                    <label for="quiz{{$row->id}}"></label>
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
                                                        <i class="fa fa-paper-plane">
                                                        </i>&ensp;
                                                        <strong>{{$applicants}}</strong>
                                                        applicants
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
    <div style="font-family: 'PT Sans', Arial, serif" class="modal fade login" id="quizModal">
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
                                Before proceeding to the quiz with this following details, you have to click the "Start
                                Quiz" button below.</p>
                            <hr class="hr-divider">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="media">
                                        <div class="media-left media-middle">
                                            @if($userAgency->ava == ""||$userAgency->ava == "agency.png")
                                                <img width="100" class="media-object"
                                                     src="{{asset('images/agency.png')}}">
                                            @else
                                                <img width="100" class="media-object"
                                                     src="{{asset('storage/users/'.$userAgency->ava)}}">
                                            @endif
                                        </div>
                                        <div class="media-body">
                                            <small class="media-heading" style="font-size: 17px;">
                                                <a href="{{route('detail.vacancy',['id'=>$vacancy->id])}}"
                                                   style="color: #00ADB5">
                                                    {{$vacancy->judul}}</a>
                                                <sub style="color: #fa5555;text-transform: none">&ndash; {{$userAgency->name}}</sub>
                                            </small>
                                            <blockquote style="font-size: 16px;color: #7f7f7f">
                                                <ul class="list-inline">
                                                    <li>
                                                        <a class="tag">
                                                            <i class="fa fa-grin-beam"></i>&ensp;
                                                            Quiz Date: {{$vacancy->quizDate_start &&
                                                            $vacancy->quizDate_end != "" ? \Carbon\Carbon::parse
                                                            ($vacancy->quizDate_start)->format('j F Y')." - ".
                                                            \Carbon\Carbon::parse($vacancy->quizDate_end)
                                                            ->format('j F Y') : '-'}}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="tag">
                                                            <i class="fa fa-shield-alt"></i>&ensp;
                                                            Quiz Code: #{{$quiz->unique_code}}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="tag">
                                                            <i class="fa fa-question-circle"></i>&ensp;
                                                            Total Question: {{$quiz->total_question}} items
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="tag">
                                                            <i class="fa fa-stopwatch"></i>&ensp;
                                                            Time Limit: {{$quiz->time_limit}} minutes
                                                        </a>
                                                    </li>
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
                    <div class="card-read-more" id="btn-apply">
                        <form method="post" action="{{route('show.quiz')}}" id="form-access-quiz">
                            {{csrf_field()}}
                            <input type="hidden" name="quiz_code" id="quiz_code">
                            <button class="btn btn-link btn-block" type="submit">
                                <i class="fa fa-grin-beam"></i>&ensp;Start Quiz
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
        $("#form-time select").on('change', function () {
            $("#form-time")[0].submit();
        });

        function showQuiz(id, code) {
            $("#quiz_code").val(code);
            $("#quizModal").modal('show');

            $(document).on('hide.bs.modal', '#quizModal', function (event) {
                $("#quiz" + id).prop('checked', true);
            });
        }
    </script>
@endpush