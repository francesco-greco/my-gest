<div  id="gestione_ubicazioni" class="row ch_canvas" style="margin-top: 30px;">
    <div class="row">
        <div class="large-12 columns text-center" style="height: 100%;">
            <dl class="tabs" data-tab>
                <dd class="active"><a href="#gestione">Gestione Ubicazioni</a></dd>
            </dl>
            <div class="tabs-content">
                <div id="gestione" class="active content">
                   <form method="post" class="custom-compact" action="<?php print_url(CH_URL_PRODUCTS . "/salva_ubicazione") ?>">
                   <div class="row">
                      <div class="large-4 columns" style="text-align: left;">
                         <span>Magazzino</span>
                         <select id="ubicazione_id_magazzino" name="ubicazione_id_magazzino" required="">
                            <option value=""> --- </option>
                            <?php foreach ($elenco_magazzini as $magazzino): ?>
                            <option value="<?php echo $magazzino->id ?>"><?php echo $magazzino->nome ?></option>
                            <?php endforeach; ?>
                         </select>
                      </div>
                   </div>
                   <br>
                   <div class="row">
                      <div class="large-12 columns">
                         <table id="table_ubicazioni">
                            <thead>
                               <tr>
                                  <th>Codice ubicazione</th>
                                  <th>Descrizione</th>
                                  <th>Tipologia ubicazione</th>
                                  <th style="width: 40px;"></th>
                               </tr>
                            </thead>
                            <tbody id="body_table_ubicazioni"></tbody>
                            <tfoot id="foot_table_ubicazioni">
                               <tr>
                                  <td>
                                     <input type="text" name="ubicazione_codice_ubicazione" id="ubicazione_codice_ubicazione" required="">
                                  </td>
                                  <td>
                                     <input type="text" name="ubicazione_descrizione" id="ubicazione_descrizione">
                                  </td>
                                  <td>
                                     <select id="ubicazione_tipologia" name="ubicazione_tipologia" required="">
                                        <option value=""> --- </option>
                                        <?php foreach ($tipi_ubicazione as $k => $u): ?>
                                        <option value="<?php echo $k ?>"><?php echo $u ?></option>
                                        <?php endforeach; ?>
                                     </select>
                                  </td>
                                  <td style="text-align: center;">
                                     <a href="#" class="add-ubicazione" title="Aggiungi"><i class="fa fa-lg fa-plus-circle"></i></a>
                                  </td>
                               </tr>
                            </tfoot>
                         </table>
                      </div>
                   </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var page = 'gestione_ubicazioni';
</script>


