"use strict";
var path = window.location.pathname;
jQuery("#back-socmed").on("click", () => {
    window.location.href = "/webappcms/social-media";
});
jQuery("#back-marketplace").on("click", () => {
    window.location.href = "/webappcms/marketplace";
});
jQuery(".form-validate").validate({
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
            $(e).next().find(".select2-selection").addClass("is-invalid");
        }
    },
    unhighlight: function (e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid");
        if ($(e).hasClass("select2-hidden-accessible")) {
            $(e).next().find(".select2-selection").removeClass("is-invalid");
        }
    },
    success: function (e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid"),
            jQuery(e).remove();
    },
    rules: {
        
    },
    messages: {
        
    },
    submitHandler: (form) => {
        event.preventDefault();
        let data = jQuery(".form-validate").serialize();
        data += "&path=" + encodeURIComponent(path);
        jQuery.ajax({
            url:
                path == "/webappcms/socmed-marketplace/create"
                    ? "/webappcms/socmed-marketplace/store"
                    : "/webappcms/socmed-marketplace/update",
            type: "POST",
            data: data,
            success: (data) => {
                if (data.message) {
                    Swal.fire({
                        title: "Save Successfully.",
                        text: "Continue to input other social media and marketplace?",
                        icon: "success",
                        showCancelButton: true,
                        showConfirmButton: true,
                        showDenyButton: true,

                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-info m-l-10",
                            denyButton: "btn btn-info m-l-10",
                        },
                        confirmButtonText: "Yes Continue",
                        cancelButtonText: "Back to Market Place",
                        denyButtonText: "Back to Social Media",
                    }).then(function (value) {
                        if (value.isDenied) {
                            window.location.href = "/webappcms/social-media"; // Ganti dengan URL tujuan Anda
                        }
                        if (value.isConfirmed) {
                            path == "/webappcms/socmed-marketplace/create"
                                ? (window.location.href =
                                      "/webappcms/socmed-marketplace/create")
                                : window.location.reload(); // Ganti dengan URL tujuan Anda
                        }
                        if (value.isDismissed) {
                            window.location.href = "/webappcms/marketplace"; // Ganti dengan URL tujuan Anda
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
if (path == "/webappcms/social-media" || path == "/webappcms/marketplace") {
    jQuery(document).ready(() => {
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
                            url: "/webappcms/socmed-marketplace/destroy/" + id,
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
        jQuery("#datatable-socmed")
            .DataTable({
                responsive: false,
                columns: [
                    { width: "10%" },
                    { width: "10%" },
                    { width: "10%" },
                    { width: "10%" },
                    { width: "10%" },
                    { width: "10%" },
                    { width: "6%" },
                ],
            })
            .buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
        jQuery("#datatable-marketplace")
            .DataTable({
                responsive: false,
                columns: [
                    { width: "10%" },
                    { width: "10%" },
                    { width: "10%" },
                    { width: "10%" },
                    { width: "6%" },
                ],
            })
            .buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
    });
    // jQuery(".table .delete-row").on("click", (e) => {
    //     e.preventDefault();
    //     var row = jQuery(this).closest("tr");
    //     var id = jQuery(this).data("id");
    //     console.log(row.data("id"));

    // });
}
