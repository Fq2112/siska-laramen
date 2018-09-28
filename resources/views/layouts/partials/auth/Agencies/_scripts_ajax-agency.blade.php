@auth
    <script>
        $("#form-password").on("submit", function (e) {
            $.ajax({
                type: 'POST',
                url: '{{route('agency.update.settings')}}',
                data: new FormData($("#form-password")[0]),
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 0) {
                        swal({
                            title: 'Account Settings',
                            text: 'Your current password is incorrect!',
                            type: 'error',
                            timer: '1500'
                        });
                        $("#error_curr_pass").addClass('has-error');
                        $("#error_new_pass").removeClass('has-error');
                        $(".aj_pass").text("Your current password is incorrect!");
                        $(".aj_new_pass").text("");

                    } else if (data == 1) {
                        swal({
                            title: 'Account Settings',
                            text: 'Your password confirmation doesn\'t match!',
                            type: 'error',
                            timer: '1500'
                        });
                        $("#error_curr_pass").removeClass('has-error');
                        $("#error_new_pass").addClass('has-error');
                        $(".aj_pass").text("");
                        $(".aj_new_pass").text("Your password confirmation doesn\'t match!");

                    } else {
                        swal({
                            title: 'Account Settings',
                            text: 'Password successfully updated!',
                            type: 'success',
                            timer: '3500'
                        });
                        $("#form-password").trigger("reset");
                        $("#error_curr_pass").removeClass('has-error');
                        $("#error_new_pass").removeClass('has-error');
                        $(".aj_pass").text("");
                        $(".aj_new_pass").text("");
                        $("#show_password_settings").click();
                    }
                },
                error: function () {
                    swal({
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        type: 'error',
                        timer: '1500'
                    });
                }
            });
            return false;
        });

        document.getElementById("file-input").onchange = function () {
            var files_size = this.files[0].size,
                max_file_size = 2000000, allowed_file_types = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg'],
                file_name = $(this).val().replace(/C:\\fakepath\\/i, ''),
                progress_bar_id = $("#progress-upload .progress-bar");

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
                        title: 'AVA Settings',
                        text: file_name + " with total size " + filesize(files_size) + ", Allowed size is " + filesize(max_file_size) + ", Try smaller file!",
                        type: 'error',
                        timer: '3500'
                    });

                } else {
                    $(this.files).each(function (i, ifile) {
                        if (ifile.value !== "") {
                            if (allowed_file_types.indexOf(ifile.type) === -1) {
                                swal({
                                    title: 'AVA Settings',
                                    text: file_name + " is unsupported file type!",
                                    type: 'error',
                                    timer: '3500'
                                });
                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{route('agency.update.settings')}}',
                                    data: new FormData($("#form-ava")[0]),
                                    contentType: false,
                                    processData: false,
                                    mimeType: "multipart/form-data",
                                    xhr: function () {
                                        var xhr = $.ajaxSettings.xhr();
                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function (event) {
                                                var percent = 0;
                                                var position = event.loaded || event.position;
                                                var total = event.total;
                                                if (event.lengthComputable) {
                                                    percent = Math.ceil(position / total * 100);
                                                }
                                                //update progressbar
                                                $("#progress-upload").css("display", "block");
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
                                        $(".show_ava").attr('src', data);
                                        swal({
                                            title: 'AVA Settings',
                                            text: 'Successfully update AVA!',
                                            type: 'success',
                                            timer: '3500'
                                        });
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
                        } else {
                            swal({
                                title: 'Oops...',
                                text: 'Cancel clicked, there\'s no any file selected!',
                                type: 'error',
                                timer: '1500'
                            })
                        }
                    });
                }
            }
        };

        function editVacancy(id) {
            $.ajax({
                url: "{{ url('account/agency/vacancy/edit') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    var numb = data.pengalaman.match(/\d/g);
                    numb = numb.join("");

                    $("#form-vacancy").attr("action", "{{ url('account/agency/vacancy/update') }}" + '/' + id);
                    $("#form-vacancy input[name='_method']").val('PUT');
                    $("#vacancy_settings").toggle(300);
                    $("#stats_vacancy").toggle(300);
                    if ($("#btn_save_vacancy").attr('disabled')) {
                        $("#btn_save_vacancy").removeAttr('disabled');
                    } else {
                        $("#btn_save_vacancy").attr('disabled', 'disabled');
                    }
                    $("#btn_cancel_vacancy").show();

                    $('#judul').val(data.judul);
                    $('#job_funct').val(data.fungsikerja_id).selectpicker("refresh");
                    $('#industry').val(data.industry_id).selectpicker("refresh");
                    $('#job_level').val(data.joblevel_id).selectpicker("refresh");
                    $('#job_type').val(data.jobtype_id).selectpicker("refresh");
                    $('#city_id').val(data.cities_id).selectpicker("refresh");
                    $('#salary_id').val(data.salary_id).selectpicker("refresh");
                    $('#pengalaman').val(numb);
                    $('#interview').val(data.interview);
                    $('#tingkatpend').val(data.tingkatpend_id).selectpicker("refresh");
                    $('#jurusanpend').val(data.jurusanpend_id).selectpicker("refresh");
                    tinyMCE.get('syarat').setContent(data.syarat);
                    tinyMCE.get('tanggungjawab').setContent(data.tanggungjawab);
                },
                error: function () {
                    swal({
                        title: 'Vacancy Setup',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        }

        function editVacancySchedule(id, isPost) {
            if (isPost == true) {
                $.ajax({
                    url: "{{ url('account/agency/vacancy/edit') }}" + '/' + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function (data) {
                        var $interview = data.interview_date,
                            $start = data.recruitmentDate_start, $end = data.recruitmentDate_end;
                        if ($interview == null) {
                            $interview = "";
                        }
                        if ($start == null) {
                            $start = "";
                        }
                        if ($end == null) {
                            $end = "";
                        }
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
                            '<div class="col-lg-6">' +
                            '<small>Active Period</small>' +
                            '<div class="input-group">' +
                            '<span class="input-group-addon">' +
                            '<i class="fa fa-calendar-check"></i></span>' +
                            '<input class="form-control" type="text" value="' + data.active_period + '" ' +
                            'id="active_period" disabled></div></div>' +
                            '<div class="col-lg-6">' +
                            '<small>Interview Date</small>' +
                            '<div class="input-group">' +
                            '<span class="input-group-addon">' +
                            '<i class="fa fa-comments"></i></span>' +
                            '<input style="background-color: #fff" class="form-control datepicker" ' +
                            'type="text" maxlength="10" ' +
                            'placeholder="yyyy-mm-dd" name="interview_date" id="interview_date" ' +
                            'value="' + $interview + '" required></div></div></div>' +
                            '<div class="row form-group" style="margin-bottom: 0">' +
                            '<div class="col-lg-6">' +
                            '<small>Recruitment Start Date</small>' +
                            '<div class="input-group">' +
                            '<span class="input-group-addon">' +
                            '<i class="fa fa-hourglass-start"></i></span>' +
                            '<input style="background-color: #fff" class="form-control datepicker" ' +
                            'type="text" maxlength="10" ' +
                            'placeholder="yyyy-mm-dd" name="recruitmentDate_start" id="recruitmentDate_start" ' +
                            'value="' + $start + '" required></div></div>' +
                            '<div class="col-lg-6">' +
                            '<small>Recruitment End Date</small>' +
                            '<div class="input-group">' +
                            '<span class="input-group-addon">' +
                            '<i class="fa fa-hourglass-end"></i></span>' +
                            '<input style="background-color: #fff" class="form-control datepicker" ' +
                            'type="text" maxlength="10" ' +
                            'placeholder="yyyy-mm-dd" name="recruitmentDate_end" id="recruitmentDate_end" ' +
                            'value="' + $end + '" required></div></div></div>' +
                            '<div class="row form-group">' +
                            '<div class="col-lg-12"><small style="font-size: 12px;color: #fa5555;">' +
                            'P.S.: You\'re only permitted to set those dates before its active period runs out.' +
                            '</small></div></div></div></div></div></div></div>' +
                            '<div class="modal-footer">' +
                            '<div class="card-read-more" id="btn-schedule">' +
                            '<button class="btn btn-link btn-block" type="submit">' +
                            '<i class="fa fa-calendar"></i>&ensp;SAVE CHANGES</button></div></div></form>'
                        );
                        $("#form-schedule input[name='_method']").val('PUT');
                        $("#vacancy_title").html('<strong>' + data.judul + '</strong> &ndash; VACANCY SCHEDULE');
                        $('.datepicker').datepicker({
                            format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                            endDate: data.active_period
                        });
                        $("#formModal").modal('show');
                    },
                    error: function () {
                        swal({
                            title: 'Vacancy Setup',
                            text: 'Data not found!',
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });

            } else {
                swal({
                    title: 'ATTENTION!',
                    text: "It seems this vacancy isn't posted yet. To post your vacancy, please select one of " +
                        "the available Plans Package on the Agency\'s Home page first",
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
@endauth