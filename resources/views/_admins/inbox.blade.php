@extends('layouts.mst_admin')
@section('title', 'Inbox &ndash; '.env('APP_NAME').' Admins | '.env('APP_NAME'))
@section('content')
    <div class="right_col" role="main" id="inbox">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Inbox
                            <small>Mail</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-times"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12 mail_list_column" data-scrollbar>
                                <button id="compose" class="btn btn-sm btn-success btn-block" type="button">
                                    <strong><i class="fa fa-edit"></i>&ensp;COMPOSE</strong>
                                </button>
                                @if(count($contacts) > 0)
                                    @foreach($contacts as $contact)
                                        @php $user = \App\User::where('email',$contact->email); @endphp
                                        <a style="cursor: pointer" id="{{$contact->id}}"
                                           onclick="viewMail('{{$contact->id}}','{{$contact->name}}',
                                                   '{{$contact->email}}','{{$contact->subject}}','{{$contact->message}}',
                                                   '{{\Carbon\Carbon::parse($contact->created_at)->format('l, j F Y').' at '.
                                            \Carbon\Carbon::parse($contact->created_at)->format('H:i')}}',
                                                   '{{encrypt($contact->id)}}')">
                                            <div class="mail_list">
                                                <div class="left">
                                                    @if($user->count())
                                                        @if($user->first()->ava == "" || $user->first()->ava == "seeker.png")
                                                            <img class="img-responsive"
                                                                 src="{{asset('images/seeker.png')}}">
                                                        @elseif($user->first()->ava == "agency.png")
                                                            <img class="img-responsive"
                                                                 src="{{asset('images/agency.png')}}">
                                                        @else
                                                            <img class="img-responsive"
                                                                 src="{{asset('storage/users/'.$user->first()->ava)}}">
                                                        @endif
                                                    @else
                                                        <img class="img-responsive"
                                                             src="{{asset('images/avatar.png')}}">
                                                    @endif
                                                </div>
                                                <div class="right">
                                                    <h3>{{$contact->name}}
                                                        <small>{{\Carbon\Carbon::parse($contact->created_at)
                                                    ->formatLocalized('%d %b %y')}}</small>
                                                    </h3>
                                                    <p>
                                                        <strong>{{$contact->subject}}</strong>&nbsp;&ndash;&nbsp;{{$contact->message}}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <a style="cursor: default">
                                        <div class="mail_list">
                                            <p><em>There seems to be none of the feedback was found&hellip;</em></p>
                                        </div>
                                    </a>
                                @endif
                            </div>
                            <!-- /MAIL LIST -->

                            <!-- CONTENT MAIL -->
                            <div class="col-sm-9 mail_view" style="display: none">
                                <div class="inbox-body" id="content_mail"></div>
                            </div>
                            <!-- /CONTENT MAIL -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- compose -->
    <div class="compose col-md-6 col-xs-12">
        <form action="{{route('admin.compose.inbox')}}" method="post" id="form-compose">
            {{csrf_field()}}
            <div class="compose-header">
                <strong id="compose_title">New Message</strong>
                <button type="button" class="close compose-close">
                    <span>×</span>
                </button>
            </div>

            <div class="compose-body" style="margin: 1em">
                <div class="row form-group">
                    <div class="col-lg-12 has-feedback">
                        <input class="form-control" id="inbox_to" type="email" name="inbox_to" placeholder="To:"
                               required>
                        <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12 has-feedback">
                        <input class="form-control" id="inbox_subject" type="text" name="inbox_subject"
                               placeholder="Subject:" required>
                        <span class="fa fa-text-width form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12 has-feedback">
                        <textarea class="use-tinymce" name="inbox_message" id="inbox_message"></textarea>
                        <span class="fa fa-text-height form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
            </div>

            <div class="compose-footer">
                <button id="send" class="btn btn-block btn-success" type="submit">Send</button>
            </div>
        </form>
    </div>
    <!-- /compose -->
@endsection
@push("scripts")
    <script>
        $(function () {
            @if($findMessage != null)
            $("#{{$findMessage}}").click();
            @endif
        });

        function viewMail(id, name, email, subject, message, date, deleteId) {
            $(".mail_list img").addClass('img-circle');

            $("#content_mail").html(
                '<div class="mail_heading row">' +
                '<div class="col-md-8">' +
                '<div class="btn-group">' +
                '<button class="btn btn-sm btn-primary btn_reply' + id + '" type="button" ' +
                'data-toggle="tooltip" data-original-title="Reply"><i class="fa fa-reply"></i></button>' +
                '<button class="btn btn-sm btn-info btn_forward' + id + '" type="button" data-toggle="tooltip" ' +
                'data-original-title="Forward"><i class="fa fa-share"></i></button>' +
                '<a class="btn btn-sm btn-danger btn_delete_inbox' + id + '" type="button" data-toggle="tooltip" ' +
                'data-original-title="Delete"><i class="fa fa-trash-alt"></i></a></div></div>' +
                '<div class="col-md-4 text-right"><p class="date">' + date + '</p></div>' +
                '<div class="col-md-12"><h4>' + subject + '</h4></div></div>' +
                '<div class="sender-info">' +
                '<div class="row">' +
                '<div class="col-md-12">' +
                '<strong>' + name + '</strong> <span>(' + email + ')</span> to <strong>me</strong></div></div></div>' +
                '<div class="view-mail"><p>' + message + '</p></div>' +
                '<div class="btn-group">' +
                '<button class="btn btn-sm btn-primary btn_reply' + id + '" type="button">' +
                '<i class="fa fa-reply"></i>&ensp;Reply</button>' +
                '<button class="btn btn-sm btn-info btn_forward' + id + '" type="button">' +
                '<i class="fa fa-share"></i>&ensp;Forward</button></div>'
            );

            $(".mail_list_column").removeClass('col-sm-12').addClass('col-sm-3');
            $(".mail_view").fadeIn("slow");

            $(".btn_reply" + id).on("click", function () {
                $("#compose_title").text('Reply Message');
                $("#inbox_to").val(email);
                $("#inbox_subject").val('Re: ' + subject);
                tinyMCE.get('inbox_message').setContent('');
                $(".compose").slideToggle();
            });

            $(".btn_forward" + id).on("click", function () {
                $("#compose_title").text('Forward Message');
                $("#inbox_to").val('');
                $("#inbox_subject").val('Fwd: ' + subject);
                tinyMCE.get('inbox_message').setContent(message);
                $(".compose").slideToggle();
            });

            $(".btn_delete_inbox" + id).on("click", function () {
                var linkURL = '{{url('admin/inbox')}}/' + deleteId + '/delete';
                swal({
                    title: 'Delete Inbox',
                    text: "Are you sure to delete " + name + "\'s message? You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#fa5555',
                    confirmButtonText: 'Yes, delete it!',
                    showLoaderOnConfirm: true,

                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            window.location.href = linkURL;
                        });
                    },
                    allowOutsideClick: false
                });
                return false;
            });

            $('html, body').animate({
                scrollTop: $('#inbox').offset().top
            }, 500);
        }

        $("#compose").on("click", function () {
            $("#compose_title").text('New Message');
            tinyMCE.get('inbox_message').setContent('');
            $("#form-compose")[0].reset();
        });

        $("#form-compose").on('submit', function (e) {
            e.preventDefault();
            if (tinyMCE.get('inbox_message').getContent() == "") {
                swal({
                    title: 'ATTENTION!',
                    text: 'You have to write some messages!',
                    type: 'warning',
                    timer: '3500'
                });

            } else {
                $(this)[0].submit();
            }
        });
    </script>
@endpush
