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
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: .5em">
                        <div class="col-lg-3 to-animate-2">
                            <form id="form-time" action="{{route('agency.vacancy.status')}}">
                                <select class="form-control selectpicker" name="time" data-container="body">
                                    <option value="1" {{$time == 1 ? 'selected' : ''}}>All Time</option>
                                    <option value="2" {{$time == 2 ? 'selected' : ''}}>Today</option>
                                    <option value="3" {{$time == 3 ? 'selected' : ''}}>Last 7 Days</option>
                                    <option value="4" {{$time == 4 ? 'selected' : ''}}>Last 30 Days</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-lg-9 to-animate">
                            <small class="pull-right">
                                @if(count($confirmAgency) > 1)
                                    Showing <strong>{{count($confirmAgency)}}</strong> vacancy status
                                @elseif(count($confirmAgency) == 1)
                                    Showing a vacancy status
                                @else
                                    <em>There seems to be none of the vacancy status was found&hellip;</em>
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($confirmAgency as $row)
                                @php
                                    $vac_ids = \App\ConfirmAgency::where('id', $row->id)->pluck('vacancy_ids')->toArray();
                                    $vacancies = \App\Vacancies::whereIn('id',$vac_ids[0])->get();
                                    $plan = \App\Plan::find($row->plans_id);
                                    $pm = \App\PaymentMethod::find($row->payment_method_id);
                                    $pc = \App\PaymentCategory::find($pm->payment_category_id);
                                    $date = \Carbon\Carbon::parse($row->created_at);
                                    $romanDate = \App\Support\RomanConverter::numberToRoman($date->format('y')) . '/' .
                                    \App\Support\RomanConverter::numberToRoman($date->format('m'));
                                    $invoice = '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $row->id;
                                @endphp
                                <div class="media to-animate">
                                    <div class="media-left media-middle">
                                        @if($row->isPaid == true)
                                            <img width="100" class="media-object"
                                                 src="{{asset('images/stamp_paid.png')}}">
                                        @else
                                            <img width="100" class="media-object"
                                                 src="{{asset('images/stamp_unpaid.png')}}">
                                        @endif
                                    </div>
                                    <div class="media-body">
                                        <small class="media-heading">
                                            <a style="color: {{$row->isPaid == true ? '#00adb5' : '#fa5555'}}"
                                               target="_blank"
                                               href="{{route('invoice.job.posting',['id'=>encrypt($row->id)])}}">
                                                <i class="fa fa-file-invoice-dollar"></i>&ensp;{{$invoice}}</a>
                                            <sub>&ndash; {{$row->created_at->diffForHumans()}}</sub>
                                        </small>
                                        <blockquote style="font-size: 12px;color: #7f7f7f">
                                            <form class="pull-right to-animate-2" id="form-paymentProof-{{$row->id}}"
                                                  method="post" action="{{route('upload.paymentProof')}}">
                                                {{csrf_field()}}
                                                <div class="anim-icon anim-icon-md upload {{$row->isPaid == true ? '' :
                                                'ld ld-breath'}}"
                                                     onclick="uploadPaymentProof('{{$row->id}}',
                                                             '{{$row->payment_proof}}','{{$invoice}}')"
                                                     data-toggle="tooltip" data-placement="bottom" title="Payment Proof"
                                                     style="font-size: 25px">
                                                    <input type="hidden" name="confirmAgency_id" value="{{$row->id}}">
                                                    <input type="checkbox" checked>
                                                    <label for="upload"></label>
                                                </div>
                                            </form>
                                            <ul class="list-inline">
                                                @foreach($vacancies as $vacancy)
                                                    <li><a class="tag" target="_blank" href="{{route('detail.vacancy',
                                                    ['id' => $vacancy->id])}}"><i class="fa fa-briefcase"></i>&ensp;
                                                            {{$vacancy->judul}} &ndash; <strong>{{$vacancy->isPost ==
                                                            true ? 'POSTED' : 'NOT POSTED YET'}}</strong></a></li>
                                                @endforeach
                                                <li>
                                                    <a class="tag tag-plans">
                                                        <i class="fa fa-thumbtack"></i>&ensp;Plans Package:
                                                        <strong style="text-transform: uppercase">{{$plan->name}}</strong></a>
                                                </li>
                                                <li>
                                                    <a class="tag tag-plans">
                                                        <i class="fa fa-credit-card"></i>&ensp;Payment:
                                                        {{$pc->name}} &ndash;
                                                        <strong style="text-transform: uppercase">{{$pm->name}}</strong>
                                                    </a></li>
                                            </ul>
                                            <small>
                                                <strong>{{$row->isPaid == true ? 'Paid' : 'Ordered'}}</strong> on
                                                {{\Carbon\Carbon::parse($row->date_payment)->format('l, j F Y').' at '.
                                                \Carbon\Carbon::parse($row->date_payment)->format('H:i')}}
                                            </small>
                                            @if(now() <= $row->created_at->addDay())
                                                <a href="{{route('delete.job.posting',['id'=>encrypt($row->id)])}}"
                                                   class="delete-jobPosting">
                                                    <div class="anim-icon anim-icon-md apply ld ld-heartbeat"
                                                         data-toggle="tooltip" data-placement="right"
                                                         title="Click here to abort this order!"
                                                         style="font-size: 15px">
                                                        <input type="checkbox" checked>
                                                        <label for="apply"></label>
                                                    </div>
                                                </a>
                                                <small class="to-animate-2">
                                                    P.S.: You are only permitted to abort this order before
                                                    <strong>{{$row->created_at->addDay()->format('l, j F Y').' at '.
                                                    $row->created_at->addDay()->format('H:i').'.'}}</strong>
                                                </small>
                                            @endif
                                        </blockquote>
                                    </div>
                                </div>
                                <hr class="hr-divider">
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 to-animate-2 myPagination">
                            {{$confirmAgency->links()}}
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
        @if($req_id != null || $req_image != null|| $req_invoice != null)
        $(function () {
            uploadPaymentProof('{{$req_id}}', '{{$req_image}}', '{{$req_invoice}}');
        });

        @endif

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
            $("#uploadModal").modal('show');
            if (image != "") {
                setImage(image);
            }
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
    </script>
@endpush