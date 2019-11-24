<?php 
   define('BASEPATH', '1');
   define('APPPATH', '../application/');
   include_once APPPATH.'config/CH_constants.php'; 
?>

var CH_URL = {
   attachments: '<?php echo CH_URL_ATTACHMENTS ?>',
	login: '<?php echo CH_URL_LOGIN ?>',
	main:  '<?php echo CH_URL_MAIN ?>',
   users:  '<?php echo CH_URL_USERS ?>',
   clients: '<?php echo CH_URL_CLIENTS ?>',
   lab_instruments: '<?php echo CH_URL_LAB_INSTRUMENTS ?>',
   lab_tasks: '<?php echo CH_URL_LAB_TASKS ?>',
   projects: '<?php echo CH_URL_PROJECTS ?>',
   labs: '<?php echo CH_URL_LABS ?>',
   interventions: '<?php echo CH_URL_INTERVENTIONS ?>',
   listini: '<?php echo CH_URL_LISTINI ?>',
   products: '<?php echo CH_URL_PRODUCTS ?>',
   fornitori: '<?php echo CH_URL_FORNITORI ?>',
   ddt: '<?php echo CH_URL_DDT ?>',
   file_import: '<?php echo CH_URL_FILE_IMPORT ?>'
};

var tipo_movimento = {
   da_0_ad_altro: 1,
   carico_0: 2,
   scarico_vendita: 3
};


var CH_RESULT = { SUCCESS: '<?php echo CH_RESPONSE_SUCCESS ?>', FAILURE: '<?php echo CH_RESPONSE_FAILURE ?>'};