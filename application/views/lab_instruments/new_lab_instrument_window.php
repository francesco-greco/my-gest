<div id="new_lab_instrument_window" class="ch_overlay_window">
	<form method="post" action="<?php print_url(CH_URL_LAB_INSTRUMENTS.'/add_lab_instrument') ?>">
      <input type="hidden" name="lab_instrument_id_lab" value="<?php echo $id_lab ?>">
      <h5><?php echo lang('instruments_instrument_add_label') ?></h5>
      <hr>
      <div class="row">
         <div class='large-6 columns'>
            <label for=""><?php echo lang('common_words_name') ?></label>
            <input class="lab_instrument_name" name="lab_instrument_name" type="text" required>
         </div>
      </div>
      <div class="row">
         <div class='large-12 columns'>
            <label for=""><?php echo lang('common_words_description') ?></label>
            <textarea name="lab_instrument_description"></textarea>
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
</div>