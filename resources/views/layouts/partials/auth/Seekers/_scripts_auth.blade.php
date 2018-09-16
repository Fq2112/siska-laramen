<script>
    $("#show_password_settings").click(function () {
        $(this).text(function (i, v) {
            return v === "PASSWORD SETTINGS" ? "Change Password ?" : "PASSWORD SETTINGS";
        });
        if ($(this).text() === 'Change Password ?') {
            this.style.color = "#fa5555";
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

    $("#show_background_settings").click(function () {
        $("#input-background").trigger('click');
    });

    $("#show_contact_settings").click(function () {
        $("#contact_settings").toggle(300);
        $("#stats_contact").toggle(300);
        if ($("#btn_save_contact").attr('disabled')) {
            $("#btn_save_contact").removeAttr('disabled');
        } else {
            $("#btn_save_contact").attr('disabled', 'disabled');
        }
    });

    $("#show_personal_data_settings").click(function () {
        $("#personal_data_settings").toggle(300);
        $("#stats_personal_data").toggle(300);
        if ($("#btn_save_personal_data").attr('disabled')) {
            $("#btn_save_personal_data").removeAttr('disabled');
        } else {
            $("#btn_save_personal_data").attr('disabled', 'disabled');
        }
    });

    $("#show_summary_settings").click(function () {
        $("#summary_settings").toggle(300);
        $("#stats_summary").toggle(300);
        if ($("#btn_save_summary").attr('disabled')) {
            $("#btn_save_summary").removeAttr('disabled');
        } else {
            $("#btn_save_summary").attr('disabled', 'disabled');
        }
    });

    $("#show_video_settings").on('click', function () {
        $("#video_settings").toggle(300);
        $(".stats_video").toggle(300);
        $("#btn_delete_video").toggle(300);
    });

    $("#show_attachments_settings").click(function () {
        $("#attachments_settings").toggle(300);
        $("#stats_attachments").toggle(300);
        $("#btn_attachments").toggle(300);
        $("#btn_delete_attachments").toggle(300);
    });

    $("#show_exp_settings, #btn_cancel_exp input[type=reset]").click(function () {
        $(window).scrollTop(1600);

        var form = $("#form-exp"), input = $("#exp_settings"), stats = $("#stats_exp"), btn = $("#btn_save_exp");
        $("#btn_cancel_exp").hide();
        form[0].reset();
        $("#exp_settings .selectpicker").val('default').selectpicker("refresh");
        input.toggle(300);
        stats.toggle(300);
        if (btn.attr('disabled')) {
            btn.removeAttr('disabled');
        } else {
            btn.attr('disabled', 'disabled');
        }
        $("#end_date").hide();
        $("#form-exp input[name='_method']").val('POST');
    });

    $("#show_edu_settings, #btn_cancel_edu input[type=reset]").click(function () {
        $("#btn_cancel_edu").hide();
        $("#form-edu")[0].reset();
        $("#edu_settings .selectpicker").val('default').selectpicker("refresh");
        $("#edu_settings").toggle(300);
        $("#stats_edu").toggle(300);
        if ($("#btn_save_edu").attr('disabled')) {
            $("#btn_save_edu").removeAttr('disabled');
        } else {
            $("#btn_save_edu").attr('disabled', 'disabled');
        }
        $("#end_period").hide();
        $("#form-edu input[name='_method']").val('POST');
    });

    $("#show_cert_settings, #btn_cancel_cert input[type=reset]").click(function () {
        $("#btn_cancel_cert").hide();
        $("#form-cert")[0].reset();
        $("#cert_settings").toggle(300);
        $("#stats_cert").toggle(300);
        if ($("#btn_save_cert").attr('disabled')) {
            $("#btn_save_cert").removeAttr('disabled');
        } else {
            $("#btn_save_cert").attr('disabled', 'disabled');
        }
        $("#form-cert input[name='_method']").val('POST');
    });

    $("#show_org_settings, #btn_cancel_org input[type=reset]").click(function () {
        $("#btn_cancel_org").hide();
        $("#form-org")[0].reset();
        $("#org_settings").toggle(300);
        $("#stats_org").toggle(300);
        if ($("#btn_save_org").attr('disabled')) {
            $("#btn_save_org").removeAttr('disabled');
        } else {
            $("#btn_save_org").attr('disabled', 'disabled');
        }
        $("#end_period2").hide();
        $("#form-org input[name='_method']").val('POST');
    });

    $("#show_lang_settings, #btn_cancel_lang input[type=reset]").click(function () {
        $("#btn_cancel_lang").hide();
        $("#form-lang")[0].reset();
        $("#lang_settings .selectpicker").val('default').selectpicker("refresh");
        $("#lang_settings").toggle(300);
        $("#stats_lang").toggle(300);
        if ($("#btn_save_lang").attr('disabled')) {
            $("#btn_save_lang").removeAttr('disabled');
        } else {
            $("#btn_save_lang").attr('disabled', 'disabled');
        }
        $("#form-lang input[name='_method']").val('POST');
    });

    $("#show_skill_settings, #btn_cancel_skill input[type=reset]").click(function () {
        $("#btn_cancel_skill").hide();
        $("#form-skill")[0].reset();
        $("#skill_settings .selectpicker").val('default').selectpicker("refresh");
        $("#skill_settings").toggle(300);
        $("#stats_skill").toggle(300);
        if ($("#btn_save_skill").attr('disabled')) {
            $("#btn_save_skill").removeAttr('disabled');
        } else {
            $("#btn_save_skill").attr('disabled', 'disabled');
        }
        $("#form-skill input[name='_method']").val('POST');
    });

    $(".gpa").on('blur', function () {
        if ($(this).val() > 4) {
            $(this).val("4.00");
        }
    });

    $(function () {
        var $attachments_cb = $(".attachments_cb"), $selectAll = $("#selectAll"),
            $btnDelete = $("#btn_delete_attachments button");

        $selectAll.click(function () {
            $('.attachments_cb').prop('checked', this.checked);
        });
        $attachments_cb.click(function () {
            if ($(".attachments_cb").length === $(".attachments_cb:checked").length) {
                $("#selectAll").prop('checked', true);
            } else {
                $("#selectAll").prop('checked', false);
            }
        });
        $attachments_cb.change(function () {
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
                $("#attachments_list li").addClass("active");
            } else {
                $("#attachments_list li").removeClass("active");
                $btnDelete.attr('disabled', true);
            }
        });
        $("#btn_save_attachments").on('click', function () {
            $("#form-attachments")[0].submit();
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
                        $("#form-delete-attachments")[0].submit();
                    });
                },
                allowOutsideClick: false
            });
            return false;
        });
    });

    function checkPassword() {
        var new_pas = $("#password").val(),
            re_pas = $("#password-confirm").val();
        if (new_pas != re_pas) {
            $("#error_new_pass").addClass('has-error');
            $(".aj_new_pass").text("Must match with your new password!");
            $("#btn_save_password").attr('disabled', 'disabled');
        } else {
            $("#error_new_pass").removeClass('has-error');
            $(".aj_new_pass").text("");
            $("#btn_save_password").removeAttr('disabled');
        }
    }

    function showEndDate() {
        var checkBox = document.getElementById("cb_end_date"),
            div = document.getElementById("end_date");
        if (checkBox.checked == true) {
            div.style.display = "none";
            $("#end_date input").val('');
        } else {
            div.style.display = "block";
        }
    }

    function showEndPeriod() {
        var checkBox = document.getElementById("cb_end_period"),
            div = document.getElementById("end_period"),
            checkBox2 = document.getElementById("cb_end_period2"),
            div2 = document.getElementById("end_period2");
        if (checkBox.checked == true) {
            div.style.display = "none";
            $("#end_period input").val('');
        } else {
            div.style.display = "block";
        }

        if (checkBox2.checked == true) {
            div2.style.display = "none";
            $("#end_period2 input").val('');
        } else {
            div2.style.display = "block";
        }
    }

    /*Video Settings*/
    var $attach = $('#attach-video'),
        $remove = $('#remove-video'),
        $name = $('#attached-video');
    $remove.hide();
    $attach.on('change', function () {
        var val = $(this).val().replace(/C:\\fakepath\\/i, '');
        if (val !== '') {
            $name
                .hide()
                .text(val)
                .fadeIn();
            $remove.fadeIn();
        } else {
            $name
                .hide()
                .text('Select a file or drag here')
                .fadeIn();
            $remove.fadeOut();
        }
    });
    $remove.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        $attach.val('').change();
    });

    /*Attachment files settings*/
    $(".browse_files").on('click', function () {
        $("#attach-files").trigger('click');
    });

    $("#attach-files").on('change', function () {
        var files = $(this).prop("files");
        var count = $(this).get(0).files.length;
        var names = $.map(files, function (val) {
            return val.name;
        });
        var txt = $("#txt_attach");
        txt.val(names);
        $("#txt_attach[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
        if (count > 1) {
            $("#count_files").text(count + " files selected");
        } else {
            $("#count_files").text(count + " file selected");
        }
    });
</script>