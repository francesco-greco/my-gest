<div id="new_costs_window" style="width: 800px; background: #fffff0">
<?php function render_model_cost($brand_code) {?>
   <div class="row">
      <div class="large-12 columns">
         <?php if($brand_code === Brands_DTO::BRAND_DELONGHI): ?>
         <?php endif; ?>
      </div>
   </div>
<?php } ?>
   <h3>Costi intervento <?php echo $is_warrenty === TRUE ? " In Garanzia" : " non in Garanzia" ?></h3>
   <hr>
   <dl class="tabs" data-tab>
      <dd class="active"><a href="#manodopera">Manodopera</a></dd>
      <dd class=""><a href="#materiali">Materiali</a></dd>
      <?php if ($is_warrenty === TRUE): ?>
      <dd class=""><a href="#cliente">Costi a carico del cliente</a></dd>
      <?php endif; ?>
   </dl>
   <div class="tabs-content">
      <div id="manodopera" class="active content">
         <div class="row">
            <div class="large-12 columns" style="padding-left: 0px;">
               <form method="post" action="#" id="manodopera_form" class="custom condensed-form">
                  <table id="table_manodopera">
                     <thead>
                        <tr>
                           <th style="width: 110px;">Ore lavoro</th>
                           <th>Descrizione</th>
                           <th style="width: 150px;">Costo</th>
                           <th style="width: 100px;">Totale</th>
                           <th style="text-align: center; width: 40px;"></th>
                        </tr>
                     </thead>
                     <tbody id="body_table_manodopera"></tbody>
                     <tfoot>
                        <tr>
                           <td>
                              <input <?php echo $is_warrenty == TRUE ? "disabled" : "" ?> min="1" type="number" name="costo_numero_ore" id="costo_numero_ore" placeholder="Numero ore" value="1">
                           </td>
                           <td>
                              <input type="text" name="costo_descrizione" id="costo_descrizione" placeholder="Descrizione">
                           </td>
                           <td>
                              <input type="text" name="costo_costo_ora" id="costo_costo_ora" placeholder="Costo in €. per ora">
                           </td>
                           <td>
                              <input type="text" name="costo_costo_totale" id="costo_costo_totale" placeholder="Totale">
                           </td>
                           <td style="text-align: center;">
                              <a href="#" id="add_costo_manodopera"><i class="fa fa-fw fa-lg fa-plus-circle"></i></a>
                           </td>
                        </tr>
                     </tfoot>
                  </table>
               </form>
            </div>
         </div>
         <?php render_model_cost($intervention->brand->brand_code); ?>
      </div>
      <div id="materiali" class="content">
         <div class="row">
            <div class="large-12 columns" style="padding-left: 0px;">
               <form method="post" action="#" class="custom condensed-form">
                  <table id="costo_materiali_table" class="details_table" style="width: 98.5%;">
                     <thead>
                        <tr>
                           <th style="width: 100px;">Brand</th>
                           <th style="width: 130px;">Codice Art.</th>
                           <th>Descrizione</th>
                           <th style="width: 70px;">U.m.</th>
                           <th style="width: 100px;">Quantità</th>
                           <th style="width: 80px;">Totale</th>
                           <th class="text-center" style="width: 50px;"></th>
                        </tr>
                     </thead>
                     <tbody id="costo_materiali_body"></tbody>
                     <tfoot>
                        <tr>
                           <td>
                              <input type="text" name="dettaglio_id_brand" id="dettaglio_id_brand" placeholder="Codice brand" disabled="" value="<?php echo $intervention->brand->brand_name ?>">
                           </td>
                           <td>
                              <input type="text" name="dettaglio_codice_articolo" id="dettaglio_codice_articolo" placeholder="Codice articolo">
                           </td>
                           <td>
                              <input type="text" name="dettaglio_descrizione" id="dettaglio_descrizione" placeholder="Descrizione">
                           </td>
                           <td>
                              <select class="expand" id="dettaglio_unita_misura" name="dettaglio_unita_misura">
                                 <option value=""> --- </option>
                                 <?php foreach ($um as $k => $u): ?>
                                    <option value="<?php echo $u ?>"><?php echo $k ?></option>
                                 <?php endforeach; ?>
                              </select>
                           </td>
                           <td>
                              <input type="text" name="dettaglio_quantita" id="dettaglio_quantita" placeholder="Quantità">
                           </td>
                           <td>
                              <input type="text" name="dettaglio_quantita" id="dettaglio_totale" placeholder="Totale">
                           </td>
                           <td style="text-align: center; width: 40px;">
                              <a href="#" class="add_costo_materiali"><i class="fa fa-fw fa-lg fa-plus-circle"></i></a>
                           </td>
                        </tr>
                     </tfoot>
                  </table>
               </form>
            </div>
         </div>
      </div>
      <?php if ($is_warrenty === TRUE): ?>
         <div id="cliente" class="content">
            <div class="row">
               test
            </div>
         </div>
      <?php endif; ?>
   </div>
</div>
