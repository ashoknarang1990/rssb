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
						<form method="post" action="<?php echo ADMIN_SITE_PATH.'pillar/edit' ?>" name="bankform" id="mealform" class="bankform" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $this->uri->segment(4) ?>">

							<fieldset>
							<?php if(isset($error_message) && trim($error_message)!=''){?>
							<div class="alert alert-error">
							  <strong><?php echo $error_message;?></strong>
							</div>
							<?php }?>
							<?php echo display_session_message();?>
							
							<!-- <div class="alert alert-infos">
							  <strong>Personal Details</strong>
							</div>
 -->
							<div class="alert alert-danger center col-md-8 hide" id="error">        
							</div>
							<div class="alert alert-info center col-md-8 hide" id="success">


				
							</div>
							<div class='form-group'>
								<div class='span5'>
									<div class="control-group">											
										<label class="control-label">Parent</label>
										<div class="controls">
											<select name="pid">
												<option value="0">-No parent-</option>
												<?php foreach($parent_meals as $parents_meal){

													$sel_per="";
													if($meal_data['pid']==$parents_meal['id']){
														$sel_per="selected";

													}
													echo "<option $sel_per value='".$parents_meal['id']."'>".$parents_meal['title']."</option>";
													}?>
											</select>
										</div>				
									</div>
								</div>
								<div class='span5'>
									<div class="control-group">											
										<label class="control-label">Pillar No</label>
										<div class="controls">
											<input type="text" data-error="Title" class='required form-control inp_fetch_text span4' placeholder="Enter title" value="<?php echo isset($meal_data['title']) ? $meal_data['title'] : ''?>" name="title" />
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
											  <input type="radio" value='1' <?php echo (isset($meal_data['is_active']) && $meal_data['is_active']==1) ? "checked" : "checked"?> name="is_active"> Active
											</label>
											
											<label class="radio inline">
											  <input type="radio" value='2' <?php echo (isset($meal_data['is_active']) && $meal_data['is_active']==0) ? "checked" : ""?> name="is_active"> Disable
											</label>
										</div>				
									</div>
								</div>

								<!-- <div class='span5'>
									<div class="control-group">											
										<label class="control-label">Added by</label>
										<div class="controls">
												<select name="added_by">
												<option value="0">-Select User-</option>
												<?php foreach($users as $user){

													$sel_usr="";
													if($meal_data['added_by']==$user['id']){
														$sel_usr="selected";

													}
													echo "<option $sel_usr value='".$user['id']."'>".$user['full_name']."</option>";
													}?>
											</select>
										</div>		
									</div>
								</div> -->
								
								<div class='clearfix'></div>
							</div>
							</fieldset>
							<div class='form-group'>
								<div class='span2'>&nbsp;</div>
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

     
        $(document.body).on('click','#submit',function(){
        	
            var token=0;
            var html='';
            $('#mealform').find('.required').each(function(){
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
                var url=$('#mealform').attr('action');

                $.ajax({ 
                    url : url,
                    type : 'post',
                    data : $('#mealform').serialize(),
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
                                window.location.href='<?php echo ADMIN_SITE_PATH.'meals'?>'+'?pid='+response.pid;
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
