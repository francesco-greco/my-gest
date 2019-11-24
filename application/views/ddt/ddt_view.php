<div  id="ddt_page" class="row" style="margin-top: 30px;">
   <h3 class="text-center"><b>Documento di Trasporto<b></h3>
            <hr>
            <div class="row">
               <ul class="inline-list">
                  <li><a href="<?php print_url(CH_URL_DDT."/ddt_list_page") ?>" title="Indietro"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                  <?php if($ddt->stato == Ddt_DTO::STATO_APERTO): ?>
                  <li><a class="btn_save" href="#" title="Salva"><i class="fa fa-fw fa-lg fa-save"></i></a></li>
                  <li><a class="btn_close" href="#" title="Registra DDT"><i class="fa fa-fw fa-lg fa-key"></i></a></li>
                  <?php endif; ?>
               </ul>
            </div>
            <form class="custom condensed-form" method="post" id="form_save_ddt" action="<?php print_url(CH_URL_DDT."/save_ddt") ?>">
            <fieldset>
               <legend>Dati Fornitore e documento</legend>
               <div class="row">
                  <div class="large-6 columns">
                     <label class="bold">Ragione sociale</label>
                     <input type="text" value="<?php if (isset($ddt)) echo $ddt->fornitore->ragione_sociale ?>">
                  </div>
                  <div class="large-3 columns">
                     <label class="bold">P. IVA</label>
                     <input type="text" value="<?php if (isset($ddt)) echo $ddt->fornitore->p_iva ?>">
                  </div>
                  <div class="large-3 columns">
                     <label class="bold">Cod. fiscale</label>
                     <input type="text" value="<?php if (isset($ddt)) echo $ddt->fornitore->codice_fiscale ?>">
                  </div>
               </div>
               <div class="row">
                  <div class="large-6 columns">
                     <label class="bold">Indirizzo</label>
                     <input type="text" value="<?php if (isset($ddt)) echo $ddt->fornitore->indirizzo." ".$ddt->fornitore->numero_civico." ".$ddt->fornitore->citta." (".$ddt->fornitore->provincia.") ".$ddt->fornitore->cap ?>">
                  </div>
                  <div class="large-3 columns">
                     <label class="bold">Referente</label>
                     <input type="text" value="<?php if (isset($ddt)) echo $ddt->fornitore->referente ?>">
                  </div>
                  <div class="large-3 columns">
                     <label class="bold">Recapito Ref.</label>
                     <input type="text" value="<?php if (isset($ddt)) echo $ddt->fornitore->referente_recapito ?>">
                  </div>
               </div>
               <div class="row">
                  <div class="large-3 columns">
                     <label class="bold">Data documento*</label>
                     <input type="text" required="" class="dataP" name="ddt_data_documento" id="ddt_data_documento" value="<?php if (isset($ddt)) echo $ddt->data_documento ?>">
                  </div>
                  <div class="large-3 columns">
                     <label class="bold">Numero documento*</label>
                     <input type="text" required="" name="ddt_numero_documento" id="ddt_numero_documento" value="<?php if (isset($ddt)) echo $ddt->numero_documento ?>">
                  </div>
                  <div class="large-3 columns">
                     <label class="bold">Numero colli*</label>
                     <input type="number" required="" name="ddt_numero_colli" id="ddt_numero_colli" value="<?php if (isset($ddt)) echo $ddt->numero_colli ?>">
                  </div>
                  <div class="large-3 columns">
                     <label class="bold">Peso Kg.</label>
                     <input type="text" name="ddt_peso" id="ddt_peso" value="<?php if (isset($ddt)) echo $ddt->peso ?>">
                  </div>
               </div>
               <div class="row">
                  <div class="large-12 columns">
                     <label class="bold">Dati vettore</label>
                     <input type="text" name="ddt_vettore" id="ddt_vettore" value="<?php if (isset($ddt)) echo $ddt->vettore ?>">
                  </div>
               </div>
            </fieldset>
               <input type="hidden" id="ddt_id" name="ddt_id" value="<?php if (isset($ddt)) echo $ddt->id ?>">
            </form>
            <fieldset>
               <legend>Dettagli</legend>
               <div style="height: 150px; overflow-y: scroll">
               <table id="ddt_details" class="details_table">
                  <thead>
                     <tr>
                        <th style="width: 100px;">Brand</th>
                        <th style="width: 200px;">Codice Art.</th>
                        <th>Descrizione</th>
                        <th style="width: 60px;">U.m.</th>
                        <th style="width: 150px;">Quantità</th>
                        <th class="text-center" style="width: 50px;"></th>
                     </tr>
                  </thead>
                  <tbody id="ddt_details_body"></tbody>
               </table>
               </div><br>
               <?php if($ddt->stato != Ddt_DTO::STATO_CHIUSO): ?>
               <table id="ddt_form_detail">
                  <thead>
                     <tr>
                        <th style="text-align: center; width: 200px;">Brand</th>
                        <th style="text-align: center; width: 200px;">Codice Art.</th>
                        <th>Descrizione</th>
                        <th style="text-align: center; width: 80px;">U.m.</th>
                        <th style="text-align: center; width: 150px;">Quantità</th>
                        <th class="text-center" style="width: 50px; text-align: center;"></th>
                     </tr>
                  </thead>
                  <tr>
                     <td>
                        <select name="dettaglio_id_brand" id="dettaglio_id_brand">
                           <option value=""> --- </option>
                           <?php foreach ($brands as $k => $brand): ?>
                              <option value="<?php echo $brand->id ?>"><?php echo $brand->brand_name ?></option>
                           <?php endforeach; ?>
                        </select>
                     </td>
                     <td>
                        <input type="text" name="dettaglio_codice_articolo" id="dettaglio_codice_articolo">
                     </td>
                     <td>
                        <input type="text" name="dettaglio_descrizione" id="dettaglio_descrizione">
                     </td>
                     <td>
                        <select name="dettaglio_unita_misura" id="dettaglio_unita_misura">
                           <option value=""> --- </option>
                           <?php foreach ($ums as $k => $um): ?>
                              <option value="<?php echo $um ?>"><?php echo $um ?></option>
                           <?php endforeach; ?>
                        </select>
                     </td>
                     <td>
                        <input type="text" name="dettaglio_quantita" id="dettaglio_quantita">
                     </td>
                     <td style="text-align: center; width: 40px;">
                        <a href="#" class="detail_save"><i class="fa fa-fw fa-lg fa-plus-circle"></i></a>
                     </td>
                  </tr>
               </table>
               <strong>NB: Selezionare il brand e eseguire la ricerca per codice o per descrizione dei prodotti da caricare.</strong>
               <?php endif; ?>
               <input type="hidden" id="ddt_stato" value="<?php echo $ddt->stato ?>">
            </fieldset>
            </div>
            <script>
               var page = 'ddt_view';
            </script>
