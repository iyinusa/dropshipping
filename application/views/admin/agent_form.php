<?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
<div class="columns">
    <div class="column is-12"><div id="bb_ajax_msg"></div></div>
</div>

<div class="columns">
    <div class="column is-6">
        <div class="control">
            <label class="label-text">Assign Role</label>
            <?php $roles = array('customer', 'agent', 'administrator'); ?>
            <select name="roles" class="chosen-select form-control" style="width:100%;">
                <?php 
                    foreach($roles as $k=>$v) {
                        $r_sel = '';
                        if($role == $v) { $r_sel = 'selected'; }
                        echo '<option value="'.$v.'" '.$r_sel.'>'.ucwords($v).'</option>';
                    }
                ?>
			</select>
        </div>
    </div>

    <div class="column is-6">
        <div class="control">
            <label class="label-text">Wallet Balance</label>
            <input name="wallet" type="text" class="input" value="<?php echo $wallet; ?>">
        </div>
    </div>
</div>

<div class="columns">
    <div class="column is-12">
        <button class="button is-danger is-outlined is-medium is-fullwidth">Save Record</button>
    </div>
</div>
<?php echo form_close(); ?>

<script src="<?php echo base_url(); ?>assets/js/jsform.js"></script>