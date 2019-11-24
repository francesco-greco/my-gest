<div id="new_ddt_window" style="width: 800px; background: #fffff0;">
   <style>
   .small-padding {
      padding-left: 2px;
      padding-right: 2px;
   }
</style>
   <h3>Nuovo Documento di trasporto</h3><br>
   <form method="post" id="form_new_ddt" action="<?php print_url(CH_URL_DDT."/save_ddt") ?>">
   <div class="row medium-uncollapse large-collapse">
      <div class="large-6 columns small-padding">
         <label class="bold">Fornitore*</label>
         <input required="" type="text" name="ddt_ragione_sociale" id="ddt_ragione_sociale">
         <input type="hidden" required name="ddt_id_fornitore" id="ddt_id_fornitore">
      </div>
      <div class="large-3 columns small-padding">
         <label class="bold">P. IVA*</label>
         <input type="text" required name="ddt_p_iva" id="ddt_p_iva">
      </div>
      <div class="large-3 columns small-padding ">
         <label class="bold">Codice Fisc.</label>
         <input type="text" required name="ddt_cf" id="ddt_cf">
      </div>
   </div>
   <div class="row">
      <div class="large-3 columns small-padding">
         <label class="bold">Data documento*</label>
         <input type="text" required class="dataP" name="ddt_data_documento" id="ddt_data_documento">
      </div>
      <div class="large-3 columns end small-padding">
         <label class="bold">documento N°*</label>
         <input type="text" required name="ddt_numero_documento" id="ddt_numero_documento">
      </div>
      <div class="large-6 columns end">
         <a href="#" class="button btn-save" style="width: 100%; height: 45px; margin-top: 20px; border-radius: 20px 20px 20px 20px;">Crea</a>
      </div>
   </div>
   </form>
   <div class="row">
      <div class="large-12 columns">
         <u>NB: I campi Fornitore - P. IVA - Codice Fiscale, sono tutti campi ad auto ricerca.</u>
      </div>
   </div>
</div>

