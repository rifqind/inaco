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
        "page": {
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
        }
    },
    messages: {
        "page": {
            required: "Please select the page"
        },
        "pages_title": {
            required: "Please enter the title"
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
            window.location.href = 'create_page.php'; // Ganti dengan URL tujuan Anda
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                window.location.href = 'list_page.php'; // Ganti dengan URL tujuan Anda
            }
        })
    }
});



// Revalidate select2 on change
$('#val-page').on('change', function() {
    $(this).valid();
});