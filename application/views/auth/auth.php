<div class="section">
    <div class="container">

        <div class="columns account-header is-auth">
            <div class="column is-10 is-offset-1 is-tablet-landscape-padded">
                <div class="auth-title">
                    <h2>LOGIN</h2>
                    <a href="<?php echo base_url(); ?>" class="button feather-button is-small primary-button upper-button raised is-hidden-mobile">
                        <span><i class="fa fa-home"></i> Home</span>
                    </a>
                    <img class="brand-filigrane" src="<?php echo base_url(); ?>assets/images/icon_inverse.png" alt="">
                </div>
                
                <div class="flat-card is-auto is-auth-form">
                    <div class="columns is-gapless is-flex-mobile">
                        <div class="column is-6 has-text-centered image-column is-padded">
                            <div class="store-wrapper">
                                <img src="<?php echo base_url(); ?>assets/images/icon.png" alt="">
                                <div class="title">
                                    <?php echo app_name; ?>
                                </div>
                                <div class="subtitle"><?php echo app_meta_desc; ?></div>
                            </div>
                            <div class="nephos-overlay"></div>
                        </div>
                        
                        <div class="column is-6 is-mobile-padded">

                            <div class="tabs-wrapper animated-tabs">
                                <div class="tabs is-form-tabs">
                                    <ul>
                                        <li class="is-tab is-active" data-tab="login"><a>Login</a></li>
                                        <li class="is-tab" data-tab="register"><a>Register</a></li>
                                    </ul>
                                </div>

                                <div id="msg" class="is-12 has-text-centered has-text-grey-lighter"></div>
                                
                                <div id="login" class="navtab-content is-active">
                                    <div class="control">
                                        <label class="auth-label">Email*</label>
                                        <input id="email" type="email" class="input" placeholder="">
                                    </div>
                                    <div class="control">
                                        <label class="auth-label">Password*</label>
                                        <input id="password" type="password" class="input" placeholder="">
                                    </div>
                                    <div class="control">
                                        <label class="checkbox-wrap is-small">
                                            <input id="house" type="checkbox" class="d-checkbox" checked>
                                            <span></span>
                                            <small>Remember me?</small>
                                        </label>
                                    </div>
                                    
                                    <div class="button-wrapper">
                                        <button type="submit" class="button feather-button primary-button upper-button raised is-login">
                                            <b><i class="fa fa-unlock"></i> Login</b>
                                        </button>
                                        <a class="forgotten">Forgot Password ?</a>
                                    </div>
                                </div>
                                
                                
                                <div id="register" class="navtab-content">
                                    <div class="control">
                                        <label class="auth-label">First Name*</label>
                                        <input id="reg_firstname" type="text" class="input" placeholder="">
                                    </div>
                                    <div class="control">
                                        <label class="auth-label">Last Name*</label>
                                        <input id="reg_lastname" type="text" class="input" placeholder="">
                                    </div>
                                    <div class="control">
                                        <label class="auth-label">Email*</label>
                                        <input id="reg_email" type="email" class="input" placeholder="">
                                    </div>
                                    <div class="control">
                                        <label class="auth-label">Password*</label>
                                        <input id="reg_password" type="password" class="input" placeholder="">
                                    </div>
                                    <div class="control">
                                        <label class="auth-label">Confirm Password*</label>
                                        <input id="reg_confirm" type="password" class="input" placeholder="">
                                    </div>
                                    <div class="control">
                                        <label class="checkbox-wrap">
                                            <input id="is_agent" type="checkbox" class="d-checkbox">
                                            <span></span>
                                            <small>I'm a Shipping Agent</small>
                                        </label>
                                    </div>
                                    
                                    <div class="button-wrapper">
                                        <button type="submit" class="button feather-button primary-button upper-button raised is-register">
                                            <b><i class="fa fa-user-plus"></i> Register</b>
                                        </button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
    
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script>var base_url = '<?php echo base_url(); ?>';</script>
<script src="<?php echo base_url(); ?>assets/js/custom/auth.js"></script>