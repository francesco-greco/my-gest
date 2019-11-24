<div id="clients-panel" class="row">
    <div class="large-12 columns large-centered">	
        <dl class="tabs" data-tab>
            <dd class="active">
                <a href="#">
                    <?php if ($client->fullname != '') : ?>
                        <?php echo $client->fullname ?>
                        <?php
                    else : echo lang('client_new_client_label');
                    endif;
                    ?>
                </a>
            </dd>
        </dl>
        <div class="tabs-content">
            <div class="active content">
                <ul class="inline-list">
                    <li><a href="<?php print_url(CH_URL_CLIENTS) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                    <li><a class="btn_save" href="#" title="<?php echo lang('common_words_save') ?>"><i class="fa fa-fw fa-lg fa-save"></i></a></li>
                    <?php if(isset($client) && $client->id != null): ?>
                    <li><a class="btn_new_intervention" href="#" data-id-client="<?php echo isset($client->id) ? $client->id : "" ?>" title="Nuova riparazione   "><i class="fa fa-fw fa-lg fa-plus"></i></a></li>
                    <?php endif; ?>
                    <li><a class="btn_send_activation_code" href="#" title="Invia comunicazione al cliente"><i class="fa fa-fw fa-lg fa-envelope-o"></i></a></li>
                </ul>
                <fieldset>
                    <legend>Dati cliente</legend>
                    <form id="form_client" class="custom-compact" method="post" action="<?php print_url(CH_URL_CLIENTS . '/save_client') ?>">
                        <input class="client_id" type="hidden" name="client_id" value="<?php echo isset($client->id) ? $client->id : "" ?>">
                        <div class="row">
                            <div class="large-4 columns">
                                <label for="client_surname"><?php echo lang('common_words_surname') ?></label>
                                <input id="client_surname" type="text" name="client_surname" value="<?php echo $client->surname ?>" tabindex="1" required="">
                            </div>
                            <div class="large-4 columns end">
                                <label for="client_name"><?php echo lang('common_words_name') ?></label>
                                <input id="client_name" type="text" name="client_name" value="<?php echo $client->name ?>" tabindex="2" required="">
                            </div>
                            <div class="large-4 columns">
                                <label for="client_fiscal_code">Codice Fiscale</label>
                                <input id="client_fiscal_code" type="text" name="client_fiscal_code" value="<?php echo $client->fiscal_code != null ? strtoupper($client->fiscal_code) : "" ?>" tabindex="3">
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-4 columns">
                                <label for="client_phone_1">Telefono 1</label>
                                <input id="client_phone_1" type="text" name="client_phone_1" value="<?php echo $client->phone_1 ?>" tabindex="4" required="">
                            </div>
                            <div class="large-4 columns">
                                <label for="client_phone_2">Telefono 2</label>
                                <input id="client_phone_2" type="text" name="client_phone_2" value="<?php echo $client->phone_2 ?>" tabindex="5">
                            </div>
                            <div class="large-4 columns">
                                <label for="client_email"><?php echo lang('common_words_email') ?> *</label>
                                <input id="client_email" type="email" name="client_email" value="<?php echo $client->email ?>"  tabindex="6">
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-4 columns">
                                <label for="client_address">Indirizzo</label>
                                <input id="client_address" type="text" name="client_address" value="<?php echo $client->address ?>" tabindex="7">
                            </div>
                            <div class="large-2 columns">
                                <label for="client_civic_number">Civico</label>
                                <input id="client_civic_number" type="text" name="client_civic_number" value="<?php echo $client->civic_number ?>" tabindex="8">
                            </div>
                            <div class="large-2 columns">
                                <label for="client_city">Città</label>
                                <input id="client_city" type="text" name="client_city" value="<?php echo $client->city ?>" required tabindex="9">
                            </div>
                            <div class="large-2 columns">
                                <label for="client_provincia">Provincia</label>
                                <input id="client_provincia" type="text" name="client_provincia" value="<?php echo $client->provincia ?>" required tabindex="10">
                            </div>
                            <div class="large-2 columns">
                                <label for="client_cap">CAP</label>
                                <input id="client_cap" type="text" name="client_cap" value="<?php echo $client->cap ?>" required tabindex="11">
                            </div>
                        </div>
                    </form>
                </fieldset>
                <?php if(isset($client) && $client->id != null && $storico != FALSE): ?>
                <fieldset>
                    <legend>Storico Riparazioni</legend>
                    <?php if(isset($storico) && count($storico) != 0): ?>
                    <div style="overflow-y: scroll; width: 100%; height: 300px; border: 1px solid black;">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Cod. Riparazione</th>
                                            <th>Prodotto</th>
                                            <th>Data riparazione</th>
                                            <th>Numero seriale</th>
                                            <th>Garanzia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($storico as $k => $riga): ?>
                                        <tr>
                                            <td><?php echo $riga->intervention_code ?></td>
                                            <td><?php echo $riga->object_description ?></td>
                                            <td><?php echo db_to_normal_timestamp($riga->creation_date) ?></td>
                                            <td><?php echo $riga->serial_number ?></td>
                                            <td><?php echo $riga->warranty_yes == Intervention_DTO::SELECTED_YES ? "SI" : "NO" ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                    <?php // else: ?>
                    <!--<i>Il cliente non ha mai effettuato riparazioni presso i nostri centri</i>-->
                    <?php endif; ?>
                </fieldset>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>var page = "edit_client";</script>