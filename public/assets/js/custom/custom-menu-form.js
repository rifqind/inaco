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
        if (window.location.pathname == '/menu/create') {
            jQuery.ajax({
                url: "/menu/store",
                type: "POST",
                data: jQuery(".form-validate").serialize(),
                success: (data) => {
                    if (data.message) {
                        swal({
                            title: "Save Successfully.",
                            text: "Continue to input other language?",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonClass: "btn btn-success",
                            confirmButtonText: "Yes Continue",
                            cancelButtonClass: "btn btn-danger m-l-10",
                            cancelButtonText: "No",
                        }).then(
                            function () {
                                window.location.href = "/menu/create"; // Ganti dengan URL tujuan Anda
                            },
                            function (dismiss) {
                                if (dismiss === "cancel") {
                                    window.location.href = "/menu"; // Ganti dengan URL tujuan Anda
                                }
                            }
                        );
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
                        swal({
                            title: "Save Successfully.",
                            text: "Continue Edit?",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonClass: "btn btn-success",
                            confirmButtonText: "Yes Continue",
                            cancelButtonClass: "btn btn-info m-l-10",
                            cancelButtonText: "Back to Main Menu",
                        }).then(
                            function () {
                                window.location.reload()  // Ganti dengan URL tujuan Anda
                            },
                            function (dismiss) {
                                if (dismiss === "cancel") {
                                    window.location.href = "/menu"; // Ganti dengan URL tujuan Anda
                                }
                            }
                        );
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
