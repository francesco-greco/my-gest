<?php
if (!function_exists('print_attribute')) {
   function print_attribute($attribute, $value, $expression=TRUE, $return_string = FALSE) {
      $s = ($expression ? $attribute.'="'.$value.'"' : '');
      if($return_string)
         return $s;
      else
         echo $s;
   }
}

if (!function_exists('mark_readonly')) {
   function mark_readonly($expression, $return_string = FALSE) {
      if($return_string)
         return print_attribute('readonly', 'readonly', $expression, $return_string);
      else
         echo print_attribute('readonly', 'readonly', $expression, $return_string);
   }
}

if (!function_exists('mark_disabled')) {
   function mark_disabled($expression, $return_string = FALSE) {
      $s = ($expression ? 'disabled="disabled"' : '');
      if($return_string)
         return $s;
      else
         echo $s;
   }
}

if (!function_exists('mark_selected')) {
   function mark_selected($val_1, $val_2, $return_string = FALSE) {
      $s = ($val_1 == $val_2 ? 'selected="selected"' : '');
      if($return_string)
         return $s;
      else
         echo $s;
   }
}

if (!function_exists('mark_checked')) {
   function mark_checked($val_1, $val_2, $return_string = FALSE) {
      $s = ($val_1 == $val_2 ? 'checked="checked"' : '');
      if($return_string)
         return $s;
      else
         echo $s;
   }
}

if (!function_exists('to_currency')) {
   function to_currency($num, $separatore_migliaia = '') {
      if(is_numeric($num)) {
         return number_format($num, 2, '.', $separatore_migliaia);
      }
      return "0.00";
   }
}

if (!function_exists('to_printable_currency')) {
   function to_printable_currency($num, $separatore_migliaia = '.') {
      if(is_numeric($num)) {
         return number_format($num, 2, ',', $separatore_migliaia);
      }
      return "0,00";
   }
}

if (!function_exists('is_null_date')) {
   function is_null_date($data) {
      return $data == NULL_DB_DATE OR $data == NULL_DB_TIME OR $data == NULL_DB_DATE.' '.NULL_DB_TIME;
   }
}

if(!function_exists('now_mysql_date')) {
   function now_mysql_date($time = NULL, $only_date=FALSE) {
      $tpl = $only_date ? 'Y-m-d' : 'Y-m-d H:i:s';
      return date($tpl, $time === NULL ? time() : $time);
   }
}

if(!function_exists('now_date')) {
   function now_date($time = NULL, $only_date=FALSE) {
      $tpl = $only_date ? 'd/m/Y' : 'd/m/Y H:i:s';
      return date($tpl, $time === NULL ? time() : $time);
   }
}

if (!function_exists('db_to_normal_date')) {
   function db_to_normal_date($data) {
      $exploded_date = explode("-", $data);
      if($data != NULL && !is_null_date($data) && count($exploded_date) === 3) {
         return $exploded_date[2].'/'.$exploded_date[1].'/'.$exploded_date[0];
      }
      return "";
   }
}

if(!function_exists('db_datetime_to_normal_date')) {
   function db_datetime_to_normal_date($data) {
      $exploded_full_date = explode(" ", $data);
      $exploded_date = explode("-", $exploded_full_date[0]);
      if($data != NULL && !is_null_date($data) && count($exploded_date) === 3) {
         return $exploded_date[2].'/'.$exploded_date[1].'/'.$exploded_date[0];
      }
      return "";
   }
}

if ( ! function_exists('millis_to_date')) {
   function millis_to_date ($millis) { return now_date(floor(floatval($millis)/1000), TRUE); }
}

if ( ! function_exists('db_to_normal_time')) {
	function db_to_normal_time($time, $second=FALSE) {
      $exploded_time = explode(":", $time);
      if($time != NULL && !is_null_date($time) && count($exploded_time) === 3) {
         if($second===FALSE){
            $returned_time = $exploded_time[0].':'.$exploded_time[1];
         }else{
            $returned_time = $exploded_time[0].':'.$exploded_time[1].':'.$exploded_time[2];
         }
         return $returned_time;
      }
      return "";
	}
}

