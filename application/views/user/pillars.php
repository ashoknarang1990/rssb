<?php $this->load->view('user/header');?>
<style>
.treeclass {text-align:center; line-height : 20px;}
.nomarginbox {margin-left: 0px;}
.idactive {color : #0d8e10;}
.idinactive {color : #ff0000;}
.activeidclass a, .inactiveidclass a {text-decoration : none}
.bcolor {color : #ccc;}
</style>

<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
	  
        <div class="span12">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> <?php echo isset($header_page_title) ? $header_page_title :''?></h3>
            </div>

            <div  style="float:right;text-align:right;margin: 10px 20px;">
                  <a href="<?php echo ADMIN_SITE_PATH; ?>pillars/edit" class="btn btn-success"><i class="icon-plus"></i> Add New Pillar  </a>
            </div>
                
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
               <div class="widget-content">
                 
                  
                    <div class="row1" id="users">
					
					
						
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

    $(document).ready(function () {

        $('#users').jtable({
            title: 'Meals List',
            paging: true,
            pageSize: 10,
            sorting: true,
            multiSorting: true,
            defaultSorting: 'Name ASC',
            actions: {
                listAction: 'pillars/xhr?cmd=index&pid=<?php echo ($this->input->get("pid")) ? $this->input->get("pid") :0; ?>',
                // deleteAction: '/Demo/DeleteStudent',
                // updateAction: '/Demo/UpdateStudent',
                // createAction: '/Demo/CreateStudent'
            },
            fields: {
                id: {
                    key: true,
                    create: false,
                    edit: false,
                    list: false
                },
                title: {
                    title: 'Name',
                    width: '23%'
                },              
                is_active: {
                    title: 'Status',
                    width: '12%',
                    options: { '1': 'Active', '0': 'In-active' }
                },
                    
                created_date: {
                    title: 'Added date',
                    width: '15%',
                    type: 'date',
                    displayFormat: 'yy-mm-dd',
                    create: false,
                    edit: false,
                    sorting: false //This column is not sortable!
                },
                Action: {
                    title: 'Action',
                    width: '15%',
                    sorting: false, //This column is not sortable!
                    display:function(data)
                    { var ret_act= "<a title='edit' href='<?php echo ADMIN_SITE_PATH ?>meals/edit/"+data.record.id+"'><i class='fa fa-pencil '></i></a> | <a title='delete' class='delete' data-id='"+data.record.id+"' href='javascript:void(0)'><i class='fa fa-trash-o '></i></a> "
                    <?php if(!$this->input->get('pid')>0) { ?>
                    ret_act=ret_act+"| <a title='sub meals' href='<?php echo ADMIN_SITE_PATH ?>meals/?pid="+data.record.id+"'><i class='fa fa-sitemap'></i></a>";
                    <?php } ?>
                    return ret_act;

                  }
                }

            }
        });

        //Load student list from server
        $('#users').jtable('load');
    });



$(document.body).on('click','.delete',function(){
    var elem=$(this);
    var id=elem.data('id');
    var url='<?php echo ADMIN_SITE_PATH;?>meals/edit'
    
        swal({
          title: "Are you sure?",
          text: "You will not able to recover",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, Continue!",
          cancelButtonText: "No, cancel please!",
          closeOnConfirm: false,
          closeOnCancel: true,
          showLoaderOnConfirm: true,
        },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({ 
                url : url,
                type : 'post',
                data : {meal_id:id,delete:1},
                dataType:'Json',
                async : false,
                 success : function( response ){
                    if(response.status==0)
                    {
                        show_message('Error',response.message,'error');
                        
                    }  
                    else
                    {
                        show_message('Status Changed',response.message,'success');
                        $('#users').jtable('load');
                    }
                   
                 },
                 error: function (request, error) {
                   
                 }
                
           });

          } 
        });
    
});


    function show_message(title,message,clas)
    {
        setTimeout(function(){
        swal(title,message,clas);
        }, 1000);
    }

</script>

</body>
</html>