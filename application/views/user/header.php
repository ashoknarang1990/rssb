<?php $header_page_id = (isset($header_page_id) && trim(strtolower($header_page_id)) != '') ? $header_page_id : "dashboard"?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo strtoupper((isset($header_page_title) && trim($header_page_title)!='') ? $header_page_title.' : '.SITE_NAME : SITE_NAME);?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo USER_CSS_PATH?>bootstrap.min.css" rel="stylesheet">
<link href="<?php echo USER_CSS_PATH?>bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo USER_CSS_PATH?>style.css" rel="stylesheet">
<link href="<?php echo USER_CSS_PATH?>jquery-ui.css" rel="stylesheet">
<link href="<?php echo USER_CSS_PATH?>pages/dashboard.css" rel="stylesheet">
<link href="<?php echo USER_CSS_PATH?>lightgray/jtable.css" rel="stylesheet">
<link href="<?php echo USER_CSS_PATH?>/sweetalert.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo  base_url();?>"><img src="<?php echo IMG_PATH?>logo.jpg" alt="" width="" style='width:75px;'>  </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
			<?php if(is_user_login(false)){?>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-cog"></i> Account <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url().'admin/dashboard/changepassword'?>">Change Password</a></li>
              <li><a href="javascript:;">Help</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> <?php $reg_id = get_logged_in_data('reg_id'); $reg_id = (trim($reg_id) == '') ? "Admin" : $reg_id; echo get_logged_in_data('full_name').' ('.$reg_id.')'?>  <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url().'admin/dashboard/editprofile'?>">Edit Profile</a></li>
              <li><a href="<?php echo base_url().'common/logout'?>">Logout</a></li>
            </ul>
          </li>
			<?php } else {?>
			
			<?php }?>
        </ul>
        
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<?php if(is_user_login(false)){?>
<!-- /navbar -->
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
		<!-- <li class="<?php echo (isset($header_page_id) && trim(strtolower($header_page_id)) == 'dashboard') ? "active" : ""?>"><a href="<?php echo base_url().'admin/dashboard'?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li> -->
    <li class="<?php echo (isset($header_page_id) && trim(strtolower($header_page_id)) == 'users') ? "active" : ""?> dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-long-arrow-down"></i><span>User Management</span> <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="<?php echo base_url().'admin/users/'?>">Manage Users</a></li>
      <li><a href="<?php echo base_url().'admin/users/edit'?>">Add New User</a></li>
     <!--  <li><a href="javascript:;">Manage Deleted Users</a></li> -->
    </ul>
    </li>
  <!--    <li class="<?php echo (isset($header_page_id) && trim(strtolower($header_page_id)) == 'users') ? "active" : ""?> dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-long-arrow-down"></i><span>Meals Pillar</span> <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="<?php echo base_url().'admin/pillars/'?>">Manage Pillar</a></li>
      <li><a href="<?php echo base_url().'admin/pillars/edit'?>">Add New Pillar</a></li>
     
    </ul>
    </li> -->
		
		
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->
<?php }?>