function db_to_normal_timestamp($date_time,$seconds=FALSE) {
   if($date_time != NULL && !is_null_date($date_time)) {
      $t = explode(' ', $date_time);
      if($t && count($t) === 2) {
         $parsed_date = db_to_normal_date($t[0]);
         $parsed_time = db_to_normal_time($t[1],$seconds);
         return trim($parsed_date.' '.$parsed_time);
      }
      else return "";
   }
}

if ( ! function_exists('normal_to_db_date')) {
	function normal_to_db_date($data) {
      if($data != NULL) {
         $d = explode('/', $data);
         if(count($d) === 3)
            return $d[2].'-'.$d[1].'-'.$d[0];
         else {
            return NULL_DB_DATE;
         }
      }
      return NULL_DB_DATE;
	}
}

if ( ! function_exists('normal_to_db_timestamp')) {
	function normal_to_db_timestamp($data) {
      $t = explode(' ', $data);
      if(count($t) > 0) {
         $parsed_date = normal_to_db_date($t[0]);
         if(count($t) > 1) {
            return $parsed_date.' '.$t[1];
         }
         else {
            return $parsed_date.' '.NULL_DB_TIME;
         }
      }
	}
}

if ( ! function_exists('get_months')) {
	function get_months() {
      return array(
         1  => 'Gennaio',
         2  => 'Febbraio',
         3  => 'Marzo',
         4  => 'Aprile',
         5  => 'Maggio',
         6  => 'Giugno',
         7  => 'Luglio',
         8  => 'Agosto',
         9  => 'Settembre',
         10 => 'Ottobre',
         11 => 'Novembre',
         12 => 'Dicembre'
      );
	}
}

if ( ! function_exists('get_years')) {
	function get_years($to, $from=2000) {
      $years = array();
      $current_year = intval($to);
      for($y = $from; $y<=$current_year; $y++) {
         $years[$y] = $y;
      }
      return $years;
	}
}

if ( ! function_exists('print_url')) {
	function print_url($trail) {
		echo  base_url($trail);
	}
}

