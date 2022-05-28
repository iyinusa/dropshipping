<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
<div class="columns">
    <div class="column is-12"><div id="bb_ajax_msg"></div></div>
</div>

<?php if(empty($type) || $type == 'edit') { ?>
    <div class="columns">
        <div class="column is-12">
            <input type="hidden" name="ship_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="control">
                <label class="label-text">Type</label>
                <?php $types = array('Normal Shipping', 'Express Shipping', 'Triweekly Shipping'); ?>
                <select name="types" class="chosen-select form-control" style="width:100%;">
                    <?php 
                        foreach($types as $k=>$v) {
                            $r_sel = '';
                            if($e_type == $v) { $r_sel = 'selected'; }
                            echo '<option value="'.$v.'" '.$r_sel.'>'.ucwords($v).'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="columns">
        <div class="column is-6">
            <div class="control">
                <label class="label-text">Min. Kg</label>
                <input name="min" type="text" class="input" value="<?php echo $e_min; ?>">
            </div>
        </div>

        <div class="column is-6">
            <div class="control">
                <label class="label-text">Max. Kg</label>
                <input name="max" type="text" class="input" value="<?php echo $e_max; ?>">
            </div>
        </div>
    </div>

    <div class="columns">
        <div class="column is-6">
            <div class="control">
                <label class="label-text">Price/Kg</label>
                <input name="price" type="text" class="input" value="<?php echo $e_price; ?>">
            </div>
        </div>

        <div class="column is-6">
            <div class="control">
                <label class="label-text">Estimate Delivery (days)</label>
                <input name="duration" type="text" class="input" value="<?php echo $e_duration; ?>" placeholder="3-5">
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