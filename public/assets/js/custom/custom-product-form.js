/*
--------------------------------
    : Custom - Validate js :
--------------------------------
*/
"use strict";
var path = window.location.pathname;
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
        category_id: {
            required: true,
        },
        product_title: {
            required: true,
        },
        product_description: {
            required: true,
        },
        language_code: {
            required: true,
        },
        product_image: {
            required: true,
        },
        product_status: {
            required: true,
        },
        product_url_shopee: {
            required: true,
        },
        product_url_tiktok: {
            required: true,
        },
        product_url_tokopedia: {
            required: true,
        },
        proudct_url_lazada: {
            required: true,
        },
        display_sequence: {
            required: true,
        },
    },
    messages: {
        category_id: {
            required: "Please select a category",
        },
        product_title: {
            required: "Please enter product name",
        },
        product_description: {
            required: "Please enter the content",
        },
        language_code: {
            required: "Please select a language",
        },
        product_image: {
            required: "Please select an image",
        },
        product_status: {
            required: "Please select the page status",
        },
        product_url_shopee: {
            required: "Please enter shopee url",
        },
        product_url_tiktok: {
            required: "Please enter tiktok url",
        },
        product_url_tokopedia: {
            required: "Please enter tokopedia url",
        },
        proudct_url_lazada: {
            required: "Please enter lazada url",
        },
        display_sequence: {
            required: "Please select the display sequence",
        },
    },
    submitHandler: function () {
        event.preventDefault();
        const form = document.getElementById("create-products");
        let formData = new FormData(form);
        jQuery.ajax({
            url:
                path == "/webappcms/products/create"
                    ? "/webappcms/products/store"
                    : "/webappcms/products/update",
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
                            path == "/webappcms/products/create"
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
                            path == "/webappcms/products/create"
                                ? (window.location.href =
                                      "/webappcms/products/create?product_id=" +
                                      data.id +
                                      "&language_code=" +
                                      data.code)
                                : window.location.reload(); // Ganti dengan URL tujuan Anda
                        }
                        if (value.isDismissed) {
                            window.location.href = "/webappcms/products"; // Ganti dengan URL tujuan Anda
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

document.getElementById("back").addEventListener("click", () => {
    window.location.href = "/webappcms/products";
});
