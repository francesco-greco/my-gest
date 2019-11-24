<div id="new_note_container" style="width: 500px;">
    <h3>Nuova nota <?php echo $post_string; ?></h3>
    <form method="post" class="custom condensed-form" id="form_note" action="<?php print_url(CH_URL_INTERVENTIONS . "/save_note") ?>">
        <div class="row">
            <div class="columns large-12">
                <label class="bold" for="note_note_code" style="margin-top: 20px;">Codice nota</label>
                <div class="columns large-6 end" style="padding-left: 0px;">
                    <select required="" id="note_note_code" name="note_note_code" class="expand" data-customforms="disabled">
                        <option value=""> --- </option>
                        <?php foreach ($notes as $k => $value): ?>
                        <option text-string="<?php echo $value ?>" value="<?php echo $k ?>"><?php echo "(".$k.") ".$value ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="columns large-12">
                <textarea required="" name="note_note_text" style="height: 150px; margin-top: 20px;"></textarea>
                <input type="hidden" name="note_user_id" value="<?php echo $this->bitauth->user_id ?>">
                <input type="hidden" name="note_user_fullname" value="<?php echo $this->bitauth->fullname ?>">
                <input type="hidden" name="note_id_intervention" value="<?php echo $id_intervention ?>">
            </div>
        </div>
        <div class="row">
            <div class="columns large-12">
                <hr>
                <div class="columns large-9"></div>
                <div class="columns large-3 text-left" >
                    <a href="#" style="" class="button radius btn-nota-save"><i class="fa fa-fw fa-lg fa-save"></i></a>
                </div>
            </div>
        </div>
    </form>
</div>