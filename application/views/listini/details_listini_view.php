<div  id="listini_dettagli" class="row ch_canvas" style="margin-top: 30px;">
   <h1 class="text-center"><b>Dettagli Listini<b></h1>
            <div class="row">
               <div class="large-12 columns">
                  <ul class="inline-list">
                     <li><a href="<?php print_url(CH_URL_LISTINI) ?>" title="Indietro"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                     <li><a class="btn_show" href="#" title="Visualizza dettaglio"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
                  </ul>
                  <select data-customforms="disabled" name="brand_code" id="brand_code" style="width: 200px; position: absolute; top: 65px; left: 220px; z-index: 2">
                     <option value=""> --- (Brands) </option>
                     <?php foreach ($brands as $k => $brand): ?>
                     <option value="<?php echo $brand->brand_code ?>"> <?php echo $brand->brand_name ?></option>
                     <?php endforeach; ?>
                  </select>
                  <hr>
                  <form id="form-listini-list" method="post" >
                     <table id="listini_list_table" class="">
                        <thead>
                           <tr>
                              <th style="width: 10px !important;">&nbsp;</th>
                              <th>Brand</th>
                              <th style="width: 200px;">Codice</th>
                              <th style="width: 100px;">Acquisto</th>
                              <th style="width: 100px;">Vendita</th>
                              <th style="width: 100px;">Netto</th>
                              <th style="width: 100px;">Rifatturazi.</th>
                              <th>Descrizione</th>
                           </tr>
                        </thead>
                     </table>
                  </form>
               </div>
            </div>
            </div>
<script>
    var page = "listini_dettagli";                
</script>                                