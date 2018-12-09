@section('title', ''.$user->name.'\'s Dashboard &ndash; Bookmarked Vacancy | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_seeker')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Bookmarked Vacancy</h4>
                            <small>Here is your bookmarked vacancies.</small>
                            <hr>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: .5em">
                        <div class="col-lg-12 to-animate">
                            <small>
                                @if(count($bookmark) > 1)
                                    Showing <strong>{{count($bookmark)}}</strong> bookmarked vacancies
                                @elseif(count($bookmark) == 1)
                                    Showing a bookmarked vacancy
                                @else
                                    <em>There seems to be none of the bookmarked vacancy was found&hellip;</em>
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($bookmark as $row)
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
                                        </small>
                                        <blockquote style="font-size: 12px;color: #7f7f7f">
                                            <form class="pull-right to-animate-2" id="form-bookmark-{{$vacancy->id}}"
                                                  method="post" action="{{route('bookmark.vacancy')}}">
                                                {{csrf_field()}}
                                                <div class="anim-icon anim-icon-md bookmark"
                                                     onclick="removeBookmark('{{$vacancy->id}}','{{$vacancy->judul}}')"
                                                     data-toggle="tooltip" data-placement="bottom"
                                                     title="Unmark" style="font-size: 25px">
                                                    <input type="hidden" name="vacancy_id" value="{{$vacancy->id}}">
                                                    <input id="bookmark{{$vacancy->id}}" type="checkbox" checked>
                                                    <label for="bookmark{{$vacancy->id}}"></label>
                                                </div>
                                            </form>
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
                                                    <td><i class="fa fa-clock"></i></td>
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
                    <div class="row">
                        <div class="col-lg-12 to-animate-2 myPagination">
                            {{$bookmark->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function removeBookmark(id, title) {
            swal({
                title: 'Are you sure to unmark ' + title + '?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, unmark it!',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
            }).then(function () {
                $("#bookmark" + id).prop('checked', false);
                $("#form-bookmark-" + id)[0].submit();
            }, function (dismiss) {
                if (dismiss == 'cancel') {
                    $("#bookmark" + id).prop('checked', true);
                }
            });
        }
    </script>
@endpush