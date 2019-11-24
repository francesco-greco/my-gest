<div id="new_supplier" style="width: 900px; background: #fffff0">
   <h3>Nuovo Fornitore</h3><br>
   <fieldset>
      <legend>Anagrafica</legend>
      <form method="post" action="<?php print_url(CH_URL_FORNITORI . "/create_supplier") ?>" id="form_fornitori" class="custom-compact">
         <div class="row">
            <div class="large-6 columns">
               <label class="bold" for="fornitore_ragione_sociale">Ragione sociale*</label>
               <input type="text" id="fornitore_ragione_sociale" name="fornitore_ragione_sociale" required="">
            </div>
            <div class="large-3 columns">
               <label class="bold" for="fornitore_citta">Città*</label>
               <input type="text" id="fornitore_citta" name="fornitore_citta" required="">
            </div>
            <div class="large-3 columns">
               <label class="bold" for="fornitore_provincia">Provincia*</label>
               <input type="text" id="fornitore_provincia" name="fornitore_provincia" required="">
            </div>
         </div>
         <div class="row">
            <div class="large-6 columns">
               <label class="bold" for="fornitore_indirizzo">indirizzo*</label>
               <input type="text" id="fornitore_indirizzo" name="fornitore_indirizzo" required="">
            </div>
            <div class="large-1 columns">
               <label class="bold" for="fornitore_numero_civico">N°*</label>
               <input type="text" id="fornitore_numero_civico" name="fornitore_numero_civico" required="">
            </div>
            <div class="large-2 columns">
               <label class="bold" for="fornitore_cap">CAP*</label>
               <input type="text" id="fornitore_cap" name="fornitore_cap" required="">
            </div>
            <div class="large-3 columns">
               <label class="bold" for="fornitore_nazione">Nazione</label>
               <input type="text" id="fornitore_nazione" name="fornitore_nazione">
            </div>
         </div>
         <div class="row">
            <div class="large-2 columns">
               <label class="bold" for="fornitore_telefono_1">Telefono*</label>
               <input type="text" id="fornitore_telefono_1" name="fornitore_telefono_1" required="">
            </div>
            <div class="large-2 columns">
               <label class="bold" for="fornitore_telefono_2">Telefono 2</label>
               <input type="text" id="fornitore_telefono_2" name="fornitore_telefono_2">
            </div>
            <div class="large-4 columns">
               <label class="bold" for="fornitore_email_1">Email*</label>
               <input type="text" id="fornitore_email_1" name="fornitore_email_1" required="">
            </div>
            <div class="large-4 columns">
               <label class="bold" for="fornitore_email_2">Email 2</label>
               <input type="text" id="fornitore_email_2" name="fornitore_email_2">
            </div>
         </div>
         <div class="row">
            <div class="large-3 columns">
               <label class="bold" for="fornitore_referente">Referente</label>
               <input type="text" id="fornitore_referente" name="fornitore_referente">
            </div>
            <div class="large-3 columns">
               <label class="bold" for="fornitore_referente_recapito">Recapito</label>
               <input type="text" id="fornitore_referente_recapito" name="fornitore_referente_recapito">
            </div>
            <div class="large-3 columns">
               <label class="bold" for="fornitore_codice_fiscale">Codice fiscale</label>
               <input type="text" id="fornitore_codice_fiscale" name="fornitore_codice_fiscale">
            </div>
            <div class="large-3 columns">
               <label class="bold" for="fornitore_p_iva">P. IVA*</label>
               <input type="text" id="fornitore_p_iva" name="fornitore_p_iva" required="">
            </div>
         </div>
         <div class="row">
            <div class="large-12 columns">
               <label class="bold" for="fornitore_web_site">WWW</label>
               <input type="text" id="fornitore_web_site" name="fornitore_web_site">
            </div>
         </div>
      </form>
      <div class="row">
            <div class="large-10 columns"></div>
            <div class="large-2 columns" style="padding-left: 27px;">
                <a href="#" class="button radius btn-create-supplier"><i class="fa fa-fw fa-lg fa-save"></i></a>
            </div>
        </div>
   </fieldset>
</div>