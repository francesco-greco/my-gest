<div id="nuovo_movimento" style="width: 900px; background: #fffff0">
   <h3>Crea nuovo movimento</h3>
   <div class="row">
      <div class="large-3 columns end" style="padding-left: 0px;">
         <span>Sede del magazzino</span>
         <select name="movimento_id_sede" id="movimento_id_sede">
            <option value=""> --- </option>
            <?php foreach ($lista_sedi as $sede): ?>
               <option value="<?php echo $sede->id ?>"><?php echo $sede->stock_description ?></option>
            <?php endforeach; ?>
         </select>
      </div>
      <div class="large-6 columns end">
         <span>lista magazzini sede</span>
         <select name="select_magazzini" id="select_magazzini">
            <option value=""> --- </option>
         </select>
      </div>
      <div class="large-2 columns left" style="padding-top: 20px;">
         <a href="#" class="conferma-blocca" title="Conferma"><i class="fa fa-lg fa-check"></i></a>
      </div>
   </div>
</div>
