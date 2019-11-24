<div style="margin-top: 30px;" id="ddt_list_page_container">
   <div class="row">
      <div class="large-12 columns text-center" style="height: 100%;">
         <h3>DDT Caricati</h3>
         <hr>
         <dl class="tabs" data-tab>
            <dd class="active"><a href="#aperti">In corso</a></dd>
            <dd class=""><a href="#registrati">Storico</a></dd>
         </dl>
         <div class="tabs-content">
            <div id="aperti" class="active content">
               <ul class="inline-list" style="margin-top: 20px;">
                  <li><a href="<?php print_url(CH_URL_MAIN) ?>" title="Indietro"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>                
                  <li><a class="btn_show" href="#" title="Salva"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
               </ul>
               <br><br>
               <div class="row">
                  <form id="form-ddt-list" method="post" >
                     <table id="ddt_list_table">
                        <thead>
                           <tr>
                              <th class="text-center" style="width: 20px;"></th>
                              <th class="text-center" style="width: 200px;">Sede</th>
                              <th class="text-center">Fornitore</th>
                              <th class="text-center" style="width: 200px;">Data Documento</th>
                              <th class="text-center" style="width: 200px;">N° Documento</th>
                           </tr>
                        </thead>
                        <tbody>

                        </tbody>
                     </table>
                  </form>
               </div>
            </div>
            <div id="registrati" class="content">
               <ul class="inline-list" style="margin-top: 20px;">
                  <li><a href="<?php print_url(CH_URL_MAIN) ?>" title="Indietro"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>                
                  <li><a class="btn_old_show" href="#" title="Salva"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
               </ul>
               <br><br>
               <div class="row">
                  <form id="form-ddt-list-old" method="post" >
                     <table id="ddt_list_table_old">
                        <thead>
                           <tr>
                              <th class="text-center" style="width: 20px;"></th>
                              <th class="text-center" style="width: 200px;">Sede</th>
                              <th class="text-center">Fornitore</th>
                              <th class="text-center" style="width: 200px;">Data Documento</th>
                              <th class="text-center" style="width: 200px;">N° Documento</th>
                           </tr>
                        </thead>
                        <tbody>

                        </tbody>
                     </table>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <script>
      var page = 'ddt_list_page';
   </script>
