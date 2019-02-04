<li><a href="{{route('home-admin')}}"><i class="fa fa-home"></i> Dashboard</a></li>
<li><a href="{{route('admin.inbox')}}"><i class="fa fa-envelope"></i> Inbox</a></li>
<li><a href="{{route('quiz.info')}}"><i class="fa fa-smile"></i> Quiz</a></li>
<li><a href="{{route('psychoTest.info')}}"><i class="fa fa-comments"></i> Psycho Test</a></li>
<li><a><i class="fa fa-table"></i> Data Transaction<span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a>Agencies <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{route('table.vacancies')}}">Job Vacancies</a></li>
                <li><a href="{{route('table.jobPostings')}}">Job Postings</a></li>
            </ul>
        </li>
        <li><a>Seekers <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{route('table.appliedInvitations')}}">Applied Invitations</a></li>
                <li><a href="{{route('table.applications')}}">Applications</a></li>
                <li><a href="{{route('table.quizResults')}}">Quiz Results</a></li>
                <li><a href="{{route('table.psychoTestResults')}}">Psycho Test Results</a></li>
            </ul>
        </li>
    </ul>
</li>