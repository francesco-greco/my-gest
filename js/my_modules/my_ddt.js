(function ($, window, document, undefined) {
   var
           CANVAS_ID = '#ddt_page';


   Ddt_page = (function () {

      var id_ddt = $(CANVAS_ID + ' #ddt_id').val();
      var stato = $(CANVAS_ID + ' #ddt_stato').val();
      var id_brand;

      function init() {
         init_button_menu();
         init_details_table();
         init_action();
      }
      
      function init_action(){
         $(CANVAS_ID + ' #dettaglio_id_brand').on('change', function(){
            var id_brand = $( "#dettaglio_id_brand option:selected" ).val();
            CH_Tools.create_autocomplete('#dettaglio_codice_articolo', CH_URL.ddt + "/get_list_details/" + id_brand,
              function (e, ui) {
                 console.log(ui.codice + " --- " + ui.descrizione);
                 $(CANVAS_ID + ' #dettaglio_codice_articolo').val(ui.item.codice);
                 $(CANVAS_ID + ' #dettaglio_descrizione').val(ui.item.descrizione);
                 e.preventDefault();
                 return false;
              },
              function (ul, item) {
                 return $("<li>")
                         .append("<a>" + item['codice'] + " " + item['descrizione'] + "</a>")
                         .appendTo(ul);
              },
              {minLength: 3});
              CH_Tools.create_autocomplete('#dettaglio_descrizione', CH_URL.ddt + "/get_list_details/" + id_brand,
              function (e, ui) {
                 console.log(ui.codice + " --- " + ui.descrizione);
                 $(CANVAS_ID + ' #dettaglio_codice_articolo').val(ui.item.codice);
                 $(CANVAS_ID + ' #dettaglio_descrizione').val(ui.item.descrizione);
                 e.preventDefault();
                 return false;
              },
              function (ul, item) {
                 return $("<li>")
                         .append("<a>" + item['codice'] + " " + item['descrizione'] + "</a>")
                         .appendTo(ul);
              },
              {minLength: 3});
         });
      }
      
      

      function init_button_menu() {
         $(CANVAS_ID + ' .btn_save').on('click', function () {
            $(CANVAS_ID + ' #form_save_ddt').submit();
         });
         $(CANVAS_ID + ' .detail_save').on('click', function () {
            detail_ddt_save();
         });
         $('#ddt_details').on('click', '.btn_delete',function(){delete_detail($(this));});
         $(CANVAS_ID + ' .btn_close').on('click', close_ddt);
      }

      function init_details_table() {
         var $table_body = $(CANVAS_ID + ' #ddt_details_body');
         $table_body.empty();
         CH_Tools.get(CH_URL.ddt + "/get_datails/" + id_ddt, function (data) {
            var tr = '';
            if (data.length == 0) {
               tr += "<tr><td colspan='5'>Nessun dettaglio presente.</td></tr>";
            } else {
               $.each(data, function (i, row) {
                  tr += "<tr>";
                  tr += "<td>" + row.codice_brand + "</td>";
                  tr += "<td>" + row.codice_articolo + "</td>";
                  tr += "<td>" + row.descrizione + "</td>";
                  tr += "<td>" + row.unita_misura + "</td>";
                  tr += "<td>" + row.quantita + "</td>";
                  if(stato == 1){
                     tr += "<td style='text-align: center;'><a href='#' class='btn_delete' data-id-detail='" + row.id +  "' title='Elimina'><i class='fa fa-fw fa-lg fa-trash'></i></a></td>";
                  } else {
                     tr += "<td></td>";
                  }
                  tr += "</tr>";
               });
            }
            $table_body.append(tr);
         });
      }
      
      function delete_detail(field){
         Load_anim.start();
         var id_detail = field.data('id-detail');
         CH_Tools.post(CH_URL.ddt + "/delete_detail/" + id_detail, function(data){
            if(data == CH_RESULT.SUCCESS){
               Load_anim.stop();
               Notify.message("Dettaglio eliminato.");
               init_details_table();
            } else {
               Load_anim.stop();
               Notify.error("Attenzione si è verificato un errore, riprovare!");
            }
         });
      }

      function detail_ddt_save() {
         var id_brand = $(CANVAS_ID + ' #dettaglio_id_brand').val();
         var codice = $(CANVAS_ID + ' #dettaglio_codice_articolo').val();
         var um = $(CANVAS_ID + ' #dettaglio_unita_misura').val();
         var quantita = $(CANVAS_ID + ' #dettaglio_quantita').val();
         var dati = {
            id_brand: id_brand,
            codice: codice,
            um: um,
            quantita: quantita,
            id_ddt: id_ddt
         };
         if (id_brand == '' || codice == '' || um == '' || quantita == '') {
            CH_Tools.show_message("Attenzione compilare tutti i campi!", 'error');
         } else {
            CH_Tools.post(CH_URL.ddt + "/save_ddt_detail", function (data) {
               if (data.error != false) {
                  CH_Tools.show_message(data.message, 'error');
                  reset_campi();
               } else {
                  reset_campi();
                  init_details_table();
               }
            }, dati);
         }
      }

      function reset_campi() {
//         $(CANVAS_ID + ' #dettaglio_id_brand').val('');
         $(CANVAS_ID + ' #dettaglio_codice_articolo').val('');
         $(CANVAS_ID + ' #dettaglio_unita_misura').val('');
         $(CANVAS_ID + ' #dettaglio_quantita').val('');
         $(CANVAS_ID + ' #dettaglio_descrizione').val('');
      }

      $form = new CH_smartForm($('form', CANVAS_ID), {
         success: function (response) {
            if (response.response == CH_RESULT.SUCCESS) {
               Load_anim.stop();
               window.location.href = base_url + CH_URL.ddt + "/show_ddt_view/" + id_ddt;
            } else {
               Load_anim.stop();
               CH_Tools.show_message("Errore salvataggio fornitore!", 'error');
            }
         },
         error: function (err) {
            console.log(err);
         }
      });

      function new_ddt_show() {
         if (confirm("Si è certi di voler compilare un DDT?")) {
            CH_Tools.load_overlay_window(CH_URL.ddt + "/show_new_ddt_window", '#new_ddt_window', function (id_window) {
               $(id_window + ' .btn-save').on('click', function () {
                  if ($(id_window + ' #form_new_ddt').valid() === true) {
                     if ($(id_window + ' #ddt_id_fornitore').val() !== '' && $(id_window + ' #ddt_id_fornitore').val() !== null && $(id_window + ' #ddt_id_fornitore').val() !== undefined) {
                        Load_anim.start();
                        $(id_window + ' #form_new_ddt').submit();
                     } else {
                        Notify.error("Dati fornitore non presenti in anagrafica o errati, reinserire!");
                        $(id_window + ' #form_new_ddt')[0].reset();
                     }
                  }
               });
               $(id_window + ' .dataP').datepicker({maxDate: '0'});
               CH_Tools.create_autocomplete('#ddt_ragione_sociale', CH_URL.fornitori + "/get_list",
                       function (e, ui) {
                          $(id_window + ' #ddt_id_fornitore').val(ui.item.id);
                          $(id_window + ' #ddt_ragione_sociale').val(ui.item.ragione_sociale);
                          $(id_window + ' #ddt_cf').val(ui.item.codice_fiscale);
                          $(id_window + ' #ddt_p_iva').val(ui.item.p_iva);
                          e.preventDefault();
                          return false;
                       },
                       function (ul, item) {
                          return $("<li>")
                                  .append("<a>" + item.ragione_sociale + "</a>")
                                  .appendTo(ul);
                       },
                       {minLength: 3});
               CH_Tools.create_autocomplete('#ddt_cf', CH_URL.fornitori + "/get_list",
                       function (e, ui) {
                          $(id_window + ' #ddt_id_fornitore').val(ui.item.id);
                          $(id_window + ' #ddt_ragione_sociale').val(ui.item.ragione_sociale);
                          $(id_window + ' #ddt_cf').val(ui.item.codice_fiscale);
                          $(id_window + ' #ddt_p_iva').val(ui.item.p_iva);
                          e.preventDefault();
                          return false;
                       },
                       function (ul, item) {
                          return $("<li>")
                                  .append("<a>" + item.codice_fiscale + "</a>")
                                  .appendTo(ul);
                       },
                       {minLength: 3});
               CH_Tools.create_autocomplete('#ddt_p_iva', CH_URL.fornitori + "/get_list",
                       function (e, ui) {
                          $(id_window + ' #ddt_id_fornitore').val(ui.item.id);
                          $(id_window + ' #ddt_ragione_sociale').val(ui.item.ragione_sociale);
                          $(id_window + ' #ddt_cf').val(ui.item.codice_fiscale);
                          $(id_window + ' #ddt_p_iva').val(ui.item.p_iva);
                          e.preventDefault();
                          return false;
                       },
                       function (ul, item) {
                          return $("<li>")
                                  .append("<a>" + item.p_iva + "</a>")
                                  .appendTo(ul);
                       },
                       {minLength: 3});
               $form = new CH_smartForm($('form', id_window), {
                  success: function (response) {
                     if (response.response == CH_RESULT.SUCCESS) {
                        Load_anim.stop();
                        window.location.href = CH_URL.ddt + "/show_ddt_view/" + response.id_ddt;
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
         };
      }
      
      function close_ddt() {
         var c = confirm("Si è certi di voler marcare il DDT come chiuso?");
         if (c == true) {
            Load_anim.start();
            CH_Tools.post(CH_URL.ddt + "/close_ddt/" + id_ddt, function (data) {
               if (data.response == CH_RESULT.SUCCESS) {
                  Load_anim.stop();
                  if(data.action != false){
                     Notify.message(data.message);
                     window.location.href = base_url + CH_URL.ddt + "/show_ddt_view/" + id_ddt;
                  } else {
                     Load_anim.stop();
                     Notify.message(data.message);
                  }
               } else {
                  Notify.error(data.message);
               }
            });
         } else {
            Notify.message("Operazione annullata");
         }
      }

      return {
         init: init,
         new_ddt_show: new_ddt_show
      };

   })();

   Ddt_list_page = (function () {

      var CANVAS_ID = '#ddt_list_page_container';

      function init() {
         init_buttons_bar();
         init_datatable();
      }
      
      function init_buttons_bar(){
         $(CANVAS_ID + ' .btn_show').on('click', function (){
            show_ddt_page();
         });
         $(CANVAS_ID + ' .btn_old_show').on('click', function (){
            show_old_ddt_page();
         });
         $('#ddt_list_table').on('dblclick', 'tr', function () {
                $(CANVAS_ID + ' .btn_show').trigger('click');
            });
         $('#ddt_list_table_old').on('dblclick', 'tr', function () {
                $(CANVAS_ID + ' .btn_old_show').trigger('click');
            });   
      }
      
      function show_ddt_page() {
         var $form = $('#form-ddt-list');
         CH_Tools.on_row_selected($form, function ($checked) {
            window.location.href = base_url + CH_URL.ddt + "/show_ddt_view/" + $checked.val();
         });
         return false;
      }
      
      function show_old_ddt_page() {
         var $form = $('#form-ddt-list-old');
         CH_Tools.on_row_selected($form, function ($checked) {
            window.location.href = base_url + CH_URL.ddt + "/show_ddt_view/" + $checked.val();
         });
         return false;
      }
      
      function init_datatable(){
         new CH_dataTable('#form-ddt-list table', {
                ajax: base_url + CH_URL.ddt + "/get_ddt_table_feed",
                sLengthMenu: 10,
                columns: [
                    {
                        data: "id_ddt",
                        render: function (data, type, row) {
                            return '<input type="radio" value="' + data + '" name="id_ddt">';
                        }
                    },
                    {"data": "sede"},
                    {"data": "fornitore"},
                    {
                       data: "data_documento",
                        render: function (data, type, row) {
                            return CH_Tools.formatDate(data);
                        }
                    },
                    {"data": "numero_documento"}
                ]
            });
         new CH_dataTable('#form-ddt-list-old table', {
                ajax: base_url + CH_URL.ddt + "/get_ddt_old_table_feed",
                sLengthMenu: 10,
                columns: [
                    {
                        data: "id_ddt",
                        render: function (data, type, row) {
                            return '<input type="radio" value="' + data + '" name="id_ddt">';
                        }
                    },
                    {"data": "sede"},
                    {"data": "fornitore"},
                    {
                       data: "data_documento",
                        render: function (data, type, row) {
                            return CH_Tools.formatDate(data);
                        }
                    },
                    {"data": "numero_documento"}
                ]
            });   
      }

      return {
         init: init
      };

   })();


   $(function () {
      switch (page) {
         case 'ddt_view':
            Ddt_page.init();
            break;
         case 'ddt_list_page':
            Ddt_list_page.init();
            break;
      }
   });

})(jQuery, window, document);


