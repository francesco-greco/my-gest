var CH_dataTable = function($target, options) {
   var
   $dataTable;
   
   /** 
    * Private function 
    * */
   function init() {
      $($target).on('click', 'tr', function() {
      var $radio = $(this).find("input[type='radio']");
         $radio.attr('checked', 'true');
      });

      $dataTable = $($target).DataTable(build_options(options));
   }
   
   function build_options(options) {
      var defaults = {
         columnDefs: [ { orderable: false, width: "30px", targets: 0 } ],
         lengthChange: true,
         order: [ 1, 'asc' ],
         autoWidth: false,
         stateSave: true,
         stateDuration: 60 * 60 * 8,
         language: dataTables_lang,
         lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
         'processing': true
      };
      
      if(typeof options == 'undefined') {
         options = {};
      }
      
      //se è presente una richiesta ajax, aggiungo i parametri serverSide e processing
      if(typeof options.ajax !== 'undefined') {
         options = $.extend({serverSide: true}, options);
      }
      return $.extend({}, defaults, options);
   }
   
   this.get_instance = function() { return $dataTable; };

   this.reload = function () {
     $dataTable.ajax.reload();
   };
   
   this.change_feed = function (url) {
      $dataTable.ajax.url(url).load();
   };
   
   init();
};

var CH_smartForm = function($target, ajaxForm_options, validator_options) {
   var
   $smartForm;
   
   function init() {
      $smartForm = $($target);
      
      var form_defaults = {
         beforeSubmit: function (arr, $form){
            return $form.valid();
         },
         dataType:  'json'
      };
      
      ajaxForm_options = $.extend({}, form_defaults , ajaxForm_options);
      $smartForm.ajaxForm(ajaxForm_options);

      validator_options = (typeof validator_options != 'undefined') ? validator_options : {};
      $smartForm.validate(validator_options);
   }
   
   this.get_form = function () {
      return $smartForm;
   };
   
   init();
};

var CH_page_reloader = (function ($) {
   var $form = $('#form_reload_page');
   
   function set_url(url) {
      $form.attr('action', base_url + url);
   }
   
   function reload() {
      $form.submit();
   }
   
   return {
      set_url: set_url,
      reload: reload
   };
})(jQuery);

var CH_delayed_keyup = function (_target, _callback, _delay) {
   var 
   time_out,
   callback = _callback,
   delay = isNaN(Number(_delay)) ? 500 : Number(_delay),
   $target = $(_target);
   
   this.start = function () {
      $target.on('keyup', function () {
         if(time_out !== undefined)  clearTimeout(time_out);
         time_out = setTimeout(function () { 
            callback();
         }, delay);
      });
   };
   
   this.stop = function () {
      clearTimeout(time_out);
      $target.off('keyup');
   };
   
   this.restart = function () {
      this.stop();
      $target.on('keyup', function () {
      if(time_out !== undefined)  clearTimeout(time_out);
         time_out = setTimeout(function () { 
            callback();
         }, delay);
      });
   };
   
   this.start();
};

var Notify = (function ($) {
   humane.info = humane.spawn({waitForMove: true});
   humane.error = humane.spawn({addnCls: 'humane-original-error', waitForMove: true});
   
   function message (txt, callback) {
      humane.info(txt, callback);
   }
   
   function error (txt, callback) {
      humane.error(txt, callback);
   }
   
   return {
      message: message,
      error: error
   };
})(jQuery);

var Load_anim = (function () {
   var opts = {
      lines: 15, // The number of lines to draw
      length: 0, // The length of each line
      width: 16, // The line thickness
      radius: 51, // The radius of the inner circle
      corners: 0.4, // Corner roundness (0..1)
      rotate: 0, // The rotation offset
      direction: 1, // 1: clockwise, -1: counterclockwise
      color: '#000', // #rgb or #rrggbb or array of colors
      speed: 1, // Rounds per second
      trail: 70, // Afterglow percentage
      shadow: false, // Whether to render a shadow
      hwaccel: false, // Whether to use hardware acceleration
      className: 'spinner', // The CSS class to assign to the spinner
      zIndex: 2e9, // The z-index (defaults to 2000000000)
      top: '50%', // Top position relative to parent
      left: '50%' // Left position relative to parent
   };
   var spinner = new Spinner(opts);
   
   return {
      start: function () { spinner.spin(document.body); },
      stop:  function () { spinner.stop(); }
   };
})();