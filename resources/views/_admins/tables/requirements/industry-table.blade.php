@extends('layouts.mst_admin')
@section('title', 'Industries Table &ndash; '.env('APP_NAME').' Admins | '.env('APP_NAME'))
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Industries
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a onclick="createIndustry()" data-toggle="tooltip" title="Create"
                                   data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Icon</th>
                                <th>Industry</th>
                                <th>Created at</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($industries as $industry)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <img class="img-responsive" width="64" alt="{{$industry->icon}}"
                                             src="{{asset('images/industries/'.$industry->icon)}}">
                                    </td>
                                    <td style="vertical-align: middle"><strong>{{$industry->nama}}</strong></td>
                                    <td style="vertical-align: middle">{{\Carbon\Carbon::parse($industry->created_at)->format('j F Y')}}</td>
                                    <td style="vertical-align: middle">{{$industry->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='editIndustry("{{$industry->id}}","{{$industry->nama}}","{{$industry->icon}}")'
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="{{route('delete.industries',['id'=>encrypt($industry->id)])}}"
                                           class="btn btn-danger btn-sm delete-data" style="font-size: 16px"
                                           data-toggle="tooltip"
                                           title="Delete" data-placement="right"><i class="fa fa-trash-alt"></i></a>
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
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Create Form</h4>
                </div>
                <form method="post" action="{{route('create.industries')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="icon">Icon <span class="required">*</span></label>
                                <input type="file" name="icon" style="display: none;" accept="image/*,.svg" id="icon"
                                       required>
                                <div class="input-group">
                                    <input type="text" id="txt_icon"
                                           class="browse_files form-control"
                                           placeholder="Upload file here..."
                                           readonly style="cursor: pointer" data-toggle="tooltip" data-placement="top"
                                           title="Allowed extension: jpg, jpeg, gif, png, svg. Allowed size: < 200 KB">
                                    <span class="input-group-btn">
                                        <button class="browse_files btn btn-info" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="industry">Industry <span class="required">*</span></label>
                                <input id="industry" type="text" class="form-control" maxlength="60" name="nama"
                                       placeholder="Industry name" required>
                                <span class="fa fa-industry form-control-feedback right" aria-hidden="true"></span>
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
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Edit Form</h4>
                </div>
                <div id="editModalContent"></div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        function createIndustry() {
            $("#createModal").modal('show');
        }

        function editIndustry(id, name, icon) {
            $('#editModalContent').html(
                '<form method="post" id="' + id + '" enctype="multipart/form-data" ' +
                'action="{{url('admin/tables/requirements/industries')}}/' + id + '/update">' +
                '{{csrf_field()}} {{method_field('PUT')}}' +
                '<div class="modal-body">' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<img style="margin: 0 auto" class="img-responsive" width="100" src="{{asset('images/industries/')}}/' + icon + '">' +
                '<label for="icon' + id + '">Icon <span class="required">*</span></label>' +
                '<input type="file" name="icon" style="display: none;" accept="image/*,.svg" id="icon' + id + '">' +
                '<div class="input-group">' +
                '<input type="text" id="txt_icon' + id + '" class="browse_files form-control" value="' + icon + '" ' +
                'readonly style="cursor: pointer" data-toggle="tooltip" data-placement="top" ' +
                'title="Allowed extension: jpg, jpeg, gif, png, svg. Allowed size: < 200 KB">' +
                '<span class="input-group-btn">' +
                '<button class="browse_files btn btn-info" type="button"><i class="fa fa-search"></i></button>' +
                '</span></div></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback"><label for="industry' + id + '">Industry ' +
                '<span class="required">*</span></label>' +
                '<input id="industry' + id + '" type="text" class="form-control" maxlength="60" ' +
                'value="' + name + '" name="nama" required>' +
                '<span class="fa fa-industry form-control-feedback right" aria-hidden="true"></span>' +
                '</div></div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Save changes</button></div></form>'
            );
            $("#editModal").modal('show');
            $(".browse_files").on('click', function () {
                $("#icon" + id).trigger('click');
            });

            $("#icon" + id).on('change', function () {
                var files = $(this).prop("files");
                var names = $.map(files, function (val) {
                    return val.name;
                });
                var txt = $("#txt_icon" + id);
                txt.val(names);
                $("#txt_icon" + id + "[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
            });
        }

        $(".browse_files").on('click', function () {
            $("#icon").trigger('click');
        });

        $("#icon").on('change', function () {
            var files = $(this).prop("files");
            var names = $.map(files, function (val) {
                return val.name;
            });
            var txt = $("#txt_icon");
            txt.val(names);
            $("#txt_icon[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
        });
    </script>
@endpush