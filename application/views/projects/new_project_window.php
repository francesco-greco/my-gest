<div id="new_project_window" class="ch_overlay_window">
	<form method="post" action="<?php print_url(CH_URL_PROJECTS.'/save_project') ?>">
      <h5><?php echo lang('projects_add_projects_label') ?></h5>
      <hr>
      <div class="row">
         <div class='large-9 columns'>
            <label for=""><?php echo lang('common_words_name') ?></label>
            <input type="text" name="project_name" required>
         </div>
         <div class='large-3 columns'>
            <label for=""><?php echo lang('common_words_code') ?></label>
            <input class="project_code" name="project_code" type="text"  maxlength="20" required>
         </div>
      </div>
      <div class="row">
         <div class='large-6 columns'>
            <label for=""><?php echo lang('projects_project_leader_label') ?></label>
            <select name="project_id_project_leader" required>
               <option value=""> --- </option>
               <?php foreach($leaders as $l): ?>
               <option value="<?php echo $l->user_id ?>"><?php echo $l->fullname ?></option>
               <?php endforeach; ?>
            </select>
         </div>
         <div class='large-6 columns'>
            <label for=""><?php echo lang('projects_client_label') ?></label>
            <select name="project_id_client" required>
               <option value=""> --- </option>
               <?php foreach($clients as $c): ?>
               <option value="<?php echo $c->user_id ?>"><?php echo $c->fullname ?></option>
               <?php endforeach; ?>
            </select>
         </div>
      </div>
      <div class="row">
         <div class="large-12 columns"><?php echo lang('projects_resp_prj_email_sending_msg') ?></div>
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