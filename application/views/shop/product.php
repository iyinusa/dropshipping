<?php
    $log_id = $this->session->userdata('afrs_id');
    $log_firstname = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
    $log_role = $this->Crud->read_field('id', $log_id, 'user', 'role');
    $log_img_id = $this->Crud->read_field('id', $log_id, 'user', 'img_id');
    $log_img = $this->Crud->image($log_img_id, 'big');
?>
<div class="shop-wrapper">
    <div class="product-panel">
        <div class="panel-header">
            <div class="likes">
                <i data-feather="heart"></i>
                <span><?php if($pdt_num > 0){echo number_format($pdt_num).' Available';} else {echo 'Out of Stock';} ?></span>
            </div>
        </div>

        <!-- Product images -->
        <div id="product-view" class="product-image translateLeft">
            <div class="is-carousel">
                <?php if(!empty($pdt_imgs)) {echo $pdt_imgs;} ?>
            </div>
        </div>

        <!-- Product details -->
        <div id="meta-view" class="translateLeft is-hidden">
            <!-- Description -->
            <div class="detailed-description">
                <div class="meta-block">
                    <h3>Product name</h3>
                    <p><?php if(!empty($pdt_title)) {echo $pdt_title;} ?></p>
                </div>
                
                <!-- <div class="meta-block">
                    <h3>Product SKU</h3>
                    <p>W589</p>
                </div> -->

                <!-- Variation -->
                <!-- <div class="meta-block">
                    <h3>Colors</h3>
                    <div class="colored-dots">
                        <div class="dot-wrapper">
                            <div class="dot is-blue"></div>
                        </div>
                        <div class="dot-wrapper">
                            <div class="dot is-white"></div>
                        </div>
                        <div class="dot-wrapper">
                            <div class="dot is-dark"></div>
                        </div>
                        <div class="dot-wrapper">
                            <div class="dot is-cream"></div>
                        </div>
                    </div>
                </div> -->
                
                <!-- Description -->
                <div class="meta-block">
                    <h3 class="spaced">Description</h3>
                    <p class="spaced">
                        <?php if(!empty($pdt_desc)) {echo $pdt_desc;} ?>
                    </p>
                </div>

                <!-- Availability -->
                <div class="meta-block">
                    <h3>Availability</h3>
                    <p><?php if($pdt_num > 0){echo 'Available';} else { echo 'Out of Stock'; } ?></p>
                </div>

                <!-- Shipping methods -->
                <!-- <div class="meta-block">
                    <h3>Shipping Methods</h3>
                    <p>Delivery, UPS, Express</p>
                </div> -->
            </div>
        </div>

        <!-- Product Ratings -->
        <div id="ratings-view" class="translateLeft is-hidden">
            <div class="product-ratings">
                <div class="main-rating">

                    <!-- Average Rating -->
                    <h3>Product Review/Rating</h3>
                    <div class="stars">
                        <?php echo $rating; ?>
                    </div>
                    <span>Rated <small><?php echo $rate_value; ?>/5.0</small> out of <small><?php echo $rate_total; ?></small> reviews</span>
                    <div><hr/><?php echo $ratings; ?></div>
                    <!-- <span class="add-review modal-trigger" data-modal="review-modal"><i data-feather="plus"></i> Add review</span> -->
                </div>

                <!-- Customer reviews -->
                <div class="customer-ratings">
                    <!-- <div class="media">
                        <div class="media-left">
                            <figure class="image is-32x32">
                                <img src="<?php echo base_url($log_img); ?>" alt="">
                            </figure>
                        </div>
                        <div class="media-content">
                            <p>
                                <span><?php echo $log_firstname; ?></span>
                                <small>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half"></i>
                                </small>
                                <br>
                                <span class="rating-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet massa fringilla egestas. Nullam condimentum luctus turpis.</span>
                            </p>
                        </div>
                    </div> -->

                </div>
            </div>
        </div>
        <!-- /Product Ratings -->

        <!-- Product panel actions -->
        <div class="product-actions">
            <!-- Zoom Action -->
            <div class="zoom-buttons">
                <!-- <i data-feather="plus-circle"></i>
                <i data-feather="minus-circle"></i> -->
            </div>
            <!-- Navigation icons -->
            <div class="right-actions">
                <!-- Product image panel -->
                <span id="show-product" class="product-action is-active"><i data-feather="image"></i></span>
                <!-- Product meta panel -->
                <span id="show-meta" class="product-action"><i data-feather="menu"></i></span>
                <!-- Product ratings panel -->
                <span id="show-ratings" class="product-action"><i data-feather="message-circle"></i></span>
            </div>
        </div>
    </div>

    <!-- Right product panel -->
    <div class="product-info-panel">
        <div class="inner-panel">
            <!-- Panel body -->
            <div class="panel-body" style="max-height:65vh; overflow:scroll;">
                <!-- Product Meta -->
                <h5 class="product-name">
                    <?php if(!empty($pdt_title)) {echo $pdt_title;} ?><br/>
                    <div class="is-small">
                        <small class="has-text-danger"><?php if(!empty($pdt_nick)) {echo $pdt_nick;} ?></small> 
                        <small class="has-text-gray-lighter">| <?php if($pdt_num > 0){echo number_format($pdt_num).' pieces available';} else {echo 'Out of Stock';} ?> </small> 
                        <span class="has-text-danger"><?php if(!empty($pdt_type)) {echo $pdt_type;} ?></span>
                    </div>
                </h5>
                <p class="product-description">
                    <?php if(!empty($pdt_desc_short)) {echo $pdt_desc_short;} ?>
                </p>

                <!-- Product controls -->
                <div class="product-controls">
                    <!-- Price -->
                    <div class="product-price">
                        <div class="heading">Price</div>
                        <input type="hidden" id="pdt_id" value="<?php if(!empty($id)) {echo $id;} ?>" />
                        <input type="hidden" id="pdt_name" value="<?php if(!empty($pdt_title)) {echo $pdt_title;} ?>" />
                        <input type="hidden" id="pdt_amount" value="<?php if(!empty($pdt_price)) {echo $pdt_price;} ?>" />
                        <input type="hidden" id="pdt_img" value="<?php if(!empty($pdt_img)) {echo $pdt_img;} ?>" />
                        <span class="value">&#8358;<?php if(!empty($pdt_price)) {echo number_format($pdt_price,2);} ?></span>
                        <span class="value2">&#8358;<?php if(!empty($pdt_original_price)) {echo number_format($pdt_original_price,2);} ?></span>
                    </div>
                    <!-- Quantity -->
                    <div class="product-quantity">
                        <div class="heading has-text-centered">Quantity</div>
                        <div class="control">
                            <input id="cart-qty" class="input is-rounded" type="number" value="<?php if(empty($pdt_num)){echo 0;} else {echo 1;}; ?>" min="<?php if(empty($pdt_num)){echo 0;} else {echo 1;}; ?>" max="<?php if(!empty($pdt_num)) {echo $pdt_num;} ?>" <?php if(empty($pdt_num)){echo 'disabled';} ?>>
                        </div>
                    </div>

                    <!-- Add to Cart -->
                    <?php if(!empty($pdt_num)){ ?>
                        <div class="add-to-cart">
                            <div class="heading is-vhidden">Add to cart</div>
                            <button class="button big-button cart-button primary-button upper-button rounded is-bold raised" onclick="add_cart();">Add to cart</button>
                        </div>
                    <?php } ?>
                </div>

                <div class="specification">
                    <br /><div class="heading">Specifications</div><hr />
                    <div class="columns is-mobile is-multiline">
                        <?php if(!empty($pdt_specs)) {echo $pdt_specs;} ?>
                    </div>
                </div>
            </div>

            <!-- Panel footer -->
            <div class="panel-footer">
                <div class="footer-inner">
                    <div class="recommended">Recommended</div>
                    <div class="columns has-text-centered">
                        
                        <div class="column"></div>
                        
                        <?php if(!empty($pdt_recommended)){ echo $pdt_recommended; } ?>

                        <!-- <div class="column is-3">
                            <div class="featured-product">
                                <div class="image">
                                    <img src="<?php echo base_url(); ?>assets/images/products/dark-seat.jpg" alt="">
                                </div>
                                <div class="product-info has-text-centered">
                                    <a href="#"><h3 class="product-name">Dark seat</h3></a>
                                    <p class="product-description">Lorem ipsum sit dolor amet</p>
                                </div>
                            </div>
                        </div>
                        <div class="column is-3">
                            <div class="featured-product">
                                <div class="image">
                                    <img src="<?php echo base_url(); ?>assets/images/products/blue-seat.png" alt="">
                                </div>
                                <div class="product-info has-text-centered">
                                    <a href="#"><h3 class="product-name">Blue seat</h3></a>
                                    <p class="product-description">Lorem ipsum sit dolor amet</p>
                                </div>
                            </div>
                        </div>
                        <div class="column is-3">
                            <div class="featured-product">
                                <div class="image">
                                    <img src="<?php echo base_url(); ?>assets/images/products/cosy-red-seat.png" alt="">
                                </div>
                                <div class="product-info has-text-centered">
                                    <a href="#"><h3 class="product-name">Red seat</h3></a>
                                    <p class="product-description">Lorem ipsum sit dolor amet</p>
                                </div>
                            </div>
                        </div> -->
                        
                        <div class="column"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div id="review-modal" class="modal review-modal">
    <div class="modal-background"></div>
    <div class="modal-content">
        <div class="box">
            <div class="box-header">
                <img src="<?php echo base_url($log_img); ?>" alt="">
                <span>Rate this product</span>
                <div class="modal-delete"><i data-feather="x"></i></div>
            </div>
            <div class="box-body">

                <fieldset class="rating">
                    <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                    <input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Great - 4.5 stars"></label>
                    <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Very good - 4 stars"></label>
                    <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Pretty good - 3.5 stars"></label>
                    <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Good - 3 stars"></label>
                    <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Average - 2.5 stars"></label>
                    <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Mediocre - 2 stars"></label>
                    <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Weak - 1.5 stars"></label>
                    <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Bad - 1 star"></label>
                    <input type="radio" id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Terrible - 0.5 stars"></label>
                </fieldset>

                <div class="control">
                    <textarea class="textarea is-button" placeholder="write something..."></textarea>
                    <div class="textarea-button">
                        <button class="button primary-button raised">Post review</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--button class="modal-close is-large" aria-label="close"></button-->
</div>