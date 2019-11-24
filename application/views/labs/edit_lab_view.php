<div id="labs-panel" class="row">
   <section class="large-12 columns large-centered">	
		<ul class="tabs" data-options="deep_linking: true" data-tab>
         <li class="tab-title active">
            <a href="#summary"><?php echo lang('labs_lab_summary_label') ?></a>
         </li>
         <li class="tab-title">
            <a href="#lab_tasks"><?php echo lang('labs_lab_tasks_label') ?></a>
         </li>
         <li class="tab-title">
            <a href="#lab_instruments"><?php echo lang('labs_lab_instruments_label') ?></a>
         </li>
         <li class="tab-title">
            <a href="#lab_staff"><?php echo lang('labs_lab_staff_label') ?></a>
         </li>
		</ul>
		<div class="tabs-content">
			<div id="summary" class="active content">
            <form class="form_lab_details" method="post" action="<?php print_url(CH_URL_LABS.'/save_lab') ?>">
               <input type="hidden" class="lab_id" name="lab_id" value="<?php echo $lab->id ?>">
               <ul class="inline-list">
                  <li><a href="<?php print_url(CH_URL_LABS) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                  <?php if($enable_lab_summary_edit): ?>
                  <li><a class="btn_save" href="#summary" title="<?php echo lang('common_words_save') ?>"><i class="fa fa-fw fa-lg fa-save"></i></a></li>
                  <?php endif; ?>
               </ul>
               <div class="row">
                  <div class='large-8 columns'>
                     <label for=""><?php echo lang('common_words_name') ?></label>
                     <input class="lab_name" name="lab_name" type="text" value="<?php echo $lab->name ?>" required <?php mark_readonly(!$enable_lab_summary_edit) ?> >
                  </div>
                  <div class='large-4 columns'>
                     <label for=""><?php echo lang('labs_lab_chief_label') ?></label>
                     <select name="lab_id_lab_chief" required <?php mark_disabled(!$this->bitauth->has_role(CH_ROLE_POWERUSER)) ?> >
                        <option value=""> --- </option>
                        <?php foreach($chiefs as $l): ?>
                        <option <?php mark_selected($l->user_id, $lab->lab_chief->user_id) ?> value="<?php echo $l->user_id ?>"><?php echo $l->fullname ?></option>
                        <?php endforeach; ?>
                     </select>
                     <!--<input type="text" value="<?php echo $lab->lab_chief->fullname ?>" readonly>-->
                  </div>
               </div>
               <div class="row">
                  <div class='large-12 columns'>
                     <label for=""><?php echo lang('labs_lab_description_label') ?></label>
                     <textarea class="lab_description" name="lab_description" <?php mark_readonly(!$enable_lab_summary_edit) ?>><?php echo $lab->description ?></textarea>
                  </div>
               </div>
				</form>
			</div>
         <div id="lab_tasks" class="content">
            <ul class="inline-list">
               <li><a href="<?php print_url(CH_URL_LABS) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
               <li><a class="btn_edit_task" href="#lab_tasks" title="<?php echo lang('labs_open_lab_task_label') ?>"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
            </ul>
            <form method="post" action="<?php print_url(CH_URL_LAB_TASKS.'/edit_task') ?>">
               <input type="hidden" name="lab_id" value="<?php echo $lab->id ?>">
               <table>
                  <thead>
                     <tr>
                        <td>&nbsp;</td>
                        <td><?php echo lang('common_words_name') ?></td>
                        <td><?php echo lang('labs_project_label') ?></td>
                        <td><?php echo lang('lab_tasks_start_label') ?></td>
                        <td><?php echo lang('lab_tasks_end_label') ?></td>
                        <td><?php echo lang('lab_tasks_progress_label') ?></td>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
            </form>
         </div>
         <div id="lab_instruments" class="content">
            <ul class="inline-list">
               <li><a href="<?php print_url(CH_URL_LABS) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
               <?php if($enable_lab_instrument_edit): ?>
               <li><a class="btn_add_lab_instrument" href="#lab_instruments" title="<?php echo lang('instruments_instrument_add_label') ?>"><i class="fa fa-fw fa-lg fa-plus"></i></a></li>
               <?php endif; ?>
               <li><a class="btn_edit_lab_instrument" href="#lab_instruments" title=""><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
            </ul>
            <form method="post" action="<?php print_url(CH_URL_LAB_INSTRUMENTS.'/edit_instrument') ?>">
               <input type="hidden" name="lab_id" value="<?php echo $lab->id ?>">
               <table>
                  <thead>
                     <tr>
                        <td>&nbsp;</td>
                        <td><?php echo lang('common_words_name') ?></td>
                        <td><?php echo lang('common_words_description') ?></td>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
            </form>
         </div>
         <div id="lab_staff" class="content">
            <ul class="inline-list">
               <li><a href="<?php print_url(CH_URL_LABS) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
               <?php if($enable_lab_staff_edit): ?>
               <li><a class="btn_add_lab_staff_member" href="#lab_staff" title="<?php echo lang('labs_lab_staff_member_add_label') ?>"><i class="fa fa-fw fa-lg fa-plus"></i></a></li>
               <li><a class="btn_delete_staff_member" href="#lab_staff" title="<?php echo lang('labs_lab_staff_member_delete_label') ?>"><i class="fa fa-fw fa-lg fa-trash"></i></a></li>
               <?php endif; ?>
            </ul>
            <form class="form_lab_staff" method="post" action="#lab_staff">
               <table>
                  <thead>
                     <tr>
                        <td>&nbsp;</td>
                        <td><?php echo lang('common_words_name') ?></td>
                        <td><?php echo lang('labs_staff_role_label') ?></td>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
            </form>
         </div>
		</div>
	</section>
</div>
<script>var page = "edit_lab";</script>