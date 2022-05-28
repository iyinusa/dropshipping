<div class="section">
    <!-- Container -->
    <div class="container">

        <!-- Account Layout -->
        <div class="columns account-header">
            <div class="column is-10 is-offset-1 is-tablet-landscape-padded">
                <!-- Title -->
                <div class="account-title">
                    <h2>ACCOUNT</h2>
                    <img class="brand-filigrane" src="<?php echo base_url(); ?>assets/images/icon_inverse.png" alt="">
                </div>

                <?php include(APPPATH.'views/user/menu.php'); ?>

                <?php echo form_open_multipart($form_link, array('id'=>'bb_ajax_form', 'class'=>'')); ?>
                    <div class="columns is-account-grid is-multiline">
                        <div class="column is-12"><div id="bb_ajax_msg"></div></div>

                        <div class="column is-5">
                            <div class="flat-card profile-card is-auto">
                                <div class="card-body">
                                    <div class="view">
                                        <div class="profile-image">
                                            <img src="<?php echo base_url($img); ?>" alt="">
                                        </div>
                                        <div class="username has-text-centered">
                                            <span><?php echo $firstname.' '.$lastname; ?></span>
                                            <small>Member since <?php echo date('M d, Y', strtotime($reg_date)); ?></small>
                                        </div>
                                    </div>
                                    <div class="edit" style="display:none;">
                                        <div id="avatar-upload" class="avatar-wrapper has-simple-popover" data-content="Change profile picture" data-placement="top">
                                            <img class="profile-pic" src="<?php echo base_url($img); ?>" alt="">
                                            <div class="upload-button">
                                                <i class="upload-icon" data-feather="plus" aria-hidden="true"></i>
                                            </div>
                                            <input type="hidden" name="img_id" value="<?php echo $img_id; ?>">
                                            <input class="file-upload" type="file" name="pics" accept="image/*"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-footer has-text-centered">
                                    <span class="achievement-title">Account Type</span>
                                    <div class="count">
                                        <?php echo strtoupper($role); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="flat-card view profile-card is-auto">
                                <div class="card-body">
                                    <div class="has-text-centered">
                                        <img class="logo" src="<?php echo base_url(); ?>assets/images/icons/money.svg" alt="" style="max-width:35%;">
                                    </div>
                                </div>
                                <div class="profile-footer has-text-centered">
                                    <span class="achievement-title">Wallet Balance</a></span>
                                    <div class="count has-text-success">
                                        &#8358;<?php echo number_format($wallet,2); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="column is-7">
                            <div class="flat-card profile-info-card is-auto">
                                <!-- Title -->
                                <div class="card-title">
                                    <h3>Account Details</h3>

                                    <?php if($log_id == $id){ ?>
                                    <div class="edit-account has-simple-popover popover-hidden-mobile view" data-content="Edit Account" data-placement="top">
                                        <a href="javascript:;"><i class="feather-icons" data-feather="settings"></i></a>
                                    </div>
                                    <div class="edit-account has-simple-popover popover-hidden-mobile edit" data-content="View Account" data-placement="top" style="display:none;">
                                        <a href="javascript:;"><i class="feather-icons" data-feather="arrow-left"></i></a>
                                    </div>
                                    <?php } ?>
                                </div>
                                
                                <div class="card-body">
                                    <div class="columns">
                                        <div class="column is-6">
                                            <div class="view">
                                                <div class="info-block">
                                                    <span class="label-text">First Name</span>
                                                    <span class="label-value"><?php echo $firstname; ?></span>
                                                </div>
                                            </div>
                                            <div class="edit" style="display:none;">
                                                <div class="control">
                                                    <label class="label-text">First Name</label>
                                                    <input name="firstname" type="text" class="input" value="<?php echo $firstname; ?>" required>
                                                </div>
                                                <br/>
                                            </div>

                                            <div class="view">
                                                <div class="info-block">
                                                    <span class="label-text">Email</span>
                                                    <span class="label-value"><?php echo $email; ?></span>
                                                </div>
                                            </div>
                                            <div class="edit" style="display:none;">
                                                <div class="control">
                                                    <label class="label-text">Email</label>
                                                    <input name="email" type="email" class="input" value="<?php echo $email; ?>" required>
                                                </div>
                                                <br/>
                                            </div>
                                        </div>

                                        <div class="column is-6">
                                            <div class="view">
                                                <div class="info-block">
                                                    <span class="label-text">Last Name</span>
                                                    <span class="label-value"><?php echo $lastname; ?></span>
                                                </div>
                                            </div>
                                            <div class="edit" style="display:none;">
                                                <div class="control">
                                                    <label class="label-text">Last Name</label>
                                                    <input name="lastname" type="text" class="input" value="<?php echo $lastname; ?>" required>
                                                </div>
                                                <br/>
                                            </div>

                                            <div class="view">
                                                <div class="info-block">
                                                    <span class="label-text">Phone</span>
                                                    <span class="label-value"><?php echo $phone; ?></span>
                                                </div>
                                            </div>
                                            <div class="edit" style="display:none;">
                                                <div class="control">
                                                    <label class="label-text">Phone</label>
                                                    <input name="phone" type="text" class="input" value="<?php echo $phone; ?>" required>
                                                </div>
                                                <br/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <img class="card-bg" src="<?php echo base_url(); ?>assets/images/icon_inverse.png" alt="">
                            </div>

                            <!-- Address Info -->
                            <div class="flat-card profile-info-card is-auto">
                                <!-- Title -->
                                <div class="card-title">
                                    <h3>Shipping Address</h3>
                                </div>
                                
                                <div class="card-body">
                                    <div class="columns">
                                        <div class="column is-6">
                                            <div class="view">
                                                <div class="info-block">
                                                    <span class="label-text">Number</span>
                                                    <span class="label-value">
                                                        <?php if(!empty($s_address)) { echo $s_address->number; } ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="edit" style="display:none;">
                                                <div class="control">
                                                    <label class="label-text">Number</label>
                                                    <input name="number" type="text" class="input" value="<?php if(!empty($s_address)) { echo $s_address->number; } ?>">
                                                </div>
                                                <br/>
                                            </div>

                                            <div class="view">
                                                <div class="info-block">
                                                    <span class="label-text">Street</span>
                                                    <span class="label-value">
                                                        <?php if(!empty($s_address)) { echo $s_address->street; } ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="edit" style="display:none;">
                                                <div class="control">
                                                    <label class="label-text">Street</label>
                                                    <input name="street" type="text" class="input" value="<?php if(!empty($s_address)) { echo $s_address->street; } ?>">
                                                </div>
                                                <br/>
                                            </div>

                                            <div class="view">
                                                <div class="info-block">
                                                    <span class="label-text">City</span>
                                                    <span class="label-value">
                                                        <?php if(!empty($s_address)) { echo $s_address->city; } ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="edit" style="display:none;">
                                                <div class="control">
                                                    <label class="label-text">City</label>
                                                    <input name="city" type="text" class="input" value="<?php if(!empty($s_address)) { echo $s_address->city; } ?>">
                                                </div>
                                                <br/>
                                            </div>
                                        </div>

                                        <div class="column is-6">
                                            <div class="view">
                                                <div class="info-block">
                                                    <span class="label-text">Postal Code</span>
                                                    <span class="label-value">
                                                        <?php if(!empty($s_address)) { echo $s_address->postal; } ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="edit" style="display:none;">
                                                <div class="control">
                                                    <label class="label-text">Postal Code</label>
                                                    <input name="postal" type="text" class="input" value="<?php if(!empty($s_address)) { echo $s_address->postal; } ?>">
                                                </div>
                                                <br/>
                                            </div>

                                            <div class="view">
                                                <div class="info-block">
                                                    <span class="label-text">Country</span>
                                                    <span class="label-value">
                                                        <?php if(!empty($country)) { echo $country; } ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="edit" style="display:none;">
                                                <div class="control">
                                                    <label class="label-text">Country</label>
                                                    <?php if(!empty($load_list_country)){echo $load_list_country;} ?>
                                                </div>
                                                <br/>
                                            </div>
                                            
                                            <div class="view">
                                                <div class="info-block">
                                                    <span class="label-text">State</span>
                                                    <span class="label-value">
                                                        <?php if(!empty($state)) { echo $state; } ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="edit" style="display:none;">
                                                <div class="control">
                                                    <label class="label-text">State</label>
                                                    <div id="load_state"><?php if(!empty($load_list_state)){echo $load_list_state;} ?></div>
                                                </div>
                                                <br/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flat-card profile-info-card is-auto edit" style="display:none;">
                                <div class="card-body">
                                    <div class="columns">
                                        <div class="column is-12">
                                            <button class="button is-danger is-outlined is-medium is-fullwidth">Update Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <!-- /Container -->
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script>var base_url = '<?php echo base_url(); ?>';</script>
<script src="<?php echo base_url(); ?>assets/js/custom/profile.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jsform.js"></script>
<script>
    function load_state() {
		var country_id = $('#country_id').val();
		$.ajax({
			url: '<?php echo base_url('profile/load_select_state/0/'); ?>' + country_id,
			success: function(data){
				$('#load_state').html(data);
			},
			complete: function() {
				$(".chosen-select").chosen();
			}
		});
	}
</script>