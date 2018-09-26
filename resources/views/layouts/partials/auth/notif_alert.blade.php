@auth
    @if(Auth::user()->isAgency())
        @php
            $agency = \App\Agencies::where('user_id',Auth::user()->id)->firstOrFail();
            $vacancies = \App\Vacancies::where('agency_id',$agency->id)->where('isPost',true)->whereNotNull('active_period')
            ->whereNull('interview_date')->whereNull('recruitmentDate_start')->whereNull('recruitmentDate_end');
        @endphp
        @if($vacancies->count() && !Illuminate\Support\Facades\Request::is('account/agency/vacancy'))
            <div class="alert-banner">
                <div class="alert-banner-content">
                    <div class="alert-banner-text">
                        There seems to be <strong>{{$vacancies->count()}}</strong> of your vacancy schedules
                        {{$vacancies->count() > 1 ? 'haven\'t' : 'hasn\'t'}} been set yet!
                    </div>
                    <a class="alert-banner-button" href="{{route('agency.vacancy.show')}}"
                       style="text-decoration: none">
                        Redirect me to the Vacancy Setup page</a>
                </div>
                <div class="alert-banner-close"></div>
            </div>
        @endif
    @endif
@endauth