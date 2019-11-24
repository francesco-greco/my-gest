<div id="lab-tasks-panel" class="row">
   <section class="large-12 columns large-centered">	
		<ul class="tabs" data-tab>
         <li class="tab-title active">
            <a href="#lab_tasks_summary"><?php echo lang('labs_lab_summary_label') ?></a>
         </li>
         <li class="tab-title">
            <a href="#lab_tasks_timesheets"><?php echo lang('lab_tasks_timesheet_label') ?></a>
         </li>
         <li class="tab-title">
            <a href="#lab_task_attachments"><?php echo lang('lab_tasks_results_label') ?></a>
         </li>
		</ul>
		<div class="tabs-content">
			<div id="lab_tasks_summary" class="active content">
            <!--<form class="form_lab_task_details" method="post" action="<?php print_url(CH_URL_LABS.'/save_lab') ?>">-->
               <input type="hidden" class="lab_id" name="lab_id" value="<?php echo $lab->id ?>">
               <input type="hidden" class="lab_task_id" name="id" value="<?php echo $lab_task->id ?>">
               <ul class="inline-list">
                  <li><a href="<?php echo $back_action_url ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                  <?php if($enable_task_edit): ?>
                  <li><a class="btn_save" href="#" title="<?php echo lang('common_words_save') ?>"><i class="fa fa-fw fa-lg fa-save"></i></a></li>
                  <?php endif; ?>
                  <?php if($enable_task_edit && !$task_is_started && !$task_is_ended): ?>
                  <li><a class="btn_start_task" href="#" title="<?php echo lang('lab_tasks_start_task_btn_label') ?>"><i class="fa fa-fw fa-lg fa-play"></i></a></li>
                  <?php endif; ?>
                  <?php if($enable_task_edit && $task_is_started && !$task_is_ended): ?>
                  <li><a class="btn_end_task" href="#" title="<?php echo lang('lab_tasks_end_task_btn_label') ?>"><i class="fa fa-fw fa-lg fa-stop"></i></a></li>
                  <?php endif; ?>
               </ul>
               <div class="row">
                  <div class='large-5 columns'>
                     <label><?php echo lang('common_words_name') ?></label>
                     <input class="lab_task_name" name="lab_task_name" type="text" value="<?php echo $lab_task->name ?>" readonly>
                  </div>
                  <div class='large-5 columns'>
                     <label><?php echo lang('labs_project_label') ?></label>
                     <input class="lab_task_name" name="lab_task_name" type="text" value="<?php echo $lab_task->project->name ?>" readonly>
                  </div>
                  <div class='large-2 columns'>
                     <label><?php echo lang('lab_tasks_code_label') ?></label>
                     <input class="lab_task_code" name="lab_task_code" type="text" value="<?php echo $lab_task->code ?>" readonly>
                  </div>
               </div>
               <div class="row">
                  <div class="large-3 columns">
                     <label><?php echo lang('lab_tasks_start_label') ?></label>
                     <input class="lab_task_start text-center" type="text" value="<?php echo millis_to_date($lab_task->start) ?>" readonly>
                  </div>
                  <div class="large-3 columns">
                     <label><?php echo lang('lab_tasks_end_label') ?></label>
                     <input class="lab_task_end text-center" type="text" value="<?php echo millis_to_date($lab_task->end) ?>" readonly>
                  </div>
                  <div class="large-3 columns">
                     <label><?php echo lang('lab_tasks_start_task_field_label') ?></label>
                     <input class="lab_task_actual_start_date text-center" type="text" value="<?php echo $lab_task->actual_start_date ?>" readonly>
                  </div>
                  <div class="large-3 columns end">
                     <label><?php echo lang('lab_tasks_end_task_field_label') ?></label>
                     <input class="lab_task_actual_end_date text-center" type="text" value="<?php echo $lab_task->actual_end_date ?>" readonly>
                  </div>
               </div>
               <div class="row">
                  <div class="large-12 columns">
                     <div class="row">
                        <div class="small-10 large-11 columns">
                           <label><?php echo lang('lab_tasks_progress_label') ?></label>
                           <div class="task_progress_slider range-slider <?php echo (!$enable_task_edit ? 'disabled' : '') ?>" data-slider="<?php echo $lab_task->progress ?>" style="margin-top: 0.7rem;" data-options="display_selector: #lab_task_progress; start: 0; end: 100;">
                              <span class="range-slider-handle" role="slider"></span>
                              <span class="range-slider-active-segment"></span>
                              <input name="lab_task_progress" type="hidden" value="<?php echo $lab_task->progress ?>" >
                           </div>
                        </div>
                        <div class="small-2 large-1 columns" style="padding-top: 1.7rem;"><span id="lab_task_progress"></span><span>&nbsp;%</span></div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class='large-12 columns'>
                     <label for=""><?php echo lang('labs_lab_description_label') ?></label>
                     <textarea class="lab_description" name="lab_description" readonly><?php echo $lab_task->description ?></textarea>
                  </div>
               </div>
				<!--</form>-->
			</div>
         <div id="lab_tasks_timesheets" class="content">
            <ul class="inline-list left large-6">
               <li><a href="<?php echo $back_action_url ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
               <!--<li><a class="btn_edit_task" href="#" title=""><i class="fa fa-fw fa-lg fa-eye"></i></a></li>-->
               <li><a class="btn_export_timesheet" href="#" title="<?php echo lang('instruments_get_timesheet_csv_label') ?>"><i class="fa fa-fw fa-lg fa-file-excel-o"></i></a></li>
            </ul>
            <ul class="inline-list" style="position: absolute; right: 220px; z-index: 100;">
               <li>
                  <div class="row">
                     <div class="large-5 columns"><label>Strumentazione</label></div>
                     <div class="large-7 columns end">
                        <select id="instrument_filter_select" style="height: 26px; padding: 0px;">
                           <option value="">Tutte</option>
                           <?php foreach($lab_instruments_list as $instrument): ?>
                           <option value="<?php echo $instrument->id ?>"><?php echo $instrument->name ?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                  </div>
               </li>
            </ul>
            <form class="form_lab_staff" method="post" action="<?php print_url('') ?>">
               <input type="hidden" name="lab_id" value="<?php echo $lab->id ?>">
               <table style="clear: both">
                  <thead>
                     <tr>
                        <td>&nbsp;</td>
                        <td>Strumentazione</td>
                        <td>Operatore</td>
                        <td>Inizio</td>
                        <td>Fine</td>
                        <td>Durata</td>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
            </form>
         </div>
         <div id="lab_task_attachments" class="content">
            <ul class="inline-list">
               <li><a href="<?php echo $back_action_url ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
               <li><a class="btn_download_attachment" href="#" title="<?php echo lang('instruments_attachment_download_attachment_label') ?>"><i class="fa fa-fw fa-lg fa-download"></i></a></li>
            </ul>
            <form method="post" action="<?php print_url('') ?>">
               <table>
                  <thead>
                     <tr>
                        <td>&nbsp;</td>
                        <td><?php echo lang('common_words_data') ?></td>
                        <td>Strumentazione</td>
                        <td><?php echo lang('common_words_description') ?></td>
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
<script>var page = "edit_lab_task";</script>