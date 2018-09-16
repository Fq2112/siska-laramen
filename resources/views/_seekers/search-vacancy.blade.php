@extends('layouts.mst_user')
@section('title', 'Search Vacancy\'s Result | SISKA &mdash; Sistem Informasi Karier')
@push('styles')
    <link href="{{ asset('css/myPagination.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mySearchFilter.css') }}" rel="stylesheet">
@endpush
@section('content')
    <section id="fh5co-services" data-section="services" style="padding-top: 7em">
        <div class="fh5co-services">
            <div class="container" style="width: 100%">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-12 section-heading text-center" style="padding-bottom: 0">
                            <h2 class="to-animate" style="text-transform: none;font-size: 18px;letter-spacing: 1px">
                                <span id="show-result"></span>
                            </h2>
                        </div>

                        <div class="col-lg-3">
                            <div class="row">
                                <div class="col-lg-12 to-animate-2" id="search-filter">
                                    <div class="sidebar-offcanvas" id="sidebar" role="navigation">
                                        <!-- FILTER -->
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Filter</h3>
                                            </div>
                                            <form id="form-filter">
                                                <ul class="panel-body">
                                                    <li class="search-filter-option">
                                                        <h3 class="filter-heading tree-toggle">
                                                            <i class="fa fa-money-bill-wave"></i>&ensp;Salary (IDR)
                                                            <i class="fa fa-chevron-down pull-right"></i>
                                                        </h3>
                                                        <ul class="tree">
                                                            <select class="form-control selectpicker"
                                                                    data-actions-box="true" name="salary_ids[]"
                                                                    title="-- Nothing Selected --" id="salary"
                                                                    data-live-search="true" multiple>
                                                                @foreach($salaries as $row)
                                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </ul>
                                                    </li>
                                                    <li class="search-filter-option">
                                                        <h3 class="filter-heading tree-toggle">
                                                            <i class="fa fa-warehouse"></i>&ensp;Job Functions
                                                            <i class="fa fa-chevron-down pull-right"></i>
                                                        </h3>
                                                        <ul class="tree">
                                                            <select class="form-control selectpicker"
                                                                    data-actions-box="true" name="jobfunc_ids[]"
                                                                    title="-- Nothing Selected --" id="job_funct"
                                                                    data-live-search="true" multiple>
                                                                @foreach($job_functions as $row)
                                                                    <option value="{{$row->id}}">{{$row->nama}}</option>
                                                                @endforeach
                                                            </select>
                                                        </ul>
                                                    </li>
                                                    <li class="search-filter-option">
                                                        <h3 class="filter-heading tree-toggle">
                                                            <i class="fa fa-industry"></i>&ensp;Industries
                                                            <i class="fa fa-chevron-down pull-right"></i>
                                                        </h3>
                                                        <ul class="tree">
                                                            <select class="form-control selectpicker"
                                                                    data-actions-box="true" name="industry_ids[]"
                                                                    title="-- Nothing Selected --" id="industry"
                                                                    data-live-search="true" multiple>
                                                                @foreach($industries as $row)
                                                                    <option value="{{$row->id}}">{{$row->nama}}</option>
                                                                @endforeach
                                                            </select>
                                                        </ul>
                                                    </li>
                                                    <li class="search-filter-option">
                                                        <h3 class="filter-heading tree-toggle">
                                                            <i class="fa fa-graduation-cap"></i>&ensp;Education
                                                            Degrees
                                                            <i class="fa fa-chevron-down pull-right"></i>
                                                        </h3>
                                                        <ul class="tree">
                                                            <select class="form-control selectpicker"
                                                                    data-actions-box="true" name="degrees_ids[]"
                                                                    title="-- Nothing Selected --" id="tingkatpend"
                                                                    data-live-search="true"
                                                                    multiple>
                                                                @foreach($degrees as $row)
                                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </ul>
                                                    </li>
                                                    <li class="search-filter-option">
                                                        <h3 class="filter-heading tree-toggle">
                                                            <i class="fa fa-user-graduate"></i>&ensp;Education
                                                            Majors
                                                            <i class="fa fa-chevron-down pull-right"></i>
                                                        </h3>
                                                        <ul class="tree">
                                                            <select class="form-control selectpicker"
                                                                    data-actions-box="true" name="majors_ids[]"
                                                                    title="-- Nothing Selected --" id="jurusanpend"
                                                                    data-live-search="true"
                                                                    multiple>
                                                                @foreach($majors as $row)
                                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </ul>
                                                    </li>
                                                    <div class="card-read-more" id="clear-filter">
                                                        <button class="btn btn-link btn-block" type="reset">
                                                            <i class="fa fa-eraser"></i>&nbsp;Clear Filters
                                                        </button>
                                                    </div>
                                                </ul>
                                            </form>
                                        </div>
                                        <!-- /filter results panel -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9" id="vacancy-list">
                            <div class="row">
                                <div id="wrapper-filter" class="col-lg-8 to-animate-2">
                                    <ul id="filter-bar">
                                        <span class="pill"></span>
                                        <li class="filter-option option-1 active"
                                            data-target="option-1" data-value="all">All
                                        </li>
                                        <li class="filter-option option-2"
                                            data-target="option-2" data-value="latest">Latest
                                        </li>
                                        <li class="filter-option option-3"
                                            data-target="option-3" data-value="highest_salary">Highest Salary
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 pull-right to-animate-2">
                                    <div class="dc-view-switcher" style="margin: 0 1em">
                                        <label>Filter: </label>
                                        <button data-trigger="filter" id="btn_filter" class="active"
                                                type="button"></button>
                                        <label>&ensp;View: </label>
                                        <button data-trigger="grid-view" type="button"></button>
                                        <button data-trigger="list-view" class="active" type="button"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 to-animate-2">
                                    <ul class="tags" id="vacancy-tags">
                                        <div id="tag-salary"></div>
                                        <div id="tag-jobfunc"></div>
                                        <div id="tag-industry"></div>
                                        <div id="tag-degrees"></div>
                                        <div id="tag-majors"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 to-animate">
                                    <img src="{{asset('images/loading.gif')}}" id="image"
                                         class="img-responsive ld ld-fade">
                                    <div data-view="list-view" class="download-cards" style="margin-left: -.5em"
                                         id="search-result">
                                    </div>
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
    </section>
