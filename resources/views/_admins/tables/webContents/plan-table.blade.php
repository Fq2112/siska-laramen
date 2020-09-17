@extends('layouts.mst_admin')
@section('title', 'Plans Table &ndash; '.env('APP_NAME').' Admins | '.env('APP_NAME'))
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
                                <th>Discount</th>
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
                                        <strong style="text-transform: uppercase;font-weight: 600">{{$plan->name}}</strong>
                                        &ndash; <span class="label label-{{$plan
                                        ->isBest == true ? 'success' : 'default'}}">{{$plan->isBest == true ? 'BEST' :
                                        'NORMAL'}}</span><br>
                                        <span style="font-weight: 500">Rp{{number_format($plan->price -
                                        ($plan->price * $plan->discount/100),2,',','.')}}</span><br>{{$plan->caption}}
                                    </td>
                                    <td style="vertical-align: middle;text-transform: uppercase" align="center">
                                        <strong>{{$plan->discount}}%</strong></td>
                                    <td style="vertical-align: middle">
                                        <ul style="margin-bottom: 0">
                                            <li><strong>{{$plan->job_ads}}</strong></li>
                                            <li>Quiz untuk <strong>{{$plan->quiz_applicant}}</strong> applicants
                                            </li>
                                            <li style="list-style: none">(<strong>Rp{{number_format
                                                ($plan->price_quiz_applicant,0,',','.')}}/applicant</strong>)
                                            </li>
                                            <li>Psycho Test untuk <strong>{{$plan->psychoTest_applicant}}</strong>
                                                applicants
                                            </li>
                                            <li style="list-style: none">(<strong>Rp{{number_format
                                                ($plan->price_psychoTest_applicant,0,',','.')}}/applicant</strong>)
                                            </li>
                                        </ul>
                                        {!! $plan->benefit !!}
                                    </td>
                                    <td style="vertical-align: middle"
                                        align="center">{{$plan->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left" onclick="editPlan('{{$plan->id}}',
                                                '{{$plan->name}}','{{$plan->caption}}','{{$plan->isBest}}',
                                                '{{$plan->price}}','{{$plan->discount}}','{{$plan->job_ads}}',
                                                '{{$plan->isQuiz}}','{{$plan->quiz_applicant}}',
                                                '{{$plan->price_quiz_applicant}}',
                                                '{{$plan->isPsychoTest}}','{{$plan->psychoTest_applicant}}',
                                                '{{$plan->price_psychoTest_applicant}}','{{$plan->benefit}}')">
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
                    <input type="hidden" name="_method">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label for="name">Plan <span class="required">*</span></label>
                                        <div class="input-group">
                                            <input id="name" type="text" class="form-control" maxlength="191"
                                                   name="name"
                                                   placeholder="Plan name" required>
                                            <span class="input-group-addon"><i class="fa fa-thumbtack"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="caption">Caption <span class="required">*</span></label>
                                        <div class="input-group">
                                            <input id="caption" type="text" class="form-control" maxlength="191"
                                                   name="caption" placeholder="Caption" required>
                                            <span class="input-group-addon"><i class="fa fa-comment-dots"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <label>Value</label>
                                        <p>
                                            <label for="normal">
                                                <input type="radio" class="flat" name="isBest" id="normal"
                                                       value="0" checked> NORMAL
                                            </label><br>
                                            <label for="best">
                                                <input type="radio" class="flat" name="isBest" id="best" value="1"> BEST
                                            </label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-5">
                                <label for="price">Price <span class="required">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><strong>Rp</strong></span>
                                    <input id="price" type="number" class="form-control" name="price"
                                           placeholder="0" min="0" required>
                                    <span class="input-group-addon"><i class="fa fa-money-bill-wave"></i></span>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <label for="discount">Discount <span class="required">*</span></label>
                                <div class="input-group" style="width: 100%">
                                    <span class="input-group-addon"><strong>%</strong></span>
                                    <input id="discount" type="number" class="form-control" min="0" max="100"
                                           name="discount" placeholder="0" style="width: 30%" required>
                                    <input id="new_price" type="text" class="form-control" style="width: 70%"
                                           placeholder="0" readonly>
                                    <span class="input-group-addon"><i class="fa fa-money-bill-wave"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="job_ads">Main Feature <span class="required">*</span></label>
                                <div class="input-group">
                                    <input id="job_ads" type="text" class="form-control" maxlength="191" name="job_ads"
                                           placeholder="Main feature" required>
                                    <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label for="isQuiz">Quiz Applicant & Price/applicant</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" class="flat" name="isQuiz" id="isQuiz" value="1">
                                    </span>
                                    <input id="quiz_applicant" name="quiz_applicant" type="number" class="form-control"
                                           style="width: 30%" placeholder="0" min="0" disabled>
                                    <input id="price_quiz_applicant" name="price_quiz_applicant" style="width: 70%"
                                           type="number" class="form-control" placeholder="0" min="0" disabled>
                                    <span class="input-group-addon"><i class="fa fa-grin-beam"></i></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="isPsychoTest">Psycho Test Applicant & Price/applicant</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" class="flat" name="isPsychoTest"
                                               id="isPsychoTest" value="1">
                                    </span>
                                    <input id="psychoTest_applicant" name="psychoTest_applicant" type="number"
                                           class="form-control" style="width: 30%" placeholder="0" min="0" disabled>
                                    <input id="price_psychoTest_applicant" name="price_psychoTest_applicant"
                                           style="width: 70%" type="number" class="form-control" placeholder="0"
                                           min="0" disabled>
                                    <span class="input-group-addon"><i class="fa fa-grin-beam"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="benefit">Benefit <span class="required">*</span></label>
                                <textarea class="use-tinymce" name="benefit" id="benefit"></textarea>
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
@endsection
@push("scripts")
    <script>
        var price = 0, discount = 0, new_price = 0;

        function createPlan() {
            $("#form-create-plan").prop('action', '{{route('create.plans')}}');
            $("#form-create-plan input[name=_method]").val('');
            $("#createModal .modal-title").text('Create Form');
            $("#btn_create_plan").text('Submit');
            $("#form-create-plan input").val('');
            tinyMCE.get('benefit').setContent('');
            $("#normal").iCheck('check');
            $("#best").iCheck('uncheck');
            $("#isQuiz").iCheck('uncheck');
            $("#isPsychoTest").iCheck('uncheck');
            $("#createModal").modal('show');
        }

        function editPlan(id, name, caption, isBest, harga, disc, jobAds, isQuiz, quiz_applicant, price_quiz_applicant, isPsychoTest, psychoTest_applicant, price_psychoTest_applicant, benefit) {

            $("#name").val(name);
            $("#caption").val(caption);
            $("#price").val(harga);
            $("#discount").val(disc);
            $("#new_price").val(parseInt(harga) - (parseInt(harga * disc / 100)));
            $("#job_ads").val(jobAds);

            if (isBest == 1) {
                $("#best").iCheck('check');
            } else {
                $("#normal").iCheck('check');
            }

            if (isQuiz == 1) {
                $("#isQuiz").iCheck('check');
                $("#quiz_applicant").val(quiz_applicant);
                $("#price_quiz_applicant").val(price_quiz_applicant);
            } else {
                $("#isQuiz").iCheck('uncheck');
                $("#quiz_applicant").val("");
                $("#price_quiz_applicant").val("");
            }

            if (isPsychoTest == 1) {
                $("#isPsychoTest").iCheck('check');
                $("#psychoTest_applicant").val(psychoTest_applicant);
                $("#price_psychoTest_applicant").val(price_psychoTest_applicant);
            } else {
                $("#isPsychoTest").iCheck('uncheck');
                $("#psychoTest_applicant").val("");
                $("#price_psychoTest_applicant").val("");
            }

            tinyMCE.get('benefit').setContent(benefit);

            $("#form-create-plan").prop('action', '{{url('admin/tables/web_contents/plans')}}/' + id + '/update');
            $("#form-create-plan input[name=_method]").val('PUT');
            $("#createModal .modal-title").text('Edit Form');
            $("#btn_create_plan").text('Save Changes');

            $("#createModal").modal('show');
        }

        $('#price').on('blur', function () {
            if ($(this).val() == "" || parseInt($(this).val()) < 0) {
                $(this).val(0);
            }
            price = $(this).val();
            new_price = parseInt(price) - (parseInt(price * discount / 100));
            $("#new_price").val(new_price);
        });

        $('#discount').on('blur', function () {
            if ($(this).val() == "" || parseInt($(this).val()) < 0) {
                $(this).val(0);
            } else if (parseInt($(this).val()) > 100) {
                $(this).val(100);
            }
            discount = $(this).val();
            new_price = parseInt(price) - (parseInt(price * discount / 100));
            $("#new_price").val(new_price);
        });

        $("#isQuiz").on("ifChanged", function () {
            if ($(this).is(':checked')) {
                $("#quiz_applicant,#price_quiz_applicant").prop('disabled', false).prop('required', true);
            } else {
                $("#quiz_applicant,#price_quiz_applicant").prop('disabled', true).prop('required', false);
            }
        });

        $("#quiz_applicant").on("blur", function () {
            if ($(this).val() == "" || parseInt($(this).val()) < 0) {
                $(this).val(0);
            }
        });
        $("#price_quiz_applicant").on("blur", function () {
            if ($(this).val() == "" || parseInt($(this).val()) < 0) {
                $(this).val(0);
            }
        });

        $("#isPsychoTest").on("ifChanged", function () {
            if ($(this).is(':checked')) {
                $("#psychoTest_applicant,#price_psychoTest_applicant").prop('disabled', false).prop('required', true);
            } else {
                $("#psychoTest_applicant,#price_psychoTest_applicant").prop('disabled', true).prop('required', false);
            }
        });

        $("#psychoTest_applicant").on("blur", function () {
            if ($(this).val() == "" || parseInt($(this).val()) < 0) {
                $(this).val(0);
            }
        });
        $("#price_psychoTest_applicant").on("blur", function () {
            if ($(this).val() == "" || parseInt($(this).val()) < 0) {
                $(this).val(0);
            }
        });

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