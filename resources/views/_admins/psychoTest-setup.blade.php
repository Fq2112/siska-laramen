@extends('layouts.mst_admin')
@section('title', 'Psycho Test List &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 id="panel_title">Psycho Test
                            <small>List</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="btn_psychoTest" data-toggle="tooltip" title="Create" data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" id="content1">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Room Code</th>
                                <th>Vacancy</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($infos as $info)
                                @php
                                    $vacancy = $info->getVacancy;
                                    $agency = $vacancy->agencies;
                                    $userAgency = $agency->user;
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        @if($rooms)
                                            <ul>
                                                @foreach ($rooms as $room)
                                                    <li>
                                                        <a href="{{route('join.psychoTest.room',['roomName' => $room])}}"
                                                           target="_blank">{{$room}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle">
                                        <i class="fa fa-briefcase"></i>
                                        <a href="{{route('detail.vacancy',['id'=>$vacancy->id])}}">
                                            <strong>{{$vacancy->judul}}</strong></a> &ndash;
                                        <a href="{{route('agency.profile',['id'=>$agency->id])}}">{{$userAgency->name}}
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a onclick="editPsychoTest('{{$info->id}}','{{$info->room_code}}','{{$vacancy->id}}')"
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="{{route('psychoTest.delete.info',['id'=>encrypt($info->id)])}}"
                                           class="btn btn-danger btn-sm delete-data" style="font-size: 16px"
                                           data-toggle="tooltip"
                                           title="Delete" data-placement="right"><i class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="x_content" id="content2" style="display: none">
                        <form method="post" action="{{route('psychoTest.create.info')}}" id="form-psychoTest-setup">
                            {{csrf_field()}}
                            <input type="hidden" name="_method">
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="vacancy_id">Vacancy <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                        <select id="vacancy_id" class="form-control selectpicker"
                                                title="-- Select Vacancy --" data-live-search="true"
                                                data-selected-text-format="count > 3" name="vacancy_ids[]"
                                                multiple required>
                                            @foreach($vacancies as $vacancy)
                                                <option value="{{$vacancy->id}}">{{$vacancy->judul}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr class="hr-divider" id="vacancySetupDivider" style="display:none">
                            <img src="{{asset('images/loading2.gif')}}" id="image"
                                 class="img-responsive ld ld-fade" style="display:none">
                            <div id="input-psychoTest-setup"></div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary btn-block" id="btn_psychoTest_submit">
                                        <strong>SUBMIT</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        @if($findVac != null)
        $(function () {
            $(".btn_psychoTest").click();
            @foreach($findVac as $row)
            $("#vacancy_id option[value='{{$row}}']").attr('selected', 'selected');
            @endforeach
            $('#vacancy_id option:selected').each(function (i, selected) {
                setTimeout(loadVacancyData('{{implode(',',$findVac->toArray())}}'), 1000);
            });
            $("#vacancy_id").selectpicker('refresh');
            $("#vacancySetupDivider").css('display', 'block');
        });
        @endif

        $(".btn_psychoTest").on("click", function () {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $(".btn_psychoTest i").toggleClass('fa-plus fa-th-list');

            $(".btn_psychoTest[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            }).tooltip('show');

            $("#panel_title").html(function (i, v) {
                return v === "Psycho Test Setup<small>Form</small>" ? "Psycho Test <small>List</small>" :
                    "Psycho Test Setup<small>Form</small>";
            });

            $("#vacancySetupDivider").css('display', 'none');
            $("#input-psychoTest-setup").html('');
            $("#btn_psychoTest_submit").html("<strong>SUBMIT</strong>");

            $("#vacancy_id").val('default').attr('name', 'vacancy_ids[]')
                .selectpicker({maxOptions: '{{count($vacancies)}}'}).selectpicker('refresh');

            $("#form-psychoTest-setup").attr('action', '{{route('psychoTest.create.info')}}');
        });

        $("#vacancy_id").on("change", function () {
            var $id = $(this).val();
            $('#vacancy_id option:selected').each(function (i, selected) {
                setTimeout(loadVacancyData($id), 1000);
                $("#vacancySetupDivider").css('display', 'block');
            });
        });

        function loadVacancyData($id) {
            $.ajax({
                url: '{{route('quiz.vacancy.info',['id' => ''])}}/' + $id,
                type: "GET",
                data: $("#vacancy_id"),
                beforeSend: function () {
                    $('#image').show();
                    $('#input-psychoTest-setup').hide();
                },
                complete: function () {
                    $('#image').hide();
                    $('#input-psychoTest-setup').show();
                },
                success: function (data) {
                    var input_psychoTest_setup = '';
                    $.each(data, function (i, val) {
                        input_psychoTest_setup +=
                            '<div class="row form-group" style="margin-bottom: 0;margin-top: 1.5em">' +
                            '<div class="col-lg-12">' +
                            '<label style="font-size: 18px">' + val.judul + '</label>' +
                            '</div></div>' +
                            '<div class="row form-group">' +
                            '<div class="col-lg-12">' +
                            '<label for="room_code">Room Code <span class="required">*</span></label>' +
                            '<div class="input-group">' +
                            '<span class="input-group-btn">' +
                            '<button type="button" class="btn btn-dark psychoTestCodes" id="btn_code' + val.id + '" ' +
                            'onclick="generateCodeBtn(' + val.id + ')"><i class="fa fa-sync"></i></button></span>' +
                            '<input id="room_code' + val.id + '" name="room_code[]" type="text" ' +
                            'class="form-control" maxlength="6" readonly required>' +
                            '<span class="input-group-addon"><i class="fa fa-shield-alt"></i></span></div>' +
                            '</div></div>'
                    });
                    $("#input-psychoTest-setup").html(input_psychoTest_setup);
                    $(".psychoTestCodes").click();
                    $(".selectpicker").selectpicker('render');
                },
                error: function () {
                    swal({
                        title: 'Oops...',
                        text: 'Something went wrong! Please refresh the page.',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
            return false;
        }

        function generateCodeBtn(id) {
            $("#room_code" + id).val(id + '_' + generateCode());
        }

        function editPsychoTest(id, code, time, total, questions, vacancy) {
            $(".btn_psychoTest i").toggleClass('fa-plus fa-th-list');
            $(".btn_psychoTest[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            });
            $("#panel_title").html(function (i, v) {
                return v === "Psycho Test Setup<small>Form</small>" ? "Psycho Test <small>List</small>" :
                    "Psycho Test Setup<small>Form</small>";
            });
            $("#vacancySetupDivider").css('display', 'none');
            $("#content1").toggle(300);
            $("#content2").toggle(300);

            $("#input-psychoTest-setup").html(
                '<div class="row form-group">' +
                '<div class="col-lg-12">' +
                '<label for="room_code">Room Code <span class="required">*</span></label>' +
                '<div class="input-group">' +
                '<span class="input-group-btn">' +
                '<button type="button" class="btn btn-dark" id="btn_code"><i class="fa fa-sync"></i></button>' +
                '</span><input id="room_code" name="room_code" type="text" class="form-control" ' +
                'maxlength="6" readonly required>' +
                '<span class="input-group-addon"><i class="fa fa-shield-alt"></i></span>' +
                '</div></div></div>'
            );
            $("#room_code").val(code);
            $("#vacancy_id").val(vacancy).attr('name', 'vacancy_id').selectpicker({maxOptions: 1}).selectpicker('refresh');

            $("#btn_code").on("click", function () {
                $("#room_code").val(generateCode());
            });

            $("#form-psychoTest-setup input[name='_method']").val('PUT');
            $("#btn_psychoTest_submit").html("<strong>SAVE CHANGES</strong>");

            $("#form-psychoTest-setup").attr("action", "{{ url('admin/psychoTest') }}/" + id + "/update");
        }

        $("#form-psychoTest-setup").on("submit", function (e) {
            e.preventDefault();
            if ($("#input-psychoTest-setup").find('.has-error').length == 0) {
                $(this)[0].submit();
            }
        });

        function generateCode() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < 6; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }
    </script>
@endpush

