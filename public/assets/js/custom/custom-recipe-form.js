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