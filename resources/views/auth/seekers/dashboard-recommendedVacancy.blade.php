@section('title', ''.$user->name.'\'s Dashboard &ndash; Recommended Vacancy | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_seeker')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Recommended Vacancy</h4>
                            <small>
                                Here is our recommended vacancies based on your work experience and education history.
                            </small>
                            <hr>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: .5em">
                        <div class="col-lg-5 to-animate-2">
                            <form id="form-src-vacancies" action="#">
                                <div id="custom-search-input">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-lg" id="btn_more"
                                                    data-toggle="tooltip" title="Advance Search">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                        <input id="txt_keyword" type="text" name="q" style="width: auto;"
                                               class="form-control myInput input-lg"
                                               onkeyup="showResetBtn(this.value)"
                                               placeholder="Job Title or Agency's Name&hellip;"
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
                            <small class="pull-right" id="show-result"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 to-animate">
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
    <div class="modal to-animate login" id="applyModal" style="font-family: 'PT Sans', Arial, serif">
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
    <div class="modal fade login" id="resumeModal" style="font-family: 'PT Sans', Arial, serif">
        <div class="modal-dialog login animated">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Resume Incomplete</h4>
                </div>
                <div class="modal-body">
                    <div class="box">
                        <div class="content" style="font-size: 16px">
                            Required data to be completed before applying:
                            <ol>
                                <li>Your personal data (gender, phone number, address, and date of birth)</li>
                                <li>Education or work experience (at least one)</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="card-read-more">
                        <a class="btn btn-link btn-block" href="{{route('seeker.edit.profile')}}">
                            <i class="fa fa-user"></i>&ensp;Go to resume</a>
                    </div>
                </div>
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

            $.get('/account/job_vacancy/recommended_vacancy/vacancies?q=' + keyword + $page, function (data) {
                last_page = data.last_page;
                successLoad(data, keyword, page);
            });
        });

        $('#txt_keyword').on('keyup', function () {
            loadVacancy();
        });

        $("#form-src-vacancies").on('submit', function (event) {
            event.preventDefault();
            loadVacancy();
        });

        function resetFilter() {
            $("#txt_keyword").removeAttr('value');
            loadVacancy();
        }

        function loadVacancy() {
            var keyword = $("#txt_keyword").val();

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: "{{route('get.recommended.vacancy')}}",
                    type: "GET",
                    data: $("#form-src-vacancies").serialize(),
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
                            title: 'Recommended Vacancy',
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
                $url = "{{url('/account/job_vacancy/recommended_vacancy/vacancies')}}" + '?page=' + page;
            }
            if ($(this).hasClass('prev')) {
                $url = "{{url('/account/job_vacancy/recommended_vacancy/vacancies')}}" + '?page=' + parseInt(active - 1);
            }
            if ($(this).hasClass('next')) {
                $url = "{{url('/account/job_vacancy/recommended_vacancy/vacancies')}}" + '?page=' + parseInt(+active + +1);
            }
            if ($(this).hasClass('hellip_prev')) {
                $url = "{{url('/account/job_vacancy/recommended_vacancy/vacancies')}}" + '?page=' + parseInt(hellip_prev - 1);
                page = parseInt(hellip_prev - 1);
            }
            if ($(this).hasClass('hellip_next')) {
                $url = "{{url('/account/job_vacancy/recommended_vacancy/vacancies')}}" + '?page=' + parseInt(+hellip_next + +1);
                page = parseInt(+hellip_next + +1);
            }
            if ($(this).hasClass('first')) {
                $url = "{{url('/account/job_vacancy/recommended_vacancy/vacancies')}}" + '?page=1';
            }
            if ($(this).hasClass('last')) {
                $url = "{{url('/account/job_vacancy/recommended_vacancy/vacancies')}}" + '?page=' + last_page;
            }

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: $url,
                    type: "GET",
                    data: $("#form-src-vacancies").serialize(),
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
                            title: 'Recommended Vacancy',
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
            var title, $result = '', pagination = '', $page = '', $class1, $class2, $style, $attr, $prop, $label,
                $tooltip, $recruitmentDate, $pengalaman, $style_quiz, $style_psychoTest;

            title = 'for <strong>"' + keyword + '"</strong>';
            if (data.total != 0) {
                if ($.trim(data.total)) {
                    total = ' (<strong>' + data.from + '</strong> - <strong>' + data.to + '</strong> of ' +
                        '<strong>' + data.total + '</strong>)';
                } else {
                    total = '';
                }
                $('#show-result').html('Showing <strong>' + data.total + '</strong> recommended vacancies matched ' + title + total);
            } else {
                $('#show-result').html('Showing <strong>' + data.total + '</strong> recommended vacancies matched ' + title);
            }
            $.each(data.data, function (i, val) {
                $('[data-toggle="tooltip"]').tooltip();

                if (val.acc == null || val.acc.isApply == false) {
                    $class1 = ' ld ld-heartbeat';
                    $style = '#fa5555';
                    $attr = '';
                    $label = 'APPLY';
                } else if (val.acc.isApply == true) {
                    $class1 = '';
                    $style = '#393e46';
                    $attr = 'disabled';
                    $label = 'APPLIED'
                }
                if (val.acc == null || val.acc.isBookmark == false) {
                    $prop = '';
                    $class2 = ' ld ld-breath';
                    $tooltip = 'Bookmark';
                } else if (val.acc.isBookmark == true) {
                    $prop = 'checked';
                    $class2 = '';
                    $tooltip = 'Unmark';
                }

                $recruitmentDate = val.recruitmentDate_start == "-" || val.recruitmentDate_end == "-" ? '-' :
                    val.recruitmentDate_start + ' - ' + val.recruitmentDate_end;

                $pengalaman = val.pengalaman > 1 ? 'At least ' + val.pengalaman + ' years' :
                    'At least ' + val.pengalaman + ' year';

                $style_quiz = val.isQuiz == 1 ? '' : 'none';
                $style_psychoTest = val.isPsychoTest == 1 ? '' : 'none';

                $result +=
                    '<div class="media">' +
                    '<div class="media-left media-middle">' +
                    '<a href="{{route('agency.profile',['id'=>''])}}/' + val.user.id + '">' +
                    '<img width="100" class="media-object" src="' + val.user.ava + '"></a></div>' +
                    '<div class="media-body">' +
                    '<small class="media-heading" style="font-size: 17px;">' +
                    '<a href="{{route('detail.vacancy',['id'=>''])}}/' + val.id + '" ' +
                    'style="color: #00ADB5">' + val.judul + '</a>' +
                    '<a href="{{route('agency.profile',['id'=>''])}}/' + val.user.id + '" style="color: #fa5555">' +
                    '<sub>&ndash; ' + val.user.name + '</sub></a></small>' +
                    '<blockquote style="font-size: 16px;color: #7f7f7f">' +
                    '<div class="pull-right">' +
                    '<button class="btn btn-danger btn-block' + $class1 + '"' +
                    'onclick="applyVacancy(' + val.id + ')" ' +
                    'style="border: none;background: ' + $style + '"' + $attr + '>' +
                    '<i class="fa fa-paper-plane"></i>&ensp;' + $label + '</button>' +
                    '<form class="pull-right" id="form-bookmark-' + val.id + '" method="post" ' +
                    'action="{{route('bookmark.vacancy')}}">{{csrf_field()}}' +
                    '<div class="anim-icon anim-icon-md bookmark ' + $class2 + '" ' +
                    'data-toggle="tooltip" data-placement="bottom" title="' + $tooltip + '" style="font-size: 25px">' +
                    '<input type="hidden" name="vacancy_id" value="' + val.id + '">' +
                    '<input id="bookmark' + val.id + '" type="checkbox" ' + $prop + '>' +
                    '<label for="bookmark' + val.id + '" onclick="bookmarkVacancy(' + val.id + ')">' +
                    '</label></div></form></div>' +
                    '<ul class="list-inline">' +
                    '<li><a target="_blank" href="{{route('search.vacancy',['loc'=>''])}}' + val.city + '" class="tag">' +
                    '<i class="fa fa-map-marked"></i>&ensp;' + val.city + '</a></li>' +
                    '<li><a target="_blank" href="{{route('search.vacancy',['jobfunc_ids'=>''])}}' + val.fungsikerja_id + '" ' +
                    'class="tag"><i class="fa fa-warehouse"></i>&ensp;' + val.job_func + '</a></li>' +
                    '<li><a target="_blank" href="{{route('search.vacancy',['industry_ids'=>''])}}' + val.industry_id + '" ' +
                    'class="tag"><i class="fa fa-industry"></i>&ensp;' + val.industry + '</a></li>' +
                    '<li><a target="_blank" href="{{route('search.vacancy',['salary_ids'=>''])}}' + val.salary_id + '" ' +
                    'class="tag"><i class="fa fa-money-bill-wave"></i>&ensp;IDR ' + val.salary + '</a></li>' +
                    '<li><a target="_blank" href="{{route('search.vacancy',['degrees_ids'=>''])}}' + val.tingkatpend_id + '" ' +
                    'class="tag"><i class="fa fa-graduation-cap"></i>&ensp;' + val.degrees + '</a></li>' +
                    '<li><a target="_blank" href="{{route('search.vacancy',['majors_ids'=>''])}}' + val.jurusanpend_id + '" ' +
                    'class="tag"><i class="fa fa-user-graduate"></i>&ensp;' + val.majors + '</a></li>' +
                    '<li><a class="tag"><i class="fa fa-briefcase"></i>&ensp;' + $pengalaman + '</a></li>' +
                    '<li><a class="tag tag-plans"><i class="fa fa-paper-plane"></i>&ensp;' +
                    '<strong>' + val.total_app + '</strong> applicants</a></li></ul>' +
                    '<table style="font-size: 14px;margin-top: -.5em">' +
                    '<tr><td><i class="fa fa-users"></i></td>' +
                    '<td>&nbsp;Recruitment Date</td>' +
                    '<td>: ' + $recruitmentDate + '</td></tr>' +
                    '<tr style="display: ' + $style_quiz + '"><td><i class="fa fa-grin-beam"></i></td>' +
                    '<td>&nbsp;Online Quiz (TPA & TKD) Date</td>' +
                    '<td>: ' + val.quizDate + '</td></tr>' +
                    '<tr style="display: ' + $style_psychoTest + '"><td><i class="fa fa-comments"></i></td>' +
                    '<td>&nbsp;Psycho Test (Online Interview) Date</td>' +
                    '<td>: ' + val.psychoTestDate + '</td></tr>' +
                    '<tr><td><i class="fa fa-user-tie"></i></td>' +
                    '<td>&nbsp;Job Interview Date</td>' +
                    '<td>: ' + val.interview_date + '</td></tr>' +
                    '<tr><td><i class="fa fa-clock"></i></td>' +
                    '<td>&nbsp;Last Update</td>' +
                    '<td>: ' + val.updated_at + '</td></tr></table>' +
                    '</blockquote></div></div><hr class="hr-divider">';
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
            window.history.replaceState("", "", '{{url('/account/job_vacancy/recommended_vacancy')}}' +
                '?q=' + keyword + $page);
            return false;
        }

        function applyVacancy(id) {
            $.ajax({
                url: "{{ url('account/job_vacancy/recommended_vacancy') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    var today = new Date().toJSON().slice(0, 10),
                        $pengalaman = data.pengalaman > 1 ? 'At least ' + data.pengalaman + ' years' :
                            'At least ' + data.pengalaman + ' year',
                        $style_quiz = data.isQuiz == 1 ? '' : 'none',
                        $style_psychoTest = data.isPsychoTest == 1 ? '' : 'none';

                    $('#inviteSeeker').html(
                        '<form action = "{{route('apply.vacancy')}}" method = "post" id = "form-apply-' + id + '" > ' +
                        '{{csrf_field()}}' +
                        '<input type="hidden" name="vacancy_id" value="' + data.id + '">' +
                        '<div class="modal-body"> ' +
                        '<div class="box"> ' +
                        '<div class="content"> ' +
                        '<p style="font-size: 17px" align="justify">' +
                        'Complete data will make you a lot easier to apply for any jobs and the agency (HRD) ' +
                        'is interested with. You will register for this vacancy with the following details:</p>' +
                        '<hr class="hr-divider">' +
                        '<div class="row">' +
                        '<div class="col-lg-12">' +
                        '<div class="media">' +
                        '<div class="media-left media-middle">' +
                        '<a href="{{route('agency.profile',['id'=>''])}}/' + data.user.id + '">' +
                        '<img width="100" class="media-object" src="' + data.user.ava + '"></a></div>' +
                        '<div class="media-body">' +
                        '<small class="media-heading" style="font-size: 17px;">' +
                        '<a href="{{route('detail.vacancy',['id'=>''])}}/' + data.id + '" ' +
                        'style="color: #00ADB5">' + data.judul + '</a>' +
                        '<a href="{{route('agency.profile',['id'=>''])}}/' + data.user.id + '" style="color: #fa5555">' +
                        '<sub>&ndash; ' + data.user.name + '</sub></a></small>' +
                        '<blockquote style="font-size: 16px;color: #7f7f7f">' +
                        '<ul class="list-inline">' +
                        '<li><a target="_blank" href="{{route('search.vacancy',['loc'=>''])}}' + data.city + '" class="tag">' +
                        '<i class="fa fa-map-marked"></i>&ensp;' + data.city + '</a></li>' +
                        '<li><a target="_blank" href="{{route('search.vacancy',['jobfunc_ids'=>''])}}' + data.fungsikerja_id + '" ' +
                        'class="tag"><i class="fa fa-warehouse"></i>&ensp;' + data.job_func + '</a></li>' +
                        '<li><a target="_blank" href="{{route('search.vacancy',['industry_ids'=>''])}}' + data.industry_id + '" ' +
                        'class="tag"><i class="fa fa-industry"></i>&ensp;' + data.industry + '</a></li>' +
                        '<li><a target="_blank" href="{{route('search.vacancy',['salary_ids'=>''])}}' + data.salary_id + '" ' +
                        'class="tag"><i class="fa fa-money-bill-wave"></i>&ensp;IDR ' + data.salary + '</a></li>' +
                        '<li><a target="_blank" href="{{route('search.vacancy',['degrees_ids'=>''])}}' + data.tingkatpend_id + '" ' +
                        'class="tag"><i class="fa fa-graduation-cap"></i>&ensp;' + data.degrees + '</a></li>' +
                        '<li><a target="_blank" href="{{route('search.vacancy',['majors_ids'=>''])}}' + data.jurusanpend_id + '" ' +
                        'class="tag"><i class="fa fa-user-graduate"></i>&ensp;' + data.majors + '</a></li>' +
                        '<li><a class="tag"><i class="fa fa-briefcase"></i>&ensp;' + $pengalaman + '</a></li>' +
                        '<li><a class="tag tag-plans"><i class="fa fa-paper-plane"></i>&ensp;' +
                        '<strong>' + data.total_app + '</strong> applicants</a></li></ul>' +
                        '<table style="font-size: 14px;margin-top: -.5em">' +
                        '<tr><td><i class="fa fa-users"></i></td>' +
                        '<td>&nbsp;Recruitment Date</td>' +
                        '<td>: ' + data.recruitment_date + '</td></tr>' +
                        '<tr style="display: ' + $style_quiz + '"><td><i class="fa fa-grin-beam"></i></td>' +
                        '<td>&nbsp;Online Quiz (TPA & TKD) Date</td>' +
                        '<td>: ' + data.quizDate + '</td></tr>' +
                        '<tr style="display: ' + $style_psychoTest + '"><td><i class="fa fa-comments"></i></td>' +
                        '<td>&nbsp;Psycho Test (Online Interview) Date</td>' +
                        '<td>: ' + data.psychoTestDate + '</td></tr>' +
                        '<tr><td><i class="fa fa-comments"></i></td>' +
                        '<td>&nbsp;Interview Date</td>' +
                        '<td>: ' + data.interview_date + '</td></tr>' +
                        '<tr><td><i class="fa fa-clock"></i></td>' +
                        '<td>&nbsp;Last Update</td>' +
                        '<td>: ' + data.updated_at + '</td></tr></table>' +
                        '</blockquote></div></div></div></div></div></div></div>' +
                        '<div class="modal-footer">' +
                        '<div class="card-read-more" id="btn-apply">' +
                        '<button class="btn btn-link btn-block" type = "button">' +
                        '<i class="fa fa-paper-plane"></i>&ensp;APPLY</button></div></div></form>'
                    );
                    $("#applyModal").modal('show');
                    $("#btn-apply button").on("click", function () {
                        if (data.recruitmentDate_start == null || today < data.recruitmentDate_start) {
                            swal({
                                title: 'ATTENTION!',
                                text: 'The recruitment date of ' + data.judul + ' hasn\'t started yet.',
                                type: 'warning',
                                timer: '5500'
                            });
                        } else if (data.recruitmentDate_end == null || today > data.recruitmentDate_end) {
                            swal({
                                title: 'ATTENTION!',
                                text: 'The recruitment date of ' + data.judul + ' has been ended.',
                                type: 'warning',
                                timer: '5500'
                            });
                        } else if (today >= data.recruitmentDate_start && today <= data.recruitmentDate_end) {
                            @if(!\App\Experience::where('seeker_id',$seeker->id)->count() ||
                            !\App\Education::where('seeker_id',$seeker->id)->count() ||
                            $seeker->phone == "" || $seeker->address == "" ||
                            $seeker->birthday == "" || $seeker->gender == "")
                            $("#resumeModal").modal('show');
                            @else
                            $('#form-apply-' + data.id)[0].submit();
                            @endif
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

        function bookmarkVacancy(id) {
            $("#form-bookmark-" + id)[0].submit();
        }

        $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function () {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });

        $("#btn_more").on("click", function () {
            window.location.href = '{{route('search.vacancy')}}?q=' + $("#txt_keyword").val()
        });
    </script>
@endpush