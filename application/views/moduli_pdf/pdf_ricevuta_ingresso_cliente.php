<style>
   html {  width: 100%; }
   hr { margin-top: 10px; background: #000000; border: 0; height: 1.8px; }

   .body_container { width: 100%; font-family: 'Tahoma'; color: #232; }
   .logo_container .sx_container {margin:0; padding:0; width:150px; background:transparent; float:left;}
   .logo_container .dx_container {margin:0; padding:0; width:320px; background:transparent; float:right; text-align:left; margin-right: 0px;  font-size: 11.5px;}
   .message_container tr, .message_container td, .message_container th, .message_container {text-align: justify; font-size: 11.5px;}
   .sign_container {margin:0; padding:0; width:200px; background:transparent; float:right; text-align:center; margin-right: 0px}
   .message_footer_container { position: absolute; bottom: 20px; text-align: justify; font-size: 11.5px; width: 85%;}
   table.small-font tr td{font-size: 10px;}
</style>
<div class="body_container">
   <!--<hr style='background: #EEEEEE; margin-top: 5px;' />-->
   <div class='logo_container' style='width: 100%;'>
      <div class='sx_container' style="padding-top: 10px;"><img style='width: 150px;' alt='Logo Russo' src='images/logo_moduli.png' /></div>
      <div class='dx_container'>
         <img style="height: 20px;" src="images/orologio-1.png"><b>Lunedi - Venerdi:</b> 09:00 - 13:00 e 15:30 - 18:30<br>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Sabato:</b> 09:00 - 12:00 <b><br>
            <img style="height: 30px;"  src="images/poi_little.jpg"><small>Via Francesco Lo Jacono, 3</b> 90100 - Palermo, PA</small><br>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Tel. 091-349610</small>
      </div>
   </div>
   <hr style='background: #EEEEEE; margin-top:5px;' /><br>
   <div class='message_container'>
      <table style="margin-top: 10px;">
         <tr>
            <th style="width: 70px;">DATA: </th>
            <td style='width: 130px;'><?php echo $data ?></td>
            <th style='text-align:left; width: 70px;'>CODICE:</th>
            <td style='width: 110px;'><strong><font style="font-size: 14px;"><?php echo $number ?></font></strong></td>
            <th style='width: 90px;'>TELEFONO 1:</th>
            <td><?php echo $telefono_1 ?></td>
         </tr>
         <tr>
            <th>CLIENTE: </th>
            <td><?php echo $cliente ?></td>
            <th>CITTA': </th>
            <td><?php echo $citta ?></td>
            <th>TELEFONO 2:</th>
            <td><?php echo $telefono_2 ?></td>
         </tr>
         <tr>
            <th>INDIRIZZO: </th>
            <td><?php echo $indirizzo ?></td>
            <th style='text-align:left;'>CAP: </th>
            <td style=''><?php echo $cap ?></td>
            <th>EMAIL:</th>
            <td><?php echo $email ?></td>
         </tr>
      </table>
      <hr /><br>
      <table>
         <tr>
            <th style="width: 120px;">MACCHINARIO:</th>
            <td style='width: 240px;'><?php echo $macchinario ?></td>
            <th style='text-align:left; width: 100px;'>PREVENTIVO: </th>
            <td style=''><?php echo $preventivo ?></td>
            <td rowspan="4" style="padding-left: 60px;">
               <img src="<?php echo $path ?>">
            </td>
         </tr>
         <tr>
            <th style="width: 120px;">MARCA: </th>
            <td style='width: 240px;'><?php echo $marca ?></td>
            <th style='text-align:left; width: 100px;'>MODELLO: </th>
            <td style=''><?php echo $modello ?></td>
         </tr>
         <tr>
            <th style="width: 120px;">MATRICOLA: </th>
            <td style='width: 240px;'><?php echo $matricola ?></td>
            <th style='text-align:left; width: 100px;'>GARANZIA: </th>
            <td style=''><?php echo $garanzia ?></td>
         </tr>
         <tr>
            <th style="width: 120px;">LIMITE SPESA: </th>
            <td style='width: 240px;'><?php echo $limite_spesa ?></td>
            <th style='text-align:left; width: 100px;'>LIMITE: </th>
            <td style=''><?php echo "€. ".$limite_spesa_costo ?></td>
         </tr>
      </table>
      <hr /><br>
      <table>
         <tr>
            <th  style="width: 120px;">GUASTO DICHIARATO: </th>
            <td><?php echo $guasto ?></td>
         </tr>
      </table>
      <hr /><br>
      <table>
         <tr>
            <th  style="width: 120px;">NOTE INGRESSO: </th>
            <td><?php echo $note?></td>
         </tr>
      </table>
      <hr /><br>
      <table style="width: 100%;">
         <tr>
            <td style="text-align: center; width: 30%;"></td>
            <td style="text-align: center; width: 40%;"><b><u>CLAUSOLE DI ASSISTENZA:</u></b></td>
            <td style="text-align: center; width: 30%;"></td>
         </tr>
         <tr>
            <td colspan="3" style="text-align: justify; font-size: 10px;">
               Il materiale non ritirato entro 90 gg. dalla data di avvenuta riparazione, preventivo non accettato oppure apparecchio non riparabile, verrà destinato alla rottamazione.<br>
               Qualora il prodotto portato in garanzia non ne risultasse conforme (manomissioni, calcare, infiltrazione liquidi, rotture meccaniche, ecc.) verrà comunicato il preventivo spesa.<br><br>
               Le riparazioni verranno effettuate entro i sottoindicati importi, senza preventivo consenso del cliente. Per coloro i quali volessero essere preventivamente informati sui costi di riparazione, dovranno farne immediata richiesta. Nel caso in cui il preventivo non venisse accettato, <u>le spese tecniche verranno comunque addebbitate (vedi tabella sottostante)</u>
            </td>
         </tr>
      </table>
      <table class="small-font" style="width: 100%;">
         <tr>
            <th style="text-align: center;">Macchinario</th>
            <th style="text-align: center;">Importo riparazione</th>
            <th style="text-align: center;">Spesa Tecnica</th>
         </tr>
         <tr>
            <td style="text-align: left;">&#8226; Aspirapolvere, Ferro a caldaia, Macchine caffè a braccio</td>
            <td style="text-align: center;">€. 55,00</td>
            <td style="text-align: center;">€. 15,00</td>
         </tr>
         <tr>
            <td style="text-align: left;">&#8226; Macchine da caffè automatica</td>
            <td style="text-align: center;">€. 100,00</td>
            <td style="text-align: center;">€. 25,00</td>
         </tr>
         <tr>
            <td style="text-align: left;">&#8226; Folletto - Bimby</td>
            <td style="text-align: center;">€. 150,00</td>
            <td style="text-align: center;">€. 25,00</td>
         </tr>
      </table>
      <div>
         <strong><b><u>RICEVUTA DA CONSEGNARE AL MOMENTO DEL RITIRO</u></b></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><b>Data Prevista Consegna: <?php echo $consegna ?></b></small>
      </div>
      <img src="images/forbice_tratteggio.jpg">
      <table style="margin-top: 10px;">
         <tr>
            <th style="width: 70px;">DATA: </th>
            <td style='width: 130px;'><?php echo $data ?></td>
            <th style='text-align:left; width: 70px;'>CODICE:</th>
            <td style='width: 110px;'><strong><font style="font-size: 14px;"><?php echo $number ?></font></strong></td>
            <th style='width: 80px;'>TELEFONO 1:</th>
            <td><?php echo $telefono_1 ?></td>
         </tr>
         <tr>
            <th>CLIENTE: </th>
            <td><strong><?php echo $cliente ?><strong></td>
            <th>CITTA': </th>
            <td><?php echo $citta ?></td>
            <th>TELEFONO 2:</th>
            <td><?php echo $telefono_2 ?></td>
         </tr>
         <tr>
            <th>INDIRIZZO: </th>
            <td><?php echo $indirizzo ?></td>
            <th style='text-align:left;'>CAP: </th>
            <td style=''><?php echo $cap ?></td>
            <th>EMAIL:</th>
            <td><?php echo $email ?></td>
         </tr>
      </table>
      <hr /><br>
      <table>
         <tr>
            <th style="width: 120px;">MACCHINARIO:</th>
            <td style='width: 240px;'><?php echo $macchinario ?></td>
            <th style='text-align:left; width: 100px;'>PREVENTIVO: </th>
            <td style=''><?php echo $preventivo ?></td>
            <td rowspan="4" style="padding-left: 60px;">
               <img src="<?php echo $path ?>">
            </td>
         </tr>
         <tr>
            <th style="width: 120px;">MARCA: </th>
            <td style='width: 240px;'><?php echo $marca ?></td>
            <th style='text-align:left; width: 100px;'>MODELLO: </th>
            <td style=''><?php echo $modello ?></td>
         </tr>
         <tr>
            <th style="width: 120px;">MATRICOLA: </th>
            <td style='width: 240px;'><?php echo $matricola ?></td>
            <th style='text-align:left; width: 100px;'>GARANZIA: </th>
            <td style=''><?php echo $garanzia ?></td>
         </tr>
         <tr>
            <th style="width: 120px;">LIMITE SPESA: </th>
            <td style='width: 240px;'><?php echo $limite_spesa ?></td>
            <th style='text-align:left; width: 100px;'>LIMITE: </th>
            <td style=''><?php echo "€. ".$limite_spesa_costo ?></td>
         </tr>
      </table>
      <hr /><br>
      <table>
         <tr>
            <th  style="width: 120px;">GUASTO DICHIARATO: </th>
            <td><?php echo $guasto ?></td>
         </tr>
      </table>
      <hr /><br>
      <table>
         <tr>
            <th  style="width: 120px;">NOTE INGRESSO: </th>
            <td><?php echo $note?></td>
         </tr>
      </table>
      <hr /><br>
      <table class="small-font">
         <tr>
            <td>
               <b>INFORMATIVA RELATIVA ALLA TUTELA DEI DATI PERSONALI:</b> Autorizzo il trattamento dei miei dati personali, consapevole di aver preso visione
               dell'Informativa esposta in bacheca presso il Centro Assistenza Tecnica, ai sensi dell' art. 13 del Regolamento (UE), n. 679/2016(GDPR).<br>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <input type="checkbox"> Do il consenso &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"> Nego il consenso<br>
               Ho verificato l'esattezza dei dati sopra riportati ed <b>accetto</b> tutte le <b>Clausole di assistenza</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Firma ..............................................</small>
            </td>
         </tr>
      </table>
      <hr /><br>
   </div>   
</div>
<div class='message_footer_container'>
   <table style="width: 100%;">
      <tr>
         <td colspan="4" style="height: 12px;"></td>
      </tr>
         <tr>
            <th>
               <p><small><?php echo $number . " - ".$data ?></small></p>
               <p><small><?php echo $cliente ?></small></p>
               <?php if($extra_info_string != null): ?>
               <p style="color: red;"><small><?php echo $extra_info_string ?></small></p>
               <?php endif; ?>
            </th>
            <th>
               <p><small><?php echo $number . " - ".$data ?></small></p>
               <p><small><?php echo $cliente ?></small></p>
               <?php if($extra_info_string != null): ?>
               <p style="color: red;"><small><?php echo $extra_info_string ?></small></p>
               <?php endif; ?>
            </th>
            <th>
               <p><small><?php echo $number . " - ".$data ?></small></p>
               <p><small><?php echo $cliente ?></small></p>
               <?php if($extra_info_string != null): ?>
               <p style="color: red;"><small><?php echo $extra_info_string ?></small></p>
               <?php endif; ?>
            </th>
            <th>
               <p><small><?php echo $number . " - ".$data ?></small></p>
               <p><small><?php echo $cliente ?></small></p>
               <?php if($extra_info_string != null): ?>
               <p style="color: red;"><small><?php echo $extra_info_string ?></small></p>
               <?php endif; ?>
            </th>
         </tr>
      </table>
<!--   <img src="<?php echo $path ?>">
      <p style="text-align: center; margin-top: 5px;"><b>Russo Ferdinando - Via F.sco Lo Jacono.3 - 90144 Palermo - Tel. + 39 091 349610 - www.russoferdinando.it</b></p>-->
</div>