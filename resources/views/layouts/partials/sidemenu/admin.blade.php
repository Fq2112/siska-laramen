<li><a href="{{route('home-admin')}}"><i class="fa fa-home"></i> Dashboard</a></li>
<li><a href="{{route('admin.inbox')}}"><i class="fa fa-envelope"></i> Inbox</a></li>
<li><a href="{{route('psychoTest.info')}}"><i class="fa fa-comments"></i> Psycho Test</a>
<li>
    <a><i class="fa fa-table"></i> Tables
        <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a>Data Master <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
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
                        <li><a href="{{route('table.appliedInvitations')}}">
                                Applied Invitations</a></li>
                        <li><a href="{{route('table.applications')}}">Applications</a></li>
                        <li><a href="{{route('table.quizResults')}}">Quiz Results</a></li>
                        <li><a href="{{route('table.psychoTestResults')}}">
                                Psycho Test Results</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</li>