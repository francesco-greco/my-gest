(function ($, window, document, undefined) {	
   var 
   CANVAS_ID = '#projects-panel';
   
   var Project_editor_page = (function () {
      var $form, id_project;
      
      function init() {
         id_project = $('.project_id', CANVAS_ID + ' .form_project_details').val();
         form_init();
         
         init_summary_toolbar();
         init_task_toolbar();
         init_attachment_toolbar();
         
         Project_attachments_table.init(id_project);
         Project_task_with_assignment.init(id_project);
      }
      
      function form_init() {
         $form = new CH_smartForm($('.form_project_details', CANVAS_ID), {
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
      
      function init_summary_toolbar() {
         $('.btn_save', CANVAS_ID).on('click', function () {
            $('.form_project_details', CANVAS_ID).submit();
         });
         
         $('.btn_start_project', CANVAS_ID).on('click', function () {
            CH_Tools.load_overlay_window(CH_URL.projects + '/window_start_project/' + id_project, '#window_select_date', function() {
               new CH_smartForm('#window_select_date form', {
                  success: function (response) {
                     if(response.result == CH_RESULT.SUCCESS) {
                        CH_page_reloader.set_url(CH_URL.projects +'/edit_project/' + id_project);
                        CH_page_reloader.reload();
                     }
                     else {
                        alert(response.message);
                     }
                  },
                  error: function () { alert('Si è verificato un errore di sistema.'); }
               });
            });
         });
         
         $('.btn_end_project', CANVAS_ID).on('click', function () {
            CH_Tools.load_overlay_window(CH_URL.projects + '/window_end_project/' + id_project, '#window_select_date', function() {
               new CH_smartForm('#window_select_date form', {
                  success: function (response) {
                     if(response.result == CH_RESULT.SUCCESS) {
                        CH_page_reloader.set_url(CH_URL.projects +'/edit_project/' + id_project);
                        CH_page_reloader.reload();
                     }
                     else {
                        alert(response.message);
                     }
                  },
                  error: function () { alert('Si è verificato un errore di sistema.'); }
               });
            });
         });
      }
      
      function init_task_toolbar() {
         $('.btn_edit_task', CANVAS_ID).on('click', function () {
            var $tasks_form = $('#project_tasks form', CANVAS_ID);
            CH_Tools.on_row_selected($tasks_form, function($checked) {
               $tasks_form.submit();
            });
         });  
      }
      
      function init_attachment_toolbar() {
         $('#project_attachments .btn_add_attachment', CANVAS_ID).on('click', function () {
            show_edit_attachment_window();
         });
      
         $('.btn_download_attachment', '#project_attachments').on('click', function () {
            CH_Tools.on_row_selected($('form', '#project_attachments'), function($checked) {
               window.location = base_url + CH_URL.attachments + '/download_attachment/' + $checked.val();
            });
            return false;
         });
         
         $('.btn_share_attachment', '#project_attachments').on('click', function () {
            CH_Tools.on_row_selected($('form', '#project_attachments'), function($checked) {
               Load_anim.start();
               CH_Tools.post(CH_URL.projects + '/share_project_attachment', 
                  function (data) {
                     if(data.result == CH_RESULT.SUCCESS) {
                        Project_attachments_table.reload();
                     }
                     else {
                        Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
                     }
                     Load_anim.stop();
                  }, 
                  {id_attachment: $checked.val()}
               );
            });
            return false;
         });
      }
      
      function show_edit_attachment_window(id_attachment) {
         var id = (typeof id_attachment !== 'undefined') ? '/' +id_attachment : '';
         CH_Tools.load_overlay_window(CH_URL.projects + '/window_edit_project_attachment' + id, '#new_project_attachment_window', function(id_window){
            $('#attachment_upload_date', id_window).datepicker();

            if(typeof id_attachment !== 'undefined') $('#attachment_filename', id_window).removeAttr('required');
            CH_smartForm($('form', id_window), {
               success: function(response) {
                  if(response.result == CH_RESULT.SUCCESS) {
                     Notify.message(CH_Tools.lang('common_words_data_saved_msg'));
                     $(id_window).foundation('reveal','close');
                     Project_attachments_table.reload();
                  }
                  else {
                     Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
                  }
               },
               error: function () {
                  Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
               }
            });

         }, {id_project: id_project});
      }


      
      var Project_task_with_assignment = (function() {
         
         var _id_project, project_attachments_table_instance, base_feed_url;

         function reload() {
            project_attachments_table_instance.reload();
         }

         function init(id_project) {
            _id_project = id_project;
            base_feed_url = base_url + CH_URL.projects + '/get_project_tasks_with_assignments_table_feed/' + _id_project;

            project_attachments_table_instance = new CH_dataTable('#project_tasks table', { 
               ajax: base_feed_url,
               columns: [
                  { 
                     data: "id", 
                     render: function ( data, type, row ) {
                       return '<input type="radio" value="' +data +'" name="id">';
                     }
                  },
                  { data: "name" }, 
                  { data: "lab" }, 
                  { data: "start" }, 
                  { data: "end" }, 
                  { data: "actual_start" }, 
                  { data: "actual_end" }
               ],
               order: [ 1, 'asc' ]
            });
         }

         return { 
            init: init,
            reload: reload
         };
      })();
      
      var Project_attachments_table = (function () {
         var _id_project, project_attachments_table_instance, base_feed_url;

         function reload() {
            project_attachments_table_instance.reload();
         }

         function init(id_project) {
            _id_project = id_project;
            base_feed_url = base_url + CH_URL.projects + '/get_project_attachments_table_feed/' + _id_project;

            project_attachments_table_instance = new CH_dataTable('#project_attachments table', { 
               ajax: base_feed_url,
               columns: [
                  { 
                     data: "id", 
                     render: function ( data, type, row ) {
                       return '<input type="radio" value="' +data +'" name="id">';
                     }
                  },
                  { data: "date", width: '100px', render: function (data) { return CH_Tools.formatDate(data); }, className: 'text-center' }, 
                  { data: "type", width: '100px', render: function(data) { return CH_Tools.lang(data); } }, 
                  { data: "description" }, 
                  { data: "lab" },
                  { data: 'task_name'},
                  { 
                     data: "attachment_share", width: '100px', className: 'text-center', sortable: false,
                     render: function(data) { return data == '1' ? CH_Tools.lang('common_words_yes') : CH_Tools.lang('common_words_No'); } 
                  }
               ],
               order: [ 1, 'asc' ]
            });
         }

         return { 
            init: init,
            reload: reload
         };
      })();
      
      return {
         init: init
      };
   })();
   
	var List_tables_page = (function () {
      var prj_table;
      
      function init() {
         init_button_bar();
         init_tables();
      }
      
      function init_tables() {
         prj_table = new CH_dataTable('#form-projects-list table', { 
            ajax: CH_URL.projects + '/get_project_table_feed',
            columns: [
               { 
                  data: "id", 
                  render: function ( data, type, row ) {
                    return '<input type="radio" value="' +data +'" name="id">';
                  }
               },
               { "data": "name" }, { "data": "code" }, { "data": "project_leader" }, { "data": "client" }
            ]
         });
      }
      
      function init_button_bar() {
         var $form = $('#form-projects-list');
         $('.btn-project-new', CANVAS_ID).on('click', function () {
            New_project_mgr.show();
         });
         $('.btn-project-edit', CANVAS_ID).on('click', function () {
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
            if(typeof prj_table != 'undefined') prj_table.reload();
         }
      };
   })();
   
   var New_project_mgr = (function () {
      function show () {
         CH_Tools.load_overlay_window(CH_URL.projects + '/window_new_project', '#new_project_window', function(id_window){
            $('.btn-send', id_window).on('click', function() { Load_anim.start(); } );
            CH_smartForm($('form', id_window), {
                  success: function(response) {
                     Load_anim.stop();
                     Notify.message(CH_Tools.lang('common_words_data_saved_msg'));
                     $(id_window).foundation('reveal','close');
                     List_tables_page.reload_table();
                  },
                  error: function () {
                     Load_anim.stop();
                     Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
                  }
               },
               {
                  rules: {
                     'project_code': {
                        remote: base_url + CH_URL.projects + "/check_project_code"
                     }
                  },
                  messages: {
                     'project_code': {
                        remote: CH_Tools.lang('projects_code_yet_used_error_msg')
                     }
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
			case 'projects': List_tables_page.init();break;
			case 'edit_project':Project_editor_page.init();break;
		}
	});   
})(jQuery, window, document);