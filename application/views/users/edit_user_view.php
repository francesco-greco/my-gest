<div id="users-panel" class="row">
    <div class="large-12 columns large-centered">	
        <dl class="tabs" data-tab>
            <dd class="active">
                <a href="#tab-utenti-utente">
                    <?php if ($utente->user_id != '') : ?>
                        <?php echo lang('user_users_label'), " '$utente->fullname'" ?>
                    <?php else : echo lang('user_new_user_label');
                    endif; ?>
                </a>
            </dd>
        </dl>
        <div class="tabs-content">
            <div class="active content" id="tab-utenti-utente">
                <ul class="inline-list">
                    <li><a href="<?php print_url(CH_URL_USERS . '#tab-utenti-list') ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                    <li><a id="btn-utenti-utente-salva" href="#" title="<?php echo lang('common_words_save') ?>"><i class="fa fa-fw fa-lg fa-save"></i></a></li>
                </ul>
                <form id="form-utenti-utente-nuovo" method="post" action="<?php print_url(CH_URL_USERS . '/salva_utente') ?>">
                    <input id="utenti-id" type="hidden" name="utenti-id" value="<?php echo $utente->user_id ?>" >
                    <input id="utenti-abilitato" type="hidden" name="utenti-abilitato" value="<?php echo $utente->enabled ?>">
                    <div class="row">
                        <div class="large-11 columns">
                            <label><?php echo lang('common_words_username') ?> *</label>
                            <input id="utenti-username" name="utenti-username" type="text" value="<?php echo $utente->username ?>" tabindex="1">
                        </div>
                        <div class="large-1 columns">
                            <a id="checkbox-utenti-abilitato" title="<?php echo lang('user_disable_enable_user_label') ?>" href="#">
                                <i class="fa fa-4x <?php echo $utente->enabled == 1 ? 'fa-unlock' : 'fa-lock' ?>"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-6 columns">
                            <label>Password *</label>
                            <input id="utenti-password" name="utenti-password" type="password" tabindex="2">
                        </div>
                        <div class="large-6 columns">
                            <label><?php echo lang('user_confirm_password_label') ?> *</label>
                            <input id="utenti-ripeti-password"  name="utenti-ripeti-password" type="password" tabindex="3">
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-4 columns">
                            <label><?php echo lang('user_fullname_label') ?> *</label>
                            <input id="utenti-nome" name="utenti-nome" type="text" value="<?php echo $utente->fullname ?>" tabindex="4">
                        </div>
                        <div class="large-4 columns" tabindex="5">
                            <label><?php echo lang('user_preferred_lang_label') ?> *</label>
                            <select id="utenti-preferred-lang" name="utenti-preferred-lang">
                                <option value=""></option>
                                <option <?php mark_selected($utente->preferred_lang, CH_LANG_EN) ?> value="<?php echo CH_LANG_EN ?>"><?php echo lang('common_words_english') ?></option>
                                <option <?php mark_selected($utente->preferred_lang, CH_LANG_IT) ?> value="<?php echo CH_LANG_IT ?>"><?php echo lang('common_words_italian') ?></option>
                            </select>
                        </div>
                        <div class="large-4 columns" tabindex="6">
                            <label>Sede</label>
                            <select id="utenti-id_sede" name="utenti-id_sede">
                                <option value=""> --- </option>
                                <?php foreach ($sedi as $k => $sede): ?>
                                <option value="<?php echo $sede->id ?>"><?php echo $sede->stock_description ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <fieldset>
                        <legend><?php echo lang('user_assigned_groups_label') ?></legend>
                        <ul class="large-block-grid-4">
                            <?php foreach ($gruppi as $gruppo) { ?>
    <?php $checked = "";
    if (in_array($gruppo->group_id, $utente->groups)) $checked = 'checked'; ?>
                                <li>
                                    <div class="row">
                                        <div class="large-4 columns switch small">
                                            <input id="group_switch_<?php echo $gruppo->group_id ?>"  name="utenti-gruppi[]" class="utenti-gruppi" <?php echo $checked ?> value="<?php echo $gruppo->group_id ?>" type="checkbox">
                                            <label for="group_switch_<?php echo $gruppo->group_id ?>"></label>
                                        </div> 
                                        <div class="large-8 columns">
                                            <label><?php echo $gruppo->name ?>&nbsp;<i title="<?php echo $gruppo->description ?>" class="has-tip tip-bottom noradius fa fa-lg fa-info-circle"></i></label>
                                        </div>
                                    </div>
                                    <!--<input type="checkbox" name="utenti-gruppi[]" class="utenti-gruppi" <?php echo $checked ?> value="<?php echo $gruppo->group_id ?>">&nbsp;<?php echo $gruppo->name ?>&nbsp;<i title="<?php echo $gruppo->description ?>" class="has-tip tip-bottom noradius fa fa-lg fa-info-circle"></i></li>-->
<?php } ?>
                        </ul>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<script>var page = "modifica_utente";</script>