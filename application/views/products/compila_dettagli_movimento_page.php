<div id="movimento_dettagli_container" style="padding-top: 20px;">
   <style>
      #table_movimento_dettagli tbody {
         display:block;
         height:200px;
         overflow:auto;
         background: #fffff0;
      }
      #table_movimento_dettagli thead, #table_movimento_dettagli tbody tr {
         display:table;
         width:100%;
         table-layout:fixed;/* even columns width , fix width of table too*/
      }
      #table_movimento_dettagli thead {
         width: calc( 100% - 1em )/* scrollbar is average 1em/16px width, remove it from thead width */
      }
   </style>
   <input type="hidden" id="id_movimento" value="<?php echo $id_movimento ?>">
   <input type="hidden" id="stato_movimento" value="<?php echo $stato_movimento ?>">
   <div class="row">
      <div class="large-12 columns">
         <dl class="tabs" data-tab>
            <dd class="active"><a href="#movimento">Movimento N. <?php echo $numero_movimento ?></a></dd>
         </dl>
         <div class="tabs-content">
            <div id="movimento" class="active content">
               <ul class="inline-list">                 
                  <li><a class="btn_stampa_bolla" href="#" title="Stampa bolla movimento"><i class="fa fa-fw fa-lg fa-print"></i></a></li>
                  <?php if ($stato_movimento != Movimenti_magazzino_DTO::STATO_CHIUSO): ?>
                  <li><a class="btn_crea_ddt" href="#" title="Crea ddt da movimento">Ddt</a></li>
                  <li><a href="#" class="chiudi-movimento" title="Chiudi movimento e trasferisci"><i class="fa fa-fw fa-lg fa-key"></i></a></li>
                  <?php endif; ?>
               </ul>
               <table>
                  <thead>
                     <tr>
                        <th style="text-align: center;">Movimento da magazzino 0 a magazzino: <?php echo $magazzino->nome ?></th>
                     </tr>
                  </thead>
               </table>
               <?php if($stato_movimento != Movimenti_magazzino_DTO::STATO_CHIUSO): ?>
               <form class="custom condensed-form">
               <table>
                  <thead>
                     <tr>
                        <th style="width: 90px;">Brand</th>
                        <th style="width: 120px">Codice Art.</th>
                        <th>Descrizione</th>
                        <th style="width: 80px;">Quantità</th>
                        <th style="width: 110px;">Ubicazione</th>
                        <th style="width: 40px;"></th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td><input type="text" id="brand"></td>
                        <td><input type="text" id="codice"></td>
                        <td><input type="text" id="descrizione"></td>
                        <td><input type="text" id="quantita"></td>
                        <td>
                           <select id="ubicazione" data-customforms="disabled">
                              <option value=""> -- </option>
                              <?php foreach ($magazzino->ubicazioni as $k => $ub): ?>
                              <option value="<?php echo $ub->id ?>"><?php echo $ub->codice_ubicazione ?></option>
                              <?php endforeach; ?>
                           </select>
                        </td>
                        <td style="text-align: center;"><a href="#" class="add_detail"><i class="fa fa-lg fa-plus-circle"></i></a></td>
                     </tr>
                  </tbody>
               </table>
                  <input type="hidden" id="id_listino">
                  <input type="hidden" id="quantita_da_0">
               </form>
               <?php else: ?>
               <div class="custom-alert text-center">
                  Movimento chiuso <i class="fa fa-lg fa-lock"></i>
               </div>
               <?php endif; ?>
               <fieldset>
                  <legend>Dettagli movimento</legend>
                  <table id="table_movimento_dettagli">
                     <thead>
                        <tr>
                        <th style="width: 90px;">Brand</th>
                        <th style="width: 120px">Codice Art.</th>
                        <th>Descrizione</th>
                        <th style="width: 80px;">Quantità</th>
                        <th style="width: 110px;">Ubicazione</th>
                        <th style="width: 40px;"></th>
                     </tr>
                     </thead>
                     <tbody class="scrollable" id="body_table_movimento_dettagli">
                     </tbody>
                  </table>
               </fieldset>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   var page = 'movimento_dettagli_page';
</script>