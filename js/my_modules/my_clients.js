(function ($, window, document, undefined) {
    var
            CANVAS_ID = '#clients-panel';

    var Client_editor_page = (function () {
        var $form, id_client;

        function init() {
            id_client = $('.client_user_id', CANVAS_ID).val();
            form_init();
            toolbar_init();
        }

        function form_init() {
            $form = new CH_smartForm($('form', CANVAS_ID), {
                success: function (response) {
                    if (response.result == CH_RESULT.SUCCESS) {
                        CH_Tools.load_overlay_window(CH_URL.interventions + '/new_intervention_window_show/' + response.id, '#new_intervention_window', function (id_window) {
                            $(id_window + ' .dataP').datepicker({'changeMonth' : true, "changeYear": true});
                            $(id_window + ' .btn-create-intervention').on('click', function () {
                                $('form', id_window).submit();
                            });
                            $(id_window).on('close', function () {
                                CH_page_reloader.set_url(CH_URL.interventions);
                                CH_page_reloader.reload();
                            });
                            $form = new CH_smartForm($('form', id_window), {
                                success: function (response) {
                                    if (response.response == CH_RESULT.SUCCESS) {
                                        CH_Tools.show_message("Intervento creato correttamente.", 'info');
                                        CH_Tools.popup_window(CH_URL.interventions + '/stampa_ricevuta/' + response.id_intervention);
//                                        window.location.href = CH_URL.clients;
                                    } else {
                                        CH_Tools.show_message(CH_Tools.lang('common_words_data_not_saved_msg'), 'error');
                                    }
                                },
                                error: function () {

                                }
                            });

                        });
                    } else {
                        CH_Tools.show_message(CH_Tools.lang('common_words_data_not_saved_msg'), 'error');
                    }
                },
                error: function () {

                }
            });
        }
        

        function toolbar_init() {
            $('.btn_save', CANVAS_ID).on('click', function () {
                $('form', CANVAS_ID).submit();
            });
            
            $('.btn_new_intervention').on('click', function (){
               var id_client = $(this).data('id-client');
               load_window_new_client(id_client); 
            });
        }
        
        function load_window_new_client(id_client){
            CH_Tools.load_overlay_window(CH_URL.interventions + '/new_intervention_window_show/' + id_client, '#new_intervention_window', function (id_window) {
                $(id_window + ' .dataP').datepicker({'changeMonth' : true, "changeYear": true});
                $(id_window + ' .btn-create-intervention').on('click', function () {
                    $('form', id_window).submit();
                });
                $(id_window).on('close', function () {
                    CH_page_reloader.set_url(CH_URL.clients);
                    CH_page_reloader.reload();
                });
                $form = new CH_smartForm($('form', id_window), {
                    success: function (response) {
                        if (response.response == CH_RESULT.SUCCESS) {
                            CH_Tools.show_message("Intervento creato correttamente.", 'info');
                            CH_Tools.popup_window(CH_URL.interventions + '/stampa_ricevuta/' + response.id_intervention);
                            CH_page_reloader.set_url(CH_URL.interventions);
                            CH_page_reloader.reload();
                        } else {
                            CH_Tools.show_message(CH_Tools.lang('common_words_data_not_saved_msg'), 'error');
                        }
                    },
                    error: function () {

                    }
                });

            });
        }

        return {
            init: init
        };
    })();

    var List_tables_page = (function () {
        function init() {
            init_button_bar();
            init_tables();
        }

        function init_tables() {
            new CH_dataTable('#form-clients-list table', {
                ajax: CH_URL.clients + '/get_client_table_feed',
                sLengthMenu : 10,
                columns: [
                    {
                        data: "id",
                        render: function (data, type, row) {
                            return '<input type="radio" value="' + data + '" name="id">';
                        }
                    },
                    {"data": "fullname"},
                    {"data": "fiscal_code"},
                    {"data": "phone_1"},
                    {"data": "phone_2"}
//                    ,
//                    {
//                        data: "id",
//                        render: function (data, type, row) {
//                            return '<a href="#" class="create_intervention" title="Crea intervento" data-id-client="' + data + '"><i class="fa fa-fw fa-lg fa-plus"></i></a>';
//                        }
//                    }
                ]
            });
        }

        function init_button_bar() {
            var $form = $('#form-clients-list');
            $('.btn-client-edit', CANVAS_ID).on('click', function () {
                var $button = $(this);
                CH_Tools.on_row_selected($form, function () {
                    $form.attr('action', $button.attr('href')).submit();
                });
                return false;
            });
            
            $('.btn-new-repair', CANVAS_ID).on('click', function(){
                CH_Tools.on_row_selected($form, function ($checked) {
                    var id_client = $checked.val();
                    CH_Tools.load_overlay_window(CH_URL.interventions + '/new_intervention_window_show/' + id_client, '#new_intervention_window', function (id_window) {
                        $(id_window + ' .dataP').datepicker({'changeMonth' : true, "changeYear": true});
                        $(id_window + ' .btn-create-intervention').on('click',function(){$('form', id_window).submit();});
                        $(id_window).on('close', function () {
                            CH_page_reloader.set_url(CH_URL.clients);
                            CH_page_reloader.reload();
                        });
                        $form = new CH_smartForm($('form', id_window), {
                            success: function (response) {
                                if (response.response == CH_RESULT.SUCCESS) {
                                    CH_Tools.show_message("Intervento creato correttamente.", 'info');
                                    CH_Tools.popup_window(CH_URL.interventions + '/stampa_ricevuta/' + response.id_intervention);
                                    window.location.href = CH_URL.clients;
                                } else {
                                    CH_Tools.show_message(CH_Tools.lang('common_words_data_not_saved_msg'), 'error');
                                }
                            },
                            error: function () {

                            }
                        });
                        
                    });
                });
                return false;
            });

            $('.btn_send_activation_code', CANVAS_ID).on('click', function () {
//            CH_Tools.on_row_selected($form, function ($checked) {
//               Send_activation_code_mgr.show($checked.val());
//            });
//            return false;
            });

        }


        return {init: init};
    })();

    $(function () {
        switch (page) {
            case 'clients':
                List_tables_page.init();
                break;
            case 'edit_client':
                Client_editor_page.init();
                break;
        }
    });
})(jQuery, window, document);