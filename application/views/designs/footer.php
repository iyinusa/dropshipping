        <div class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-top">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title"></h2><hr/>
                    </div>
                    <div class="modal-body"> </div>
                </div>
            </div>
        </div>
        
        <script>var base_url = '<?php echo base_url(); ?>';</script>
        <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/nephos.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/custom/find-product.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/custom/cart.js"></script>   
        <script src="<?php echo base_url(); ?>assets/js/custom/checkout.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/popup/popup.js"></script>
        
        <?php if($page_active == 'shop'){ ?>
            <script src="<?php echo base_url(); ?>assets/js/custom/products.js"></script>
        <?php } ?>

        <?php if($page_active == 'wallet'){ ?>
            <script src="<?php echo base_url(); ?>assets/js/custom/wallet.js"></script>
        <?php } ?>

        <?php if($page_active == 'transactions'){ ?>
            <script src="<?php echo base_url(); ?>assets/js/custom/transactions.js"></script>
        <?php } ?>

        <?php if($page_active == 'admin/customers'){ ?>
            <script src="<?php echo base_url(); ?>assets/js/custom/customers.js"></script>
        <?php } ?>

        <?php if($page_active == 'admin/agents'){ ?>
            <script src="<?php echo base_url(); ?>assets/js/custom/agents.js"></script>
        <?php } ?>

        <?php if($page_active == 'admin/shipping'){ ?>
            <script src="<?php echo base_url(); ?>assets/js/custom/shipping.js"></script>
        <?php } ?>

        <?php if($page_active == 'agent/shipping'){ ?>
            <script src="<?php echo base_url(); ?>assets/js/custom/ship_price.js"></script>
        <?php } ?>

        <?php if($page_active == 'calculator'){ ?>
            <script src="<?php echo base_url(); ?>assets/js/custom/calculator.js"></script>
        <?php } ?>
    </body>  
</html>