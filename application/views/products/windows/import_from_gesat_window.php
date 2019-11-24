<div id="import_gesat_container" style="width: 500px; background: #fffff0">
   <h3>Importa listino prodotti</h3>
   <!--<form method="post" action="<?php print_url(CH_URL_PRODUCTS."/load_listino_from_gesat") ?>"  enctype="multipart/form-data" id="form_load_listino" name="form_load_listino">-->
   <?php echo form_open_multipart(CH_URL_PRODUCTS."/load_listino_from_gesat");?>
      <div class="row">
         <div class="large-12 columns">
            <span class="bold">Seleziona file txt</span>
            <input type="file" name="attachment" id="attachment" size="50">
         </div>
      </div>
      <br>
      <div class="progress large-12 success round ">
         <span class="meter" style="width: 0%"></span>
      </div>
      <hr>
      <div class="row">
         <div class="large-12 columns right" style="text-align: right; padding-right: 0px;">
            <a href="#" class="btn-start-upload" title="Inizia caricamento"><i class="fa fa-lg fa-download"></i></a>
         </div>
      </div>
      <?php echo form_close(); ?>
   <!--</form>-->
</div>

