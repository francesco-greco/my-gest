<div id="window_select_date" class="ch_overlay_window" style="width: 310px;">
	<form method="post" action="<?php echo $submit_url ?>">
      <h5><?php echo lang($title_dictionary_term) ?></h5>
      <hr>
      <div class="row">
         <div class='large-12 columns'><?php echo lang(isset($message_dictionar_term) ? $message_dictionar_term : 'common_words_insert_date_label') ?></div>
      </div>
      <div class="row" style="margin-top: 10px;">
         <div class='large-12 columns'>
            <input class="selected_date text-center" type="text" name="selected_date" readonly required>
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
      $('.selected_date', '#window_select_date').datepicker({ changeYear: true, changeMonth: true });
   </script>
</div>