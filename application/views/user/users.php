<?php $this->load->view('user/header');?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  

    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                   <div class="span12">
                    <form class='form-inline'>
                      

                        <div class="form-group">
                          <div class="span3">
                            <div class="control-group"> 
                             <!--  <label class="sr-only" for="name">Search</label> -->
                              <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search">
                            </div>
                          </div>
                          <div class="span3">
                           <div class="control-group">
                              <!-- <label class="sr-only" for="name">Pillar No</label> -->
                              <input type="text" class="form-control" id="pillar_no" name="pillar_no" placeholder="Pillar No">
                          </div> 
                          </div>
                          <div class="span3">
                            <button type="submit" class="btn blue " id="LoadRecordsButton"><i class="fa fa-search"></i> Filter</button>
                            <button type="reset" class="btn default" id="reset_button"><i class="fa fa-refresh"></i> Reset</button>
                            
                          </div> 

                           <!--  <div class="span3">                     
                          <div class="control-group">
                            
                              <input type="text" class="form-control" id="datepicker" name="start_from" placeholder="Entry date from">
                          </div>
                          </div>
                          <div class="span3"> 
                           <div class="control-group">
                             
                              <input type="text" class="form-control" id="datepicker1" name="start_to" placeholder="Entry date to ">
                          </div>
                          </div>              -->          
                      </div>
                     
                    
                                           
                      <!--   <div class="form-group">
                          <div class="span3">
                            <button type="submit" class="btn blue " id="LoadRecordsButton"><i class="fa fa-search"></i> Filter</button>
                            <button type="reset" class="btn default" id="reset_button"><i class="fa fa-refresh"></i> Reset</button>
                            
                          </div>
                        </div> -->
                     
                    </form>
                     </div>
                </div>

                <div class="row">

                    <div class="span12">
                        <div class="widget widget-nopad">
                            <div class="widget-header"> <i class="icon-list-alt"></i>
                                <h3> <?php echo isset($header_page_title) ? $header_page_title :''?></h3>
                            </div>
                            <div class="add_new_btn">
                                <a href="<?php echo ADMIN_SITE_PATH; ?>users/edit" class="btn btn-success"><i class="icon-plus"></i> Add New User  </a>
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

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <?php $this->load->view('user/footer');?>
    <script>
  $( function() {
    $( "#datepicker" ).datepicker();

    $( "#datepicker1" ).datepicker();
  } );
  </script>


        <script type="text/javascript">
            $(document).ready(function() {

                $('#users').jtable({
                    title: 'User List',
                    paging: true,
                    pageSize: 10,
                    sorting: false,
                    multiSorting: true,
                    defaultSorting: 'id desc',
                    actions: {
                        listAction: 'users/xhr?cmd=index',
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
                        full_name: {
                            title: 'Name',
                            width: '15%'
                        },
                        pillar_no: {
                            title: 'Pillar No',

                            width: '5%'
                        },
                        adult: {
                            title: 'Adult',
                            width: '5%'
                        },
                        city_name: {
                            title: 'City Name',
                            width: '5%'
                        },
                        children: {
                            title: 'Children',
                            width: '10%'
                        },

                        phone_number: {
                            title: 'Phone',
                            list: true
                        },

                        gender: {
                            title: 'Gender',
                            width: '13%',
                            options: {
                                '1': 'Male',
                                '2': 'Female'
                            }
                        },

                        is_active: {
                            title: 'Status',
                            width: '12%',
                            options: {
                                '1': 'Active',
                                '0': 'In-active'
                            }
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
                            display: function(data) {
                                return "<a title='edit' href='<?php echo ADMIN_SITE_PATH ?>users/edit/" + data.record.id + "'><i class='fa fa-edit '></i></a> <a title='delete' class='delete' data-id='" + data.record.id + "' href='javascript:void(0)'><i class='fa fa-trash-o '></i></a>";
                            }
                        }

                    }
                });

                //Load student list from server
                $('#users').jtable('load');

                $('#LoadRecordsButton').click(function(e) {
                e.preventDefault();
                $('#users').jtable('load', {
                    keyword: $('#keyword').val(),
                    pillar_no: $('#pillar_no').val(),
                   
                   
                });
                });

                $('#reset_button').click(function(e) {
                $('#users').jtable('load');
                });



            });

            $(document.body).on('click', '.delete', function() {
                var elem = $(this);
                var id = elem.data('id');
                var url = '<?php echo ADMIN_SITE_PATH;?>users/edit'

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
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: url,
                                type: 'post',
                                data: {
                                    user_id: id,
                                    delete: 1
                                },
                                dataType: 'Json',
                                async: false,
                                success: function(response) {
                                    if (response.status == 0) {
                                        show_message('Error', response.message, 'error');

                                    } else {
                                        show_message('Status Changed', response.message, 'success');
                                        $('#users').jtable('load');
                                    }

                                },
                                error: function(request, error) {

                                }

                            });

                        }
                    });

            });



            function show_message(title, message, clas) {
                setTimeout(function() {
                    swal(title, message, clas);
                }, 1000);
            }
        </script>

        </body>

        </html>