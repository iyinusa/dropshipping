<div class="section">
    <div class="container">
        <div class="columns account-header">
            <div class="column is-10 is-offset-1 is-tablet-landscape-padded">
                <div class="account-title">
                    <h2>Shipping Pricing</h2>
                    <img class="brand-filigrane" src="<?php echo base_url(); ?>assets/images/icon_inverse.png" alt="">
                </div>

                <?php include(APPPATH.'views/user/menu.php'); ?>

                <div class="listing-controls">
                    <div class="layout-controls">
                        <input type="text" id="search_query" class="input" oninput="ini_load();" placeholder="Search Shipping Price" style="border:1px solid #ccc; background:transparent;" />
                    </div>
                    
                    <div class="sort-box">
                        <a href="javascript:;" class="button is-danger is-outlined pop" pageName="<?php echo base_url('admin/shipping_form'); ?>" pageTitle="Add Shipping Price"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>

                <div id="load_data"></div>

                <div class="columns">
                    <div id="loadmore" class="column has-text-centered"></div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<!-- Popup -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>