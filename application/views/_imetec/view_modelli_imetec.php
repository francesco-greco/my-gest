<fieldset>
   <legend><?php echo $intervention->brand->brand_name ?></legend>
   <table>
      <thead>
         <tr>
            <th style="width: 120px; text-align: center;">Modello</th>
            <td><?php echo $intervention->extra_data != FALSE && $intervention->extra_data['listino'] != FALSE ? $intervention->extra_data['listino']->modello : "Modello non identificato!" ?></td>
            <th style="width: 120px; text-align: center;">Type</th>
            <td><?php echo $intervention->extra_data != FALSE && $intervention->extra_data['type'] != FALSE ? $intervention->extra_data['type']->codice_tipo : "ND" ?></td>
         </tr>
      </thead>
   </table>
   <table>
      <thead>
         <tr>
            <th style="width: 120px; text-align: center;">Descrizione</th>
            <td><?php echo $intervention->extra_data != FALSE && $intervention->extra_data['type'] != FALSE ? $intervention->extra_data['type']->descrizione_tipo : "ND" ?></td>
         </tr>
      </thead>
   </table>
   <table>
      <thead>
         <tr>
            <th style="width: 180px; text-align: center;">Prod. finito/ricambio</th>
            <td style="text-align: center;"><?php echo $intervention->extra_data != FALSE && $intervention->extra_data['listino'] != FALSE ? $intervention->extra_data['listino']->prodotto_finito_ricambio : "ND" ?></td>
            <th style="width: 180px; text-align: center;">Riparabile/Sostituibile</th>
            <td style="text-align: center;"><?php echo $intervention->extra_data != FALSE && $intervention->extra_data['listino'] != FALSE ? $intervention->extra_data['listino']->riparabile_sostituibile : "ND" ?></td>
            <th style="width: 70px; text-align: center;">Critico</th>
            <td style="text-align: center;"><?php echo $intervention->extra_data != FALSE && $intervention->extra_data['listino'] != FALSE ? $intervention->extra_data['listino']->prodotto_critico : "ND" ?></td>
            <th style="width: 100px; text-align: center;">Ordinabile</th>
            <td style="text-align: center;"><?php echo $intervention->extra_data != FALSE && $intervention->extra_data['listino'] != FALSE ? $intervention->extra_data['listino']->ordinabile : "ND" ?></td>
         </tr>
      </thead>
   </table>
   <table>
      <thead>
         <tr>
            <th style="width: 200px; text-align: center;">Descrizione aggiuntiva</th>
            <td style="text-align: left;"><?php echo $intervention->extra_data != FALSE && $intervention->extra_data['dati_extra_listino'] != FALSE ? $intervention->extra_data['dati_extra_listino']->descrizione_aggiuntiva : "ND" ?></td>
         </tr>
      </thead>
   </table>
   <div class="sale-container">
      <dl class="accordion" data-accordion>
         <dd> <a href="#panel1">Date di produzione valide</a> 
            <div id="panel1" class="content" style="overflow-y: scroll; height: 250px; border: 1px solid black;">
               <table>
                  <thead>
                     <tr>
                        <th style="text-align: center;">N. settimana</th>
                        <th style="text-align: center;">Anno</th>
                     </tr>
                  </thead>
                  <?php if ($intervention->extra_data != FALSE && $intervention->extra_data['dati_extra_listino'] != FALSE): ?>
                     <?php foreach ($intervention->extra_data['date_produzione'] as $k => $line): ?>
                  <tr>
                     <td style="text-align: center;"><?php echo substr($line->data_produzione,0,2) ?></td>
                     <td style="text-align: center;"><?php echo substr($line->data_produzione,2,4) ?></td>
                  </tr>
                     <?php endforeach; ?>
                  <?php else: ?>
                  <tr>
                     <td colspan="2">ND</td>
                  </tr>
                  <?php endif; ?>
               </table>
            </div> 
         </dd> 
         <dd style="margin-top: 20px; padding-bottom: 30px;"> 
            <a href="#panel2">Dati distinta base</a> 
            <div id="panel2" class="content">
               <?php if ($intervention->extra_data != FALSE && $intervention->extra_data['distinta_base'] != FALSE): ?>
               <table>
                  <thead>
                     <tr>
                        <th style="text-align: center;">Codice ricambio</th>
                        <th style="text-align: center;">Codice esploso</th>
                        <th style="text-align: center;">Posizione esploso</th>
                        <th style="text-align: center;">Data inizio validità</th>
                     </tr>
                     <?php foreach ($intervention->extra_data['distinta_base'] as $k => $dist): ?>
                     <tr>
                        <td style="text-align: center;"><?php echo $dist->codice_articolo_ricambio ?></td>
                        <td style="text-align: center;"><?php echo $dist->codice_esploso ?></td>
                        <td style="text-align: center;"><?php echo $dist->posizione_esploso != null ? $dist->posizione_esploso : "ND"; ?></td>
                        <td style="text-align: center;"><?php echo $dist->data_inizio_validita != null ? db_to_normal_date($dist->data_inizio_validita) : "ND"; ?></td>
                     </tr>
                     <?php endforeach; ?>
                  </thead>
               </table>
               <?php endif; ?>
            </div> 
         </dd> 
      </dl>
   </div> 
</fieldset>

