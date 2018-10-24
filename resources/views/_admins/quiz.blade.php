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
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
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
                                <th>#Code</th>
                                <th>Topic</th>
                                <th>Questions</th>
                                <th>Time Limit</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($infos as $info)
                                @php $questions = \App\QuizQuestions::whereIn('id',$info->question_ids)->get(); @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <strong>{{$info->unique_code}}</strong></td>
                                    <td style="vertical-align: middle" align="center">
                                        <strong>{{\App\QuizType::find($info->quiztype_id)->name}}</strong></td>
                                    <td style="vertical-align: middle">
                                        <ol>
                                            @foreach($questions as $question)
                                                @php $options = \App\QuizOptions::where('question_id',$question->id)->get() @endphp
                                                <li>
                                                    <strong>{{$question->question_text}}</strong>
                                                    <ul>
                                                        @foreach($options as $option)
                                                            <li style="font-weight: {{$option->correct == true ? 'bold' : 'normal'}}">{{$option->correct == true ?
                                                            $option->option.' (correct answer)' : $option->option}}</li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <strong>{{$info->time_limit}}</strong> minutes
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick="editQuiz('{{$info->id}}','{{$info->unique_code}}',
                                                '{{$info->quiztype_id}}','{{$info->time_limit}}',
                                                '{{$info->total_question}}','{{implode(",",$info->question_ids)}}')"
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
                        <form method="post" action="{{route('quiz.create.info')}}" id="form-quiz">
                            {{csrf_field()}}
                            <input type="hidden" name="_method">
                            <div class="row form-group">
                                <div class="col-lg-3 has-feedback">
                                    <label for="unique_code">Quiz Code <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                          <button type="button" class="btn btn-dark" id="btn_code">
                                              <i class="fa fa-sync"></i></button>
                                        </span>
                                        <input id="unique_code" name="unique_code" type="text" class="form-control"
                                               maxlength="6" readonly required>
                                    </div>
                                    <span class="fa fa-shield-alt form-control-feedback right"
                                          aria-hidden="true"></span>
                                </div>
                                <div class="col-lg-5 has-feedback">
                                    <label for="quiztype_id">Topic <span class="required">*</span></label>
                                    <select id="quiztype_id" class="form-control" name="quiztype_id" required>
                                        <option value="">-- Choose --</option>
                                        @foreach(\App\QuizType::all() as $topic)
                                            <option value="{{$topic->id}}">{{$topic->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="fa fa-star form-control-feedback right"
                                          aria-hidden="true"></span>
                                </div>
                                <div class="col-lg-2 has-feedback">
                                    <label for="time_limit">Time Limit <span class="required">*</span></label>
                                    <input id="time_limit" name="time_limit" class="form-control" type="text"
                                           placeholder="in minutes" maxlength="3"
                                           onkeypress="return numberOnly(event, false)"
                                           required>
                                    <span class="fa fa-clock form-control-feedback right"
                                          aria-hidden="true"></span>
                                </div>
                                <div class="col-lg-2 has-feedback">
                                    <label for="total_question">Total Question <span class="required">*</span></label>
                                    <input id="total_question" name="total_question" class="form-control" type="text"
                                           placeholder="10" maxlength="3" onkeypress="return numberOnly(event, false)"
                                           value="1" required>
                                    <span class="fa fa-list-ol form-control-feedback right"
                                          aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12" id="select-question"></div>
                            </div>
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
        $(".btn_quiz").on("click", function () {
            $(".btn_quiz i").toggleClass('fa-plus fa-th-list');
            $(".btn_quiz[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            }).tooltip('show');

            $("#panel_title").html(function (i, v) {
                return v === "Quiz Setup<small>Form</small>" ? "Quiz <small>List</small>" : "Quiz Setup<small>Form</small>";
            });

            $("#btn_quiz_submit").html("<strong>SUBMIT</strong>");
            $("#form-quiz")[0].reset();
            $("#unique_code").val(generateCode());
            $("#select-question").empty().append("");

            $("#content1").toggle(300);
            $("#content2").toggle(300);
        });

        $("#btn_code").on("click", function () {
            $("#unique_code").val(generateCode());
        });

        function generateCode() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < 6; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }

        $("#quiztype_id").on("change", function () {
            $("#total_question").val(1);
            $.get('{{url('/admin/quiz/question')}}/' + $(this).val() + '/load', function (data) {
                var $result = '';
                $result +=
                    '<label for="question_ids">Questions <span class="required">*</span></label>' +
                    '<select id="question_ids" class="form-control selectpicker" data-max-options="1" ' +
                    'title="-- Select Questions --" data-live-search="true" name="question_ids[]" ' +
                    'data-selected-text-format="count > 3" multiple required>';
                $.each(data, function (i, val) {
                    $result += '<option value="' + val.id + '">' + val.question_text + '</option>'
                });
                $result += '</select>';
                $("#select-question").empty().append($result);
                $('.selectpicker').selectpicker();
            });
        });

        var total_question = "";
        $("#total_question").on("blur", function () {
            if ($(this).val() == "0" || $(this).val() == "") {
                $(this).val(1);
            }
            total_question = $(this).val();
            $("#question_ids").val('default').selectpicker({maxOptions: total_question}).selectpicker('refresh');
        });

        function editQuiz(id, code, topic, time, total, questions) {
            $(".btn_quiz i").toggleClass('fa-plus fa-th-list');
            $(".btn_quiz[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            });

            $("#panel_title").html(function (i, v) {
                return v === "Quiz Setup<small>Form</small>" ? "Quiz <small>List</small>" : "Quiz Setup<small>Form</small>";
            });

            $("#content1").toggle(300);
            $("#content2").toggle(300);

            $("#form-quiz").attr("action", "{{ url('admin/quiz') }}/" + id + "/update");
            $("#form-quiz input[name='_method']").val('PUT');
            $("#unique_code").val(code);
            $("#quiztype_id").val(topic);
            $("#time_limit").val(time);
            $("#total_question").val(total);
            $("#btn_quiz_submit").html("<strong>SAVE CHANGES</strong>");

            $.get('{{url('/admin/quiz/question')}}/' + topic + '/load', function (data) {
                var $result = '';
                $result +=
                    '<label for="question_ids">Questions <span class="required">*</span></label>' +
                    '<select id="question_ids" class="form-control selectpicker" data-max-options="' + total + '" ' +
                    'title="-- Select Questions --" data-live-search="true" name="question_ids[]" ' +
                    'data-selected-text-format="count > 3" multiple required>';
                $.each(data, function (i, val) {
                    $result += '<option value="' + val.id + '">' + val.question_text + '</option>'
                });
                $result += '</select>';
                $("#select-question").empty().append($result);

                $.each(questions.split(","), function (i, e) {
                    $("#question_ids option[value='" + e + "']").prop("selected", true);
                });

                $('.selectpicker').selectpicker();
            });
        }
    </script>
@endpush