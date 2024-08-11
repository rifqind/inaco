/*
---------------------------------------
    : Custom - Table Datatable js :
---------------------------------------
*/
"use strict";
$(document).ready(function () {
    /* -- Table - Datatable -- */
    /*   $('#datatable').DataTable({
        responsive: true
    });
    $('#default-datatable').DataTable( {
        "order": [[ 3, "desc" ]],
        responsive: true
    } );    */
    var table = $("#datatable-products").DataTable({
        lengthChange: false,
        responsive: false,
        searching: true,
        /*      products: ['copy', 'csv', 'excel', 'pdf', 'print'] 
        products: ['excel', 'pdf', 'print'] */
    });
    //  table.products().container().appendTo('#datatable-products_wrapper .col-md-6:eq(0)');
    $(
        "#datatable-products_wrapper > .row:first-child > .col-sm-12:first-child"
    ).append($("#filter-wrapper"));
    // $("#datatable-products_filter label").append($("#addButton"));
    var categoryIndex = 0;
    $("#datatable-products th").each(function (i) {
        if ($($(this)).html() == "Category") {
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
                        url: "/products/destroy/" + id,
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
