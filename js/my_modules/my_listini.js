(function ($, window, document, undefined) {
    var
            CANVAS_ID = '#listini_main';

    var Listini_page = (function () {

        function init() {
            $('.btn-new-listino').on('click', show_new_listino_window);
        }

        function show_new_listino_window() {
            CH_Tools.load_overlay_window(CH_URL.listini + "/show_new_listino_window/", '#new_listino_window', function (id_window) {
                $(id_window + ' .btn-listino-save').on('click', function () {
                    $('form', id_window).submit();
                });
                $form = new CH_smartForm($('form', id_window), {
                    success: function (response) {
                        if (response == CH_RESULT.SUCCESS) {
                            CH_Tools.show_message("Salvataggio listino avvenuto correttamente!", 'message');
                        } else {
                            CH_Tools.show_message("Errore salvataggio listino!", 'error');
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });
        }


        return {
            init: init
        };
    })();

    var Listini_dettagli_page = (function () {

        var
                CANVAS_ID = '#listini_dettagli';
        var dat;

        function init() {
            init_buttons_bar();
            init_datatable();
        }

        function init_buttons_bar() {
            var $form = $('#form-listini-list');
            $(CANVAS_ID + ' .btn_show').on('click', function () {
                var $button = $(this);
                CH_Tools.on_row_selected($form, function ($checked) {
                    show_details_listino($checked.val());
                });
                return false;
            });
            $("#listini_list_table").on('dblclick', 'tr', function () {
                $(CANVAS_ID + ' .btn_show').trigger('click');
            });
        }

        function show_details_listino(id_listino) {
            CH_Tools.load_overlay_window(CH_URL.listini + "/show_details_listino_window/" + id_listino, '#listino_details_window', function (id_window) {
                $(id_window + ' .btn-listino-save').on('click', function () {
                    $('form', id_window).submit();
                });
                $form = new CH_smartForm($('form', id_window), {
                    success: function (response) {
                        if (response == CH_RESULT.SUCCESS) {
                            CH_Tools.show_message("Salvataggio listino avvenuto correttamente!", 'message');
                            window.location.href = base_url + CH_URL.listini + "/show_listini";
                        } else {
                            CH_Tools.show_message("Errore salvataggio listino!", 'error');
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });
        }

        function init_datatable() {
            dat = new CH_dataTable('#form-listini-list table', {
                ajax: {url: base_url + CH_URL.listini + "/get_listini_table_feed", data: function (data) {
                  var brand_code = $('#brand_code').val();
                  data.brand_code = brand_code;
               }},
                
                sLengthMenu: 10,
                columns: [
                    {
                        data: "id_listino",
                        render: function (data, type, row) {
                            return '<input type="radio" value="' + data + '" name="id_listino">';
                        },
                        bSearchable: false
                    },
                    {
                       data: "brand",
                        render: function (data, type, row) {
                            return '<p>' + data + '</p>';
                         }
                    },
                    {"data": "codice"},
                    {"data": "acquisto",
                        bSearchable: false},
                    {"data": "vendita_1",
                        bSearchable: false},
                    {"data": "acquisto_prezzo_netto",
                        bSearchable: false},
                    {"data": "rifatturazione",
                        bSearchable: false},
                    {
                       data: "descrizione",
                        render: function (data, type, row) {
                            return '<p>' + data + '</p>';
                         }
                    }
                ]
            });
            
            $(CANVAS_ID + ' #brand_code').change(function () {
              dat.reload();
            });
        }
        
        return {
            init: init
        };

    })();


    $(function () {
        switch (page) {
            case 'listini_main':
                Listini_page.init();
                break;
            case 'listini_dettagli':
                Listini_dettagli_page.init();
                break;
        }
    });
})(jQuery, window, document);
