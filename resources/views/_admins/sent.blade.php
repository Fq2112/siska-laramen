@extends('layouts.mst_admin')
@section('title', 'Sent ('.count($sents) > 1 ? count($sents).' messages ' : count($sents).' message) &ndash; '.env('APP_NAME').' Admins | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap-fileinput/css/fileinput.min.css')}}">
    <style>
        .mail_list.active {
            background: #26b99a;
            color: #fff;
            border-radius: 3px;
            padding: .5em;
            border: 1px solid #169F85;
        }

        .mail_list.active h3 small {
            color: #fff;
        }

        .bootstrap-tagsinput {
            padding: 1em;
            border-radius: 0;
        }

        .bootstrap-tagsinput .tag {
            border-radius: 0;
        }

        .bootstrap-tagsinput .tag [data-role="remove"]:after {
            font-family: "Font Awesome 5 Free";
            content: "\f00d";
            font-weight: 900;
        }

        .bootstrap-multiemail {
            width: 100%;
            cursor: text;
            margin-bottom: 0;
        }

        .bootstrap-multiemail .tag {
            background-color: transparent;
            border: 1px solid #ccc;
            border-radius: 10px;
            color: #555 !important;
            padding: 1px 5px;
            line-height: 18px;
        }

        .bootstrap-multiemail .tag.invalid {
            background-color: #E74C3C !important;
            color: #fff !important;
            border-color: #E74C3C !important;
        }

        #attach-div .input-group {
            margin-bottom: 0;
        }

        #attach-div .file-preview {
            border-radius: 0;
            border-color: #ccc;
        }
    </style>
@endpush
@section('content')
    <div class="right_col" role="main" id="inbox">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Sent
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
                                @if(count($sents) > 0)
                                    @foreach($sents as $sent)
                                        <a style="cursor: pointer" id="{{$sent->id}}"
                                           onclick="viewMail('{{route('admin.get.read', ['id' => encrypt($sent->id), 'type' => 'sent'])}}')">
                                            <div class="mail_list">
                                                <div class="left">
                                                    <img src="{{Auth::guard('admin')->user()->ava == "" || Auth::guard('admin')->user()->ava == "avatar.png" ? asset('images/avatar.png') : asset('storage/admins/'.Auth::guard('admin')->user()->ava)}}"
                                                         alt="avatar" class="img-responsive">
                                                </div>
                                                <div class="right">
                                                    <h3>{{$sent->recipients}}
                                                        <small>{{\Carbon\Carbon::parse($sent->created_at)->formatLocalized('%d %b %y')}}</small>
                                                    </h3>
                                                    <p>
                                                        <strong>{{$sent->subject}}</strong>&nbsp;&ndash;&nbsp;{{$sent->category}}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <a style="cursor: default">
                                        <div class="mail_list">
                                            <p><em>There seems to be none of the sent mail was found&hellip;</em></p>
                                        </div>
                                    </a>
                                @endif
                            </div>
                            <!-- /MAIL LIST -->

                            <!-- CONTENT MAIL -->
                            <div class="col-sm-9 mail_view">
                                <img src="{{asset('images/loading.gif')}}" id="image2"
                                     class="img-responsive ld ld-fade" style="display:none;margin: 0 auto">
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
        <form action="{{route('admin.compose.inbox')}}" method="post" id="form-compose"
              enctype="multipart/form-data" novalidate>
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
                        <input class="form-control" id="inbox_to" type="email" name="inbox_to" placeholder="To:">
                        <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12 has-feedback">
                        <input class="form-control" id="inbox_subject" type="text" name="inbox_subject"
                               placeholder="Subject:">
                        <span class="fa fa-text-width form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12 has-feedback">
                        <select class="form-control selectpicker" id="inbox_category" name="inbox_category"
                                title="-- Choose Category --">
                            <option value="promo">Promo</option>
                            <option value="others">Others</option>
                        </select>
                        <span class="fa fa-tags form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <div class="col-lg-6 has-feedback" style="display: none">
                        <select class="form-control selectpicker" id="inbox_promo" name="inbox_promo"
                                title="-- Choose Promo --">
                            @foreach($promo as $row)
                                <option value="{{$row->promo_code}}"
                                        data-subtext="{{$row->description}}">{{$row->promo_code}}</option>
                            @endforeach
                        </select>
                        <span class="fa fa-ticket-alt form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12 has-feedback">
                        <textarea class="use-tinymce" name="inbox_message" id="inbox_message"></textarea>
                        <span class="fa fa-text-height form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div id="attach-div" class="row form-group" style="display: none">
                    <div class="col-lg-12">
                        <input accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.odt,.ppt,.pptx"
                               type="file" name="attachments[]" multiple>
                    </div>
                </div>
            </div>
            <div class="row compose-footer">
                <div class="col-lg-1">
                    <button id="attach" class="btn btn-block btn-default" type="button">
                        <i class="fa fa-paperclip"></i></button>
                </div>
                <div class="col-lg-11">
                    <button id="send" class="btn btn-block btn-success" type="submit"><b>SEND MESSAGE</b></button>
                </div>
            </div>
        </form>
    </div>
    <!-- /compose -->
