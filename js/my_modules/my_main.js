(function ($, window, document, undefined) {
   var
           CANVAS_ID = '#main_menu';


   var Main_page = (function () {
      
      function init() {
            init_button_menu();
        }
        
      function init_button_menu(){
         $(CANVAS_ID + ' .new_ddt').on('click', function(){
            Ddt_page.new_ddt_show();
         });
      }
      
      return {
         init: init
      };

   })();
   
   $(function () {
        switch (page) {
            case 'main':
                Main_page.init();
                break;
        }
    });

})(jQuery, window, document);

