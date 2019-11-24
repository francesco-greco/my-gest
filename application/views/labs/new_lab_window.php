<div id="new_lab_window" class="ch_overlay_window">
	<form method="post" action="<?php print_url(CH_URL_PROJECTS.'/save_project') ?>">
      <h5><?php echo lang('labs_add_lab_label') ?></h5>
      <hr>
      <div class="row">
         <div class='large-9 columns'>
            <label for=""><?php echo lang('common_words_name') ?></label>
            <input type="text" name="lab_name" required>
         </div>
      </div>
      <div class="row">
         <div class='large-6 columns'>
            <label for=""><?php echo lang('labs_lab_chief_label') ?></label>
            <select name="lab_id_lab_chief" required>
               <option value=""> --- </option>
               <?php foreach($chiefs as $l): ?>
               <option value="<?php echo $l->user_id ?>"><?php echo $l->fullname ?></option>
               <?php endforeach; ?>
            </select>
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