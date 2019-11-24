<div id="carica_articoli_container" style="margin-top: 30px;">
   <div class="row">
      <div class="large-12 columns text-center" style="height: 100%;">
         <dl class="tabs" data-tab>
            <dd class="active"><a href="#articoli">Articoli</a></dd>
         </dl>
         <div class="tabs-content">
            <div id="articoli" class="active content">
               <ul class="inline-list">
                  <li><a href="<?php print_url(CH_URL_MAIN) ?>" title="Indietro"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                  <li><a class="btn_show" href="#" title="Gestisci articolo"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
               </ul>
               <br><br>
               <div class="row">
                  <select data-customforms="disabled" name="brand_code" id="brand_code" style="width: 200px; position: absolute; top: 124px; left: 220px; z-index: 2">
                        <option value=""> --- (Brands) </option>
                        <?php foreach ($brands as $k => $brand): ?>
                           <option value="<?php echo $brand->brand_code ?>"> <?php echo $brand->brand_name ?></option>
                        <?php endforeach; ?>
                     </select>
                  <div class="large-12 columns">
                     <form id="form-articoli-list" method="post" >
                        <table id="articoli_list_table" class="">
                           <thead>
                              <tr>
                                 <th style="width: 10px !important;">&nbsp;</th>
                                 <th style="width: 180px !important;">Brand</th>
                                 <th style="width: 120px">Cod. brand</th>
                                 <th style="width: 200px">Codice</th>
                                 <th>Descrizione</th>
                              </tr>
                           </thead>
                        </table>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   var page = "carica_articoli";
</script>