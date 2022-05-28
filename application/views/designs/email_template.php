<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title></title>
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">
<style>
	body{width:100%; margin:auto;}
	#m_wrap{width:100%; margin:auto; background-color:#eee; color:#666; padding:15px; font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif}
	#m_box{width:85%; margin:auto; background-color:#fff; border-radius:15px; padding:20px;}
	.mlogo{padding:10px 0px; text-align:center; margin-bottom:10px;}
	.mlogo a{text-decoration:none; outline:none; border:none;}
	.mhead{font-size:18px; padding-bottom:20px; background-color:#D8B668; padding:15px; margin-bottom:15px; color:#fff; text-align:center; font-weight:bold;}
	.mcontent{font-size:14px;}
	.mcontent .mname{font-size:14px; font-weight:bold;}
	table{width:100%; border:none;}
	table td{border-bottom:1px solid #eee; padding:5px;}
	table td.left{text-align:left;}
	table td.right{text-align:right;}
	table td.center{text-align:center;}
	.mfooter{text-align:center; font-size:12px; margin-top:15px;}
	.mbtn{display: flex; justify-content: center; align-items: center; align-content: center; flex-wrap: wrap; width: 100%; margin: 15px auto;}
	.mbtn .btn{flex: 1 1 auto; padding: 10px 30px; text-align: center; transition: 0.5s; background-size: 200% auto; color: white; box-shadow: 0 0 20px #eee; border-radius: 5px; cursor:pointer; outline:none; text-decoration:none;}
	.mbtn .btn:hover{background-color: #ef5d5f;}
	.mbtn .btn1{background-color: #D8B668;}
</style>
</head>

<body>
	<div id="m_wrap"> 
        <div id="m_box">
            <div class="mhead">
                <div class="mlogo">
                    <img alt="<?php echo app_name; ?>" src="<?php echo base_url(); ?>assets/img/logo-dark50.png" style="max-width:100%;" />
                </div>
				<?php echo $subhead; ?>
            </div>
            
            <div class="mcontent">
                <?php echo $message; ?>
            </div>
        </div>
        
        <div class="mfooter">
            <b><?php echo app_name; ?> Team</b><br />
            &copy;<?php echo date('Y'); ?> - All right reserved.
        </div>
    </div>
</body>
</html>