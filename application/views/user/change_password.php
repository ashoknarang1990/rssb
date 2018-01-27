<?php $this->load->view('user/header');?>
<style>
.treeclass {text-align:center; line-height : 20px;}
.nomarginbox {margin-left: 0px;}
.idactive {color : #0d8e10;}
.idinactive {color : #ff0000;}
.activeidclass a, .inactiveidclass a {text-decoration : none}
.bcolor {color : #ccc;}
.form-group {margin-bottom:10px;}
.clearfix {clear:both;}
</style>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
	  
        <div class="span12">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-bar-chart"></i>
              <h3> <?php echo $header_page_title?></h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <div id="big_stats" class="cf">
                    <div class="row1">
						<form method="post" name="bankform" id="bankform" class="bankform" enctype="multipart/form-data">
							<?php if(isset($error_message) && trim($error_message)!=''){?>
							<div class="alert alert-error">
                                              <strong><?php echo $error_message;?>
                                            </div>
							<?php }?>
							<?php echo display_session_message();?>
							<div class='form-group'>
								<div class='span2'>Current Password</div>
								<div class='span9'>
									<input type="password" class='required form-control inp_fetch_text span4' placeholder="Enter Current Password" value="" name="password" />
								</div>
								<div class='clearfix'></div>
							</div>
							<div class='form-group'>
								<div class='span2'>New Password</div>
								<div class='span9'>
									<input type="password" class='required form-control inp_fetch_text span4' placeholder="Enter New Password" value="" name="npassword" />
								</div>
								<div class='clearfix'></div>
							</div>
							<div class='form-group'>
								<div class='span2'>Confirm Password</div>
								<div class='span9'>
									<input type="password" class='required form-control inp_fetch_text span4' placeholder="Enter Confirm Password" value="" name="cpassword" />
								</div>
								<div class='clearfix'></div>
							</div>
							<div class='form-group'>
								<div class='span2'>&nbsp;</div>
								<div class='span9'>
									<input type="submit" name="submit" class="btn btn-primary" value="Update Password">
								</div>
								<div class='clearfix'></div>
							</div>
						</form>
					</div>
                  </div>
                </div>
                <!-- /widget-content --> 
                
              </div>
            </div>
          </div>
          <!-- /widget -->
          
          <!-- /widget -->
        </div>
        
      
	  </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->
<?php $this->load->view('user/footer');?>
</body>
</html>
