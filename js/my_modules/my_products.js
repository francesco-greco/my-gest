(function ($, window, document, undefined) {
   
var Nuovo_articolo_page = (function () {

        var
                CANVAS_ID = '#carica_articoli_container';

        function init() {
            init_buttons_bar();
            init_datatable();
        }

        function init_buttons_bar() {
            var $form = $('#form-articoli-list');
            $(CANVAS_ID + ' .btn_show').on('click', function () {
                var $button = $(this);
                CH_Tools.on_row_selected($form, function ($checked) {
                    window.location.href = base_url + CH_URL.products + "/show_details_article/" + $checked.val();
                });
                return false;
            });
            $("#articoli_list_table").on('dblclick', 'tr', function () {
                $(CANVAS_ID + ' .btn_show').trigger('click');
            });
        }

        function show_details_article(id_listino) {
            CH_Tools.load_overlay_window(CH_URL.products + "/show_details_article/" + id_listino, '#article_details_window', function (id_window) {
                $(id_window + ' .btn-listino-save').on('click', function () {
                    $('form', id_window).submit();
                });
                $(id_window + ' .btn-action').on('click', function(){
                    var icon_action = $('#icon_action');
                    var form_container = $('#form_container');
                    if(icon_action.hasClass('fa-lock')){
                       icon_action.removeClass('fa-lock').addClass('fa-unlock');
                       form_container.removeClass('hide');
                    } else if(icon_action.hasClass('fa-unlock')){
                       icon_action.removeClass('fa-unlock').addClass('fa-lock');
                       form_container.addClass('hide');
                    }
                });
                $form = new CH_smartForm($('form', id_window), {
                    success: function (response) {
                        if (response == CH_RESULT.SUCCESS) {
                            CH_Tools.show_message("Salvataggio avvenuto correttamente!", 'message');
                            window.location.href = base_url + CH_URL.products + "/carica_articoli_view";
                        } else {
                            CH_Tools.show_message("Errore salvataggio dati!", 'error');
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });
        }

        function init_datatable() {
         var dataTable = new CH_dataTable('#form-articoli-list table', {
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
               {"data": "brand",
                  bSearchable: false},
               {"data": "brand_code",
                  bSearchable: false},
               {"data": "codice"},
               {"data": "descrizione"}
            ]
         });

         $(CANVAS_ID + ' #brand_code').change(function () {
            dataTable.reload();
         });
      }

      return {
         init: init
      };

   })();
    
   var Magazzino_main = (function () {

      var
              CANVAS_ID = '#products_main';

      function init() {
         init_buttons_bar();
      }

      function init_buttons_bar(){
         $(CANVAS_ID + ' .btn-crea-magazzino').on('click', show_new_magazzino);
         $(CANVAS_ID + ' .btn-importa-listino-gesat').on('click', show_import_listino_from_gesat);
      }
      
      function show_new_magazzino() {
         CH_Tools.load_overlay_window(CH_URL.products + "/nuovo_magazzino_show", '#nuovo_magazzino', function (id_window) {
            $(id_window + ' input').keyup(function () {
               $(this).val($(this).val().toUpperCase());
            });
            $(id_window + ' .abilita-magazzino').on('click', function () {
               var $icon = $(id_window + ' .abilita-magazzino').find('i');
               var $abilitato = $(id_window + ' #magazzino_abilitato');
               if ($icon.hasClass('fa-unlock')) {
                  var r = confirm("Si è certi di voler creare il magazzino disabilitato in partenza?");
                  if (r === true) {
                     $icon.removeClass('fa-unlock').addClass('fa-lock');
                     $abilitato.val(2);
                  }
               } else {
                  $icon.removeClass('fa-lock').addClass('fa-unlock');
                  $abilitato.val(1);
               }
            });
            $(id_window + ' .btn-magazzino-save').on('click', function(){
               $('form', id_window).submit();
                Load_anim.start();
            });
            $form = new CH_smartForm($('form', id_window), {
               success: function (response) {
                  if (response == CH_RESULT.SUCCESS) {
                     CH_Tools.show_message("Salvataggio avvenuto correttamente!", 'message');
                      Load_anim.stop();
                  } else {
                     CH_Tools.show_message("Errore salvataggio dati!", 'error');
                     Load_anim.stop();
                  }
               },
               error: function (err) {
                  Load_anim.stop();
                  console.log(err);
               }
            });
         });
      }
      
      function show_import_listino_from_gesat(){
         CH_Tools.load_overlay_window(CH_URL.products + '/importa_listino_da_gesat_show', '#import_gesat_container', function (id_window) {
            $(id_window + ' .btn-start-upload').on('click', function(){$(id_window + ' form').submit();});
         });
      }
      
      return {
         init: init
      };

   })();
   
   
   var Gestione_ubicazioni = (function () {

      var
              CANVAS_ID = '#gestione_ubicazioni',
              SELECT = '#ubicazione_id_magazzino',
              TABLE = '#table_ubicazioni',
              TABLE_BODY = '#body_table_ubicazioni';

      function init() {
         init_buttons_bar();
         init_table();
         init_actions();
         init_form();
      }
      
      function init_form(){
         $form = new CH_smartForm($('form', CANVAS_ID), {
               success: function (response) {
                  if (response == CH_RESULT.SUCCESS) {
                      Load_anim.stop();
                      init_table();
                      resetta_campi();
                  } else {
                     Load_anim.stop();
                     alert('Attenzione, si è verificato un errore, riprovare!');
                  }
               },
               error: function (err) {
                  Load_anim.stop();
                  alert('Attenzione, si è verificato un errore, riprovare!');
                  console.log(err);
               }
            });
      }
      
      function resetta_campi(){
         $('#ubicazione_codice_ubicazione', CANVAS_ID).val('');
         $('#ubicazione_descrizione', CANVAS_ID).val('');
         $(CANVAS_ID + ' #ubicazione_tipologia')[0].selectedIndex = 0;
      }
      
      function init_actions(){
         $(CANVAS_ID + ' #ubicazione_id_magazzino').on('change', function(){init_table();});
         $(CANVAS_ID + ' input').keyup(function () {$(this).val($(this).val().toUpperCase());});
      }

      function init_buttons_bar(){
         $(TABLE).on('click', '.delete-ubicazione',function(){delete_ubicazione($(this));});
         $(TABLE).on('click', '.add-ubicazione',function(){
            if($('form', CANVAS_ID).valid()){
               Load_anim.start();
               $('form', CANVAS_ID).submit();
            }
         });
      }
      
      function init_table(){
         var id_magazzino = $("select[name='ubicazione_id_magazzino']").val();
         if(id_magazzino == ''){
            null_body();
         } else {
            CH_Tools.get(CH_URL.products + "/get_lista_ubicazioni/" + id_magazzino, function(data){
               if(data.length === 0){
                  null_body();
               } else {
                  var tr = '';
                  $.each(data, function(i,row){
                     tr += '<tr>';
                     tr += '<td>' + row.codice_ubicazione + '</td>';
                     tr += '<td>' + row.descrizione + '</td>';
                     tr += '<td>' + compute_tipologia(row.tipologia) + '</td>';
                     tr += '<td style="text-align: center"><a href="#" class="delete-ubicazione" data-id_ubicazione="' + row.id + '"><i class="icon fa fa-lg fa-trash"></i></a></td>';
                     tr += '</tr>';
                  });
                  $(CANVAS_ID + ' ' + TABLE_BODY).empty().append(tr);
               }
            });
         }
      }
      
      function compute_tipologia(tipo){
         var string = "";
         switch (tipo) {
            case 'SC':
               string = "Scaffale";
               break;
            case 'CS':
               string = "Cassetto";
               break;
            case 'PD':
               string = "Pedana";
               break;   
            case 'MS':
               string = "Mensola";
               break;   
         }
         return string;
      }
      
      function null_body(){
         var tr = '';
         tr += '<tr>';
         tr += '<td colspan="4">Nessun elemento da mostrare</td></tr>';
         $(CANVAS_ID + ' ' + TABLE_BODY).empty().append(tr);
         console.log('reset tabella');
      }
      
      function delete_ubicazione(field){
         var id_ubicazione = field.data('id_ubicazione');
         CH_Tools.get(CH_URL.products + "/cancella_ubicazione/" + id_ubicazione, function(response){
            if(response == CH_RESULT.SUCCESS){
               init_table();
            } else {
               alert('Si è verificato un errore riprovare!');
            }
         });
      }
      
      return {
         init: init
      };

   })();
   
   var Azioni_magazzino = (function () {

        var
                CANVAS_ID = '#azioni_magazzino_zero';

        function init() {
            init_buttons_bar();
            init_datatable();
        }

        function init_buttons_bar() {
           $(CANVAS_ID + ' .nuovo_movimento').on('click', show_crea_nuovo_movimento); 
        }
        
        function show_crea_nuovo_movimento(){
           CH_Tools.load_overlay_window(CH_URL.products + "/crea_nuovo_movimento_show", '#nuovo_movimento', function (id_window) {
              var $movimento_dettagli = $(id_window + ' .movimento_dettagli');
              $(id_window + ' #movimento_id_sede').on('change', build_select_magazzino);
              $(id_window + ' .conferma-blocca').on('click', manage_action_move);
              
            function build_select_magazzino() {
               var id_sede = $(this).val();
               var $select_magazzini = $(id_window + ' #select_magazzini');
               if (id_sede != '') {
                  $select_magazzini.addClass('loading-right');
                  CH_Tools.get(CH_URL.products + "/get_lista_magazzini_by_sede_ajax/" + id_sede, function (data) {
                     if (data != false && data != null) {
                        var options = "<option value=''> --- </option>";
                        $select_magazzini.empty();
                        $.each(data, function (i, magazzino_dto) {
                           options += "<option value='" + magazzino_dto.id + "'>(" + magazzino_dto.codice + ") " + magazzino_dto.nome + "</option>";
                        });
                        $select_magazzini.append(options);
                     } else {
                        Notify.error("Attenzione si è verificato un errore!");
                     }
                     $select_magazzini.removeClass('loading-right');
                  });
               } else {
                  var options = "<option value=''> --- </option>";
                  $select_magazzini.empty();
                  $select_magazzini.addClass('loading-right');
                  $select_magazzini.append(options);
                  $select_magazzini.removeClass('loading-right');
               }
            }
            
            function manage_action_move(){
               var id_sede = $(id_window + ' #movimento_id_sede').val();
               var id_magazzino = $(id_window + ' #select_magazzini').val();
               if(id_sede == '' || id_magazzino == ''){
                  Notify.error("Selezionare valori mancanti!");
               } else {
                  var c = confirm("Si è certi di voler creare il movimento?");
                  if (c === true) {
                     Load_anim.start();
                     CH_Tools.post(CH_URL.products + "/crea_nuovo_movimento", function(data){
                        if(data.response != CH_RESULT.SUCCESS){
                           Notify.error("Si è verificato un errore!");
                           Load_anim.stop();
                        } else {
                           Load_anim.stop();
                           window.location.href = base_url + CH_URL.products + "/compila_dettagli_movimento/" + data.id_movimento;
                        }
                     },{'id_sede': id_sede, 'id_magazzino': id_magazzino, 'tipo_movimento': tipo_movimento.da_0_ad_altro});
                  } else {
                     Notify.message("Operazione annullata!");
                  }
               }
            }
           });
        }
        
        function init_datatable() {
            new CH_dataTable('#form-articoli-magazzino-zero-list table', {
                ajax: base_url + CH_URL.products + "/get_prodotti_magazzino_zero_table_feed",
                sLengthMenu: 10,
                columns: [
                    {
                        data: "id_listino",
                        render: function (data, type, row) {
                            return '<input type="radio" value="' + data + '" name="id_listino">';
                        }
                    },
                    {"data": "brand"},
                    {"data": "brand_code"},
                    {"data": "codice"},
                    {"data": "descrizione"},
                    {"data":"quantita"},
                    {data: "last_date",
                       render: function(data, type, row){
                          return CH_Tools.formatDate(data);
                       }
                    }
                ]
            });
        }

        return {
            init: init
        };

    })();
    
    var Movimento_dettagli_page = (function(){
       
       var canvas_id = '#movimento_dettagli_container';
       var move_id = $(canvas_id + ' #id_movimento').val();
       var stato = $(canvas_id + ' #stato_movimento').val();
       
       function init() {
         init_buttons();
         build_details_table();
         CH_Tools.create_autocomplete('#descrizione', CH_URL.products + "/autocomplete_articoli",
                 function (e, ui) {
                    $(canvas_id + ' #brand').val(ui.item.brand_code);
                    $(canvas_id + ' #codice').val(ui.item.listino_codice);
                    $(canvas_id + ' #descrizione').val(ui.item.descrizione);
                    $(canvas_id + ' #id_listino').val(ui.item.id_listino);
                    $(canvas_id + ' #quantita_da_0').val(ui.item.quantita_da_0);
                    e.preventDefault();
                    return false;
                 },
                 function (ul, item) {
                    return $("<li>")
                            .append("<a>(" + item.brand_code + ") " + item.listino_codice + " " + item.descrizione + " Pz." + item.quantita_da_0 + "</a>")
                            .appendTo(ul);
                 },
                 {minLength: 3});
      }
      
      function build_details_table(){
         CH_Tools.post(CH_URL.products + "/get_list_movements_details", function(response){
            var $body_table = $(canvas_id + ' #body_table_movimento_dettagli');
            var tr = "";
            if(response.length == 0){
               tr += '<tr><td colspan="6">Nessun dettaglio da visualizzare</td></tr>';
            } else {
               $.each(response, function (i, row) {
                  tr += '<tr>';
                  tr += '<td style="text-align: center; width: 90px;">' + row.brand_code +'</td>';
                  tr += '<td style="text-align: center; width: 120px">' + row.codice +'</td>';
                  tr += '<td style="text-align: center;">' + row.descrizione +'</td>';
                  tr += '<td style="text-align: center; width: 80px;">' + row.quantita +'</td>';
                  tr += '<td style="text-align: center; width: 110px;">' + (row.codice_ubicazione === null ? "---" : row.codice_ubicazione) +'</td>';
                  if(stato == 1){
                     tr += '<td style="text-align: center; width: 40px;"><a href="#" class="delete-detail"><i class="fa fa-fw fa-lg fa-trash"></i></a></td>';
                  } else {
                     tr += '<td style="text-align: center; width: 40px;"> </td>';
                  }
                  tr += '</tr>';
               });
            }
            $body_table.empty().append(tr);
         },{id_movimento: move_id});
      }
      
      function init_buttons() {
         $(canvas_id + ' .add_detail').on('click', function () {
            var id_listino = $(canvas_id + ' #id_listino').val();
            var quantita = $(canvas_id + ' #quantita').val();
            var quantita_da_0 = $(canvas_id + ' #quantita_da_0').val();
            var ubicazione = $(canvas_id + ' #ubicazione').find('option:selected').val();
            if (id_listino == '' || id_listino == undefined || id_listino == false) {
               Notify.error('Prodotto non selezionato correttamente, reinserire!');
            } else if(quantita == 0 || quantita == undefined || quantita == null){
               Notify.error('Inserire quantità!');
            } else if(parseInt(quantita) > parseInt(quantita_da_0)){
               Notify.error('La quantità che si vuole inserire supera quella della disponibilità!');
            } else {
               var fields = {
                  dettaglio_id_movimento: move_id,
                  dettaglio_id_articolo: id_listino,
                  dettaglio_quantita: quantita,
                  dettaglio_id_ubicazione: ubicazione
               };
               CH_Tools.post(CH_URL.products + "/allow_save_movement", function(data){
                  if(data === CH_RESULT.SUCCESS){
                     Load_anim.start();
                     CH_Tools.post(CH_URL.products + "/save_movement_detail", function (data) {
                        if (data != false) {
                           build_details_table();
                           reset_campi();
                           Load_anim.stop();
                        } else {
                           Notify.error("Si è verificato un errore, riprovare");
                           reset_campi;
                           Load_anim.stop();
                        }
                     }, fields);
                  } else {
                     Notify.error("Articolo già inserito in movimento!");
                  }
               },{id_movimento: move_id, id_listino: id_listino});
            }
         });
         
         $('.chiudi-movimento', canvas_id).on('click', function(){
            var id_movimento = $(canvas_id + ' #id_movimento').val();
            CH_Tools.confirm('Si è certi di voler chiudere il movimento? \nQuesta operazione (irreversibile) andrà a scaricare il magazzino 0 e andra a caricare il magazzino selezionato!', function(){
               Load_anim.start();
               CH_Tools.post(CH_URL.products + "/chiudi_movimento_di_magazzino", function(response){
                  if(response.result == CH_RESULT.SUCCESS){
                     Load_anim.stop();
                     window.location.href = base_url + CH_URL.products + "/compila_dettagli_movimento/" + response.id_movimento;
                  } else {
                     Load_anim.stop();
                     Notify.error("Si è verificato un errore, riprovare !");
                  }
               },{id_movimento: id_movimento});
            }, function(){
                alert('Operazione annullata');
            });
         });
      }
      
      function reset_campi(){
         $('#brand, #codice, #descrizione, #quantita, #id_listino, #quantita_da_0', canvas_id).val('');
         $('#ubicazione', canvas_id).prop('selectedIndex',0);
      }
       
       return {
          init: init
       };
       
    })();
    
    var Movimenti_list = (function(){
       
       var CANVAS_ID = '#movimenti_list_container';
       
       function init(){
          init_button();
          init_datatable();
       }
       
       function init_button() {
         $(CANVAS_ID + ' .btn_show').on('click', function () {
            var $form = $('#form-movimenti-list');
            var $button = $(this);
            CH_Tools.on_row_selected($form, function ($checked) {
               window.location.href = base_url + CH_URL.products + "/compila_dettagli_movimento/" + $checked.val();
            });
            return false;
         });
         
         $("#movimenti_list_table").on('dblclick', 'tr', function () {
            $(CANVAS_ID + ' .btn_show').trigger('click');
         });
      }
       
       function init_datatable() {
         new CH_dataTable('#form-movimenti-list table', {
            ajax: base_url + CH_URL.products + "/get_movimenti_table_feed",
            sLengthMenu: 10,
            fnRowCallback: function (nRow, aData, iDisplayIndex) {
               if (aData.stato == 1)
                  $('td', nRow).css('color', 'red');        //oggi
               else if (aData.stato == 2)
                  $('td', nRow).css('color', 'black');   //ieri
            },
            columns: [
               {
                  data: "id_movimento",
                  render: function (data, type, row) {
                     return '<input type="radio" value="' + data + '" name="id_movimento">';
                  }
               },
               { data: "data_movimento",
                 render: function(data){
                    return CH_Tools.formatDate(data);
                 }
               },
               {"data": "movimento_codice"},
               {"data": "magazzino"},
               {data: "tipo_movimento",
                render : function(data){
                  if(data == tipo_movimento.da_0_ad_altro){
                     return "Da Mag. 0 ad Altro";
                  } else if(data == tipo_movimento.carico_0){
                     return "Carico Mag. 0";
                  } else if(data == tipo_movimento.scarico_vendita){
                     return "Scarico per vendita";
                  }
                }
               }
            ]
         });
      }
       
       return {
          init: init
       };
       
    })();


    $(function () {
      switch (page) {
         case 'carica_articoli':
            Nuovo_articolo_page.init();
            break;
         case 'magazzini_main':
            Magazzino_main.init();
            break;
         case 'gestione_ubicazioni':
            Gestione_ubicazioni.init();
            break;
         case 'azioni_magazzino':
            Azioni_magazzino.init();
            break;
         case 'movimento_dettagli_page':
            Movimento_dettagli_page.init();
            break;
         case 'lista_movimenti':
            Movimenti_list.init();
            break;
      }
   });
})(jQuery, window, document);

