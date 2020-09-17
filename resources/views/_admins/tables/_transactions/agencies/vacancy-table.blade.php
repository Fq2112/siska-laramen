@extends('layouts.mst_admin')
@section('title', 'Job Vacancies Table &ndash; '.env('APP_NAME').' Admins | '.env('APP_NAME'))
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Job Vacancies
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
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($vacancies as $vacancy)
                                @php
                                    if($vacancy->plan_id != null){
                                        $plan = \App\Plan::find($vacancy->plan_id);
                                    }
                                    $agency = \App\Agencies::find($vacancy->agency_id);
                                    $user = \App\User::find($agency->user_id);
                                    $city = \App\Cities::find($vacancy->cities_id)->name;
                                    $salary = \App\Salaries::find($vacancy->salary_id);
                                    $jobfunc = \App\FungsiKerja::find($vacancy->fungsikerja_id);
                                    $joblevel = \App\JobLevel::find($vacancy->joblevel_id);
                                    $jobtype = \App\JobType::find($vacancy->jobtype_id);
                                    $industry = \App\Industri::find($vacancy->industry_id);
                                    $degrees = \App\Tingkatpend::find($vacancy->tingkatpend_id);
                                    $majors = \App\Jurusanpend::find($vacancy->jurusanpend_id);
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
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

                                                                @if($vacancy->plan_id != null && $plan->isQuiz == true)
                                                                    <span data-toggle="tooltip" data-placement="bottom"
                                                                          title="Online Quiz (TPA & TKD) Date"
                                                                          class="label label-warning">
                                                                        <strong><i class="fa fa-grin-beam"></i>&ensp;
                                                                            {{$vacancy->quizDate_start != "" &&
                                                                            $vacancy->quizDate_end != "" ?
                                                                            \Carbon\Carbon::parse
                                                                            ($vacancy->quizDate_start)->format('j F Y')
                                                                            .' - '.\Carbon\Carbon::parse
                                                                            ($vacancy->quizDate_end)->format('j F Y') :
                                                                            'Unknown'}}
                                                                        </strong>
                                                                    </span>&nbsp;|
                                                                @endif
                                                                @if($vacancy->plan_id != null && $plan->isPsychoTest == true)
                                                                    <span data-toggle="tooltip" data-placement="bottom"
                                                                          title="Psycho Test (Online Interview) Date"
                                                                          class="label label-danger">
                                                                        <strong><i class="fa fa-comments"></i>&ensp;
                                                                            {{$vacancy->psychoTestDate_start &&
                                                                            $vacancy->psychoTestDate_end != "" ?
                                                                            \Carbon\Carbon::parse
                                                                            ($vacancy->psychoTestDate_start)
                                                                            ->format('j F Y')." - ".
                                                                            \Carbon\Carbon::parse
                                                                            ($vacancy->psychoTestDate_end)
                                                                            ->format('j F Y') : 'Unknown'}}
                                                                        </strong>
                                                                    </span>&nbsp;|
                                                                @endif
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
                                                            title="Job Type">
                                                            <td><i class="fa fa-user-clock"></i>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>{{$jobtype->name}}</td>
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
                                                        @if($vacancy->plan_id != null && $plan->isQuiz == true)
                                                            <tr data-toggle="tooltip" data-placement="left"
                                                                title="Quiz Passing Grade & Participant">
                                                                <td><i class="fa fa-grin-beam"></i></td>
                                                                <td>&nbsp;</td>
                                                                <td><strong>{{$vacancy->passing_grade." / ".
                                                                $vacancy->quiz_applicant}}</strong> persons
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if($vacancy->plan_id != null && $plan->isPsychoTest == true)
                                                            <tr data-toggle="tooltip" data-placement="left"
                                                                title="Psycho Test Participant">
                                                                <td><i class="fa fa-comments"></i></td>
                                                                <td>&nbsp;</td>
                                                                <td><strong>{{$vacancy->psychoTest_applicant}}</strong>
                                                                    persons
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <hr style="margin: .5em auto">
                                        <strong>Requirements</strong><br>{!! $vacancy->syarat !!}
                                        <hr style="margin: .5em auto">
                                        <strong>Responsibilities</strong><br>{!! $vacancy->tanggungjawab !!}
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <a href="{{route('detail.vacancy',['id' => $vacancy->id])}}" target="_blank"
                                           class="btn btn-info btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Details"><i class="fa fa-info-circle"></i></a>
                                        <hr style="margin: 5px auto">
                                        <a href="{{route('delete.vacancies',['id'=>encrypt($vacancy->id)])}}"
                                           class="btn btn-danger btn-sm delete-data" style="font-size: 16px"
                                           data-toggle="tooltip"
                                           title="Delete" data-placement="bottom"><i class="fa fa-trash-alt"></i></a>
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
@endsection