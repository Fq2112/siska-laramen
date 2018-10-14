@extends('layouts.mst_admin')
@section('title', 'Users Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Users
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
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined at</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($users as $user)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        @if($user->ava == "" || $user->ava == "seeker.png")
                                            <img class="img-responsive" width="100" alt="seeker.png"
                                                 src="{{asset('images/seeker.png')}}">
                                        @elseif($user->ava == "agency.png")
                                            <img class="img-responsive" width="100" alt="agency.png"
                                                 src="{{asset('images/agency.png')}}">
                                        @else
                                            <img class="img-responsive" width="100" alt="{{$user->ava}}"
                                                 src="{{asset('storage/users/'.$user->ava)}}">
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle">
                                        <strong>{{$user->name}}</strong><br>
                                        <a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                    <td style="vertical-align: middle;text-transform: uppercase" align="center">
                                        <span class="label label-default"
                                              style="background: {{$user->isAgency() ? '#00adb5' : '#fa5555'}}">
                                            {{$user->isAgency() ? 'Job Agency' : 'Job Seeker'}}</span></td>
                                    <td style="vertical-align: middle;text-transform: uppercase" align="center">
                                        <span class="label label-{{$user->status == true ? 'success' : 'warning'}}">
                                            {{$user->status == true ? 'Active' : 'Inactive'}}</span>
                                    </td>
                                    <td style="vertical-align: middle">{{\Carbon\Carbon::parse($user->created_at)->format('j F Y')}}</td>
                                    <td style="vertical-align: middle">{{$user->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a href="{{route('detail.users',['id' => $user->id])}}"
                                           class="btn btn-info btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Details" data-placement="left"><i class="fa fa-info-circle"></i></a>
                                        <hr style="margin: 5px auto">
                                        <a href="{{route('delete.users',['id'=>encrypt($user->id)])}}"
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