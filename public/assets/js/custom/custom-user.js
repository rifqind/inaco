var path = window.location.pathname;
if (path == "/webappcms/user") {
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".table .delete-row").forEach((button) => {
            button.addEventListener("click", (e) => {
                const button = e.target.closest(".delete-row");
                const row = e.target.closest("tr");
                const id = button.dataset.id;

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    showConfirmButton: true,
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger m-l-10",
                    },
                    confirmButtonText: "Yes, delete it!",
                }).then((value) => {
                    if (value.isConfirmed) {
                        jQuery.ajax({
                            url: "/webappcms/user/destroy/" + id,
                            type: "DELETE",
                            data: {
                                _token: jQuery('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                            success: function (data) {
                                if (data.message) {
                                    row.remove();
                                    Swal.fire(
                                        "Deleted!",
                                        "Your data has been deleted.",
                                        "success"
                                    );
                                } else if (data.error) {
                                    Swal.fire(
                                        "Error!",
                                        "There was a problem deleting your data.",
                                        "error"
                                    );
                                }
                            },
                            error: function () {
                                Swal.fire(
                                    "Error!",
                                    "There was a problem with the server.",
                                    "error"
                                );
                            },
                        });
                    }
                });
            });
        });
        jQuery("#datatable-user")
            .DataTable({
                responsive: true,
                columns: [
                    { width: "15%" },
                    { width: "15%" },
                    { width: "10%" },
                    { width: "10%" },
                    { width: "5%" },
                ],
            })
            .buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
    });
} else {
    document.addEventListener("DOMContentLoaded", () => {
        jQuery("#create-user").validate({
            ignore: [],
            errorClass: "invalid-feedback animated fadeInDown",
            errorElement: "div",
            errorPlacement: function (e, a) {
                jQuery(a).parents(".form-group > div").append(e);
            },
            highlight: function (e) {
                jQuery(e)
                    .closest(".form-group")
                    .removeClass("is-invalid")
                    .addClass("is-invalid");
                if ($(e).hasClass("select2-hidden-accessible")) {
                    $(e)
                        .next()
                        .find(".select2-selection")
                        .addClass("is-invalid");
                }
            },
            unhighlight: function (e) {
                jQuery(e).closest(".form-group").removeClass("is-invalid");
                if ($(e).hasClass("select2-hidden-accessible")) {
                    $(e)
                        .next()
                        .find(".select2-selection")
                        .removeClass("is-invalid");
                }
            },
            success: function (e) {
                jQuery(e).closest(".form-group").removeClass("is-invalid"),
                    jQuery(e).remove();
            },
            rules: {
                email: {
                    required: true,
                },
                name: {
                    required: true,
                },
                // password: {
                //     required: true,
                // },
                role_id: {
                    required: true,
                },
                user_status: {
                    required: true,
                },
            },
            messages: {
                email: {
                    required: "Please enter email",
                },
                name: {
                    required: "Please enter name",
                },
                password: {
                    required: "Please enter password",
                },
                role_id: {
                    required: "Please select role",
                },
                user_status: {
                    required: "Please select status",
                },
            },
            submitHandler: function () {
                event.preventDefault();
                const form = document.getElementById("create-user");
                let formData = new FormData(form);
                jQuery.ajax({
                    url:
                        path == "/webappcms/user/create"
                            ? "/webappcms/user/create"
                            : "/webappcms/user/update",
                    type: "POST",
                    data: formData,
                    headers: {
                        "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    processData: false,
                    contentType: false,
                    success: (data) => {
                        if (data.message) {
                            Swal.fire({
                                title: "Save Successfully.",
                                text: "Continue to add new user?",
                                icon: "success",

                                showCancelButton: true,
                                showConfirmButton: true,
                                customClass: {
                                    confirmButton: "btn btn-success",
                                    cancelButton: "btn btn-danger m-l-10",
                                },
                                confirmButtonText: "Yes Continue",
                                cancelButtonText: "No",
                            }).then((value) => {
                                // if (value.isDenied) {
                                //     window.location.href = "/social-media"; // Ganti dengan URL tujuan Anda
                                // }
                                if (value.isConfirmed) {
                                    window.location.reload(); // Ganti dengan URL tujuan Anda
                                }
                                if (value.isDismissed) {
                                    window.location.href = "/webappcms/user"; // Ganti dengan URL tujuan Anda
                                }
                            });
                        } else if (data.error) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: data.error,
                            });
                        }
                    },
                    error: (data) => {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: data,
                        });
                    },
                });
            },
        });
        document.getElementById("back").addEventListener("click", () => {
            window.location.href = "/webappcms/user";
        });
    });
}
