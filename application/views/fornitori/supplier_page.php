<div  id="fornitore_page" class="row" style="margin-top: 30px;">
   <h1 class="text-center"><b>Fornitore<b></h1>
            <hr>
      <form method="post" action="<?php print_url(CH_URL_FORNITORI . "/create_supplier") ?>" id="form_fornitori" class="custom-compact">
         <div class="row">
            <ul class="inline-list">
                <li><a href="<?php print_url(CH_URL_FORNITORI) ?>" title="Indietro"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>                
                <li><a class="btn_save" href="#" title="Salva modifiche"><i class="fa fa-fw fa-lg fa-save"></i></a></li>
            </ul>
            <div class="large-6 columns">
               <label class="bold" for="fornitore_ragione_sociale">Ragione sociale*</label>
               <input type="text" id="fornitore_ragione_sociale" name="fornitore_ragione_sociale" required="" value="<?php echo $fornitore->ragione_sociale ?>">
            </div>
            <div class="large-3 columns">
               <label class="bold" for="fornitore_citta">Città*</label>
               <input type="text" id="fornitore_citta" name="fornitore_citta" required="" value="<?php echo $fornitore->citta ?>">
            </div>
            <div class="large-3 columns">
               <label class="bold" for="fornitore_provincia">Provincia*</label>
               <input type="text" id="fornitore_provincia" name="fornitore_provincia" required="" value="<?php echo $fornitore->provincia ?>">
            </div>
         </div>
         <div class="row">
            <div class="large-6 columns">
               <label class="bold" for="fornitore_indirizzo">indirizzo*</label>
               <input type="text" id="fornitore_indirizzo" name="fornitore_indirizzo" required="" value="<?php echo $fornitore->indirizzo ?>">
            </div>
            <div class="large-1 columns">
               <label class="bold" for="fornitore_numero_civico">N°*</label>
               <input type="text" id="fornitore_numero_civico" name="fornitore_numero_civico" required="" value="<?php echo $fornitore->numero_civico ?>">
            </div>
            <div class="large-2 columns">
               <label class="bold" for="fornitore_cap">CAP*</label>
               <input type="text" id="fornitore_cap" name="fornitore_cap" required="" value="<?php echo $fornitore->cap ?>">
            </div>
            <div class="large-3 columns">
               <label class="bold" for="fornitore_nazione">Nazione</label>
               <input type="text" id="fornitore_nazione" name="fornitore_nazione" value="<?php echo $fornitore->nazione ?>">
            </div>
         </div>
         <div class="row">
            <div class="large-2 columns">
               <label class="bold" for="fornitore_telefono_1">Telefono*</label>
               <input type="text" id="fornitore_telefono_1" name="fornitore_telefono_1" required="" value="<?php echo $fornitore->telefono_1 ?>">
            </div>
            <div class="large-2 columns">
               <label class="bold" for="fornitore_telefono_2">Telefono 2</label>
               <input type="text" id="fornitore_telefono_2" name="fornitore_telefono_2" value="<?php echo $fornitore->telefono_2 ?>">
            </div>
            <div class="large-4 columns">
               <label class="bold" for="fornitore_email_1">Email*</label>
               <input type="text" id="fornitore_email_1" name="fornitore_email_1" required="" value="<?php echo $fornitore->email_1 ?>">
            </div>
            <div class="large-4 columns">
               <label class="bold" for="fornitore_email_2">Email 2</label>
               <input type="text" id="fornitore_email_2" name="fornitore_email_2" value="<?php echo $fornitore->email_2 ?>">
            </div>
         </div>
         <div class="row">
            <div class="large-3 columns">
               <label class="bold" for="fornitore_referente">Referente</label>
               <input type="text" id="fornitore_referente" name="fornitore_referente" value="<?php echo $fornitore->referente ?>">
            </div>
            <div class="large-3 columns">
               <label class="bold" for="fornitore_referente_recapito">Recapito</label>
               <input type="text" id="fornitore_referente_recapito" name="fornitore_referente_recapito" value="<?php echo $fornitore->referente_recapito ?>">
            </div>
            <div class="large-3 columns">
               <label class="bold" for="fornitore_codice_fiscale">Codice fiscale</label>
               <input type="text" id="fornitore_codice_fiscale" name="fornitore_codice_fiscale" value="<?php echo $fornitore->codice_fiscale ?>">
            </div>
            <div class="large-3 columns">
               <label class="bold" for="fornitore_p_iva">P. IVA*</label>
               <input type="text" id="fornitore_p_iva" name="fornitore_p_iva" required="" value="<?php echo $fornitore->p_iva ?>">
            </div>
         </div>
         <div class="row">
            <div class="large-12 columns">
               <label class="bold" for="fornitore_web_site">WWW</label>
               <input type="text" id="fornitore_web_site" name="fornitore_web_site" value="<?php echo $fornitore->web_site ?>">
            </div>
         </div>
         <input type="hidden" id="fornitore_id" name="fornitore_id" value="<?php echo $fornitore->id ?>">
      </form>
</div>
<script>
   var page = 'supplier_page';
</script>

