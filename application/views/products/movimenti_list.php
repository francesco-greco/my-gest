<div id="movimenti_list_container" style="margin-top: 30px;">
    <div class="row">
        <div class="large-12 columns text-center" style="height: 100%;">
            <dl class="tabs" data-tab>
                <dd class="active"><a href="#articoli">Movimenti</a></dd>
            </dl>
            <div class="tabs-content">
                <div id="articoli" class="active content">
                   <ul class="inline-list">
                        <li><a href="<?php print_url(CH_URL_PRODUCTS) ?>" title="Indietro"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                        <li><a class="btn_show" href="#" title="visualizza movimento"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
                    </ul>
                    <br><br>
                    <div class="row">
                       <form id="form-movimenti-list" method="post" >
                        <table id="movimenti_list_table" class="">
                            <thead>
                                <tr>
                                    <th style="width: 10px !important;">&nbsp;</th>
                                    <th style="width: 200px !important;">Data movimento</th>
                                    <th style="width: 200px !important;">Numero movimento</th>
                                    <th style="">Magazzino</th>
                                    <th style="width: 200px">Tipo Movimento</th>
                                </tr>
                            </thead>
                        </table>
                    </form>
                    </div>
                    <div class="row">
                       <div class="large-12 columns bold" style="text-align: left;">
                          <font style="color: red;">*Rosso: stato bozza (movimento non eseguito in magazzino)</font><br>
                          **Nero: movimento eseguito in magazzino
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
   var page = "lista_movimenti";
</script>

