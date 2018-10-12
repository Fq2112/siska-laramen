<script>
    $(".delete-attachments, .delete-exp, .delete-edu, .delete-cert, .delete-org, .delete-lang, .delete-skill, .delete-vacancy, .delete-users").on('click', function () {
        var linkURL = $(this).attr("href");
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
                    window.location.href = linkURL;
                });
            },
            allowOutsideClick: false
        });
        return false;
    });
</script>