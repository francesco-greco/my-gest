<div id="new_lab_instrument_attachment_window" class="ch_overlay_window" style="width: 600px;">
   <form method="post" action="<?php print_url(CH_URL_LAB_INSTRUMENTS.'/save_lab_instrument_attachment/') ?>" enctype="multipart/form-data">
      <input type="hidden" name="attachment_id" value="<?php echo $attachment->id ?>">
      <input type="hidden" name="attachment_id_lab_instrument" value="<?php echo $id_lab_instrument ?>">
      
      <h5><?php echo ($attachment->id ? lang('instruments_attachment_edit_attachment_label') : lang('instruments_attachment_add_attachment_label')) ?></h5>
      <hr>
      <div class="row">
         <div class='large-5 columns'>
            <label for="attachment_type"><?php echo lang('common_words_type') ?></label>
            <select id="attachment_type" name="attachment_category" required>
               <option value=""> --- </option>
               <?php foreach ($attachment_categories as $category): ?>
               <option <?php mark_selected($attachment->category, $category->category) ?> value="<?php echo $category->category ?>"><?php echo lang($category->language_label) ?></option>
               <?php endforeach; ?>
            </select>
         </div>
         <div class='large-7 columns end'>
            <label for="attachment_id_lab_task"><?php echo lang('labs_lab_tasks_label') ?></label>
            <select id="attachment_id_lab_task" name="attachment_id_lab_task" disabled>
               <option value=""> --- </option>
               <?php foreach ($lab_tasks as $task): ?>
               <option <?php mark_selected($attachment->id_lab_task, $task->id) ?> value="<?php echo $task->id ?>"><?php echo $task->name ?></option>
               <?php endforeach; ?>
            </select>
         </div>
      </div>
      <div class="row">
         <div class="large-4 columns">
            <label for="attachment_upload_date"><?php echo lang('common_words_data') ?></label>
            <input type="text" id="attachment_upload_date" class="text-center" name="attachment_upload_date" value="<?php echo $attachment->upload_date ?>" required readonly>
         </div>
         <div class="large-8 columns">
            <label for="attachment_filename"><?php echo lang('common_words_attachment') ?></label>
            <input style="height: 36px;" type="file" id="attachment_filename" name="attachment_filename" required>
         </div>
      </div>
      <div class="row">
         <div class='large-12 columns'>
            <label for="attachment_description"><?php echo lang('common_words_description') ?></label>
            <textarea name="attachment_description"><?php echo $attachment->description ?></textarea>
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