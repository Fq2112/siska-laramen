@section('title', ''.$user->name.'\'s Dashboard &ndash; Invitation to Apply | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_seeker')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Invitation to Apply</h4>
                            <small>Here is your invitation to apply (job offers) from agencies.</small>
                            <hr>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: .5em">
                        <div class="col-lg-12 to-animate">
                            <small class="pull-right">
                            </small>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: .5em">
                        <div class="col-lg-12 to-animate">
                            <small class="pull-right">
                                @if(count($invToApply) > 1)
                                    Showing <strong>{{count($invToApply)}}</strong> invitation to apply
                                @elseif(count($invToApply) == 1)
                                    Showing an invitation to apply
                                @else
                                    <em>There seems to be none of the invitation was found from any agency&hellip;</em>
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($invToApply as $row)
                                @php
                                    $agency = \App\Agencies::find($row->agency_id);
                                    $userAgency = \App\User::find($agency->user_id);
                                    $vacancy = \App\Vacancies::find($row->vacancy_id);
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
                                               href="{{route('agency.profile',['id'=>$agency->id])}}">
                                                {{$userAgency->name}}</a>
                                            <sub>&ndash;
                                                <a href="{{route('detail.vacancy',['id'=>$vacancy->id])}}">
                                                    {{$vacancy->judul}}</a></sub>
                                            <span class="pull-right" style="color: #fa5555">
                                                Invited on {{Carbon\Carbon::parse($row->created_at)->format('j F Y')}}
                                            </span>
                                        </small>
                                        <blockquote style="color: #7f7f7f">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <div class="pull-right to-animate-2">
                                                                <div class="anim-icon anim-icon-md apply ld ld-breath"
                                                                     onclick="showapplyInvModal('{{$vacancy->id}}',
                                                                             '{{$vacancy->judul}}')"
                                                                     data-toggle="tooltip" title="Apply"
                                                                     data-placement="bottom" style="font-size: 25px">
                                                                    <input type="checkbox" checked>
                                                                    <label for="apply"></label>
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
                                                                        $vacancy->pengalaman.' years' :
                                                                        $vacancy->pengalaman.' year'}}
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </blockquote>
                                    </div>
                                </div>
                                <hr class="hr-divider">
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 to-animate-2 myPagination">
                            {{$invToApply->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal to-animate login" id="applyInvModal" style="font-family: 'PT Sans', Arial, serif">
        <div class="modal-dialog login animated" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Hi {{Auth::user()->name}},</h4>
                </div>
                <div class="modal-body">
                    <div class="box">
                        <div class="content">
                            <p style="font-size: 17px" align="justify">
                                Complete data will make you a lot easier to apply for any jobs and the agency (HRD)
                                is interested with. You will register for this vacancy with the
                                following details:</p>
                            <hr class="hr-divider">
                            <div class="row">
                                <div class="col-lg-12" id="applyInvModalBody"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="card-read-more" id="btn-apply">
                        <form method="post" action="{{route('apply.vacancy')}}" id="form-apply">
                            {{csrf_field()}}
                            <input type="hidden" name="vacancy_id" id="vacancy_id">
                            <button class="btn btn-link btn-block" type="submit">
                                <i class="fa fa-paper-plane"></i>&ensp;Apply
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
        function showapplyInvModal(id, title) {
            var today = new Date().toJSON().slice(0, 10), $pengalaman;
            $.ajax({
                url: "{{ url('account/dashboard/application_status/compare') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    if (today >= data.recruitmentDate_start && today <= data.recruitmentDate_end) {
                        if (data.pengalaman > 1) {
                            $pengalaman = 'At least ' + data.pengalaman + ' years';
                        } else {
                            $pengalaman = 'At least ' + data.pengalaman + ' year';
                        }
                        $('#applyInvModalBody').html(
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
                            '<li><a class="tag"><i class="fa fa-briefcase"></i>&ensp;' + $pengalaman + '</a></li>' +
                            '</ul></blockquote></div></div>'
                        );
                        $("#applyInvModal").modal('show');
                        $("#vacancy_id").val(data.id);

                    } else if (today < data.recruitmentDate_start) {
                        swal({
                            title: 'ATTENTION!',
                            text: 'It seems that the recruitment date of ' + title + ' hasn\'t started yet.',
                            type: 'warning',
                            timer: '7000'
                        });

                    } else if (today > data.recruitmentDate_end) {
                        swal({
                            title: 'ATTENTION!',
                            text: 'It seems that the recruitment date of ' + title + ' has been ended.',
                            type: 'warning',
                            timer: '7000'
                        })
                    }
                },
                error: function () {
                    swal({
                        title: 'Invitation to Apply',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        }
    </script>
@endpush