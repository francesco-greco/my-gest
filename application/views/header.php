<!DOCTYPE html>
<html class="no-js" lang="en">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>My-Gest-App<?php echo (isset($bb) AND count($bb) > 0) ? ' - '.$bb[count($bb) - 1]['label'] : '' ?></title>
	
      <link rel="shortcut icon" href="<?php print_url('favicon.ico') ?>" />
		<link rel="icon" href="<?php print_url('favicon.ico') ?>" />

      <link rel="stylesheet" href="<?php print_url('css/font-awesome.min.css') ?>">
      <link rel="stylesheet" href="<?php print_url('css/foundation.css') ?>" />
      <link rel="stylesheet" href="<?php print_url('css/jquery.dataTables.foundation.css') ?>" />
      <link rel="stylesheet" href="<?php print_url('css/humane_themes/original.css') ?>" />
      <link rel="stylesheet" href="<?php print_url('css/redmond/jquery-ui-1.9.2.custom.min.css') ?>">
      <link rel="stylesheet" href="<?php print_url('css/jquery-ui-timepicker-addon.css') ?>">
      <link rel="stylesheet" href="<?php print_url('css/my_main.css') ?>" />
      <?php if(isset($css_script) && count($css_script) > 0) : ?>
         <?php foreach($css_script as $script) : ?>
         <link rel="stylesheet" href="<?php print_url("css/{$script}") ?>">
         <?php endforeach; ?>
		<?php endif; ?>

      <script src="<?php print_url('js/vendor/jquery.js') ?>"></script>
      <script src="<?php print_url('js/vendor/jquery-migrate.min.js') ?>"></script>
<!--      <script src="<?php print_url('js/vendor/jquery-ui.min.js') ?>"></script>-->
      <script src="<?php print_url('js/vendor/jquery-ui-1.9.2.custom.min.js') ?>"></script>
      <script src="<?php print_url('js/vendor/modernizr.js') ?>"></script>
  		<script src="<?php print_url('js/my_serverside_constants.js.php') ?>"></script>
      
      <script> 
			var 
         base_url = '<?php echo $base_url ?>',
         <?php if(isset($this->bitauth->preferred_lang)) : ?>
         lang = '<?php echo $this->bitauth->preferred_lang ?>',
         <?php endif; ?>
         dictionary = <?php if(isset($dictionary) && is_array($dictionary)) { echo json_encode($dictionary); } else { echo '{}'; }?>,
         <?php if(isset($user_message) && $user_message['message'] != '') : ?>
         user_message = <?php echo json_encode($user_message) ?>,
         <?php endif; ?>
         is_user_logged = <?php echo (isset($this->bitauth) && $this->bitauth->logged_in()? 'true' : 'false'); ?>;
		</script>
   </head>
   <body>
      <div class="fixed">
         <nav class="top-bar" data-topbar role="navigation">
            <ul class="title-area">
               <li class="name"><h1><a href="<?php echo $base_url, CH_URL_MAIN ?>">My-Gest-App</a></h1></li>
               <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li> 
            </ul> 
            <section class="top-bar-section"> 
               <ul class="left">
                  <?php if(isset($bb)) : ?>
                     <?php foreach ($bb as $i => $crumb): ?>
                        <li>
                           <a <?php echo $i == count($bb) - 1 ? "class='current'" : ""?> href="<?php echo isset($crumb['url']) ? $crumb['url'] : "" ?>"><?php echo $crumb['label'] ?></a>
                        </li>
                     <?php endforeach; ?>
                  <?php endif; ?>
               </ul>
               <ul class="right">
                  <?php if($this->bitauth->logged_in()): ?>
                  <li style="color: white; line-height: 2.7em;">Benvenuto, <?php echo $this->bitauth->fullname ?></li>
                  <li><a href="<?php print_url(CH_URL_LOGIN.'/logout') ?>" title="<?php echo lang('common_words_save') ?>"><i class="fa fa-fw fa-lg fa-power-off"></i></a></li>
                  <?php endif; ?>
               </ul>
            </section>
         </nav>
      </div>
      <div id="ch_main_container">