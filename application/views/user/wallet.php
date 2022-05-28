<div class="section">
    <div class="container">
        <div class="columns account-header">
            <div class="column is-10 is-offset-1 is-tablet-landscape-padded">
                <div class="account-title">
                    <h2>My Orders</h2>
                    <img class="brand-filigrane" src="<?php echo base_url(); ?>assets/images/icon_inverse.png" alt="">
                </div>

                <?php include(APPPATH.'views/user/menu.php'); ?>

                <div class="columns is-multiline">
                    <div class="column is-4">
                        <small class="has-text-grey" style="font-size:x-small;">SPENT</small>
                        <div class="has-text-danger"><small>&#8358;</small><b><?php echo number_format($spent,2); ?></b></div>
                    </div>
                    <div class="column is-4">
                        <small class="has-text-grey" style="font-size:x-small;">BALANCE</small>
                        <div class="has-text-success"><small>&#8358;</small><b><?php echo number_format($balance,2); ?></b></div>
                    </div>
                    <div class="column is-4 has-text-right">
                        <a class="button is-success is-outlined" onclick="toggle_wallet();"><i class="fa fa-money"></i>&nbsp;&nbsp;Fund Wallet</a>
                    </div>
                </div>

                <div id="toggle_wallet" class="columns is-multiline" style="display:none;">
                    <div class="column is-12 flat-card is-auto">
                        <div class="columns is-multiline">
                            <div class="column is-2"></div>
                            <div class="column is-4">
                                <small class="has-text-grey">AMOUNT (&#8358;)</small>
                                <div class="field">
                                    <p class="control has-icons-left">
                                        <input id="pay_amount" class="input is-large has-text-centered" type="number" placeholder="10000" oninput="get_pay();">
                                        <span class="icon is-small is-left">
                                            <i class="fa fa-money"></i>
                                        </span>
                                    </p>
                                </div>
                                <div class="has-text-success"><img alt="" src="<?php echo base_url(); ?>assets/images/pay.png" /></div>
                            </div>
                            <div class="column is-4">
                                <div id="amount" class="has-text-success"></div>
                                
                                <div id="pay_btn" class="has-text-centered"></div>
                            </div>
                            <div class="column is-2"></div>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="listing-controls">
                    <div class="layout-controls">
                        <input type="text" id="search_query" class="input" oninput="ini_load();" placeholder="Search Wallet" style="border:1px solid #ccc; background:transparent;" />
                    </div>
                    
                    <div class="sort-box">
                        <div class="sort-box-select">
                            <select id="order_status" data-placeholder="Default order" class="chosen-select-no-single" onchange="ini_load();">
                                <option value="">All</option>	
                                <option value="Credit">Credit</option>
                                <option value="Debit">Debit</option>
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