@endsection
@push("scripts")
    <script src="{{asset('bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('bootstrap-tagsinput/bootstrap-multiEmail.js')}}"></script>
    <script src="{{asset('bootstrap-fileinput/js/plugins/piexif.min.js')}}"></script>
    <script src="{{asset('bootstrap-fileinput/js/plugins/sortable.min.js')}}"></script>
    <script src="{{asset('bootstrap-fileinput/js/plugins/purify.min.js')}}"></script>
    <script src="{{asset('bootstrap-fileinput/js/fileinput.min.js')}}"></script>
    <script>
        var inbox_to = $("#inbox_to"), multiEmailInput = inbox_to.multiEmail(),
            inbox_category = $("#inbox_category"),
            inbox_promo = $("#inbox_promo"),
            btn_attach = $("#attach"), input_attach = $("#attach-div input[type=file]");

        $(function () {
            @if($findMessage != null)
            $("#{{$findMessage}}").click();
            @endif
        });

        $("#compose").on("click", function () {
            $("#compose_title").text('New Message');
            tinyMCE.get('inbox_message').setContent('');
            inbox_category.parents('.has-feedback').addClass('col-lg-12').removeClass('col-lg-6').next().hide();
            $("#inbox_category, #inbox_promo").val('default').selectpicker('refresh');
            $("#form-compose")[0].reset();
        });

        inbox_category.on('change', function () {
            inbox_promo.val('default').selectpicker('refresh');

            if ($(this).val() == 'promo') {
                $(this).parents('.has-feedback').removeClass('col-lg-12').addClass('col-lg-6').next().show();
            } else {
                $(this).parents('.has-feedback').addClass('col-lg-12').removeClass('col-lg-6').next().hide();
            }
        });

        btn_attach.on('click', function () {
            $("#attach-div").toggle(300);
            $(".file-input").hide().parents('label').find('.card-text').show();

            input_attach.fileinput('destroy').fileinput({
                showUpload: false,
                showBrowse: false,
                showCaption: true,
                browseOnZoneClick: true,
                showPreview: true,
                initialPreviewAsData: true,
                overwriteInitial: true,
                initialCaption: "Choose file...",
                dropZoneTitle: 'Drag & drop your design file here...',
                dropZoneClickTitle: '<br>(or click to choose it)',
                removeLabel: 'DELETE',
                removeIcon: '<i class="fa fa-trash-alt mr-1"></i>',
                removeClass: 'btn btn-danger btn-block m-0',
                removeTitle: 'Click here to clear the file you selected!',
                cancelLabel: 'CANCEL',
                cancelIcon: '<i class="fa fa-undo mr-1"></i>',
                cancelClass: 'btn btn-danger btn-block m-0',
                cancelTitle: 'Click here to cancel your file upload process!',
                allowedFileExtensions: ["jpg", "jpeg", "png", "tiff", "pdf", "doc", "docx"],
                maxFileSize: 5120,
                msgSizeTooLarge: 'File \"{name}\" (<b>{size} KB</b>) exceeds maximum allowed upload size of <b>{maxSize} KB (5 MB)</b>, try to upload smaller file!',
                msgInvalidFileExtension: 'Invalid extension for file \"{name}\", only \"{extensions}\" files are supported!',
            });

            $(".file-input .file-caption-name").attr('disabled', 'disabled').removeAttr('title').css('cursor', 'text');
            $(".file-input .file-caption").removeClass('icon-visible');
        });

        $("#form-compose").on('submit', function (e) {
            e.preventDefault();
            if (!inbox_to.val()) {
                swal({
                    title: 'ATTENTION!',
                    text: 'You have to write the recipient\'s email!',
                    type: 'warning',
                    timer: '3500'
                });

            } else {
                if (!$("#inbox_subject").val()) {
                    swal({
                        title: 'ATTENTION!',
                        text: 'You have to write the email subject!',
                        type: 'warning',
                        timer: '3500'
                    });

                } else {
                    if (inbox_category.val() == 'promo' && !inbox_promo.val()) {
                        swal({
                            title: 'ATTENTION!',
                            text: 'You have to choose the promo code!',
                            type: 'warning',
                            timer: '3500'
                        });

                    } else {
                        if (tinyMCE.get('inbox_message').getContent() == "") {
                            swal({
                                title: 'ATTENTION!',
                                text: 'You have to write some messages!',
                                type: 'warning',
                                timer: '3500'
                            });

                        } else {
                            var validEmails = $.grep(inbox_to.tagsinput('items'), function (email, index) {
                                return multiEmailInput[0].validEmail(email);
                            });
                            multiEmailInput[0].removeAll();
                            $.each(validEmails, function (i, val) {
                                multiEmailInput[0].add(val);
                            });

                            $(this)[0].submit();
                        }
                    }
                }
            }
        });

        function viewMail(url) {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: url,
                    type: 'GET',
                    beforeSend: function () {
                        $(".mail_list img").addClass('img-circle');
                        $(".mail_list_column").removeClass('col-sm-12').addClass('col-sm-3');
                        $(".mail_list").removeClass('active');
                        $('#image2').show();
                        $('#content_mail').hide();
                    },
                    complete: function () {
                        $('#image2').hide();
                        $('#content_mail').show();
                    },
                    success: function (data) {
                        var content = '';
                        $("#" + data.id).find('.mail_list').addClass('active');

                        if(data.str_attach != null) {
                            content='<br><small><i class="fa fa-paperclip"></i>&ensp;'+data.str_attach+'</small>'
                        }

                        $("#content_mail").html(
                            '<div class="mail_heading row">' +
                            '<div class="col-md-8">' +
                            '<div class="btn-group">' +
                            '<button class="btn btn-sm btn-primary btn_reply' + data.id + '" type="button" ' +
                            'data-toggle="tooltip" data-original-title="Reply"><i class="fa fa-reply"></i></button>' +
                            '<button class="btn btn-sm btn-info btn_forward' + data.id + '" type="button" data-toggle="tooltip" ' +
                            'data-original-title="Forward"><i class="fa fa-share"></i></button>' +
                            '<a class="btn btn-sm btn-danger btn_delete_inbox' + data.id + '" type="button" data-toggle="tooltip" ' +
                            'data-original-title="Delete"><i class="fa fa-trash-alt"></i></a></div></div>' +
                            '<div class="col-md-4 text-right"><p class="date">' + data.created_at + '</p></div>' +
                            '<div class="col-md-12"><h4>' + data.subject + content+'</h4></div></div>' +
                            '<div class="sender-info">' +
                            '<div class="row">' +
                            '<div class="col-md-12">' +
                            '<span>to: </span> <strong>' + data.recipients + '</strong> <span>(' + data.category + ')</span></div></div></div>' +
                            '<div class="view-mail"><p>' + data.message + '</p></div>' +
                            '<div class="btn-group">' +
                            '<button class="btn btn-sm btn-primary btn_reply' + data.id + '" type="button">' +
                            '<i class="fa fa-reply"></i>&ensp;Reply</button>' +
                            '<button class="btn btn-sm btn-info btn_forward' + data.id + '" type="button">' +
                            '<i class="fa fa-share"></i>&ensp;Forward</button></div>'
                        );

                        $(".btn_reply" + data.id).on("click", function () {
                            $("#compose_title").text('Reply Message');
                            $("#inbox_to").val(data.email);
                            $("#inbox_subject").val('Re: ' + data.subject);
                            tinyMCE.get('inbox_message').setContent('');
                            $(".compose").slideToggle();
                        });

                        $(".btn_forward" + data.id).on("click", function () {
                            $("#compose_title").text('Forward Message');
                            $("#inbox_to").val('');
                            $("#inbox_subject").val('Fwd: ' + data.subject);
                            tinyMCE.get('inbox_message').setContent(data.message);
                            $(".compose").slideToggle();
                        });

                        $(".btn_delete_inbox" + data.id).on("click", function () {
                            swal({
                                title: 'Delete Message',
                                text: "Are you sure to delete " + data.name + "\'s message? You won't be able to revert this!",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#fa5555',
                                confirmButtonText: 'Yes, delete it!',
                                showLoaderOnConfirm: true,

                                preConfirm: function () {
                                    return new Promise(function (resolve) {
                                        window.location.href = data.del_route;
                                    });
                                },
                                allowOutsideClick: false
                            });
                            return false;
                        });

                        $('html, body').animate({
                            scrollTop: $('#inbox').offset().top
                        }, 500);
                    },
                    error: function () {
                        swal({
                            title: 'Oops..',
                            text: 'Terjadi kesalahan! Silahkan, segarkan browser Anda.',
                            type: 'error',
                            timer: '3500',
                            confirmButtonColor: '#fa5555',
                        });
                    }
                });
            }.bind(this), 800);
        }
    </script>
@endpush
