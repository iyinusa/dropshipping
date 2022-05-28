<?php
    $user_id = $this->session->userdata('afrs_id');
    $user_role = strtolower($this->Crud->read_field('id', $user_id, 'user', 'role'));
?>

<div class="tabs account-tabs">
    <ul>
        <li class="<?php if($page_active == 'profile'){ echo 'is-active'; } ?>">
            <a href="<?php echo base_url('profile'); ?>">Account</a>
        </li>
        <li class="<?php if($page_active == 'wallet'){ echo 'is-active'; } ?>">
            <a href="<?php echo base_url('wallet'); ?>">Wallet</a>
        </li>
        <li class="<?php if($page_active == 'cart'){ echo 'is-active'; } ?>">
            <a href="<?php echo base_url('cart'); ?>">Cart</a>
        </li>
        <li class="<?php if($page_active == 'orders'){ echo 'is-active'; } ?>">
            <a href="<?php echo base_url('orders'); ?>">Orders</a>
        </li>
        <li class="<?php if($page_active == 'transactions'){ echo 'is-active'; } ?>">
            <a href="<?php echo base_url('transactions'); ?>">Transactions</a>
        </li>

        <?php if($user_role == 'agent') { ?>
            <li class="<?php if($page_active == 'agent/shipping'){ echo 'is-active'; } ?>">
                <a href="<?php echo base_url('agent/shipping'); ?>">Shipping Pricing</a>
            </li>
        <?php } ?>

        <?php if($user_role == 'administrator') { ?>
            <li class="<?php if($page_active == 'admin/customers'){ echo 'is-active'; } ?>">
                <a href="<?php echo base_url('admin/customers'); ?>">Customers</a>
            </li>
            <li class="<?php if($page_active == 'admin/agents'){ echo 'is-active'; } ?>">
                <a href="<?php echo base_url('admin/agents'); ?>">Agents</a>
            </li>
            <li class="<?php if($page_active == 'admin/shipping'){ echo 'is-active'; } ?>">
                <a href="<?php echo base_url('admin/shipping'); ?>">Shipping Pricing</a>
            </li>
        <?php } ?>
    </ul>
</div>