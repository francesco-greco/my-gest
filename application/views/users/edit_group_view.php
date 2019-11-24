<div id="users-panel" class="row">
	<div class="large-12 columns large-centered">	
		<dl class="tabs" data-tab>
			<dd class="active">
				<a href="#tab-utenti-gruppo">
					<?php if($gruppo->name != '') : ?>
					Gruppo utente '<?php echo $gruppo->name ?>'
					<?php else : echo lang('user_new_user_group_label'); endif; ?>
				</a>
			</dd>
		</dl>
		<div class="tabs-content">
			<div class="active content" id="tab-utenti-gruppoTab">
				<ul class="inline-list">
					<li><a href="<?php print_url(CH_URL_USERS.'#tab-utenti-gruppi') ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
					<li><a id="btn-utenti-gruppo-salva" href="#" title="<?php echo lang('common_words_save') ?>"><i class="fa fa-fw fa-lg fa-save"></i></a></li>
				</ul>
				<form id="form-utenti-gruppo-nuovo" method="post" action="<?php print_url(CH_URL_USERS.'/salva_gruppo') ?>">
					<input type="hidden" name="gruppi-id" value="<?php echo $gruppo->group_id ?>" >
               <div class="row">
                  <div class="large-3 columns">
                     <label><?php echo lang('common_words_name') ?> *</label>
                     <input id="gruppi-nome" name="gruppi-nome" type="text" value="<?php echo $gruppo->name ?>">
                  </div>
                  <div class="large-9 columns">
                     <label><?php echo lang('common_words_description') ?></label>
                     <input type="text" name="gruppi-descrizione" value="<?php echo $gruppo->description ?>">
                     <!--<textarea name="gruppi-descrizione"><?php echo $gruppo->description ?></textarea>-->
                  </div>
               </div>
					<fieldset>
						<legend><?php echo lang('user_selected_group_rules') ?></legend>
						<ul class="large-block-grid-3">
							<?php foreach ($roles as $role) : ?>
							<?php $checked = "";	if(in_array($role->label, $gruppo->roles)) $checked = 'checked'; ?>
							<li>
                        <input type="checkbox" name="gruppi-ruoli[]" class="gruppi-ruoli" <?php echo $checked ?> value="<?php echo $role->label ?>">&nbsp;<?php echo $role->label ?>&nbsp;
                        <i title="<?php echo $role->description ?>" data-tooltip aria-haspopup="true" class="has-tip tip-bottom noradius fa fa-info-circle"></i></li>
							<?php endforeach; ?>
						</ul>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
<script>var page = "modifica_gruppo"</script>