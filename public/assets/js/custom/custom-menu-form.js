/*
--------------------------------
    : Custom - Validate js :
--------------------------------
*/
"use strict";
jQuery("#back").on("click", () => {
    window.location.href = "/menu";
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
        parent: {
            required: true,
        },
        pages_title: {
            required: true,
        },
        category: {
            required: true,
        },
        urlwebsite: {
            required: true,
        },
        urlcms: {
            required: true,
        },
        iconcms: {
            required: true,
        },
        language: {
            required: true,
        },
        display_sequence: {
            required: true,
        },
    },
    messages: {
        parent: {
            required: "Please select the parent",
        },
        pages_title: {
            required: "Please enter the title",
        },
        category: {
            required: "Please select the category",
        },
        urlwebsite: {
            required: "Please enter url website",
        },
        urlcms: {
            required: "Please enter url cms",
        },
        iconcms: {
            required: "Please enter icon cms",
        },
        language: {
            required: "Please select a language",
        },
        display_sequence: {
            required: "Please select a display sequence",
        },
    },
    submitHandler: function (form) {
        if (window.location.pathname == "/menu/create") {
            jQuery.ajax({
                url: "/menu/store",
                type: "POST",
                data: jQuery(".form-validate").serialize(),
                success: (data) => {
                    if (data.message) {
                        Swal.fire({
                            title: "Save Successfully.",
                            text: "Continue to input other language?",
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
                                window.location.href = "/menu/create"; // Ganti dengan URL tujuan Anda
                            }
                            if (value.isDismissed) {
                                window.location.href = "/menu"; // Ganti dengan URL tujuan Anda
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
        } else {
            jQuery.ajax({
                url: "/menu/update",
                type: "POST",
                data: jQuery(".form-validate").serialize(),
                success: (data) => {
                    if (data.message) {
                        Swal.fire({
                            title: "Save Successfully.",
                            text: "Continue Edit?",
                            icon: "success",

                            showCancelButton: true,
                            showConfirmButton: true,
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-info m-l-10",
                            },
                            confirmButtonText: "Yes Continue",
                            cancelButtonText: "Back to Menu Navigation List",
                        }).then((value) => {
                            if (value.isConfirmed) {
                                window.location.reload(); // Ganti dengan URL tujuan Anda
                            }
                            if (value.isDismissed) {
                                window.location.href = "/menu"; // Ganti dengan URL tujuan Anda
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
        }
    },
});
if (window.location.pathname == "/menu") {
    jQuery(document).ready(() => {
        // jQuery("#datatable-menu").on("click", ".delete-row", function (e) {
        // e.preventDefault();
        // var row = jQuery(this).closest("tr");
        // var id = jQuery(this).data("id");
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
                            url: "/menu/destroy/" + id,
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
    });
}
