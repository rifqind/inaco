/*
---------------------------------------
    : Custom - Table Datatable js :
---------------------------------------
*/
"use strict";
$(document).ready(function() {
    /* -- Table - Datatable -- */
    $('#datatable').DataTable({
        responsive: true
    });
    $('#default-datatable').DataTable( {
        "order": [[ 3, "desc" ]],
        responsive: true
    } );    
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        responsive: true,
  /*      buttons: ['copy', 'csv', 'excel', 'pdf', 'print'] 
        buttons: ['excel', 'pdf', 'print'] */
    });
    var table = $('#datatable-menu').DataTable({
        lengthChange: false,
        responsive: false,
  /*      buttons: ['copy', 'csv', 'excel', 'pdf', 'print'] 
        buttons: ['excel', 'pdf', 'print'] */
        columns: [
            { "width": "10%" },
            { "width": "10%" },
            { "width": "10%" },
            { "width": "10%" },
            { "width": "10%" },
            { "width": "6%" }
        ]
    });
    table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
});