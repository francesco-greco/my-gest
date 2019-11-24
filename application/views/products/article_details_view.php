<style>
   #article_details_view .highlight td{background: teal !important; color: white;}
   #article_details_view .highlight0 td{background: cornflowerblue !important; color: white;}
</style>
<div  id="article_details_view" class="ch_canvas" style="margin-top: 30px;">
   <div class="row">
      <ul class="inline-list">
      <li><a href="<?php print_url(CH_URL_PRODUCTS."/show_articoli_view") ?>" title="Indietro"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
      <li><a class="btn_print" href="<?php print_url(CH_URL_PRODUCTS."/stampa/$listino->id") ?>" target="_blank" title="Gestisci articolo"><i class="fa fa-fw fa-lg fa-print"></i></a></li>
   </ul>
      <table class="head_table">
         <td style="width: 120px;"><?php echo $listino->brand->brand_name ?></td>
         <td style="width: 120px;"><?php echo $listino->codice ?></td>
         <td><p><?php echo $listino->descrizione ?></p></td>
         <td style="width: 160px;"><?php echo $this->bitauth->city." ".date('d/m/Y') ?></td>
      </table>
   </div>
   <div class="row">
      <table class="article_details">
         <thead>
         <tr>
            <th>Sede</th>
            <th>Cod. magazzino</th>
            <th>magazzino</th>
            <th>Quantità</th>
            <th>Ubicazione</th>
            <th>In preventivo</th>
            <th>Scorta minima</th>
            <th>In ordine</th>
         </tr>
         </thead>
         <?php $tot = 0; $tot_q = 0; ?>
         <?php foreach ($dettagli as $k => $row): ?>
         <tr class="<?php echo $row->id_sede == $this->bitauth->id_sede ? "highlight" : "" ?><?php echo $row->codice_magazzino == 'STG' ? "highlight0" : "" ?>">
            <td><?php echo $row->sede ?></td>
            <td><?php echo $row->codice_magazzino ?></td>
            <td><?php echo $row->nome_magazzino ?></td>
            <td class="text-center"><?php echo $row->quantita ?></td>
            <td class="text-center"><?php echo $row->ubicazioni ?></td>
            <td class="text-center">0</td>
            <td class="text-center">0</td>
            <td class="text-center">0</td>
         </tr>
         <?php $tot += $row->quantita ?>
         <?php endforeach; ?>
         <tr>
            <th colspan="3" class="text-center">Totale</th>
            <td class="text-center"><?php echo $tot ?></td>
            <td style="background: gray;" class="text-center"></td>
            <td class="text-center">0</td>
            <td class="text-center">0</td>
            <td class="text-center">0</td>
         </tr>
      </table>
   </div>
   <div class="row">
      <table class="listino_details">
         <tr>
            <th style="background: #008cba; color: white;">Costo</th>
            <td style="text-align: center;">€. <?php echo $listino->prezzo_acquisto ?></td>
            <th style="background: #008cba; color: white;">Prezzo al pubblico</th>
            <td style="text-align: center;">€. <?php echo $listino->prezzo_pubblico_1 ?></td>
            <th style="background: #008cba; color: white;">Prezzo Rivenditore</th>
            <td style="text-align: center;">€. <?php echo $listino->prezzo_rivenditore ?></td>
            <th style="background: #008cba; color: white;">Rifatturazione</th>
            <td style="text-align: center;">€. <?php echo $listino->prezzo_rifatturazione ?></td>
         </tr>
      </table>
   </div>
</div>
