<div id="clients-panel" class="row">
    <div class="large-12 columns large-centered">	
        <dl class="tabs" data-tab>
            <dd class="active"><a href="#"><?php echo lang('client_clients_label') ?></a></dd>
        </dl>
        <div class="tabs-content">
            <div class="active content">
                <ul class="inline-list">
                    <li><a href="<?php print_url(CH_URL_MAIN) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                    <li><a href="<?php print_url(CH_URL_CLIENTS . "/new_client") ?>" title="<?php echo lang('client_add_client_label') ?>"><i class="fa fa-fw fa-lg fa-plus"></i></a></li>
                    <li><a class="btn-client-edit" href="<?php print_url(CH_URL_CLIENTS . "/edit_client") ?>" title="<?php echo lang('client_edit_selected_client_label') ?>"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
                    <li><a class="btn-new-repair" href="#" title="Nuovo intervento"><i class="fa fa-fw fa-lg fa-briefcase"></i></a></li>
                </ul>
                <br><br>
                <form id="form-clients-list" method="post" >
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 10px !important;">&nbsp;</th>
                                <th>Nominativo</th>
                                <th>Codice Fiscale/P IVA</th>
                                <th>Recapito 1</th>
                                <th>Recapito 2</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script>var page = 'clients';</script>