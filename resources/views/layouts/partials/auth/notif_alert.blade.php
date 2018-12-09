@auth
    @if(Auth::user()->isAgency())
        @php
            $agency = \App\Agencies::where('user_id',Auth::user()->id)->firstOrFail();
            $vacancies = \App\Vacancies::where('agency_id',$agency->id)->where('isPost',true)
            ->whereNotNull('active_period')->whereNotNull('plan_id')
            ->whereNull('interview_date')->whereNull('recruitmentDate_start')->whereNull('recruitmentDate_end');
        @endphp
        @if($vacancies->count() && !Illuminate\Support\Facades\Request::is('account/agency/vacancy'))
            <div class="alert-banner">
                <div class="alert-banner-content">
                    <div class="alert-banner-text">
                        There seems to be <strong>{{$vacancies->count()}}</strong> of your vacancy schedules that
                        {{$vacancies->count() > 1 ? ' haven\'t' : ' hasn\'t'}} been set yet!
                    </div>
                    <a class="alert-banner-button" href="{{route('agency.vacancy.show')}}"
                       style="text-decoration: none">
                        Redirect me to the Vacancy Setup page</a>
                </div>
                <div class="alert-banner-close"></div>
            </div>
        @endif
    @elseif(Auth::user()->isSeeker())
        <style>
            .alert-banner {
                background: #fa5555;
            }

            .alert-banner-button {
                color: #fa5555;
                border-bottom: 4px solid #692e2e;
            }

            .alert-banner-button:hover {
                background: #9b3c3c;
            }
        </style>
        @php
            $seeker = \App\Seekers::where('user_id', Auth::user()->id)->firstOrFail();

            $quizInv = \App\Accepting::wherehas('getVacancy', function ($q) {
                $q->wherenotnull('quizDate_start')->wherenotnull('quizDate_end')
                ->where('quizDate_start', '<=', today()->addDay())
                ->where('quizDate_end', '>=', today());
            })->where('seeker_id', $seeker->id)->where('isApply', true)->count();

            $submittedQuizInv = \App\Accepting::wherehas('getVacancy', function ($q) use ($seeker) {
                $q->wherenotnull('quizDate_start')->wherenotnull('quizDate_end')
                ->where('quizDate_start', '<=', today()->addDay())
                ->where('quizDate_end', '>=', today())
                ->whereHas('getQuizInfo', function ($q) use ($seeker){
                    $q->whereHas('getQuizResult', function ($q) use ($seeker){
                        $q->where('seeker_id', $seeker->id);
                    });
                });
            })->where('seeker_id', $seeker->id)->where('isApply', true)->count();

            $totalQuizInv = $quizInv - $submittedQuizInv;

            $findRoom = \App\PsychoTestInfo::whereHas('getVacancy', function ($vac) use ($seeker) {
                $vac->whereHas('getAccepting', function ($acc) use ($seeker) {
                    $acc->where('seeker_id', $seeker->id)->where('isApply', true);
                })->whereHas('getQuizInfo', function ($info) use ($seeker) {
                    $info->whereHas('getQuizResult', function ($res) use ($seeker) {
                        $res->where('seeker_id', $seeker->id)->where('isPassed', true);
                    });
                });
            })->first();

            $candidate = '';
            if ($findRoom != null) {
                foreach ($findRoom->room_codes as $room) {
                    strtok($room, '_');
                    $participantID = strtok('');
                    if ($seeker->id == $participantID) {
                        $candidate = $seeker->id;
                    }
                }
            }

            $psychoTestInv = \App\Accepting::wherehas('getVacancy', function ($vac) use ($candidate) {
                $vac->whereHas('getQuizInfo', function ($info) use ($candidate) {
                    $info->whereHas('getQuizResult', function ($res) use ($candidate) {
                        $res->where('seeker_id', $candidate)->where('isPassed', true);
                    });
                })->wherenotnull('psychoTestDate_start')->wherenotnull('psychoTestDate_end')
                    ->where('psychoTestDate_start', '<=', today()->addDay())
                    ->where('psychoTestDate_end', '>=', today());
            })->where('seeker_id', $candidate)->where('isApply', true)->count();

            $submittedPsychoTestInv = \App\Accepting::wherehas('getVacancy', function ($vac) use ($candidate) {
                $vac->whereHas('getQuizInfo', function ($info) use ($candidate) {
                    $info->whereHas('getQuizResult', function ($res) use ($candidate) {
                        $res->where('seeker_id', $candidate)->where('isPassed', true);
                    });
                })->wherenotnull('psychoTestDate_start')->wherenotnull('psychoTestDate_end')
                ->where('psychoTestDate_start', '<=', today()->addDay())
                ->where('psychoTestDate_end', '>=', today())
                ->whereHas('getPsychoTestInfo', function ($q) use ($candidate){
                    $q->whereHas('getPsychoTestResult', function ($q) use ($candidate){
                        $q->where('seeker_id', $candidate);
                    });
                });
            })->where('seeker_id', $candidate)->where('isApply', true)->count();

            $totalPsychoTestInv = $psychoTestInv - $submittedPsychoTestInv;
        @endphp
        @if($totalQuizInv > 0 && !Illuminate\Support\Facades\Request::is(['quiz','account/dashboard/quiz_invitation']))
            <div class="alert-banner">
                <div class="alert-banner-content">
                    <div class="alert-banner-text">
                        There seems to be <strong>{{$totalQuizInv}}</strong> of the quiz invitation was found!
                    </div>
                    <a class="alert-banner-button" href="{{route('seeker.invitation.quiz')}}"
                       style="text-decoration: none">
                        Redirect me to the Quiz Invitation page</a>
                </div>
                <div class="alert-banner-close"></div>
            </div>
        @endif
        @if($totalPsychoTestInv > 0 && !Illuminate\Support\Facades\Request::is
        (['psychoTest','account/dashboard/psychoTest_invitation']))
            <div class="alert-banner">
                <div class="alert-banner-content">
                    <div class="alert-banner-text">
                        There seems to be <strong>{{$totalPsychoTestInv}}</strong> of the psycho test invitation was
                        found!
                    </div>
                    <a class="alert-banner-button" href="{{route('seeker.invitation.psychoTest')}}"
                       style="text-decoration: none">
                        Redirect me to the Psycho Test Invitation page</a>
                </div>
                <div class="alert-banner-close"></div>
            </div>
        @endif
    @endif
@endauth
@auth('admin')
    @php $posting = \App\ConfirmAgency::where('isPaid',false)->wherenotnull('payment_proof')
    ->whereDate('created_at', '>=', now()->subDay())->count(); @endphp
    @if($posting > 0)
        <div class="alert-banner">
            <div class="alert-banner-content">
                <div class="alert-banner-text">
                    There seems to be <strong>{{$posting}}</strong> job posting request that
                    {{$posting > 1 ? ' haven\'t' : ' hasn\'t'}} been approve yet!
                </div>
                <a class="alert-banner-button" href="{{route('table.jobPostings')}}" style="text-decoration: none">
                    Redirect me to the Job Posting Table page</a>
            </div>
            <div class="alert-banner-close"></div>
        </div>
    @endif
@endauth