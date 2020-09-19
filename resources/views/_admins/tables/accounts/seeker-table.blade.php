@extends('layouts.mst_admin')
@section('title', 'Job Seekers Table &ndash; '.env('APP_NAME').' Admins | '.env('APP_TITLE'))
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Job Seekers
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link" data-toggle="tooltip" title="Close" data-placement="right">
                                    <i class="fa fa-times"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Ava</th>
                                <th>Contact</th>
                                <th>Personal Data</th>
                                <th>Total Experience</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($seekers as $seeker)
                                @php $user = \App\User::find($seeker->user_id); @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        @if($user->ava == "" || $user->ava == "seeker.png")
                                            <img class="img-responsive" width="100" alt="seeker.png"
                                                 src="{{asset('images/seeker.png')}}">
                                        @else
                                            <img class="img-responsive" width="100" alt="{{$user->ava}}"
                                                 src="{{asset('storage/users/'.$user->ava)}}">
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle">
                                        <strong>{{$user->name}}</strong><br>
                                        <a href="mailto:{{$user->email}}">{{$user->email}}</a><br>
                                        <hr style="margin: 5px auto">
                                        <a href="{{$seeker->website}}" target="_blank">{{$seeker->website}}</a><br>
                                        <a href="tel:{{$seeker->phone}}">{{$seeker->phone}}</a><br>
                                        {{$seeker->address}} &ndash; {{$seeker->zip_code}}
                                    </td>
                                    <td style="vertical-align: middle">
                                        <table style="margin: 0">
                                            <tr>
                                                <td><i class="fa fa-birthday-cake"></i></td>
                                                <td>&nbsp;</td>
                                                <td>
                                                    {{$seeker->birthday == "" ? 'Birthday (-)' : \Carbon\Carbon::parse
                                                    ($seeker->birthday)->format('j F Y')}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-transgender"></i></td>
                                                <td>&nbsp;</td>
                                                <td style="text-transform: capitalize">
                                                    {{$seeker->gender != "" ? $seeker->gender : 'Gender (-)'}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-hand-holding-heart"></i></td>
                                                <td>&nbsp;</td>
                                                <td style="text-transform: capitalize">
                                                    {{$seeker->relationship != "" ? $seeker->relationship : 'Relationship Status (-)'}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-flag"></i></td>
                                                <td>&nbsp;</td>
                                                <td>
                                                    {{$seeker->nationality != "" ? $seeker->nationality : 'Nationality (-)'}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-hand-holding-usd"></i></td>
                                                <td>&nbsp;</td>
                                                <td style="text-transform: none" id="expected_salary{{$seeker->id}}">
                                                    @if($seeker->lowest_salary != "")
                                                        <script>
                                                            var low = ("{{$seeker->lowest_salary}}") / 1000000,
                                                                high = ("{{$seeker->highest_salary}}") / 1000000;
                                                            document.getElementById("expected_salary{{$seeker->id}}").innerText = "IDR " + low + " to " + high + " millions";
                                                        </script>
                                                    @else
                                                        Expected Salary (anything)
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        @if($seeker->total_exp != "")
                                            <span class="label label-default" style="background: #fa5555">
                                                {{$seeker->total_exp > 1 ? $seeker->total_exp.' years' :
                                                $seeker->total_exp.' year'}}</span>
                                        @else
                                            <span class="label label-default" style="background: #fa5555">0 year</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle"
                                        align="center">{{$seeker->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a href="{{route('seeker.profile',['id' => $seeker->id])}}" target="_blank"
                                           class="btn btn-info btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Details" data-placement="left"><i class="fa fa-info-circle"></i></a>
                                        <hr style="margin: 5px auto">
                                        <a href="{{route('delete.seekers',['id'=>encrypt($seeker->id)])}}"
                                           class="btn btn-danger btn-sm delete-data" style="font-size: 16px"
                                           data-toggle="tooltip"
                                           title="Delete" data-placement="left"><i class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
