(function ($, window, document, undefined) {

   var File_import_page = (function () {

      var CANVAS_ID = '#main_file_import_page';
      
      function init() {
         init_button();
      }
      
      function init_button(){
         $('.btn-load-file', CANVAS_ID).on('click', function(){
            var type = $(this).data('type');
            var brand_code = $(this).data('brand');
            Widget_file_import.show(brand_code, type);
         });
      }

      return {
         init: init
      };
   })();

   $(function () {
      switch (page) {
         case 'load_file_main':
            File_import_page.init();
            break;
      }
   });

})(jQuery, window, document);