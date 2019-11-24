<div id="projects-panel" class="row">
   <section class="large-12 columns large-centered">	
		<ul class="tabs" data-options="deep_linking: true" data-tab>
         <li class="tab-title active">
            <a href="#summary">Sommario</a>
         </li>
         <li class="tab-title">
            <a href="#project_tasks">Attività</a>
         </li>
         <li class="tab-title">
            <a href="#project_attachments">Allegati</a>
         </li>
		</ul>
		<div class="tabs-content">
			<div id="summary" class="active content">
            <form class="form_project_details" method="post" action="<?php print_url(CH_URL_PROJECTS.'/save_project') ?>">
               <input type="hidden" class="project_id" name="project_id" value="<?php echo $project->id ?>">
               <ul class="inline-list">
                  <li><a href="<?php print_url(CH_URL_PROJECTS) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                  <?php if(!$open_read_only): ?>
                  <li><a class="btn_save" href="javascript:void(0)" title="<?php echo lang('common_words_save') ?>"><i class="fa fa-fw fa-lg fa-save"></i></a></li>
                  <?php endif; ?>
                  <li><a href="<?php print_url(CH_URL_PROJECTS.'/project_gantt/'.$project->id) ?>" target="gantt_admin"><i class="fa fa-fw fa-lg fa-bar-chart"></i></a></li>
                  <?php if(!$open_read_only && !$project_is_started && !$project_is_ended): ?>
                  <li><a class="btn_start_project" href="javascript:void(0)" title="<?php echo lang('projects_start_project_btn_label') ?>"><i class="fa fa-fw fa-lg fa-play"></i></a></li>
                  <?php endif; ?>
                  <?php if(!$open_read_only && $project_is_started && !$project_is_ended): ?>
                  <li><a class="btn_end_project" href="javascript:void(0)" title="<?php echo lang('projects_end_project_btn_label') ?>"><i class="fa fa-fw fa-lg fa-stop"></i></a></li>
                  <?php endif; ?>
               </ul>
               <div class="row">
                  <div class='large-9 columns'>
                     <label for="project_name"><?php echo lang('common_words_name') ?></label>
                     <input <?php mark_readonly($open_read_only) ?> id="project_name" class="project_name" name="project_name" type="text" value="<?php echo $project->name ?>">
                  </div>
                  <div class='large-3 columns'>
                     <label for="project_code"><?php echo lang('common_words_code') ?></label>
                     <input <?php mark_readonly($open_read_only) ?> id="project_code" class="project_code" type="text" value="<?php echo $project->code ?>" readonly>
                  </div>
               </div>
               <div class="row">
                  <div class='large-6 columns'>
                     <label for=""><?php echo lang('projects_project_leader_label') ?></label>
                     <input type="text" value="<?php echo $project->project_leader->fullname ?>" readonly>
                  </div>
                  <div class='large-6 columns'>
                     <label for=""><?php echo lang('projects_client_label') ?></label>
                     <input type="text" value="<?php echo $project->client->fullname ?>" readonly>
                  </div>
               </div>
               <div class="row">
                  <div class="large-2 columns">
                     <label for=""><?php echo lang('projects_start_project_field_label') ?></label>
                     <input type="text" class="text-center" value="<?php echo $project->start_date ?>" readonly>
                  </div>
                  <div class="large-2 columns">
                     <label for=""><?php echo lang('projects_end_project_field_label') ?></label>
                     <input type="text" class="text-center" value="<?php echo $project->end_date ?>" readonly>
                  </div>
                  <div class="large-2 columns end"></div>
               </div>
               <div class="row">
                  <div class="large-12 columns">
                     <label for="project_description"><?php echo lang('common_words_description') ?></label>
                     <textarea <?php mark_readonly($open_read_only) ?> id="project_description" name="project_description" rows="10" ><?php echo $project->description ?></textarea>
                  </div>
               </div>
				</form>
			</div>
         <div id="project_tasks" class="content">
				<form method="post" action="<?php print_url(CH_URL_LAB_TASKS.'/edit_task') ?>">
               <ul class="inline-list">
                  <li><a href="<?php print_url(CH_URL_PROJECTS) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                  <li><a class="btn_edit_task" href="javascript:void(0)" title="<?php echo lang('projects_open_lab_task_label') ?>"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
               </ul>
               <table>
                  <thead>
                     <tr>
                        <th>&nbsp;</th>
                        <th>Attività</th>
                        <th>Laboratorio</th>
                        <th>Inizio pianificato</th>
                        <th>Conclusione pianificata</th>
                        <th>Inizio effettivo</th>
                        <th>Conclusione effettiva</th>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
				</form>
			</div>
         <div id="project_attachments" class="content">
				<form method="post" action="#">
               <ul class="inline-list">
                  <li><a href="<?php print_url(CH_URL_PROJECTS) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                  <?php if(!$open_read_only): ?>
                  <li><a class="btn_add_attachment" href="javascript:void(0)" title="<?php echo lang('projects_add_attachment_label') ?>"><i class="fa fa-fw fa-lg fa-plus"></i></a></li>
                  <?php endif; ?>
                  <li><a class="btn_download_attachment" href="javascript:void(0)" title="<?php echo lang('common_words_download_attachment_label') ?>"><i class="fa fa-fw fa-lg fa-download"></i></a></li>
                  <?php if(!$open_read_only): ?>
                  <li><a class="btn_share_attachment" href="javascript:void(0)" title="<?php echo lang('projects_share_attachment_label') ?>"><i class="fa fa-fw fa-lg fa-share-alt"></i></a></li>
                  <?php endif; ?>
               </ul>
               <table>
                  <thead>
                     <tr>
                        <th>&nbsp;</th>
                        <th><?php echo lang('common_words_data') ?></th>
                        <th><?php echo lang('common_words_type') ?></th>
                        <th><?php echo lang('common_words_description') ?></th>
                        <th>Laboratorio</th>
                        <th>Attività</th>
                        <th><?php echo lang('common_words_shared') ?></th>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
				</form>
			</div>
		</div>
	</section>
</div>
<script>var page = "edit_project";</script>