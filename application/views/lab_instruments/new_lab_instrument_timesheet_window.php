<div id="new_lab_instrument_timesheet_window" class="ch_overlay_window" style="width: 600px;">
	<form method="post" action="<?php print_url(CH_URL_LAB_INSTRUMENTS.'/save_lab_instrument_timesheet') ?>">
      <input type="hidden" name="timesheet_id" value="<?php echo $timesheet->id ?>">
      <input type="hidden" name="timesheet_id_lab_instrument" value="<?php echo $id_lab_instrument ?>">
      
      <h5><?php echo ($timesheet->id ? lang('instruments_edit_timesheet_title') : lang('instruments_add_timesheet_title')) ?></h5>
      <hr>
      <div class="row">
         <div class='large-5 columns'>
            <label for="timesheet_type"><?php echo lang('common_words_type') ?></label>
            <select id="timesheet_type" name="timesheet_type" required>
               <?php foreach ($timesheet_types as $type): ?>
               <option <?php mark_selected($timesheet->type, $type->type) ?> value="<?php echo $type->type ?>"><?php echo lang($type->language_label) ?></option>
               <?php endforeach; ?>
            </select>
         </div>
         <div class='large-7 columns end'>
            <label for="timesheet_id_lab_task"><?php echo lang('labs_lab_tasks_label') ?></label>
            <select id="timesheet_id_lab_task" name="timesheet_id_lab_task" disabled>
               <option value=""> --- </option>
               <?php foreach ($lab_tasks as $task): ?>
               <option <?php mark_selected($timesheet->id_lab_task, $task->id) ?> value="<?php echo $task->id ?>"><?php echo $task->name ?></option>
               <?php endforeach; ?>
            </select>
         </div>
      </div>
      <div class="row">
         <div class="large-4 columns">
            <label for="timesheet_start_timestamp"><?php echo lang('instruments_timesheet_start_label') ?></label>
            <input type="text" id="timesheet_start_timestamp" class="text-center" name="timesheet_start_timestamp" value="<?php echo $timesheet->start_timestamp ?>" required readonly>
         </div>
         <div class="large-4 columns">
            <label for="timesheet_end_timestamp"><?php echo lang('instruments_timesheet_end_label') ?></label>
            <input type="text" id="timesheet_end_timestamp" class="text-center" name="timesheet_end_timestamp" value="<?php echo $timesheet->end_timestamp ?>" required readonly>
         </div>
         <div class="large-4 columns">
            <label for="timesheet_duration"><?php echo lang('instruments_timesheet_length_label') ?></label>
            <input type="text" id="timesheet_duration" class="text-center" name="timesheet_duration" value="<?php echo $timesheet->duration ?>" readonly>
         </div>
      </div>
      <?php if($is_lab_chief): ?>
      <div class="row">
         <div class='large-6 columns end'>
            <label for="timesheet_id_user"><?php echo lang('instruments_timesheet_operator_label') ?></label>
            <select id="timesheet_id_user" name="timesheet_id_user" required>
               <option value=""> --- </option>
               <?php foreach ($lab_staff as $staff): ?>
               <option <?php mark_selected($timesheet->id_user, $staff->id_user) ?> value="<?php echo $staff->id_user ?>"><?php echo $staff->user->fullname ?></option>
               <?php endforeach; ?>
            </select>
         </div>
      </div>
      <?php else: ?>
      <input type="hidden" name="timesheet_id_user" value="<?php echo $this->bitauth->user_id ?>">
      <?php endif; ?>
		<hr>
		<div class="row">
			<div class="large-8 columns campo-errore"></div>
			<div class="columns text-right ch_button_pane">
            <button type="submit" title="<?php echo lang('common_words_send') ?>" class="btn-send button"><i class="fa fa-lg fa-check"></i></button>
			</div>
		</div>
	</form>
</div>