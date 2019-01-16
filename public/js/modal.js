function showEmailForm() {
    $('.loginBox, .registerBox, .passwordBox, .partnershipBox')
        .fadeOut('fast', function () {
            $('.emailBox').fadeIn('fast');
            $('.register-footer, .partnership-footer').fadeOut('fast', function () {
                $('.login-footer').fadeIn('fast');
            });

            $('.modal-title').html('Reset Password');
        });
    $('.error').removeClass('alert alert-danger').html('');
}

function showResetPasswordForm() {
    $('.emailBox, .registerBox, .loginBox, .partnershipBox')
        .fadeOut('fast', function () {
            $('.passwordBox').fadeIn('fast');
            $('.login-footer, .partnership-footer, .register-footer').fadeOut('fast');
            $('.modal-title').html('Recovery Password');
        });
    $('.error').removeClass('alert alert-danger').html('');
}

function showPartnershipForm() {
    $('.emailBox, .registerBox, .loginBox, .passwordBox')
        .fadeOut('fast', function () {
            $('.partnershipBox').fadeIn('fast');
            $('.login-footer, .register-footer').fadeOut('fast', function () {
                $('.partnership-footer').fadeIn('fast');
            });

            $('.modal-title').html('SISKA Partnership');
        });
}

function openLoginModal() {
    $("#loginModal .social, #loginModal .division").show();
    showLoginForm();
    setTimeout(function () {
        $('#loginModal').modal('show');
    }, 230);
}

function openRegisterModal() {
    $("#loginModal .social, #loginModal .division").show();
    showRegisterForm();
    setTimeout(function () {
        $('#loginModal').modal('show');
    }, 230);
}

function openEmailModal() {
    $("#loginModal .social, #loginModal .division").show();
    showEmailForm();
    setTimeout(function () {
        $('#loginModal').modal('show');
    }, 230);
}

function openPasswordModal() {
    $("#loginModal .social, #loginModal .division").show();
    showResetPasswordForm();
    setTimeout(function () {
        $('#loginModal').modal('show');
    }, 230);
}


function openPartnershipModal() {
    $("#loginModal .social, #loginModal .division").hide();
    showPartnershipForm();
    setTimeout(function () {
        $('#loginModal').modal('show');
    }, 230);
}

/*
function loginAjax() {
    /!*   Remove this comments when moving to server
    $.post( "/login", function( data ) {
            if(data == 1){
                window.location.replace("/home");
            } else {
                 shakeModal();
            }
        });
    *!/

    /!*   Simulate error message from the server   *!/
    shakeModal();
}

function shakeModal() {
    $('#loginModal .modal-dialog').addClass('shake');
    $('.error').addClass('alert alert-danger').html("Invalid email/password combination");
    $('input[type="password"]').val('');
    setTimeout(function () {
        $('#loginModal .modal-dialog').removeClass('shake');
    }, 1000);
}*/
