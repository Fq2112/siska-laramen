<!doctype html>
<html lang="en">
@php
    $quizDate = \Carbon\Carbon::parse($vacancy->quizDate_start)->format('j F Y') . " - " .
    \Carbon\Carbon::parse($vacancy->quizDate_end)->format('j F Y');
    $no = 1;
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$vacancy->judul}}: Quiz Result List for {{$quizDate}}</title>
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
<h3 style="margin-top: 0;margin-bottom: 5px">Quiz Result List for {{$quizDate}}</h3>
<hr style="margin-bottom: .5em">
<table border="0" cellpadding="0" cellspacing="0" align="center" id="data-table">
    <tr>
        <th>No</th>
        <th>Contact</th>
        <th>Quiz Details</th>
        <th>Passing Grade</th>
        <th>Score</th>
    </tr>
    @foreach($applicants as $applicant)
        @php
            $seeker = \App\Seekers::find($applicant['seeker_id']);
            $info = \App\QuizInfo::find($applicant['quiz_id']);
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
                <strong>Quiz Code: {{$info->unique_code}}</strong>
                <ul style="margin-top: 0;">
                    <li>{{$info->total_question}} items</li>
                    <li>{{$info->time_limit}} minutes</li>
                </ul>
            </td>
            <td style="vertical-align: middle;text-align: center;font-weight: 600">{{$info->getVacancy->passing_grade}}</td>
            <td style="vertical-align: middle;text-align: center;font-weight: 600;color: {{$applicant['score'] >= $info->getVacancy->passing_grade ? '#00adb5' : '#fa5555'}}">{{$applicant['score']}}</td>
        </tr>
    @endforeach
</table>
</body>
</html>