@extends('layouts.mst_admin')
@section('title', 'Quiz Questions Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
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
                                    <td style="vertical-align: middle">{{$question->question_text}}</td>
                                    <td style="vertical-align: middle">{{\Carbon\Carbon::parse($question->created_at)->format('j F Y')}}</td>
                                    <td style="vertical-align: middle">{{$question->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='editQuestion("{{$question->id}}","{{$question->quiztype_id}}",
                                                "{{$question->question_text}}")'
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
                <form method="post" action="{{route('quiz.create.questions')}}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
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
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="question_text">Question <span class="required">*</span></label>
                                <textarea id="question_text" name="question_text" class="form-control"
                                          placeholder="Question" style="resize: vertical" required></textarea>
                                <span class="fa fa-question-circle form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                        </div>
                        @for($i=1;$i<=5;$i++)
                            <div class="row form-group">
                                <div class="col-lg-12 has-feedback">
                                    <label for="option{{$i}}">Option #{{$i}} <span class="required">*</span></label>
                                    <input id="option{{$i}}" name="option{{$i}}" class="form-control"
                                           placeholder="Option #{{$i}}" required>
                                    <span class="fa fa-list-ul form-control-feedback right" aria-hidden="true"></span>
                                </div>
                            </div>
                        @endfor
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="correct">Correct Answer <span class="required">*</span></label>
                                <select id="correct" name="correct" class="form-control" required>
                                    <option value="">-- Choose --</option>
                                    @for($i=1;$i<=5;$i++)
                                        <option value="option{{$i}}">Option #{{$i}}</option>
                                    @endfor
                                </select>
                                <span class="fa fa-check-circle form-control-feedback right" aria-hidden="true"></span>
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
        <div class="modal-dialog modal-lg" style="width: 50%">
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
        function createQuestion() {
            $("#createModal").modal('show');
        }

        function editQuestion(id, topic, question) {
            $('#editModalContent').html(
                '<form method="post" id="' + id + '" action="{{url('admin/tables/bank_soal/questions')}}/' + id + '/update">' +
                '{{csrf_field()}} {{method_field('PUT')}}' +
                '<div class="modal-body">' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="quiztype_id' + id + '">Topic <span class="required">*</span></label>' +
                '<select id="quiztype_id' + id + '" class="form-control" name="quiztype_id" required></select>' +
                '<span class="fa fa-star form-control-feedback right" aria-hidden="true"></span></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="question_text' + id + '">Question <span class="required">*</span></label>' +
                '<textarea id="question_text' + id + '" name="question_text" class="form-control" ' +
                'placeholder="Question" style="resize: vertical" required>' + question + '</textarea>' +
                '<span class="fa fa-question-circle form-control-feedback right" aria-hidden="true"></span>' +
                '</div></div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Save changes</button></div></form>'
            );

            $.get('/admin/quiz/topics/load', function (data) {
                var $attr, $result = '';
                $.each(data, function (i, val) {
                    $attr = val.id == topic ? 'selected' : '';
                    $result += '<option value="' + val.id + '" ' + $attr + '>' + val.name + '</option>';
                });
                $("#quiztype_id" + id).empty().append($result);
            });

            $("#editModal").modal('show');
        }
    </script>
@endpush