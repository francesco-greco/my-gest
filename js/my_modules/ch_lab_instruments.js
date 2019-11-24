var Lab_instruments_mgr = (function () {
   var 
   CANVAS_ID = '#labs-instrument-panel',
   instruments_table,
   instrument_timesheets_table,
   instrument_attachments_table,
   id_lab_instrument;

   function init() {
      id_lab_instrument = $('.lab_instrument_id', CANVAS_ID + ' .form_instrument_time_sheets').val();
      init_summary_form();
      init_toolbars();
      init_instrument_timesheets_datatable(id_lab_instrument);
      init_instrument_attachments_datatable(id_lab_instrument);
   }
   
   function init_summary_form() {
      new CH_smartForm($('.form_lab_instrument_details', CANVAS_ID), {
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

   function init_toolbars() {
      $('#summary .btn_save', CANVAS_ID).on('click', function () {
         $('.form_lab_instrument_details', CANVAS_ID).submit();
      });
      
      $('#instrument_time_sheets .btn_add_timesheet', CANVAS_ID).on('click', function () {
         show_edit_timesheet_window();
      });
      
      $('#instrument_time_sheets .btn_edit_timesheet', CANVAS_ID).on('click', function () {
         CH_Tools.on_row_selected($('.form_instrument_time_sheets', CANVAS_ID), function($checked) {
            show_edit_timesheet_window($checked.val());
         });
      });
      
      $('#instrument_attachment .btn_add_attachment', CANVAS_ID).on('click', function () {
         show_edit_attachment_window();
      });
      
      $('#instrument_attachment .btn_edit_attachment', CANVAS_ID).on('click', function () {
         CH_Tools.on_row_selected($('.form_instrument_attachments', CANVAS_ID), function($checked) {
            show_edit_attachment_window($checked.val());
         });
      });
      
      $('#instrument_attachment .btn_download_attachment', CANVAS_ID).on('click', function () {
         CH_Tools.on_row_selected($('.form_instrument_attachments', CANVAS_ID), function($checked) {
            window.location = base_url + CH_URL.attachments + '/download_attachment/' + $checked.val();
         });
         return false;
      });
      
      $('#instrument_time_sheets .btn_export_timesheet', CANVAS_ID).on('click', function () {
         CH_Tools.load_overlay_window(CH_URL.lab_instruments + '/window_export_timesheets', '#window_select_date_range', $.noop, {id_lab_instrument: id_lab_instrument});
      });
   }

   function show_edit_timesheet_window(id_timesheet) {
      var id = (typeof id_timesheet !== 'undefined') ? '/' +id_timesheet : '';
      CH_Tools.load_overlay_window(CH_URL.lab_instruments + '/window_edit_lab_instrument_timesheet' + id, '#new_lab_instrument_timesheet_window', function(id_window){
         //relazione tipo timesheet con task
         $('#timesheet_type', id_window).on('change', function () {
            if($(this).val() == 'PROJECT') {
               $('#timesheet_id_lab_task').removeAttr('disabled');
            }
            else {
               $('#timesheet_id_lab_task').attr('disabled', true);
            }
         }).trigger('change');
         
         //datetime su start ed end
         var $start_date = $('#timesheet_start_timestamp', id_window),
            $end_date= $('#timesheet_end_timestamp', id_window);
            
         $start_date.datetimepicker({ 
            onClose: function(dateText, inst) {
               if ($end_date.val() != '') {
                  var testStartDate = $start_date.datetimepicker('getDate');
                  var testEndDate = $end_date.datetimepicker('getDate');
                  if (testStartDate > testEndDate)
                     $end_date.datetimepicker('setDate', testStartDate);
               }
               else {
                  $end_date.val(dateText);
               }
               var duration = get_duration($start_date.datetimepicker('getDate'), $end_date.datetimepicker('getDate'));
               $('#timesheet_duration', id_window).val(duration);
            },
            onSelect: function (selectedDateTime){
               var end = $end_date.val();
               $end_date.datetimepicker( "option", "minDateTime", $start_date.datetimepicker('getDate') );
               $end_date.val(end);
            }
         });
         
         $end_date.datetimepicker({ 
            onClose: function(dateText, inst) {
               if ($start_date.val() != '') {
                  var testStartDate = $start_date.datetimepicker('getDate');
                  var testEndDate = $end_date.datetimepicker('getDate');
                  if (testStartDate > testEndDate)
                     $start_date.datetimepicker('setDate', testEndDate);
               }
               else {
                  $start_date.val(dateText);
               }
               var duration = get_duration($start_date.datetimepicker('getDate'), $end_date.datetimepicker('getDate'));
               $('#timesheet_duration', id_window).val(duration);
            },
            onSelect: function (selectedDateTime){
                var start = $start_date.val();
               $start_date.datetimepicker( "option", "maxDateTime", $end_date.datetimepicker('getDate'));
               $start_date.val(start);
            }
         });
         
         CH_smartForm($('form', id_window), {
            success: function(response) {
               if(response.result == CH_RESULT.SUCCESS) {
                  Notify.message(CH_Tools.lang('common_words_data_saved_msg'));
                  $(id_window).foundation('reveal','close');
                  reload_instrument_timesheets_table();
               }
               else {
                  Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
               }
            },
            error: function () {
               Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
            }
         });
         
      }, {id_lab_instrument: id_lab_instrument});
   }
   
   function get_duration(start, end) {
      if(typeof end === 'undefined' || typeof start === 'undefined') return '';
      var total_duration_seconds = (end.getTime() - start.getTime())/1000,
          duration_minutes = parseInt(total_duration_seconds/60),
          duration_hours = parseInt(duration_minutes/60);
      duration_minutes = duration_minutes % 60;
      
      return duration_hours + ':' + (duration_minutes < 10 ? '0':'') + new String(duration_minutes);
   }
   
   function reload_instrument_timesheets_table() {
      instrument_timesheets_table.reload();
   }
   
   function init_instrument_timesheets_datatable(id_lab_instrument) {
      instrument_timesheets_table = new CH_dataTable('#instrument_time_sheets table', { 
         ajax: base_url + CH_URL.lab_instruments + '/get_lab_instrument_timesheets_table_feed/' + id_lab_instrument,
         columns: [
            { 
               data: "id", 
               render: function ( data, type, row ) {
                 return '<input type="radio" value="' +data +'" name="id">';
               }
            },
            { render: function(data) { return CH_Tools.lang(data); }, data: "type" }, 
            { data: "task_name" }, { data: "user_fullname" }, { data: "start", render: function (data) { return CH_Tools.formatDate(data); } }, 
            { data: "end", render: function (data) { return CH_Tools.formatDate(data); } }, { data: "duration" }
         ]
      });
   }
   
   function show_edit_attachment_window(id_attachment) {
      var id = (typeof id_attachment !== 'undefined') ? '/' +id_attachment : '';
      CH_Tools.load_overlay_window(CH_URL.lab_instruments + '/window_edit_lab_instrument_attachment' + id, '#new_lab_instrument_attachment_window', function(id_window){
         //relazione tipo attachment con task
         $('#attachment_type', id_window).on('change', function () {
            if($(this).val() == 'RESULT') {
               $('#attachment_id_lab_task').removeAttr('disabled');
            }
            else {
               $('#attachment_id_lab_task').attr('disabled', true);
            }
         }).trigger('change');
         
         $('#attachment_upload_date', id_window).datepicker();
         
         if(typeof id_attachment !== 'undefined') $('#attachment_filename', id_window).removeAttr('required');
         CH_smartForm($('form', id_window), {
            success: function(response) {
               if(response.result == CH_RESULT.SUCCESS) {
                  Notify.message(CH_Tools.lang('common_words_data_saved_msg'));
                  $(id_window).foundation('reveal','close');
                  reload_instrument_attachments_table();
               }
               else {
                  Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
               }
            },
            error: function () {
               Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
            }
         });
         
      }, {id_lab_instrument: id_lab_instrument});
   }
   
   function init_instrument_attachments_datatable(id_lab_instrument) {
      instrument_attachments_table = new CH_dataTable('#instrument_attachment table', { 
         ajax: base_url + CH_URL.lab_instruments + '/get_lab_instrument_attachments_table_feed/' + id_lab_instrument,
         columns: [
            { 
               data: "id", 
               render: function ( data, type, row ) {
                 return '<input type="radio" value="' +data +'" name="id">';
               }
            },
            { data: "date" }, { render: function(data) { return CH_Tools.lang(data); }, data: "type" }, 
            { data: "description" }, { data: "task_name" }, { data: "user_fullname" }
         ]
      });
   }
   
   function reload_instrument_attachments_table() {
      instrument_attachments_table.reload();
   }
   
   function show_add_instrument_window (id_lab) {
      CH_Tools.load_overlay_window(CH_URL.lab_instruments + '/window_new_lab_instrument', '#new_lab_instrument_window', function(id_window){
         $('.lab_instrument_name', id_window).autocomplete({
            source: base_url + CH_URL.lab_instruments + "/autocomplete_lab_instrument_names_feed",
            minLength: 3
         });
         CH_smartForm($('form', id_window), {
            success: function(response) {
               Notify.message(CH_Tools.lang('common_words_data_saved_msg'));
               $(id_window).foundation('reveal','close');
               reload_instruments_table();
            },
            error: function () {
               Notify.error(CH_Tools.lang('common_words_data_not_saved_msg'));
            }
         });
      }, {id_lab: id_lab});
   }

   function init_instruments_datatable(id_lab) {
      instruments_table = new CH_dataTable('#lab_instruments table', { 
         ajax: base_url + CH_URL.lab_instruments + '/get_lab_instruments_table_feed/' + id_lab,
         columns: [
            { 
               data: "id", 
               render: function ( data, type, row ) {
                 return '<input type="radio" value="' +data +'" name="id">';
               }
            },
            { "data": "name" }, { "data": "description" }
         ]
      });
   }

   function reload_instruments_table() {
      instruments_table.reload();
   }

   return {
      init: init,
      init_instruments_datatable: init_instruments_datatable,
      reload_instruments_table: reload_instruments_table,
      show_add_instrument_window: show_add_instrument_window
   };
})();

$(function () {
   switch(page) {
      case 'edit_lab_instrument':Lab_instruments_mgr.init();break;
   }
});