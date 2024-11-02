/*
------------------------------------
    : Custom - Form Editors js :
------------------------------------
*/
"use strict";
var path = window.location.pathname;
$(document).ready(function () {
    let imageCounter = 1;
    $("#addImage").click(function () {
        if (imageCounter < 4) {
            imageCounter++;
            const newImageInput = `
            <div class="input-group mb-3 align-items-center" id="imageInput${imageCounter}">
                <input type="file" class="form-control-file w-auto" name="product_image[]">
                <div class="">
                    <button class="btn btn-danger removeImage btn-round h2" type="button">-</button>
                </div>
            </div>`;
            $("#imageContainer").append(newImageInput);
        }
    });
    $("#addImage-update").click(function () {
        if (imageCounter < 4) {
            imageCounter++;
            const newImageInput = `
            <div class="input-group mb-3 align-items-center" id="imageInput${imageCounter}">
                <input type="file" class="form-control-file w-auto" name="product_image_update[]">
                <div class="">
                    <button class="btn btn-danger removeImage btn-round h2" type="button">-</button>
                </div>
            </div>`;
            $("#imageContainer").append(newImageInput);
        }
    });

    $("#imageContainer").on("click", ".removeImage", function () {
        $(this).closest(".input-group").remove();
        imageCounter--;
    });
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
        window.location.href = "/webappcms/recipes";
    });

    const radioYt = document.getElementById('recipe_yt_confirm1')
    if (radioYt.checked) {
        document.getElementById('youtube-link-input').classList.remove('d-none')
    } 
    radioYt.addEventListener('click', () => {
        document.getElementById('youtube-link-input').classList.remove('d-none')
    })
    document.getElementById('recipe_yt_confirm2').addEventListener('click', () => {
        document.getElementById('youtube-link-input').classList.add('d-none')
        let input = document.getElementById('recipe_yt')
        input.value = null
    })

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
                path == "/webappcms/recipes/create"
                    ? "/webappcms/recipes/store"
                    : "/webappcms/recipes/update",
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
                            path == "/webappcms/recipes/create"
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
                            path == "/webappcms/recipes/create"
                                ? (window.location.href =
                                    "/webappcms/recipes/create?recipe_id=" +
                                    data.id +
                                    "&language_code=" +
                                    data.code)
                                : window.location.reload(); // Ganti dengan URL tujuan Anda
                        }
                        if (value.isDismissed) {
                            window.location.href = "/webappcms/recipes"; // Ganti dengan URL tujuan Anda
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
