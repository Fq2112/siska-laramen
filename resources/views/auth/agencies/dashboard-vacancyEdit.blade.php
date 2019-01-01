@section('title', ''.$user->name.'\'s Profile | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <style>
        .card-title a {
            color: #7f7f7f;
        }

        .media-object {
            cursor: pointer;
            opacity: .4;
            -webkit-transition: all .2s ease-in;
            -moz-transition: all .2s ease-in;
            transition: all .2s ease-in;
        }

        .media-object:hover {
            opacity: 1;
        }

        #formModal .login .box .form input[type="text"], .login .box .form input[type="email"], .login .box .form input[type="password"] {
            border: 1px solid #ccc;
            border-radius: 0 4px 4px 0;
            margin-bottom: 0;
        }
    </style>
@endpush
@extends('layouts.auth.mst_agency')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 to-animate">
                            <div class="card">
                                <form action="{{route('agency.vacancy.create')}}" method="post" id="form-vacancy">
                                    {{csrf_field()}}
                                    <input type="hidden" name="_method">
                                    <input type="hidden" name="check_form" value="vacancy">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small id="show_vacancy_settings">
                                                Vacancy Setup
                                                <span class="pull-right" style="cursor: pointer; color: #00ADB5">
                                                <i class="fa fa-briefcase"></i>&ensp;Add
                                                </span>
                                            </small>
                                            <hr class="hr-divider">
                                            <div id="stats_vacancy">
                                                @if(count($vacancies) != 0)
                                                    <div data-scrollbar style="max-height: 700px">
                                                        @foreach($vacancies as $row)
                                                            @php
                                                                if($row->plan_id != null){
                                                                    $plan = \App\Plan::find($row->plan_id);
                                                                }
                                                                $city = \App\Cities::find($row->cities_id)->name;
                                                                $salary = \App\Salaries::find($row->salary_id);
                                                                $jobfunc = \App\FungsiKerja::find($row->fungsikerja_id);
                                                                $joblevel = \App\JobLevel::find($row->joblevel_id);
                                                                $industry = \App\Industri::find($row->industry_id);
                                                                $degrees = \App\Tingkatpend::find($row->tingkatpend_id);
                                                                $majors = \App\Jurusanpend::find($row->jurusanpend_id);
                                                                $applicants = \App\Accepting::where('vacancy_id', $row->id)
                                                                ->where('isApply', true)->count();
                                                            @endphp
                                                            <div class="row" style="border: {{$row->isPost == true &&
                                                        $row->active_period != "" && $row->plan_id != "" &&
                                                        ($row->recruitmentDate_start == "" ||
                                                        $row->recruitmentDate_end == "" || $row->interview_date == "")
                                                        ? '2px solid #00ADB5' : 'none'}};">
                                                                <div class="col-lg-12">
                                                                    <div class="media">
                                                                        <div class="media-left media-middle">
                                                                            <img class="media-object" width="128"
                                                                                 src="{{asset('images/edit_date.png')}}"
                                                                                 data-toggle="tooltip" title="Edit Schedule"
                                                                                 data-placement="bottom"
                                                                                 onclick="editVacancySchedule('{{$row->id}}',
                                                                                         '{{$row->judul}}','{{$row->plan_id}}',
                                                                                         '{{$row->isPost}}',
                                                                                         '{{$row->active_period}}',
                                                                                         '{{$row->interview_date}}',
                                                                                         '{{$row->recruitmentDate_start}}',
                                                                                         '{{$row->recruitmentDate_end}}',
                                                                                         '{{$row->quizDate_start}}',
                                                                                         '{{$row->quizDate_end}}',
                                                                                         '{{$row->psychoTestDate_start}}',
                                                                                         '{{$row->psychoTestDate_end}}')">
                                                                        </div>
                                                                        <div class="media-body">
                                                                            <small class="media-heading">
                                                                                <a href="{{route('detail.vacancy',
                                                                            ['id'=>$row->id])}}" style="color: #00ADB5">
                                                                                    {{$row->judul}}</a>
                                                                                <sub style="color: #fa5555;text-transform: none">&ndash; {{$row->updated_at
                                                                            ->diffForHumans()}}</sub>
                                                                                <span class="pull-right">
                                                                            <a style="color: #00ADB5;cursor: pointer;"
                                                                               onclick="editVacancy('{{$row->id}}')">
                                                                                Edit&ensp;<i class="fa fa-edit"></i></a>
                                                                            <small style="color: #7f7f7f">&nbsp;&#124;&nbsp;</small>
                                                                            <a href="{{route('agency.vacancy.delete',
                                                                            ['id' => encrypt($row->id),
                                                                            'judul' => $row->judul])}}"
                                                                               class="delete-vacancy"
                                                                               style="color: #FA5555;">
                                                                                <i class="fa fa-eraser"></i>&ensp;Delete</a>
                                                                        </span>
                                                                            </small>
                                                                            <blockquote
                                                                                    style="font-size: 12px; color: #7f7f7f; border-left: 5px solid {{$row->isPost == true &&
                                                        $row->active_period != "" && $row->plan_id != "" &&
                                                        ($row->recruitmentDate_start == "" ||
                                                        $row->recruitmentDate_end == "" || $row->interview_date == "")
                                                        ? '#00ADB5' : '#eee'}};" class="ulTinyMCE">
                                                                                <ul class="list-inline">
                                                                                    <li>
                                                                                        <a class="tag" target="_blank"
                                                                                           href="{{route('search.vacancy',
                                                                                   ['loc' => substr($city, 0, 2)=="Ko"
                                                                                   ? substr($city,5)
                                                                                   : substr($city,10)])}}">
                                                                                            <i class="fa fa-map-marked"></i>&ensp;
                                                                                            {{substr($city, 0, 2)=="Ko" ?
                                                                                            substr($city,5) :
                                                                                            substr($city,10)}}
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a class="tag" target="_blank"
                                                                                           href="{{route('search.vacancy',
                                                                                   ['jobfunc_ids' =>
                                                                                   $row->fungsikerja_id])}}">
                                                                                            <i class="fa fa-warehouse"></i>&ensp;
                                                                                            {{$jobfunc->nama}}
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a class="tag" target="_blank"
                                                                                           href="{{route('search.vacancy',
                                                                                   ['industry_ids' =>
                                                                                   $row->industry_id])}}">
                                                                                            <i class="fa fa-industry"></i>&ensp;
                                                                                            {{$industry->nama}}
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a class="tag" target="_blank"
                                                                                           href="{{route('search.vacancy',
                                                                                   ['salary_ids' => $salary->id])}}">
                                                                                            <i class="fa fa-money-bill-wave"></i>
                                                                                            &ensp;IDR {{$salary->name}}</a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a class="tag" target="_blank"
                                                                                           href="{{route('search.vacancy',
                                                                                   ['degrees_ids' =>
                                                                                   $row->tingkatpend_id])}}">
                                                                                            <i class="fa fa-graduation-cap"></i>
                                                                                            &ensp;{{$degrees->name}}</a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a class="tag" target="_blank"
                                                                                           href="{{route('search.vacancy',
                                                                                   ['majors_ids' =>
                                                                                   $row->jurusanpend_id])}}">
                                                                                            <i class="fa fa-user-graduate"></i>
                                                                                            &ensp;{{$majors->name}}</a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a class="tag">
                                                                                            <i class="fa fa-briefcase"></i>
                                                                                            &ensp;At least
                                                                                            {{$row->pengalaman > 1 ?
                                                                                            $row->pengalaman.' years' :
                                                                                            $row->pengalaman.' year'}}
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
                                                                                    @if($row->plan_id != "")
                                                                                        <li>
                                                                                            <a class="tag tag-plans">
                                                                                                <i class="fa fa-thumbtack">
                                                                                                </i>&ensp;Plan:
                                                                                                {{$plan->name}} Package
                                                                                            </a>
                                                                                        </li>
                                                                                        @if($plan->isQuiz == true)
                                                                                            <li>
                                                                                                <a class="tag tag-plans">
                                                                                                    <i class="fa fa-grin-beam">
                                                                                                    </i>&ensp;Quiz with
                                                                                                    {{$row->passing_grade}}
                                                                                                    passing grade &ndash;
                                                                                                    for &ndash;
                                                                                                    {{$row->quiz_applicant}}
                                                                                                    applicants
                                                                                                </a>
                                                                                            </li>
                                                                                        @endif
                                                                                        @if($plan->isPsychoTest == true)
                                                                                            <li>
                                                                                                <a class="tag tag-plans">
                                                                                                    <i class="fa fa-comments">
                                                                                                    </i>&ensp;Psycho Test
                                                                                                    for
                                                                                                    {{$row
                                                                                                    ->psychoTest_applicant}}
                                                                                                    applicants
                                                                                                </a>
                                                                                            </li>
                                                                                        @endif
                                                                                    @endif
                                                                                </ul>
                                                                                <small>Requirements</small>
                                                                                {!! $row->syarat !!}
                                                                                <small>Responsibilities</small>
                                                                                {!! $row->tanggungjawab !!}
                                                                                <hr class="hr-divider">
                                                                                <table class="stats"
                                                                                       style="font-size: 12px;margin-top: -.5em">
                                                                                    <tr>
                                                                                        <td>
                                                                                            <i class="fa fa-calendar-check"></i>
                                                                                        </td>
                                                                                        <td>&nbsp;Active Period</td>
                                                                                        <td>:
                                                                                            {{$row->active_period != "" ?
                                                                                            "until ".\Carbon\Carbon::parse
                                                                                            ($row->active_period)
                                                                                            ->format('j F Y') : '-'}}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><i class="fa fa-users"></i></td>
                                                                                        <td>&nbsp;Recruitment Date</td>
                                                                                        <td>: {{$row->recruitmentDate_start
                                                                                        && $row->recruitmentDate_end !=
                                                                                        "" ? \Carbon\Carbon::parse
                                                                                        ($row->recruitmentDate_start)
                                                                                        ->format('j F Y')." - ".
                                                                                        \Carbon\Carbon::parse
                                                                                        ($row->recruitmentDate_end)
                                                                                        ->format('j F Y') : '-'}}
                                                                                        </td>
                                                                                    </tr>
                                                                                    @if($row->plan_id != "" &&
                                                                                    $row->plan_id == 2)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <i class="fa fa-grin-beam">
                                                                                                </i>
                                                                                            </td>
                                                                                            <td>&nbsp;Online Quiz
                                                                                                (TPA & TKD) Date
                                                                                            </td>
                                                                                            <td>: {{$row->quizDate_start &&
                                                                                        $row->quizDate_end != "" ?
                                                                                        \Carbon\Carbon::parse
                                                                                        ($row->quizDate_start)
                                                                                        ->format('j F Y')." - ".
                                                                                        \Carbon\Carbon::parse
                                                                                        ($row->quizDate_end)
                                                                                        ->format('j F Y') : '-'}}
                                                                                            </td>
                                                                                        </tr>
                                                                                    @elseif($row->plan_id != "" &&
                                                                                    $row->plan_id == 3)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <i class="fa fa-grin-beam">
                                                                                                </i>
                                                                                            </td>
                                                                                            <td>&nbsp;Online Quiz
                                                                                                (TPA & TKD) Date
                                                                                            </td>
                                                                                            <td>: {{$row->quizDate_start &&
                                                                                        $row->quizDate_end != "" ?
                                                                                        \Carbon\Carbon::parse
                                                                                        ($row->quizDate_start)
                                                                                        ->format('j F Y')." - ".
                                                                                        \Carbon\Carbon::parse
                                                                                        ($row->quizDate_end)
                                                                                        ->format('j F Y') : '-'}}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <i class="fa fa-comments">
                                                                                                </i>
                                                                                            </td>
                                                                                            <td>&nbsp;Psycho Test
                                                                                                (Online Interview) Date
                                                                                            </td>
                                                                                            <td>:
                                                                                                {{$row->psychoTestDate_start
                                                                                                && $row->psychoTestDate_end
                                                                                                != "" ? \Carbon\Carbon::parse
                                                                                                ($row->psychoTestDate_start)
                                                                                                ->format('j F Y')." - ".
                                                                                                \Carbon\Carbon::parse
                                                                                                ($row->psychoTestDate_end)
                                                                                                ->format('j F Y') : '-'}}
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
                                                                                    <tr>
                                                                                        <td><i class="fa fa-user-tie"></i>
                                                                                        </td>
                                                                                        <td>&nbsp;Job Interview Date</td>
                                                                                        <td>:
                                                                                            {{$row->interview_date != "" ?
                                                                                            \Carbon\Carbon::parse
                                                                                            ($row->interview_date)
                                                                                            ->format('l, j F Y') : '-'}}
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </blockquote>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr class="hr-divider">
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p align="justify">
                                                        There seems to be none of the vacancy was found&hellip;</p>
                                                @endif
                                            </div>

                                            <div id="vacancy_settings" style="display: none">
                                                <div class="row form-group">
                                                    <div class="col-lg-8">
                                                        <small>Vacancy Name</small>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-building"></i>
                                                            </span>
                                                            <input class="form-control" type="text"
                                                                   placeholder="ex: Programmer"
                                                                   name="judul" id="judul"
                                                                   maxlength="200" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <small>Work Experience</small>
                                                        <div class="input-group" style="text-transform: none">
                                                            <span class="input-group-addon">
                                                                At least</span>
                                                            <input class="form-control" type="text"
                                                                   onkeypress="return numberOnly(event, false)"
                                                                   maxlength="3" placeholder="0"
                                                                   id="pengalaman" name="pengalaman" required>
                                                            <span class="input-group-addon">
                                                                year(s)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Job Function</small>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-warehouse"></i>
                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --" id="job_funct"
                                                                    data-live-search="true" data-container="body"
                                                                    name="fungsikerja_id" required>
                                                                @foreach($job_functions as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->nama}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>Industry</small>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-industry"></i>
                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --" id="industry"
                                                                    data-live-search="true" data-container="body"
                                                                    name="industri_id" required>
                                                                @foreach($industries as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->nama}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Job Level</small>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-level-up-alt"></i>
                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --" id="job_level"
                                                                    data-live-search="true" data-container="body"
                                                                    name="joblevel_id" required>
                                                                @foreach($job_levels as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>Job Type</small>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user-clock"></i>
                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --" data-container="body"
                                                                    id="job_type" name="jobtype_id" required>
                                                                @foreach($job_types as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Location</small>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-map-marked"></i>
                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --" id="city_id"
                                                                    data-live-search="true" data-container="body"
                                                                    name="cities_id" required>
                                                                @foreach($provinces as $province)
                                                                    <optgroup label="{{$province->name}}">
                                                                        @foreach($province->cities as $city)
                                                                            @if(substr($city->name, 0, 2)=="Ko")
                                                                                <option value="{{$city->id}}">
                                                                                    {{substr($city->name,4)}}
                                                                                </option>
                                                                            @else
                                                                                <option value="{{$city->id}}">
                                                                                    {{substr($city->name,9)}}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>Salary</small>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <strong>Rp</strong></span>
                                                            <select class="form-control selectpicker"
                                                                    id="salary_id" data-live-search="true"
                                                                    name="salary_id" data-container="body" required>
                                                                <option value="" selected>-- Choose --</option>
                                                                @foreach($salaries as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <small>Education Degree</small>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-graduation-cap"></i>
                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --" id="tingkatpend"
                                                                    data-live-search="true" data-container="body"
                                                                    name="tingkatpend_id" required>
                                                                @foreach(\App\Tingkatpend::all() as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>Education Major</small>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user-graduate"></i>
                                                            </span>
                                                            <select class="form-control selectpicker"
                                                                    title="-- Choose --" id="jurusanpend"
                                                                    data-live-search="true" data-container="body"
                                                                    name="jurusanpend_id" required>
                                                                @foreach(\App\Jurusanpend::all() as $row)
                                                                    <option value="{{$row->id}}">
                                                                        {{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <small>Requirements</small>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <textarea class="use-tinymce" name="syarat"
                                                                  placeholder="Job's requirements"
                                                                  id="syarat"></textarea>
                                                    </div>
                                                </div>

                                                <small>Responsibilities</small>
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <textarea class="use-tinymce" name="tanggungjawab"
                                                                  placeholder="Job's responsibilities"
                                                                  id="tanggungjawab"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row form-group" id="btn_cancel_vacancy">
                                                    <div class="col-lg-12">
                                                        <input type="reset" value="CANCEL" class="btn btn-default">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button class="btn btn-link btn-block" data-placement="top" type="button"
                                                data-toggle="tooltip" title="Click here to submit your changes!"
                                                id="btn_save_vacancy" disabled>
                                            <i class="fa fa-briefcase"></i>&nbsp;SAVE CHANGES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal to-animate login" id="formModal" style="font-family: 'PT Sans', Arial, serif">
        <div class="modal-dialog login animated">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="vacancy_title"></h4>
                </div>
                <div id="schedule_settings"></div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    @include('layouts.partials.auth.Agencies._scripts_auth-agency')
    @include('layouts.partials.auth.Agencies._scripts_ajax-agency')
@endpush
