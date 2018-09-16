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
                            <small class="pull-right">
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
                                                <div class="anim-icon anim-icon-md bookmark ld ld-breath"
                                                     id="{{$vacancy->id}}" onclick="removeBookmark(id)"
                                                     data-toggle="tooltip" title="Unmark" style="font-size: 25px">
                                                    <input type="hidden" name="vacancy_id" value="{{$vacancy->id}}">
                                                    <input type="checkbox" checked>
                                                    <label for="bookmark"></label>
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
                                                        &ensp;{{$vacancy->pengalaman}}
                                                    </a>
                                                </li>
                                            </ul>
                                            <small>Posted on
                                                {{Carbon\Carbon::parse($vacancy->created_at)
                                                ->format('j F Y')}}</small>
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
        function removeBookmark(id) {
            $("#" + id + ' input[type=checkbox]').prop('checked', false);
            $("#form-bookmark-" + id)[0].submit();
        }
    </script>
@endpush