if ( ! function_exists('is_xmlhttprequest')) {
	function is_xmlhttprequest() {
		return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
}

if ( ! function_exists('json_output')) {
	function json_output($value) {
		echo json_encode($value);
	}
}

if ( ! function_exists('json_response')) {
   function json_response($result, $data = NULL) {
      $d = $data !== NULL ? array_merge(array('result' => $result), $data) : array('result' => $result);
		json_output($d);
	}
}

if ( ! function_exists('load_ch_class')) {
   function load_ch_class($class_path) {
      require_once APPPATH.'classes/'.$class_path.'.php';
   }
}

if ( ! function_exists('load_dto')) {
   function load_dto() {
      $args = func_get_args();
      array_walk($args, function($dto_path, $key) { 
         require_once APPPATH.'dto/'.$dto_path.'.php'; 
      });
   }
}

if ( ! function_exists('flatten_for_autocomplete')) {
   function flatten_for_autocomplete($list, $value_field, $label_field = FALSE) {
      $autocomplete_feed = array();
      $flattenizer = $label_field == FALSE 
         ? function($element, $v_field) { return $element[$v_field]; } 
         : function($element, $v_field, $l_field) {  return array('value' => $element[$v_field], 'label' => $element[$l_field]);  };
         
      foreach ($list as $element) {
         $autocomplete_feed[] = $flattenizer((array)$element, $value_field, $label_field);
      }
      
      return $autocomplete_feed;
   }
}

if ( ! function_exists('lang')) {
	function lang($dictionary_term) {
		$CI =& get_instance();
      
      $line = FALSE;
      if(func_num_args() > 1) {
         $to_be_parsed = $CI->lang->line($dictionary_term);
         if($to_be_parsed !== FALSE) {
            $args = func_get_args();
            $args[0] = $to_be_parsed;

            $line = call_user_func_array('sprintf', $args);
         }
      }
      else {
         $line = $CI->lang->line($dictionary_term);
      }
      
		return ($line !== FALSE) ? $line : $dictionary_term;
	}
}

if( ! function_exists('send_file_to_browser')) {
   function send_file_to_browser($full_filepath, $client_filename = FALSE) {
      if (file_exists($full_filepath)) {

         header('Content-Description: File Transfer');
         header('Content-Type: application/octet-stream');
         header('Content-Disposition: attachment; filename='.($client_filename !== FALSE ? $client_filename : basename($full_filepath)));
         header('Content-Transfer-Encoding: binary');
         header('Expires: 0');
         header('Cache-Control: must-revalidate');
         header('Pragma: public');
         header('Content-Length: ' . filesize($full_filepath));
         
         ob_clean();
         flush();
         readfile($full_filepath);
         exit;
      }
      return FALSE;
	}
}

if(!function_exists('ch_send_email')) {
   function ch_send_email($email) {
      $ci = &get_instance();
      
      $ci->load->library('phpmailer_lib');
      
      if(array_key_exists('from', $email)) {
         $ci->phpmailer_lib->from($email['from']);
      }
      else {
         $ci->phpmailer_lib->from(CH_EMAIL_NOREPLY);
      }
      
      if(ENVIRONMENT === 'development') {
         $ci->phpmailer_lib->to(CH_EMAIL_DEBUG);
		}
		else if(ENVIRONMENT === 'production') {
         if(is_array($email['to'])) {
            foreach ($email['to'] as $to) {
               $ci->phpmailer_lib->to($to);
            }
         }
         else {
            $ci->phpmailer_lib->to($email['to']);
         }
         
         if(array_key_exists('cc', $email)) {
            if(is_array($email['cc'])) {
               foreach ($email['cc'] as $cc) {
                  $ci->phpmailer_lib->cc($cc);
               }
            }
            else {
               $ci->phpmailer_lib->cc($email['cc']);
            }
         }
         
         if(array_key_exists('reply_to', $email)) {
            if(is_array($email['reply_to'])) {
               foreach ($email['reply_to'] as $reply_to) {
                  $ci->phpmailer_lib->reply_to($reply_to);
               }
            }
            else {
               $ci->phpmailer_lib->reply_to($email['reply_to']);
            }
         }
         
         if(array_key_exists('bcc', $email)) {
            if(is_array($email['bcc'])) {
               foreach ($email['bcc'] as $bcc) {
                  $ci->phpmailer_lib->bcc($bcc);
               }
            }
            else {
               $ci->phpmailer_lib->bcc($email['bcc']);
            }
         }
		}
      
      $subject = (ENVIRONMENT === 'development' ? 'EMAIL TEST - ' : '').$email['subject'];
      $ci->phpmailer_lib->subject($subject);
      $ci->phpmailer_lib->message($email['message']);

      if(array_key_exists('attach', $email)) {
         if(is_string ($email['attach'])) {
            $ci->phpmailer_lib->attach($email['attach']);
         }
         else if(is_array ($email['attach'])) {
            foreach($email['attach'] as $attachment) {
               $ci->phpmailer_lib->attach($attachment);
            }
         }
      }
            
      if($ci->phpmailer_lib->send()) {
         $data['result'] = CH_RESPONSE_SUCCESS;
      }
      else {
         $data['result'] = CH_RESPONSE_FAILURE;
         $data['message'] = $this->phpmailer_lib->is_error() ? $this->phpmailer_lib->get_error() : 'L\'email non è stata inviata.';
      }
            
      return $data;
   }
}

if(!function_exists('render_table_legenda')) {
   function render_table_legenda($legenda) {
?>
   <ul class="link-list" style="position: absolute; bottom: 6px; right: 35px;">
      <li style="padding-left: 20px;"><b>Legenda: </b></li>
      <?php foreach($legenda as $element): ?>
      <li class="colore_legenda" style="background-color: <?php echo $element['color'] ?>;"></li>
      <li class="voce_legenda"><?php echo $element['label'] ?></li>
      <?php endforeach; ?>
   </ul>
<?php
   }
}