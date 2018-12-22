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
<h1 style="margin-bottom: 5px">Vacancy List &ndash; {{$partner->name}}</h1>
<h3 style="margin-top: 0;margin-bottom: 5px">{{'Email: '.$partner->email. ' | Phone: '.$partner->phone}}</h3>
<hr style="margin-bottom: .5em">
<table border="0" cellpadding="0" cellspacing="0" align="center" id="data-table">
    <tr>
        <th>No</th>
        <th>Partner Credentials</th>
        <th colspan="3">Vacancy Details</th>
    </tr>
    @php $no = 1; @endphp
    @foreach($vacancies as $vacancy)
        @php
            if($vacancy->plan_id != null){
                $plan = \App\Plan::find($vacancy->plan_id);
            }
            $agency = \App\Agencies::find($vacancy->agency_id);
            $user = \App\User::find($agency->user_id);
            $city = \App\Cities::find($vacancy->cities_id)->name;
            $salary = \App\Salaries::find($vacancy->salary_id);
            $jobfunc = \App\FungsiKerja::find($vacancy->fungsikerja_id);
            $joblevel = \App\JobLevel::find($vacancy->joblevel_id);
            $industry = \App\Industri::find($vacancy->industry_id);
            $degrees = \App\Tingkatpend::find($vacancy->tingkatpend_id);
            $majors = \App\Jurusanpend::find($vacancy->jurusanpend_id);
        @endphp
        <tr>
            <td style="vertical-align: middle;text-align: center">{{$no++}}</td>
            <td style="vertical-align: middle">
                <table>
                    <tr>
                        <td>API Key</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{$partner->api_key}}</td>
                    </tr>
                    <tr>
                        <td>API Secret</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{$partner->api_secret}}</td>
                    </tr>
                    <tr>
                        <td>API Expiry</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{\Carbon\Carbon::parse($partner->api_expiry)->format('l, j F Y')}}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{\Carbon\Carbon::parse($partner->status)->format('l, j F Y')}}</td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: middle">
                <table>
                    <tr>
                        <td>Title</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><strong>{{$vacancy->judul}}</strong></td>
                    </tr>
                    <tr>
                        <td>Agency</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><strong>{{$user->name}}</strong></td>
                    </tr>
                    <tr>
                        <td>Location</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{substr($city, 0, 2)=="Ko" ? substr($city,5) : substr($city,10)}}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>
                            <strong style="text-transform: uppercase">{{$vacancy->isPost == true ? 'Active' : 'Inactive'}}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Plan</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>
                            @if($vacancy->isPost == true)
                                <strong style="text-transform: uppercase">{{$plan->name}}</strong> Package
                                @else
                                &ndash;
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Created at</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{\Carbon\Carbon::parse($vacancy->created_at)->format('j F Y')}}</td>
                    </tr>
                    <tr>
                        <td>Last Update</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{\Carbon\Carbon::parse($vacancy->updated_at)->diffForHumans()}}</td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: middle">
                <table>
                    <tr>
                        <td>Job Function</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{$jobfunc->nama}}</td>
                    </tr>
                    <tr>
                        <td>Industry</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{$industry->nama}}</td>
                    </tr>
                    <tr>
                        <td>Job Level</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{$joblevel->name}}</td>
                    </tr>
                    <tr>
                        <td>Salary</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>IDR {{$salary->name}}</td>
                    </tr>
                    <tr>
                        <td>Education Degree</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{$degrees->name}}</td>
                    </tr>
                    <tr>
                        <td>Education Major</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{$majors->name}}</td>
                    </tr>
                    <tr>
                        <td>Work Experience</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>At least {{$vacancy->pengalaman > 1 ? $vacancy->pengalaman.' years' :
                        $vacancy->pengalaman.' year'}}</td>
                    </tr>
                    <tr>
                        <td>Total Applicant</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><strong>{{\App\Accepting::where('vacancy_id',$vacancy->id)->where('isApply',true)->count()}}
                            </strong> applicants
                        </td>
                    </tr>
                </table>
                <hr style="margin: .5em auto">
                <strong>Requirements</strong><br>{!! $vacancy->syarat !!}
                <hr style="margin: .5em auto">
                <strong>Responsibilities</strong><br>{!! $vacancy->tanggungjawab !!}
            </td>
            <td style="vertical-align: middle">
                <table>
                    <tr>
                        <td>Recruitment Date</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{$vacancy->recruitmentDate_start != "" && $vacancy->recruitmentDate_end != "" ?
                        \Carbon\Carbon::parse($vacancy->recruitmentDate_start)->format('j F Y').' - '.
                        \Carbon\Carbon::parse($vacancy->recruitmentDate_end)->format('j F Y') : 'Unknown'}}</td>
                    </tr>
                    <tr>
                        <td>Job Interview Date</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>{{$vacancy->interview_date != "" ? \Carbon\Carbon::parse($vacancy->interview_date)
                        ->format('l, j F Y') : 'Unknown'}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>