<div id="article_details_window" style="width: 900px; background: #fffff0">
    <h3>Dettaglio articolo <?php echo $articolo->brand->brand_name . " codice " . $articolo->codice ?></h3>
    <hr>
    <fieldset>
       <legend>Listino articolo</legend>
       <table>
          <tr>
             <th>Prezzo vendita 1</th>
             <td>€. <?php echo to_currency($articolo->prezzo_pubblico_1) ?></td>
             <th>Prezzo vendita 2</th>
             <td>€. <?php echo to_currency($articolo->prezzo_pubblico_2) ?></td>
          </tr>
       
          <tr>
             <th>Prezzo rifatturazione</th>
             <td>€. <?php echo to_currency($articolo->prezzo_rifatturazione) ?></td>
             <th>Costo</th>
             <td>€. <?php echo to_currency($articolo->prezzo_acquisto) ?></td>
          </tr>
       </table>
    </fieldset>
    <?php foreach ($articolo->articolo as $k => $dettaglio): ?>
    <fieldset>
       <legend>Situazione attuale magazzino codice <?php echo $k ?></legend>
    <table>
       <tr>
          <th>Disponibilità attuale Q.tà</th>
          <td><?php echo $dettaglio == false ? 0 : $dettaglio->quantita ?></td>
          <th>Data ultimo caricamento</th>
          <td><?php echo $dettaglio == false ? "MAI" : db_to_normal_timestamp($dettaglio->data_ultimo_ingresso) ?></td>
       </tr>
    </table>
    <table>
       <tr>
          <th>Op. ultimo caricamento</th>
          <td><?php echo $dettaglio == false ? "NESSUNO" : $dettaglio->operatore_ultimo_aggiornamento ?></td>
          <th>Scorta minima</th>
          <td><?php echo $dettaglio == false || $dettaglio->scorta_minima == null ? 0 : $dettaglio->scorta_minima ?></td>
       </tr>
    </table>
    <table>
       <tr>
          <th style="width: 196px;">Ubicazione</th>
          <td><?php echo $dettaglio == false ? "NON ASSEGNATA" : $dettaglio->ubicazione ?></td>
<!--          <th></th>
          <td style="text-align: center"><a href="#" class="btn-action"><i id="icon_action" class="fa fa-fw fa-lg fa-lock "></i></a></td>-->
       </tr>
    </table>
    </fieldset>
    <?php endforeach; ?>
<!--    <fieldset id="form_container" class="hide">
       <legend>Modifica</legend>
       <form method="post" id="form_article">
          <input type="hidden" name="articolo_operatore_ultimo_aggiornamento" value="<?php echo $this->bitauth->fullname ?>">
          <input type="hidden" name="articolo_id_sede" value="<?php echo $this->bitauth->id_sede ?>">
          <input type="hidden" name="articolo_stock_code" value="<?php echo $this->bitauth->stock_code ?>">
          <input type="hidden" name="articolo_id_listino" value="<?php echo $articolo->id ?>">
          <input type="hidden" name="articolo_codice" value="<?php echo $articolo->codice ?>">
          
          <table>
             <tr>
                <th>Quantità</th>
                <td><input type="text" name="articolo_quantita" required=""></td>
                <th>Scorta minima</th>
                <td><input type="text" name="articolo_scorta_minima" required="" value="<?php $articolo->articolo != FALSE ? $articolo->articolo->scorta_minima : "" ?>"></td>
             </tr>
          </table>
       </form>
    </fieldset>-->
</div>

