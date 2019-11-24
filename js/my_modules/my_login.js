(function($) {
   $('form', '.ch_canvas').ajaxForm({
      beforeSubmit: function (arr, $form){
         return $form.valid();
      },
      success: function(data) {
         if(data.result == CH_RESULT.SUCCESS) {
            window.location = base_url + CH_URL.main;
         }
         else {
            $('#recaptcha_response_field').val('');
//            Recaptcha.reload();
            alert(data.message);
         }
      },
      error: function() {
         $('#recaptcha_response_field').val('');
         Recaptcha.reload();
         alert('Si è vericato un errore sul server. Ritentare successivamente.');
      },
      dataType:'json'
   })
   .validate();
})(jQuery);