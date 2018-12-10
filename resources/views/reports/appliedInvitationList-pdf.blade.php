<!doctype html>
<html lang="en">
@php
    $recruitmentDate = \Carbon\Carbon::parse($vacancy->recruitmentDate_start)->format('j F Y') . " - " .
    \Carbon\Carbon::parse($vacancy->recruitmentDate_end)->format('j F Y');
    $no = 1;
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$vacancy->judul}}: Applied Invitation List for {{$recruitmentDate}}</title>
    <style>
        h1, h2, h3, h4, h5, h6 {
            text-align: center;
        }

        #data-table {
            width: auto;
            border-collapse: collapse;
            margin: 0 auto;
        }

        #data-table td, th {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }

        #data-table tr:nth-child(even) {
            background-color: #eee;
        }

    </style>
</head>
<body>
<h1 style="margin-bottom: 5px">{{$vacancy->judul}}</h1>
<h2 style="margin-top: 0;margin-bottom: 5px">{{$vacancy->agencies->user->name}}</h2>
<h3 style="margin-top: 0;margin-bottom: 5px">Applied Invitation List for {{$recruitmentDate}}</h3>
<hr style="margin-bottom: .5em">
<table border="0" cellpadding="0" cellspacing="0" align="center" id="data-table">
    <tr>
        <th>No</th>
        <th>Contact</th>
        <th>Education</th>
        <th>Work Experience</th>
    </tr>
    @foreach($applicants as $applicant)
        @php
            $seeker = \App\Seekers::find($applicant['seeker_id']);
        @endphp
        <tr>
            <td style="vertical-align: middle;text-align: center">{{$no++}}</td>
            <td style="vertical-align: middle">
                <strong>{{$seeker->user->name}}</strong><br>
                {{$seeker->user->email." | ".$seeker->phone}}<br>
                <hr style="margin: 5px auto">
                {{$seeker->website}}<br>
                {{$seeker->address}} &ndash; {{$seeker->zip_code}}
            </td>
            <td style="vertical-align: middle">
                @foreach($seeker->educations as $edu)
                    <strong>{{$edu->school_name}}</strong>
                    <ul style="margin-top: 0;">
                        <li>{{$edu->getDegree->name.' - '.$edu->getMajor->name}}</li>
                        <li>GPA: {{$edu->nilai != "" ? $edu->nilai : '-'}}</li>
                    </ul>
                @endforeach
            </td>
            <td style="vertical-align: middle">
                @foreach($seeker->experiences as $exp)
                    @php
                        $start = \Carbon\Carbon::parse($exp->start_date);
                        $end = \Carbon\Carbon::parse($exp->end_date);
                    @endphp
                    <strong>{{$exp->company}}</strong>
                    <ul style="margin-top: 0;">
                        <li>as {{$exp->job_title}}</li>
                        <li>for {{$start->diffInYears($end).' year(s)'}}</li>
                    </ul>
                @endforeach
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>