@extends('layouts.mst_admin')
@section('title', 'Quiz Questions Table &ndash; '.env('APP_NAME').' Admins | '.env('APP_NAME'))
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Quiz Questions
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a onclick="createQuestion()" data-toggle="tooltip" title="Create"
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
                                <th>Topic</th>
                                <th>Question</th>
                                <th>Created at</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($questions as $question)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <strong>{{\App\QuizType::find($question->quiztype_id)->name}}</strong></td>
                                    <td style="vertical-align: middle">{!! $question->question_text !!}</td>
                                    <td style="vertical-align: middle">{{\Carbon\Carbon::parse($question->created_at)->format('j F Y')}}</td>
                                    <td style="vertical-align: middle">{{$question->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='editQuestion("{{$question->id}}")'
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="{{route('quiz.delete.questions',['id'=>encrypt($question->id)])}}"
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
        <div class="modal-dialog modal-lg" style="width: 50%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Create Form</h4>
                </div>
                <form method="post" action="{{route('quiz.create.questions')}}" id="form-quiz-question">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="quiztype_id">Topic <span class="required">*</span></label>
                                <div class="input-group">
                                    <select id="quiztype_id" class="form-control selectpicker"
                                            title="-- Select Topic --" data-live-search="true"
                                            name="quiztype_id" required>
                                        @foreach(\App\QuizType::all() as $topic)
                                            <option value="{{$topic->id}}">{{$topic->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon"><i class="fa fa-star"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="question_text">Question <span class="required">*</span></label>
                                <textarea id="question_text" name="question_text" class="use-tinymce"></textarea>
                            </div>
                        </div>
                        @for($c=1;$c<=5;$c++)
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="option{{$c}}">Option #{{$c}} <span class="required">*</span></label>
                                    <div class="input-group">
                                        <input id="option{{$c}}" name="options[]" class="form-control input-options"
                                               placeholder="Option #{{$c}}" required>
                                        <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                    </div>
                                </div>
                            </div>
                        @endfor
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="correct">Correct Answer <span class="required">*</span></label>
                                <div class="input-group">
                                    <select id="correct" class="form-control selectpicker"
                                            title="-- Select Correct Answer --" data-live-search="true"
                                            name="correct" required>
                                        @for($c=1;$c<=5;$c++)
                                            <option value="{{$c}}">Option #{{$c}}</option>
                                        @endfor
                                    </select>
                                    <span class="input-group-addon"><i class="fa fa-check-circle"></i></span>
                                </div>
                            </div>
                        </div>
                        <input id="option_ids" type="hidden" name="option_ids">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btn_quiz_question">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        function createQuestion() {
            $('#quiztype_id').val('default').selectpicker('refresh');
            tinyMCE.get('question_text').setContent('');

            $(".input-options").val('');
            $('#correct').val('default').selectpicker('refresh');

            $("#form-quiz-question").prop('action', '{{route('quiz.create.questions')}}');
            $("#form-quiz-question input[name=_method]").val('');
            $("#createModal .modal-title").text('Create Form');
            $("#btn_quiz_question").text('Submit');

            $("#createModal").modal('show');
        }

        function editQuestion(id) {
            var option_ids = [];
            $.ajax({
                url: "{{ url('admin/tables/bank_soal/questions') }}" + '/' + id + '/edit',
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $('#quiztype_id').val(data.quiztype_id).selectpicker('refresh');
                    tinyMCE.get('question_text').setContent(data.question_text);

                    $.each(data.options, function (i, val) {
                        i = i + 1;
                        $("#option" + i).val(val.option);
                        option_ids[i - 1] = val.id;
                    });
                    $("#option_ids").val(option_ids);

                    var findIndex = $.map(data.options, function (obj, index) {
                        if (obj.correct == true) {
                            return index;
                        }
                    }), correct = parseInt(findIndex) + 1;

                    $('#correct').val(correct).selectpicker('refresh');

                    $("#form-quiz-question").prop('action', '{{url('admin/tables/bank_soal/questions')}}/' + id + '/update');
                    $("#form-quiz-question input[name=_method]").val('PUT');
                    $("#createModal .modal-title").text('Edit Form');
                    $("#btn_quiz_question").text('Save Changes');

                    $("#createModal").modal('show');
                },
                error: function () {
                    swal({
                        title: 'Bank Soal',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        }

        $("#form-quiz-question").on('submit', function (e) {
            e.preventDefault();
            if (tinyMCE.get('question_text').getContent() == "") {
                swal({
                    title: 'ATTENTION!',
                    text: 'Question field can\'t be null!',
                    type: 'warning',
                    timer: '3500'
                });

            } else {
                $(this)[0].submit();
            }
        });
    </script>
@endpush