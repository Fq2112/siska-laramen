@section('title', ''.$user->name.'\'s Dashboard &ndash; Job Invitation | '.env('APP_NAME'))
@extends('layouts.auth.mst_seeker')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="margin-bottom: 10px">Job Invitation</h4>
                            <small>Here is your job invitations from agencies.</small>
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
                        <div class="col-lg-12 to-animate">
                            <small class="pull-right">
                            </small>
                        </div>
                    </div>
                    <div class="row" style="margin: 0">
                        <div class="row" id="vac-control">
                            <div class="col-lg-4 to-animate-2">
                                <div id="daterangepicker" class="myDateRangePicker" data-toggle="tooltip"
                                     data-placement="top" title="Invited Date Filter">
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
    <div class="modal to-animate login" id="applyInvModal" style="font-family: 'PT Sans', Arial, serif">
        <div class="modal-dialog login animated" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Hi {{Auth::user()->name}},</h4>
                </div>
                <div class="modal-body">
                    <div class="box">
                        <div class="content">
                            <p style="font-size: 17px" align="justify">
                                By applying this invitation, you do not need to follow the entire vacancy schedule,
                                but only need to wait for further notification from the agency.</p>
                            <hr class="hr-divider">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="media">
                                        <div class="media-left media-middle">
                                            <a id="agencyID">
                                                <img width="100" class="media-object" id="agencyAva">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <small class="media-heading">
                                                <a style="color: #00ADB5" id="vacJudul">Editor</a>
                                                <sub>– <a id="agencyName">Rabbit Media</a></sub>
                                            </small>
                                            <blockquote style="font-size: 12px;color: #7f7f7f">
                                                <ul class="list-inline">
                                                    <li><a class="tag" target="_blank" id="vacLoc"></a></li>
                                                    <li><a class="tag" target="_blank" id="vacJobFunc"></a></li>
                                                    <li><a class="tag" target="_blank" id="vacIndustry"></a></li>
                                                    <li><a class="tag" target="_blank" id="vacSalary"></a></li>
                                                    <li><a class="tag" target="_blank" id="vacDegree"></a></li>
                                                    <li><a class="tag" target="_blank" id="vacMajor"></a></li>
                                                    <li><a class="tag" id="vacExp"></a></li>
                                                    <li><a class="tag tag-plans"><i class="fa fa-paper-plane"></i>
                                                            <strong class="vacTotalApp"></strong> applicant(s)
                                                        </a>
                                                    </li>
                                                </ul>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="card-read-more" id="btn-apply">
                        <form method="post" action="{{route('seeker.jobInvitation.apply')}}" id="form-apply">
                            {{csrf_field()}} {{method_field('PUT')}}
                            <input type="hidden" name="invitation_id" id="invitation_id">
                            <button class="btn btn-link btn-block" type="submit">
                                <i class="fa fa-paper-plane"></i>&ensp;Apply
                            </button>
                        </form>
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
                    url: "{{route('get.inv.vacancies')}}",
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
                            title: 'Job Invitation',
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
                $url = "{{url('/account/dashboard/job_invitation/vacancies')}}" + '?page=' + page;
            }
            if ($(this).hasClass('prev')) {
                $url = "{{url('/account/dashboard/job_invitation/vacancies')}}" + '?page=' + parseInt(active - 1);
            }
            if ($(this).hasClass('next')) {
                $url = "{{url('/account/dashboard/job_invitation/vacancies')}}" + '?page=' + parseInt(+active + +1);
            }
            if ($(this).hasClass('hellip_prev')) {
                $url = "{{url('/account/dashboard/job_invitation/vacancies')}}" + '?page=' + parseInt(hellip_prev - 1);
                page = parseInt(hellip_prev - 1);
            }
            if ($(this).hasClass('hellip_next')) {
                $url = "{{url('/account/dashboard/job_invitation/vacancies')}}" + '?page=' + parseInt(+hellip_next + +1);
                page = parseInt(+hellip_next + +1);
            }
            if ($(this).hasClass('first')) {
                $url = "{{url('/account/dashboard/job_invitation/vacancies')}}" + '?page=1';
            }
            if ($(this).hasClass('last')) {
                $url = "{{url('/account/dashboard/job_invitation/vacancies')}}" + '?page=' + last_page;
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
                        successLoad(data, date, page);
                    },
                    error: function () {
                        swal({
                            title: 'Job Invitation',
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
            var title, total, $date, $result = '', pagination = '', $page = '', $class, $color, $attr, $label,
                $display, $recruitmentDate, $pengalaman, $style_quiz, $style_psychoTest, $param, $param2;

            if (data.total > 0) {
                title = data.total > 1 ? 'Showing <strong>' + data.total + '</strong> job invitations' :
                    'Showing a job invitation';

                $date = date != undefined ? ' for <strong>"' + date + '"</strong>' : ' for <strong>"{{today()
                ->startOfMonth()->formatLocalized('%d %b %Y')." - ".today()
                ->endOfMonth()->formatLocalized('%d %b %Y')}}"</strong>';

                total = $.trim(data.total) ? ' (<strong>' + data.from + '</strong> - ' +
                    '<strong>' + data.to + '</strong> of <strong>' + data.total + '</strong>)' : '';

            } else {
                title = '<em>There seems to be none of the job invitation was found&hellip;</em>';
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

                $display = val.isApply == 1 && '{{today()}}' <= val.vacancy.checkDate_end ? '' : 'none';

                $class = val.isApply == 0 ? 'ld ld-breath' : '';
                $color = val.isApply == 0 ? '#fa5555' : '#393e46';
                $attr = val.isApply == 0 ? '' : 'disabled';
                $label = val.isApply == 0 ? 'APPLY' : 'APPLIED';

                $param = val.vacancy.id + ",'" + val.vacancy.judul + "'";
                $param2 = val.vacancy.id + ",'" + val.vacancy.judul + "'," + val.id;

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
                    '<span class="pull-right" style="color: #fa5555">Invited on ' + val.created_at + '</span>' +
                    '</small>' +
                    '<blockquote style="font-size: 16px;color: #7f7f7f">' +
                    '<div class="pull-right">' +
                    '<button class="btn btn-danger btn-block ' + $class + '" onclick="showapplyInvModal(' + $param2 + ')" ' +
                    'style="border: none;background: ' + $color + '" ' + $attr + '>' +
                    '<i class="fa fa-paper-plane"></i>&ensp;' + $label + '</button></div>' +
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
                    '<hr style="display:' + $display + ';margin-bottom: 0">' +
                    '<form style="display:' + $display + '" id="form-apply-' + val.vacancy.id + '" method="post" ' +
                    'action="{{route('seeker.jobInvitation.apply')}}">{{csrf_field()}}{{method_field('PUT')}}' +
                    '<div class="anim-icon anim-icon-md apply ld ld-heartbeat" ' +
                    'onclick="abortApplication(' + $param + ')" data-toggle="tooltip" data-placement="right" ' +
                    'title="Click here to abort this application!" style="font-size: 15px">' +
                    '<input type="hidden" name="invitation_id" ' +
                    'id="invitation_id' + val.id + '" value="' + val.id + '">' +
                    '<input id="apply' + val.vacancy.id + '" type="checkbox" checked>' +
                    '<label for="apply' + val.vacancy.id + '"></label></div></form>' +
                    '<small style="display:' + $display + '">' +
                    'P.S.: Job Seekers are only permitted to abort their application ' +
                    'before the recruitment ends.</small>' +
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
            window.history.replaceState("", "", '{{url('/account/dashboard/job_invitation')}}' + $page);
            return false;
        }

        function showapplyInvModal(id, title, invitation_id) {
            var today = new Date().toJSON().slice(0, 10), $pengalaman;
            $.ajax({
                url: "{{ url('account/dashboard/application_status/compare') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    if (today >= data.recruitmentDate_start && today <= data.recruitmentDate_end) {

                        $pengalaman = data.pengalaman > 1 ? 'At least ' + data.pengalaman + ' years' :
                            'At least ' + data.pengalaman + ' year';

                        $("#agencyID").attr("href", "{{route('agency.profile',['id' => ''])}}" + data.agency_id);
                        $("#agencyName").attr("href", "{{route('agency.profile',['id' => ''])}}" + data.agency_id)
                            .text(data.user.name);
                        $("#agencyAva").attr('src', data.user.ava);
                        $("#vacJudul").attr("href", "{{route('detail.vacancy',['id' => ''])}}" + data.id).text(data.judul);
                        $("#vacLoc").attr("href", "{{route('search.vacancy',['loc' => ''])}}" + data.city)
                            .html('<i class="fa fa-map-marked"></i>&ensp;' + data.city);
                        $("#vacJobFunc")
                            .attr("href", "{{route('search.vacancy',['jobfunc_ids' => ''])}}" + data.fungsikerja_id)
                            .html('<i class="fa fa-warehouse"></i>&ensp;' + data.job_func);
                        $("#vacIndustry")
                            .attr("href", "{{route('search.vacancy',['industry_ids' => ''])}}" + data.industry_id)
                            .html('<i class="fa fa-industry"></i>&ensp;' + data.industry);
                        $("#vacSalary").attr("href", "{{route('search.vacancy',['salary_ids' => ''])}}" + data.salary_id)
                            .html('<i class="fa fa-money-bill-wave"></i>&ensp;' + data.salary);
                        $("#vacDegree")
                            .attr("href", "{{route('search.vacancy',['degrees_ids' => ''])}}" + data.tingkatpend_id)
                            .html('<i class="fa fa-graduation-cap"></i>&ensp;' + data.degrees);
                        $("#vacMajor")
                            .attr("href", "{{route('search.vacancy',['majors_ids' => ''])}}" + data.jurusanpend_id)
                            .html('<i class="fa fa-user-graduate"></i>&ensp;' + data.majors);
                        $("#vacExp").html('<i class="fa fa-briefcase"></i>&ensp;' + $pengalaman);
                        $(".vacTotalApp").text(data.total_app);

                        $("#apply" + id).prop('checked', true);
                        $("#applyInvModal").modal('show');
                        $(document).on('hide.bs.modal', '#applyInvModal', function (event) {
                            $("#apply" + id).prop('checked', false);
                        });
                        $("#invitation_id").val(invitation_id);

                    } else if (today < data.recruitmentDate_start) {
                        swal({
                            title: 'ATTENTION!',
                            text: 'It seems that the recruitment date of ' + title + ' hasn\'t started yet.',
                            type: 'warning',
                            timer: '7000'
                        });

                    } else if (today > data.recruitmentDate_end) {
                        swal({
                            title: 'ATTENTION!',
                            text: 'It seems that the recruitment date of ' + title + ' has been ended.',
                            type: 'warning',
                            timer: '7000'
                        })
                    }
                },
                error: function () {
                    swal({
                        title: 'Job Invitation',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        }

        function abortApplication(id, title) {
            swal({
                title: 'Are you sure to abort ' + title + '?',
                text: "If its recruitment date has been ended, you won't be able to revert this application!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, abort it!',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
            }).then(function () {
                $("#apply" + id).prop('checked', false);
                $("#form-apply-" + id)[0].submit();
            }, function (dismiss) {
                if (dismiss == 'cancel') {
                    $("#apply" + id).prop('checked', true);
                }
            });
        }
    </script>
@endpush