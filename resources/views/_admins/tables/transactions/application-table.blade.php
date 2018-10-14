@extends('layouts.mst_admin')
@section('title', 'Job Agencies Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Job Agencies
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
                                <th>Work Days</th>
                                <th>Work Hours</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($agencies as $agency)
                                @php $user = \App\User::where('id',$agency->user_id)->first(); @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        @if($user->ava == "" || $user->ava == "agency.png")
                                            <img class="img-responsive" width="100" alt="agency.png"
                                                 src="{{asset('images/agency.png')}}">
                                        @else
                                            <img class="img-responsive" width="100" alt="{{$user->ava}}"
                                                 src="{{asset('storage/users/'.$user->ava)}}">
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle">
                                        <strong>{{$user->name}}</strong><br>
                                        <a href="mailto:{{$user->email}}">{{$user->email}}</a><br>
                                        <strong>Headquarter : </strong>
                                        <span class="label label-primary"
                                              style="text-transform: uppercase">{{$agency->kantor_pusat}}</span>
                                        <hr style="margin: 5px auto">
                                        <a href="{{$agency->link}}" target="_blank">{{$agency->link}}</a><br>
                                        <a href="tel:{{$agency->phone}}">{{$agency->phone}}</a><br>{{$agency->alamat}}
                                    </td>
                                    <td style="vertical-align: middle" align="center">{{$agency->hari_kerja}}</td>
                                    <td style="vertical-align: middle" align="center">{{$agency->jam_kerja}}</td>
                                    <td style="vertical-align: middle"
                                        align="center">{{$agency->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a href="{{route('detail.agencies',['id' => $agency->id])}}"
                                           class="btn btn-info btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Details" data-placement="left"><i class="fa fa-info-circle"></i></a>
                                        <hr style="margin: 5px auto">
                                        <a href="{{route('delete.agencies',['id'=>encrypt($agency->id)])}}"
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