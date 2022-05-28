<div class="section" style="min-height:100vh;">
    <div class="container">
        <div class="columns category-header">
            <div class="column is-10 is-offset-1 is-tablet-landscape-padded">
                <div class="category-title is-product-category">
                    <h2>Products Search Result</h2>
                    <div class="listing-controls category-icon is-hidden-mobile">
                        <img src="<?php echo base_url(); ?>assets/images/icon_inverse.png" alt="">
                    </div>
                </div>
                
                <?php if(empty($search_items)){ ?>
                    <div class="columns">
                        <div class="column is-12 has-text-centered has-text-grey-light">
                            <img src="<?php echo base_url(); ?>assets/images/icon_inverse.png" alt=""><br/>
                            No Item(s) Returned
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="columns is-product-list is-multiline">
                        <div class="column is-12">
                            <ul>
                                <?php echo $search_items; ?>
                            </ul>

                        </div>

                    </div>

                    <!-- <div class="show-more"><a href="#">Show more products</a></div> -->
                <?php } ?>

            </div>
        </div> 
    </div>
</div>