<div id="window_select_date_range" class="ch_overlay_window" style="width: 400px;">
	<form method="post" action="<?php echo $submit_url ?>">
      <h5><?php echo lang($title_dictionary_term) ?></h5>
      <hr>
      <div class="row">
         <div class='large-6 columns'>
            <label for=""><?php echo lang('common_words_start_label') ?></label>
            <input class="start_date text-center" type="text" name="start_date" readonly>
         </div>
         <div class='large-6 columns'>
            <label for=""><?php echo lang('common_words_end_label') ?></label>
            <input class="end_date text-center" type="text" name="end_date" readonly>
         </div>
      </div>
		<hr>
		<div class="row">
			<div class="large-8 columns campo-errore"></div>
			<div class="columns text-right ch_button_pane">
            <button type="submit" title="<?php echo lang('common_words_send') ?>" class="btn-send button"><i class="fa fa-lg fa-check"></i></button>
			</div>
		</div>
	</form>
   <script>
      var $start_date = $('.start_date', '#window_select_date_range'),
         $end_date= $('.end_date', '#window_select_date_range');

      $start_date.datetimepicker({ 
         changeYear: true, changeMonth: true,
         onClose: function(dateText, inst) {
            if ($end_date.val() != '') {
               var testStartDate = $start_date.datetimepicker('getDate');
               var testEndDate = $end_date.datetimepicker('getDate');
               if (testStartDate > testEndDate)
                  $end_date.datetimepicker('setDate', testStartDate);
            }
         }/*,
         onSelect: function (selectedDateTime){
            var end = $end_date.val();
            $end_date.datetimepicker( "option", "minDateTime", $start_date.datetimepicker('getDate') );
            $end_date.val(end);
         }*/
      });

      $end_date.datetimepicker({ 
         changeYear: true, changeMonth: true,
         onClose: function(dateText, inst) {
            if ($start_date.val() != '') {
               var testStartDate = $start_date.datetimepicker('getDate');
               var testEndDate = $end_date.datetimepicker('getDate');
               if (testStartDate > testEndDate)
                  $start_date.datetimepicker('setDate', testEndDate);
            }
         }/*,
         onSelect: function (selectedDateTime){
            var start = $start_date.val();
            $start_date.datetimepicker( "option", "maxDateTime", $end_date.datetimepicker('getDate'));
            $start_date.val(start);
         }*/
      });
   </script>
</div>