@endsection
@push("scripts")
    <script src="{{ asset('js/filter-gridList.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.dc-view-switcher button[data-trigger="grid-view"]').click();
        });
    </script>
@endpush
@push("lumen.ajax")
    <script>
        var last_page;

        $(document).ready(function () {
            $('#image').hide();
            $('#search-result').show();
            $('.myPagination').show();
            $('.dc-view-switcher button[data-trigger="grid-view"]').click();

            var keyword = '{{$keyword}}', location = '{{$location}}', sort = '{{$sort}}',
                salary = '{{$salary_ids}}', jobfunc = '{{$jobfunc_ids}}', industry = '{{$industry_ids}}',
                degrees = '{{$degrees_ids}}', majors = '{{$majors_ids}}', page = '{{$page}}',
                $sort = '', $salary = '', $jobfunc = '', $industry = '', $degrees = '', $majors = '', $page = '';

            if (keyword != "" || location != "") {
                $("#btn_reset").show();
            } else {
                $("#btn_reset").hide();
            }
            if (sort != "") {
                $sort = '&sort=' + sort;
            }
            if (page != "" && page != undefined) {
                $page = '&page=' + page;
            }

            if (salary != "" && salary != null) {
                $salary = '&salary_ids=' + salary;
                @foreach(\App\Salaries::whereIn('id',explode(',',$salary_ids))->get() as $row)
                $("#salary option[value='{{$row->id}}']").attr('selected', 'selected');
                var tag_sal = $("#tag-salary");
                tag_sal.html('');
                $('#salary option:selected').each(function (i, selected) {
                    tag_sal.append("<li><a data-id='" + $(this).val() + "' class='tag'>" +
                        "<i class='tag-close'></i><i class='fa fa-money-bill-wave tag-icon'></i>" +
                        "&ensp;" + $(this).text() + "</a></li>");
                });
                @endforeach
            }

            if (jobfunc != "" && jobfunc != null) {
                $jobfunc = '&jobfunc_ids=' + jobfunc;
                @foreach(\App\FungsiKerja::whereIn('id',explode(',',$jobfunc_ids))->get() as $row)
                $("#job_funct option[value='{{$row->id}}']").attr('selected', 'selected');
                var tag_jf = $("#tag-jobfunc");
                tag_jf.html('');
                $('#job_funct option:selected').each(function (i, selected) {
                    tag_jf.append("<li><a data-id='" + $(this).val() + "' class='tag'>" +
                        "<i class='tag-close'></i><i class='fa fa-warehouse tag-icon'></i>" +
                        "&ensp;" + $(this).text() + "</a></li>");
                });
                @endforeach
            }

            if (industry != "" && industry != null) {
                $industry = '&industry_ids=' + industry;
                @foreach(\App\Industri::whereIn('id',explode(',',$industry_ids))->get() as $row)
                $("#industry option[value='{{$row->id}}']").attr('selected', 'selected');
                var tag_in = $("#tag-industry");
                tag_in.html('');
                $('#industry option:selected').each(function (i, selected) {
                    tag_in.append("<li><a data-id='" + $(this).val() + "' class='tag'>" +
                        "<i class='tag-close'></i><i class='fa fa-industry tag-icon'></i>" +
                        "&ensp;" + $(this).text() + "</a></li>");
                });
                @endforeach
            }

            if (degrees != "" && degrees != null) {
                $degrees = '&degrees_ids=' + degrees;
                @foreach(\App\Tingkatpend::whereIn('id',explode(',',$degrees_ids))->get() as $row)
                $("#tingkatpend option[value='{{$row->id}}']").attr('selected', 'selected');
                var tag_de = $("#tag-degrees");
                tag_de.html('');
                $('#tingkatpend option:selected').each(function (i, selected) {
                    tag_de.append("<li><a data-id='" + $(this).val() + "' class='tag'>" +
                        "<i class='tag-close'></i><i class='fa fa-graduation-cap tag-icon'></i>" +
                        "&ensp;" + $(this).text() + "</a></li>");
                });
                @endforeach
            }

            if (majors != "" && majors != null) {
                $majors = '&majors_ids=' + majors;
                @foreach(\App\Jurusanpend::whereIn('id',explode(',',$majors_ids))->get() as $row)
                $("#jurusanpend option[value='{{$row->id}}']").attr('selected', 'selected');
                var tag_ma = $("#tag-majors");
                tag_ma.html('');
                $('#jurusanpend option:selected').each(function (i, selected) {
                    tag_ma.append("<li><a data-id='" + $(this).val() + "' class='tag'>" +
                        "<i class='tag-close'></i><i class='fa fa-user-graduate tag-icon'></i>" +
                        "&ensp;" + $(this).text() + "</a></li>");
                });
                @endforeach
            }

            $.get('api/vacancies/search?q=' + keyword + '&loc=' + location + $sort + $salary + $jobfunc + $industry +
                $degrees + $majors + $page, function (data) {
                last_page = data.last_page;
                successLoad(data, keyword, location, sort, salary, jobfunc, industry, degrees, majors, page);
            });
        });

        // search form navbar
        $("#txt_keyword").on('keyup', function () {
            loadVacancy();
        });
        $("#list-lokasi li a").click(function () {
            setTimeout(loadVacancy, 100);
        });
        $(".search-form").on('submit', function (event) {
            event.preventDefault();
            return false;
        });
        // sort
        $("#filter-bar li").click(function () {
            var data = $(this).attr('data-value'), sort = $("#txt_sort");
            $("#filter-bar li").removeClass("active");
            $(this).addClass("active");
            $("#filter-bar").removeClass().addClass($(this).attr("data-target"));
            sort.val(data);
            loadVacancy();
        });
        // reset filter
        $("#btn_reset").click(function () {
            $("#lokasi").html('Filter&nbsp;<span class="fa fa-caret-down">' + '</span>');
            $("#txt_keyword").removeAttr('value');
            $(".search-form input:not(#txt_sort)").val('');
            setTimeout(loadVacancy, 100);
        });
        $("#clear-filter button").click(function () {
            var $selectpicker = $("#search-filter .selectpicker option");
            $("#txt_sort").removeAttr('value');
            $selectpicker.prop('selected', false).trigger('change');
            $selectpicker.removeAttr('selected');
            $("#search-filter .selectpicker").selectpicker("refresh");
            setTimeout(loadVacancy, 100);
        });

        // filters + tags
        $(function () {
            $("#salary").on('change', function () {
                var tag = $("#tag-salary");
                tag.html('');
                $('#salary option:selected').each(function (i, selected) {
                    tag.append("<li><a data-id='" + $(this).val() + "' class='tag'>" +
                        "<i class='tag-close'></i><i class='fa fa-money-bill-wave tag-icon'></i>" +
                        "&ensp;IDR " + $(this).text() + "</a></li>");

                    loadVacancy();
                });
            });
            $('#tag-salary').on('click', ".tag", function () {
                var id = $(this).data("id");
                $(this).remove();
                $('#salary option:selected').each(function (i, selected) {
                    $('#salary option[value="' + id + '"]').prop('selected', false).trigger('change');
                    $("#salary").selectpicker("refresh");

                    setTimeout(loadVacancy, 100);
                });
            });

            $("#job_funct").on('change', function () {
                var tag = $("#tag-jobfunc");
                tag.html('');
                $('#job_funct option:selected').each(function (i, selected) {
                    tag.append("<li><a data-id='" + $(this).val() + "' class='tag'>" +
                        "<i class='tag-close'></i><i class='fa fa-warehouse tag-icon'></i>" +
                        "&ensp;" + $(this).text() + "</a></li>");

                    loadVacancy();
                });
            });
            $('#tag-jobfunc').on('click', ".tag", function () {
                var id = $(this).data("id");
                $(this).remove();
                $('#job_funct option:selected').each(function (i, selected) {
                    $('#job_funct option[value="' + id + '"]').prop('selected', false).trigger('change');
                    $("#job_funct").selectpicker("refresh");

                    setTimeout(loadVacancy, 100);
                });
            });

            $("#industry").on('change', function () {
                var tag = $("#tag-industry");
                tag.html('');
                $('#industry option:selected').each(function (i, selected) {
                    tag.append("<li><a data-id='" + $(this).val() + "' class='tag'>" +
                        "<i class='tag-close'></i><i class='fa fa-industry tag-icon'></i>" +
                        "&ensp;" + $(this).text() + "</a></li>");

                    loadVacancy();
                });
            });
            $('#tag-industry').on('click', ".tag", function () {
                var id = $(this).data("id");
                $(this).remove();
                $('#industry option:selected').each(function (i, selected) {
                    $('#industry option[value="' + id + '"]').prop('selected', false).trigger('change');
                    $("#industry").selectpicker("refresh");

                    setTimeout(loadVacancy, 100);
                });
            });

            $("#tingkatpend").on('change', function () {
                var tag = $("#tag-degrees");
                tag.html('');
                $('#tingkatpend option:selected').each(function (i, selected) {
                    tag.append("<li><a data-id='" + $(this).val() + "' class='tag'>" +
                        "<i class='tag-close'></i><i class='fa fa-graduation-cap tag-icon'></i>" +
                        "&ensp;" + $(this).text() + "</a></li>");

                    loadVacancy();
                });
            });
            $('#tag-degrees').on('click', ".tag", function () {
                var id = $(this).data("id");
                $(this).remove();
                $('#tingkatpend option:selected').each(function (i, selected) {
                    $('#tingkatpend option[value="' + id + '"]').prop('selected', false).trigger('change');
                    $("#tingkatpend").selectpicker("refresh");

                    setTimeout(loadVacancy, 100);
                });
            });

            $("#jurusanpend").on('change', function () {
                var tag = $("#tag-majors");
                tag.html('');
                $('#jurusanpend option:selected').each(function (i, selected) {
                    tag.append("<li><a data-id='" + $(this).val() + "' class='tag'>" +
                        "<i class='tag-close'></i><i class='fa fa-user-graduate tag-icon'></i>" +
                        "&ensp;" + $(this).text() + "</a></li>");

                    loadVacancy();
                });
            });
            $('#tag-majors').on('click', ".tag", function () {
                var id = $(this).data("id");
                $(this).remove();
                $('#jurusanpend option:selected').each(function (i, selected) {
                    $('#jurusanpend option[value="' + id + '"]').prop('selected', false).trigger('change');
                    $("#jurusanpend").selectpicker("refresh");

                    setTimeout(loadVacancy, 100);
                });
            });
        });

        function loadVacancy() {
            var keyword = $("#txt_keyword").val(), location = $("#txt_location").val(), sort = $("#txt_sort").val(),
                salary = $("#salary").val(), jobfunc = $("#job_funct").val(), industry = $("#industry").val(),
                degrees = $("#tingkatpend").val(), majors = $("#jurusanpend").val();

            $.ajax({
                url: "{{route('get.search.vacancy')}}",
                type: "GET",
                data: $(".search-form, #form-filter").serialize(),
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
                    successLoad(data, keyword, location, sort, salary, jobfunc, industry, degrees, majors);
                },
                error: function () {
                    swal({
                        title: 'Search Vacancy',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
            return false;
        }

        $('.myPagination ul').on('click', 'li', function (event) {
            $(window).scrollTop(0);

            var keyword = $("#txt_keyword").val(), location = $("#txt_location").val(), sort = $("#txt_sort").val(),
                salary = $("#salary").val(), jobfunc = $("#job_funct").val(), industry = $("#industry").val(),
                degrees = $("#tingkatpend").val(), majors = $("#jurusanpend").val();

            page = $(this).children().text();
            active = $(this).parents("ul").find('.active').eq(0).text();
            hellip_prev = $(this).closest('.hellip_prev').next().find('a').text();
            hellip_next = $(this).closest('.hellip_next').prev().find('a').text();

            if (page > 0) {
                $url = "{{url('/api')}}" + '/vacancies/search?page=' + page;
            }
            if ($(this).hasClass('prev')) {
                $url = "{{url('/api')}}" + '/vacancies/search?page=' + parseInt(active - 1);
            }
            if ($(this).hasClass('next')) {
                $url = "{{url('/api')}}" + '/vacancies/search?page=' + parseInt(+active + +1);
            }
            if ($(this).hasClass('hellip_prev')) {
                $url = "{{url('/api')}}" + '/vacancies/search?page=' + parseInt(hellip_prev - 1);
                page = parseInt(hellip_prev - 1);
            }
            if ($(this).hasClass('hellip_next')) {
                $url = "{{url('/api')}}" + '/vacancies/search?page=' + parseInt(+hellip_next + +1);
                page = parseInt(+hellip_next + +1);
            }
            if ($(this).hasClass('first')) {
                $url = "{{url('/api')}}" + '/vacancies/search?page=1';
            }
            if ($(this).hasClass('last')) {
                $url = "{{url('/api')}}" + '/vacancies/search?page=' + last_page;
            }

            $.ajax({
                url: $url,
                type: "GET",
                data: $(".search-form, #form-filter").serialize(),
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
                    successLoad(data, keyword, location, sort, salary, jobfunc, industry, degrees, majors, page);
                },
                error: function () {
                    swal({
                        title: 'Search Vacancy',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
            event.preventDefault();
            return false;
        });

        function successLoad(data, keyword, location, sort, salary, jobfunc, industry, degrees, majors, page) {

            // title search result
            if ((keyword != "") && (location != "")) {
                title = 'for <strong>"' + keyword + '"</strong> in <strong>"' + location + '"</strong>'
            } else if (location == "") {
                title = 'for <strong>"' + keyword + '"</strong>'
            } else {
                title = 'in <strong>"' + location + '"</strong>'
            }
            if ($.trim(data.total)) {
                total = ' (<strong>' + data.from + '</strong> - <strong>' + data.to + '</strong> of ' +
                    '<strong>' + data.total + '</strong>)';
            } else {
                total = '';
            }
            $('#show-result').html('Showing <strong>' + data.total + '</strong> opportunities matched ' + title + total);

            // sort
            var sort_opt1 = $("#filter-bar .option-1"), sort_opt2 = $("#filter-bar .option-2"),
                sort_opt3 = $("#filter-bar .option-3");
            if (sort == "highest_salary") {
                $("#filter-bar").addClass('option-3').removeClass('option-2 option-1');
                sort_opt3.addClass('active');
                sort_opt2.removeClass('active');
                sort_opt1.removeClass('active');
            } else if (sort == "latest") {
                $("#filter-bar").addClass('option-2').removeClass('option-3 option-1');
                sort_opt3.removeClass('active');
                sort_opt2.addClass('active');
                sort_opt1.removeClass('active');
            } else {
                $("#filter-bar").addClass('option-1').removeClass('option-3 option-2');
                sort_opt3.removeClass('active');
                sort_opt2.removeClass('active');
                sort_opt1.addClass('active');
            }

            // result list
            $result = '';
            $.each(data.data, function (i, val) {
                $result +=
                    '<article class="download-card">' +
                    '<a href="{{route('agency.profile',['id' => ''])}}/' + val.agency_id + '">' +
                    '<div class="download-card__icon-box"><img src="' + val.user.ava + '"></div></a>' +
                    '<div class="download-card__content-box">' +
                    '<div class="content">' +
                    '<h2 class="download-card__content-box__catagory">' + val.updated_at + '</h2>' +
                    '<a href="{{route('detail.vacancy',['id' => ''])}}/' + val.id + '">' +
                    '<h3 class="download-card__content-box__title">' + val.judul + '</h3></a>' +
                    '<a href="{{route('agency.profile',['id' => ''])}}/' + val.agency_id + '">' +
                    '<p class="download-card__content-box__description">' + val.user.name + '</p></a>' +
                    '<table style="font-size: 14px"><tbody>' +
                    '<tr><td><i class="fa fa-industry"></i></td>' +
                    '<td>&nbsp;</td>' +
                    '<td>' + val.industry + '</td></tr>' +
                    '<tr><td><i class="fa fa-map-marked"></i></td>' +
                    '<td>&nbsp;</td>' +
                    '<td>' + val.city + '</td></tr>' +
                    '<tr><td><i class="fas fa-money-bill-wave"></i></td>' +
                    '<td>&nbsp;</td>' +
                    '<td>' + val.salary + '</td></tr>' +
                    '<tr><td><i class="fas fa-briefcase"></i></td>' +
                    '<td>&nbsp;</td>' +
                    '<td>' + val.pengalaman + '</td></tr>' +
                    '</tbody></table></div></div>' +
                    '<div class="card-read-more">' +
                    '<a href="{{route('detail.vacancy',['id' => ''])}}/' + val.id + '" class="btn btn-link btn-block">' +
                    'Read More</a></div></article>';
            });
            $("#search-result").empty().append($result);

            // pagination
            pagination = '';
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

            // url generator
            var $sort = '', $salary = '', $jobfunc = '', $industry = '', $degrees = '', $majors = '', $page = '';
            if (sort != "") {
                $sort = '&sort=' + sort;
            }
            if (salary != "" && salary != null) {
                $salary = '&salary_ids=' + salary;
                $sort = '';
            }
            if (jobfunc != "" && jobfunc != null) {
                $jobfunc = '&jobfunc_ids=' + jobfunc;
                $sort = '';
            }
            if (industry != "" && industry != null) {
                $industry = '&industry_ids=' + industry;
                $sort = '';
            }
            if (degrees != "" && degrees != null) {
                $degrees = '&degrees_ids=' + degrees;
                $sort = '';
            }
            if (majors != "" && majors != null) {
                $majors = '&majors_ids=' + majors;
                $sort = '';
            }
            if (page != "" && page != undefined) {
                $page = '&page=' + page;
            }
            window.history.replaceState("", "", '{{url('/')}}' + '/search?q=' + keyword + '&loc=' + location +
                $sort + $salary + $jobfunc + $industry + $degrees + $majors + $page);

            return false;
        }
    </script>
@endpush
