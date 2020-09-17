@section('title', ''.$user->name.'\'s Dashboard &ndash; Recommended Seeker | '.env('APP_NAME'))
@extends('layouts.auth.mst_agency')
@push('styles')
    <style>
        .card-read-more button {
            color: #00ADB5;
        }

        .card-read-more button:hover {
            color: #fff;
        }
    </style>
@endpush
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Recommended Seeker</h4>
                            <small>Here is our recommended seekers based on your <strong>posted</strong> vacancy's
                                requirements of work experience <strong>and</strong> education degree requirement.
                            </small>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 to-animate-2">
                            <form id="form-src-seekers" action="#">
                                <div id="custom-search-input">
                                    <div class="input-group">
                                        <input id="txt_keyword" type="text" name="q" style="width: auto;"
                                               class="form-control myInput input-lg"
                                               onkeyup="showResetBtn(this.value)"
                                               placeholder="Search by Seeker's Name&hellip;"
                                               value="{{!empty($keyword) ? $keyword : ''}}">
                                        <span class="input-group-btn">
                                            <button type="reset" class="btn btn-info btn-lg"
                                                    id="btn_reset" onclick="resetFilter()">
                                                <span class="glyphicon glyphicon-remove">
                                                    <span class="sr-only">Close</span>
                                                </span>
                                            </button>
                                            <button id="cari" class="btn btn-info btn-lg" type="submit">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-7 to-animate">
                            <small class="pull-right" id="show-result" style="text-align: right"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" data-scrollbar style="max-height: 400px;margin: .5em 0">
                            <img src="{{asset('images/loading.gif')}}" id="image" class="img-responsive ld ld-fade">
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
    <div class="modal to-animate login" id="inviteModal" style="font-family: 'PT Sans', Arial, serif">
        <div class="modal-dialog login animated">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{'Hi '.$user->name.','}}</h4>
                </div>
                <div id="inviteSeeker"></div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var last_page;

        $(function () {
            var keyword = '{{$keyword}}', page = '{{$page}}', $page = '';
            $('#image').hide();

            if (keyword != "" || location != "") {
                $("#btn_reset").show();
            } else {
                $("#btn_reset").hide();
            }
            if (page != "" && page != undefined) {
                $page = '&page=' + page;
            }

            $.get('/account/agency/dashboard/recommended_seeker/seekers?q=' + keyword + $page, function (data) {
                last_page = data.last_page;
                successLoad(data, keyword, page);
            });
        });

        $("#txt_keyword").on('keyup', function () {
            loadSeeker();
        });
        $("#form-src-seekers").on('submit', function (event) {
            event.preventDefault();
            loadSeeker();
        });

        function resetFilter() {
            $("#txt_keyword").removeAttr('value');
            loadSeeker();
        }

        function loadSeeker() {
            var keyword = $("#txt_keyword").val();

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: "{{route('get.recommended.seeker')}}",
                    type: "GET",
                    data: $("#form-src-seekers").serialize(),
                    beforeSend: function () {
                        $('#image').show();
                        $('#search-result').hide();
                        $('.myPagination').hide();
                    },
                    complete: function () {
                        $('#image').hide();
                        $('#search-result').show();
                        $('.myPagination').show();
                    },
                    success: function (data) {
                        successLoad(data, keyword);
                    },
                    error: function () {
                        swal({
                            title: 'Recommended Seeker',
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
            var keyword = $("#txt_keyword").val();
            $(window).scrollTop(0);

            page = $(this).children().text();
            active = $(this).parents("ul").find('.active').eq(0).text();
            hellip_prev = $(this).closest('.hellip_prev').next().find('a').text();
            hellip_next = $(this).closest('.hellip_next').prev().find('a').text();

            if (page > 0) {
                $url = "{{url('/account/agency/dashboard/recommended_seeker/seekers')}}" + '?page=' + page;
            }
            if ($(this).hasClass('prev')) {
                $url = "{{url('/account/agency/dashboard/recommended_seeker/seekers')}}" + '?page=' + parseInt(active - 1);
            }
            if ($(this).hasClass('next')) {
                $url = "{{url('/account/agency/dashboard/recommended_seeker/seekers')}}" + '?page=' + parseInt(+active + +1);
            }
            if ($(this).hasClass('hellip_prev')) {
                $url = "{{url('/account/agency/dashboard/recommended_seeker/seekers')}}" + '?page=' + parseInt(hellip_prev - 1);
                page = parseInt(hellip_prev - 1);
            }
            if ($(this).hasClass('hellip_next')) {
                $url = "{{url('/account/agency/dashboard/recommended_seeker/seekers')}}" + '?page=' + parseInt(+hellip_next + +1);
                page = parseInt(+hellip_next + +1);
            }
            if ($(this).hasClass('first')) {
                $url = "{{url('/account/agency/dashboard/recommended_seeker/seekers')}}" + '?page=1';
            }
            if ($(this).hasClass('last')) {
                $url = "{{url('/account/agency/dashboard/recommended_seeker/seekers')}}" + '?page=' + last_page;
            }

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: $url,
                    type: "GET",
                    data: $("#form-src-seekers").serialize(),
                    beforeSend: function () {
                        $('#image').show();
                        $('#search-result').hide();
                        $('.myPagination').hide();
                    },
                    complete: function () {
                        $('#image').hide();
                        $('#search-result').show();
                        $('.myPagination').show();
                    },
                    success: function (data) {
                        successLoad(data, keyword, page);
                    },
                    error: function () {
                        swal({
                            title: 'Recommended Seeker',
                            text: 'Data not found!',
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            }.bind(this), 800);

            return false;
        });

        function successLoad(data, keyword, page) {
            var title, $q, total, $result = '', pagination = '', $page = '', $class, $style, $attr, $label, $salary;

            $q = keyword != "" ? ' for <strong>"' + keyword + '"</strong>' : '';
            if (data.total > 0) {
                title = data.total > 1 ? 'Showing <strong>' + data.total + '</strong> recommended seekers matched' :
                    'Showing a recommended seeker matched';

                total = $.trim(data.total) ? '<br>Page: <strong>' + data.from + '</strong> - ' +
                    '<strong>' + data.to + '</strong> of <strong>' + data.total + '</strong>' : '';

            } else {
                title = 'Showing <strong>0</strong> recommended seeker matched';
                total = '';
            }
            $('#show-result').html(title + $q + total);

            $.each(data.data, function (i, val) {
                if (val.inv == null) {
                    $class = ' ld ld-breath';
                    $style = '#00adb5';
                    $attr = '';
                    $label = 'INVITE'
                } else {
                    $class = '';
                    $style = '#393e46';
                    $attr = 'disabled';
                    $label = 'INVITED'
                }

                $salary = val.seeker.low == 0 || val.seeker.high == 0 ? 'Anything' :
                    'IDR ' + val.seeker.low + ' to ' + val.seeker.high + ' millions';

                $result +=
                    '<div class="media">' +
                    '<div class="media-left media-middle">' +
                    '<a href="{{route('seeker.profile',['id'=>''])}}/' + val.id + '">' +
                    '<img width="100" class="media-object" src="' + val.seeker.ava + '"></a></div>' +
                    '<div class="media-body">' +
                    '<small class="media-heading" style="font-size: 17px;">' +
                    '<a href="{{route('seeker.profile',['id'=>''])}}/' + val.seeker.id + '" ' +
                    'style="color: #00ADB5">' + val.seeker.name + '</a>' +
                    '<a href="mailto:' + val.seeker.email + '" style="color: #fa5555">' +
                    '<sub>&ndash; ' + val.seeker.email + '</sub></a></small>' +
                    '<blockquote style="font-size: 16px;color: #7f7f7f">' +
                    '<div class="pull-right">' +
                    '<button class="btn btn-danger btn-block' + $class + '"' +
                    'onclick="inviteSeeker(' + val.seeker.id + ')" ' +
                    'style="border: none;background: ' + $style + '"' + $attr + '>' +
                    '<i class="fa fa-envelope"></i>&ensp;' + $label + '</button></div>' +
                    '<ul class="list-inline">' +
                    '<li><a class="tag"><i class="fa fa-user-tie"></i>' +
                    '&ensp;' + val.jobTitle + '</a></li>' +
                    '<li><a class="tag"><i class="fa fa-briefcase"></i>' +
                    '&ensp;Work Experience: ' + val.total_exp + ' years</a></li>' +
                    '<li><a class="tag"><i class="fa fa-hand-holding-usd"></i>&ensp;' +
                    'Expected Salary: ' + $salary + '</a></li>' +
                    '<li><a class="tag"><i class="fa fa-graduation-cap"></i>&ensp;' +
                    'Latest Degree: ' + val.edu.last_deg + '</a></li>' +
                    '<li><a class="tag"><i class="fa fa-user-graduate"></i>&ensp;' +
                    'Latest Major: ' + val.edu.last_maj + '</a></li></ul>' +
                    '<table style="font-size: 12px">' +
                    '<tr><td><i class="fa fa-calendar-check"></i></td>' +
                    '<td>&nbsp;Member Since</td>' +
                    '<td> : ' + val.created_at + '</td></tr>' +
                    '<tr><td><i class="fa fa-clock"></i></td>' +
                    '<td>&nbsp;Last Update</td>' +
                    '<td> : ' + val.updated_at + '</td></tr></table></blockquote></div></div>' +
                    '<hr class="hr-divider">';
            });
            $("#search-result").empty().append($result);

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
                $page = '&page=' + page;
            }
            window.history.replaceState("", "", '{{url('/account/agency/dashboard/recommended_seeker')}}' +
                '?q=' + keyword + $page);
            return false;
        }

        function inviteSeeker(id) {
            $.ajax({
                url: "{{ url('account/agency/dashboard/recommended_seeker') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    var $low = data.lowest_salary / 1000000,
                        $high = data.highest_salary / 1000000;
                    $('#inviteSeeker').html(
                        '<form action = "{{route('invite.seeker')}}" method = "post" id = "form-invite-' + id + '" > ' +
                        '{{csrf_field()}}' +
                        '<input type="hidden" name="seeker_id" value="' + data.id + '">' +
                        '<div class="modal-body"> ' +
                        '<div class="box"> ' +
                        '<div class="content"> ' +
                        '<p style="font-size: 17px" align="justify">' +
                        'You will invite this seeker with the following details:</p>' +
                        '<hr class="hr-divider">' +
                        '<div class="row">' +
                        '<div class="col-lg-12">' +
                        '<div class="media">' +
                        '<div class="media-left media-middle">' +
                        '<a href="{{route('seeker.profile',['id' => ''])}}/' + data.id + '">' +
                        '<img width="100" class="media-object" src="' + data.user.ava + '"></a></div>' +
                        '<div class="media-body">' +
                        '<small class="media-heading" style = "font-size: 17px;">' +
                        '<a href="{{route('seeker.profile',['id'=>''])}}/' + data.id + '" ' +
                        'style = "color: #00ADB5">' + data.user.name + '</a>' +
                        '<a href="mailto:' + data.user.email + '" style="color: #fa5555">' +
                        '<sub>&ndash; ' + data.user.email + '</sub></a></small>' +
                        '<blockquote style="font-size: 16px;color: #7f7f7f">' +
                        '<ul class="list-inline">' +
                        '<li><a class="tag"><i class="fa fa-user-tie"></i>&ensp;' + data.jobTitle + '</a></li>' +
                        '<li><a class="tag"><i class="fa fa-briefcase"></i>&ensp;' +
                        'Work Experience: ' + data.total_exp + ' years</a></li>' +
                        '<li><a class="tag" id = "expected_salary' + data.id + '"></a></li>' +
                        '<li><a class="tag"><i class="fa fa-graduation-cap"></i>&ensp;' +
                        'Latest Degree: ' + data.edu.last_deg + '</a></li>' +
                        '<li><a class="tag"><i class="fa fa-user-graduate"></i>&ensp;' +
                        'Latest Major: ' + data.edu.last_maj + '</a></li></ul>' +
                        '<table style = "font-size: 12px" >' +
                        '<tr><td><i class="fa fa-calendar-check"></i></td>' +
                        '<td>&nbsp;Member Since </td>' +
                        '<td>:' + data.created_at + ' </td></tr>' +
                        '<tr><td><i class="fa fa-clock"></i></td>' +
                        '<td>&nbsp;Last Update </td>' +
                        '<td>:' + data.updated_at + ' </td></tr></table><hr>' +
                        '<div class="row form-group form">' +
                        '<div class="col-lg-12">' +
                        '<p align="justify" style="font-size:17px;margin-bottom: .5em">' +
                        'Select one of the following vacancies that you ' +
                        'have in order to offer it for this Job Seeker.</p>' +
                        '<div class="input-group">' +
                        '<span class="input-group-addon"><i class="fa fa-briefcase"></i></span > ' +
                        '<select class="form-control selectpicker" name="vacancy_id" data-container = "body" ' +
                        'id="vacancy_id" required>' +
                        '<option value = "" selected disabled>--Choose Vacancy--</option>' +
                            @foreach($vacancies as $vacancy)
                                '<option value = "{{$vacancy->id}}" {{$vacancy->isPost == false ? 'disabled' : ''}}>' +
                        '{{$vacancy->judul}}</option>' +
                            @endforeach
                                '</select></div>' +
                        '<small style = "font-size: 10px;color: #FA5555">' +
                        'P.S.: You\'re only permitted to select your vacancy that has been posted.</small>' +
                        '</div></div></blockquote></div></div></div></div></div></div></div>' +
                        '<div class="modal-footer">' +
                        '<div class="card-read-more" id = "btn-invite">' +
                        '<button class="btn btn-link btn-block" type = "button">' +
                        '<i class="fa fa-envelope"></i>&ensp;INVITE</button></div></div></form>'
                    );
                    $('#expected_salary' + id).html('<i class="fa fa-hand-holding-usd"></i>&ensp;' +
                        'Expected Salary: IDR ' + $low + ' to ' + $high + ' millions');
                    $('#vacancy_id').selectpicker('render');
                    $("#inviteModal").modal('show');

                    $("#btn-invite button").on("click", function () {
                        if ($("#vacancy_id").val()) {
                            $("#inviteModal").modal('hide');
                            $('#form-invite-' + id)[0].submit();
                        } else {
                            swal({
                                title: 'ATTENTION!',
                                text: 'Please select one of your vacancies in order to offer it for this Job Seeker.',
                                type: 'warning',
                                timer: '3500'
                            });
                        }
                    });
                },
                error: function () {
                    swal({
                        title: 'Oops...',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    });
                }
            });
        }
    </script>
@endpush