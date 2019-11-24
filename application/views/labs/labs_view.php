<div id="labs-panel" class="row">
	<div class="large-12 columns large-centered">	
		<dl class="tabs" data-tab>
			<dd class="active"><a href="#"><?php echo lang('labs_labs_label') ?></a></dd>
		</dl>
		<div class="tabs-content">
			<div class="active content">
				<ul class="inline-list">
					<li><a href="<?php print_url(CH_URL_MAIN) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
               <?php if($this->bitauth->has_role(CH_ROLE_LAB_AREA_ADD_LAB)): ?>
					<li><a class="btn-lab-new" href="#" title="<?php echo lang('labs_add_lab_label') ?>"><i class="fa fa-fw fa-lg fa-plus"></i></a></li>
               <?php endif; ?>
					<li><a class="btn-lab-edit" href="<?php print_url(CH_URL_LABS."/edit_lab") ?>" title="<?php echo lang('labs_edit_selected_lab_label') ?>"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
				</ul>
				<form id="form-labs-list" method="post" >
					<table>
						<thead>
							<tr>
								<th style="width: 10px !important;">&nbsp;</th>
								<th><?php echo lang('common_words_name') ?></th>
								<th><?php echo lang('labs_lab_chief_label') ?></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<script>var page = 'labs';</script>