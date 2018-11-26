<script>
    $(".delete-attachments, .delete-exp, .delete-edu, .delete-cert, .delete-org, .delete-lang, .delete-skill, .delete-vacancy, .delete-data").on('click', function () {
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

    $(".btn_signOut").on("click", function () {
        swal({
            title: 'Sign Out',
            text: "Are you sure to end your session?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fa5555',
            confirmButtonText: 'Yes, sign out now!',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {
                    $("#logout-form").submit();
                });
            },
            allowOutsideClick: false
        });
        return false;
    });

    $(".btn_signOut2").on("click", function () {
        swal({
            title: 'Sign Out',
            text: "Are you sure to end your session?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fa5555',
            confirmButtonText: 'Yes, sign out now!',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {
                    $("#logout-form2").submit();
                });
            },
            allowOutsideClick: false
        });
        return false;
    });
</script>