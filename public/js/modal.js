// reset password form
function showEmailForm() {
    $('#loginModal .loginBox, .registerBox, .passwordBox').fadeOut('fast', function () {
        $('.emailBox').fadeIn('fast');
        $('.register-footer').fadeOut('fast', function () {
            $('.login-footer').fadeIn('fast');
        });

        $('.modal-title').html('Reset Password');
    });
    $('.error').removeClass('alert alert-danger').html('');
}

function showResetPasswordForm() {
    $('#loginModal .emailBox, .registerBox, .loginBox').fadeOut('fast', function () {
        $('.passwordBox').fadeIn('fast');
        $('.login-footer').fadeOut('fast', function () {
            $('.register-footer-footer').fadeIn('fast');
        });

        $('.modal-title').html('Reset Password');
    });
    $('.error').removeClass('alert alert-danger').html('');
}

function openLoginModal() {
    showLoginForm();
    setTimeout(function () {
        $('#loginModal').modal('show');
    }, 230);
}

function openRegisterModal() {
    showRegisterForm();
    setTimeout(function () {
        $('#loginModal').modal('show');
    }, 230);
}

// reset password modal
function openEmailModal() {
    showEmailForm();
    setTimeout(function () {
        $('#loginModal').modal('show');
    }, 230);
}

function openPasswordModal() {
    showResetPasswordForm();
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
