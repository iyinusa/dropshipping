<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
<div class="columns">
    <div class="column is-12"><div id="bb_ajax_msg"></div></div>
</div>

<?php if(empty($type) || $type == 'edit') { ?>
    <div class="columns">
        <div class="column is-6">
            <input type="hidden" name="ship_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="control">
                <label class="label-text">Type</label>
                <?php 
                    $country_id = $this->Crud->read_field('name', 'Nigeria', 'country', 'id'); 
                    $states = $this->Crud->read_single_order('country_id', $country_id, 'state', 'name', 'asc'); 
                ?>
                <select name="state_id" class="chosen-select form-control" style="width:100%;">
                    <?php 
                        if(!empty($states)) {
                            foreach($states as $st) {
                                $r_sel = '';
                                if($e_state_id == $st->id) { $r_sel = 'selected'; }
                                echo '<option value="'.$st->id.'" '.$r_sel.'>'.$st->name.'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="column is-6">
            <div class="control">
                <label class="label-text">Amount</label>
                <input name="amount" type="text" class="input" value="<?php if(!empty($e_amount)){ echo $e_amount; } ?>" placeholder="1200">
            </div>
        </div>
    </div>

    <div class="columns">
        <div class="column is-12">
            <button class="button is-danger is-outlined is-medium is-fullwidth">Save Record</button>
        </div>
    </div>
<?php } ?>

<?php if($type == 'delete') { ?>
    <div class="columns">
        <div class="column is-12">
            <input type="hidden" name="d_ship_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
            <h3>Are you sure?</h3>
        </div>
    </div>

    <div class="columns">
        <div class="column is-12">
            <button class="button is-danger is-outlined is-medium is-fullwidth">Yes - Delete</button>
        </div>
    </div>
<?php } ?>

<?php echo form_close(); ?>

<script src="<?php echo base_url(); ?>assets/js/jsform.js"></script>