/*
------------------------------------
    : Custom - Form Editors js :
------------------------------------
*/
"use strict";
$(document).ready(function() {
    /* -- Form Editors - Tinymce -- */
    if($("#tinymce-example").length > 0) {
        tinymce.init({
            selector: "textarea#tinymce-example",
            theme: "modern",
            height:320,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ]
        });
    }
 

       var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        responsive: true,
        searching: true
  /*      buttons: ['copy', 'csv', 'excel', 'pdf', 'print'] 
        buttons: ['excel', 'pdf', 'print'] */
    });
  //  table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
  $("#datatable-buttons_wrapper > .row:first-child > .col-sm-12:first-child").append($("#filter-wrapper"));
  // $("#datatable-buttons_filter label").append($("#addButton"));
  var categoryIndex = 0;
      $("#datatable-buttons th").each(function (i) {
        if ($($(this)).html() == "Produk") {
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

   /* -- Form Editors - Summernote -- */
   $('.summernote').summernote({
    height: 250,
    width: 600,
    minHeight: null,
    maxHeight: null,
    focus: true,
    toolbar: [
// [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
  //  ['font', ['strikethrough', 'superscript', 'subscript']],
  //  ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
  //  ['table', ['table']],
  //  ['insert', ['link', 'picture', 'video']],
  //  ['view', ['fullscreen', 'codeview', 'help']]
  ] 
});

});