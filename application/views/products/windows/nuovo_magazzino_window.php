<div id="nuovo_magazzino" style="width: 900px; background: #fffff0">
   <h3>Nuovo Magazzino</h3><br>
   <form method="post" action="<?php print_url(CH_URL_PRODUCTS . "/salva_magazzino") ?>" id="form_magazzino" class="custom condensed-form">
      <div class="row">
         <div class="large-3 columns end" style="padding-left: 0px;">
            <span>Sede del magazzino</span>
            <select name="magazzino_id_sede" id="magazzino_id_sede" required="">
               <option value=""> --- </option>
               <?php foreach ($lista_sedi as $sede): ?>
               <option value="<?php echo $sede->id ?>"><?php echo $sede->stock_description ?></option>
               <?php endforeach; ?>
            </select>
         </div>
      </div>
      <div class="row">
         <div class="large-4 columns" style="padding-left: 0px;">
            <span>Nome Magazzino</span>
            <input type="text" id="magazzino_nome" name="magazzino_nome" required="">
         </div>
         <div class="large-4 columns" style="padding-left: 0px;">
            <span>Codice Magazzino*</span>
            <input type="text" id="magazzino_codice" name="magazzino_codice"  required="">
         </div>
         <div class="large-3 columns" style="padding-left: 0px;">
            <span>Responsabile</span>
            <select name="magazzino_responsabile" id="magazzino_responsabile"  required="">
               <option value=""> -- </option>
               <?php foreach ($lista_utenti as $k => $utente): ?>
               <option value="<?php echo $utente->user_id ?>"><?php echo $utente->fullname ?></option>
               <?php endforeach; ?>
            </select>
         </div>
         <div class="large-1 columns text-center" style="padding-top: 20px;">
            <a href="#" class="abilita-magazzino"><i class="fa fa-fw fa-lg fa-unlock"></i></a>
         </div>
      </div>
      <div class="row">
         <div class="large-4 columns" style="font-weight: bold; padding-left: 0px; padding-top: 20px;">
            *Codice Max 5 caratteri<br>
            **Tutti i campi sono obbligatori
         </div>
      </div>
      <hr>
      <div class="row">
         <div class="columns large-9"></div>
         <div class="columns large-3 text-right" >
            <a href="#" style="" class="button small radius btn-magazzino-save"><i class="fa fa-fw fa-lg fa-save"></i></a>
         </div>
      </div>   
      <div class="hidden-field">
         <input type="hidden" id="magazzino_abilitato" name="magazzino_abilitato"  required="" value="<?php echo Magazzino_DTO::ABILITATO_SI ?>">
      </div>
</div>
