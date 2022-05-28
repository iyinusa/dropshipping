<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
    $log_id = $this->session->userdata('afrs_id');
    $log_firstname = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
    $log_role = $this->Crud->read_field('id', $log_id, 'user', 'role');
    $log_img_id = $this->Crud->read_field('id', $log_id, 'user', 'img_id');
    $log_img = $this->Crud->image($log_img_id, 'big');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags always come first -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title><?php echo $title; ?></title>
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png" />

        <!--Core CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bulma.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/core.css">
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:100,400" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500" rel="stylesheet">
        
        <!-- plugins -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/slick/slick.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/slick/slick-theme.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/webuipopover/jquery.webui-popover.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/izitoast/css/iziToast.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/zoom/zoom.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jpcard/card.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/chosen/chosen.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/icons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/popup/popup.css" />
    </head>
    <body>
        <div class="pageloader"></div>
        <div class="infraloader is-active"></div>
        
        <nav class="navbar mobile-navbar is-hidden-desktop is-hidden-tablet" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="<?php echo base_url(); ?>">
                    <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="">
                </a>
        
                <a id="sidebar-mode" class="navbar-item is-icon is-sidebar-toggler" href="javascript:void(0);">
                    <i data-feather="sidebar"></i>
                </a>
        
                <div class="navbar-burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            
            <!-- Navbar mobile menu -->
            <div class="navbar-menu">
                <div class="navbar-item has-dropdown">
                    <a href="<?php echo base_url('profile'); ?>" class="navbar-link">
                        <img src="<?php echo base_url($log_img); ?>" alt=""> 
                        <span class="is-heading">Welcome, <?php if(!empty($log_firstname)) {echo $log_firstname;} else { echo 'Guest'; } ?></span> 
                    </a>
        
                    <!-- Mobile Dropdown -->
                    <div class="navbar-dropdown">
                        <a href="<?php echo base_url('cart'); ?>" class="navbar-item is-flex">
                            <span>Cart</span>
                            <span class="menu-badge cart-count">0</span>
                        </a>
                        <a href="<?php echo base_url('orders'); ?>" class="navbar-item">Orders</a>
                        <a href="<?php echo base_url('orders/track'); ?>" class="navbar-item">Track Order</a>
                        <a href="<?php echo base_url('auth/logout'); ?>" class="navbar-item">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- /Mobile mode navbar -->
        
        <!-- Main Sidebar-->
        <div class="main-sidebar">
            <div class="sidebar-brand">
                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/icon_menu.png" alt=""></a>
            </div>
            <div class="sidebar-inner">
                <ul class="icon-menu">
                    <li>
                        <a href="javascript:void(0);" id="open-shop"><i data-feather="home"></i></a>
                    </li>   
                    <li>
                        <a href="javascript:void(0);" id="open-cart"><i data-feather="shopping-cart"></i> <span class="cart-items is-cart" style="display:none;"></span></a>
                    </li>  
                    <li>
                        <a href="javascript:void(0);" id="open-search"><i data-feather="search"></i></a>
                        <a href="javascript:void(0);" id="close-search" class="is-hidden is-inactive"><i data-feather="x"></i></a>
                    </li>   
                    <li class="is-hidden-desktop is-hidden-tablet">
                        <a href="javascript:void(0);" id="mobile-mode"><i data-feather="smartphone"></i></a>
                    </li> 
                </ul>
        
                <!-- User account -->
                <ul class="bottom-menu is-hidden-mobile">
                    <li>
                        <?php if(empty($log_id)){ ?>
                            <a href="<?php echo base_url('auth/'); ?>"><i data-feather="user"></i></a>
                        <?php } else { ?>
                            <a href="<?php echo base_url('auth/logout'); ?>"><i data-feather="log-out"></i></a>
                        <?php } ?>
                    </li>     
                </ul>
            </div>
        </div>
        <!-- /Main Sidebar-->
        
        <!-- Shop quickview -->
        <div class="shop-quickview has-background-image" data-background="assets/images/bg/sidebar.jpeg">
            <div class="inner">
                <!-- Header -->
                <div class="quickview-header">
                    <h2><?php echo app_name; ?></h2>
                    <span id="close-shop-sidebar"><i data-feather="x"></i></span>
                </div>
                <!-- Shop menu -->
                <ul class="shop-menu">
                    <li>
                        <a href="<?php echo base_url('shop'); ?>">
                            <span>Shop</span>
                            <i data-feather="grid"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('profile'); ?>">
                            <span>My Account</span>
                            <i data-feather="user"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('orders'); ?>">
                            <span>My Orders</span>
                            <i data-feather="credit-card"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('orders/track'); ?>">
                            <span>Track Orders</span>
                            <i data-feather="server"></i>
                        </a>
                    </li>
                </ul>
                <!-- Profile image -->
                <ul class="user-profile">
                    <li>
                        <a href="<?php echo base_url('profile'); ?>">
                            <img src="<?php echo base_url($log_img); ?>" alt="">
                            <span class="user">
                                <span><?php if(!empty($log_firstname)){ echo $log_firstname; } else { echo 'Guest'; } ?></span>
                                <span><span class="cart-count">0</span> <small>Items in Cart</small></span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Cart quickview -->
        <div class="cart-quickview">
            <div class="inner">
                <!-- Header -->
                <div class="quickview-header">
                    <h2>Quick Cart</h2>
                    <span id="close-cart-sidebar"><i data-feather="x"></i></span>
                </div>
                <!-- Cart quickview body -->
                <div class="cart-box"> </div>
            </div>
        </div>

        <div class="search-overlay"></div>
    
        <div class="search-input-wrapper is-desktop is-hidden">
            <div class="field">
                <div class="control">
                    <span class="is-product-msg"></span>
                    <input type="text" name="search" placeholder="Product Name" class="is-product-input" autofocus required>
                    <span id="clear-search" role="button"><i data-feather="x"></i></span>
                    <div>
                        <a href="javascript:;" class="button is-danger is-large is-fullwidth is-find-product">Find Product</a>
                    </div>
                </div>
            </div>
        </div>