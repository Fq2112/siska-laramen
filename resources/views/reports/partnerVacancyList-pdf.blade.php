<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vacancy List &ndash; {{$partner->name}}</title>
    <style>
        h1, h2, h3, h4, h5, h6 {
            text-align: center;
        }

        #data-table {
            width: auto;
            border-collapse: collapse;
            margin: 0 auto;
        }

        #data-table td, #data-table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #data-table tr:nth-child(even) {
            background-color: #eee;
        }

    </style>
</head>
<body>
<h1 style="margin-bottom: 5px">Vacancy List &ndash; {{$partner->name}}</h1>
<h3 style="margin-top: 0;margin-bottom: 5px">{{'Email: '.$partner->email. ' | Phone: '.$partner->phone}}</h3>
<hr style="margin-bottom: .5em">
<table border="0" cellpadding="0" cellspacing="0" align="center" id="data-table">
    <tr>
        <th align="center">No</th>
        <th align="center">Details</th>
    </tr>
    @php $no = 1; @endphp
    @foreach($vacancies as $vacancy)
        @php
            $agency = \App\Agencies::find($vacancy->agency_id);
            $user = \App\User::find($agency->user_id);
            $city = \App\Cities::find($vacancy->cities_id)->name;
            $salary = \App\Salaries::find($vacancy->salary_id);
            $jobfunc = \App\FungsiKerja::find($vacancy->fungsikerja_id);
            $joblevel = \App\JobLevel::find($vacancy->joblevel_id);
            $jobtype = \App\JobType::find($vacancy->jobtype_id);
            $industry = \App\Industri::find($vacancy->industry_id);
            $degrees = \App\Tingkatpend::find($vacancy->tingkatpend_id);
            $majors = \App\Jurusanpend::find($vacancy->jurusanpend_id);
        @endphp
        <tr>
            <td style="vertical-align: middle;text-align: center" align="center">{{$no++}}</td>
            <td style="vertical-align: middle">
                <strong>General</strong>
                <ul>
                    <li><strong>Title:</strong> {{$vacancy->judul}}</li>
                    <li><strong>Agency:</strong> {{$user->name}}</li>
                    <li><strong>Status:</strong> <span style="color: {{$vacancy->isPost == true ?
                    'green' : 'red'}}">{{$vacancy->isPost == true ? 'ACTIVE' : 'INACTIVE'}}</span></li>
                    <li><strong>Location:</strong> {{substr($city, 0, 2)=="Ko" ? substr($city,5) : substr($city,10)}}
                    </li>
                    <li><strong>Job Function:</strong> {{$jobfunc->nama}}</li>
                    <li><strong>Industry:</strong> {{$industry->nama}}</li>
                    <li><strong>Job Level:</strong> {{$joblevel->name}}</li>
                    <li><strong>Job Type:</strong> {{$jobtype->name}}</li>
                    <li><strong>Salary:</strong> IDR {{$salary->name}}</li>
                    <li><strong>Work Experience:</strong> At least {{$vacancy->pengalaman > 1 ?
                    $vacancy->pengalaman.' years' : $vacancy->pengalaman.' year'}}</li>
                    <li><strong>Education Degree:</strong> {{$degrees->name}}</li>
                    <li><strong>Education Major:</strong> {{$majors->name}}</li>
                    <li><strong>Total Applicant:</strong> {{\App\Accepting::where('vacancy_id',$vacancy->id)
                    ->where('isApply',true)->count()}} applicants
                    </li>
                </ul>
                <hr style="margin: .5em auto">
                <strong>Schedules</strong>
                <ul>
                    <li><strong>Recruitment Date:</strong> {{$vacancy->recruitmentDate_start != "" &&
                    $vacancy->recruitmentDate_end != "" ? \Carbon\Carbon::parse($vacancy->recruitmentDate_start)
                    ->format('j F Y').' - '.\Carbon\Carbon::parse($vacancy->recruitmentDate_end)
                    ->format('j F Y') : 'Unknown'}}</li>
                    <li><strong>Job Interview Date:</strong> {{$vacancy->interview_date != "" ?
                    \Carbon\Carbon::parse($vacancy->interview_date)->format('l, j F Y') : 'Unknown'}}</li>
                </ul>
                <strong>Requirements</strong><br>{!! $vacancy->syarat !!}
                <hr style="margin: .5em auto">
                <strong>Responsibilities</strong><br>{!! $vacancy->tanggungjawab !!}
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>