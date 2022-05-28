<?php
    $log_id = $this->session->userdata('afrs_id');
    $log_firstname = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
    $log_lastname = $this->Crud->read_field('id', $log_id, 'user', 'lastname');
    $log_role = $this->Crud->read_field('id', $log_id, 'user', 'role');
    $log_img_id = $this->Crud->read_field('id', $log_id, 'user', 'img_id');
    $log_img = $this->Crud->image($log_img_id, 'big');
?>
<div class="action-bar is-centered">
    <div class="steps-wrapper">
        <ol class="step-list">
            <li class="<?php if($step >= 1){ echo 'active'; } ?>"></li>
            <li class="<?php if($step >= 2){ echo 'active'; } ?>"></li>
            <li class="<?php if($step >= 3){ echo 'active'; } ?>"></li>
            <li class="<?php if($step >= 4){ echo 'active'; } ?>"></li>
        </ol>
    </div>
</div>

<div class="shop-wrapper">
    <?php if($step == 1){ ?>
        <div class="section">
            <div class="container">
                <div class="columns account-header">
                    <div class="column is-10 is-offset-1 checkout-wrapper is-tablet-landscape-padded">
                        <div class="checkout-title">
                            <h2>CHECKOUT</h2>
                            <h3><?php if(!empty($order_no)){ echo 'ORDER-'.$order_no; } ?></h3>
                        </div>
                        
                        <div class="flat-card is-auto is-checkout-form">
                            <div class="columns is-gapless is-vcentered">
                                <div class="column is-12 has-text-centered grey-column is-padded">
                                    <div class="customer-wrapper">
                                        <img src="<?php echo base_url($log_img); ?>" alt="">
                                        <div class="logged-as">
                                            Checkout as
                                        </div>
                                        <div class="username">
                                            <?php echo $log_firstname.' '.$log_lastname; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="button-wrapper has-text-right">
                            <a href="<?php echo base_url('cart'); ?>" class="button feather-button is-small primary-button upper-button raised">
                                <span><i class="fa fa-arrow-left"></i> Cancel</span>
                            </a>
                            <a href="<?php echo base_url('checkout/step/2'); ?>" class="button feather-button is-small primary-button upper-button raised">
                                <span>Next <i class="fa fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if($step == 2){ ?>
        <div class="section">
            <div class="container">
                <div class="columns account-header">
                    <div class="column is-10 is-offset-1 checkout-wrapper is-tablet-landscape-padded">
                        <div id="checkout_msg" class="is-centered"></div>

                        <div class="checkout-title">
                            <h2>SHIPPING</h2>
                            <h3><?php if(!empty($order_no)){ echo 'ORDER-'.$order_no; } ?></h3>
                        </div>
                        
                        <div class="flat-card is-auto is-checkout-form has-overflow">
                            <div class="columns is-gapless is-vcentered">
                                <div class="column is-5 has-text-centered grey-column has-popover-top enhanced-popover-hidden-mobile">
                                    <div class="shipping-wrapper">
                                        <div class="columns is-multiline is-gapless">
                                            <div class="column is-12">Select Local Agent<hr/></div>
                                            
                                            <?php echo $agents; ?>
                                        </div>
                                    </div>
                                </div>
    
                                <!-- Shipping Popover -->
                                <div class="webui-popover-content">
                                    <div class="popover-flex-block">
                                        <div class="icon-block">
                                            <img src="<?php echo base_url(); ?>assets/images/icon.png" alt="">
                                        </div>
                                        <div class="content-block">Before jumping to the next step, you need to specify a shipping agent</div>
                                    </div>
                                </div>
    
                                <!-- Shipping Address form -->
                                <div class="column is-7 is-padded">
                                    <form class="shipping-address-form">
                                        <div class="columns is-multiline">
                                            <input id="agent_id" type="hidden" />
                                            <input id="agent_amount" type="hidden" />

                                            <!-- Form control -->
                                            <div class="column is-6">
                                                <div class="control">
                                                    <label class="checkout-label">Number*</label>
                                                    <input id="number" type="text" class="input" value="<?php if(!empty($s_address->number)) { echo $s_address->number; } ?>">
                                                </div>
                                            </div>
                                            <!-- Form control -->
                                            <div class="column is-6">
                                                <div class="control">
                                                    <label class="checkout-label">Street*</label>
                                                    <input id="street" type="text" class="input" value="<?php if(!empty($s_address->street)) { echo $s_address->street; } ?>">
                                                </div>
                                            </div>
                                            <!-- Form control -->
                                            <div class="column is-6">
                                                <div class="control">
                                                    <label class="checkout-label">Postal Code</label>
                                                    <input id="postal" type="text" class="input" value="<?php if(!empty($s_address->postal)) { echo $s_address->postal; } ?>">
                                                </div>
                                            </div>
                                            <!-- Form control -->
                                            <div class="column is-6">
                                                <div class="control">
                                                    <label class="checkout-label">City*</label>
                                                    <input id="city" type="text" class="input" value="<?php if(!empty($s_address->city)) { echo $s_address->city; } ?>">
                                                </div>
                                            </div>
                                            <!-- Chosen Select -->
                                            <div class="column is-6">
                                                <label class="checkout-label">Country*</label>
                                                <div class="control">
                                                    <?php if(!empty($load_list_country)){echo $load_list_country;} ?>
                                                </div>
                                            </div>
                                            <!-- Form control -->
                                            <div class="column is-6">
                                                <div class="control">
                                                    <label class="checkout-label">State/Region*</label>
                                                    <div id="load_state"><?php if(!empty($load_list_state)){echo $load_list_state;} ?></div>
                                                </div>
                                            </div>
                                        </div>    
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="button-wrapper has-text-right">
                            <a href="<?php echo base_url('checkout/step/1'); ?>" class="button feather-button is-small primary-button upper-button raised">
                                <span><i class="fa fa-arrow-left"></i> Previous</span>
                            </a>
                            <a href="javascript:;" class="button feather-button is-small primary-button upper-button raised is-next" onclick="submit_shipping();">
                                <span>Next <i class="fa fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if($step == 3){ ?>
        <div class="section">
            <div class="container">
                <div class="columns account-header">
                    <div class="column is-10 is-offset-1 checkout-wrapper is-tablet-landscape-padded">
                        <div id="checkout_msg" class="is-centered"></div>

                        <div class="checkout-title">
                            <h2>VERIFICATION</h2>
                            <h3><?php if(!empty($order_no)){ echo 'ORDER-'.$order_no; } ?></h3>
                        </div>
                        
                        <div class="flat-card is-auto is-checkout-form">
                            <div class="columns is-gapless is-vcentered">
                                <!-- Order Total -->
                                <div class="column is-4 has-text-centered grey-column is-padded">
                                    <div class="verification-wrapper">
                                        <div class="total-price">
                                            <i data-feather="credit-card"></i>
                                            <span>Order Total</span>
                                            <span><small>&#8358;</small><?php echo number_format($cart_total,2); ?></span>
                                            <span><?php echo $pdt_count; ?> Products ordered + Shipping</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- List of items -->
                                <div class="column is-8 is-padded items-column">
                                    <?php echo $cart_items; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="button-wrapper has-text-right">
                            <a href="<?php echo base_url('checkout/step/2'); ?>" class="button feather-button is-small primary-button upper-button raised">
                                <span><i class="fa fa-arrow-left"></i> Previous</span>
                            </a>
                            <a href="javascript:;" class="button feather-button is-small primary-button upper-button raised is-next" onclick="submit_order();">
                                <span>Next <i class="fa fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if($step == 4){ ?>
        <div class="section">
            <div class="container">
                <div class="columns account-header">
                    <div class="column is-10 is-offset-1 checkout-wrapper is-tablet-landscape-padded">
                        <div id="checkout_msg" class="is-centered"></div>

                        <div id="payment-header" class="checkout-title is-centered animated preFadeInUp fadeInUp">
                            <h2>PAYMENT METHOD</h2>
                            <img class="brand-filigrane is-centered" src="<?php echo base_url(); ?>assets/images/icon_inverse.png" alt="">
                        </div>
                        
                        <div id="payment-methods" class="columns is-multiline">
                            <div class="column is-3"> </div>
                            <!-- Wallet -->
                            <div class="column is-3">
                                <div class="flat-card payment-method is-cash is-auto animated preFadeInUp fadeInUp" data-method="cash">
                                    <div class="payment-icon">
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                            <g>
                                                <g>
                                                    <path d="M495.432,76.96H16.568C7.432,76.96,0,84.392,0,93.528v324.944c0,9.136,7.432,16.568,16.568,16.568h478.864
                                                                c9.136,0,16.568-7.432,16.568-16.568V93.528C512,84.392,504.568,76.96,495.432,76.96z M495.967,350.597h-26.189
                                                                c-4.427,0-8.017,3.589-8.017,8.017s3.589,8.017,8.017,8.017h26.189v18.171H367.166c-4.427,0-8.017,3.589-8.017,8.017
                                                                c0,4.427,3.589,8.017,8.017,8.017h128.801v17.637c0,0.295-0.239,0.534-0.534,0.534H16.568c-0.295,0-0.534-0.239-0.534-0.534
                                                                v-17.637H332.96c4.427,0,8.017-3.589,8.017-8.017c0-4.427-3.589-8.017-8.017-8.017H16.033V366.63h419.543
                                                                c4.427,0,8.017-3.589,8.017-8.017s-3.589-8.017-8.017-8.017H16.033v-18.198c0.179,0.005,0.354,0.027,0.534,0.027h478.864
                                                                c0.181,0,0.356-0.021,0.534-0.027V350.597z M495.967,315.858c0,0.295-0.239,0.534-0.534,0.534H16.568
                                                                c-0.295,0-0.534-0.239-0.534-0.534V93.528c0-0.295,0.239-0.534,0.534-0.534h478.864c0.295,0,0.534,0.239,0.534,0.534V315.858z"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path d="M469.779,145.369c-14.44,0-26.188-11.748-26.188-26.188c0-4.427-3.589-8.017-8.017-8.017h-94.066
                                                                c-4.427,0-8.017,3.589-8.017,8.017s3.588,8.017,8.017,8.017h86.813c3.254,16.866,16.575,30.187,33.441,33.441v88.107
                                                                c-16.866,3.254-30.188,16.575-33.441,33.441h-86.813c-4.427,0-8.017,3.589-8.017,8.017s3.589,8.017,8.017,8.017h94.066
                                                                c4.427,0,8.017-3.589,8.017-8.017c0-14.44,11.748-26.188,26.188-26.188c4.427,0,8.017-3.589,8.017-8.017V153.386
                                                                C477.795,148.959,474.206,145.369,469.779,145.369z"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path d="M170.487,282.188H83.679c-3.254-16.864-16.577-30.186-33.441-33.441V160.64c16.864-3.256,30.188-16.576,33.441-33.441
                                                                h86.808c4.427,0,8.017-3.589,8.017-8.017s-3.589-8.017-8.017-8.017H76.426c-4.427,0-8.017,3.589-8.017,8.017
                                                                c0,14.44-11.748,26.188-26.188,26.188c-4.427,0-8.017,3.589-8.017,8.017V256c0,4.427,3.589,8.017,8.017,8.017
                                                                c14.44,0,26.188,11.748,26.188,26.188c0,4.427,3.589,8.017,8.017,8.017h94.062c4.427,0,8.017-3.589,8.017-8.017
                                                                S174.915,282.188,170.487,282.188z"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path d="M256,111.165c-51.572,0-93.528,41.957-93.528,93.528s41.956,93.528,93.528,93.528s93.528-41.956,93.528-93.528
                                                                S307.572,111.165,256,111.165z M256,282.188c-42.731,0-77.495-34.764-77.495-77.495s34.764-77.495,77.495-77.495
                                                                s77.495,34.764,77.495,77.495S298.731,282.188,256,282.188z"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path d="M264.017,198.533v-27.974c11.431,1.758,18.171,6.984,18.171,10.084c0,4.427,3.589,8.017,8.017,8.017
                                                                s8.017-3.589,8.017-8.017c0-13.489-14.236-24.034-34.205-26.274v-0.982c0-4.427-3.589-8.017-8.017-8.017s-8.017,3.589-8.017,8.017
                                                                v0.982c-19.969,2.24-34.205,12.786-34.205,26.274c0,18.806,18.787,25.929,34.205,30.21v27.974
                                                                c-11.431-1.758-18.171-6.984-18.171-10.084c0-4.427-3.589-8.017-8.017-8.017s-8.017,3.589-8.017,8.017
                                                                c0,13.489,14.236,24.034,34.205,26.274V256c0,4.427,3.589,8.017,8.017,8.017s8.017-3.589,8.017-8.017v-0.982
                                                                c19.969-2.24,34.205-12.786,34.205-26.274C298.221,209.937,279.434,202.814,264.017,198.533z M247.983,194.089
                                                                c-13.372-4.204-18.171-7.957-18.171-13.446c0-3.1,6.74-8.326,18.171-10.084V194.089z M264.017,238.827v-23.53
                                                                c13.372,4.204,18.171,7.957,18.171,13.446C282.188,231.843,275.447,237.069,264.017,238.827z"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="payment-text">
                                        Wallet
                                    </div>
                                </div>
                            </div>
                            <!-- Debit Card -->
                            <div class="column is-3">
                                <div class="flat-card payment-method is-credit-card is-auto animated preFadeInUp fadeInUp" data-method="credit-card">
                                    <div class="payment-icon">
                                        <svg version="1.1" id="Capa_3" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 511.996 511.996" style="enable-background:new 0 0 511.996 511.996;" xml:space="preserve">
                                            <g>
                                                <g>
                                                    <path d="M439.433,154.196H43.082C19.326,154.196,0,173.522,0,197.278v224.025c0,23.755,19.326,43.082,43.082,43.082h396.351
                                                                c23.755,0,43.082-19.326,43.082-43.082V197.278C482.515,173.522,463.188,154.196,439.433,154.196z M465.282,421.311
                                                                c0,14.251-11.598,25.849-25.849,25.849H43.082c-14.251,0-25.849-11.598-25.849-25.849V197.286
                                                                c0-14.251,11.598-25.849,25.849-25.849h396.351c14.251,0,25.849,11.598,25.849,25.849V421.311z"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path d="M137.861,197.278H51.698c-4.756,0-8.616,3.86-8.616,8.616v68.931c0,4.765,3.86,8.616,8.616,8.616h86.163
                                                                c4.756,0,8.616-3.852,8.616-8.616v-68.931C146.478,201.138,142.618,197.278,137.861,197.278z M129.245,266.208H60.314V214.51
                                                                h68.931V266.208z"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <rect x="51.698" y="231.752" width="25.849" height="17.233"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <rect x="112.012" y="231.752" width="25.849" height="17.233"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path d="M387.735,317.906c-28.511,0-51.698,23.187-51.698,51.698s23.187,51.698,51.698,51.698
                                                                c28.511,0,51.698-23.187,51.698-51.698S416.247,317.906,387.735,317.906z M387.735,404.07c-19.008,0-34.465-15.458-34.465-34.465
                                                                c0-19.008,15.458-34.465,34.465-34.465s34.465,15.458,34.465,34.465C422.201,388.612,406.743,404.07,387.735,404.07z"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path d="M336.037,317.906c-28.511,0-51.698,23.187-51.698,51.698s23.187,51.698,51.698,51.698
                                                                c28.511,0,51.698-23.187,51.698-51.698S364.549,317.906,336.037,317.906z M336.037,404.07c-19.008,0-34.465-15.458-34.465-34.465
                                                                c0-19.008,15.458-34.465,34.465-34.465c19.008,0,34.465,15.458,34.465,34.465C370.503,388.612,355.045,404.07,336.037,404.07z"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <rect x="43.082" y="335.139" width="51.698" height="17.233"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <rect x="129.245" y="335.139" width="51.698" height="17.233"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <rect x="215.408" y="335.139" width="51.698" height="17.233"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <rect x="43.082" y="386.837" width="224.025" height="17.233"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path d="M475.691,110.977L84.328,48.163C60.883,44.381,38.748,60.459,35,83.904l-13.872,86.163l17.017,2.74l13.872-86.172
                                                                c2.249-14.079,15.552-23.712,29.589-21.463l391.363,62.822c14.062,2.232,23.686,15.484,21.481,29.537
                                                                c-0.009,0.052-0.017,0.112-0.026,0.164L465.377,342.42l17.035,2.68l29.02-184.657c0.009-0.052,0.017-0.103,0.026-0.155
                                                                C515.188,136.826,499.144,114.707,475.691,110.977z"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <rect x="310.188" y="205.903" width="17.233" height="34.465"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <rect x="344.654" y="205.903" width="17.233" height="34.465"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <rect x="379.119" y="205.903" width="17.233" height="34.465"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <rect x="413.584" y="205.903" width="17.233" height="34.465"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
    
                                                    <rect x="478.209" y="173.36" transform="matrix(0.1677 -0.9858 0.9858 0.1677 221.3524 635.1268)" width="17.232" height="26.219"/>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <rect x="185.261" y="-16.007" transform="matrix(0.169 -0.9856 0.9856 0.169 26.104 304.9166)" width="17.232" height="305.97"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="payment-text">
                                        Credit Card
                                    </div>
                                </div>
                            </div>
                            <div class="column is-3"> </div>

                            <!-- Back to previous step -->
                            <div class="column is-8 is-offset-2 has-text-centered">
                                <a href="<?php echo base_url('checkout/step/3'); ?>" class="button feather-button is-small primary-button upper-button raised">
                                    <span><i class="fa fa-arrow-left"></i> Previous</span>
                                </a>
                            </div>
                        </div>
    
                        <!-- Wallet section -->
                        <div id="cash" class="is-hidden animated preFadeInUp fadeInUp">
                            <!-- Title -->
                            <div class="checkout-title">
                                <h2>WALLET</h2>
                                <h3><?php if(!empty($order_no)){ echo 'ORDER-'.$order_no; } ?></h3>
                            </div>
                            <!-- Order -->
                            <div class="flat-card is-auto is-checkout-form">
                                <div class="columns is-gapless is-vcentered">
                                    <!-- Order Total -->
                                    <div class="column is-6 has-text-centered grey-column is-padded">
                                        <div class="payment-wrapper">
                                            <div class="subtotal">
                                                <span class="partial-value"><?php echo number_format($order_item,2); ?></span>
                                                <span class="plus-operator">+</span>
                                                <span class="vat-value"><?php echo number_format($order_ship,2); ?> (Shipping)</span>
                                                <span class="equal-operator">=</span>
                                            </div>
                                            <div class="total">
                                                <span>&#8358;<?php echo number_format($order_amount,2); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Confirm Cash Payment -->
                                    <div class="column is-6 is-padded">
                                        <div class="has-text-centered">
                                            <div>
                                                <small>WALLET BALANCE</small>
                                                <h2 class="has-text-success"><b>&#8358;<?php echo number_format($wallet,2); ?></b></h2>
                                                <br />
                                            </div>
                                            <img class="logo is-centered" src="<?php echo base_url(); ?>assets/images/icons/money.svg" alt="">
                                            <span class="bank-account">
                                                Come by at one of our nearest stores and pay your order in cash if you wish to. The order will remain pending until we receive the payment.
                                            </span>
                                            <a href="javascript:;" class="button feather-button is-large secondary-button upper-button raised is-next" onclick="wallet_pay();">
                                                <span><b><i class="fa fa-money"></i> Confirm Payment</b></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Back to Payment Methods -->
                            <div class="button-wrapper has-text-right">
                                <a href="javascript:void(0);" class="button feather-button is-small primary-button upper-button raised back-to-methods">
                                    <span><i class="fa fa-arrow-left"></i> Go back</span>
                                </a>
                            </div>
                        </div>

                        <!-- Debit Card section -->
                        <div id="credit-card" class="is-hidden animated preFadeInUp fadeInUp">
                            <!-- Title -->
                            <div class="checkout-title">
                                <h2>DEBIT CARD</h2>
                                <h3><?php if(!empty($order_no)){ echo 'ORDER-'.$order_no; } ?></h3>
                            </div>
                            <!-- Order -->
                            <div class="flat-card is-auto is-checkout-form">
                                <div class="columns is-gapless is-vcentered">
                                    <!-- Order Total -->
                                    <div class="column is-6 has-text-centered grey-column is-padded">
                                        <div class="payment-wrapper">
                                            <div class="subtotal">
                                                <span class="partial-value"><?php echo number_format($order_item,2); ?></span>
                                                <span class="plus-operator">+</span>
                                                <span class="vat-value"><?php echo number_format($order_ship,2); ?> (Shipping)</span>
                                                <span class="equal-operator">=</span>
                                            </div>
                                            <div class="total">
                                                <span>&#8358;<?php echo number_format($order_amount,2); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- JS credit card -->
                                    <div class="column is-6 is-light-padded is-centered">
                                        <div class="has-text-centered">
                                            <?php if(!empty($pay_msg)) { echo $pay_msg; } ?>

                                            <img alt="" src="<?php echo base_url(); ?>assets/images/pay.png" /><br/><br/>
                                            <a href="javascript:;" class="button feather-button is-large primary-button upper-button raised is-next" onClick="payWithRave();">
                                                <b><i class="fa fa-credit-card"></i> Pay with Card</b>
                                            </a>
                                            <?php echo $payScript; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Back to payment methods -->
                            <div class="button-wrapper has-text-right">
                                <a href="javascript:void(0);" class="button feather-button is-small primary-button upper-button raised back-to-methods">
                                    <span><i class="fa fa-arrow-left"></i> Go back</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if($step == 5){ ?>
        <div class="section">
            <div class="container">
                <div class="columns account-header">
                    <div class="column is-10 is-offset-1 checkout-wrapper has-text-centered is-tablet-landscape-padded">
                        <div class="checkout-title is-centered">
                            <h2>CHECKOUT COMPLETE</h2>
                            <img class="brand-filigrane is-centered" src="<?php echo base_url(); ?>assets/images/icon_inverse.png" alt="">
                        </div>
                        
                        <div class="flat-card is-auto thanks-card">
                            <img src="<?php echo base_url(); ?>assets/images/icons/order.svg" alt="">
                            <div class="card-heading">Order Placed !</div>
                            <p>You are done ordering your products. We are very happy to count you amongst our customers. Use our tracking tools to manage your order</p>
                            <div class="button-wrap">
                                <a href="<?php echo base_url('orders'); ?>" class="button feather-button primary-button is-bold raised rounded">Order</a> 
                                <a href="<?php echo base_url('orders/track'); ?>" class="button feather-button secondary-button is-bold raised rounded">Track Order</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
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