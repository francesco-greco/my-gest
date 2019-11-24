var CH_Tools = (function ($) {
   
   function show_message(body, type, callback) {
		var $body = $('#window-messaggio .msg-body');
		var $sign = $('#window-messaggio .msg-sign');
		
		switch(type) {
         case 'message':
			case 'info':
				$sign.html('<i style="color: #2BA6CB; font-size: 3em; position:relative; top:5px;" class="fa fa-info-circle"></i>').show();
				break;
			case 'error':
				$sign.html('<i style="color: red; font-size: 3em;" class="fa fa-warning"></i>').show();
				break;
			case 'question':
				$sign.html('<i style="color: #2BA6CB; font-size: 3em; position:relative; top:5px;" class="fa fa-question-circle"></i>').show();
				break;
			default:
				$sign.empty();
				break;
		}
		
		$body.html(body);
		$('#window-messaggio .buttons-row').hide();
      
      //chiude eventuali finestre gia aperte
      $('.reveal-modal.open').foundation('reveal','close');
		$('#window-messaggio').foundation('reveal','open');
		if(typeof callback != 'undefined') 
			$('#window-messaggio').on('close.fndtn.reveal', '[data-reveal]', callback);
	}
	
	function confirm(body, on_ok, on_cancel) {
		var $window = $('#window-messaggio');
		$("#window-messaggio .msg-sign").html('<i style="color: #2BA6CB; font-size: 3em; position:relative;" class="fa fa-question-circle"></i>').show();
		$("#window-messaggio .msg-body").removeClass('twelve').addClass('twelve').html(body);
		$("#window-messaggio .buttons-row").show();
		
		if(typeof on_ok != 'undefined') {
			$("#window-messaggio .buttons-row .success.button").off("click.sg").on("click.sg", function () {
            var res = on_ok();
            if(res != false) $window.foundation('reveal','close');
			});
		}
		
		if(typeof on_cancel != 'undefined') {
			$("#window-messaggio .buttons-row .alert.button").off("click.sg").on("click.sg", function () {
				$window.foundation('reveal','close');
				on_cancel();
			});
			
			$("#window-messaggio .close-reveal-modal").off("click.sg").on("click.sg", on_cancel);
		}
		else {
			$("#window-messaggio .buttons-row .secondary.button").off("click.sg").on("click.sg", function () {
				$window.foundation('reveal','close');
			});
		}
		
		//chiude eventuali finestre gia aperte
      $('.reveal-modal.open').foundation('reveal','close');
		$window.foundation('reveal', 'open');
	}
	
   function show_overlay_window(id_window, on_load, on_show) {
      on_load(id_window);
      $(id_window).addClass('reveal-modal').attr('data-reveal', '').append('<a class="close-reveal-modal">x</a>');
      $(id_window).foundation('reveal', 'open');
   }
   
   function create_autocomplete(target, source, select_callback, renderer, o) {
		var options = {
			focus: function (e, ui) {e.preventDefault(); return false;},
			delay: 500,
			minLength: 3,
         open: function(){
            $(this).autocomplete('widget').css('z-index', 10000);
            return false;
         }
		};
		$(target).on('focus', function () { $(this).trigger('keydown'); })
		if(typeof source === 'string') {
			options.source = function (obj, response) {	
				CH_Tools.get(source, response, {term: obj.term });
			};
		}
		else options.source = source;
		
		if(typeof select_callback !== 'undefined') options.select = select_callback;
		var f = (typeof o !== 'undefined') ? $.extend({}, options, o) : options;
      
      if($(target).length > 0) {
         var d = $(target).autocomplete(f);
         if(typeof renderer !== 'undefined')
            d.data( "ui-autocomplete" )._renderItem = renderer	;
      }
	}
   
	function load_html_fragment(url_frammento, callback, params) {
		var process_funct = function (data, textStatus, jqXHR) {
			var $frammento = $(data);
         if(typeof $frammento.attr('id') != 'undefined') {
            var $frammento_presente = $('#' + $frammento.attr('id'));
			
            //Se esiste già il frammento caricato lo si rimuove
            if($frammento_presente.length > 0) $frammento_presente.remove();
            $('#ch_main_container').append($frammento);
            $frammento.foundation();
            callback(data, textStatus, jqXHR);
           
         }
         else {
            show_message(data, 'info');
         }
		};
		
      _ajax('get', base_url + url_frammento, process_funct, params, 'html', true);
   }
	
   function load_overlay_window(url_frammento, id_window, callback, params) {
      Load_anim.start();
      load_html_fragment(url_frammento, function() {
         Load_anim.stop();
         show_overlay_window(id_window, callback);
      }, params);
   }
   
    function on_row_selected(form, callback, error_msg) {
        var _checked = $(form).find("input[type='radio']:checked");
        if (_checked.length > 0) {
            callback(_checked);
        } else {
            var msg = typeof error_msg != 'undefined' ? error_msg : 'Almeno un elemento della lista deve essere selezionato.';
            Notify.message(msg);
        }
    }  
	
	function get(url, callback, params, type) {
      return _ajax('get', base_url + url, callback, params, type, true);
   }

   function post(url, callback, params, type) {
      return _ajax('post', base_url + url, callback, params, type, true);
   }

   function _ajax(reqType, url, callback, params, type, async) {
      params = (typeof params == "undefined") ? {} : params;
      type = (typeof type == "undefined") ? "json" : type;
      return $.ajax({
         type: reqType,
         url: url,
         async: async,
         data: params,
         cache: false,
         dataType: type,
         success: callback,
         error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == "401") {
               window.location = base_url;
            }
            else if(jqXHR.status == "503") {
               window.location = base_url + 'login/wip';
            }
            else {
               if(window.console) {
                  console.log(jqXHR.status + " " + textStatus + " - " + errorThrown);
               }
               else {
                  alert(jqXHR.status + " " + textStatus + " - " + errorThrown);
               }
            }
         }
      });
   }
	
   function lang(dictionary_term) {
      if(typeof dictionary[dictionary_term] != 'undefined') {
         return dictionary[dictionary_term];
      }
      else {
         return dictionary_term;
      }
   }
   
   function formatDate(str_date) {
		var d_t = str_date.split(' ');
		var p = {date: '', time: ''};
		for(var i=0; i< d_t.length; i++) {
			if(d_t[i].indexOf('-') != -1) {
				var d = d_t[i].split('-');
				p.date = d[2] + "/" + d[1] + "/" + d[0];
			}
			else if(d_t[i].indexOf(':') != -1) {
				var t = d_t[i].split(':');
				p.time = t[0] + ':' + t[1];
			}
		}
		return $.trim(p.date + " " + p.time);
	}
   
   function parseDate(d) {
      
      var splitted_datetime = d.split(' ');
      if(splitted_datetime.length == 0) return undefined;
      
      var splitted_date = splitted_datetime[0].split('/');
      if(splitted_date.length <= 2) return undefined;
      
      var parsed_date = new Date(parseInt(splitted_date[2]), parseInt(splitted_date[window.lang=='it' ? 1 : 0]) - 1, parseInt(splitted_date[window.lang=='it' ? 0 : 1]));
      if(splitted_datetime.length > 1) {
         var splitted_time = splitted_datetime[1].split(':');
         if(splitted_time.length == 2) {
            parsed_date.setHours(parseInt(splitted_time[0]));
            parsed_date.setMinutes(parseInt(splitted_time[1]));
         }
         if(splitted_time.length == 3) {
            parsed_date.setSeconds(parseInt(splitted_time[2]));
         }
      }
      
      return parsed_date;
   }
   
   function printf(source, params) {
      if ( arguments.length == 1 ) 
         return function() {
            var args = $.makeArray(arguments);
            args.unshift(source);
            return printf.apply( this, args );
         };
      if ( arguments.length > 2 && params.constructor != Array  ) {
         params = $.makeArray(arguments).slice(1);
      }
      if ( params.constructor != Array ) {
         params = [ params ];
      }
      $.each(params, function(i, n) {
         source = source.replace(new RegExp("\\{" + i + "\\}", "g"), n);
      });
      return source;
   };
   
   function popup_window(url, width, height, window_name) {
      var
      opt, w;
		
      width = typeof width != 'undefined' ? width : 500;
		height = typeof height != 'undefined' ? height : 333;
		opt = 'width=' + width + ',height=' + height + ',resizable=yes,scrollbars=yes,toolbar=no,location=no,directories=no,status=no,menubar=no';
		w = window.open( base_url + 'main/wait', (typeof window_name != 'undefined' ? window_name : ''), opt);
      
      setTimeout(function () { w.location = base_url + url; }, 500);
      
      return w;
	}
	
   return {
      show_message: show_message,
      confirm: confirm,
      on_row_selected: on_row_selected,
      load_overlay_window: load_overlay_window,
      parseDate: parseDate,
      formatDate: formatDate,
      get: get,
      post: post,
      printf: printf,
      lang: lang,
      popup_window: popup_window,
      create_autocomplete: create_autocomplete
   };
})(jQuery);


//START APPLICATION
$(function(){ 
   if(typeof user_message != 'undefined') CH_Tools.show_message(user_message.message, user_message.type);
   if(typeof Foundation != 'undefined') { $(document).foundation(); }
});