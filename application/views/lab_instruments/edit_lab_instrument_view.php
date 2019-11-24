<div id="labs-instrument-panel" class="row">
   <section class="large-12 columns large-centered">	
		<ul class="tabs" data-tab>
         <li class="tab-title active">
            <a href="#summary"><?php echo lang('labs_lab_summary_label') ?></a>
         </li>
         <li class="tab-title">
            <a href="#instrument_time_sheets"><?php echo lang('instruments_timesheet_label') ?></a>
         </li>
         <li class="tab-title">
            <a href="#instrument_attachment"><?php echo lang('common_words_attachments') ?></a>
         </li>
		</ul>
		<div class="tabs-content">
			<div id="summary" class="active content">
            <form class="form_lab_instrument_details" method="post" action="<?php print_url(CH_URL_LAB_INSTRUMENTS.'/save_instrument') ?>">
               <input type="hidden" class="lab_instrument_id" name="lab_instrument_id" value="<?php echo $lab_instrument->id ?>">
               <ul class="inline-list">
                  <li><a href="<?php print_url(CH_URL_LABS.'/edit_lab/'.$lab->id.'#lab_instruments') ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                  <?php if($enable_instrument_summary_edit): ?>
                  <li><a class="btn_save" href="#" title="<?php echo lang('common_words_save') ?>"><i class="fa fa-fw fa-lg fa-save"></i></a></li>
                  <?php endif ?>
               </ul>
               <div class="row">
                  <div class='large-8 columns'>
                     <label for="lab_instrument_name"><?php echo lang('common_words_name') ?></label>
                     <input id="lab_instrument_name" name="lab_instrument_name" type="text" value="<?php echo $lab_instrument->name ?>" <?php mark_readonly(!$enable_instrument_summary_edit) ?> required>
                  </div>
                  <div class="large-4 columns">
                     <label for=""><?php echo lang('common_words_type') ?></label>
                     <select name="lab_instrument_type" <?php mark_disabled(!$enable_instrument_summary_edit) ?>>
                        <?php foreach ($lab_instrument_types as $t): ?>
                        <option <?php mark_selected($t->type, $lab_instrument->type) ?> value="<?php echo $t->type ?>"><?php echo lang($t->language_label) ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <div class='large-12 columns'>
                     <label for="lab_instrument_description"><?php echo lang('common_words_description') ?></label>
                     <textarea id="lab_instrument_description"<?php mark_readonly(!$enable_instrument_summary_edit) ?> name="lab_instrument_description"><?php echo $lab_instrument->description ?></textarea>
                  </div>
               </div>
				</form>
			</div>
         <div id="instrument_time_sheets" class="content">
            <ul class="inline-list">
               <li><a href="<?php print_url(CH_URL_LABS.'/edit_lab/'.$lab->id.'#lab_instruments') ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
               <li><a class="btn_add_timesheet" href="#"  title="<?php echo lang('instruments_add_timesheet_title') ?>"><i class="fa fa-fw fa-lg fa-plus"></i></a></li>
               <li><a class="btn_edit_timesheet" href="#" title="<?php echo lang('instruments_edit_timesheet_title') ?>"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
               <li><a class="btn_delete_timesheet" href="#" title="<?php echo lang('instruments_delete_timesheet_title') ?>"><i class="fa fa-fw fa-lg fa-remove"></i></a></li>
               <li><a class="btn_export_timesheet" href="#" title="<?php echo lang('instruments_get_timesheet_csv_label') ?>"><i class="fa fa-fw fa-lg fa-file-excel-o"></i></a></li>
            </ul>
            <form class="form_instrument_time_sheets" method="post" action="#">
               <input type="hidden" class="lab_instrument_id" name="lab_instrument_id" value="<?php echo $lab_instrument->id ?>">
               <table>
                  <thead>
                     <tr>
                        <td>&nbsp;</td>
                        <td><?php echo lang('common_words_type') ?></td>
                        <td><?php echo lang('labs_lab_tasks_label') ?></td>
                        <td><?php echo lang('instruments_timesheet_operator_label') ?></td>
                        <td><?php echo lang('instruments_timesheet_start_label') ?></td>
                        <td><?php echo lang('instruments_timesheet_end_label') ?></td>
                        <td><?php echo lang('instruments_timesheet_length_label') ?></td>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
            </form>
         </div>
         <div id="instrument_attachment" class="content">
            <ul class="inline-list">
               <li><a href="<?php print_url(CH_URL_LABS.'/edit_lab/'.$lab->id.'#lab_instruments') ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
               <li><a class="btn_add_attachment" href="#" title="<?php echo lang('instruments_attachment_add_attachment_label') ?>"><i class="fa fa-fw fa-lg fa-plus"></i></a></li>
               <li><a class="btn_edit_attachment" href="#" title="<?php echo lang('instruments_attachment_edit_attachment_label') ?>"><i class="fa fa-fw fa-lg fa-edit"></i></a></li>
               <!--<li><a class="btn_delete_attachment" href="#" title="<?php echo lang('instruments_attachment_delete_attachment_label') ?>"><i class="fa fa-fw fa-lg fa-remove"></i></a></li>-->
               <li><a class="btn_download_attachment" href="#" title="<?php echo lang('instruments_attachment_download_attachment_label') ?>"><i class="fa fa-fw fa-lg fa-download"></i></a></li>
            </ul>
            <form class="form_instrument_attachments" method="post" action="#">
               <input type="hidden" class="lab_instrument_id" name="lab_instrument_id" value="<?php echo $lab_instrument->id ?>">
               <table>
                  <thead>
                     <tr>
                        <td>&nbsp;</td>
                        <td><?php echo lang('common_words_data') ?></td>
                        <td><?php echo lang('common_words_type') ?></td>
                        <td><?php echo lang('common_words_description') ?></td>
                        <td><?php echo lang('labs_lab_tasks_label') ?></td>
                        <td><?php echo lang('instruments_timesheet_operator_label') ?></td>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
            </form>
         </div>
		</div>
	</section>
</div>
<script>var page = "edit_lab_instrument";</script>