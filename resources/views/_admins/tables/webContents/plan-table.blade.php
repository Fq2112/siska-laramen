@extends('layouts.mst_admin')
@section('title', 'Plans Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Plans
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a onclick="createPlan()" data-toggle="tooltip" title="Create" data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Details</th>
                                <th>Value</th>
                                <th>Benefit</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($plans as $plan)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <strong style="text-transform: uppercase">{{$plan->name}}</strong> &ndash;
                                        <span id="price-{{$plan->id}}"></span><br>{{$plan->caption}}
                                        <script>
                                                    @if(preg_replace('/[^0-9]/', '', $plan->price) != "")
                                            var price = ("{{$plan->price}}" / "{{$plan->price <= 998999 ? 1000 : 1000000}}");
                                            @if($plan->price <= 998999)
                                                price = price.toFixed(0);
                                            @else
                                                price = price.toFixed(1);
                                            @endif
                                            document.getElementById("price-{{$plan->id}}").innerHTML =
                                                price + "{{$plan->price <= 998999 ? 'rb' : 'jt'}}/bln";
                                            @else
                                            document.getElementById("price-{{$plan->id}}").innerHTML = "{{$plan->price}}";
                                            @endif
                                        </script>
                                    </td>
                                    <td style="vertical-align: middle;text-transform: uppercase" align="center">
                                        <span class="label label-{{$plan->isBest == true ? 'success' : 'default'}}">
                                            {{$plan->isBest == true ? 'Best' : 'Normal'}}</span></td>
                                    <td style="vertical-align: middle">
                                        <ul style="margin-bottom: 0">
                                            <li><strong>{{$plan->job_ads}}</strong></li>
                                        </ul>
                                        {!! $plan->benefit !!}
                                    </td>
                                    <td style="vertical-align: middle"
                                        align="center">{{$plan->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left" onclick="editPlan('{{$plan->id}}',
                                                '{{$plan->name}}','{{$plan->price}}','{{$plan->caption}}',
                                                '{{$plan->job_ads}}','{{$plan->isBest}}','{{$plan->benefit}}')">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="{{route('delete.plans',['id'=>encrypt($plan->id)])}}"
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
                <form method="post" action="{{route('create.plans')}}" id="form-create-plan">
                    {{csrf_field()}}
                    <input type="hidden" name="admin_id" value="{{Auth::guard('admin')->user()->id}}">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-5 has-feedback">
                                <label for="name">Plan <span class="required">*</span></label>
                                <input id="name" type="text" class="form-control" maxlength="191" name="name"
                                       placeholder="Plan name" required>
                                <span class="fa fa-thumbtack form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-5 has-feedback">
                                <label for="price">Price <span class="required">*</span></label>
                                <input id="price" type="text" class="form-control" maxlength="191" name="price"
                                       placeholder="0" required>
                                <span class="fa fa-money-bill-wave form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-2">
                                <label>Value</label>
                                <p>
                                    <label for="normal">
                                        Normal: <input type="radio" class="flat" name="isBest" id="normal" value="0"
                                                       checked>
                                    </label>
                                    <label for="best">
                                        Best: <input type="radio" class="flat" name="isBest" id="best" value="1">
                                    </label>
                                </p>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6 has-feedback">
                                <label for="caption">Caption <span class="required">*</span></label>
                                <input id="caption" type="text" class="form-control" maxlength="191" name="caption"
                                       placeholder="Caption" required>
                                <span class="fa fa-comment-dots form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-6 has-feedback">
                                <label for="job_ads">Job Ads <span class="required">*</span></label>
                                <input id="job_ads" type="text" class="form-control" maxlength="191" name="job_ads"
                                       placeholder="Job ads" required>
                                <span class="fa fa-briefcase form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="benefit">Benefit <span class="required">*</span></label>
                                <textarea class="use-tinymce" name="benefit"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btn_create_plan">Submit</button>
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
        function createPlan() {
            $("#createModal").modal('show');
        }

        function editPlan(id, name, price, caption, jobAds, isBest, benefit) {
            $('#editModalContent').html(
                '<form method="post" id="' + id + '" action="{{url('admin/tables/web_contents/plans')}}/' + id +
                '/update">{{csrf_field()}} {{method_field('PUT')}}' +
                '<div class="modal-body">' +
                '<div class="row form-group">' +
                '<div class="col-lg-5 has-feedback">' +
                '<label for="name' + id + '">Plan <span class="required">*</span></label>' +
                '<input id="name' + id + '" type="text" class="form-control" maxlength="191" name="name" ' +
                'placeholder="Plan name" value="' + name + '" required>' +
                '<span class="fa fa-thumbtack form-control-feedback right" aria-hidden="true"></span></div>' +
                '<div class="col-lg-5 has-feedback">' +
                '<label for="price' + id + '">Price <span class="required">*</span></label>' +
                '<input id="price' + id + '" type="text" class="form-control" maxlength="191" name="price" ' +
                'placeholder="0" value="' + price + '" required>' +
                '<span class="fa fa-money-bill-wave form-control-feedback right" aria-hidden="true"></span></div>' +
                '<div class="col-lg-2"><label>Value</label>' +
                '<p><label for="normal' + id + '">Normal: <input type="radio" class="flat" name="isBest" ' +
                'id="normal' + id + '" value="0"></label>' +
                '<label for="best' + id + '">Best: <input type="radio" class="flat" name="isBest" ' +
                'id="best' + id + '" value="1"></label></p></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-6 has-feedback">' +
                '<label for="caption' + id + '">Caption <span class="required">*</span></label>' +
                '<input id="caption' + id + '" type="text" class="form-control" maxlength="191" name="caption" ' +
                'placeholder="Caption" value="' + caption + '" required>' +
                '<span class="fa fa-comment-dots form-control-feedback right" aria-hidden="true"></span></div>' +
                '<div class="col-lg-6 has-feedback">' +
                '<label for="job_ads' + id + '">Job Ads <span class="required">*</span></label>' +
                '<input id="job_ads' + id + '" type="text" class="form-control" maxlength="191" name="job_ads" ' +
                'placeholder="Job ads" value="' + jobAds + '" required>' +
                '<span class="fa fa-briefcase form-control-feedback right" aria-hidden="true"></span></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12">' +
                '<label for="benefit' + id + '">Benefit <span class="required">*</span></label>' +
                '<textarea class="use-tinymce" name="benefit" id="benefit' + id + '"></textarea>' +
                '</div></div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Save changes</button></div></form>'
            );
            if (isBest == 1) {
                $("#best" + id).prop('checked', true);
            } else {
                $("#normal" + id).prop('checked', true);
            }

            tinyMCE.remove();
            tinyMCE.init(editor_config);
            tinyMCE.get('benefit' + id).setContent(benefit);

            $("#editModal").modal('show');
        }

        $("#form-create-plan").on('submit', function (e) {
            e.preventDefault();
            if (tinyMCE.get('benefit').getContent() == "") {
                swal({
                    title: 'ATTENTION!',
                    text: 'Benefit field can\'t be null!',
                    type: 'warning',
                    timer: '3500'
                });

            } else {
                $(this)[0].submit();
            }
        });
    </script>
@endpush