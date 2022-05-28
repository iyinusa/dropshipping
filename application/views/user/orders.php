<div class="section">
    <div class="container">
        <div class="columns account-header">
            <div class="column is-10 is-offset-1 is-tablet-landscape-padded">
                <div class="account-title">
                    <h2>My Orders</h2>
                    <img class="brand-filigrane" src="<?php echo base_url(); ?>assets/images/icon_inverse.png" alt="">
                </div>

                <?php include(APPPATH.'views/user/menu.php'); ?>

                <div class="listing-controls">
                    <div class="layout-controls">
                        <input type="text" id="search_query" class="input" oninput="ini_load();" placeholder="Order Number" style="border:1px solid #ccc; background:transparent;" />
                    </div>
                    
                    <div class="sort-box">
                        <div class="sort-box-select">
                            <select id="order_status" data-placeholder="Default order" class="chosen-select-no-single" onchange="ini_load();">
                                <option value="">All Orders</option>	
                                <option value="pending">Pending</option>
                                <option value="progress">In Progress</option>
                                <option value="complete">Complete</option>
                            </select>
                        </div>
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

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script>var base_url = '<?php echo base_url(); ?>';</script>
<script src="<?php echo base_url(); ?>assets/js/custom/orders.js"></script>