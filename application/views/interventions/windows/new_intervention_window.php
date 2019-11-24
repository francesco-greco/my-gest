<div id="new_intervention_window" style="width: 900px; background: #fffff0">
    <h3>Nuovo intervento</h3>
    <form method="post" action="<?php print_url(CH_URL_INTERVENTIONS . "/create_intervention") ?>" id="form_intervention" class="custom-compact">
        <input type="hidden" name="intervento_id_client" value="<?php echo $id_client ?>">
        <input type="hidden" name="intervento_id_processing_stage" value="<?php echo $start_stage->id ?>">
        <fieldset>
            <legend>Dati Prodotto</legend>
            <div class="row">
               <div class="large-3 columns end">
                  <label class="bold" for="intervento_id_categoria">Categoria*</label>
                  <select id="intervento_id_categoria" name="intervento_id_categoria" required="">
                     <option value=""> --- </option>
                     <?php foreach ($categorie as $k => $categoria): ?>
                     <option value="<?php echo $categoria->id ?>"><?php echo $categoria->categoria ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="row">
                <div class="large-3 columns">
                    <label class="bold" for="intervento_id_brand">Marca*</label>
                    <select name="intervento_id_brand" required>
                        <option value=""> --- </option>
                        <?php foreach ($brands_list as $brand): ?>
                            <option value="<?php echo $brand->id ?>"><?php echo $brand->brand_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="large-3 columns">
                    <label class="bold" for="intervento_model">Modello</label>
                    <input type="text" id="intervento_model" name="intervento_model">
                </div>
                <div class="large-3 columns">
                    <label class="bold" for="intervento_serial_number">Numero di serie</label>
                    <input type="text" id="intervento_serial_number" name="intervento_serial_number">
                </div>
                <div class="large-3 columns">
                    <label class="bold" for="intervento_object_description">Definizione oggetto*</label>
                    <input type="text" id="intervento_object_description" name="intervento_object_description" required>
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns">
                    <label class="bold" for="intervento_purchase_date">Data acquisto</label>
                    <input class="dataP" type="text" id="intervento_purchase_date" name="intervento_purchase_date">
                </div>
                <div class="large-3 columns">
                    <label class="bold" for="intervento_warranty_yes">Garanzia*</label>
                    <select name="intervento_warranty_yes" required="">
                        <option value=""> --- </option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="large-3 columns">
                    <label class="bold" for="intervento_receipt_present">Scontrino</label>
                    <select name="intervento_receipt_present">
                        <option value=""> --- </option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="large-3 columns">
                    <label class="bold" for="intervento_previous_failures">Guasti precedenti</label>
                    <select name="intervento_previous_failures">
                        <option value=""> --- </option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Dati Riparazione</legend>
            <div class="row">
                <div class="large-2 columns">
                    <label class="bold" for="intervento_price_quotation">Preventivo*</label>
                    <select name="intervento_price_quotation" required="">
                        <option value=""> --- </option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="large-2 columns">
                    <label class="bold" for="intervento_deposit">Cauzione €.*</label>
                    <select name="intervento_deposit">
                        <option value=""> --- </option>
                        <option value="10">€ 10,00</option>
                        <option value="20">€ 20,00</option>
                        <option value="30">€ 30,00</option>
                        <option value="40">€ 40,00</option>
                    </select>
                </div>
                <div class="large-2 columns">
                    <label class="bold" for="intervento_spending_limit">Limite spesa</label>
                    <select name="intervento_spending_limit">
                        <option value=""> --- </option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="large-3 columns ">
                    <label class="bold" for="intervento_spending_limit_amount">Limite di spesa €.</label>
                    <select name="intervento_spending_limit_amount">
                        <option value=""> --- </option>
                        <option value="50">€. 50,00</option>
                        <option value="100">€. 100,00</option>
                        <option value="120">€. 120,00</option>
                    </select>
                </div>
                <div class="large-3 columns">
                    <label class="bold" for="intervento_expected_delivery_date">Presunta Consegna*</label>
                    <input class="dataP" type="text" id="intervento_expected_delivery_date" name="intervento_expected_delivery_date" required="">
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label class="bold" for="intervento_description">Guasto dichiarato*</label>
                    <textarea style="height: 60px;" id="intervento_description" name="intervento_description" required=""></textarea>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label class="bold" for="intervento_description">Note ingresso prodotto*</label>
                    <textarea style="height: 60px;" id="intervento_product_entry_notes" name="intervento_product_entry_notes" required=""></textarea>
                </div>
            </div>
        </fieldset>
        <hr>
        <div class="row">
            <div class="large-10 columns"></div>
            <div class="large-2 columns text-right" style="padding: 0px;">
                <a href="#" class="button radius btn-create-intervention"><i class="fa fa-fw fa-lg fa-save"></i></a>
            </div>
        </div>
    </form>
</div>