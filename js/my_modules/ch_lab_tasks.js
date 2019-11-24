var Lab_tasks_mgr = (function () {
   var tasks_table, instrument_timesheets_table, slider_timeout_id, id_lab_task, id_lab;

   function init() {
      id_lab = $('.lab_id', '#lab_tasks_summary').val();
      id_lab_task = $('.lab_task_id', '#lab_tasks_summary').val();
      
      $('.btn_start_task', '#lab_tasks_summary').on('click', function () {
         CH_Tools.load_overlay_window(CH_URL.lab_tasks + '/window_start_task/' + id_lab_task, '#window_select_date', function() {
            new CH_smartForm('#window_select_date form', {
               success: function (response) {
                  if(response.result == CH_RESULT.SUCCESS) {
                     //CH_page_reloader.set_url(CH_URL.lab_tasks +'/edit_task/' + id_lab + '/' + id_lab_task);
                     CH_page_reloader.set_url(CH_URL.lab_tasks +'/edit_task/' + id_lab_task);
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

      $('.btn_end_task', '#lab_tasks_summary').on('click', function () {
         CH_Tools.load_overlay_window(CH_URL.lab_tasks + '/window_end_task/' + id_lab_task, '#window_select_date', function() {
            new CH_smartForm('#window_select_date form', {
               success: function (response) {
                  if(response.result == CH_RESULT.SUCCESS) {
                     //CH_page_reloader.set_url(CH_URL.lab_tasks +'/edit_task/' + id_lab + '/' + id_lab_task);
                     CH_page_reloader.set_url(CH_URL.lab_tasks +'/edit_task/' + id_lab_task);
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
      
      $('.task_progress_slider', '#lab_tasks_summary').on('change.fndtn.slider', function(){
         if(typeof slider_timeout_id == 'undefined') {
            slider_timeout_id = setTimeout(
               function() { 
                  slider_timeout_id = undefined;
                  CH_Tools.post(CH_URL.lab_tasks + '/update_task_progress', function (data) {
                     if(data.result == CH_RESULT.FAILURE) {
                        Notify.error(data.message);
                     }
                  }, {id_lab_task: id_lab_task, progress: $('.task_progress_slider').attr('data-slider')});
               }, 500);
         }
      });
      
      $('#instrument_filter_select', '#lab_tasks_timesheets').on('change', function() {
         instrument_timesheets_table.filter_by_instrument($(this).val());
      });
      
      $('.btn_export_timesheet', '#lab_tasks_timesheets').on('click', function () {
         CH_Tools.load_overlay_window(CH_URL.lab_tasks + '/window_export_timesheets', '#window_select_date_range', $.noop, {id_lab_task: id_lab_task});
      });
      
      $('.btn_download_attachment', '#lab_task_attachments').on('click', function () {
         CH_Tools.on_row_selected($('form', '#lab_task_attachments'), function($checked) {
            window.location = base_url + CH_URL.attachments + '/download_attachment/' + $checked.val();
         });
         return false;
      });
      
      instrument_timesheets_table.init(id_lab_task);
      task_attachments_table.init(id_lab_task);
   }

   
   function init_tasks_datatable(id_lab) {
      tasks_table = new CH_dataTable('#lab_tasks table', { 
         ajax: base_url + CH_URL.labs + '/get_lab_tasks_table_feed/' + id_lab,
         columns: [
            { 
               data: "id", 
               render: function ( data, type, row ) {
                 return '<input type="radio" value="' +data +'" name="id">';
               }
            },
            {  data: "name" }, { "data": "project_name" },
            {  data: "start_date" }, { "data": "end_date" }, 
            {  render: function ( data, type, row ) {
                  return data +'%';
               }, className: "text-center", data: "progress" 
            }
         ]
      });
   }

   function reload_tasks_datatable() {
      tasks_table.reload();
   }

   var instrument_timesheets_table = (function () {
      var _id_lab_task, instrument_timesheets_table_instance, base_feed_url;
      
      function reload() {
         instrument_timesheets_table_instance.reload();
      }

      function init(id_lab_task) {
         _id_lab_task = id_lab_task;
         base_feed_url = base_url + CH_URL.lab_tasks + '/get_task_instrument_timesheets_table_feed/' + _id_lab_task;
         
         instrument_timesheets_table_instance = new CH_dataTable('#lab_tasks_timesheets table', { 
            ajax: base_feed_url,
            columns: [
               { 
                  data: "id", 
                  render: function ( data, type, row ) {
                    return '<input type="radio" value="' +data +'" name="id">';
                  }
               },
               { data: "instrument_name" }, { data: "user_fullname" }, 
               { data: "start", render: function (data) { return CH_Tools.formatDate(data); } }, 
               { data: "end", render: function (data) { return CH_Tools.formatDate(data); } }, { data: "duration" }
            ]
         });
      }

      function filter_by_instrument(id_instrument) {
         if(!isNaN(parseInt(id_instrument))) {
            instrument_timesheets_table_instance.change_feed(base_feed_url + '/' + id_instrument);
         }
         else if(id_instrument== '') {
            instrument_timesheets_table_instance.change_feed(base_feed_url);
         }
      }
   
      return { 
         init: init,
         filter_by_instrument: filter_by_instrument,
         reload: reload
      };
   })();

   var task_attachments_table = (function () {
      var _id_lab_task, task_attachments_table_instance, base_feed_url;
      
      function reload() {
         task_attachments_table_instance.reload();
      }

      function init(id_lab_task) {
         _id_lab_task = id_lab_task;
         base_feed_url = base_url + CH_URL.lab_tasks + '/get_lab_task_attachments_table_feed/' + _id_lab_task;
         
         task_attachments_table_instance = new CH_dataTable('#lab_task_attachments table', { 
            ajax: base_feed_url,
            columns: [
               { 
                  data: "id", 
                  render: function ( data, type, row ) {
                    return '<input type="radio" value="' +data +'" name="id">';
                  }
               },
               { data: "date", render: function (data) { return CH_Tools.formatDate(data); } }, 
               { data: 'instrument_name'},
               { data: "description" }, 
               { data: "user_fullname" }
            ]
         });
      }

      return { 
         init: init,
         reload: reload
      };
   })();

   return {
      init: init,
      init_tasks_datatable: init_tasks_datatable,
      reload_tasks_datatable: reload_tasks_datatable
   };
})();

$(function () {
   switch(page) {
      case 'edit_lab_task':Lab_tasks_mgr.init();break;
   }
});