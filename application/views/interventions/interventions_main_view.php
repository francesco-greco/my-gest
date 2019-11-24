<div id="interventions_main_container" style="margin-top: 30px;">
    <div class="row">
        <div class="large-12 columns text-center" style="height: 100%;">
            <h4 class="my-title">Riparazioni</h4>
            <hr>
            <dl class="tabs" data-tab>
                <dd class="active"><a href="#corso">In corso</a></dd>
                <dd class=""><a href="#storico">Storico</a></dd>
            </dl>
            <div class="tabs-content">
                <div id="corso" class="active content">
                    <ul class="inline-list">
                        <li><a href="<?php print_url(CH_URL_MAIN) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                        <li><a class="btn_show" href="#" title="Visualizza intervento"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
                    </ul>
                    <br><br>
                    <div class="row table_list_container">
                        <form id="form-interventions-list" method="post" >
                            <table id="main_interventions_table" class="table_interventions_list">
                                <thead>
                                    <tr>
                                        <th style="width: 10px !important;">&nbsp;</th>
                                        <th>Codice</th>
                                        <th>Data Ing.</th>
                                        <th>Cliente</th>
                                        <th>Prodotto</th>
                                        <th>Marca</th>
                                        <th>Seriale</th>
                                        <th>Garanzia</th>
                                        <th>Sede</th>
                                    </tr>
                                </thead>
                            </table>
                        </form>
                    </div>
                </div>
                <div id="storico" class="content">
                    <ul class="inline-list">
                        <li><a href="<?php print_url(CH_URL_MAIN) ?>" title="<?php echo lang('common_words_back') ?>"><i class="fa fa-fw fa-lg fa-chevron-left"></i></a></li>
                        <li><a class="btn_old_show" href="#" title="Visualizza intervento"><i class="fa fa-fw fa-lg fa-eye"></i></a></li>
                    </ul>
                    <br><br>
                    <div class="row table_list_container">
                        <form id="form-old_interventions-list" method="post" >
                            <table id="old_interventions_table" class="table_interventions_list">
                                <thead>
                                    <tr>
                                        <th style="width: 10px !important;">&nbsp;</th>
                                        <th>Codice</th>
                                        <th>Data Ing.</th>
                                        <th>Cliente</th>
                                        <th>Prodotto</th>
                                        <th>Marca</th>
                                        <th>Seriale</th>
                                        <th>Garanzia</th>
                                        <th>Sede</th>
                                    </tr>
                                </thead>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var page = 'interventions_main';
</script>
