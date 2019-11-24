<div id="users-panel" class="row">
	<div class="large-12 columns large-centered">	
		<dl class="tabs" data-tab>
			<dd class="active"><a href="<?php echo '#'.TAB_LISTA_UTENTI ?>"><?php echo lang('user_users_label') ?></a></dd>
			<dd><a href="<?php echo '#'.TAB_LISTA_GRUPPI ?>"><?php echo lang('user_groups_label') ?></a></dd>
		</dl>
		<div class="tabs-content">
			<div class="active content" id="<?php echo TAB_LISTA_UTENTI ?>">
				<ul class="inline-list">
					<li><a href="<?php print_url(CH_URL_MAIN) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
					<li><a href="<?php print_url(CH_URL_USERS."/nuovo_utente") ?>" title="<?php echo lang('user_add_user_label') ?>"><i class="fa fa-fw fa-lg fa-plus"></i></a></li>
					<li><a id="btn-utenti-utente-modifica" href="<?php print_url(CH_URL_USERS."/modifica_utente") ?>" title="<?php echo lang('user_edit_selected_user_label') ?>"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
					<li><a id="btn-utenti-utente-abilitato" href="<?php print_url(CH_URL_USERS."/abilita_utente") ?>" title="<?php echo lang('user_disable_enable_user_label') ?>"><i class="fa fa-fw fa-lg fa-lock"></i></a></li>
				</ul>
                                <br><br>
				<form id="form-utenti-lista" method="post" >
					<input id="utenti-abilitato" name="utenti-abilitato" type="hidden">
					<table id="table-utenti-lista">
						<thead>
							<tr>
								<th style="width: 10px !important;">&nbsp;</th>
								<th><?php echo lang('common_words_name') ?></th>
								<th><?php echo lang('common_words_username') ?></th>
								<th><?php echo lang('common_words_language') ?></th>
								<th><?php echo lang('user_groups_label') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($user_list as $user): ?>
							<tr>
								<td><input type="radio" name="utenti-id" data-utenti-abilitato="<?php if(!$user->enabled) { echo '0'; } else { echo '1'; } ?>" value="<?php echo $user->user_id ?>"></td>
								<td><?php echo $user->fullname ?>&nbsp; <?php if(!$user->enabled) { echo '<i class="fa fa-fw fa-lock">'; } ?> </td>
								<td><?php echo $user->username ?></td>
								<td><?php echo $user->preferred_lang ?></td>
								<td>
									<?php foreach($user->groups as $idx => $name) 
										echo ($idx > 0 ? ", " : "").$name;
									?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</form>
			</div>
         <div class="content" id="<?php echo TAB_LISTA_GRUPPI ?>">
				<ul class="inline-list">
               <li><a href="<?php print_url(CH_URL_MAIN) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
					<li><a href="<?php print_url(CH_URL_USERS."/nuovo_gruppo") ?>" title="<?php echo lang('user_add_group_label') ?>"><i class="fa fa-fw fa-lg fa-plus"></i></a></li>
					<li><a id="btn-utenti-gruppo-modifica" href="<?php print_url(CH_URL_USERS."/modifica_gruppo") ?>" title="<?php echo lang('user_edit_group_label') ?>"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
					<li><a id="btn-utenti-gruppo-cancella" href="<?php print_url(CH_URL_USERS."/cancella_gruppo") ?>" title="<?php echo lang('user_delete_group_label') ?>"><i class="fa fa-fw fa-lg fa-remove"></i></a></li>
				</ul>
             <br><br>
				<form id="form-utenti-gruppi-lista" method="post" >
               <table id="table-utenti-gruppi-lista" style="table-layout: fixed;">
						<thead>
							<tr>
								<th style="width: 10px !important;">&nbsp;</th>
								<th><?php echo lang('common_words_name') ?></th>
								<th><?php echo lang('common_words_description') ?></th>
								<th><?php echo lang('user_selected_group_rules') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($user_groups_list as $group): ?>
							<tr>
								<td><input type="radio" name="gruppi-id" value="<?php echo $group->group_id ?>"></td>
								<td class="nowrap"><?php echo $group->name ?></td>
								<td><?php echo $group->description ?></td>
								<td>
									<?php foreach($group->roles as $idx => $role) 
										echo ($idx > 0 ? ", " : "").$role->slug;
									?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<script>var page = 'utenti';</script>