/*
---------------------------------------
    : Custom - Table Datatable js :
---------------------------------------
*/
"use strict";
$(document).ready(function() {
    /* -- Table - Datatable -- */
 /*   $('#datatable').DataTable({
        responsive: true
    });
    $('#default-datatable').DataTable( {
        "order": [[ 3, "desc" ]],
        responsive: true
    } );    */
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        responsive: false,
        searching: true
  /*      buttons: ['copy', 'csv', 'excel', 'pdf', 'print'] 
        buttons: ['excel', 'pdf', 'print'] */
    });
  //  table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
  $("#datatable-buttons_wrapper > .row:first-child > .col-sm-12:first-child").append($("#filter-wrapper"));
  // $("#datatable-buttons_filter label").append($("#addButton"));
  var categoryIndex = 0;
      $("#datatable-buttons th").each(function (i) {
        if ($($(this)).html() == "Category") {
          categoryIndex = i; return false;
        }
      });

  $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var selectedItem = $('#categoryFilter').val()
          var category = data[categoryIndex];
          if (selectedItem === "" || category.includes(selectedItem)) {
            return true;
          }
          return false;
        }
      );

   $("#categoryFilter").change(function (e) {
        table.draw();
      });

      table.draw();    

});