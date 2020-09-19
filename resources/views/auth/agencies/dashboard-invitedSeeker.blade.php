@section('title', ''.$user->name.'\'s Dashboard &ndash; Invited Seeker | '.env('APP_TITLE'))
@extends('layouts.auth.mst_agency')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs" id="vac-nav-tabs">
                                @foreach($vacancies as $vacancy)
                                    @php $total = \App\Invitation::where('agency_id', $agency->id)
                                    ->where('vacancy_id', $vacancy->id)->count(); @endphp
                                    <li id="{{$vacancy->id}}">
                                        <a data-toggle="tab" href="#vac-{{$vacancy->id}}"
                                           onclick="setVacancy('{{$vacancy->id}}')">{{$vacancy->judul}}
                                            <span class="badge">{{$total > 99 ? '99+' : $total}}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                            <form id="form-loadInvSeeker">
                                <input type="hidden" name="vacancy_id" id="vacancy_id">
                                <input type="hidden" name="start_date" id="start_date">
                                <input type="hidden" name="end_date" id="end_date">
                                <input type="hidden" id="date">
                            </form>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 1em">
                        <div class="tab-content" id="vac-tab-content">
                            <div class="tab-pane to-animate">
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
                                    <div class="col-lg-12 nicescrolls" style="max-height: 400px;margin-bottom: 1em">
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
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            var first_vac = $("#vac-nav-tabs li").first(),
                start = moment().startOf('month'), end = moment().endOf('month');
            first_vac.addClass('active');
            $("#vac-tab-content .tab-pane").addClass('active');
            setVacancy(first_vac.attr('id'));

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

        function setVacancy(id) {
            $("#vacancy_id").val(id);
            loadInvSeeker();
        }

        function searchDate(start, end) {
            $('#daterangepicker span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
            $("#start_date").val(start.format('YYYY-MM-D'));
            $("#end_date").val(end.format('YYYY-MM-D'));
            $("#date").val(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
            loadInvSeeker(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
        }

        function loadInvSeeker(date) {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: "{{route('get.invited.seeker')}}",
                    type: "GET",
                    data: $("#form-loadInvSeeker").serialize(),
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
                            title: 'Invited Seeker',
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
                $url = "{{url('/account/agency/dashboard/invited_seeker/seekers')}}" + '?page=' + page;
            }
            if ($(this).hasClass('prev')) {
                $url = "{{url('/account/agency/dashboard/invited_seeker/seekers')}}" + '?page=' + parseInt(active - 1);
            }
            if ($(this).hasClass('next')) {
                $url = "{{url('/account/agency/dashboard/invited_seeker/seekers')}}" + '?page=' + parseInt(+active + +1);
            }
            if ($(this).hasClass('hellip_prev')) {
                $url = "{{url('/account/agency/dashboard/invited_seeker/seekers')}}" + '?page=' + parseInt(hellip_prev - 1);
                page = parseInt(hellip_prev - 1);
            }
            if ($(this).hasClass('hellip_next')) {
                $url = "{{url('/account/agency/dashboard/invited_seeker/seekers')}}" + '?page=' + parseInt(+hellip_next + +1);
                page = parseInt(+hellip_next + +1);
            }
            if ($(this).hasClass('first')) {
                $url = "{{url('/account/agency/dashboard/invited_seeker/seekers')}}" + '?page=1';
            }
            if ($(this).hasClass('last')) {
                $url = "{{url('/account/agency/dashboard/invited_seeker/seekers')}}" + '?page=' + last_page;
            }

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: $url,
                    type: "GET",
                    data: $("#form-loadInvSeeker").serialize(),
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

        function successLoad(data, date, page) {
            var title, total, $date, $result = '', pagination = '', $page = '',
                $style, $label, $phone, $salary, $display, $param;

            if (data.total > 0) {
                title = data.total > 1 ? 'Showing <strong>' + data.total + '</strong> invited seekers' :
                    'Showing an invited seeker';

                $date = date != undefined ? ' for <strong>"' + date + '"</strong>' : ' for <strong>"{{today()
                ->startOfMonth()->formatLocalized('%d %b %Y')." - ".today()
                ->endOfMonth()->formatLocalized('%d %b %Y')}}"</strong>';

                total = $.trim(data.total) ? ' (<strong>' + data.from + '</strong> - ' +
                    '<strong>' + data.to + '</strong> of <strong>' + data.total + '</strong>)' : '';

            } else {
                title = '<em>There seems to be none of the invited seeker was found&hellip;</em>';
                total = '';
                $date = '';
            }
            $('#show-result').html(title + $date + total);

            $.each(data.data, function (i, val) {
                if (val.isApply == 0) {
                    $style = '#fa5555';
                    $label = 'NOT APPLY';
                    $display = '';
                } else {
                    $style = '#393e46';
                    $label = 'APPLIED';
                    $display = 'none';
                }

                $salary = val.seeker.low == 0 || val.seeker.high == 0 ? 'Anything' :
                    'IDR ' + val.seeker.low + ' to ' + val.seeker.high + ' millions';

                $phone = val.seeker.phone != "" ? '' : 'none';

                $param = val.id + ",'" + val.seeker.name + "'";

                $result +=
                    '<div class="media">' +
                    '<div class="media-left media-middle">' +
                    '<a href="{{route('seeker.profile',['id'=>''])}}/' + val.id + '">' +
                    '<img width="100" class="media-object" src="' + val.seeker.ava + '"></a></div>' +
                    '<div class="media-body">' +
                    '<small class="media-heading" style="font-size: 17px;">' +
                    '<a href="{{route('seeker.profile',['id'=>''])}}/' + val.seeker_id + '" ' +
                    'style="color: #00ADB5">' + val.seeker.name + '</a>' +
                    '<a href="mailto:' + val.seeker.email + '" style="color: #fa5555">' +
                    '<sub>&ndash; ' + val.seeker.email + '</sub></a>' +
                    '<a style="display: ' + $phone + '" href="tel:' + val.seeker.phone + '">' +
                    '<sub> | ' + val.seeker.phone + '</sub></a>' +
                    '<span class="pull-right" style="color: #00ADB5">Invited on ' + val.created_at + '</span>' +
                    '</small>' +
                    '<blockquote style="font-size: 16px;color: #7f7f7f">' +
                    '<span class="label label-default pull-right" ' +
                    'style="background: ' + $style + ';padding: 5px 15px;font-size: 14px">' +
                    '<i class="fa fa-paper-plane"></i>&ensp;' + $label + '</span>' +
                    '<ul class="list-inline">' +
                    '<li><a class="tag"><i class="fa fa-user-tie"></i>' +
                    '&ensp;' + val.seeker.jobTitle + '</a></li>' +
                    '<li><a class="tag"><i class="fa fa-briefcase"></i>' +
                    '&ensp;Work Experience: ' + val.seeker.total_exp + ' years</a></li>' +
                    '<li><a class="tag"><i class="fa fa-hand-holding-usd"></i>&ensp;' +
                    'Expected Salary: ' + $salary + '</a></li>' +
                    '<li><a class="tag"><i class="fa fa-graduation-cap"></i>&ensp;' +
                    'Latest Degree: ' + val.seeker.last_deg + '</a></li>' +
                    '<li><a class="tag"><i class="fa fa-user-graduate"></i>&ensp;' +
                    'Latest Major: ' + val.seeker.last_maj + '</a></li></ul>' +
                    '<table style="font-size: 12px">' +
                    '<tr><td><i class="fa fa-calendar-check"></i></td>' +
                    '<td>&nbsp;Member Since</td>' +
                    '<td> : ' + val.seeker.created_at + '</td></tr>' +
                    '<tr><td><i class="fa fa-clock"></i></td>' +
                    '<td>&nbsp;Last Update</td>' +
                    '<td> : ' + val.seeker.updated_at + '</td></tr></table>' +
                    '<hr style="display:' + $display + ';margin-bottom: 0">' +
                    '<form style="display:' + $display + '" id="form-invitation-' + val.id + '" ' +
                    'method="post" action="{{route('invite.seeker')}}">{{csrf_field()}}' +
                    '<div class="anim-icon anim-icon-md invitation ld ld-breath" ' +
                    'onclick="abortInvitation(' + $param + ')" data-toggle="tooltip" ' +
                    'data-placement="right" title="Click here to abort this invitation!" style="font-size: 25px">' +
                    '<input type="hidden" name="invitation_id" value="' + val.id + '">' +
                    '<input type="hidden" name="seeker_id" value="' + val.seeker_id + '">' +
                    '<input id="invitation' + val.id + '" type="checkbox" checked>' +
                    '<label for="invitation' + val.id + '"></label></div></form>' +
                    '<small style="display:' + $display + '">' +
                    'P.S.: You are only permitted to abort this invitation before the ' +
                    'seeker that you\'ve invite apply it.</small>' +
                    '</blockquote></div></div>' +
                    '<hr class="hr-divider">';
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
            window.history.replaceState("", "", '{{url('/account/agency/dashboard/invited_seeker')}}' + $page);
            return false;
        }

        function abortInvitation(id, name) {
            swal({
                title: 'Are you sure to abort ' + name + '?',
                text: "You won't be able to revert this invitation!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, abort it!',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
            }).then(function () {
                $("#invitation" + id).prop('checked', false);
                $("#form-invitation-" + id)[0].submit();
            }, function (dismiss) {
                if (dismiss == 'cancel') {
                    $("#invitation" + id).prop('checked', true);
                }
            });
        }
    </script>
@endpush
