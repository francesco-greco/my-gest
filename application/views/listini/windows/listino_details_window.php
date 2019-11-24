<div id="listino_details_window" style="width: 900px; background: #fffff0">
    <h3>Dettaglio/Modifica listino <?php echo $listino->brand->brand_name ?> codice <?php echo $listino->codice ?></h3>
    <hr>
    <form method="post" action="<?php print_url(CH_URL_LISTINI . "/save") ?>" id="form_intervention" class="custom-compact">
        <div class="row">
            <div class="large-3 columns">
                <label class="bold" for="listino_brand_code">Brand</label>
                <input type="text" readonly="" value="<?php echo $listino->brand->brand_name ?>">
            </div>
            <div class="large-3 columns">
                <label class="bold" for="listino_codice">Codice</label>
                <input type="text" readonly="" class="required" value="<?php echo $listino->codice ?>">
            </div>
           <div class="large-2 columns">
                <label class="bold" for="listino_scorta_minima">Scorta min.</label>
                <input type="text" name="listino_scorta_minima" value="<?php echo $listino->scorta_minima ?>">
            </div>
            <div class="large-4 columns">
                <label class="bold" for="listino_descrizione">Descrizione</label>
                <input type="text" name="listino_descrizione" value="<?php echo $listino->descrizione ?>">
            </div>
        </div><br>
        <div class="row">
            <div class="large-3 columns">
                <label class="bold" for="listino_prezzo_acquisto">Prezzo acquisto</label>
                <div class="row collapse">
                    <div class="small-3 large-2 columns">
                        <span class="prefix">€</span>
                    </div>
                    <div class="small-9 large-10 columns">
                        <input type="text" name="listino_prezzo_acquisto" placeholder="0.00" value="<?php echo $listino->prezzo_acquisto ?>">
                    </div>
                </div>
            </div>
            <div class="large-3 columns">
                <label class="bold" for="listino_prezzo_pubblico_1">Prezzo Vendita 1</label>
                <div class="row collapse">
                    <div class="small-3 large-2 columns">
                        <span class="prefix">€</span>
                    </div>
                    <div class="small-9 large-10 columns">
                        <input type="text" name="listino_prezzo_pubblico_1" placeholder="0.00" value="<?php echo $listino->prezzo_pubblico_1 ?>">
                    </div>
                </div>
            </div>
            <div class="large-3 columns">
                <label class="bold" for="listino_prezzo_rivenditore">Prezzo Rivenditore</label>
                <div class="row collapse">
                    <div class="small-3 large-2 columns">
                        <span class="prefix">€</span>
                    </div>
                    <div class="small-9 large-10 columns">
                        <input type="text" name="listino_prezzo_rivenditore" placeholder="0.00" value="<?php echo $listino->prezzo_rivenditore ?>">
                    </div>
                </div>
            </div>
            <div class="large-3 columns">
                <label class="bold" for="listino_prezzo_rifatturazione">Prezzo Rifatturazione</label>
                <div class="row collapse">
                    <div class="small-3 large-2 columns">
                        <span class="prefix">€</span>
                    </div>
                    <div class="small-9 large-10 columns">
                        <input type="text" name="listino_prezzo_rifatturazione" placeholder="0.00" value="<?php echo $listino->prezzo_rifatturazione ?>">
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
           <div class="large-3 columns">
              <label class="bold" for="listino_acquisto_prezzo_netto">Prezzo Acquisto Netto</label>
              <div class="row collapse">
                 <div class="small-3 large-2 columns">
                    <span class="prefix">€</span>
                 </div>
                 <div class="small-9 large-10 columns">
                    <input type="text" name="listino_acquisto_prezzo_netto" placeholder="0.00" value="<?php echo $listino->acquisto_prezzo_netto ?>">
                 </div>
              </div>
           </div>
        </div>
        <div class="hide">
            <input type="hidden" name="listino_id" value="<?php echo $listino->id ?>">
        </div>
        <hr>
        <div class="row">
           <div class="large-12 columns bold">NB: * I prezzi sono tutti IVA esclusa.</div>
        </div>
        <div class="row">
            <div class="columns large-9"></div>
            <div class="columns large-3 text-right" >
                <a href="#" style="" class="button small radius btn-listino-save"><i class="fa fa-fw fa-lg fa-save"></i></a>
            </div>
        </div>
    </form>
</div>