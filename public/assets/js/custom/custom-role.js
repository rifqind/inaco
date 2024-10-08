var path = window.location.pathname;
if (path == "/webappcms/roles") {
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
                            url: "/webappcms/role/destroy/" + id,
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
        jQuery("#datatable-role")
            .DataTable({
                responsive: true,
                columns: [
                    { width: "15%" },
                    { width: "15%" },
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
        jQuery("#create-role").validate({
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
                role_name: {
                    required: true,
                },
                permission_id: {
                    required: true,
                },
            },
            messages: {
                role_name: {
                    required: "Please enter role name",
                },
                permission_id: {
                    required: "Please select permission name",
                },
            },
            submitHandler: function () {
                event.preventDefault();
                const form = document.getElementById("create-role");
                let formData = new FormData(form);
                jQuery.ajax({
                    url:
                        path == "/webappcms/role/create"
                            ? "/webappcms/role/create"
                            : "/webappcms/role/update",
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
                                text: "Continue to add new role?",
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
                                    window.location.href = "/webappcms/roles"; // Ganti dengan URL tujuan Anda
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
            window.location.href = "/webappcms/roles";
        });
    });
}
