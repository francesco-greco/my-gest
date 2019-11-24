<div id="widget_file_import_window" style="width: 700px; background: #fffff0">
   <h3>Importazione File <?php echo $filename . " per <b>" . $brand->brand_name . "</b>" ?></h3>
   <?php echo form_open_multipart(CH_URL_FILE_IMPORT . "/load_file"); ?>
   <div class="row">
      <div class="large-12 columns">
         <span class="bold">Seleziona file</span>
         <input type="file" name="attachment" id="attachment" size="50">
      </div>
   </div>
   <br>
   <div class="progress large-12 alert round ">
      <span class="meter" style="width: 0%"></span>
   </div>
   <hr>
   <div class="row">
      <div class="large-12 columns right" style="text-align: right; padding-right: 0px;">
         <a href="#" class="btn-start-upload" title="Inizia caricamento"><i class="fa fa-lg fa-download"></i></a>
      </div>
   </div>
   <input type="hidden" name="brand_code" value="<?php echo $brand->brand_code ?>">
   <input type="hidden" name="file_type" value="<?php echo $filename ?>">
   <?php echo form_close(); ?>
</div>

