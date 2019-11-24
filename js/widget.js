var Widget_file_import =(function($, window, document, undefined){
   
   function show(brand_code, type){
      CH_Tools.load_overlay_window(CH_URL.file_import + "/show_widget_file_import/" + brand_code + "/" + type, '#widget_file_import_window', function (id_window) {
         
         var $progress = $(id_window + ' .meter');
         var timer;
         
         $(id_window + ' .btn-start-upload').on('click', function(){
            $(id_window + ' form').submit();
            progress_increment();
         });
         
         $form = new CH_smartForm($('form', id_window), {
            success: function (response) {
               if (response.response == CH_RESULT.SUCCESS) {
                  progress_stopping();
                  CH_Tools.show_message(response.message, 'info');
               } else {
                  CH_Tools.show_message(response.message, 'error');
               }
            },
            error: function (err) {
               console.log(err);
            }
         });
         
         function progress_increment() {
            var count = 1;
            timer = setInterval(function () {
               $progress.css('width', count + '%');
               count++;
               if(count === 100){
                  count = 1;
                  $progress.css('width', '0%');
               }
            }, 500);
            sleep(100);
         }
         
         function progress_stopping(){
            clearInterval(timer);
            $progress.css('width', '0%');
         }
      });
   }
   
   function sleep(milliseconds) {
      var start = new Date().getTime();
      for (var i = 0; i < 1e7; i++) {
         if ((new Date().getTime() - start) > milliseconds) {
            break;
         }
      }
   }
   
   return {
      show: show
   };
   
})(jQuery, window, document);

