(function ($, window, document, undefined) {
   
var Fornitori_main = (function () {

        var
                CANVAS_ID = '#fornitori_main';

        function init() {
            init_buttons_bar();
            init_datatable();
        }

        function init_buttons_bar() {
            $(CANVAS_ID + ' .btn_add').on('click', show_new_supplier_window);
            $(CANVAS_ID + ' .btn_show').on('click', show_supplier_page);
            $('#fornitori_list_table').on('dblclick', 'tr', function () {
                $(CANVAS_ID + ' .btn_show').trigger('click');
            });
        }

        function init_datatable() {
            new CH_dataTable('#form-fornitori-list table', {
                ajax: base_url + CH_URL.fornitori + "/get_fornitori_table_feed",
                sLengthMenu: 10,
                columns: [
                    {
                        data: "id_fornitore",
                        render: function (data, type, row) {
                            return '<input type="radio" value="' + data + '" name="id_fornitore">';
                        }
                    },
                    {
                       data: "ragione_sociale",
                        render: function (data, type, row) {
                            return '<p>' + data + '</p>';
                        }
                    },
                    {"data": "telefono_1"},
                    {"data": "telefono_2"},
                    {"data": "referente"},
                    {"data": "referente_recapito"},
                    {"data": "email"}
                ]
            });
        }
        
        function show_new_supplier_window() {
         CH_Tools.load_overlay_window(CH_URL.fornitori + "/show_new_supplier_window", '#new_supplier', function (id_window) {
            
            $(id_window + ' .btn-create-supplier').on('click', function () {
               if($('form', id_window).valid()) Load_anim.start();
               $('form', id_window).submit();
            });

            $form = new CH_smartForm($('form', id_window), {
               success: function (response) {
                  if (response == CH_RESULT.SUCCESS) {
                     Load_anim.stop();
                     window.location.href = base_url + CH_URL.fornitori;
                  } else {
                     Load_anim.stop();
                     CH_Tools.show_message("Errore salvataggio fornitore!", 'error');
                  }
               },
               error: function (err) {
                  console.log(err);
               }
            });
         });
      }
      
      function show_supplier_page() {
         var $form = $('#form-fornitori-list');
         var $button = $(this);
         CH_Tools.on_row_selected($form, function ($checked) {
            window.location.href = CH_URL.fornitori + "/show_supplier/" + $checked.val();
         });
         return false;
      }

        return {
            init: init
        };

    })();
    
    var Supplier_page = (function(){
       
       var CANVAS_ID = '#fornitore_page';
       var supplier_id = $(CANVAS_ID + ' #fornitore_id').val();

        function init() {
            init_buttons_bar();
        }
        
        function init_buttons_bar(){
           $(CANVAS_ID + ' .btn_save').on('click', save_supplier);
        }
        
        function save_supplier(){
           if($('form', CANVAS_ID).valid()) Load_anim.start();
           $('form', CANVAS_ID).submit();
           
        }
        
        $form = new CH_smartForm($('form', CANVAS_ID), {
               success: function (response) {
                  if (response == CH_RESULT.SUCCESS) {
                     Load_anim.stop();
                     window.location.href = base_url + CH_URL.fornitori + "/show_supplier/" + supplier_id;
                  } else {
                     Load_anim.stop();
                     CH_Tools.show_message("Errore salvataggio fornitore!", 'error');
                  }
               },
               error: function (err) {
                  console.log(err);
               }
            });
       
       return {
            init: init
        };
       
    })();


    $(function () {
      switch (page) {
         case 'fornitori_main':
            Fornitori_main.init();
            break;
         case 'supplier_page':
            Supplier_page.init();
            break;
      }
   });
})(jQuery, window, document);


