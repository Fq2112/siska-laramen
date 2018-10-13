<script>
    @if(session('success'))
    new PNotify({
        title: 'Success!',
        text: '{{session('success')}}',
        type: 'success',
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
</script>