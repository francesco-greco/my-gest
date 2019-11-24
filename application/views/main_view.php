<div  id="main_menu" class="row ch_canvas" style="margin-top: 30px;">
    <h1 class="text-center"><b>Pannello di controllo My Gest App<b></h1>
    <div class="main_button_container1" style="margin-top: 50px;">
<!--<ul class="button-group round even-6">
  <li><a href="#" class="button">Button 1</a></li>
  <li><a href="#" class="button">Button 2</a></li>
  <li><a href="#" class="button">Button 3</a></li>
  <li><a href="#" class="button">Button 4</a></li>
  <li><a href="#" class="button">Button 5</a></li>
  <li><a href="#" class="button">Button 6</a></li>
</ul>-->
        <?php if ($this->bitauth->has_role(CH_ROLE_USER_TECNICI_ACCESS)): ?>
            <div class="large-2 columns <?php echo $this->bitauth->has_role(CH_ROLE_POWERUSER) ? "large" : "large-centered" ?>">
                <h4 class="text-center">Tecnici</h4>
                <hr>
                <div class="large-block-grid-2">
                    <a href="<?php print_url(CH_URL_INTERVENTIONS) ?>" class="button expand round">Interventi</a>
                    <a href="<?php print_url(CH_URL_PRODUCTS) ?>" class="button expand round">Magazzino</a>
                    <!--<a href="<?php print_url(CH_URL_CLIENTS) ?>" class="button expand round">Clienti</a>-->
                    <a href="<?php print_url(CH_URL_FORNITORI) ?>" class="button expand round">Fornitori</a>
                    <a href="#" class="button expand round">Ordini</a>
                    <a href="<?php print_url(CH_URL_DDT."/ddt_list_page") ?>" class="button expand round">Visualizza DDT</a>
                    <a href="<?php print_url(CH_URL_PRODUCTS . "/show_articoli_view") ?>" class="button expand round">Articoli</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->bitauth->has_role(CH_ROLE_USER_AMMINISTRAZIONE_ACCESS)): ?>
            <div class="large-2 columns <?php echo $this->bitauth->has_role(CH_ROLE_POWERUSER) ? "large" : "large-centered" ?>">
                <h4 class="text-center">Amministrazione</h4>
                <hr>
                <div class="large-block-grid-2">
                    <a href="#" class="button expand round">Proforma</a>
                    <a href="#" class="button expand round">Ordini</a>
                    <a href="<?php print_url(CH_URL_FORNITORI) ?>" class="button expand round">Fornitori</a>
                    <a href="<?php print_url(CH_URL_PRODUCTS) ?>" class="button expand round">Magazzino</a>
                    <a href="<?php print_url(CH_URL_DDT."/ddt_list_page") ?>" class="button expand round">Visualizza DDT</a>
                    <a href="<?php print_url(CH_URL_PRODUCTS . "/show_articoli_view") ?>" class="button expand round">Articoli</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->bitauth->has_role(CH_ROLE_USER_BANCO_ACCESS)): ?>
            <div class="large-2 columns <?php echo $this->bitauth->has_role(CH_ROLE_POWERUSER) ? "large" : "large-centered" ?>">
                <h4 class="text-center">Banco Cliente</h4>
                <hr>
                <div class="large-block-grid-2">
                    <a href="<?php print_url(CH_URL_INTERVENTIONS) ?>" class="button expand round">Interventi</a>
                    <a href="<?php print_url(CH_URL_CLIENTS) ?>" class="button expand round">Clienti</a>
                    <a href="#" class="button expand round">Ordini</a>
                    <a href="#" class="button expand round">Reclami</a>
                    <a href="<?php print_url(CH_URL_PRODUCTS) ?>" class="button expand round">Magazzino</a>
                    <a href="#" class="button expand round">Comunicazioni</a>
                    <a href="#" class="button expand round new_ddt">Registra DDT</a>
                    <a href="<?php print_url(CH_URL_DDT."/ddt_list_page") ?>" class="button expand round">Visualizza DDT</a>
                    <a href="<?php print_url(CH_URL_PRODUCTS . "/show_articoli_view") ?>" class="button expand round">Articoli</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->bitauth->has_role(CH_ROLE_USER_MAGAZZINO_ACCESS)): ?>
            <div class="large-2 columns <?php echo $this->bitauth->has_role(CH_ROLE_POWERUSER) ? "large" : "large-centered" ?>">
                <h4 class="text-center">Magazzino</h4>
                <hr>
                <div class="large-block-grid-2">
                    <a href="<?php print_url(CH_URL_PRODUCTS) ?>" class="button expand round">Magazzino</a>
                    <a href="#" class="button expand round new_ddt">Registra DDT</a>
                    <a href="<?php print_url(CH_URL_DDT."/ddt_list_page") ?>" class="button expand round">Visualizza DDT</a>
                    <a href="#" class="button expand round">Ordini</a>
                    <a href="<?php print_url(CH_URL_FILE_IMPORT."/main_import_file") ?>" class="button expand round">Importa File</a>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if ($this->bitauth->has_role(CH_ROLE_USER_MANAGEMENT_ACCESS)): ?>
            <div class="large-2 columns <?php echo $this->bitauth->has_role(CH_ROLE_POWERUSER) ? "large" : "large-centered" ?>">
                <h4 class="text-center">Management</h4>
                <hr>
                <div class="large-block-grid-2">
                    <?php if ($this->bitauth->has_role(CH_ROLE_POWERUSER)): ?>
                        <a href="<?php print_url(CH_URL_USERS) ?>" class="button expand round">Impostazioni</a>
                    <?php endif; ?>
                    <a href="<?php print_url(CH_URL_LISTINI); ?>" class="button expand round">Listini</a>
                    <a href="<?php print_url(CH_URL_PRODUCTS) ?>" class="button expand round">Magazzino</a>
                    <a href="#" class="button expand round">Brands</a>
                    <a href="#" class="button expand round">Assegnazioni</a>
                    <a href="<?php print_url(CH_URL_DDT."/ddt_list_page") ?>" class="button expand round">Visualizza DDT</a>
                    <a href="<?php print_url(CH_URL_PRODUCTS . "/show_articoli_view") ?>" class="button expand round">Articoli</a>
                </div>
            </div>
            <div class="large-2 columns <?php echo $this->bitauth->has_role(CH_ROLE_USER_MANAGEMENT_ACCESS) ? "large" : "large-centered" ?>">
                <h4 class="text-center">Listati</h4>
                <hr>
                <div class="large-block-grid-2">
                    <a href="#" class="button expand round">Listati</a>
                    <a href="#" class="button expand round">Report</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>var page = 'main';</script>