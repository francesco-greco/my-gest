<style>
   html {  width: 100%; }
   hr { margin-top: 10px; background: #000000; border: 0; height: 1.8px; }
   table.bordered { border-collapse: collapse; }
table.bordered td, table.bordered th { border: 1px solid black; padding-left: 5px; padding-right: 5px; height: 0.7cm; }
   .body_container { width: 100%; font-family: 'Tahoma'; color: #232; }
   .logo_container .sx_container {margin:0; padding:0; width:150px; background:transparent; float:left;}
   .logo_container .dx_container {margin:0; padding:0; width:150px; background:transparent; float:right; text-align:right; margin-right: 0px}
   .message_container tr, .message_container td, .message_container {text-align: justify; font-size: 12.2px;}
   .sign_container {margin:0; padding:0; width:200px; background:transparent; float:right; text-align:center; margin-right: 0px}
   .message_footer_container { position: absolute; bottom: 55px; text-align: justify; font-size: 10px; width: 85%;}
</style>
<div class="body_container">
   <hr style='background: #EEEEEE; margin-top: 20px;' />
   <div class='logo_container' style='width: 100%;'>
      <!--<div class='sx_container'><img style='width: 150px;' alt='Logo Russo Ferdinando' src='<?php print_url('images/logo_moduli.png') ?>' /></div>-->
      <div class='sx_container'><img style='width: 150px;' alt='Logo Russo Ferdinando' src='images/logo_moduli.png' /></div>
   </div>
   <hr style='background: #EEEEEE; margin-top:5px;' /><br><br>
   <table style="width: 100%;"><tr><th style="text-align: center; font-size: 18px;">SITUAZIONE ARTICOLO <?php echo $brand_name . " Cod." . $codice ?></th></tr></table>
   <br><br>
   <table class="article_details bordered" style="width: 100%;">
         <tr>
            <th>Sede</th>
            <th style="width: 150px;">Magazzino</th>
            <th>Cod. magazzino</th>
            <th>Quantità</th>
            <th>Ubicazione</th>
            <th>In preventivo</th>
            <th>Scorta minima</th>
            <th>In ordine</th>
         </tr>
         <?php $tot = 0 ?>
         <?php foreach ($dettagli as $k => $art): ?>
         <tr class="<?php echo $art->id_sede == $this->bitauth->id_sede ? "highlight" : "" ?>">
            <td><?php echo $art->sede ?></td>
            <td><?php echo $art->nome_magazzino ?></td>
            <td><?php echo $art->codice_magazzino ?></td>
            <td class="text-center"><?php echo $art->quantita ?></td>
            <td class="text-center"><?php echo $art->ubicazioni ?></td>
            <td class="text-center">0</td>
            <?php $tot += $art->quantita ?>
            <td class="text-center">0</td>
            <td class="text-center">0</td>
         </tr>
         <?php endforeach; ?>
         <tr>
            <th colspan="3" class="text-center">Totale</th>
            <td class="text-center"><?php echo $tot ?></td>
            <td style="background: gray;" class="text-center"></td>
            <td class="text-center">0</td>
            <td class="text-center">0</td>
            <td class="text-center">0</td>
         </tr>
   </table><br><br>
   <div class="row">
      <table class="listino_details bordered" style="width: 100%;">
         <tr>
            <th style="background: #008cba; color: white;">Costo</th>
            <td style="text-align: center;">€. <?php echo $listino->prezzo_acquisto ?></td>
            <th style="background: #008cba; color: white;">Prezzo 1</th>
            <td style="text-align: center;">€. <?php echo $listino->prezzo_pubblico_1 ?></td>
            <th style="background: #008cba; color: white;">Prezzo rivenditore</th>
            <td style="text-align: center;">€. <?php echo $listino->prezzo_rivenditore ?></td>
            <th style="background: #008cba; color: white;">Rifatturazione</th>
            <td style="text-align: center;">€. <?php echo $listino->prezzo_rifatturazione ?></td>
         </tr>
      </table>
   </div>
</div>
<div class='message_footer_container'>
   <p style="text-align: center; margin-top: 10px;"><b>Russo Ferdinando Assistenza Tecnica Autorizzata P.IVA 03751490826</b></p>
</div>
