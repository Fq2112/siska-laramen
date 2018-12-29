@extends('layouts.mst_admin')
@section('title', 'Quiz List &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 id="panel_title">Quiz
                            <small>List</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="btn_quiz" data-toggle="tooltip" title="Create" data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" id="content1">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Vacancy</th>
                                <th>Quiz Details</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($infos as $info)
                                @php
                                    $vacancy = $info->getVacancy;
                                    $quizDate = $vacancy->quizDate_start && $vacancy->quizDate_end != "" ?
                                    \Carbon\Carbon::parse($vacancy->quizDate_start)->format('j F Y')." - ".
                                    \Carbon\Carbon::parse($vacancy->quizDate_end)->format('j F Y') : '-';
                                    $agency = $vacancy->agencies;
                                    $userAgency = $agency->user;
                                    $ava = $userAgency->ava == ""||$userAgency->ava == "agency.png" ?
                                    asset('images/agency.png') : asset('storage/users/'.$userAgency->ava);
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="{{route('agency.profile',['id' => $agency->id])}}"
                                                       target="_blank"
                                                       style="float: left;margin-right: .5em;margin-bottom: 0">
                                                        <img class="img-responsive" width="100" src="{{$ava}}">
                                                    </a>
                                                    <table style="margin: 0">
                                                        <tr>
                                                            <td>
                                                                <a href="{{route('detail.vacancy',['id' =>
                                                                $vacancy->id])}}" target="_blank">
                                                                    <strong>{{$vacancy->judul}}</strong>
                                                                </a> &ndash;
                                                                <a href="{{route('agency.profile',['id' => $agency->id])}}"
                                                                   target="_blank">
                                                                    {{$userAgency->name}}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span data-toggle="tooltip" data-placement="left"
                                                                      title="Recruitment Date"
                                                                      class="label label-default">
                                                                    <strong><i class="fa fa-users"></i>&ensp;
                                                                        {{$vacancy->recruitmentDate_start != "" &&
                                                                        $vacancy->recruitmentDate_end != "" ?
                                                                        \Carbon\Carbon::parse
                                                                        ($vacancy->recruitmentDate_start)
                                                                        ->format('j F Y').' - '.\Carbon\Carbon::parse
                                                                        ($vacancy->recruitmentDate_end)
                                                                        ->format('j F Y') : 'Unknown'}}
                                                                    </strong>
                                                                </span>&nbsp;|
                                                                <span data-toggle="tooltip" data-placement="right"
                                                                      title="Online Quiz (TPA & TKD) Date"
                                                                      class="label label-danger">
                                                                        <strong><i class="fa fa-grin-beam"></i>&ensp;
                                                                            {{$quizDate}}
                                                                        </strong>
                                                                    </span>&nbsp;
                                                                <hr style="margin: .5em auto">
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Psycho Test (Online Interview) Date"
                                                                      class="label label-default">
                                                                        <strong><i class="fa fa-comments"></i>&ensp;
                                                                            {{$vacancy->psychoTestDate_start &&
                                                                            $vacancy->psychoTestDate_end != "" ?
                                                                            \Carbon\Carbon::parse($vacancy
                                                                            ->psychoTestDate_start)->format('j F Y').
                                                                            " - ".\Carbon\Carbon::parse($vacancy
                                                                            ->psychoTestDate_end)->format('j F Y') :
                                                                            'Unknown'}}
                                                                        </strong>
                                                                    </span>&nbsp;|
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Job Interview Date"
                                                                      class="label label-default">
                                                                    <strong><i class="fa fa-user-tie"></i>&ensp;
                                                                        {{$vacancy->interview_date != "" ?
                                                                        \Carbon\Carbon::parse($vacancy->interview_date)
                                                                        ->format('l, j F Y') : 'Unknown'}}
                                                                    </strong>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <hr style="margin: .5em auto">
                                        <table>
                                            <tr>
                                                <td><i class="fa fa-paper-plane"></i>&nbsp;</td>
                                                <td>Total Applicant</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{\App\Accepting::where('vacancy_id',$vacancy->id)
                                                ->where('isApply',true)->count()}} applicants
                                                </td>
                                            </tr>
                                            <tr style="font-weight: 600">
                                                <td><i class="fa fa-grin-beam"></i>&nbsp;</td>
                                                <td>Total Participant for Quiz with {{$vacancy->passing_grade}} passing
                                                    grade
                                                </td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$vacancy->quiz_applicant}} persons</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-comments"></i>&nbsp;</td>
                                                <td>Total Participant for Psycho Test</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$vacancy->psychoTest_applicant}} persons</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <table>
                                            <tr>
                                                <td><i class="fa fa-shield-alt"></i>&nbsp;</td>
                                                <td>Quiz Code</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td><strong>{{$info->unique_code}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-question-circle"></i>&nbsp;</td>
                                                <td><strong>{{$info->total_question}}</strong> Questions</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>
                                                    <ul style="margin-left: -1.5em;margin-top: .5em;">
                                                        @foreach($types as $type)
                                                            @php $q = \App\QuizQuestions::whereIn('id',$info->question_ids)
                                                            ->where('quiztype_id',$type->id)->count(); @endphp
                                                            <li><strong>{{$q}}</strong> {{$type->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-stopwatch"></i>&nbsp;</td>
                                                <td>Time Limit</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td><strong>{{$info->time_limit}}</strong> minutes</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick="editQuiz('{{$info->id}}','{{$info->unique_code}}',
                                                '{{$info->time_limit}}','{{$info->total_question}}',
                                                '{{implode(",",$info->question_ids)}}','{{$vacancy->id}}')"
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="{{route('quiz.delete.info',['id'=>encrypt($info->id)])}}"
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
                        <form method="post" action="{{route('quiz.create.info')}}" id="form-quiz-setup">
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
                                    <span style="color: #fa5555">P.S.: You can only select vacancy that its quiz
                                        hasn't been set yet (except when editing).</span>
                                </div>
                            </div>
                            <hr class="hr-divider" id="vacancySetupDivider" style="display:none">
                            <img src="{{asset('images/loading2.gif')}}" id="image"
                                 class="img-responsive ld ld-fade" style="display:none">
                            <div id="input_quiz_setup"></div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary btn-block" id="btn_quiz_submit">
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
        $(function () {
            @if($findVac != null)
            $(".btn_quiz").click();
            @foreach($findVac as $row)
            $("#vacancy_id option[value='{{$row}}']").attr('selected', 'selected');
            @endforeach
            $('#vacancy_id option:selected').each(function (i, selected) {
                setTimeout(loadVacancyData('{{implode(',',$findVac->toArray())}}'), 1000);
            });
            $("#vacancy_id").selectpicker('refresh');
            $("#vacancySetupDivider").css('display', 'block');
            @endif
        });

        $(".btn_quiz").on("click", function () {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $(".btn_quiz i").toggleClass('fa-plus fa-th-list');

            $(".btn_quiz[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            }).tooltip('show');

            $("#panel_title").html(function (i, v) {
                return v === "Quiz Setup<small>Form</small>" ? "Quiz <small>List</small>" : "Quiz Setup<small>Form</small>";
            });

            $("#vacancySetupDivider").css('display', 'none');
            $("#input_quiz_setup").html('');
            $("#btn_quiz_submit").html("<strong>SUBMIT</strong>");

            @foreach($vacancies as $vacancy)
            var options = $("#vacancy_id option[value='{{$vacancy->id}}']");
            @if($vacancy->getQuizInfo != null)
            options.attr("disabled", "disabled");
            @else
            options.removeAttr("disabled");
            @endif
            @endforeach
            $("#vacancy_id").val('default').attr('name', 'vacancy_ids[]')
                .selectpicker({maxOptions: '{{count($vacancies)}}'}).selectpicker('refresh');

            $("#form-quiz-setup").attr('action', '{{route('quiz.create.info')}}');
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
                    $('#input_quiz_setup').hide();
                },
                complete: function () {
                    $('#image').hide();
                    $('#input_quiz_setup').show();
                },
                success: function (data) {
                    var input_quiz_setup = '';
                    $.each(data, function (i, val) {
                        input_quiz_setup +=
                            '<div class="row form-group" style="margin-bottom: 0;margin-top: 1.5em">' +
                            '<div class="col-lg-12">' +
                            '<label style="font-size: 18px">' + val.judul + '</label>' +
                            '</div></div>' +
                            '<div class="row form-group">' +
                            '<div class="col-lg-4">' +
                            '<label for="unique_code">Quiz Code <span class="required">*</span></label>' +
                            '<div class="input-group">' +
                            '<span class="input-group-btn">' +
                            '<button type="button" class="btn btn-dark quizCodes" id="btn_code' + val.id + '" ' +
                            'onclick="generateCodeBtn(' + val.id + ')"><i class="fa fa-sync"></i></button></span>' +
                            '<input id="unique_code' + val.id + '" name="unique_code[]" type="text" ' +
                            'class="form-control" maxlength="6" readonly required>' +
                            '<span class="input-group-addon"><i class="fa fa-shield-alt"></i></span>' +
                            '</div></div>' +
                            '<div class="col-lg-4">' +
                            '<label for="total_question">Total Question <span class="required">*</span></label>' +
                            '<div class="input-group">' +
                            '<span class="input-group-addon"><i class="fa fa-list-ol"></i></span>' +
                            '<input id="total_question' + val.id + '" name="total_question[]" class="form-control" ' +
                            'type="text" placeholder="10" maxlength="3" onkeypress="return numberOnly(event, false)" ' +
                            'value="1" onchange="totalQuestion(' + val.id + ')" required>' +
                            '</div></div>' +
                            '<div class="col-lg-4">' +
                            '<label for="time_limit">Time Limit <span class="required">*</span></label>' +
                            '<div class="input-group">' +
                            '<span class="input-group-addon"><i class="fa fa-stopwatch"></i></span>' +
                            '<input id="time_limit' + val.id + '" name="time_limit[]" class="form-control" ' +
                            'type="text" placeholder="in minutes" maxlength="3" ' +
                            'onkeypress="return numberOnly(event, false)" required>' +
                            '</div></div></div>' +
                            '<div class="row form-group" id="questionList' + val.id + '">' +
                            '<div class="col-lg-12">' +
                            '<label for="question_ids">Questions <span class="required">*</span></label>' +
                            '<div class="input-group">' +
                            '<span class="input-group-addon"><i class="fa fa-question-circle"></i></span>' +
                            '<select id="question_ids' + val.id + '" class="form-control selectpicker" ' +
                            'data-max-options="1" title="-- Select Questions --" data-live-search="true" ' +
                            'name="question_ids[' + val.id + '][]" data-selected-text-format="count > 2" ' +
                            'onchange="quizQuestions(' + val.id + ')" multiple required>' +
                            '@foreach($types as $type)' +
                            '<optgroup label="{{$type->name}}">' +
                            '@foreach($type->getQuizQuestions as $question)' +
                            '<option value="{{$question->id}}">{!!$question->question_text!!}</option>@endforeach' +
                            '</optgroup>' +
                            '@endforeach' +
                            '</select></div><span class="help-block"><small id="quiz_errorTxt' + val.id + '" ' +
                            'style="text-transform: none;float: left"></small></span></div></div>'
                    });
                    $("#input_quiz_setup").html(input_quiz_setup);
                    $(".quizCodes").click();
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
            $("#unique_code" + id).val(generateCode());
        }

        function totalQuestion(id) {
            if (parseInt($("#total_question" + id).val()) <= 0 || $("#total_question" + id).val() == "") {
                $("#total_question" + id).val(1);
                $("#question_ids" + id).val('default').selectpicker({maxOptions: 1}).selectpicker('refresh');

            } else {
                $("#question_ids" + id).val('default')
                    .selectpicker({maxOptions: parseInt($("#total_question" + id).val())}).selectpicker('refresh');
            }

            $("#questionList" + id).removeClass('has-error');
            $("#quiz_errorTxt" + id).text('');
        }

        function quizQuestions(id) {
            if ($("#question_ids" + id + " :selected").length < parseInt($("#total_question" + id).val())) {
                $("#questionList" + id).addClass('has-error');
                $("#quiz_errorTxt" + id).text('Total question you\'ve entered doesn\'t match with ' +
                    'the question that you select!');
            } else {
                $("#questionList" + id).removeClass('has-error');
                $("#quiz_errorTxt" + id).text('');
            }
        }

        function editQuiz(id, code, time, total, questions, vacancy) {
            $(".btn_quiz i").toggleClass('fa-plus fa-th-list');
            $(".btn_quiz[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            });
            $("#panel_title").html(function (i, v) {
                return v === "Quiz Edit<small>Form</small>" ? "Quiz <small>List</small>" : "Quiz Edit<small>Form</small>";
            });
            $("#vacancySetupDivider").css('display', 'none');
            $("#content1").toggle(300);
            $("#content2").toggle(300);

            $("#input_quiz_setup").html(
                '<div class="row form-group">' +
                '<div class="col-lg-4">' +
                '<label for="unique_code">Quiz Code <span class="required">*</span></label>' +
                '<div class="input-group">' +
                '<span class="input-group-btn">' +
                '<button type="button" class="btn btn-dark" id="btn_code"><i class="fa fa-sync"></i></button>' +
                '</span><input id="unique_code" name="unique_code" type="text" class="form-control" ' +
                'maxlength="6" readonly required>' +
                '<span class="input-group-addon"><i class="fa fa-shield-alt"></i></span>' +
                '</div></div>' +
                '<div class="col-lg-4">' +
                '<label for="total_question">Total Question <span class="required">*</span></label>' +
                '<div class="input-group">' +
                '<span class="input-group-addon"><i class="fa fa-list-ol"></i></span>' +
                '<input id="total_question" name="total_question" class="form-control" type="text" ' +
                'placeholder="10" maxlength="3" onkeypress="return numberOnly(event, false)" value="1" required>' +
                '</div></div>' +
                '<div class="col-lg-4">' +
                '<label for="time_limit">Time Limit <span class="required">*</span></label>' +
                '<div class="input-group">' +
                '<span class="input-group-addon"><i class="fa fa-stopwatch"></i></span>' +
                '<input id="time_limit" name="time_limit" class="form-control" type="text" ' +
                'placeholder="in minutes" maxlength="3" onkeypress="return numberOnly(event, false)" required>' +
                '</div></div></div>' +
                '<div class="row form-group" id="questionList">' +
                '<div class="col-lg-12"><label for="question_ids">Questions <span class="required">*</span></label>' +
                '<div class="input-group">' +
                '<span class="input-group-addon"><i class="fa fa-question-circle"></i></span>' +
                '<select id="question_ids" class="form-control selectpicker" data-max-options="1" ' +
                'title="-- Select Questions --" data-live-search="true" name="question_ids[]" ' +
                'data-selected-text-format="count > 2" multiple required>' +
                '@foreach($types as $type)' +
                '<optgroup label="{{$type->name}}">' +
                '@foreach($type->getQuizQuestions as $question)' +
                '<option value="{{$question->id}}">{!!$question->question_text!!}</option>@endforeach' +
                '</optgroup>' +
                '@endforeach' +
                '</select></div><span class="help-block"><small class="quiz_errorTxt" ' +
                'style="text-transform: none;float: left"></small></span></div></div>'
            );
            $("#unique_code").val(code);
            $("#time_limit").val(time);
            $("#vacancy_id option[value=" + vacancy + "]").removeAttr('disabled');
            $("#vacancy_id").val(vacancy).attr('name', 'vacancy_id').selectpicker({maxOptions: 1}).selectpicker('refresh');

            $("#btn_code").on("click", function () {
                $("#unique_code").val(generateCode());
            });

            var total_question = total;
            $("#total_question").val(total).on("change", function () {
                if (parseInt($(this).val()) <= 0 || $(this).val() == "") {
                    $(this).val(1);
                }
                total_question = $(this).val();
                $("#question_ids").val('default').selectpicker({maxOptions: total_question}).selectpicker('refresh');
                $("#questionList").removeClass('has-error');
                $(".quiz_errorTxt").text('');
            });

            $("#question_ids").val(questions.split(",")).selectpicker({maxOptions: total}).selectpicker('refresh')
                .on("change", function () {
                    if ($("#question_ids :selected").length < total_question) {
                        $("#questionList").addClass('has-error');
                        $(".quiz_errorTxt").text('Total question you\'ve entered doesn\'t match with ' +
                            'the question that you select!');
                    } else {
                        $("#questionList").removeClass('has-error');
                        $(".quiz_errorTxt").text('');
                    }
                });

            $("#form-quiz-setup input[name='_method']").val('PUT');
            $("#btn_quiz_submit").html("<strong>SAVE CHANGES</strong>");

            $("#form-quiz-setup").attr("action", "{{ url('admin/quiz') }}/" + id + "/update");
        }

        $("#form-quiz-setup").on("submit", function (e) {
            e.preventDefault();
            if ($("#input_quiz_setup").find('.has-error').length == 0) {
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