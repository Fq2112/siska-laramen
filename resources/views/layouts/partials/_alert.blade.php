<script>
    @if(session('contact'))
    swal({
        title: 'Successfully sent a message!',
        text: '{{ session('contact') }}',
        type: 'success',
        timer: '5500',
        confirmButtonColor: '#00adb5',
    });
    @elseif(session('activated'))
    swal({
        title: 'Account Activated!',
        text: '{{ session('activated') }}',
        type: 'success',
        timer: '3500',
        confirmButtonColor: '#00adb5',
    });
    @elseif(session('inactive'))
    swal({
        title: 'ATTENTION!',
        text: '{{ session('inactive') }}',
        type: 'error',
        timer: '3500',
        confirmButtonColor: '#fa5555',
    });
    @elseif(session('token'))
    swal({
        title: 'Validation Token Expired!',
        text: '{{session('token')}}',
        type: 'error',
        timer: '3500',
        confirmButtonColor: '#fa5555',
    });
    @elseif(session('signed'))
    swal({
        title: 'Signed In!',
        text: 'Welcome {{Auth::guard('admin')->check() ? Auth::guard('admin')->user()->name : Auth::user()->name}}! ' +
            'You\'re now signed in.',
        type: 'success',
        timer: '3500',
        confirmButtonColor: '#00adb5',
    });
    @elseif(session('expire'))
    swal({
        title: 'Authentication Required!',
        text: '{{ session('expire') }}',
        type: 'error',
        timer: '5000',
        confirmButtonColor: '#fa5555',
    });
    @elseif(session('logout'))
    swal({
        title: 'Signed Out!',
        text: '{{ session('logout') }}',
        type: 'warning',
        timer: '3500',
        confirmButtonColor: '#fa5555',
    });
    @elseif(session('warning'))
    swal({
        title: 'ATTENTION!',
        text: '{{ session('warning') }}',
        type: 'warning',
        timer: '3500',
        confirmButtonColor: '#fa5555',
    });

    @elseif(session('resetLink') || session('recovered'))
    swal({
        title: 'Success!',
        text: '{{session('resetLink') ? session('resetLink') : session('recovered') }}',
        type: 'success',
        timer: '3500',
        confirmButtonColor: '#00adb5',
    });

    @elseif(session('resetLink_failed') || session('recover_failed'))
    swal({
        title: 'Error!',
        text: '{{session('resetLink_failed') ? session('resetLink_failed') : session('recover_failed') }}',
        type: 'error',
        timer: '3500',
        confirmButtonColor: '#fa5555',
    });

    @elseif(session('unknown'))
    swal({
        title: 'Social Provider Error!',
        text: '{{ session('unknown') }}',
        type: 'error',
        timer: '3500',
        confirmButtonColor: '#fa5555',
    });

    @elseif(session('add'))
    swal({
        title: 'Profile Settings',
        text: '{{ session('add') }}',
        type: 'success',
        timer: '3500',
        confirmButtonColor: '#00adb5',
    });
    @elseif(session('update'))
    swal({
        title: 'Success!',
        text: '{{ session('update') }}',
        type: 'success',
        timer: '3500',
        confirmButtonColor: '#00adb5',
    });
    @elseif(session('delete'))
    swal({
        title: 'Success!',
        text: '{{ session('delete') }}',
        type: 'success',
        timer: '3500',
        confirmButtonColor: '#00adb5',
    });
    @elseif(session('error'))
    swal({
        title: 'Profile Settings',
        text: '{{ session('error') }}',
        type: 'error',
        timer: '3500',
        confirmButtonColor: '#fa5555',
    });
    @elseif(session('vacancy'))
    swal({
        title: 'Good Luck!',
        text: '{{ session('vacancy') }}',
        type: 'success',
        timer: '3500',
        confirmButtonColor: '#00adb5',
    });

    @elseif(session('agency'))
    swal({
        title: 'Favorite Agency',
        text: '{{ session('agency') }}',
        type: 'success',
        timer: '3500',
        confirmButtonColor: '#00adb5',
    });
    @elseif(session('jobPosting'))
    swal({
        title: 'Job Posting',
        text: '{{ session('jobPosting') }}',
        type: 'success',
        timer: '3500',
        confirmButtonColor: '#00adb5',
    });

    @elseif(session('seeker'))
    swal({
        title: 'Invite Seeker',
        text: '{{ session('seeker') }}',
        type: 'success',
        timer: '3500',
        confirmButtonColor: '#00adb5',
    });
    @endif

    @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    swal({
        title: 'Oops..',
        text: '{{ $error }}',
        type: 'error',
        timer: '3500',
        confirmButtonColor: '#fa5555',
    });
    @endforeach
    @endif
</script>
