@auth
    <script>
        $("#form-password").on("submit", function (e) {
            $.ajax({
                type: 'POST',
                url: '{{route('update.settings')}}',
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

        document.getElementById("input-background").onchange = function () {
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
                        title: 'Background Settings',
                        text: file_name + " with total size " + filesize(files_size) + ", Allowed size is " + filesize(max_file_size) + ", Try smaller file!",
                        type: 'error',
                        timer: '3500'
                    });

                } else {
                    $(this.files).each(function (i, ifile) {
                        if (ifile.value !== "") {
                            if (allowed_file_types.indexOf(ifile.type) === -1) {
                                swal({
                                    title: 'Background Settings',
                                    text: file_name + " is unsupported file type!",
                                    type: 'error',
                                    timer: '3500'
                                });
                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{route('update.background')}}',
                                    data: new FormData($("#form-background")[0]),
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
                                                    progress_bar_id.removeClass("progress-bar-danger");
                                                    progress_bar_id.addClass("progress-bar-success");
                                                } else {
                                                    progress_bar_id.removeClass("progress-bar-success");
                                                    progress_bar_id.addClass("progress-bar-danger");
                                                }
                                            }, true);
                                        }
                                        return xhr;
                                    },
                                    success: function (data) {
                                        var url = 'url("{{asset('storage/users/seekers/background')}}/' + data + '")';
                                        $(".show_background").css('background-image', url);
                                        $("#show_background_name").html("&nbsp;" + data);
                                        swal({
                                            title: 'Background Settings',
                                            text: 'Successfully update background!',
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

        document.getElementById("file-input").onchange = function () {
            var files_size = this.files[0].size,
                max_file_size = 2000000, allowed_file_types = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg'],
                file_name = $(this).val().replace(/C:\\fakepath\\/i, ''),
                progress_bar_id = $("#progress-upload-ava .progress-bar");

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
                                    url: '{{route('update.settings')}}',
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
                                                $("#progress-upload-ava").css("display", "block");
                                                progress_bar_id.css("width", +percent + "%");
                                                progress_bar_id.text(percent + "%");
                                                if (percent == 100) {
                                                    progress_bar_id.removeClass("progress-bar-danger");
                                                    progress_bar_id.addClass("progress-bar-success");
                                                } else {
                                                    progress_bar_id.removeClass("progress-bar-success");
                                                    progress_bar_id.addClass("progress-bar-danger");
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
                                        $("#progress-upload-ava").css("display", "none");
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

        function ekUpload() {
            function Init() {
                var fileSelect = document.getElementById('attach-video'),
                    fileDrag = document.getElementById('video-label');

                fileSelect.addEventListener('change', fileSelectHandler, false);

                var xhr = new XMLHttpRequest();
                if (xhr.upload) {
                    fileDrag.addEventListener('dragover', fileDragHover, false);
                    fileDrag.addEventListener('dragleave', fileDragHover, false);
                    fileDrag.addEventListener('drop', fileSelectHandler, false);
                }
            }

            function fileDragHover(e) {
                var fileDrag = document.getElementById('video-label');

                e.stopPropagation();
                e.preventDefault();

                fileDrag.className = (e.type === 'dragover' ? 'hover' : '');
            }

            function fileSelectHandler(e) {
                var files = e.target.files || e.dataTransfer.files;
                $("#attach-video").prop("files", files);

                fileDragHover(e);

                for (var i = 0, f; f = files[i]; i++) {
                    uploadVideo(f);
                }
            }

            function uploadVideo(file) {
                var files_size = file.size, file_name = file.name, max_file_size = 31457280,
                    allowed_file_types = (/\.(?=mp4|ogg|webm)/gi).test(file_name),
                    progress_bar_id = $("#progress-upload-video .progress-bar"), $remove = $('#remove-video');

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
                            title: 'Profile Settings',
                            text: file_name + " with total size " + filesize(files_size) + ", Allowed size is " + filesize(max_file_size) + ", Try smaller file!",
                            type: 'error',
                            timer: '3500'
                        });
                        $remove.click();
                        $("#progress-upload-video").css("display", "none");
                        $("#div_delVid").html("");

                    } else {
                        if (!allowed_file_types) {
                            swal({
                                title: 'Profile Settings',
                                text: file_name + " is unsupported file type!",
                                type: 'error',
                                timer: '3500'
                            });
                            $remove.click();
                            $("#progress-upload-video").css("display", "none");
                            $("#div_delVid").html("");

                        } else {
                            $.ajax({
                                type: 'POST',
                                url: '{{route('update.profile')}}',
                                data: new FormData($("#form-video-summary")[0]),
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
                                            $("#progress-upload-video").css("display", "block");
                                            progress_bar_id.css("width", +percent + "%");
                                            progress_bar_id.text(percent + "%");
                                            if (percent == 100) {
                                                progress_bar_id.removeClass("progress-bar-danger");
                                                progress_bar_id.addClass("progress-bar-success");
                                            } else {
                                                progress_bar_id.removeClass("progress-bar-success");
                                                progress_bar_id.addClass("progress-bar-danger");
                                            }
                                        }, true);
                                    }
                                    return xhr;
                                },
                                success: function (data) {
                                    $(".aj_video").attr('src', data);
                                    $(".aj_video_name,#attached-video").text(file_name);
                                    $("#show_video_settings").click();
                                    $("#div_delVid").html(
                                        '<a class="btn btn-link btn-block" id="btn_delete_video">' +
                                        '<i class="fa fa-eraser"></i>&nbsp;DELETE VIDEO</a>'
                                    );
                                    $remove.hide();
                                    swal({
                                        title: 'Profile Settings',
                                        text: 'Update successfully!',
                                        type: 'success',
                                        timer: '3500'
                                    });
                                    $("#progress-upload-video").css("display", "none");
                                },
                                error: function () {
                                    swal({
                                        title: 'Oops...',
                                        text: 'Something went wrong!',
                                        type: 'error',
                                        timer: '1500'
                                    });
                                    $remove.click();
                                    $("#progress-upload-video").css("display", "none");
                                    $("#div_delVid").html("");
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
                document.getElementById('video-label').style.display = 'none';
            }
        }

        ekUpload();

        $("#btn_delete_video").on("click", function () {
            $("#input_video").val("delete_video_summary");

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
                        $.ajax({
                            type: "POST",
                            url: '{{route('update.profile')}}',
                            data: new FormData($("#form-video-summary")[0]),
                            contentType: false,
                            processData: false,
                            success: function () {
                                $(".aj_video").attr('src', '{{asset("images/vid-placeholder.mp4")}}');
                                $("#btn_delete_video").css('display', "none");
                                $(".aj_video_name").html("Video that describes You. Allowed extension: mp4, webm, " +
                                    "and ogg. Allowed size: < 30 MB. <br><br>");
                                swal({
                                    title: 'Profile Settings',
                                    text: 'Delete successfully!',
                                    type: 'success',
                                    timer: '3500'
                                });
                                $("#progress-upload-video").css("display", "none");
                                $("#div_delVid").html("");
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
                    });
                },
                allowOutsideClick: false
            });
        });

        function editExp(id) {
            $.ajax({
                url: "{{ url('account/profile/experiences/edit') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $("#form-exp").attr("action", "{{ url('account/profile/experiences/update') }}" + '/' + id);
                    $("#form-exp input[name='_method']").val('PUT');
                    $("#exp_settings").toggle(300);
                    $("#stats_exp").toggle(300);
                    if ($("#btn_save_exp").attr('disabled')) {
                        $("#btn_save_exp").removeAttr('disabled');
                    } else {
                        $("#btn_save_exp").attr('disabled', 'disabled');
                    }
                    $("#btn_cancel_exp").show();
                    document.getElementById("cb_end_date").checked = false;
                    $("#end_date").show();
                    $('#job_title').val(data.job_title);
                    $('#company').val(data.company);
                    $('#start_date').val(data.start_date);
                    $('#end_date input').datepicker({
                        format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true,
                        startDate: data.start_date,
                    }).val(data.end_date);
                    $('#report_to').val(data.report_to);
                    tinyMCE.get('job_desc').setContent(data.job_desc);
                    $('#job_level').val(data.joblevel_id).selectpicker("refresh");
                    $('#job_funct').val(data.fungsikerja_id).selectpicker("refresh");
                    $('#job_type').val(data.jobtype_id).selectpicker("refresh");
                    $('#salary_id').val(data.salary_id).selectpicker("refresh");
                    $('#industry').val(data.industri_id).selectpicker("refresh");
                    $('#city_id').val(data.city_id).selectpicker("refresh");
                },
                error: function () {
                    swal({
                        title: 'Experience Settings',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        }

        function editEdu(id) {
            $.ajax({
                url: "{{ url('account/profile/educations/edit') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $("#form-edu").attr("action", "{{ url('account/profile/educations/update') }}" + '/' + id);
                    $("#form-edu input[name='_method']").val('PUT');
                    $("#edu_settings").toggle(300);
                    $("#stats_edu").toggle(300);
                    if ($("#btn_save_edu").attr('disabled')) {
                        $("#btn_save_edu").removeAttr('disabled');
                    } else {
                        $("#btn_save_edu").attr('disabled', 'disabled');
                    }
                    $("#btn_cancel_edu").show();
                    document.getElementById("cb_end_period").checked = false;
                    $("#end_period").show();

                    $('#school_name').val(data.school_name);
                    tinyMCE.get('awards').setContent(data.awards);
                    $('#start_period').val(data.start_period);
                    $('#end_period input').datepicker({
                        format: "yyyy",
                        viewMode: "years",
                        minViewMode: "years",
                        autoclose: true,
                        todayHighlight: true,
                        todayBtn: true,
                        startDate: data.start_period,
                    }).val(data.end_period);
                    $('#nilai').val(data.nilai);
                    $('#tingkatpend').val(data.tingkatpend_id).selectpicker("refresh");
                    $('#jurusanpend').val(data.jurusanpend_id).selectpicker("refresh");
                },
                error: function () {
                    swal({
                        title: 'Education Settings',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        }

        function editCert(id) {
            $.ajax({
                url: "{{ url('account/profile/trainings/edit') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $("#form-cert").attr("action", "{{ url('account/profile/trainings/update') }}" + '/' + id);
                    $("#form-cert input[name='_method']").val('PUT');
                    $("#cert_settings").toggle(300);
                    $("#stats_cert").toggle(300);
                    if ($("#btn_save_cert").attr('disabled')) {
                        $("#btn_save_cert").removeAttr('disabled');
                    } else {
                        $("#btn_save_cert").attr('disabled', 'disabled');
                    }
                    $("#btn_cancel_cert").show();

                    $('#name_cert').val(data.name);
                    $('#issuedby').val(data.issuedby);
                    $('#issueddate ').val(data.issueddate);
                    tinyMCE.get('desc_cert').setContent(data.descript);
                },
                error: function () {
                    swal({
                        title: 'Training Settings',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        }

        function editOrg(id) {
            $.ajax({
                url: "{{ url('account/profile/organizations/edit') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $("#form-org").attr("action", "{{ url('account/profile/organizations/update') }}" + '/' + id);
                    $("#form-org input[name='_method']").val('PUT');
                    $("#org_settings").toggle(300);
                    $("#stats_org").toggle(300);
                    if ($("#btn_save_org").attr('disabled')) {
                        $("#btn_save_org").removeAttr('disabled');
                    } else {
                        $("#btn_save_org").attr('disabled', 'disabled');
                    }
                    $("#btn_cancel_org").show();
                    document.getElementById("cb_end_period2").checked = false;
                    $("#end_period2").show();

                    $('#name_org').val(data.name);
                    $('#org_title').val(data.title);
                    $('#start_period2 ').val(data.start_period);
                    $('#end_period2 input').datepicker({
                        format: "yyyy",
                        viewMode: "years",
                        minViewMode: "years",
                        autoclose: true,
                        todayHighlight: true,
                        todayBtn: true,
                        startDate: data.start_period,
                    }).val(data.end_period);
                    tinyMCE.get('org_desc').setContent(data.descript);
                },
                error: function () {
                    swal({
                        title: 'Organization Settings',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        }

        function editLang(id) {
            $.ajax({
                url: "{{ url('account/profile/languages/edit') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $("#form-lang").attr("action", "{{ url('account/profile/languages/update') }}" + '/' + id);
                    $("#form-lang input[name='_method']").val('PUT');
                    $("#lang_settings").toggle(300);
                    $("#stats_lang").toggle(300);
                    if ($("#btn_save_lang").attr('disabled')) {
                        $("#btn_save_lang").removeAttr('disabled');
                    } else {
                        $("#btn_save_lang").attr('disabled', 'disabled');
                    }
                    $("#btn_cancel_lang").show();

                    $('#name_lang').val(data.name);
                    $('#spoken_lvl').val(data.spoken_lvl).selectpicker("refresh");
                    $('#written_lvl ').val(data.written_lvl).selectpicker("refresh");
                },
                error: function () {
                    swal({
                        title: 'Language Settings',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        }

        function editSkill(id) {
            $.ajax({
                url: "{{ url('account/profile/skills/edit') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $("#form-skill").attr("action", "{{ url('account/profile/skills/update') }}" + '/' + id);
                    $("#form-skill input[name='_method']").val('PUT');
                    $("#skill_settings").toggle(300);
                    $("#stats_skill").toggle(300);
                    if ($("#btn_save_skill").attr('disabled')) {
                        $("#btn_save_skill").removeAttr('disabled');
                    } else {
                        $("#btn_save_skill").attr('disabled', 'disabled');
                    }
                    $("#btn_cancel_skill").show();

                    $('#name_skill').val(data.name);
                    $('#skill_lvl').val(data.level).selectpicker("refresh");
                },
                error: function () {
                    swal({
                        title: 'Skill Settings',
                        text: 'Data not found!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        }
    </script>
@endauth