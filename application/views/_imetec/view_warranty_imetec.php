<ul class="inline-list">
   <li><a href="<?php print_url(CH_URL_INTERVENTIONS) ?>" title="Indietro"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
   <li><a class="btn_save" href="#" title="Salva dati garanzia"><i class="fa fa-fw fa-lg fa-save"></i></a></li>
</ul>
<fieldset>
   <legend>Garanzia Imetec</legend>
   <form class="custom condensed-form" method="post" action="#">
      <div class="row">
         <div class="large-3 columns">
            <span class="bold">Modello</span>
            <input type="text" name="warranty_model" id="warranty_model" value="<?php echo $intervention->model ?>" required="">
         </div>
         <div class="large-3 columns">
            <span class="bold">Type</span>
            <input type="text" name="warranty_type" id="warranty_type" value="<?php echo $intervention->extra_data['type']->codice_tipo ?>" required="">
         </div>
         <div class="large-3 columns">
            <span class="bold">Data produzione</span>
            <select data-customforms="disabled" class="expand" name="warranty_production_date" id="warranty_production_date" required="">
               <option value=""> --- </option>
               <?php foreach ($intervention->extra_data['date_produzione'] as $k => $data): ?>
                  <option value="<?php echo $data->data_produzione ?>"><?php echo $data->data_produzione ?></option>
               <?php endforeach; ?>
            </select>
         </div>
         <div class="large-3 columns">
            <span class="bold">Rip/Sost</span>
            <input style="width: 90%;" type="text" name="warranty_repaired_replaced" id="warranty_repaired_replaced" value="<?php echo $intervention->extra_data['listino']->riparabile_sostituibile ?>" required="">
         </div>
      </div>
      <div class="row">
         <div class="large-3 columns">
            <span class="bold">Mod. sostitutivo</span>
            <select data-customforms="disabled" class="expand" name="warranty_replacement_product_code" id="warranty_replacement_product_code">
               <option value=""> --- </option>
               <?php foreach ($intervention->extra_data['distinta_base'] as $g => $distinta): ?>
               <option value="<?php echo $distinta->codice_articolo_ricambio ?>"><?php echo $distinta->codice_articolo_ricambio ?></option>
               <?php endforeach; ?>
            </select>
         </div>
      </div>
      <div class="row" style="margin-top: 20px;">
         <div class="large-12 columns">
            <div style="width: 100%; padding-left: 10px; padding-right: 10px; background-color: #fff8dc; height: 150px; overflow-y: scroll;">
            <table id="table_ricambi">
               <caption style="text-align: left; padding-left: 5px; font-size: smaller;">Inserimento ricambi per garanzia</caption>
               <thead>
                  <tr>
                     <th>Codice</th>
                     <th>Quantità</th>
                     <th>Descrizione</th>
                     <th style="width: 40px;"></th>
                  </tr>
               </thead>
               <tbody style="height: 50px;" id="body_table_ricambi">
                  <tr>
                     <td colspan="4">Non ci sono ricambi inseriti</td>
                  </tr>
               </tbody>
            </table>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="large-12 columns">
            <table style="margin-top: 10px;">
               <tr>
                  <td style="padding-left: 2px;"><input type="text" placeholder="Codice" id="codice_ricambio" style="width: 95%;"></td>
                  <td style="padding-left: 2px;"><input type="text" placeholder="Qunatità" id="quantita_ricambio" style="width: 95%;"></td>
                  <td style="padding-left: 2px;"><input type="text" placeholder="Descrizione" id="descrizione_ricambio" style="width: 95%;"></td>
                  <td style="width: 40px; text-align: center;"><a href="#" class="add_costo_materiali"><i class="fa fa-fw fa-lg fa-plus-circle"></i></a></td>
               </tr>
            </table>
         </div>
      </div>
      <div class="hide">
         <input type="text" name="warranty_id_intervention" id="warranty_id_intervention" value="<?php echo $intervention->id ?>">
      </div>
   </form>
</fieldset>

