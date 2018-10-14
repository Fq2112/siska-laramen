@extends('layouts.mst_admin')
@section('title', 'Admins Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Admins
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a onclick="createAdmin()" data-toggle="tooltip" title="Create" data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
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
                                <th>Created at</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($admins as $admin)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        @if($admin->ava == "" || $admin->ava == "avatar.png")
                                            <img class="img-responsive" width="100" alt="avatar.png"
                                                 src="{{asset('images/avatar.png')}}">
                                        @else
                                            <img class="img-responsive" width="100" alt="{{$admin->ava}}"
                                                 src="{{asset('storage/admins/'.$admin->ava)}}">
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle">
                                        <strong>{{$admin->name}}</strong><br>
                                        <a href="mailto:{{$admin->email}}">{{$admin->email}}</a></td>
                                    <td style="vertical-align: middle;text-transform: uppercase" align="center">
                                        <span class="label label-{{$admin->isRoot() ? 'primary' : 'info'}}">
                                            {{$admin->isRoot() ? 'Root' : 'Admin'}}</span></td>
                                    <td style="vertical-align: middle">
                                        {{\Carbon\Carbon::parse($admin->created_at)->format('j F Y')}}</td>
                                    <td style="vertical-align: middle">{{$admin->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a href="{{route('detail.admins',['id' => $admin->id])}}"
                                           class="btn btn-info btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Details" data-placement="left"><i class="fa fa-info-circle"></i></a>
                                        @if(!$admin->isRoot() || $admin->id!=Auth::guard('admin')->user()->id)
                                            <hr style="margin: 5px auto">
                                            <a href="{{route('delete.admins',['id'=>encrypt($admin->id)])}}"
                                               class="btn btn-danger btn-sm delete-data" style="font-size: 16px"
                                               data-toggle="tooltip"
                                               title="Delete" data-placement="left"><i class="fa fa-trash-alt"></i></a>
                                        @endif
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
    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Create Form</h4>
                </div>
                <form method="post" action="{{route('create.admins')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label for="ava">Avatar</label>
                                <input type="file" name="ava" style="display: none;" accept="image/*" id="ava">
                                <div class="input-group">
                                    <input type="text" id="txt_ava"
                                           class="browse_files form-control"
                                           placeholder="Upload file here..."
                                           readonly style="cursor: pointer" data-toggle="tooltip" data-placement="top"
                                           title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB">
                                    <span class="input-group-btn">
                                        <button class="browse_files btn btn-info" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6 has-feedback">
                                <label for="name">Name <span class="required">*</span></label>
                                <input id="name" type="text" class="form-control" maxlength="191" name="name"
                                       placeholder="Full name" required>
                                <span class="fa fa-id-card form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6 has-feedback">
                                <label for="email">Email <span class="required">*</span></label>
                                <input id="email" type="email" class="form-control" name="email"
                                       placeholder="Email" required>
                                <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-6 has-feedback">
                                <label for="role">Role <span class="required">*</span></label>
                                <select id="role" class="form-control" name="role" required>
                                    <option value="">-- Choose --</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <span class="fa fa-user-shield form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6 has-feedback">
                                <label for="password">Password <span class="required">*</span></label>
                                <input id="password" type="password" class="form-control" minlength="6" name="password"
                                       placeholder="Password" required>
                                <span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-6 has-feedback">
                                <label for="confirm">Password Confirmation <span class="required">*</span></label>
                                <input id="confirm" type="password" class="form-control" minlength="6"
                                       name="password_confirmation" placeholder="Retype password" required>
                                <span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        function createAdmin() {
            $("#createModal").modal('show');
        }

        $(".browse_files").on('click', function () {
            $("#ava").trigger('click');
        });

        $("#ava").on('change', function () {
            var files = $(this).prop("files");
            var names = $.map(files, function (val) {
                return val.name;
            });
            var txt = $("#txt_ava");
            txt.val(names);
            $("#txt_ava[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
        });
    </script>
@endpush