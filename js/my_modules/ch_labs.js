(function ($, window, document, undefined) {	
   var 
   CANVAS_ID = '#labs-panel';
   
   var Lab_editor_page = (function () {
      var $form, id_lab, tasks_table;
      
      function init() {
         id_lab = $('.form_lab_details .lab_id').val();
         init_form();
         init_toolbar();
         //init_tasks_datatable(id_lab);
         Lab_tasks_mgr.init_tasks_datatable(id_lab);
         Lab_staff_mgr.init_staff_member_datatable(id_lab);
         Lab_instruments_mgr.init_instruments_datatable(id_lab);
      }
      
      function init_form() {
         $form = new CH_smartForm($('.form_lab_details', CANVAS_ID), {
            success: function(response) {
               if(response.result == CH_RESULT.SUCCESS) {
                  Notify.message(CH_Tools.lang('common_words_data_saved_msg'));
               }
               else {
                  Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
               }
            },
            error: function () {
               Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
            }
         });
      }
      
      function init_toolbar() {
         $('.btn_save', CANVAS_ID).on('click', function () {
            $('.form_lab_details', CANVAS_ID).submit();
         });
         
         $('.btn_edit_task', CANVAS_ID).on('click', function () {
            var $tasks_form = $('#lab_tasks form', CANVAS_ID);
            CH_Tools.on_row_selected($tasks_form, function($checked) {
               $tasks_form.submit();
            });
         });
         
         $('.btn_edit_lab_instrument', CANVAS_ID).on('click', function () {
            var $instrument_form = $('#lab_instruments form', CANVAS_ID);
            CH_Tools.on_row_selected($instrument_form, function($checked) {
               $instrument_form.submit();
            });
         });
         
         $('.btn_add_lab_instrument', CANVAS_ID).on('click', function () {
            Lab_instruments_mgr.show_add_instrument_window(id_lab);
         });
         
         $('.btn_add_lab_staff_member', CANVAS_ID).on('click', function () {
            Lab_staff_mgr.show_add_member_window();
         });
         $('.btn_delete_staff_member', CANVAS_ID).on('click', function () {
            CH_Tools.on_row_selected($('form.form_lab_staff'), function($checked) {
               Lab_staff_mgr.delete_staff_member($checked.val());
            });
         });
      }
      
      var Lab_staff_mgr = (function () {
         var staff_table;
         
         function show_add_member_window () {
            CH_Tools.load_overlay_window(CH_URL.labs + '/window_new_lab_staff', '#new_lab_staff_window', function(id_window){
               $('.lab_member_role', id_window).autocomplete({
                  source: base_url + CH_URL.labs + "/autocomplete_staff_roles_feed",
                  minLength: 3
               });
               CH_smartForm($('form', id_window), {
                     success: function(response) {
                        Notify.message(CH_Tools.lang('common_words_data_saved_msg'));
                        $(id_window).foundation('reveal','close');
                        reload_staff_member_table();
                     },
                     error: function () {
                        Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
                     }
                  }      
               );
            }, {id_lab: id_lab});
         }
         
         function delete_staff_member(id_lab_staff) {
            CH_Tools.confirm(CH_Tools.lang('labs_lab_staff_member_delete_confirm_message'), function () {
               CH_Tools.post(CH_URL.labs + '/delete_lab_staff_member', function (response) {
                  if(response.result == CH_RESULT.SUCCESS) {
                     reload_staff_member_table();
                     Notify.message(CH_Tools.lang('common_words_data_saved_msg'));
                  }
                  else {
                     Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
                  }
               }, {id_lab_staff: id_lab_staff});
            });
         }
         
         function init_staff_member_datatable(id_lab) {
            staff_table = new CH_dataTable('#lab_staff table', { 
               ajax: base_url + CH_URL.labs + '/get_lab_staff_table_feed/' + id_lab,
               columns: [
                  { 
                     data: "id", 
                     render: function ( data, type, row ) {
                       return '<input type="radio" value="' +data +'" name="id">';
                     }
                  },
                  { "data": "name" }, { "data": "role" }
               ]
            });
         }
         
         function reload_staff_member_table() {
            staff_table.reload();
         }
         
         return {
            init_staff_member_datatable: init_staff_member_datatable,
            reload_staff_member_table: reload_staff_member_table,
            show_add_member_window: show_add_member_window,
            delete_staff_member: delete_staff_member
         };
      })();

      return {
         init: init
      };
   })();
   
	var List_tables_page = (function () {
      var lab_table;
      
      function init() {
         init_toolbar();
         init_tables();
      }
      
      function init_tables() {
         lab_table = new CH_dataTable('#form-labs-list table', { 
            ajax: CH_URL.labs + '/get_lab_table_feed',
            columns: [
               { 
                  data: "id", 
                  render: function ( data, type, row ) {
                    return '<input type="radio" value="' +data +'" name="id">';
                  }
               },
               { "data": "name" }, { "data": "lab_chief" }
            ]
         });
      }
      
      function init_toolbar() {
         var $form = $('#form-labs-list');
         $('.btn-lab-new', CANVAS_ID).on('click', function () {
            New_lab_mgr.show();
         });
         $('.btn-lab-edit', CANVAS_ID).on('click', function () {
            var $button = $(this);
            CH_Tools.on_row_selected($form, function () {
               $form.attr('action', $button.attr('href')).submit();
            });
            return false;
         });
      }
      
      
      return { 
         init: init,
         reload_table: function () { 
            if(typeof lab_table != 'undefined') lab_table.reload();
         }
      };
   })();
   
   var New_lab_mgr = (function () {
      function show () {
         CH_Tools.load_overlay_window(CH_URL.labs + '/window_new_lab', '#new_lab_window', function(id_window){
            CH_smartForm($('form', id_window), {
                  success: function(response) {
                     Notify.message(CH_Tools.lang('common_words_data_saved_msg'));
                     $(id_window).foundation('reveal','close');
                     List_tables_page.reload_table();
                  },
                  error: function () {
                     Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
                  }
               }      
            );
         });
      }
      
      return {
         show: show
      };
   })();
   
   $(function () {
		switch(page) {
			case 'labs': List_tables_page.init();break;
			case 'edit_lab':Lab_editor_page.init();break;
		}
	});   
})(jQuery, window, document);