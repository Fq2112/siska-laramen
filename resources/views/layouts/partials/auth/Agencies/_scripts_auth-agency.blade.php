<script>
    $("#show_password_settings").click(function () {
        $(this).text(function (i, v) {
            return v === "PASSWORD SETTINGS" ? "Change Password ?" : "PASSWORD SETTINGS";
        });
        if ($(this).text() === 'Change Password ?') {
            this.style.color = "#00ADB5";
        } else {
            this.style.color = "#7f7f7f";
        }

        $("#password_settings").toggle(300);
        if ($("#btn_save_password").attr('disabled')) {
            $("#btn_save_password").removeAttr('disabled');
        } else {
            $("#btn_save_password").attr('disabled', 'disabled');
        }
    });

    $("#show_gallery_settings").click(function () {
        $(window).scrollTop(700);
        $("#gallery_settings").toggle(300);
        $(".stats_gallery").toggle(300);
        $("#btn_gallery").toggle(300);
        $("#btn_delete_gallery").toggle(300);
    });

    $("#show_personal_data_settings").click(function () {
        $("#personal_data_settings").toggle(300);
        $(".stats_personal_data").toggle(300);
        if ($("#btn_save_personal_data").attr('disabled')) {
            $("#btn_save_personal_data").removeAttr('disabled');
        } else {
            $("#btn_save_personal_data").attr('disabled', 'disabled');
        }
    });

    $("#show_agency_about_settings").click(function () {
        $("#agency_about_settings").toggle(300);
        $("#stats_agency_about").toggle(300);
        if ($("#btn_save_agency_about").attr('disabled')) {
            $("#btn_save_agency_about").removeAttr('disabled');
        } else {
            $("#btn_save_agency_about").attr('disabled', 'disabled');
        }
    });
    $("#btn_save_agency_about").on('click', function (e) {
        e.preventDefault();
        if (tinyMCE.get('tentang').getContent() == "") {
            swal({
                title: 'ATTENTION!',
                text: 'About Us field can\'t be null!',
                type: 'warning',
                timer: '3500'
            });

        } else if (tinyMCE.get('alasan').getContent() == "") {
            swal({
                title: 'ATTENTION!',
                text: 'Why Choose Us field can\'t be null!',
                type: 'warning',
                timer: '3500'
            });

        } else {
            $('#form-about')[0].submit();
        }
    });

    $("#show_address_settings").click(function () {
        $("#address_settings").toggle(300);
        $("#stats_address").toggle(300);
        if ($("#btn_save_address").attr('disabled')) {
            $("#btn_save_address").removeAttr('disabled');
        } else {
            $("#btn_save_address").attr('disabled', 'disabled');
        }
    });

    $("#show_vacancy_settings, #btn_cancel_vacancy input[type=reset]").click(function () {
        $("#btn_cancel_vacancy").hide();
        $("#form-vacancy")[0].reset();
        $("#vacancy_settings .selectpicker").val('default').selectpicker("refresh");
        $("#vacancy_settings").toggle(300);
        $("#stats_vacancy").toggle(300);
        if ($("#btn_save_vacancy").attr('disabled')) {
            $("#btn_save_vacancy").removeAttr('disabled');
        } else {
            $("#btn_save_vacancy").attr('disabled', 'disabled');
        }
        $("#form-vacancy input[name='_method']").val('POST');

        $('html, body').animate({
            scrollTop: $('#show_vacancy_settings').offset().top
        }, 500);
    });
    $("#btn_save_vacancy").on('click', function (e) {
        e.preventDefault();
        if (tinyMCE.get('syarat').getContent() == "") {
            swal({
                title: 'ATTENTION!',
                text: 'Requirements field can\'t be null!',
                type: 'warning',
                timer: '3500'
            });

        } else if (tinyMCE.get('tanggungjawab').getContent() == "") {
            swal({
                title: 'ATTENTION!',
                text: 'Responsibilities field can\'t be null!',
                type: 'warning',
                timer: '3500'
            });

        } else {
            $('#form-vacancy')[0].submit();
        }
    });

    $(".browse_files").on('click', function () {
        $("#gallery-files").trigger('click');
    });
    $("#gallery-files").on('change', function () {
        var files = $(this).prop("files");
        var count = $(this).get(0).files.length;
        var names = $.map(files, function (val) {
            return val.name;
        });
        var txt = $("#txt_gallery");
        txt.val(names);
        $("#txt_gallery[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
        if (count > 1) {
            $("#count_files").text(count + " files selected");
        } else {
            $("#count_files").text(count + " file selected");
        }
    });

    $(function () {
        var $gallery_cb = $(".gallery_cb"), $selectAll = $("#selectAll"),
            $btnDelete = $("#btn_delete_gallery button");

        $selectAll.click(function () {
            $('.gallery_cb').prop('checked', this.checked);
        });
        $gallery_cb.click(function () {
            if ($(".gallery_cb").length === $(".gallery_cb:checked").length) {
                $("#selectAll").prop('checked', true);
            } else {
                $("#selectAll").prop('checked', false);
            }
        });
        $gallery_cb.change(function () {
            if ($(this).is(":checked")) {
                $btnDelete.removeAttr('disabled');
                $(this).closest('li').addClass("active");
            } else {
                $(this).closest('li').removeClass("active");
                $btnDelete.attr('disabled', true);
            }
        });
        $selectAll.change(function () {
            if ($(this).is(":checked")) {
                $btnDelete.removeAttr('disabled');
                $("#gallery_list li").addClass("active");
            } else {
                $("#gallery_list li").removeClass("active");
                $btnDelete.attr('disabled', true);
            }
        });
        $("#btn_save_gallery").on('click', function () {
            $("#form-create-gallery")[0].submit();
        });
        $btnDelete.on('click', function () {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $("#form-delete-gallery")[0].submit();
                    });
                },
                allowOutsideClick: false
            });
            return false;
        });
    });

    function editVacancySchedule(id, $judul, plan_id, isPost, $active_period, $interview, $start, $end, $quiz_start, $quiz_end, $psychoTest_start, $psychoTest_end) {
        if (isPost == true) {
            $('#schedule_settings').html(
                '<form action="{{url('account/agency/vacancy/update')}}/' + id + '"' +
                'method="post" id="form-schedule">{{csrf_field()}}' +
                '<input type="hidden" name="_method">' +
                '<input type="hidden" name="check_form" value="schedule">' +
                '<div class="modal-body">' +
                '<div class="box">' +
                '<div class="content">' +
                '<p style="font-size: 17px" align="justify">' +
                'Agencies are permitted to set their own vacancy schedule. ' +
                'To set yours, please fill in all the form fields correctly.</p>' +
                '<hr class="hr-divider">' +
                '<div class="row form">' +
                '<div class="col-lg-12">' +
                '<div class="row form-group">' +
                '<div class="col-lg-12">' +
                '<small>Active Period</small>' +
                '<div class="input-group">' +
                '<span class="input-group-addon">' +
                '<i class="fa fa-calendar-check"></i></span>' +
                '<input class="form-control" type="text" value="' + $active_period + '" ' +
                'id="active_period" disabled></div></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12">' +
                '<small>Recruitment Date</small>' +
                '<div class="input-group">' +
                '<span class="input-group-addon"><i class="fa fa-user"></i></span>' +
                '<input style="background-color: #fff;width: 50%" class="form-control" type="text" maxlength="10" ' +
                'placeholder="yyyy-mm-dd" name="recruitmentDate_start" id="recruitmentDate_start" ' +
                'value="' + $start + '" required>' +
                '<input style="background-color: #fff;width:50%" class="form-control" type="text" maxlength="10" ' +
                'placeholder="yyyy-mm-dd" name="recruitmentDate_end" id="recruitmentDate_end" ' +
                'value="' + $end + '" required>' +
                '<span class="input-group-addon"><i class="fa fa-users"></i></span></div>' +
                '<span class="help-block">' +
                '<small style="float: left;font-size: 12px;color: #fa5555;">P.S.: You\'re only permitted to set ' +
                'those dates before its active period runs out.</small></span></div></div>' +
                '<div id="quiz_psychoTest_date' + id + '"></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12">' +
                '<small>Job Interview Date</small>' +
                '<div class="input-group">' +
                '<span class="input-group-addon">' +
                '<i class="fa fa-user-tie"></i></span>' +
                '<input style="background-color: #fff" class="form-control" ' +
                'type="text" maxlength="10" placeholder="yyyy-mm-dd" name="interview_date" id="interview_date" ' +
                'value="' + $interview + '" required></div></div></div>' +
                '</div></div></div></div></div>' +
                '<div class="modal-footer">' +
                '<div class="card-read-more" id="btn-schedule">' +
                '<button class="btn btn-link btn-block" type="submit">' +
                '<i class="fa fa-calendar"></i>&ensp;SAVE CHANGES</button></div></div></form>'
            );
            $("#form-schedule input[name='_method']").val('PUT');
            $("#vacancy_title").html('<strong>' + $judul + '</strong> &ndash; VACANCY SCHEDULE');

            if (plan_id == 1) {
                $("#quiz_psychoTest_date" + id).html('');
                $("#recruitmentDate_start").datepicker({
                    format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                    startDate: '{{today()}}',
                    endDate: $active_period
                }).on('changeDate', function (selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('#recruitmentDate_end').datepicker({
                        format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                        startDate: minDate,
                        endDate: $active_period
                    }).on('changeDate', function (selected) {
                        var minDate = new Date(selected.date.valueOf());
                        $('#interview_date').datepicker({
                            format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                            startDate: minDate
                        });
                    });
                });

            } else if (plan_id == 2) {
                $("#quiz_psychoTest_date" + id).html(
                    '<div class="row form-group">' +
                    '<div class="col-lg-12">' +
                    '<small>Quiz (Online TPA & TKD) Date</small>' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-smile"></i></span>' +
                    '<input style="background-color: #fff;width: 50%" class="form-control" type="text" maxlength="10" ' +
                    'placeholder="yyyy-mm-dd" name="quizDate_start" id="quizDate_start" ' +
                    'value="' + $quiz_start + '" required>' +
                    '<input style="background-color: #fff;width:50%" class="form-control" type="text" maxlength="10" ' +
                    'placeholder="yyyy-mm-dd" name="quizDate_end" id="quizDate_end" ' +
                    'value="' + $quiz_end + '" required>' +
                    '<span class="input-group-addon"><i class="fa fa-grin-beam"></i></span>' +
                    '</div></div></div>'
                );
                $("#recruitmentDate_start").datepicker({
                    format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                    startDate: '{{today()}}',
                    endDate: $active_period
                }).on('changeDate', function (selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('#recruitmentDate_end').datepicker({
                        format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                        startDate: minDate,
                        endDate: $active_period
                    }).on('changeDate', function (selected) {
                        var minDate = new Date(selected.date.valueOf());
                        $('#quizDate_start').datepicker({
                            format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                            startDate: minDate
                        }).on('changeDate', function (selected) {
                            var minDate = new Date(selected.date.valueOf());
                            $('#quizDate_end').datepicker({
                                format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                                startDate: minDate
                            }).on('changeDate', function (selected) {
                                var minDate = new Date(selected.date.valueOf());
                                $('#interview_date').datepicker({
                                    format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                                    startDate: minDate
                                });
                            });
                        });
                    });
                });

            } else if (plan_id == 3) {
                $("#quiz_psychoTest_date" + id).html(
                    '<div class="row form-group">' +
                    '<div class="col-lg-12">' +
                    '<small>Quiz (Online TPA & TKD) Date</small>' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-smile"></i></span>' +
                    '<input style="background-color: #fff;width: 50%" class="form-control" type="text" maxlength="10" ' +
                    'placeholder="yyyy-mm-dd" name="quizDate_start" id="quizDate_start" ' +
                    'value="' + $quiz_start + '" required>' +
                    '<input style="background-color: #fff;width:50%" class="form-control" type="text" maxlength="10" ' +
                    'placeholder="yyyy-mm-dd" name="quizDate_end" id="quizDate_end" ' +
                    'value="' + $quiz_end + '" required>' +
                    '<span class="input-group-addon"><i class="fa fa-grin-beam"></i></span>' +
                    '</div></div></div>' +
                    '<div class="row form-group">' +
                    '<div class="col-lg-12">' +
                    '<small>Psycho Test (Online Interview) Date</small>' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-comment"></i></span>' +
                    '<input style="background-color: #fff;width: 50%" class="form-control" type="text" maxlength="10" ' +
                    'placeholder="yyyy-mm-dd" name="psychoTestDate_start" id="psychoTestDate_start" ' +
                    'value="' + $psychoTest_start + '" required>' +
                    '<input style="background-color: #fff;width:50%" class="form-control" type="text" maxlength="10" ' +
                    'placeholder="yyyy-mm-dd" name="psychoTestDate_end" id="psychoTestDate_end" ' +
                    'value="' + $psychoTest_end + '" required>' +
                    '<span class="input-group-addon"><i class="fa fa-comments"></i></span>' +
                    '</div></div></div>'
                );
                $("#recruitmentDate_start").datepicker({
                    format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                    startDate: '{{today()}}',
                    endDate: $active_period
                }).on('changeDate', function (selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('#recruitmentDate_end').datepicker({
                        format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                        startDate: minDate,
                        endDate: $active_period
                    }).on('changeDate', function (selected) {
                        var minDate = new Date(selected.date.valueOf());
                        $('#quizDate_start').datepicker({
                            format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                            startDate: minDate
                        }).on('changeDate', function (selected) {
                            var minDate = new Date(selected.date.valueOf());
                            $('#quizDate_end').datepicker({
                                format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                                startDate: minDate
                            }).on('changeDate', function (selected) {
                                var minDate = new Date(selected.date.valueOf());
                                $('#psychoTestDate_start').datepicker({
                                    format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                                    startDate: minDate
                                }).on('changeDate', function (selected) {
                                    var minDate = new Date(selected.date.valueOf());
                                    $('#psychoTestDate_end').datepicker({
                                        format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                                        startDate: minDate
                                    }).on('changeDate', function (selected) {
                                        var minDate = new Date(selected.date.valueOf());
                                        $('#interview_date').datepicker({
                                            format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                                            startDate: minDate
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            }

            $("#formModal").modal('show');

        } else {
            swal({
                title: 'ATTENTION!',
                text: "It seems this vacancy isn't posted yet. To post your vacancy, please select one of " +
                    "the available Plan/Package on the Agency\'s Home page first.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00ADB5',
                confirmButtonText: 'Yes, redirect me to the Agency\'s Home page.',
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        window.location.href = '{{route('home-agency')}}#pricing';
                    });
                },
                allowOutsideClick: false
            });
            return false;
        }
    }
</script>