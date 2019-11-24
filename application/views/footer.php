		</div>
      <form id='form_reload_page' method="POST" action="#"></form>
      <!-- Template dei messaggi di popup -->
		<div id="window-messaggio" class="reveal-modal medium" style="display: none; background: #4682b4; border-radius: 20px 20px 20px 20px;"  data-reveal>
			<div class="row">
				<table style="border: none; margin-bottom: 0px;">
					<tr>
						<td class="msg-sign" style="vertical-align: middle; width: 4em;"></td>
						<td class="msg-body" style="vertical-align: middle"></td>
					</tr>
				</table>
         </div>
         <br>
			<div class="row buttons-row">
				<div class="large-3 columns large-offset-3" style="margin-top: 10px;">
					<button class="success button expand round">Si</button>
				</div>
				<div class="large-3 columns end" style="margin-top: 10px;">
					<button class="alert button expand round">No</button>
				</div>
			</div>
         <a class="close-reveal-modal">&#215;</a>
		</div>
		
      <script src="<?php print_url('js/foundation.min.js') ?>"></script>
      <script src="<?php print_url("js/plugin/jquery.form.js") ?>"></script>
      <script src="<?php print_url("js/plugin/validate/jquery.validate.min.js") ?>"></script>
      <script src="<?php print_url("js/plugin/validate/additional-methods.min.js") ?>"></script>
      <?php if($this->bitauth->logged_in() && $this->bitauth->preferred_lang == CH_LANG_IT): ?>
      <script src="<?php print_url("js/plugin/validate/messages_it.min.js") ?>"></script>
      <?php endif; ?>
      <script src="<?php print_url("js/plugin/dataTables/jquery.dataTables.min.js") ?>"></script>
      <script src="<?php print_url("js/plugin/dataTables/jquery.dataTables.foundation.js") ?>"></script>
      <script src="<?php print_url('js/plugin/humane/humane.js') ?>"></script>
      <script src="<?php print_url('js/plugin/spin.js') ?>"></script>
      <script src="<?php print_url('js/plugin/timepicker/jquery-ui-timepicker-addon.js') ?>" defer="defer"></script>
      
      <?php if($this->bitauth->logged_in()): ?>
      <script src="<?php print_url("js/plugin/dataTables/jquery.dataTables.lang.{$this->bitauth->preferred_lang}.js") ?>"></script>
      <script src="<?php print_url("js/plugin/timepicker/i18n/jquery-ui-timepicker-{$this->bitauth->preferred_lang}.js") ?>" defer="defer"></script>
      <script src="<?php print_url("js/vendor/jquery.ui.datepicker-{$this->bitauth->preferred_lang}.js") ?>" defer="defer"></script>
      <?php else : ?>
      <script src="<?php print_url('js/plugin/timepicker/i18n/jquery-ui-timepicker-it.js') ?>" defer="defer"></script>
      <script src="<?php print_url("js/plugin/dataTables/jquery.dataTables.lang.it.js") ?>"></script>
      <?php endif; ?>
      <script src="<?php print_url('js/jquery-ui-1.9.2.custom.min.js') ?>"></script>
      
      <?php if(isset($plugins) && count($plugins) > 0) : ?>
      <?php foreach($plugins as $plugin) : ?>
		<script src="<?php print_url("js/{$plugin}") ?>"></script>
      <?php endforeach; ?>
		<?php endif; ?>
      
		<?php $v = "0.00.001"; //Utilizzato per evitare il caching degli script dopo una modifica ?>
      <script src="<?php print_url("js/widget.js?".$v) ?>"></script>
      <script src="<?php print_url("js/my_utility.js?".$v) ?>"></script>
      <script src="<?php print_url('js/my_gest_app.js?'.$v) ?>"></script>
      
		<?php if(isset($modules) && count($modules) > 0) : ?>
      <?php foreach($modules as $script) : ?>
		<script src="<?php print_url("js/{$script}?".$v) ?>"></script>
      <?php endforeach; ?>
		<?php endif; ?>
      
	</body>
</html>