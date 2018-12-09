<!doctype html>
<html lang="en">
@php
    $psychoTestDate = \Carbon\Carbon::parse($vacancy->psychoTestDate_start)->format('j F Y') . " - " .
    \Carbon\Carbon::parse($vacancy->psychoTestDate_end)->format('j F Y');
    $no = 1;
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$vacancy->judul}}: Psycho Test Result List for {{$psychoTestDate}}</title>
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
<h3 style="margin-top: 0;margin-bottom: 5px">Psycho Test Result List for {{$psychoTestDate}}</h3>
<hr style="margin-bottom: .5em">
<table border="0" cellpadding="0" cellspacing="0" align="center" id="data-table">
    <tr>
        <th>No</th>
        <th>Contact</th>
        <th>Psycho Test Details</th>
        <th>Results</th>
    </tr>
    @foreach($applicants as $applicant)
        @php
            $seeker = \App\Seekers::find($applicant['seeker_id']);
            $admin = \App\Admin::find($applicant['admin_id']);
            $info = \App\PsychoTestInfo::find($applicant['psychoTest_id']);
            $room = '';
            foreach($info->room_codes as $code){
                strtok($code, '_');
                $participantID = strtok('');
                if($seeker->id == $participantID){
                    $room = $code;
                }
            }
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
            <td>
                <ul style="margin-left: -1em">
                    <li>Room Code: <strong>{{$room}}</strong></li>
                    <li>Interviewer: <strong>{{$admin->name}}</strong></li>
                </ul>
            </td>
            <td>
                <ul style="margin-left: -1em">
                    <li><strong>{{$applicant['kompetensi']}}</strong> &ndash; Kompetensi</li>
                    <li><strong>{{$applicant['karakter']}}</strong> &ndash; Karakter</li>
                    <li><strong>{{$applicant['attitude']}}</strong> &ndash; Attitude</li>
                    <li><strong>{{$applicant['grooming']}}</strong> &ndash; Grooming</li>
                    <li><strong>{{$applicant['komunikasi']}}</strong> &ndash; Komunikasi</li>
                    <li><strong>{{$applicant['anthusiasme']}}</strong> &ndash; Antusiasme</li>
                    <li>Note: <strong>{{$applicant['note'] != "" ? $applicant['note'] : '-'}}</strong></li>
                </ul>
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>