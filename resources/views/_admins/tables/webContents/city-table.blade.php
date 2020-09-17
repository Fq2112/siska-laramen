@extends('layouts.mst_admin')
@section('title', 'Cities Table &ndash; '.env('APP_NAME').' Admins | '.env('APP_NAME'))
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Cities
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a onclick="createCity()" data-toggle="tooltip" title="Create" data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Province</th>
                                <th>City</th>
                                <th>Created at</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($cities as $city)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">{{\App\Provinces::find($city->province_id)->name}}</td>
                                    <td style="vertical-align: middle"><strong>{{$city->name}}</strong></td>
                                    <td style="vertical-align: middle">{{\Carbon\Carbon::parse($city->created_at)->format('j F Y')}}</td>
                                    <td style="vertical-align: middle">{{$city->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='editCity("{{$city->id}}","{{$city->province_id}}","{{$city->name}}")'
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="{{route('delete.cities',['id'=>encrypt($city->id)])}}"
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
                <form method="post" action="{{route('create.cities')}}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="province">Province <span class="required">*</span></label>
                                <select id="province" class="form-control" name="province_id" required>
                                    <option value="">-- Choose --</option>
                                    @foreach(\App\Provinces::all() as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                                <span class="fa fa-monument form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="name">City <span class="required">*</span></label>
                                <input id="name" type="text" class="form-control" maxlength="191" name="name"
                                       placeholder="City name" required>
                                <span class="fa fa-building form-control-feedback right"
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
        function createCity() {
            $("#createModal").modal('show');
        }

        function editCity(id, province, name) {
            $('#editModalContent').html(
                '<form method="post" id="' + id + '" action="{{url('admin/tables/web_contents/cities')}}/' + id +
                '/update">{{csrf_field()}} {{method_field('PUT')}}' +
                '<div class="modal-body">' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="province' + id + '">Province <span class="required">*</span></label>' +
                '<select id="province' + id + '" class="form-control" name="province_id" required></select>' +
                '<span class="fa fa-monument form-control-feedback right" aria-hidden="true"></span></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="name' + id + '">City <span class="required">*</span></label>' +
                '<input id="name' + id + '" type="text" class="form-control" maxlength="191" name="name"' +
                'placeholder="City name" value="' + name + '" required>' +
                '<span class="fa fa-building form-control-feedback right" aria-hidden="true"></span>' +
                '</div></div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Save changes</button></div></form>'
            );
            $.get('/api/clients/provinces', function (data) {
                var $attr, $result = '';
                $.each(data, function (i, val) {
                    $attr = val.id == province ? 'selected' : '';
                    $result += '<option value="' + val.id + '" ' + $attr + '>' + val.name + '</option>';
                });
                $("#province" + id).empty().append($result);
            });
            $("#editModal").modal('show');
        }
    </script>
@endpush