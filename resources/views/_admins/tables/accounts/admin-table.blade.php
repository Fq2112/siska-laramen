@extends('layouts.mst_admin')
@section('title', 'Admins Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <style>
        #password + .glyphicon, #new_password + .glyphicon, #confirm + .glyphicon {
            cursor: pointer;
            pointer-events: all;
        }
    </style>
@endpush
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
                                @if(Auth::guard('admin')->user()->isRoot())
                                    <th>Action</th>@endif
                            </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($admins as $admin)
                                @php
                                    if($admin->isRoot()){
                                        $label = 'primary';
                                    } elseif($admin->isAdmin()){
                                        $label = 'info';
                                    } elseif($admin->isQuizStaff()){
                                        $label = 'success';
                                    } elseif($admin->isSyncStaff()){
                                        $label = 'warning';
                                    } elseif($admin->isInterviewer()){
                                        $label = 'danger';
                                    }
                                @endphp
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
                                        <span class="label label-{{$label}}">{{$admin->role}}</span></td>
                                    <td style="vertical-align: middle" align="center">
                                        {{\Carbon\Carbon::parse($admin->created_at)->format('j F Y')}}</td>
                                    <td style="vertical-align: middle"
                                        align="center">{{$admin->updated_at->diffForHumans()}}</td>
                                    @if(Auth::guard('admin')->user()->isRoot())
                                        <td style="vertical-align: middle" align="center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-dark btn-sm"
                                                        style="font-weight: 600" onclick="editProfile('{{$admin->id}}',
                                                        '{{$admin->ava}}','{{$admin->name}}')">
                                                    <i class="fa fa-user-edit"></i>&ensp;EDIT
                                                </button>
                                                <button type="button" class="btn btn-dark btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a onclick="accountSettings('{{$admin->id}}',
                                                                '{{$admin->email}}','{{$admin->role}}')">
                                                            <i class="fa fa-user-cog"></i>&ensp;Settings
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('delete.admins',['id'=> encrypt($admin->id)])}}"
                                                           class="delete-data"><i class="fa fa-trash-alt"></i>&ensp;Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    @endif
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
                                <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-6 has-feedback">
                                <label for="confirm">Password Confirmation <span class="required">*</span></label>
                                <input id="confirm" type="password" class="form-control" minlength="6"
                                       name="password_confirmation" placeholder="Retype password" required>
                                <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                      aria-hidden="true"></span>
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
    <div id="adminsProfileModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" style="width: 30%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Edit Profile</h4>
                </div>
                <div id="profileModalContent"></div>
            </div>
        </div>
    </div>
    <div id="adminsSettingsModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" style="width: 30%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Account Settings</h4>
                </div>
                <div id="settingsModalContent"></div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        function createAdmin() {
            $("#createModal").modal('show');
        }

        function editProfile(id, ava, name) {
            var $path = ava == "" || ava == "avatar.png" ? '{{asset('images/avatar.png')}}' :
                '{{asset('storage/admins/')}}/' + ava;
            $("#profileModalContent").html(
                '<form method="post" action="{{url('admin/tables/accounts/admins')}}/' + id + '/update/profile" ' +
                'enctype="multipart/form-data">' +
                '{{csrf_field()}} {{method_field('PUT')}}' +
                '<div class="modal-body">' +
                '<div class="row form-group">' +
                '<img src="' + $path + '" class="img-responsive" id="btn_img' + id + '" ' +
                'style="margin: 0 auto;width: 50%;cursor: pointer" data-toggle="tooltip" data-placement="bottom" ' +
                'title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB">' +
                '<hr style="margin: .5em auto">' +
                '<div class="col-lg-12">' +
                '<label for="ava' + id + '">Avatar</label>' +
                '<input type="file" name="ava" style="display: none;" accept="image/*" id="ava' + id + '" value="' + ava + '">' +
                '<div class="input-group">' +
                '<input type="text" id="txt_ava' + id + '" value="' + ava + '" class="browse_files form-control" ' +
                'placeholder="Upload file here..." readonly style="cursor: pointer" data-toggle="tooltip" ' +
                'title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB">' +
                '<span class="input-group-btn">' +
                '<button class="browse_files btn btn-info" type="button"><i class="fa fa-search"></i></button>' +
                '</span></div></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="name">Name <span class="required">*</span></label>' +
                '<input id="name" type="text" class="form-control" maxlength="191" name="name" ' +
                'placeholder="Full name" value="' + name + '" required>' +
                '<span class="fa fa-id-card form-control-feedback right" aria-hidden="true"></span></div></div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Save Changes</button></div></form>'
            );

            $("#adminsProfileModal").modal("show");

            $(".browse_files").on('click', function () {
                $("#ava" + id).trigger('click');
            });

            $("#btn_img" + id).on('click', function () {
                $("#ava" + id).trigger('click');
            });

            $("#ava" + id).on('change', function () {
                var files = $(this).prop("files");
                var names = $.map(files, function (val) {
                    return val.name;
                });
                var txt = $("#txt_ava" + id);
                txt.val(names);
                $("#txt_ava" + id + "[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
            });
        }

        function accountSettings(id, email, role) {
            var $attr = role == 'admin' ? 'selected' : '';
            $("#settingsModalContent").html(
                '<form method="post" action="{{url('admin/tables/accounts/admins')}}/' + id + '/update/account">' +
                '{{csrf_field()}} {{method_field('PUT')}}' +
                '<div class="modal-body">' +
                '<div class="row form-group" id="div' + role + '">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="role">Role <span class="required">*</span></label>' +
                '<select class="form-control" id="role" name="role" required>' +
                '<option value="root" ' + $attr + ' disabled>Root</option>' +
                '<option value="admin" ' + $attr + '>Admin</option>' +
                '</select>' +
                '<span class="fa fa-user-shield form-control-feedback right" aria-hidden="true"></span></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="email">Email <span class="required">*</span></label>' +
                '<input id="email" type="email" class="form-control" name="email" ' +
                'placeholder="Email" value="' + email + '" required>' +
                '<span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="password">Current Password <span class="required">*</span></label>' +
                '<input id="password' + id + '" type="password" class="form-control" minlength="6" name="password" ' +
                'placeholder="Current Password" required>' +
                '<span onclick="togglePass(' + id + ')" style="pointer: cursor; pointer-events: all" ' +
                'class="glyphicon glyphicon-eye-open form-control-feedback right" aria-hidden="true"></span></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="new_password">New Password <span class="required">*</span></label>' +
                '<input id="new_password' + id + '" type="password" class="form-control" minlength="6" ' +
                'name="new_password" placeholder="New Password" required>' +
                '<span onclick="toggleNewPass(' + id + ')" style="pointer: cursor; pointer-events: all" ' +
                'class="glyphicon glyphicon-eye-open form-control-feedback right" aria-hidden="true"></span></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="confirm">Password Confirmation <span class="required">*</span></label>' +
                '<input id="confirm' + id + '" type="password" class="form-control" minlength="6" ' +
                'name="password_confirmation" placeholder="Retype password" required>' +
                '<span onclick="toggleConfirmPass(' + id + ')" style="pointer: cursor; pointer-events: all" ' +
                'class="glyphicon glyphicon-eye-open form-control-feedback right" aria-hidden="true"></span></div></div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Save Changes</button></div></form>'
            );
            if (role == 'root') {
                $("#div" + role).remove();
            }
            $("#adminsSettingsModal").modal("show");
        }

        function togglePass(id) {
            $('#password' + id + ' + .glyphicon').toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#password' + id).togglePassword();
        }

        function toggleNewPass(id) {
            $('#new_password' + id + ' + .glyphicon').toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#new_password' + id).togglePassword();
        }

        function toggleConfirmPass(id) {
            $('#confirm' + id + ' + .glyphicon').toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#confirm' + id).togglePassword();
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

        $('#password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#password').togglePassword();
        });

        $('#new_password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#new_password').togglePassword();
        });

        $('#confirm + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#confirm').togglePassword();
        });
    </script>
@endpush