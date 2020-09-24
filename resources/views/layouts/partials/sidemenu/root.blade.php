<li><a href="{{route('home-admin')}}"><i class="fa fa-home"></i> Dashboard</a></li>
<li><a><i class="fa fa-envelope"></i> Mail <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a href="{{route('admin.inbox')}}">Inbox</a></li>
        <li><a href="{{route('admin.sent')}}">Sent</a></li>
    </ul>
</li>
<li><a href="{{route('quiz.info')}}"><i class="fa fa-smile"></i> Quiz</a></li>
<li><a href="{{route('psychoTest.info')}}"><i class="fa fa-comments"></i> Psycho Test</a></li>
<li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a>Data Master <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a>Accounts <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{route('table.admins')}}">Admins</a></li>
                        <li><a href="{{route('table.users')}}">Users</a></li>
                        <li><a href="{{route('table.agencies')}}">Agencies</a></li>
                        <li><a href="{{route('table.seekers')}}">Seekers</a></li>
                    </ul>
                </li>
                <li><a>Bank Soal <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{route('quiz.topics')}}">Topics</a></li>
                        <li><a href="{{route('quiz.questions')}}">Questions</a></li>
                        <li><a href="{{route('quiz.options')}}">Options</a></li>
                    </ul>
                </li>
                <li><a>Requirements <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{route('table.degrees')}}">Education Degrees</a></li>
                        <li><a href="{{route('table.majors')}}">Education Majors</a></li>
                        <li><a href="{{route('table.industries')}}">Industries</a></li>
                        <li><a href="{{route('table.JobFunctions')}}">Job Functions</a></li>
                        <li><a href="{{route('table.JobLevels')}}">Job Levels</a></li>
                        <li><a href="{{route('table.JobTypes')}}">Job Types</a></li>
                        <li><a href="{{route('table.salaries')}}">Salaries</a></li>
                    </ul>
                </li>
                <li><a>Web Contents <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{route('table.blog')}}">Blog</a></li>
                        <li><a href="{{route('table.blogTypes')}}">Blog Types</a></li>
                        <li><a href="{{route('table.carousels')}}">Carousels</a></li>
                        <li><a href="{{route('table.PaymentCategories')}}">Payment
                                Category</a></li>
                        <li><a href="{{route('table.PaymentMethods')}}">Payment Method</a>
                        </li>
                        <li><a href="{{route('table.plans')}}">Plans</a></li>
                        <li><a href="{{route('table.nations')}}">Nations</a></li>
                        <li><a href="{{route('table.provinces')}}">Provinces</a></li>
                        <li><a href="{{route('table.cities')}}">Cities</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a>Data Transaction <span class="fa fa-chevron-down"></span></a>
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
                <li><a>Partners <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{route('partners.credentials.show')}}">Credentials</a></li>
                        <li><a href="{{route('partners.vacancies.show')}}">Job Vacancies</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</li>
