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
        $(window).scrollTop(0);
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
</script>