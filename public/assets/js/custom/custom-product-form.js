/*
--------------------------------
    : Custom - Validate js :
--------------------------------
*/
"use strict";
jQuery(".form-validate").validate({
    ignore: [],
    errorClass: "invalid-feedback animated fadeInDown",
    errorElement: "div",
    errorPlacement: function(e, a) {
        jQuery(a).parents(".form-group > div").append(e);
    },
    highlight: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid");
        if ($(e).hasClass("select2-hidden-accessible")) {
            $(e).next().find(".select2-selection").addClass("is-invalid");
        }
    },
    unhighlight: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid");
        if ($(e).hasClass("select2-hidden-accessible")) {
            $(e).next().find(".select2-selection").removeClass("is-invalid");
        }
    },
    success: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove();
    },
    rules: {
        "product_category": {
            required: true
        },
        "pages_title": {
            required: true
        },
        "content_desc": {
            required: true
        },
        "language": {
            required: true
        },
        "pages_image": {
            required: true
        },
        "page_status": {
            required: true
        },
        "shopee": {
            required: true
        },
        "tiktok": {
            required: true
        },
        "tokopedia": {
            required: true
        },
        "lazada": {
            required: true
        },
        "display_sequence": {
            required: true
        }
    },
    messages: {
        "product_category": {
            required: "Please select a category"
        },
        "pages_title": {
            required: "Please enter product name"
        },
        "content_desc": {
            required: "Please enter the content"
        },
        "language": {
            required: "Please select a language"
        },
        "pages_image": {
            required: "Please select an image"
        },
        "page_status": {
            required: "Please select the page status"
        },
        "shopee": {
            required: "Please enter shopee url"
        },
        "tiktok": {
            required: "Please enter tiktok url"
        },
        "tokopedia": {
            required: "Please enter tokopedia url"
        },
        "lazada": {
            required: "Please enter lazada url"
        },
        "display_sequence": {
            required: "Please select the display sequence"
        }
    },
    submitHandler: function(form) {
        swal({
            title: 'Save Successfully.',
            text: 'Continue to input other language?',
            type: 'success',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            confirmButtonText: 'Yes Continue',
            cancelButtonClass: 'btn btn-danger m-l-10',
            cancelButtonText: 'No'
        }).then(function () {
            window.location.href = 'create_product.php'; // Ganti dengan URL tujuan Anda
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                window.location.href = 'list_product.php'; // Ganti dengan URL tujuan Anda
            }
        })
    }
});


let imageCounter = 1;
$('#addImage').click(function() {
    if (imageCounter < 4) {
        imageCounter++;
        const newImageInput = `
            <div class="input-group mb-3 align-items-center" id="imageInput${imageCounter}">
                <input type="file" class="form-control-file w-auto" name="pages_image">
                <div class="">
                    <button class="btn btn-danger removeImage btn-round h2" type="button">-</button>
                </div>
            </div>`;
        $('#imageContainer').append(newImageInput);
    }
});

$('#imageContainer').on('click', '.removeImage', function() {
    $(this).closest('.input-group').remove();
    imageCounter--;
});

