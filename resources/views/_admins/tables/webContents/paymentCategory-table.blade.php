@extends('layouts.mst_admin')
@section('title', 'Payment Categories Table &ndash; '.env('APP_NAME').' Admins | '.env('APP_NAME'))
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Payment Categories
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a onclick="createCategory()" data-toggle="tooltip" title="Create"
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
                                <th>Category / Caption</th>
                                <th>Created at</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($categories as $category)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <strong>{{$category->name}}</strong><br>{{$category->caption}}</td>
                                    <td style="vertical-align: middle">{{\Carbon\Carbon::parse($category->created_at)->format('j F Y')}}</td>
                                    <td style="vertical-align: middle">{{$category->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='editCategory("{{$category->id}}","{{$category->name}}",
                                                "{{$category->caption}}")'
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="{{route('delete.PaymentCategories',['id'=>encrypt($category->id)])}}"
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
                <form method="post" action="{{route('create.PaymentCategories')}}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="name">Category <span class="required">*</span></label>
                                <input id="name" type="text" class="form-control" maxlength="191" name="name"
                                       placeholder="Category name" required>
                                <span class="fa fa-university form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="caption">Caption <span class="required">*</span></label>
                                <input id="caption" type="text" class="form-control" maxlength="191" name="caption"
                                       placeholder="Caption" required>
                                <span class="fa fa-comment-dots form-control-feedback right"
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
        function createCategory() {
            $("#createModal").modal('show');
        }

        function editCategory(id, name, caption) {
            $('#editModalContent').html(
                '<form method="post" id="' + id + '" action="{{url('admin/tables/web_contents/payment_categories')}}/' + id +
                '/update">{{csrf_field()}} {{method_field('PUT')}}' +
                '<div class="modal-body">' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="name' + id + '">Category <span class="required">*</span></label>' +
                '<input id="name' + id + '" type="text" class="form-control" maxlength="191" name="name"' +
                'value="' + name + '" required>' +
                '<span class="fa fa-university form-control-feedback right" aria-hidden="true"></span></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="caption' + id + '">Caption <span class="required">*</span></label>' +
                '<input id="caption' + id + '" type="text" class="form-control" maxlength="191" name="caption"' +
                'value="' + caption + '" required>' +
                '<span class="fa fa-comment-dots form-control-feedback right" aria-hidden="true"></span>' +
                '</div></div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Save changes</button></div></form>'
            );
            $("#editModal").modal('show');
        }
    </script>
@endpush