<?php $this->load->view('user/header.php');?>
<link href="<?php echo USER_CSS_PATH?>pages/signin.css" rel="stylesheet" type="text/css">
<div class="account-container">
	
	<div class="content clearfix">
		
		<form id='login_form' name='login_form' method="post" action='<?php echo base_url().'common/login'?>'>
		
			<h1>Admin Login</h1>		
			
			<div class="login-fields">
				
				<p>Please provide your details</p>
				<div class='_form_err_msg_div'></div>
				<div class="field">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" value="" placeholder="Enter Username" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" placeholder="Enter Password" class="login password-field"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<span class="login-checkbox">
					<a href="#">Reset Password</a>
				</span>
									
				<input type='submit' name="submit_login" class="button btn btn-success btn-large" value='Login' />
				
			</div> <!-- .actions -->
			
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->
<?php $this->load->view('user/footer.php');?>
<script type="text/javascript" src="<?php echo JS_PATH?>user_login.js"></script>