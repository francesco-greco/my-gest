<?php
   function get_view_for_brand($brand_code){
      if($brand_code == Brands_DTO::BRAND_IMETEC){
         return "views/_imetec/view_modelli_imetec.php";
      }
   }
   
   function get_warranty_view_for_brand($brand_code){
      if($brand_code == Brands_DTO::BRAND_IMETEC){
         return "views/_imetec/view_warranty_imetec.php";
      }
   }
?>
<div id="intervention_page" style="margin-top: 30px;">
   <input type="hidden" id="id_intervention" value="<?php echo $intervention->id ?>">
   <input type="hidden" id="intervention_status" value="<?php echo $intervention->status ?>">
   <div class="row">
      <div class="large-9 columns text-center" style="height: 100%;">
         <dl class="tabs" data-tab>
            <dd class="active"><a href="#cliente">Dati Cliente</a></dd>
            <dd class=""><a href="#intervento">Dati intervento</a></dd>
            <dd class=""><a href="#modello">Dati modello</a></dd>
            <?php if ($intervention->warranty_yes == Intervention_DTO::WARRENTY_YES): ?>
            <dd class=""><a href="#warranty">Dati per garanzia</a></dd>
            <?php endif; ?>
         </dl>
         <div class="tabs-content">
            <br>
            <h4 class="my-title">Riparazione <?php echo $intervention->intervention_code . " Numero ingressi precedenti: " . $serial_count ?><a href="#" title="<?php echo $intervention->status == Intervention_DTO::STATUS_CLOSED ? "Riparazione chiusa" : "Riparazione in corso" ?>"><i class="fa fa-fw fa-lg <?php echo $intervention->status == Intervention_DTO::STATUS_CLOSED ? "fa-lock" : "fa-unlock-alt" ?>"></i></a></h4>
            <hr>
            <div id="cliente" class="active content">
               <fieldset>
                  <legend>Dati cliente</legend>
                  <table>
                     <thead>
                        <tr>
                           <th>Nome Intero</th>
                           <th>Telefono 1</th>
                           <th>Telefono 2</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td><?php echo $intervention->client->fullname ?></td>
                           <td><?php echo $intervention->client->phone_1 ?></td>
                           <td><?php echo $intervention->client->phone_2 ?></td>
                        </tr>
                        <tr>
                           <td style="background-color: #008cba; color: white; font-weight: bold; font-size: 1.0rem;">Città</td>
                           <td style="background-color: #008cba; color: white; font-weight: bold; font-size: 1.0rem;">Provincia</td>
                           <td style="background-color: #008cba; color: white; font-weight: bold; font-size: 1.0rem;">Cap</td>
                        </tr>
                        <tr>
                           <td><?php echo $intervention->client->city ?></td>
                           <td><?php echo $intervention->client->provincia ?></td>
                           <td><?php echo $intervention->client->cap ?></td>
                        </tr>
                     </tbody>
                  </table>
               </fieldset>
            </div>
            <div id="intervento" class="content">
               <ul class="inline-list">
                  <li><a href="<?php print_url(CH_URL_INTERVENTIONS) ?>" title="Indietro"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                  <!--<li><a href="<?php print_url("files/codici_iris.xlsx") ?>" title="Consulta codici Iris"><i class="fa fa-fw fa-lg fa-edit"></i></a></li>-->
                  <?php if ($intervention->status != Intervention_DTO::STATUS_CLOSED): ?>
                     <li><a class="btn_stampa_ricevuta" href="#" title="Ricevuta ingresso"><i class="fa fa-fw fa-lg fa-print"></i></a></li>
                     <?php if($intervention->warranty_yes === Intervention_DTO::WARRENTY_NO): ?>
                     <li><a class="btn_costi" href="#" title="Inserisci costi riparazione"><i class="fa fa-fw fa-lg fa-briefcase"></i></a></li>
                     <?php endif; ?>
                  <?php endif; ?>
               </ul>
               <div class="row table_list_container left-intervention">
                  <fieldset>
                     <legend>Dati riparazione</legend>
                     <table>
                        <thead>
                           <tr>
                              <th style="text-align: center;">Categoria prodotto</th>
                              <td style="text-align: center;"><?php echo $intervention->category->categoria ?></td>
                              <th style="text-align: center;">Garanzia</th>
                              <td style="text-align: center;">
                                 <select name="intervento_warranty_yes" id="intervento_warranty_yes">
                                    <option value="<?php echo Intervention_DTO::WARRENTY_YES ?>" <?php mark_selected($intervention->warranty_yes, Intervention_DTO::WARRENTY_YES) ?>>SI</option>
                                    <option value="<?php echo Intervention_DTO::WARRENTY_NO ?>" <?php mark_selected($intervention->warranty_yes, Intervention_DTO::WARRENTY_NO) ?>>NO</option>
                                 </select>
                              </td>
                           </tr>
                        </thead>
                     </table>
                     <table style="margin-top: -15px !important;">
                        <thead>
                           <tr>
                              <th style="text-align: center;">Data ingresso</th>
                              <td><?php echo db_to_normal_timestamp($intervention->creation_date) ?></td>
                              <th style="text-align: center;">Consegna prevista</th>
                              <td><?php echo db_to_normal_date($intervention->purchase_date) ?></td>
                           </tr>
                        </thead>
                     </table>
                     <table style="margin-top: -15px !important;">
                        <thead>
                           <tr>
                              <th style="text-align: center; width: 70px;">Marca</th>
                              <td><?php echo $intervention->brand->brand_name ?></td>
                              <th style="text-align: center; width: 80px;">Modello</th>
                              <td><?php echo $intervention->model ?></td>
                              <th style="text-align: center; width: 80px;">N. serie</th>
                              <td><?php echo $intervention->serial_number ?></td>
                           </tr>
                           <tr>
                              <th style="text-align: center;">Guasto</th>
                              <td colspan="5"><p style="text-align: justify"><?php echo $intervention->description ?></p></td>
                           </tr>
                           <tr>
                              <th style="text-align: center;">Note</th>
                              <td colspan="5"><p style="text-align: justify"><?php echo $intervention->product_entry_notes ?></p></td>
                           </tr>
                        </thead>
                     </table>
                  </fieldset>
                  <fieldset>
                     <legend>Stato di lavorazione</legend>
                     <table>
                        <tr>
                           <td class="text-center">
                              <div class="text-center processing_stage_label" style="font-size: 1.1rem; color: green; font-weight: bold;"></div>
                           </td>
                        </tr>
                     </table>
                  </fieldset>
               </div>
            </div>
            <div id="modello" class="content">
                <?php include_once APPPATH.get_view_for_brand($intervention->brand->brand_code); ?>
            </div>
            <?php if ($intervention->warranty_yes == Intervention_DTO::WARRENTY_YES): ?>
            <div id="warranty" class="content">
               <?php include_once APPPATH.get_warranty_view_for_brand($intervention->brand->brand_code); ?>
            </div>
            <?php endif; ?>
         </div>
      </div>
      <div class="large-3 columns text-center" style="height: 100%; position: relative; left: 100px;">
         <h4 class="my-title">Note operative</h4>
         <hr>
         <ul class="inline-list">
            <li><a href="#" class="btn-new-note" data-id-intervention="<?php echo $intervention->id ?>" title="Nuova nota operativa"><i class="fa fa-fw fa-lg fa-plus-square-o"></i></a></li>
            <li><a href="#" title="Stampa lista note"><i class="fa fa-fw fa-lg fa-print"></i></a></li>
            <?php if ($intervention->status == Intervention_DTO::STATUS_CLOSED): ?>
               <li><a href="#" class="btn-new-posthumous-note" data-id-intervention="<?php echo $intervention->id ?>" title="Nuova nota operativa postuma">Nota postuma</a></li>
            <?php endif; ?>
         </ul>
         <div class="row table_list_container">
            <div class="notes_container" style="width: 100%; padding-left: 10px; padding-right: 10px; background-color: #fff8dc; height: 600px; overflow-y: scroll;">

            </div>
         </div>
      </div>
   </div>
</div>
<script>
   var page = 'intervention_page';
</script>