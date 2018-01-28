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
						<form method="post" action="<?php echo ADMIN_SITE_PATH.'users/edit' ?>" name="bankform" id="userform" class="bankform" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $this->uri->segment(4) ?>">
							<fieldset>
							<?php if(isset($error_message) && trim($error_message)!=''){?>
							<div class="alert alert-error">
							  <strong><?php echo $error_message;?></strong>
							</div>
							<?php }?>
							<?php echo display_session_message();?>
							
							<div class="alert alert-danger center col-md-8 hide" id="error">        
							</div>
							<div class="alert alert-info center col-md-8 hide" id="success">


							</div>
							<div class='form-group'>
								<div class='span5'>
									<div class="control-group">											
										<label class="control-label">Full Name</label>
										<div class="controls">
											<input type="text" data-error="Full name" class='required form-control inp_fetch_text span4' placeholder="Enter Full Name" value="<?php echo isset($user_data['full_name']) ? $user_data['full_name'] : ''?>" name="full_name" />
										</div>				
									</div>
								</div>
								<!-- <div class='span5'>
=======
								<div class='span5'>
									<div class="control-group">											
										<label class="control-label">Father / Husband Name</label>
										<div class="controls">
											<input type="text" data-error="Guardian  name" class='required form-control inp_fetch_text span4' placeholder="Enter Guardian Name" value="<?php echo isset($user_data['guardian_name']) ? $user_data['guardian_name'] : ''?>" name="guardian_name" />
										</div>				
									</div>
								</div>
								
								<div class='clearfix'></div>
							</div>
							
							<div class='form-group'>
							<div class='span5'>
