<div id="new_lab_staff_window" class="ch_overlay_window">
	<form method="post" action="<?php print_url(CH_URL_LABS.'/add_lab_staff_member') ?>">
      <input type="hidden" name="lab_staff_member_id_lab" value="<?php echo $id_lab ?>">
      <h5><?php echo lang('labs_lab_staff_member_add_label') ?></h5>
      <hr>
      <div class="row">
         <div class='large-6 columns'>
            <label for=""><?php echo lang('labs_lab_staff_member_label') ?></label>
            <select name="lab_staff_member_id_user" required>
               <option value=""> --- </option>
               <?php foreach($staff_members as $l): ?>
               <option value="<?php echo $l->user_id ?>"><?php echo $l->fullname ?></option>
               <?php endforeach; ?>
            </select>
         </div>
         <div class='large-6 columns'>
            <label for=""><?php echo lang('labs_staff_role_label') ?></label>
            <input class="lab_member_role" type="text" name="lab_staff_member_role" required>
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