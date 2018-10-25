@extends('layouts.mst_admin')
@section('title', 'Job Invitations Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Job Invitations
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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($invitations as $invitation)
                                @php
                                    $seeker = \App\Seekers::find($invitation->seeker_id);
                                    $userSeeker = \App\User::find($seeker->user_id);
                                    $last_edu = \App\Education::where('seeker_id', $seeker->id)
                                    ->wherenotnull('end_period')->orderby('tingkatpend_id', 'desc')->take(1)->get();
                                    $vacancy = \App\Vacancies::find($invitation->vacancy_id);
                                    $agency = \App\Agencies::find($vacancy->agency_id);
                                    $userAgency = \App\User::find($agency->user_id);
                                    $city = \App\Cities::find($vacancy->cities_id)->name;
                                    $degrees = \App\Tingkatpend::find($vacancy->tingkatpend_id);
                                    $majors = \App\Jurusanpend::find($vacancy->jurusanpend_id);
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <table style="margin: 0">
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
                                                                @endif&nbsp;|
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
                                                                            \App\Tingkatpend::find($last_edu->first()
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
                                        <table style="margin: 0">
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
                                                    <table style="margin: 0">
                                                        <tr>
                                                            <td><strong>{{$vacancy->judul}}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="{{route('agency.profile',['id' => $agency->id])}}"
                                                                   target="_blank">
                                                                    {{$userAgency->name}}</a>&nbsp;&ndash;
                                                                {{substr($city, 0, 2) == "Ko" ? substr($city,5) :
                                                                substr($city,10)}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <strong data-toggle="tooltip" data-placement="left"
                                                                        title="Recruitment Date">
                                                                    {{$vacancy->recruitmentDate_start != "" &&
                                                                    $vacancy->recruitmentDate_end != "" ?
                                                                    \Carbon\Carbon::parse
                                                                    ($vacancy->recruitmentDate_start)
                                                                    ->format('j F Y').' - '.\Carbon\Carbon::parse
                                                                    ($vacancy->recruitmentDate_end)
                                                                    ->format('j F Y') : '(empty)'}}
                                                                </strong> |
                                                                <strong data-toggle="tooltip" data-placement="right"
                                                                        title="Interview Date">
                                                                    {{$vacancy->interview_date != "" ?
                                                                    \Carbon\Carbon::parse($vacancy->interview_date)
                                                                    ->format('l, j F Y') : '(empty)'}}
                                                                </strong>
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
                                    </td>
                                    <td style="vertical-align: middle;" align="center">
                                        @if($invitation->isApply == true)
                                            <span class="label label-default" style="background: #00adb5">INVITED</span>
                                            &ndash;&nbsp;on&nbsp;&ndash;
                                            <span class="label label-info">
                                                {{\Carbon\Carbon::parse($invitation->created_at)->format('j F Y')}}
                                            </span>
                                        @else
                                            <span class="label label-default"
                                                  style="background: #fa5555">NOT APPLY</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success btn-sm"
                                                    style="font-weight: 600">
                                                INVITE
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="{{route('table.invitations.delete',['id'=> encrypt
                                                    ($invitation->id)])}}" class="delete-application">
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
@endsection
@push("scripts")
    <script>
        $(".delete-application").on("click", function () {
            var linkURL = $(this).attr("href");
            swal({
                title: 'Delete Application',
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