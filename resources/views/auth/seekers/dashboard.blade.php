@section('title', ''.$user->name.'\'s Dashboard &ndash; Application Status | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_seeker')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Application Status</h4>
                            <small>Here is the current and previous status of your applications.</small>
                            <hr>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: .5em">
                        <div class="col-lg-3 to-animate-2">
                            <form id="form-time" action="{{route('seeker.dashboard')}}">
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
                                @if(count($apply) > 1)
                                    Showing all <strong>{{count($apply)}}</strong> application status
                                @elseif(count($apply) == 1)
                                    Showing an application status
                                @else
                                    <em>There seems to be none of the application status was found&hellip;</em>
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($apply as $row)
                                @php
                                    $vacancy = \App\Vacancies::find($row->vacancy_id);
                                    $agency = \App\Agencies::find($vacancy->agency_id);
                                    $userAgency = \App\User::find($agency->user_id);
                                    $city = \App\Cities::find($vacancy->cities_id)->name;
                                    $salary = \App\Salaries::find($vacancy->salary_id);
                                    $jobfunc = \App\FungsiKerja::find($vacancy->fungsikerja_id);
                                    $joblevel = \App\JobLevel::find($vacancy->joblevel_id);
                                    $industry = \App\Industri::find($vacancy->industry_id);
                                    $degrees = \App\Tingkatpend::find($vacancy->tingkatpend_id);
                                    $majors = \App\Jurusanpend::find($vacancy->jurusanpend_id);
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
                                                <div class="anim-icon anim-icon-md compare ld ld-breath"
                                                     onclick="showCompare('{{$vacancy->id}}')" data-toggle="tooltip"
                                                     title="Compare" data-placement="bottom" style="font-size: 25px">
                                                    <input type="checkbox" checked>
                                                    <label for="compare"></label>
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
                                                        &ensp;{{$vacancy->pengalaman}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="tag">
                                                        <i class="fa fa-calendar-alt"></i>
                                                        &ensp;Interview Schedule: {{$vacancy->interview}}
                                                    </a>
                                                </li>
                                            </ul>
                                            <table style="font-size: 14px;margin-top: -.5em">
                                                <tr>
                                                    <td><i class="fa fa-comments"></i>
                                                    </td>
                                                    <td>&nbsp;Interview Date</td>
                                                    <td>:
                                                        {{$vacancy->interview_date != "" ?
                                                        \Carbon\Carbon::parse
                                                        ($vacancy->interview_date)
                                                        ->format('l, j F Y') : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-users"></i></td>
                                                    <td>&nbsp;Recruitment Date</td>
                                                    <td>:
                                                        {{$vacancy->recruitmentDate_start &&
                                                        $vacancy->recruitmentDate_end != "" ?
                                                        \Carbon\Carbon::parse
                                                        ($vacancy->recruitmentDate_start)
                                                        ->format('j F Y')." - ".
                                                        \Carbon\Carbon::parse
                                                        ($vacancy->recruitmentDate_end)
                                                        ->format('j F Y') : '-'}}
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
                                            @if(today() <= $vacancy->recruitmentDate_end)
                                                <hr style="margin-bottom: 0">
                                                <form class="to-animate" id="form-apply-{{$vacancy->id}}"
                                                      method="post" action="{{route('apply.vacancy')}}">
                                                    {{csrf_field()}}
                                                    <div class="anim-icon anim-icon-md apply ld ld-heartbeat"
                                                         onclick="abortApplication('{{$vacancy->id}}','{{$vacancy->judul}}')"
                                                         data-toggle="tooltip" data-placement="right"
                                                         title="Click here to abort this application!"
                                                         style="font-size: 15px">
                                                        <input type="hidden" name="vacancy_id" value="{{$vacancy->id}}">
                                                        <input type="checkbox" checked>
                                                        <label for="apply"></label>
                                                    </div>
                                                </form>
                                                <small class="to-animate-2">
                                                    P.S.: Job Seekers are only permitted to abort their application
                                                    before the recruitment ends.
                                                </small>
                                            @endif
                                        </blockquote>
                                    </div>
                                </div>
                                <hr class="hr-divider">
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 to-animate-2 myPagination">
                            {{$apply->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal to-animate login" id="compareModal" style="font-family: 'PT Sans', Arial, serif">
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
                                Here's the summary of the applicants' data who apply on this vacancy based on the
                                requirements of education degree and work experience.</p>
                            <hr class="hr-divider">
                            <div class="row">
                                <div class="col-lg-12" id="compare"></div>
                            </div>
                        </div>
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

        function abortApplication(id, title) {
            swal({
                title: 'Are you sure to abort ' + title + '?',
                text: "You won't be able to revert this application!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, abort it!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $("#" + id + ' input[type=checkbox]').prop('checked', false);
                        $("#form-apply-" + id)[0].submit();
                    });
                },
                allowOutsideClick: false
            });
            return false;
        }

        function showCompare(id) {
            $.ajax({
                url: "{{ url('account/dashboard/application_status/compare') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    var $eduEqual = (data.edu_equal / data.total_app) * 100,
                        $eduHigher = (data.edu_higher / data.total_app) * 100,
                        $expEqual = (data.exp_equal / data.total_app) * 100,
                        $expHigher = (data.exp_higher / data.total_app) * 100;
                    $('#compare').html(
                        '<div class="media">' +
                        '<div class="media-left media-middle">' +
                        '<a href="{{route('agency.profile',['id' => ''])}}/' + data.agency_id + '">' +
                        '<img width="100" class="media-object" src="' + data.user.ava + '"></a></div>' +
                        '<div class="media-body">' +
                        '<small class="media-heading">' +
                        '<a style="color: #00ADB5" ' +
                        'href="{{route('detail.vacancy',['id' => ''])}}/' + data.id + '">' + data.judul + '</a>' +
                        ' <sub>– <a href="{{route('agency.profile',['id' => ''])}}/' + data.agency_id + '">'
                        + data.user.name + '</a></sub></small>' +
                        '<blockquote style="font-size: 12px;color: #7f7f7f">' +
                        '<ul class="list-inline">' +
                        '<li><a class="tag" target="_blank" ' +
                        'href="{{route('search.vacancy',['loc'=>''])}}/' + data.city + '">' +
                        '<i class="fa fa-map-marked"></i>&ensp;' + data.city + '</a></li>' +
                        '<li><a class="tag" target="_blank" ' +
                        'href="{{route('search.vacancy',['jobfunc_ids' => ''])}}/' + data.fungsikerja_id + '">' +
                        '<i class="fa fa-warehouse"></i>&ensp;' + data.job_func + '</a></li>' +
                        '<li><a class="tag" target="_blank" ' +
                        'href="{{route('search.vacancy',['industry_ids' => ''])}}/' + data.industry_id + '">' +
                        '<i class="fa fa-industry"></i>&ensp;' + data.industry + '</a></li>' +
                        '<li><a class="tag" target="_blank" ' +
                        'href="{{route('search.vacancy',['salary_ids' => ''])}}/' + data.salary_id + '">' +
                        '<i class="fa fa-money-bill-wave"></i>&ensp;IDR ' + data.salary + '</a></li>' +
                        '<li><a class="tag" target="_blank" ' +
                        'href="{{route('search.vacancy',['degrees_ids' => ''])}}/' + data.tingkatpend_id + '">' +
                        '<i class="fa fa-graduation-cap"></i>&ensp;' + data.degrees + '</a></li>' +
                        '<li><a class="tag" target="_blank" ' +
                        'href="{{route('search.vacancy',['majors_ids' => ''])}}/' + data.jurusanpend_id + '">' +
                        '<i class="fa fa-user-graduate"></i>&ensp;' + data.majors + '</a></li>' +
                        '<li><a class="tag"><i class="fa fa-briefcase"></i>&ensp;' + data.pengalaman + '</a></li>' +
                        '</ul>' +
                        '<hr>' +
                        '<table><tr style="font-size: 14px">' +
                        '<th colspan="3"><i class="fa fa-user-tie"></i> Applicants</th>' +
                        '<th colspan="3"><i class="fa fa-graduation-cap"></i> Education Degree</th>' +
                        '<th colspan="2"><i class="fa fa-briefcase"></i> Work Experience</th></tr>' +
                        '<tr><td class="counter-count" data-toggle="tooltip" ' +
                        'data-placement="bottom" title="Total Applicants">' + data.total_app + '</td>' +
                        '<td>&ensp;&ensp;&ensp;</td>' +
                        '<td>&ensp;&ensp;&ensp;</td>' +
                        '<td><div class="progress-container" data-value="' + $eduEqual + '">' +
                        '<svg class="progress-bar-circle" id="svg-edu-eq" width="120" height="120" ' +
                        'viewPort="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
                        '<circle class="progress-meter" r="36" cx="60" cy="60" stroke-width="15"></circle>' +
                        '<circle class="progress-value" r="36" cx="60" cy="60" stroke-width="15"></circle></svg>' +
                        '<span data-toggle="tooltip" data-placement="bottom" title="Equal Degree"></span></div></td>' +
                        '<td><div class="progress-container" data-value="' + $eduHigher + '">' +
                        '<svg class="progress-bar-circle" id="svg-edu-hi" width="120" height="120" ' +
                        'viewPort="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
                        '<circle class="progress-meter" r="36" cx="60" cy="60" stroke-width="15"></circle>' +
                        '<circle class="progress-value" r="36" cx="60" cy="60" stroke-width="15"></circle></svg>' +
                        '<span data-toggle="tooltip" data-placement="bottom" title="Higher Degree"></span></div></td>' +
                        '<td>&ensp;&ensp;&ensp;</td>' +
                        '<td><div class="progress-container" data-value="' + $expEqual + '">' +
                        '<svg class="progress-bar-circle" id="svg-exp-eq" width="120" height="120" ' +
                        'viewPort="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
                        '<circle class="progress-meter" r="36" cx="60" cy="60" stroke-width="15"></circle>' +
                        '<circle class="progress-value" r="36" cx="60" cy="60" stroke-width="15"></circle></svg>' +
                        '<span data-toggle="tooltip" data-placement="bottom" title="Equal Experience"></span></div></td>' +
                        '<td><div class="progress-container" data-value="' + $expHigher + '">' +
                        '<svg class="progress-bar-circle" id="svg-exp-hi" width="120" height="120" ' +
                        'viewPort="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
                        '<circle class="progress-meter" r="36" cx="60" cy="60" stroke-width="15"></circle>' +
                        '<circle class="progress-value" r="36" cx="60" cy="60" stroke-width="15"></circle></svg>' +
                        '<span data-toggle="tooltip" data-placement="bottom" title="Higher Experience"></span>' +
                        '</div></td></tr></table></blockquote></div></div>'
                    );
                    $("#compareModal").modal('show');
                    $('[data-toggle="tooltip"]').tooltip();
                    $('.counter-count').each(function () {
                        $(this).prop('Counter', 0).animate({
                            Counter: $(this).text()
                        }, {
                            duration: 3000,
                            easing: 'swing',
                            step: function (now) {
                                $(this).text(Math.ceil(now));
                            }
                        });
                    });
                    var progressBars = document.querySelectorAll('.progress-container');

                    for (var el of progressBars) {
                        var dataValue = el.getAttribute("data-value");
                        var progressValue = el.querySelector(".progress-value");
                        var valueContainer = el.querySelector("span");

                        var radius = progressValue.getAttribute("r");

                        var circumference = 2 * Math.PI * radius;

                        progressValue.style.strokeDasharray = circumference;
                        progress(dataValue);
                    }

                    function progress(value) {
                        var progress = value / 100;
                        var dashoffset = circumference * (1 - progress);

                        progressValue.style.strokeDashoffset = dashoffset;

                        animateValue(valueContainer, 0, dataValue, 1500);
                    }

                    function animateValue(selector, start, end, duration) {
                        var obj = selector;
                        var range = end - start;

                        var minTimer = 50;

                        var stepTime = Math.abs(Math.floor(duration / range));
                        stepTime = Math.max(stepTime, minTimer);

                        var startTime = new Date().getTime();
                        var endTime = startTime + duration;
                        var timer;

                        function run() {
                            var now = new Date().getTime();
                            var remaining = Math.max((endTime - now) / duration, 0);
                            var value = Number.parseFloat(end - remaining * range).toFixed(2);
                            obj.innerHTML = value + "%";
                            if (value == end) {
                                clearInterval(timer);
                            }
                        }

                        var timer = setInterval(run, stepTime);
                        run();
                    }
                },
                error: function () {
                    swal({
                        title: 'Compare Application',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        }
    </script>
@endpush