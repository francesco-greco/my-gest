<div id="send_activation_code_window" class="ch_overlay_window">
	<form method="post" action="">
      <h5><?php echo lang('client_send_activation_code_label') ?></h5>
      <hr>
      <ul class="large-block-grid-1">
         <li><?php echo lang('client_send_activation_code_alert', $client->fullname) ?>:</li>
         <li class="text-center"><strong><?php echo $client->email ?></strong></li>
         <li><?php echo lang('common_words_proceed') ?> ?</li>
      </ul>
		<hr>
		<div class="row">
			<div class="large-8 columns campo-errore"></div>
			<div class="columns text-right ch_button_pane">
            <button type="button" title="<?php echo lang('common_words_send') ?>" class="btn-send button"><i class="fa fa-lg fa-check"></i></button>
			</div>
		</div>
	</form>
</div>