@extends('layouts.mst_admin')
@section('title', 'Payment Methods Table &ndash; '.env('APP_NAME').' Admins | '.env('APP_NAME'))
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Payment Methods
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a onclick="createMethod()" data-toggle="tooltip" title="Create" data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Logo</th>
                                <th>Details</th>
                                <th>Created at</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($methods as $method)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <img class="img-responsive" width="100" alt="{{$method->logo}}"
                                             src="{{asset('images/paymentMethod/'.$method->logo)}}">
                                    </td>
                                    <td style="vertical-align: middle">
                                        <strong>{{$method->name}}</strong><br>
                                        {{\App\PaymentCategory::find($method->payment_category_id)->name}}<br>
                                        {{$method->account_number != "" ?
                                        $method->account_number.' (a/n '.$method->account_name.')' : ''}}
                                    </td>
                                    <td style="vertical-align: middle">{{\Carbon\Carbon::parse($method->created_at)->format('j F Y')}}</td>
                                    <td style="vertical-align: middle">{{$method->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='editMethod("{{$method->id}}","{{$method->logo}}",
                                                "{{$method->name}}","{{$method->payment_category_id}}",
                                                "{{$method->account_name}}","{{$method->account_number}}")'
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="{{route('delete.PaymentMethods',['id'=>encrypt($method->id)])}}"
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Create Form</h4>
                </div>
                <form method="post" action="{{route('create.PaymentMethods')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="logo">Logo <span class="required">*</span></label>
                                <input type="file" name="logo" style="display: none;" accept="image/*" id="logo"
                                       required>
                                <div class="input-group">
                                    <input type="text" id="txt_logo"
                                           class="browse_files form-control"
                                           placeholder="Upload file here..."
                                           readonly style="cursor: pointer" data-toggle="tooltip" data-placement="top"
                                           title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 1 MB">
                                    <span class="input-group-btn">
                                        <button class="browse_files btn btn-info" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6 has-feedback">
                                <label for="category">Payment Category <span class="required">*</span></label>
                                <select onchange="ifBank(this)" class="form-control" id="category" name="category_id"
                                        required>
                                    <option value="">-- Choose --</option>
                                    @foreach(\App\PaymentCategory::all() as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                                <span class="fa fa-university form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-6 has-feedback">
                                <label for="name">Payment Method <span class="required">*</span></label>
                                <input id="name" type="text" class="form-control" maxlength="191" name="name"
                                       placeholder="Payment method" required>
                                <span class="fa fa-credit-card form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group" id="ifBank" style="display: none">
                            <div class="col-lg-6 has-feedback">
                                <label for="account_name">Account Name <span class="required">*</span></label>
                                <input id="account_name" class="form-control" name="account_name"
                                       placeholder="Account name">
                                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-6 has-feedback">
                                <label for="account_number">Account Number <span class="required">*</span></label>
                                <input id="account_number" class="form-control" name="account_number"
                                       placeholder="Account number">
                                <span class="fa fa-ellipsis-h form-control-feedback right" aria-hidden="true"></span>
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
        <div class="modal-dialog modal-lg">
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
        function createMethod() {
            $("#createModal").modal('show');
        }

        function editMethod(id, logo, method, category, acc_name, acc_number) {
            $('#editModalContent').html(
                '<form method="post" id="' + id + '" enctype="multipart/form-data" ' +
                'action="{{url('admin/tables/web_contents/payment_methods')}}/' + id + '/update">' +
                '{{csrf_field()}} {{method_field('PUT')}}' +
                '<div class="modal-body">' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<img style="margin: 0 auto;width: 50%;cursor:pointer" class="img-responsive" id="btn_img' + id + '" ' +
                'src="{{asset('images/paymentMethod/')}}/' + logo + '" data-toggle="tooltip" data-placement="bottom" ' +
                'title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 1 MB">' +
                '<label for="logo' + id + '">Logo <span class="required">*</span></label>' +
                '<input type="file" name="logo" style="display: none;" accept="image/*" id="logo' + id + '">' +
                '<div class="input-group">' +
                '<input type="text" id="txt_logo' + id + '" class="browse_files form-control" value="' + logo + '" ' +
                'readonly style="cursor: pointer" data-toggle="tooltip" data-placement="top" ' +
                'title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 1 MB">' +
                '<span class="input-group-btn">' +
                '<button class="browse_files btn btn-info" type="button"><i class="fa fa-search"></i></button>' +
                '</span></div></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-6 has-feedback">' +
                '<label for="category' + id + '">Payment Category <span class="required">*</span></label>' +
                '<select onchange="ifBankModal(this,' + id + ')" class="form-control" id="category' + id + '" ' +
                'name="category_id" required></select>' +
                '<span class="fa fa-university form-control-feedback right" aria-hidden="true"></span></div>' +
                '<div class="col-lg-6 has-feedback">' +
                '<label for="name' + id + '">Payment Method <span class="required">*</span></label>' +
                '<input id="name' + id + '" type="text" class="form-control" maxlength="191" name="name"' +
                'value="' + method + '" required>' +
                '<span class="fa fa-credit-card form-control-feedback right" aria-hidden="true"></span>' +
                '</div></div>' +
                '<div class="row form-group" id="ifBank' + id + '" style="display: none">' +
                '<div class="col-lg-6 has-feedback">' +
                '<label for="account_name' + id + '">Account Name <span class="required">*</span></label>' +
                '<input id="account_name' + id + '" class="form-control" name="account_name" ' +
                'placeholder="Account name" value="' + acc_name + '">' +
                '<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span></div>' +
                '<div class="col-lg-6 has-feedback">' +
                '<label for="account_number' + id + '">Account Number <span class="required">*</span></label>' +
                '<input id="account_number' + id + '" class="form-control" name="account_number" ' +
                'placeholder="Account number" value="' + acc_number + '">' +
                '<span class="fa fa-ellipsis-h form-control-feedback right" aria-hidden="true"></span>' +
                '</div></div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Save changes</button></div></form>'
            );
            if (category == 1) {
                $("#ifBank" + id).show();
            }
            $.get('/api/clients/paymentcategory', function (data) {
                var $attr, $result = '';
                $.each(data, function (i, val) {
                    $attr = val.id == category ? 'selected' : '';
                    $result += '<option value="' + val.id + '" ' + $attr + '>' + val.name + '</option>';
                });
                $("#category" + id).empty().append($result);
            });
            $("#editModal").modal('show');

            $(".browse_files").on('click', function () {
                $("#logo" + id).trigger('click');
            });
            $("#btn_img" + id).on('click', function () {
                $("#logo" + id).trigger('click');
            });

            $("#logo" + id).on('change', function () {
                var files = $(this).prop("files");
                var names = $.map(files, function (val) {
                    return val.name;
                });
                var txt = $("#txt_logo" + id);
                txt.val(names);
                $("#txt_logo" + id + "[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
            });
        }

        $(".browse_files").on('click', function () {
            $("#logo").trigger('click');
        });

        $("#logo").on('change', function () {
            var files = $(this).prop("files");
            var names = $.map(files, function (val) {
                return val.name;
            });
            var txt = $("#txt_logo");
            txt.val(names);
            $("#txt_logo[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
        });

        function ifBank(that) {
            if (that.value == "1") {
                $("#ifBank").slideDown(300);
                $("#account_name,#account_number").prop('required', true);

            } else {
                $("#ifBank").slideUp(300);
                $("#account_name,#account_number").prop('required', false);
            }
        }

        function ifBankModal(that, id) {
            if (that.value == "1") {
                $("#ifBank" + id).slideDown(300);
                $("#account_name" + id).prop('required', true);
                $("#account_number" + id).prop('required', true);

            } else {
                $("#ifBank" + id).slideUp(300);
                $("#account_name" + id).prop('required', false);
                $("#account_number" + id).prop('required', false);
            }
        }
    </script>
@endpush