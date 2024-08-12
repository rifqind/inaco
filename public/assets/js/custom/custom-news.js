/*
---------------------------------------
    : Custom - Table Datatable js :
---------------------------------------
*/
"use strict";
var path = window.location.pathname;

jQuery("#create-news").validate({
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
        news_category: {
            required: true,
        },
        news_title: {
            required: true,
        },
        news_description: {
            required: true,
        },
        language_code: {
            required: true,
        },
        news_image: {
            required: true,
        },
        create_date: {
            required: true,
        },
        news_status: {
            required: true,
        },
    },
    messages: {
        news_category: {
            required: "Please select the category",
        },
        news_title: {
            required: "Please enter the title",
        },
        news_description: {
            required: "Please enter the content",
        },
        language_code: {
            required: "Please select a language",
        },
        news_image: {
            required: "Please select an image",
        },
        create_date: {
            required: "Please select a date",
        },
        news_status: {
            required: "Please select the news status",
        },
    },
    submitHandler: () => {
        event.preventDefault();
        const form = document.getElementById("create-news");
        let formData = new FormData(form);
        jQuery.ajax({
            url: path == "/webappcms/news/create" ? "/webappcms/news/store" : "/webappcms/news/update",
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
                            path == "/webappcms/news/create"
                                ? "Continue to input another language?"
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
                            path == "/webappcms/news/create"
                                ? (window.location.href =
                                      "/webappcms/news/create?news_id=" +
                                      data.id +
                                      "&language_code=" +
                                      data.code)
                                : window.location.reload(); // Ganti dengan URL tujuan Anda
                        }
                        if (value.isDismissed) {
                            window.location.href =
                                "/webappcms/news?news_category=" + data.category; // Ganti dengan URL tujuan Anda
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
if (path == "/webappcms/news") {
    document.addEventListener("DOMContentLoaded", () => {
        jQuery("#datatable-news")
            .DataTable({
                responsive: false,
                columns: [
                    { width: "5%" },
                    { width: "7%" },
                    { width: "5%" },
                    { width: "25%" },
                    { width: "5%" },
                    { width: "5%" },
                ],
            })
            .buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
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
                            url: "/webappcms/news/destroy/" + id,
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
    document.getElementById("back").addEventListener("click", () => {
        const params = new URLSearchParams(window.location.search);
        const category = params.get("news_category");

        window.location.href = "/webappcms/news?news_category=" + category;
    });
}