>>>>>>> 680e006552c9107f1ae2358d5d8ae2cbc9dff659
									<div class="control-group">											
										<label class="control-label">Email Address</label>
										<div class="controls">
											<input type="text" data-error="Address" class=' form-control inp_fetch_text span4' placeholder="Enter Email Address" value="<?php echo isset($user_data['email_id']) ? $user_data['email_id'] : ''?>" name="email_id" />
										</div>				
									</div>
								</div> -->
								<div class='span5'>
									<div class="control-group">											
										<label class="control-label">Contact Number</label>
										<div class="controls">
											<input type="text" data-error="Phone number" class='required form-control inp_fetch_text span4' placeholder="Enter Contact Number" value="<?php echo isset($user_data['phone_number']) ? $user_data['phone_number'] : ''?>" name="phone_number" />
										</div>				
									</div>
								</div>
								
								<div class='clearfix'></div>
							</div>

							
							

							<div class='form-group'>

							 	<div class='span5'>
									<div class="control-group">											
										<label class="control-label">Adult</label>
										<div class="controls">
										<select name="adult">
											
											
											<?php foreach($user_count as $cnt){
												$sel="";
												if($cnt==$user_data['adult']){

													$sel="selected=selected";
												}

												echo '<option '.$sel.' value="'.$cnt.'">'.$cnt.'</option>';
												} ?>
											

										</select>
											
										</div>				
									</div>
								</div>
								<div class='span5'>
									<div class="control-group">											
										<label class="control-label">Children</label>
										<div class="controls">
										<select name="children">
											
											
											<?php foreach($user_count as $cnt){
												$sel2="";
												if($cnt==$user_data['adult']){

													$sel2="selected=selected";
												}


												echo '<option '.$sel2.' value="'.$cnt.'">'.$cnt.'</option>';
												} ?>
											

										</select>
											
										</div>				
									</div>
								</div>
								
								<div class='clearfix'></div>
							</div>


							<div class='form-group'>

							<div class='span5'>

									<div class="control-group">											
										<label class="control-label">Pillar no</label>
										<div class="controls">
											<input type="text" class=' form-control inp_fetch_text span4' placeholder="Enter Pillar No" value="<?php echo isset($user_data['pillar_no']) ? $user_data['pillar_no'] : ''?>" name="pillar_no" />
										</div>				
									</div>
								</div>
								<div class='span5'>
									<div class="control-group">											
										<label class="control-label">Gender</label>
										<div class="controls">
											<label class="radio inline">
											  <input type="radio" value='1' <?php echo (isset($user_data['gender']) && $user_data['gender']==1) ? "checked" : ""?> name="gender"> Male
											</label>
											
											<label class="radio inline">
											  <input type="radio" value='2' <?php echo (isset($user_data['gender']) && $user_data['gender']==2) ? "checked" : ""?> name="gender"> Female
											</label>
										</div> 			
									</div>
								</div>
								<!-- <div class='span5'>
									<div class="control-group">											
										<label class="control-label">Age</label>
										<div class="controls">
											<input type="text" class=' form-control inp_fetch_text span4' placeholder="Enter age" value="<?php echo isset($user_data['age']) ? $user_data['age'] : ''?>" name="age" />
										</div>				
									</div>
								</div> -->
								
								<div class='clearfix'></div>
							</div>
							<div class='form-group'>
								<div class='span5'>
									<div class="control-group">											
										<label class="control-label">States</label>
										<div class="controls">
											<select id="state_id">
												<?php if(isset($getstate) && !empty($getstate)){
													foreach($getstate as $s){?>
														<option value="<?php echo $s['id']?>"><?php echo $s['name']?> </option>
												<?php }} ?> 
											</select>
										</div>				
									</div>
								</div>
								<div class='span5'>
									<div class="control-group">											
										<label class="control-label">Cities</label>
										<div class="controls">
											<select id="city_id">
												<?php if(isset($getstate) && !empty($getstate)){
													foreach($getstate as $s){?>
														<option value="<?php echo $s['id']?>"><?php echo $s['name']?> </option>
												<?php }} ?> 
											</select>
										</div> 			
									</div>
								</div>
								<!-- <div class='span5'>
									<div class="control-group">											
										<label class="control-label">Age</label>
										<div class="controls">
											<input type="text" class=' form-control inp_fetch_text span4' placeholder="Enter age" value="<?php echo isset($user_data['age']) ? $user_data['age'] : ''?>" name="age" />
										</div>				
									</div>
								</div> -->
								
								<div class='clearfix'></div>
							</div>
							
							
						
							
							
							
							<!-- <div class='form-group'>
								<div class='span5'>
									<div class="control-group">											
										<label class="control-label">Gender</label>
										<div class="controls">
											<label class="radio inline">
											  <input type="radio" value='1' <?php echo (isset($user_data['gender']) && $user_data['gender']==1) ? "checked" : ""?> name="gender"> Male
											</label>
											
											<label class="radio inline">
											  <input type="radio" value='2' <?php echo (isset($user_data['gender']) && $user_data['gender']==2) ? "checked" : ""?> name="gender"> Female
											</label>
										</div> 			
									</div>
								</div>

								
								
								<div class='clearfix'></div>
							</div>
							<div class='form-group'>
								<div class='span5'>
									<div class="control-group">											
										<label class="control-label">Status</label>
										<div class="controls">
											<label class="radio inline">
											  <input type="radio" value='1' <?php echo (isset($user_data['is_active']) && $user_data['is_active']==1) ? "checked" : ""?> name="is_active"> Active
											</label>
											
											<label class="radio inline">
											  <input type="radio" value='2' <?php echo (isset($user_data['is_active']) && $user_data['is_active']==2) ? "checked" : ""?> name="is_active"> Pending
											</label>
										</div> 				
									</div>
								</div>

								
								
								<div class='clearfix'></div>
							</div> -->
							</fieldset>
							<div class='form-group'>
								
								<div class='span9'>
									<button type="button" name="submit" id="submit" class="btn btn-primary" value="Edit Details">Save</button>
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
<script type="text/javascript">


    $(document).ready(function(){

    	$("state_id")

     
        $(document.body).on('click','#submit',function(){
        	
            var token=0;
            var html='';
            $('#userform').find('.required').each(function(){
                var val=$(this).val();
                if(val=='')
                {
                    token++;
                    var message=$(this).data('error');
                    html=html+'<h5><b> Required - </b>'+message+'</h5>';
                    
                }

            });
            
            // var contentLength = CKEDITOR.instances['content_ckeditor'].getData().length;
            // if( !contentLength ) {
            //     html=html+'<h5><b> Required - </b>Please enter some content</h5>';
            //     token++;
            // }
            // else
            // {
            //     var content=CKEDITOR.instances['content_ckeditor'].getData();
            //     $('#content_ckeditor').val(content);
            // }

            if(token>0)
            {
                $('#error').removeClass('hide');
                $('#error').html(html);
                return false;
            }
            else
            {

                $('#error').addClass('hide');
                var url=$('#userform').attr('action');

                $.ajax({ 
                    url : url,
                    type : 'post',
                    data : $('#userform').serialize(),
                    dataType:'Json',
                    beforeSend : function (){
                        $.blockUI({
                            fadeIn : 0,
                            fadeOut :0,
                            showOverlay : true,
                            css:{fontSize:'10px'},
                            
                        });
                    },
                    async : false,
                     success : function( response ){
                     	
                     	if(response.status==0)
                        {
                           $('#success').addClass('hide');
                           $('#error').html(response.message).removeClass('hide');
                        }  
                        else
                        {
                          $('#success').html(response.message).removeClass('hide');
                           $('#error').addClass('hide');
                           if(response.id>0)
                           {
                                window.location.href='<?php echo ADMIN_SITE_PATH.'users'?>';
                           } 
                        }
                       
                     },
                     error: function (request, error) {
                       
                     },
                     complete : function (){
                        $.unblockUI();
                    }
                   
               });
                 return false;

            }

        });

       
        
    });
   // AjaxFileUploder('blog_image');
</script>
</body>
</html>
