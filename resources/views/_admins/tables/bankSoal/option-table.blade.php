@extends('layouts.mst_admin')
@section('title', 'Quiz Options Table &ndash; SISKA Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Quiz Options
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a onclick="createOption()" data-toggle="tooltip" title="Create" data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Question</th>
                                <th>Option</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($options as $option)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <strong>{{\App\QuizQuestions::find($option->question_id)->question_text}}</strong>
                                    </td>
                                    <td style="vertical-align: middle">{{$option->option}}</td>
                                    <td style="vertical-align: middle;text-transform: uppercase" align="center">
                                        <span class="label label-{{$option->correct == true ? 'success' : 'danger'}}">
                                            {{$option->correct == true ? 'Correct' : 'Incorrect'}}</span>
                                    </td>
                                    <td style="vertical-align: middle">{{\Carbon\Carbon::parse($option->created_at)->format('j F Y')}}</td>
                                    <td style="vertical-align: middle">{{$option->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='editOption("{{$option->id}}","{{$option->question_id}}",
                                                "{{$option->option}}","{{$option->correct}}")'
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="{{route('quiz.delete.options',['id'=>encrypt($option->id)])}}"
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
                <form method="post" action="{{route('quiz.create.options')}}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="question_id">Question <span class="required">*</span></label>
                                <select id="question_id" class="form-control" name="question_id" required>
                                    <option value="">-- Choose --</option>
                                    @foreach(\App\QuizQuestions::all() as $question)
                                        <option value="{{$question->id}}">{{$question->question_text}}</option>
                                    @endforeach
                                </select>
                                <span class="fa fa-question-circle form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-10 has-feedback">
                                <label for="option">Option <span class="required">*</span></label>
                                <input id="option" name="option" class="form-control" placeholder="Option" required>
                                <span class="fa fa-list-ul form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-2 has-feedback">
                                <label for="correct">Status <span class="required">*</span></label>
                                <label><input type="checkbox" name="correct" class="flat" id="correct" value="1">
                                    Correct</label>
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
        function createOption() {
            $("#createModal").modal('show');
        }

        function editOption(id, question, option, correct) {
            $('#editModalContent').html(
                '<form method="post" id="' + id + '" action="{{url('admin/tables/bank_soal/options')}}/' + id + '/update">' +
                '{{csrf_field()}} {{method_field('PUT')}}' +
                '<div class="modal-body">' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="question_id' + id + '">Question <span class="required">*</span></label>' +
                '<select id="question_id' + id + '" class="form-control" name="question_id" required></select>' +
                '<span class="fa fa-question-circle form-control-feedback right" aria-hidden="true"></span></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-10 has-feedback">' +
                '<label for="option' + id + '">Option <span class="required">*</span></label>' +
                '<input id="option' + id + '" name="option" class="form-control" placeholder="Option" ' +
                'value="' + option + '" required>' +
                '<span class="fa fa-list-ul form-control-feedback right" aria-hidden="true"></span></div>' +
                '<div class="col-lg-2 has-feedback">' +
                '<label for="correct' + id + '">Status <span class="required">*</span></label>' +
                '<label><input type="checkbox" name="correct" class="flat iCheck" ' +
                'id="correct' + id + '" value="1"> Correct</label></div></div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Save changes</button></div></form>'
            );

            $.get('/admin/quiz/questions/load', function (data) {
                var $attr, $result = '';
                $.each(data, function (i, val) {
                    $attr = val.id == question ? 'selected' : '';
                    $result += '<option value="' + val.id + '" ' + $attr + '>' + val.question_text + '</option>';
                });
                $("#question_id" + id).empty().append($result);
            });

            $('.iCheck').iCheck({checkboxClass: 'icheckbox_flat-green', radioClass: 'iradio_flat-green'});
            if (correct == 1) {
                $("#correct" + id).iCheck('check');
            }

            $("#editModal").modal('show');
        }
    </script>
@endpush