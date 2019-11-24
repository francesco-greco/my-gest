<div  id="products_main" class="row ch_canvas" style="margin-top: 30px;">
   <div class="row">
      <div class="large-3 columns large-centered">
         <h4 class="text-center">Menù</h4>
         <hr>
         <div class="large-block-grid-3">
            <a href="<?php print_url(CH_URL_PRODUCTS."/load_gestione_magazzino_zero") ?>" class="button expand round">Magazzino 0*</a>
            <a href="#" class="button expand round btn-crea-magazzino">Crea magazzino</a>
            <a href="<?php print_url(CH_URL_PRODUCTS."/mostra_movimenti_list") ?>" class="button expand round">Visualizza movimenti</a>
            <a href="<?php print_url(CH_URL_PRODUCTS."/gestione_ubicazioni") ?>" class="button expand round btn-crea-ubicazione" target="_blank">Gestione ubicazioni</a>
            <a href="#" class="button expand round btn-importa-listino-gesat">Importa listino da Gesat</a>
            <!--<a href="<?php print_url(CH_URL_PRODUCTS . "/show_articoli_view") ?>" class="button expand round btn-new-listino">Situazione magazzini</a>-->
            <!--<a href="#" class="button expand round">Magazzino</a>-->
         </div>
      </div>
   </div><br><br><br>
   <div class="row">
      <div class="large-12 columns">
         <b>* Il magazzino 0 è il magazzino dove si riceve la merce e da dove viene smistata la merce verso gli altri magazzini per tutte le sedi</b>
      </div>
   </div>
</div>
<script>
   var page = 'magazzini_main';
</script>

