/*
--------------------------------
    : Custom - Validate js :
--------------------------------
*/
"use strict";

var path = window.location.pathname;
var temporaryImages = [];
jQuery("#create-page").validate({
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
        page: {
            required: true,
        },
        pages_title: {
            required: true,
        },
        pages_description: {
            required: true,
        },
        language_code: {
            required: true,
        },
        pages_image: {
            required: true,
        },
        pages_status: {
            required: true,
        },
    },
    messages: {
        page: {
            required: "Please select the page",
        },
        pages_title: {
            required: "Please enter the title",
        },
        pages_description: {
            required: "Please enter the content",
        },
        language_code: {
            required: "Please select a language",
        },
        pages_image: {
            required: "Please select an image",
        },
        pages_status: {
            required: "Please select the page status",
        },
    },
    submitHandler: function () {
        event.preventDefault();
        const form = document.getElementById("create-page");
        let formData = new FormData(form);
        if (temporaryImages.length > 0) {
            temporaryImages.forEach((path, index) => {
                formData.append(`summernoteImg[${index}]`, path)
            })
        }
        jQuery.ajax({
            url: path == "/webappcms/pages/create" ? "/webappcms/pages/store" : "/webappcms/pages/update",
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
                            path == "/webappcms/pages/create"
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
                            path == "/webappcms/pages/create"
                                ? (window.location.href =
                                    "/webappcms/pages/create?pages_id=" +
                                    data.id +
                                    "&language_code=" +
                                    data.code)
                                : window.location.reload(); // Ganti dengan URL tujuan Anda
                        }
                        if (value.isDismissed) {
                            window.location.href = "/webappcms/pages"; // Ganti dengan URL tujuan Anda
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

// Revalidate select2 on change
$("#val-page").on("change", function () {
    $(this).valid();
});

if (path == "/webappcms/pages") {
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
                            url: "/webappcms/pages/destroy/" + id,
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
        jQuery("#datatable-pages")
            .DataTable({
                responsive: false,
                columns: [
                    { width: "5%" },
                    { width: "30%" },
                    { width: "5%" },
                    { width: "5%" },
                ],
            })
            .buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
    });
} else {
    document.getElementById("back").addEventListener("click", () => {
        window.location.href = "/webappcms/pages";
    });
}

document.addEventListener('DOMContentLoaded', () => {
    summerNoteInit()
})
const summerNoteInit = () => {
    $('#summernote').summernote({
        height: 320,
        width: 600,
        minHeight: null,
        maxHeight: null,
        focus: true,
        imageAttributes: {
            icon: '<i class="note-icon-pencil"/>',
            removeEmpty: false, // true = remove attributes | false = leave empty if present
            disableUpload: false // true = don't display Upload Options | Display Upload Options
        },
        popover: {
            image: [
                ['custom', ['imageAttributes']],
                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
        },
        grid: {
            wrapper: "row",
            columns: [
                "col-md-12",
                "col-md-6",
                "col-md-4",
                "col-md-3",
                "col-md-24",
            ]
        },
        icons: {
            grid: "bi bi-grid-3x2"
        },
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            //  ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onImageUpload: function (image) {
                sendFile(image[0]);
            },
            onMediaDelete: function (target) {
                deleteFile(target[0].src);
            }
        },
    });
}
const sendFile = (file, editor, welEditable) => {
    const _token = jQuery('meta[name="csrf-token"]').attr(
        "content"
    )
    let data = new FormData()
    data.append("file", file)
    data.append("_token", _token)
    $('#loading-image-summernote').show();
    $('#summernote').summernote('disable');

    $.ajax({
        data: data,
        type: "POST",
        url: "/upload-image-summernote",
        cache: false,
        contentType: false,
        processData: false,
        success: function (url) {
            // console.log(url);
            if (url['status'] == "success") {
                $('#summernote').summernote('enable');
                $('#loading-image-summernote').hide();
                $('#summernote').summernote('editor.saveRange');
                $('#summernote').summernote('editor.restoreRange');
                $('#summernote').summernote('editor.focus');
                $('#summernote').summernote('editor.insertImage', url['image_url']);
                temporaryImages.push(url['image_url']);
            }
            $("img").addClass("img-fluid");
        },
        error: function (data) {
            // console.log(data)
            $('#summernote').summernote('enable');
            $('#loading-image-summernote').hide();
        }
    });
}
const deleteFile = (target) => {
    const _token = jQuery('meta[name="csrf-token"]').attr(
        "content"
    )
    let data = new FormData();
    data.append("target", target);
    data.append('_token', _token);
    $('#loading-image-summernote').show();
    $('.summernote').summernote('disable');
    $.ajax({
        data: data,
        type: "POST",
        url: "/delete-image-summernote",
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            // console.log(result)
            if (result['status'] == "success") {
                $('.summernote').summernote('enable');
                $('#loading-image-summernote').hide();
            }
        },
        error: function (data) {
            // console.log(data)
            $('.summernote').summernote('enable');
            $('#loading-image-summernote').hide();
        }
    });
}
