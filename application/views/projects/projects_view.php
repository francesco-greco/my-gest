<div id="projects-panel" class="row">
	<div class="large-12 columns large-centered">	
		<dl class="tabs" data-tab>
			<dd class="active"><a href="#"><?php echo lang('projects_projects_label') ?></a></dd>
		</dl>
		<div class="tabs-content">
			<div class="active content">
				<ul class="inline-list">
					<li><a href="<?php print_url(CH_URL_MAIN) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
               <?php if($enable_create_prj_btn === TRUE): ?>
					<li><a class="btn-project-new" href="#" title="<?php echo lang('projects_add_projects_label') ?>"><i class="fa fa-fw fa-lg fa-plus"></i></a></li>
               <?php endif ?>
					<li><a class="btn-project-edit" href="<?php print_url(CH_URL_PROJECTS."/edit_project") ?>" title="<?php echo lang('projects_edit_selected_project_label') ?>"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
				</ul>
				<form id="form-projects-list" method="post" >
					<table>
						<thead>
							<tr>
								<th style="width: 10px !important;">&nbsp;</th>
								<th><?php echo lang('common_words_name') ?></th>
								<th><?php echo lang('common_words_code') ?></th>
                        <th><?php echo lang('projects_project_leader_label') ?></th>
                        <th><?php echo lang('projects_client_label') ?></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<script>var page = 'projects';</script>