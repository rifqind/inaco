/*
------------------------------------
    : Custom - Form Editors js :
------------------------------------
*/
"use strict";
var path = window.location.pathname;
$(document).ready(function () {
    /* -- Form Editors - Tinymce -- */
    if ($("#tinymce-example").length > 0) {
        tinymce.init({
            selector: "textarea#tinymce-example",
            theme: "modern",
            height: 320,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor",
            ],
            toolbar:
                "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [
                { title: "Bold text", inline: "b" },
                {
                    title: "Red text",
                    inline: "span",
                    styles: { color: "#ff0000" },
                },
                {
                    title: "Red header",
                    block: "h1",
                    styles: { color: "#ff0000" },
                },
                { title: "Example 1", inline: "span", classes: "example1" },
                { title: "Example 2", inline: "span", classes: "example2" },
                { title: "Table styles" },
                { title: "Table row 1", selector: "tr", classes: "tablerow1" },
            ],
        });
    }
    /* -- Form Editors - Summernote -- */
    $(".summernote").summernote({
        height: 250,
        width: 600,
        minHeight: null,
        maxHeight: null,
        focus: true,
        toolbar: [
            // [groupName, [list of button]]
            ["style", ["bold", "italic", "underline", "clear"]],
            //  ['font', ['strikethrough', 'superscript', 'subscript']],
            //  ['fontsize', ['fontsize']],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            //  ['table', ['table']],
            //  ['insert', ['link', 'picture', 'video']],
            //  ['view', ['fullscreen', 'codeview', 'help']]
        ],
    });

    document.getElementById("back").addEventListener("click", () => {
        window.location.href = "/recipes";
    });
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
        product_id: {
            required: true,
        },
        recipe_title: {
            required: true,
        },
        recipe_description: {
            required: true,
        },
        language_code: {
            required: true,
        },
        recipe_image: {
            required: true,
        },
        recipe_status: {
            required: true,
        },
    },
    messages: {
        product_id: {
            required: "Please select a product",
        },
        recipe_title: {
            required: "Please enter product name",
        },
        recipe_description: {
            required: "Please enter the content",
        },
        language_code: {
            required: "Please select a language",
        },
        recipe_image: {
            required: "Please select an image",
        },
        recipe_status: {
            required: "Please select the page status",
        },
    },
    submitHandler: function () {
        event.preventDefault();
        const form = document.getElementById("create-recipe");
        let formData = new FormData(form);
        jQuery.ajax({
            url:
                path == "/recipes/create"
                    ? "/recipes/store"
                    : "/recipes/update",
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
                            path == "/recipes/create"
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
                            path == "/recipes/create"
                                ? (window.location.href =
                                      "/recipes/create?recipe_id=" +
                                      data.id +
                                      "&language_code=" +
                                      data.code)
                                : window.location.reload(); // Ganti dengan URL tujuan Anda
                        }
                        if (value.isDismissed) {
                            window.location.href = "/recipes"; // Ganti dengan URL tujuan Anda
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
