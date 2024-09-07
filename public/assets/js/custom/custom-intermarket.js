var path = window.location.pathname;
if (path == "/webappcms/inter-market") {
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
                        url: "/webappcms/inter-market/destroy/" + id,
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
    document.addEventListener("DOMContentLoaded", () => {
        jQuery("#datatable-intermarket")
            .DataTable({
                responsive: true,
                columns: [{ width: "10%" }, { width: "10%" }, { width: "5%" }],
            })
            .buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
    });
} else {
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("back").addEventListener("click", () => {
            window.location.href = "/webappcms/inter-market";
        });
        jQuery("#create-intermarket").validate({
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
                country: {
                    required: true,
                },
                product_export: {
                    required: true,
                },
            },
            messages: {
                country: {
                    required: "Please select country",
                },
                product_export: {
                    required: "Please select product",
                },
            },
            submitHandler: function () {
                event.preventDefault();
                const form = document.getElementById("create-intermarket");
                let formData = new FormData(form);
                jQuery.ajax({
                    url:
                        path == "/webappcms/inter-market/create"
                            ? "/webappcms/inter-market/store"
                            : "/webappcms/inter-market/update",
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
                                text:
                                    path == "/webappcms/inter-market/create"
                                        ? "Continue to input another market?"
                                        : "Continue to edit?",
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
                                    window.location.href =
                                        "/webappcms/inter-market"; // Ganti dengan URL tujuan Anda
                                }
                            });
                        } else if (data.error) {
                            alert(data.error);
                        }
                    },
                    error: (data) => {
                        alert(data);
                    },
                });
            },
        });
    });
}
