(function ($, window, document, undefined) {	
	
   var Group_editor_page = (function () {
      function init() {
         $('#btn-utenti-gruppo-salva').on('click', function () {
            $('#form-utenti-gruppo-nuovo').submit();
         });

         $('input.gruppi-ruoli').eq(0).on('click', function () {
            if($(this).attr('checked')) {
               $('input.gruppi-ruoli').not(this).attr('disabled', 'disabled');
            }
            else {
               $('input.gruppi-ruoli').not(this).removeAttr('disabled');
            }
         });
      }
      
      return {
         init: init
      };
   })();
   
   var User_editor_page = (function () {
      function init() {
         //Gestisce il lucchetto che abilita/disabilita un profilo utente
         $('#checkbox-utenti-abilitato').on('click', function () {
            if($('#utenti-abilitato').val() == 1) {
               $(this).find('i').removeClass('fa-unlock').addClass('fa-lock');
               $('#utenti-abilitato').val(0);
            }
            else {
               $(this).find('i').removeClass('fa-lock').addClass('fa-unlock');
               $('#utenti-abilitato').val(1);
            }
         });

         //Validazione del form utente
         $('#form-utenti-utente-nuovo').validate({
            rules: {
               'utenti-username': 'required',
               'utenti-password': {
                  required: {depends: function (element) {
                     return $('#utenti-id').val() == '' && $(element).val() == ''
                  }}
               },
               'utenti-ripeti-password': {
                  equalTo: '#utenti-password'
               },
               'utenti-codice': 'required',
               'utenti-nome': 'required'
            },
            messages: {
               'utenti-username': "E' obbligatorio assegnare un username ad un profilo utente.",
               'utenti-password': "E' obbligatorio assegnare una password ad un profilo utente.",
               'utenti-ripeti-password': 'La password non è ripetuta correttamente.',
               'utenti-codice': "E' obbligatorio assegnare un codice univoco ad un profilo utente.",
               'utenti-nome': "E' obbligatorio assegnare il nome dell'operatore ad un profilo utente."
            }//,
         });

         $('#btn-utenti-utente-salva').on('click', function () {
            $('#form-utenti-utente-nuovo').submit();
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
         new CH_dataTable('#table-utenti-lista');
         new CH_dataTable('#table-utenti-gruppi-lista');
      }
      
      function init_button_bar() {
         $('#btn-utenti-utente-modifica').on('click', function () {
            var $button = $(this);

            CH_Tools.on_row_selected('#form-utenti-lista', function () {
               $('#form-utenti-lista').attr('action', $button.attr('href')).submit();
            });

            return false;
         });

         $('#btn-utenti-utente-abilitato').on('click', function () {
            var $button = $(this);

            CH_Tools.on_row_selected('#form-utenti-lista', function (_checked) {
               $('#utenti-abilitato').val(_checked.attr('data-utenti-abilitato'));
               $('#form-utenti-lista').attr('action', $button.attr('href')).submit();
            });

            return false;
         });

         $('#btn-utenti-gruppo-cancella').on('click', function () {
            var $button = $(this);

            CH_Tools.on_row_selected('#form-utenti-gruppi-lista', function () {
               CH_Tools.confirm('Sicuro di voler cancellare il gruppo utente selezionato?', function () {
                  $('#form-utenti-gruppi-lista').attr('action', $button.attr('href')).submit();
               });
            });

            return false;
         });

         $('#btn-utenti-gruppo-modifica').on('click', function () {
            var $button = $(this);

            CH_Tools.on_row_selected('#form-utenti-gruppi-lista', function () {
               $('#form-utenti-gruppi-lista').attr('action', $button.attr('href')).submit();
            });

            return false;
         });	
      }
      
      
      return { init: init };
   })();
   
   $(function () {
		switch(page) {
			case 'utenti': List_tables_page.init();break;
			case 'modifica_gruppo':Group_editor_page.init();break;
			case 'modifica_utente':User_editor_page.init();break;
		}
	});   
})(jQuery, window, document);