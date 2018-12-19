@section('title', ''.$user->name.'\'s Dashboard &ndash; Bookmarked Vacancy | SISKA &mdash; Sistem Informasi Karier')
@extends('layouts.auth.mst_seeker')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Bookmarked Vacancy</h4>
                            <small>Here is your bookmarked vacancies.</small>
                            <hr>
                            <form id="form-loadAccInv">
                                <input type="hidden" name="seeker_id" value="{{$seeker->id}}">
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
                                     data-placement="top" title="Bookmarked Date Filter">
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
@endsection
@push('scripts')
    <script>
        $(function () {
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
            loadAccInv(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
        }

        function loadAccInv(date) {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: "{{route('get.bookmarked.vacancies')}}",
                    type: "GET",
                    data: $("#form-loadAccInv").serialize(),
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
                            title: 'Bookmarked Vacancy',
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
                $url = "{{url('/account/job_vacancy/bookmarked_vacancy/vacancies')}}" + '?page=' + page;
            }
            if ($(this).hasClass('prev')) {
                $url = "{{url('/account/job_vacancy/bookmarked_vacancy/vacancies')}}" + '?page=' + parseInt(active - 1);
            }
            if ($(this).hasClass('next')) {
                $url = "{{url('/account/job_vacancy/bookmarked_vacancy/vacancies')}}" + '?page=' + parseInt(+active + +1);
            }
            if ($(this).hasClass('hellip_prev')) {
                $url = "{{url('/account/job_vacancy/bookmarked_vacancy/vacancies')}}" + '?page=' + parseInt(hellip_prev - 1);
                page = parseInt(hellip_prev - 1);
            }
            if ($(this).hasClass('hellip_next')) {
                $url = "{{url('/account/job_vacancy/bookmarked_vacancy/vacancies')}}" + '?page=' + parseInt(+hellip_next + +1);
                page = parseInt(+hellip_next + +1);
            }
            if ($(this).hasClass('first')) {
                $url = "{{url('/account/job_vacancy/bookmarked_vacancy/vacancies')}}" + '?page=1';
            }
            if ($(this).hasClass('last')) {
                $url = "{{url('/account/job_vacancy/bookmarked_vacancy/vacancies')}}" + '?page=' + last_page;
            }

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: $url,
                    type: "GET",
                    data: $("#form-loadAccInv").serialize(),
                    beforeSend: function () {
                        $('#image').show();
                        $('#search-result, #vac-control, .myPagination').hide();
                    },
                    complete: function () {
                        $('#image').hide();
                        $('#search-result, #vac-control, .myPagination').show();
                    },
                    success: function (data) {
                        console.log(data.data);
                        successLoad(data, date, page);
                    },
                    error: function () {
                        swal({
                            title: 'Bookmarked Vacancy',
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
            var title, total, $date, $result = '', pagination = '', $page = '',
                $display, $recruitmentDate, $pengalaman, $style_quiz, $style_psychoTest, $param;

            if (data.total > 0) {
                title = data.total > 1 ? 'Showing <strong>' + data.total + '</strong> bookmarked vacancies' :
                    'Showing a bookmarked vacancy';

                $date = date != undefined ? ' for <strong>"' + date + '"</strong>' : ' for <strong>"{{today()
                ->startOfMonth()->formatLocalized('%d %b %Y')." - ".today()
                ->endOfMonth()->formatLocalized('%d %b %Y')}}"</strong>';

                total = $.trim(data.total) ? ' (<strong>' + data.from + '</strong> - ' +
                    '<strong>' + data.to + '</strong> of <strong>' + data.total + '</strong>)' : '';

            } else {
                title = '<em>There seems to be none of the bookmarked vacancy was found&hellip;</em>';
                total = '';
                $date = '';
            }
            $('#show-result').html(title + $date + total);

            $.each(data.data, function (i, val) {
                $recruitmentDate = val.vacancy.recruitmentDate_start == "-" ||
                val.vacancy.recruitmentDate_end == "-" ? '-' :
                    val.vacancy.recruitmentDate_start + ' - ' + val.vacancy.recruitmentDate_end;

                $pengalaman = val.vacancy.pengalaman > 1 ? 'At least ' + val.vacancy.pengalaman + ' years' :
                    'At least ' + val.vacancy.pengalaman + ' year';

                $style_quiz = val.vacancy.isQuiz == 1 ? '' : 'none';
                $style_psychoTest = val.vacancy.isPsychoTest == 1 ? '' : 'none';

                $display = '{{today()}}' <= val.vacancy.checkDate_end ? '' : 'none';

                $param = val.vacancy.id + ",'" + val.vacancy.judul + "'";

                $result +=
                    '<div class="media">' +
                    '<div class="media-left media-middle">' +
                    '<a href="{{route('agency.profile',['id'=>''])}}/' + val.user.id + '">' +
                    '<img width="100" class="media-object" src="' + val.user.ava + '"></a></div>' +
                    '<div class="media-body">' +
                    '<small class="media-heading" style="font-size: 17px;">' +
                    '<a href="{{route('detail.vacancy',['id'=>''])}}/' + val.vacancy.id + '" ' +
                    'style="color: #00ADB5">' + val.vacancy.judul + '</a>' +
                    '<a href="{{route('agency.profile',['id'=>''])}}/' + val.user.id + '" style="color: #fa5555">' +
                    '<sub>&ndash; ' + val.user.name + '</sub></a>' +
                    '<span class="pull-right" style="color: #fa5555">Bookmarked on ' + val.created_at + '</span>' +
                    '</small>' +
                    '<blockquote style="font-size: 16px;color: #7f7f7f">' +
                    '<form class="pull-right" id="form-bookmark-' + val.vacancy.id + '" method="post" ' +
                    'action="{{route('bookmark.vacancy')}}">{{csrf_field()}}' +
                    '<div class="anim-icon anim-icon-md bookmark" onclick="removeBookmark(' + $param + ')" ' +
                    'data-toggle="tooltip" data-placement="bottom" title="Unmark" style="font-size: 25px">' +
                    '<input type="hidden" name="vacancy_id" value="' + val.vacancy.id + '">' +
                    '<input id="bookmark' + val.vacancy.id + '" type="checkbox" checked>' +
                    '<label for="bookmark' + val.vacancy.id + '"></label></div></form>' +
                    '<ul class="list-inline">' +
                    '<li><a target="_blank" href="{{route('search.vacancy',['loc'=>''])}}' + val.vacancy.city + '" ' +
                    'class="tag"><i class="fa fa-map-marked"></i>&ensp;' + val.vacancy.city + '</a></li>' +
                    '<li><a target="_blank" class="tag" ' +
                    'href="{{route('search.vacancy',['jobfunc_ids'=>''])}}' + val.vacancy.fungsikerja_id + '">' +
                    '<i class="fa fa-warehouse"></i>&ensp;' + val.vacancy.job_func + '</a></li>' +
                    '<li><a target="_blank" class="tag" ' +
                    'href="{{route('search.vacancy',['industry_ids'=>''])}}' + val.vacancy.industry_id + '">' +
                    '<i class="fa fa-industry"></i>&ensp;' + val.vacancy.industry + '</a></li>' +
                    '<li><a target="_blank" class="tag" ' +
                    'href="{{route('search.vacancy',['salary_ids'=>''])}}' + val.vacancy.salary_id + '">' +
                    '<i class="fa fa-money-bill-wave"></i>&ensp;IDR ' + val.vacancy.salary + '</a></li>' +
                    '<li><a target="_blank" class="tag" ' +
                    'href="{{route('search.vacancy',['degrees_ids'=>''])}}' + val.vacancy.tingkatpend_id + '">' +
                    '<i class="fa fa-graduation-cap"></i>&ensp;' + val.vacancy.degrees + '</a></li>' +
                    '<li><a target="_blank" class="tag" ' +
                    'href="{{route('search.vacancy',['majors_ids'=>''])}}' + val.vacancy.jurusanpend_id + '">' +
                    '<i class="fa fa-user-graduate"></i>&ensp;' + val.vacancy.majors + '</a></li>' +
                    '<li><a class="tag"><i class="fa fa-briefcase"></i>&ensp;' + $pengalaman + '</a></li>' +
                    '<li><a class="tag tag-plans"><i class="fa fa-paper-plane"></i>&ensp;' +
                    '<strong>' + val.vacancy.total_app + '</strong> applicants</a></li></ul>' +
                    '<table style="font-size: 14px;margin-top: -.5em">' +
                    '<tr><td><i class="fa fa-users"></i></td>' +
                    '<td>&nbsp;Recruitment Date</td>' +
                    '<td>: ' + $recruitmentDate + '</td></tr>' +
                    '<tr style="display: ' + $style_quiz + '"><td><i class="fa fa-grin-beam"></i></td>' +
                    '<td>&nbsp;Online Quiz (TPA & TKD) Date</td>' +
                    '<td>: ' + val.vacancy.quizDate + '</td></tr>' +
                    '<tr style="display: ' + $style_psychoTest + '"><td><i class="fa fa-comments"></i></td>' +
                    '<td>&nbsp;Psycho Test (Online Interview) Date</td>' +
                    '<td>: ' + val.vacancy.psychoTestDate + '</td></tr>' +
                    '<tr><td><i class="fa fa-user-tie"></i></td>' +
                    '<td>&nbsp;Job Interview Date</td>' +
                    '<td>: ' + val.vacancy.interview_date + '</td></tr>' +
                    '<tr><td><i class="fa fa-clock"></i></td>' +
                    '<td>&nbsp;Last Update</td>' +
                    '<td>: ' + val.vacancy.updated_at + '</td></tr></table>' +
                    '</blockquote></div></div><hr class="hr-divider">';
            });
            $("#search-result").empty().append($result);
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
            window.history.replaceState("", "", '{{url('/account/job_vacancy/bookmarked_vacancy')}}' + $page);
            return false;
        }

        function removeBookmark(id, title) {
            swal({
                title: 'Are you sure to unmark ' + title + '?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, unmark it!',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
            }).then(function () {
                $("#bookmark" + id).prop('checked', false);
                $("#form-bookmark-" + id)[0].submit();
            }, function (dismiss) {
                if (dismiss == 'cancel') {
                    $("#bookmark" + id).prop('checked', true);
                }
            });
        }
    </script>
@endpush