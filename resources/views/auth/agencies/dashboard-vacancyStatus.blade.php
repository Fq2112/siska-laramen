@section('title', ''.$user->name.'\'s Dashboard &ndash; Vacancy Status | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_agency')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Vacancy Status</h4>
                            <small>Here is the current and previous status of your vacancies.</small>
                            <hr>
                            <form id="form-loadVacStats">
                                <input type="hidden" name="agency_id" value="{{$agency->id}}">
                                <input type="hidden" name="start_date" id="start_date">
                                <input type="hidden" name="end_date" id="end_date">
                                <input type="hidden" id="date">
                            </form>
                        </div>
                    </div>
                    <div class="row" style="margin: 0">
                        <div class="row" id="vac-control">
                            <div class="col-lg-4 to-animate-2">
                                <div id="daterangepicker" class="myDateRangePicker" data-toggle="tooltip"
                                     data-placement="top" title="Ordered Date Filter">
                                    <i class="fa fa-calendar-alt"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                            <div class="col-lg-8 to-animate">
                                <small class="pull-right" id="show-result" style="text-align: right"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" data-scrollbar style="max-height: 400px;margin-bottom: 1em">
                                <img src="{{asset('images/loading3.gif')}}" id="image"
                                     class="img-responsive ld ld-fade">
                                <div id="search-result"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 to-animate-2 myPagination">
                                <ul class="pagination"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal to-animate login" id="uploadModal" style="font-family: 'PT Sans', Arial, serif">
        <div class="modal-dialog login animated">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="invoice"></h4>
                </div>
                <div class="modal-body">
                    <div class="box">
                        <div class="content">
                            <p style="font-size: 17px" align="justify">To speed up its verification process,
                                upload your payment proof file here.</p>
                            <hr class="hr-divider">
                            <div class="row">
                                <div class="col-lg-12" id="paymentProof"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            @if($findConfirm != "")
            @if(now() <= $findConfirm->created_at->addDay())
            uploadPaymentProof('{{$findConfirm->id}}', '{{$findConfirm->payment_proof}}', '{{$req_invoice}}');
            @else
            swal({
                title: 'ATTENTION!',
                text: '{{$req_invoice}} has been expired.',
                type: 'warning',
                timer: '3500'
            });
                    @endif
                    @endif

            var start = moment().startOf('month'), end = moment().endOf('month');

            $('#daterangepicker').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, searchDate);

            searchDate(start, end);
        });

        function searchDate(start, end) {
            $('#daterangepicker span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
            $("#start_date").val(start.format('YYYY-MM-D'));
            $("#end_date").val(end.format('YYYY-MM-D'));
            $("#date").val(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
            loadVacStats(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
        }

        function loadVacStats(date) {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: "{{route('get.vacancy.status')}}",
                    type: "GET",
                    data: $("#form-loadVacStats").serialize(),
                    beforeSend: function () {
                        $('#image').show();
                        $('#search-result, #vac-control, .myPagination').hide();
                    },
                    complete: function () {
                        $('#image').hide();
                        $('#search-result, #vac-control, .myPagination').show();
                    },
                    success: function (data) {
                        successLoad(data, date);
                    },
                    error: function () {
                        swal({
                            title: 'Vacancy Status',
                            text: 'Data not found!',
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            }.bind(this), 800);

            return false;
        }

        $('.myPagination ul').on('click', 'li', function () {
            var date = $("#date").val();

            $(window).scrollTop(0);

            page = $(this).children().text();
            active = $(this).parents("ul").find('.active').eq(0).text();
            hellip_prev = $(this).closest('.hellip_prev').next().find('a').text();
            hellip_next = $(this).closest('.hellip_next').prev().find('a').text();

            if (page > 0) {
                $url = "{{url('/account/agency/vacancy/status/vacancies')}}" + '?page=' + page;
            }
            if ($(this).hasClass('prev')) {
                $url = "{{url('/account/agency/vacancy/status/vacancies')}}" + '?page=' + parseInt(active - 1);
            }
            if ($(this).hasClass('next')) {
                $url = "{{url('/account/agency/vacancy/status/vacancies')}}" + '?page=' + parseInt(+active + +1);
            }
            if ($(this).hasClass('hellip_prev')) {
                $url = "{{url('/account/agency/vacancy/status/vacancies')}}" + '?page=' + parseInt(hellip_prev - 1);
                page = parseInt(hellip_prev - 1);
            }
            if ($(this).hasClass('hellip_next')) {
                $url = "{{url('/account/agency/vacancy/status/vacancies')}}" + '?page=' + parseInt(+hellip_next + +1);
                page = parseInt(+hellip_next + +1);
            }
            if ($(this).hasClass('first')) {
                $url = "{{url('/account/agency/vacancy/status/vacancies')}}" + '?page=1';
            }
            if ($(this).hasClass('last')) {
                $url = "{{url('/account/agency/vacancy/status/vacancies')}}" + '?page=' + last_page;
            }

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: $url,
                    type: "GET",
                    data: $("#form-loadVacStats").serialize(),
                    beforeSend: function () {
                        $('#image').show();
                        $('#search-result, #vac-control, .myPagination').hide();
                    },
                    complete: function () {
                        $('#image').hide();
                        $('#search-result, #vac-control, .myPagination').show();
                    },
                    success: function (data) {
                        successLoad(data, date, page);
                    },
                    error: function () {
                        swal({
                            title: 'Vacancy Status',
                            text: 'Data not found!',
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            }.bind(this), 800);

            return false;
        });

        function successLoad(data, date, page) {
            var title, total, $date, pagination = '', $page = '',
                $color, $display, $class, $param, $param2, $label;

            if (data.total > 0) {
                title = data.total > 1 ? 'Showing <strong>' + data.total + '</strong> vacancy status' :
                    'Showing a vacancy status';

                $date = date != undefined ? ' for <strong>"' + date + '"</strong>' : ' for <strong>"{{today()
                ->startOfMonth()->formatLocalized('%d %b %Y')." - ".today()
                ->endOfMonth()->formatLocalized('%d %b %Y')}}"</strong>';

                total = $.trim(data.total) ? ' (<strong>' + data.from + '</strong> - ' +
                    '<strong>' + data.to + '</strong> of <strong>' + data.total + '</strong>)' : '';

            } else {
                title = '<em>There seems to be none of the vacancy status was found&hellip;</em>';
                total = '';
                $date = '';
            }
            $('#show-result').html(title + $date + total);

            $("#search-result").empty();
            $.each(data.data, function (i, val) {
                $color = val.isPaid == 1 ? '#00adb5' : '#fa5555';
                $display = val.isPaid == 0 && val.expired == false ? '' : 'none';
                $class = val.isPaid == 1 ? '' : 'ld ld-breath';
                $label = val.isPaid == 1 ? "<strong>Paid</strong> on " + val.date_payment :
                    "<strong>Ordered</strong> on " + val.date_order;
                $param = val.id + ",'" + val.payment_proof + "','" + val.invoice + "'";
                $param2 = val.id + ",'" + val.invoice + "'";

                $("#search-result").append(
                    '<div class="media">' +
                    '<div class="media-left media-middle">' +
                    '<img width="100" class="media-object" src="' + val.ava + '"></div>' +
                    '<div class="media-body">' +
                    '<small class="media-heading">' +
                    '<a style="color: ' + $color + '" target="_blank" ' +
                    'href="{{route('invoice.job.posting',['id'=> ''])}}/' + val.encryptID + '">' +
                    '<i class="fa fa-file-invoice-dollar"></i>&ensp;' + val.invoice + '</a>' +
                    '<sub>&ndash; ' + val.created_at + '</sub></small>' +
                    '<blockquote style="font-size: 12px;color: #7f7f7f">' +
                    '<form style="display: ' + $display + '" class="pull-right" id="form-paymentProof-' + val.id + '" ' +
                    'method="post" action="{{route('upload.paymentProof')}}">{{csrf_field()}}' +
                    '<div class="anim-icon anim-icon-md upload ' + $class + '" ' +
                    'onclick="uploadPaymentProof(' + $param + ')" data-toggle="tooltip" data-placement="bottom" ' +
                    'title="Payment Proof" style="font-size: 25px">' +
                    '<input type="hidden" name="confirmAgency_id" value="' + val.id + '">' +
                    '<input id="upload' + val.id + '" type="checkbox" checked>' +
                    '<label for="upload' + val.id + '"></label></div></form>' +
                    '<ul class="list-inline" id="vacancies' + val.id + '"></ul>' +
                    '<small>' + $label + '</small>' +
                    '<a id="btnDel_jobPosting' + val.id + '" style="display: ' + $display + '" ' +
                    'href="{{route('delete.job.posting',['id'=>''])}}/' + val.encryptID + '" ' +
                    'onclick="deleteJobPosting(' + $param2 + ')">' +
                    '<div class="anim-icon anim-icon-md apply ld ld-heartbeat" data-toggle="tooltip" ' +
                    'data-placement="right" title="Click here to abort this order!" style="font-size: 15px">' +
                    '<input id="apply' + val.id + '" type="checkbox" checked>' +
                    '<label for="apply' + val.id + '"></label></div></a>' +
                    '<small style="display: ' + $display + '">P.S.: You are only permitted to COMPLETE the payment or ' +
                    'even ABORT this order before <strong>' + val.deadline + '.</strong></small>' +
                    '</blockquote></div></div><hr class="hr-divider">'
                );

                var $vacancies = '', $status;
                $.each(val.vacancy_ids, function (x, nilai) {
                    $status = nilai.isPost == 1 ? 'POSTED' : 'NOT POSTED YET';
                    $vacancies +=
                        '<li><a target="_blank" href="{{route('detail.vacancy',['id' => ''])}}/' + nilai.id + '" ' +
                        'class="tag tag-plans"><i class="fa fa-briefcase"></i>&ensp;' + nilai.judul + ' &ndash; ' +
                        '<strong>' + $status + '</strong></li>';
                });
                $("#vacancies" + val.id).html($vacancies +
                    '<li><a class="tag tag-plans"><i class="fa fa-thumbtack"></i>&ensp;Plan: ' +
                    '<strong style="text-transform: uppercase">' + val.plan + '</strong> Package</a></li>' +
                    '<li><a class="tag tag-plans"><i class="fa fa-credit-card"></i>&ensp;Payment: ' + val.pc + ' &ndash; ' +
                    '<strong style="text-transform: uppercase">' + val.pm + '</strong></a></li>'
                );
            });
            $('[data-toggle="tooltip"]').tooltip();

            if (data.last_page > 1) {

                if (data.current_page > 4) {
                    pagination += '<li class="first"><a href="' + data.first_page_url + '"><i class="fa fa-angle-double-left"></i></a></li>';
                }

                if ($.trim(data.prev_page_url)) {
                    pagination += '<li class="prev"><a href="' + data.prev_page_url + '" rel="prev"><i class="fa fa-angle-left"></i></a></li>';
                } else {
                    pagination += '<li class="disabled"><span><i class="fa fa-angle-left"></i></span></li>';
                }

                if (data.current_page > 4) {
                    pagination += '<li class="hellip_prev"><a style="cursor: pointer">&hellip;</a></li>'
                }

                for ($i = 1; $i <= data.last_page; $i++) {
                    if ($i >= data.current_page - 3 && $i <= data.current_page + 3) {
                        if (data.current_page == $i) {
                            pagination += '<li class="active"><span>' + $i + '</span></li>'
                        } else {
                            pagination += '<li><a style="cursor: pointer">' + $i + '</a></li>'
                        }
                    }
                }

                if (data.current_page < data.last_page - 3) {
                    pagination += '<li class="hellip_next"><a style="cursor: pointer">&hellip;</a></li>'
                }

                if ($.trim(data.next_page_url)) {
                    pagination += '<li class="next"><a href="' + data.next_page_url + '" rel="next"><i class="fa fa-angle-right"></i></a></li>';
                } else {
                    pagination += '<li class="disabled"><span><i class="fa fa-angle-right"></i></span></li>';
                }

                if (data.current_page < data.last_page - 3) {
                    pagination += '<li class="last"><a href="' + data.last_page_url + '"><i class="fa fa-angle-double-right"></i></a></li>';
                }
            }
            $('.myPagination ul').html(pagination);

            if (page != "" && page != undefined) {
                $page = '?page=' + page;
            }
            window.history.replaceState("", "", '{{url('/account/agency/vacancy/status')}}' + $page);
            return false;
        }

        function uploadPaymentProof(id, image, invoice) {
            $("#paymentProof").html(
                '<form id="upload-form" method="post" enctype="multipart/form-data">' +
                '{{csrf_field()}} {{ method_field('put') }}' +
                '<input type="hidden" name="confirmAgency_id" value="' + id + '">' +
                '<div class="uploader">' +
                '<input id="file-upload" type="file" name="payment_proof" accept="image/*">' +
                '<label for="file-upload" id="file-drag">' +
                '<img id="file-image" src="#" alt="Payment Proof" class="hidden img-responsive">' +
                '<div id="start">' +
                '<i class="fa fa-download" aria-hidden="true"></i>' +
                '<div>Select your payment proof file or drag it here</div>' +
                '<div id="notimage" class="hidden">Please select an image</div>' +
                '<span id="file-upload-btn" class="btn btn-primary"> Select a file</span></div>' +
                '<div id="response" class="hidden"><div id="messages"></div></div>' +
                '<div id="progress-upload">' +
                '<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" ' +
                'aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div></label></div></form>'
            );
            $("#invoice").html('<strong>' + invoice + '</strong> &ndash; PAYMENT PROOF');
            $("#upload" + id).prop('checked', false);
            $("#uploadModal").modal('show');
            if (image != "") {
                setImage(image);
            }
            $(document).on('hide.bs.modal', '#uploadModal', function (event) {
                $("#upload" + id).prop('checked', true);
            });
            ekUpload(id);
        }

        function ekUpload(id) {
            function Init() {
                var fileSelect = document.getElementById('file-upload'),
                    fileDrag = document.getElementById('file-drag');

                fileSelect.addEventListener('change', fileSelectHandler, false);

                var xhr = new XMLHttpRequest();
                if (xhr.upload) {
                    fileDrag.addEventListener('dragover', fileDragHover, false);
                    fileDrag.addEventListener('dragleave', fileDragHover, false);
                    fileDrag.addEventListener('drop', fileSelectHandler, false);
                }
            }

            function fileDragHover(e) {
                var fileDrag = document.getElementById('file-drag');

                e.stopPropagation();
                e.preventDefault();

                fileDrag.className = (e.type === 'dragover' ? 'hover' : 'modal-body file-upload');
            }

            function fileSelectHandler(e) {
                var files = e.target.files || e.dataTransfer.files;
                $("#file-upload").prop("files", files);

                fileDragHover(e);

                for (var i = 0, f; f = files[i]; i++) {
                    uploadPaymentProof(f);
                }
            }

            function uploadPaymentProof(file) {
                var files_size = file.size, max_file_size = 2000000, file_name = file.name,
                    allowed_file_types = (/\.(?=gif|jpg|png|jpeg)/gi).test(file_name);

                if (!window.File && window.FileReader && window.FileList && window.Blob) {
                    swal({
                        title: 'Attention!',
                        text: "Your browser does not support new File API! Please upgrade.",
                        type: 'warning',
                        timer: '3500'
                    });

                } else {
                    if (files_size > max_file_size) {
                        swal({
                            title: 'Payment Proof',
                            text: file_name + " with total size " + filesize(files_size) + ", Allowed size is " + filesize(max_file_size) + ", Try smaller file!",
                            type: 'error',
                            timer: '3500'
                        });
                        $("#messages-" + id).html('Please upload a smaller file (< ' + filesize(max_file_size) + ').');
                        document.getElementById('file-image').classList.add("hidden");
                        document.getElementById('start').classList.remove("hidden");
                        document.getElementById("upload-form").reset();

                    } else {
                        if (!allowed_file_types) {
                            swal({
                                title: 'Payment Proof',
                                text: file.name + " is unsupported file type!",
                                type: 'error',
                                timer: '3500'
                            });
                            document.getElementById('file-image').classList.add("hidden");
                            document.getElementById('notimage').classList.remove("hidden");
                            document.getElementById('start').classList.remove("hidden");
                            document.getElementById('response').classList.add("hidden");
                            document.getElementById("upload-form").reset();

                        } else {
                            $.ajax({
                                type: 'POST',
                                url: '{{route('upload.paymentProof')}}',
                                data: new FormData($("#upload-form")[0]),
                                contentType: false,
                                processData: false,
                                mimeType: "multipart/form-data",
                                xhr: function () {
                                    var xhr = $.ajaxSettings.xhr(),
                                        progress_bar_id = $("#progress-upload .progress-bar");
                                    if (xhr.upload) {
                                        xhr.upload.addEventListener('progress', function (event) {
                                            var percent = 0;
                                            var position = event.loaded || event.position;
                                            var total = event.total;
                                            if (event.lengthComputable) {
                                                percent = Math.ceil(position / total * 100);
                                            }
                                            progress_bar_id.css("display", "block");
                                            progress_bar_id.css("width", +percent + "%");
                                            progress_bar_id.text(percent + "%");
                                            if (percent == 100) {
                                                progress_bar_id.removeClass("progress-bar-info");
                                                progress_bar_id.addClass("progress-bar-success");
                                            } else {
                                                progress_bar_id.removeClass("progress-bar-success");
                                                progress_bar_id.addClass("progress-bar-info");
                                            }
                                        }, true);
                                    }
                                    return xhr;
                                },
                                success: function (data) {
                                    swal({
                                        title: 'Job Posting',
                                        text: 'Payment proof is successfully uploaded! To check whether ' +
                                            'your vacancy is already posted or not, please check ' +
                                            'Vacancy Status in your dashboard.',
                                        type: 'success',
                                        timer: '7000'
                                    });

                                    setImage(data);
                                    $("#progress-upload").css("display", "none");
                                },
                                error: function () {
                                    swal({
                                        title: 'Oops...',
                                        text: 'Something went wrong!',
                                        type: 'error',
                                        timer: '1500'
                                    })
                                }
                            });
                            return false;
                        }
                    }
                }
            }

            if (window.File && window.FileList && window.FileReader) {
                Init();
            } else {
                document.getElementById('file-drag').style.display = 'none';
            }
        }

        function setImage(image) {
            $("#messages").html('<strong>' + image + '</strong>');
            $('#start').addClass("hidden");
            $('#response').removeClass("hidden");
            $('#notimage').addClass("hidden");
            $('#file-image').removeClass("hidden").attr('src', '{{asset('storage/users/agencies/payment/')}}/' + image);
        }

        function deleteJobPosting(id, invoice) {
            var linkURL = $("#btnDel_jobPosting" + id).attr("href");
            swal({
                title: 'Abort Job Posting',
                text: "Are you sure to abort " + invoice + "? You won't be able to revert this action!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, abort it!',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
            }).then(function () {
                $("#apply" + id).prop('checked', false);
                window.location.href = linkURL;
            }, function (dismiss) {
                if (dismiss == 'cancel') {
                    $("#apply" + id).prop('checked', true);
                }
            });
        }
    </script>
@endpush