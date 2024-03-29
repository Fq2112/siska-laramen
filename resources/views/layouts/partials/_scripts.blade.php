<script>
    var editor_config;
    $(document).ready(function () {
        Scrollbar.initAll();

        $('.carousel-indicators:nth-child(1)').addClass('active');
        $('.item:nth-child(1)').addClass('active');

        @if(!\Illuminate\Support\Facades\Request::is('search*'))
        $("#btn_reset").hide();
        @endif

        $('[data-toggle="tooltip"]').tooltip();

        $('[data-toggle="popover"]').popover();

        $('.gpa').simpleGPAFormat();
        $(".rupiah").maskMoney({thousands: ',', decimal: '.', precision: '0'});
        $('.datetimepicker').datetimepicker({format: "YYYY-MM-DD HH:mm:ss"});
        $('.timepicker').datetimepicker({format: "HH:mm"});
        $('.daypicker').datetimepicker({format: 'dddd', viewMode: 'days'});
        $('.datepicker').datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, todayBtn: true});
        $('.yearpicker').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true,
            todayHighlight: true,
            todayBtn: true
        });

        $('#toggle').click(function () {
            $('#target').toggleClass('active');
        });

        $('.tree-toggle').click(function () {
            $(this).parent().children('ul.tree').toggle(200);
        });

        $('.alert-banner-close').on('click', function () {
            $('.alert-banner').slideUp(300, function () {
                $(this).remove();
            });
        });

        editor_config = {
            branding: false,
            path_absolute: '{{url('/')}}',
            selector: '.use-tinymce',
            height: 300,
            themes: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code',
                'insertdatetime media table contextmenu paste code help wordcount'
            ],
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            relative_urls: false,
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth ||
                    document.getElementsByTagName('body')[0].clientWidth,
                    y = window.innerHeight || document.documentElement.clientHeight ||
                        document.getElementsByTagName('body')[0].clientHeight,
                    cmsURL = editor_config.path_absolute + 'filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + '&type=Images';
                } else {
                    cmsURL = cmsURL + '&type=Files';
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'File Manager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: 'yes',
                    close_previous: 'no'
                });
            }
        };
        tinymce.init(editor_config);

        @if(session('success') || session('error') || session('logout') || session('expire') || session('inactive') ||
        session('unknown') || session('recovered'))
        openLoginModal();
        @elseif($errors->has('email') || $errors->has('password') || $errors->has('name'))
        openRegisterModal();
        @elseif(session('resetLink') || session('resetLink_failed'))
        openEmailModal();
        @elseif(session('reset') || session('recover_failed'))
        openPasswordModal();
        @endif
    });

    var recaptcha_register, recaptcha_partnership, recaptchaCallback = function () {
        recaptcha_register = grecaptcha.render(document.getElementById('recaptcha-register'), {
            'sitekey': '{{env('reCAPTCHA_v2_SITEKEY')}}',
            'callback': 'enable_btnRegister',
            'expired-callback': 'disabled_btnRegister'
        });
        recaptcha_partnership = grecaptcha.render(document.getElementById('recaptcha-partnership'), {
            'sitekey': '{{env('reCAPTCHA_v2_SITEKEY')}}',
            'callback': 'enable_btnPartnership',
            'expired-callback': 'disabled_btnPartnership'
        });
    };

    function enable_btnLogin() {
        $("#btn_login").removeAttr('disabled');
    }

    function disabled_btnLogin() {
        $("#btn_login").attr('disabled', 'disabled');
    }

    function enable_btnRegister() {
        $("#btn_register").removeAttr('disabled');
    }

    function disabled_btnRegister() {
        $("#btn_register").attr('disabled', 'disabled');
    }

    function enable_btnPartnership() {
        $("#btn_partnership").removeAttr('disabled');
    }

    function disabled_btnPartnership() {
        $("#btn_partnership").attr('disabled', 'disabled');
    }

    $("#form-login").on("submit", function (e) {
        if (grecaptcha.getResponse(recaptcha_login).length === 0) {
            e.preventDefault();
            swal({
                title: 'ATTENTION!',
                text: 'Please confirm us that you\'re not a robot by clicking in the reCAPTCHA dialog-box.',
                type: 'warning',
                timer: '5500',
                confirmButtonColor: '#fa5555',
            });
        }
    });

    $("#form-register").on("submit", function (e) {
        if (grecaptcha.getResponse(recaptcha_register).length === 0) {
            e.preventDefault();
            swal({
                title: 'ATTENTION!',
                text: 'Please confirm us that you\'re not a robot by clicking in the reCAPTCHA dialog-box.',
                type: 'warning',
                timer: '5500',
                confirmButtonColor: '#fa5555',
            });
        }

        if ($.trim($("#reg_email,#reg_name,#reg_password,#reg_password_confirm").val()) === "") {
            return false;

        } else {
            if ($("#reg_password_confirm").val() != $("#reg_password").val()) {
                return false;

            } else {
                $("#reg_errorAlert").html('');
                return true;
            }
        }
    });

    $("#reg_password_confirm").on("keyup", function () {
        if ($(this).val() != $("#reg_password").val()) {
            $("#reg_errorAlert").html(
                '<div class="alert alert-danger alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                '<h4><i class="icon fa fa-times"></i> Alert!</h4>Your password confirmation doesn\'t match!</div>'
            );
        } else {
            $("#reg_errorAlert").html('');
        }
    });

    function checkForgotPassword() {
        var new_pas = $("#forg_password").val(),
            re_pas = $("#forg_password_confirm").val();
        if (new_pas != re_pas) {
            $("#forg_errorAlert").html(
                '<div class="alert alert-danger alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                '<h4><i class="icon fa fa-times"></i> Alert!</h4>Your password confirmation doesn\'t match!</div>'
            );
            $(".btn-password").attr('disabled', 'disabled');

        } else {
            $("#forg_errorAlert").html('');
            $(".btn-password").removeAttr('disabled');
        }
    }

    $("#form-recovery").on("submit", function (e) {
        if ($("#forg_password_confirm").val() != $("#forg_password").val()) {
            $(".btn-password").attr('disabled', 'disabled');
            return false;

        } else {
            $("#forg_errorAlert").html('');
            $(".btn-password").removeAttr('disabled');
            return true;
        }
    });

    $('#log_password + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#log_password').togglePassword();
    });

    $('#reg_password + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#reg_password').togglePassword();
    });

    $('#reg_password_confirm + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#reg_password_confirm').togglePassword();
    });

    $('#forg_password + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#forg_password').togglePassword();
    });

    $('#forg_password_confirm + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#forg_password_confirm').togglePassword();
    });

    function checkRupiahValue() {
        var low = parseInt($("#lowest").val().split(',').join("")), input = $("#highest"),
            high = parseInt(input.val().split(',').join(""));
        if (low < 1000 || high < 1000) {
            $(".checkRupiahValue").addClass('has-error');
            $(".aj_rp").text("Range invalid! These input value must be greater than or equal to 1000.");
            $("#btn_save_personal_data").attr('disabled', 'disabled');
        } else {
            if (low > high) {
                $(".checkRupiahValue").addClass('has-error');
                $(".aj_rp").text("Range invalid! This input value must be greater than or equal to the previous one.");
                $("#btn_save_personal_data").attr('disabled', 'disabled');
            } else {
                $(".checkRupiahValue").removeClass('has-error');
                $(".aj_rp").text("");
                $("#btn_save_personal_data").removeAttr('disabled');
            }
        }
        $(document).keypress(function (e) {
            if (e.which == 13) {
                checkRupiahValue();
            }
        });
    }

    function thousandSeparator(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }

    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    <!--Filter City-->
    function filterFunction() {
        var input, a, i;
        input = $("#txt_filter").val().toUpperCase();
        a = $("#list-lokasi a");
        $("#list-lokasi .dropdown-header, #list-lokasi .divider").hide();
        for (i = 0; i < a.length; i++) {
            if (a.eq(i).text().toUpperCase().indexOf(input) > -1) {
                a.eq(i).parents("li").show();
                $('.province' + a.eq(i).parents("li").data('id')).show();
                $('#divider').show();
            } else {
                a.eq(i).parents("li").hide();
                $('.not_found').show();
            }
        }
    }

    $("#btn_reset").on("click", function () {
        $(this).hide();
        $("#lokasi").html('Filter&nbsp;<span class="fa fa-caret-down">' + '</span>');
        $("#txt_keyword").removeAttr('value');
        $(".search-form input:not(#txt_sort)").val('');
        filterFunction();
    });

    function showResetBtn(keyword) {
        if (keyword && keyword.length <= 0) {
            $("#btn_reset").hide();
        } else {
            $("#btn_reset").show();
        }
    }

    $("#list-lokasi li a").click(function () {
        var location = $(this).text();
        $('#lokasi').html(location + '&nbsp;<span class="fa fa-caret-down">' + '</span>');
        $("#btn_reset").show();
        $("#txt_location").val(location);
    });

    <!--end:filter city-->

    function numberOnly(e, decimal) {
        var key;
        var keychar;
        if (window.event) {
            key = window.event.keyCode;
        } else if (e) {
            key = e.which;
        } else return true;
        keychar = String.fromCharCode(key);
        if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27) || (key == 188)) {
            return true;
        } else if ((("0123456789").indexOf(keychar) > -1)) {
            return true;
        } else if (decimal && (keychar == ".")) {
            return true;
        } else return false;
    }

    function showRegisterForm() {
        $('.loginBox, .emailBox, .passwordBox, .partnershipBox').fadeOut('fast', function () {
            $('.registerBox').fadeIn('fast');
            $('.login-footer, .partnership-footer').fadeOut('fast', function () {
                $('.register-footer').fadeIn('fast');
            });
            $('.modal-title').html('{{ \Illuminate\Support\Facades\Request::is('agency') ? 'Sign Up as a Job Agency' : 'Sign Up With' }}');
        });
        $('.error').removeClass('alert alert-danger').html('');

    }

    function showLoginForm() {
        $('.registerBox, .emailBox, .passwordBox, .partnershipBox').fadeOut('fast', function () {
            $('.loginBox').fadeIn('fast');
            $('.register-footer, .partnership-footer').fadeOut('fast', function () {
                $('.login-footer').fadeIn('fast');
            });

            $('.modal-title').html('{{ \Illuminate\Support\Facades\Request::is('agency') ? 'Sign In as a Job Agency' : 'Sign In With' }}');
        });
        $('.error').removeClass('alert alert-danger').html('');
    }

    $('.carousel').carousel();

    var title = document.getElementsByTagName("title")[0].innerHTML;
    (function titleScroller(text) {
        document.title = text;
        setTimeout(function () {
            titleScroller(text.substr(1) + text.substr(0, 1));
        }, 500);
    }(title + " ~ "));

    <!--Scroll to top button-->
    window.onscroll = function () {
        scrollFunction()
    };

    function scrollFunction() {
        if ($(this).scrollTop() > 100) {
            $('.to-top').addClass('show-to-top');
        } else {
            $('.to-top').removeClass('show-to-top');
        }
    }

    function scrollToTop(callback) {
        if ($('html').scrollTop()) {
            $('html').animate({scrollTop: 0}, callback);
            return;
        }
        if ($('body').scrollTop()) {
            $('body').animate({scrollTop: 0}, callback);
            return;
        }
        callback();
    }

    <!--end:Scroll to top button-->

    $("figure").mouseleave(
        function () {
            $(this).removeClass("hover");
        }
    );

    <!--Scroll Progress Bar-->
    function progress() {

        var windowScrollTop = $(window).scrollTop();
        var docHeight = $(document).height();
        var windowHeight = $(window).height();
        var progress = (windowScrollTop / (docHeight - windowHeight)) * 100;
        var $bgColor = progress > 99 ? '#00ADB5' : '#FA5555';
        var $textColor = progress > 99 ? '#fff' : '#333';

        $('.progress .bar').width(progress + '%').css({backgroundColor: $bgColor});
        // $('h1').text(Math.round(progress) + '%').css({color: $textColor});
        $('.fill').height(progress + '%').css({backgroundColor: $bgColor});
    }

    progress();

    $(document).on('scroll', progress);

    <!-- WhatsHelp.io widget -->
    window.onload = function() {
        $('.images-preloader').fadeOut();

        window.mobilecheck() ? $("body").removeClass('use-nicescroll') : '';
        $(".use-nicescroll").niceScroll({
            cursorcolor: "{{Auth::guard('admin')->check() || Auth::check() && Auth::user()->isAgency() ? 'rgb(0,173,181)' : 'rgb(255,85,85)'}}",
            cursorwidth: "8px",
            background: "rgba(222, 222, 222, .75)",
            cursorborder: 'none',
            // cursorborderradius:0,
            autohidemode: 'leave',
            zindex: 99999999,
        });

        var options = {
            whatsapp: "+6281356598237",
            telegram: "fq2112",
            call_to_action: "Message us",
            button_color: "{{Auth::guard('admin')->check() || Auth::check() && Auth::user()->isAgency() ? '#00ADB5' : '#FA5555'}}",
            position: "left",
            order: "whatsapp, telegram",
        };
        var proto = document.location.protocol, host = "whatshelp.io", url = proto + "//static." + host;
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () {
            WhWidgetSendButton.init(host, proto, options);
        };
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
    };

    $(document).on('mouseover', '.use-nicescroll', function () {
        $(this).getNiceScroll().resize();
    });

    if($(".nicescrolls").length > 0) {
        $(document).on('mouseover', '.nicescrolls', function () {
            $(this).getNiceScroll().resize();
        });
    }
</script>
