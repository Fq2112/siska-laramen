<script>
    @if(session('success'))
    new PNotify({
        title: 'Success!',
        text: '{{session('success')}}',
        type: 'success',
        styling: 'bootstrap3'
    });
    @elseif(session('warning'))
    new PNotify({
        title: 'ATTENTION!',
        text: '{{session('warning')}}',
        type: 'warning',
        styling: 'bootstrap3'
    });
    @elseif(session('error'))
    new PNotify({
        title: 'Error!',
        text: '{{session('error')}}',
        type: 'error',
        styling: 'bootstrap3'
    });
    @endif

    @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    new PNotify({
        title: 'Error!',
        text: '{{$error}}',
        type: 'error',
        styling: 'bootstrap3'
    });
    @endforeach
    @endif
</script>