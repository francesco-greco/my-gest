<div id="new_listino_window" style="width: 900px; background: #fffff0">
    <h3>Nuovo listino</h3>
    <hr>
    <form method="post" action="<?php print_url(CH_URL_LISTINI . "/save") ?>" id="form_intervention" class="custom-compact">
        <div class="row">
            <div class="large-3 columns">
                <label class="bold" for="listino_brand_code">Brand</label>
                <select name="listino_brand_code" class="required">
                    <option value=""> --- </option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?php echo $brand->brand_code ?>"><?php echo $brand->brand_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="large-3 columns">
                <label class="bold" for="listino_codice">Codice</label>
                <input type="text" name="listino_codice" class="required">
            </div>
           <div class="large-2 columns">
                <label class="bold" for="listino_scorta_minima">Scorta Min.</label>
                <input type="text" name="listino_scorta_minima" class="">
            </div>
            <div class="large-4 columns">
                <label class="bold" for="listino_descrizione">Descrizione</label>
                <input type="text" name="listino_descrizione" class="">
            </div>
        </div>
        <div class="row">
            <div class="large-3 columns">
                <label class="bold" for="listino_prezzo_acquisto">Prezzo acquisto</label>
                <div class="row collapse">
                    <div class="small-3 large-2 columns">
                        <span class="prefix">€</span>
                    </div>
                    <div class="small-9 large-10 columns">
                        <input type="text" name="listino_prezzo_acquisto" class="" value="" placeholder="0.00">
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
                        <input type="text" name="listino_prezzo_pubblico_1" class="" value="" placeholder="0.00">
                    </div>
                </div>
            </div>
            <div class="large-3 columns">
                <label class="bold" for="listino_prezzo_pubblico_2">Prezzo Vendita 2</label>
                <div class="row collapse">
                    <div class="small-3 large-2 columns">
                        <span class="prefix">€</span>
                    </div>
                    <div class="small-9 large-10 columns">
                        <input type="text" name="listino_prezzo_pubblico_2" class="" value="" placeholder="0.00">
                    </div>
                </div>
            </div>
            <div class="large-3 columns">
                <label class="bold" for="listino_prezzo_rifatturazione">Prezzo Vendita 2</label>
                <div class="row collapse">
                    <div class="small-3 large-2 columns">
                        <span class="prefix">€</span>
                    </div>
                    <div class="small-9 large-10 columns">
                        <input type="text" name="listino_prezzo_rifatturazione" class="" value="" placeholder="0.00">
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="columns large-9"></div>
            <div class="columns large-3 text-right" >
                <a href="#" style="" class="button small radius btn-listino-save"><i class="fa fa-fw fa-lg fa-save"></i></a>
            </div>
        </div>
    </form>
</div>