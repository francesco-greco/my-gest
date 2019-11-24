(function ($, window, document, undefined) {

    var
            CANVAS_ID = '#interventions_main_container';

    var List_tables_page = (function () {
        function init() {
            init_button_bar();
            init_tables();
        }
        
        function init_button_bar(){
            var $form = $('#form-interventions-list');
            var $form_old = $('#form-old_interventions-list');
            $('#main_interventions_table').on('dblclick', 'tr', function () {
                $(CANVAS_ID + ' .btn_show').trigger('click');
            });
            
            $('#old_interventions_table').on('dblclick', 'tr', function () {
                $(CANVAS_ID + ' .btn_old_show').trigger('click');
            });
            
            $(CANVAS_ID + ' .btn_show').on('click', function () {
                var $button = $(this);
                CH_Tools.on_row_selected($form, function ($checked) {
                    window.location.href = CH_URL.interventions + "/show_intervention/" + $checked.val();
                });
                return false;
            });
            
            $(CANVAS_ID + ' .btn_old_show').on('click', function () {
                var $button = $(this);
                CH_Tools.on_row_selected($form_old, function ($checked) {
                    window.location.href = CH_URL.interventions + "/show_intervention/" + $checked.val();
                });
                return false;
            });
        }
        
        function init_tables() {
            new CH_dataTable('#form-interventions-list table', {
                ajax: CH_URL.interventions + '/get_interventions_table_feed',
                sLengthMenu: 10,
                columns: [
                    {
                        data: "id_intervention",
                        render: function (data, type, row) {
                            return '<input type="radio" value="' + data + '" name="id_intervention">';
                        }
                    },
                    {"data": "intervention_code"},
                    {
                        data: "creation_date",
                        render: function (data, type, row) {
                            return CH_Tools.formatDate(data);
                        }
                    },
                    {"data": "surname"},
                    {"data": "object_description"},
                    {"data": "brand_name"},
                    {"data": "serial_number"},
                    {"data": "garanzia",
                    render: function(data){
                      return data == 1 ? 'SI' : 'NO' 
                    }},
                    {"data": "sede"}

                ]
            });
            
            new CH_dataTable('#form-old_interventions-list table', {
                ajax: CH_URL.interventions + '/get_old_interventions_table_feed',
                sLengthMenu: 10,
                columns: [
                    {
                        data: "id_intervention",
                        render: function (data, type, row) {
                            return '<input type="radio" value="' + data + '" name="id_intervention">';
                        }
                    },
                    {"data": "intervention_code"},
                    {
                        data: "creation_date",
                        render: function (data, type, row) {
                            return CH_Tools.formatDate(data);
                        }
                    },
                    {"data": "surname"},
                    {"data": "object_description"},
                    {"data": "brand_name"},
                    {"data": "serial_number"},
                    {"data": "garanzia",
                    render: function(data){
                      return data == 1 ? 'SI' : 'NO' 
                    }},
                    {"data": "sede"}

                ]
            });
        }
        
        return {init: init};
    })();
    
    var Intervention_page = (function () {
        
        var CANVAS_ID = '#intervention_page';
        var id_intervention = $('#id_intervention').val();
        
        function init() {
            init_button_bar();
            init_note();
            init_processing_stage();
        }
        
        function init_button_bar() {
         $(CANVAS_ID + ' .btn_stampa_ricevuta').on('click', function (){
            CH_Tools.popup_window(CH_URL.interventions + '/stampa_ricevuta/' + id_intervention);
         });
         
         $(CANVAS_ID + ' #intervento_warranty_yes').on('change', function (){
            var value = $(this).val();
            var fields = {
               intervento_id: id_intervention,
               intervento_warranty_yes: value
            };
            CH_Tools.confirm("Si è certi di voler cambiare il parametro garanzia? se si ricordarsi di rivedere i costi, se impostati già per questo intervento!", function(){
               Load_anim.start();
               CH_Tools.post(CH_URL.interventions + "/change_intervention_warranty_mode", function(data){
                  if(data === CH_RESULT.SUCCESS){
                     Load_anim.stop();
                     Notify.message("Operazione effettuata!");
                     window.location.href = base_url + CH_URL.interventions + "/show_intervention/" + id_intervention;
                  } else {
                     Load_anim.stop();
                     Notify.error("Si è verificato un errore, riprovare!");
                  }
               }, fields);
            }, function(){
               var reset_value;
               if(value == 1){
                  reset_value = 2;
               } else if(value == 2){
                  reset_value = 1;
               }
               $(CANVAS_ID + ' #intervento_warranty_yes').val(reset_value);
               Notify.error("Operazione annullata!");
            });
         });
         
         $(CANVAS_ID + ' .btn_costi').on('click', function(){intervention_costs_window_show();});
         
         $('.btn-new-note').on('click', function () {
            var status = $('#intervention_status').val();
            if (status == 1) {
               CH_Tools.load_overlay_window(CH_URL.interventions + "/show_new_note_window/" + $(this).data('id-intervention'), '#new_note_container', function (id_window) {
                  var $form = $('#form_note');
                  $(id_window + ' .btn-nota-save').on('click', function () {
                     $('form', id_window).submit();
                  });
                  $form = new CH_smartForm($('form', id_window), {
                     success: function (response) {
                        if (response.response == CH_RESULT.SUCCESS) {
                           window.location.href = base_url + CH_URL.interventions + "/show_intervention/" + id_intervention;
                        } else {
                           CH_Tools.show_message("Errore salvataggio nota!", 'error');
                        }
                     },
                     error: function (err) {
                        console.log(err);
                     }
                  });
               });
            } else {
               CH_Tools.show_message("Riparazione chiusa impossibile eseguire azioni!", 'error');
            }
         });
         
         $('.btn-new-posthumous-note', CANVAS_ID).on('click', function () {
            CH_Tools.load_overlay_window(CH_URL.interventions + "/show_new_note_window/" + $(this).data('id-intervention'), '#new_note_container', function (id_window) {
               var $form = $('#form_note');
               $(id_window + ' .btn-nota-save').on('click', function () {
                  $('form', id_window).submit();
               });
               $form = new CH_smartForm($('form', id_window), {
                  success: function (response) {
                     if (response.response == CH_RESULT.SUCCESS) {
                        window.location.href = base_url + CH_URL.interventions + "/show_intervention/" + id_intervention;
                     } else {
                        CH_Tools.show_message("Errore salvataggio nota!", 'error');
                     }
                  },
                  error: function (err) {
                     console.log(err);
                  }
               });
            });
         });
      }
        
        function init_note(){
            var $note_container = $('.notes_container');
            $note_container.empty();
            CH_Tools.post(CH_URL.interventions + "/get_notes_intervention/" + id_intervention, function(response){
                var div = "";
                if(response.length == 0){
                    div += "<div class='note_div'>Nessuna nota da mostrare</div>";
                } else {
                    $.each(response, function(i,row){
                       div += "<div class='note_div'>";
                       div += "<div style='text-align: left;'><b>Data:</b> " + CH_Tools.formatDate(row.creation_date) + "</div>";
                       div += "<div style='text-align: left;'><b>Oper:</b> " + row.user_fullname + "</div>";
                       div += "<div style='text-align: left;'><b>Codice:</b> " + row.note_code + "</div>";
                       div += "<div style='text-align: left;'><b>Nota</b>: " + row.note_text + "</div>";
                       div += "</div>";
                    });
                }
                $note_container.append(div);
            });
        }
        
        function init_processing_stage(){
            CH_Tools.post(CH_URL.interventions + "/get_current_processing_stage/" + id_intervention, function(response){
               if(response.response == CH_RESULT.SUCCESS){
                   $('.processing_stage_label').html(response.processing_stage);
                   $('#intervention_status').val(response.status);
               } else {
                   CH_Tools.show_message("Si è verificato un errore!", 'error');
               }
            });
        }
        
        function intervention_costs_window_show() {
         CH_Tools.load_overlay_window(CH_URL.interventions + "/intervention_costs_window_show/" + id_intervention, '#new_costs_window', function (id_window) {
//            $('#manod', id_window).on('click', function () {
//               $('#materiali', id_window).removeClass('active');
//               $('#materialiTab', id_window).removeClass('active');
//               $('#cliente', id_window).removeClass('active');
//               $('#clienteTab', id_window).removeClass('active');
//               $('#manodopera', id_window).addClass('active');
//               $('#manodoperaTab', id_window).addClass('active');
//            });
//            $('#mater', id_window).on('click', function () {
//               $('#manodopera', id_window).removeClass('active');
//               $('#manodoperaTab', id_window).removeClass('active');
//               $('#cliente', id_window).removeClass('active');
//               $('#clienteTab', id_window).removeClass('active');
//               $('#materiali', id_window).addClass('active');
//               $('#materialiTab', id_window).addClass('active');
//            });
//            $('#cliente', id_window).on('click', function () {
//               $('#manodopera', id_window).removeClass('active');
//               $('#manodoperaTab', id_window).removeClass('active');
//               $('#cliente', id_window).addClass('active');
//               $('#clienteTab', id_window).addClass('active');
//               $('#materiali', id_window).removeClass('active');
//               $('#materialiTab', id_window).removeClass('active');
//            });
            get_table_data_details();

            function get_table_data_details() {
               var body_table_manodopera = $(id_window + ' #body_table_manodopera');
               var body_table_materiali = $(id_window + ' #costo_materiali_body');
               var tr_manodopera = "";
               var tr_materiali = "";
               body_table_manodopera.empty();
               body_table_materiali.empty();
               CH_Tools.get(CH_URL.interventions + "/get_intervention_cost_details/" + id_intervention, function (data) {
                  if (data.manodopera_details.length === 0) {
                     tr_manodopera += "<tr><td colspan='5'>Non sono presenti dati da mostrare</td></tr>";
                  } else {
                     $.each(data.manodopera_details, function(i,row){
                        tr_manodopera += "<tr>";
                        tr_manodopera += "<td style='text-align: center'>" + row.quantita + "</td>";
                        tr_manodopera += "<td style='text-align: center'>" + row.descrizione + "</td>";
                        tr_manodopera += "<td style='text-align: center'>" + row.prezzo_unitario + "</td>";
                        tr_manodopera += "<td style='text-align: center'>" + row.totale + "</td>";
                        tr_manodopera += "<td style='text-align: center'></td>";
                        tr_manodopera += "</tr>";
                     });
                  }
                  body_table_manodopera.append(tr_manodopera);
                  if (data.materiali_details.length === 0) {
                     tr_materiali += "<tr><td colspan='7'>Non sono presenti dati da mostrare</td></tr>";
                  } else {
                     $.each(data.manodopera_details, function(i,row){
                        tr_manodopera += "<tr>";
                        tr_manodopera += "<td style='text-align: center'>" + row.id_brand + "</td>";
                        tr_manodopera += "<td style='text-align: center'>" + row.codice_articolo + "</td>";
                        tr_manodopera += "<td style='text-align: center'>" + row.descrizione + "</td>";
                        tr_manodopera += "<td style='text-align: center'>" + row.unita_misura + "</td>";
                        tr_manodopera += "<td style='text-align: center'>" + row.quantita + "</td>";
                        tr_manodopera += "<td style='text-align: center'>" + row.totale + "</td>";
                        tr_manodopera += "<td style='text-align: center'></td>";
                        tr_manodopera += "</tr>";
                     });
                  }
                  body_table_materiali.append(tr_materiali);
               });
            }
         });
      }
        return {init: init};
    })();


    $(function () {
        switch (page) {
            case 'interventions_main':
                List_tables_page.init();
                break;
            case 'intervention_page':
                Intervention_page.init();
                break;
        }
    });
})(jQuery, window, document);