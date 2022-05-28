<div class="section">
    <div class="container">
        <div class="columns account-header">
            <div class="column is-10 is-offset-1 is-tablet-landscape-padded">
                <div class="account-title">
                    <h2>Transactions</h2>
                    <img class="brand-filigrane" src="<?php echo base_url(); ?>assets/images/icon_inverse.png" alt="">
                </div>

                <?php include(APPPATH.'views/user/menu.php'); ?>

                <div class="listing-controls">
                    <div class="layout-controls">
                        <input type="text" id="search_query" class="input" oninput="ini_load();" placeholder="Search Transaction" style="border:1px solid #ccc; background:transparent;" />
                    </div>
                    
                    <div class="sort-box">
                        
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