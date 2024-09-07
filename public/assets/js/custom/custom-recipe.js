/*
------------------------------------
    : Custom - Form Editors js :
------------------------------------
*/
"use strict";
$(document).ready(function () {
    /* -- Form Editors - Tinymce -- */

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
                        url: "/webappcms/recipes/destroy/" + id,
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

    var table = $("#datatable-recipe").DataTable({
        lengthChange: false,
        responsive: true,
        searching: true,
        /*      buttons: ['copy', 'csv', 'excel', 'pdf', 'print'] 
        buttons: ['excel', 'pdf', 'print'] */
    });
    //  table.buttons().container().appendTo('#datatable-recipe_wrapper .col-md-6:eq(0)');
    $(
        "#datatable-recipe_wrapper > .row:first-child > .col-sm-12:first-child"
    ).append($("#filter-wrapper"));
    // $("#datatable-recipe_filter label").append($("#addButton"));
    var categoryIndex = 0;
    $("#datatable-recipe th").each(function (i) {
        if ($($(this)).html() == "Product") {
            categoryIndex = i;
            return false;
        }
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        var selectedItem = $("#categoryFilter").val();
        var category = data[categoryIndex];
        if (selectedItem === "" || category.includes(selectedItem)) {
            return true;
        }
        return false;
    });

    $("#categoryFilter").change(function (e) {
        table.draw();
    });

    table.draw();
});
