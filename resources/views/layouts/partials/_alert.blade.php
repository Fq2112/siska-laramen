<script>
    @if(session('contact'))
    swal({
        title: 'Successfully sent a message!',
        text: '{{ session('contact') }}',
        type: 'success',
        timer: '5500'
    });
    @elseif(session('activated'))
    swal({
        title: 'Account Activated!',
        text: '{{ session('activated') }}',
        type: 'success',
        timer: '3500'
    });
    @elseif(session('signed'))
    swal({
        title: 'Welcome {{Auth::user()->name}}!',
        text: '{{ session('signed') }}',
        type: 'success',
        timer: '3500'
    });
    @elseif(session('expire'))
    swal({
        title: 'Authentication Required!',
        text: '{{ session('expire') }}',
        type: 'error',
        timer: '5000'
    });
    @elseif(session('logout'))
    swal({
        title: 'Signed Out!',
        text: '{{ session('logout') }}',
        type: 'warning',
        timer: '3500'
    });
    @elseif(session('warning'))
    swal({
        title: 'ATTENTION!',
        text: '{{ session('warning') }}',
        type: 'warning',
        timer: '3500'
    });
    @elseif(session('status'))
    swal({
        title: 'Reset Password Success!',
        text: '{{ session('status') }}',
        type: 'success',
        timer: '3500'
    });
    @elseif(session('unknown'))
    swal({
        title: 'Social Provider Error!',
        text: '{{ session('unknown') }}',
        type: 'error',
        timer: '3500'
    });

    @elseif(session('add'))
    swal({
        title: 'Profile Settings',
        text: '{{ session('add') }}',
        type: 'success',
        timer: '3500'
    });
    @elseif(session('update'))
    swal({
        title: 'Profile Settings',
        text: '{{ session('update') }}',
        type: 'success',
        timer: '3500'
    });
    @elseif(session('delete'))
    swal({
        title: 'Profile Settings',
        text: '{{ session('delete') }}',
        type: 'success',
        timer: '3500'
    });
    @elseif(session('error'))
    swal({
        title: 'Profile Settings',
        text: '{{ session('error') }}',
        type: 'error',
        timer: '3500'
    });
    @elseif(session('vacancy'))
    swal({
        title: 'Good Luck!',
        text: '{{ session('vacancy') }}',
        type: 'success',
        timer: '7000'
    });
    @elseif(session('agency'))
    swal({
        title: 'Favorite Agency',
        text: '{{ session('agency') }}',
        type: 'success',
        timer: '3500'
    });
    @elseif(session('jobPosting'))
    swal({
        title: 'Job Posting',
        text: '{{ session('jobPosting') }}',
        type: 'success',
        timer: '7000'
    });
    @elseif(session('seeker'))
    swal({
        title: 'Invite Seeker',
        text: '{{ session('seeker') }}',
        type: 'success',
        timer: '3500'
    });
    @endif

    @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    swal({
        title: 'Oops..!',
        text: '{{ $error }}',
        type: 'error',
        timer: '3500'
    });
    @endforeach
    @endif

    $(function () {
        $('#form-login').submit(function (event) {
            var verified = grecaptcha.getResponse();
            if (verified.length === 0) {
                event.preventDefault();
                swal({
                    title: 'ATTENTION!',
                    text: 'Please confirm us that you are not a robot, with clicking in the reCAPTCHA dialog-box.',
                    type: 'warning',
                    timer: '3500'
                });
            }
        });
    });
</script>