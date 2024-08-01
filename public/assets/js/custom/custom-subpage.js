/*
--------------------------------
    : Custom - Validate js :
--------------------------------
*/
"use strict";
var path = window.location.pathname;
$(document).ready(function () {
    // Initialize Select2
    $("#val-page").select2();

    // jQuery Validation Plugin

    // Revalidate select2 on change
    $("#val-page").on("change", function () {
        $(this).valid();
    });
});
$("#create-subpage").validate({
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
        pages: {
            required: true,
        },
        sub_pages_title: {
            required: true,
        },
        sub_pages_description: {
            required: true,
        },
        language_code: {
            required: true,
        },
        sub_pages_image: {
            required: true,
        },
        sub_page_status: {
            required: true,
        },
    },
    messages: {
        pages: {
            required: "Please select the page",
        },
        sub_pages_title: {
            required: "Please enter the title",
        },
        sub_pages_description: {
            required: "Please enter the content",
        },
        language_code: {
            required: "Please select a language",
        },
        sub_pages_image: {
            required: "Please select an image",
        },
        sub_pages_status: {
            required: "Please select the page status",
        },
    },
    submitHandler: function () {
        event.preventDefault();
        const form = document.getElementById("create-subpage");
        let formData = new FormData(form);
        jQuery.ajax({
            url:
                path == "/subpages/create"
                    ? "/subpages/store"
                    : "/subpages/update",
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
                        text: "Continue to input another page?",
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
                            path == "/subpages/create"
                                ? (window.location.href = "/subpages/create")
                                : window.location.reload(); // Ganti dengan URL tujuan Anda
                        }
                        if (value.isDismissed) {
                            window.location.href = "/subpages"; // Ganti dengan URL tujuan Anda
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

if (path == "/subpages") {
    jQuery(document).ready(() => {
        jQuery("#datatable-subpages").DataTable({
            responsive: true,
            columns: [
                { width: "5%" },
                { width: "5%" },
                { width: "30%" },
                { width: "5%" },
                { width: "5%" },
            ],
        });
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
                            url: "/subpages/destroy/" + id,
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
} else {
    document.getElementById("back").addEventListener("click", (e) => {
        window.location.href = "/subpages";
    });
}
