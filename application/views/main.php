<div class="shop-wrapper has-background-image" data-background="<?php echo base_url(); ?>assets/images/bg/3.jpg" style="background-attachment:fixed;">
    
    <div class="background-caption">
        <h1><?php echo app_name; ?></h1>
    </div>

    
    <div class="hero-caption">
        <h1><?php echo app_name; ?></h1>
        <h2><?php echo app_meta_desc; ?></h2>
        
        <a href="<?php echo base_url('shop'); ?>" class="button big-button primary-button upper-button rounded raised">Start Shopping</a> 

        <a href="<?php echo base_url('calculator'); ?>" class="button big-button upper-button rounded raised">Shopping Calculator</a>
    </div>

    <div class="columns" style="padding-top:400px;">
        <div class="column is-10 is-offset-1 is-tablet-landscape-padded">
            <div class="columns is-product-grid is-multiline">
                <?php echo $recents; ?>

                <div class="column is-12">
                    <a href="<?php echo base_url('shop'); ?>" class="button big-button upper-button raised is-fullwidth">All Products</a>
                    <br/><br/>
                </div>
            </div>
        </div>
    </div>

</div>