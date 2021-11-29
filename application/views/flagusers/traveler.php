<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Flighteno</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Flighteno" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo SURL;?>assets/images/favicon.png">

        <!-- jvectormap -->
        <link href="<?php echo SURL;?>assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <!-- DataTables -->
        <link href="<?php echo SURL;?>assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo SURL;?>assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
        
        <!-- App css -->
        <link href="<?php echo SURL;?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo SURL;?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo SURL;?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->

        <style>

            .userNameColorChange{

                color: black;
            }
            .filters_style {
                border-radius: 25px;
                border: 2px solid #e9ecef;
                /* padding: 20px; */
                width: 100%;
                /* height: 15px; */
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                /* border: 1px solid #dddddd; */
                border-bottom: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            .styleHeader{

                color: black;
                font-weight : bold
            }

            body{
                background-color : '';
            }

            .button{
              	border-radius: 25px;
				background-color:  #57B0AF;
				color: white;
				font-weight: bold;
                text-decoration: none;
                display: inline-block;
                cursor: pointer;
                width: 44%;
            }

            .buttonReset{
                border-radius: 25px;
				color: white;
				font-weight: bold;
                text-decoration: none;
                display: inline-block;
                cursor: pointer;
                width: 44%;
                background-color:  #ff0e0e;
                text-align: center;
            }

            .pagination a {
                color: black;
                float: left;
                padding: 8px 16px;
                text-decoration: none;
            }

            .pagination a.active {
                background-color: #4CAF50;
                color: white;
                border-radius: 5px;
            }

            .pagination a:hover:not(.active) {
                background-color: #ddd;
                border-radius: 5px;
            }
            .titleStyle{
                font-style: normal;
                font-weight: 800;
                font-size: 40px;
                color: #18243C;
                margin-top: 2%;
                margin-left: 0%;
                margin-bottom: 1%;
            }
            .titleStyle2{
                left: 350px;
                top: 251px;
                font-weight: bold;
                font-size: 16px;
                line-height: 19px;
                color: #959595
            }
            body{
                background-color: #f8f8f8;
            }
        </style>
    </head>
    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include('includes/topbar.php');?>
            <!-- end Topbar -->
            <!-- ========== Left Sidebar Start ========== -->
            <?php include('includes/sidebar.php');?>
            <!-- Left Sidebar End -->
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <div class="content">
                    <!-- Start Content-->
                    <div class="container-fluid" style="padding-left: 4%; padding-right: 4%;">
                        <div class= "row">
                            <div class="col-12 mt-3">
                                <h4 class="page-title styleHeader titleStyle">Flag users</h4>
                                <p class="titleStyle2">Traveler</p>
                            </div>  
                        </div>
                        <!-- start page title -->
                
                        <?php $flagTravelerUser = $this->session->userdata('flagTravelerUser'); ?>
                        <form method="POST" action="<?php echo base_url();?>index.php/admin/FlagUsers/flagTraveler">
                            <div class="row"> 
                               
                                <div class="col-xl-3">
                                    <label>From: </label>
                                    <input type="date" class="form-control filters_style" placeholder="start date" name="start_date"  value="<?=(!empty($flagTravelerUser['start_date']) ? $flagTravelerUser['start_date'] : "")?>" />
                                </div> <!-- end col -->

                                <div class="col-xl-3">
                                    <label>To: </label>
                                    <input type="date" class="form-control filters_style" placeholder="end date"  name="end_date"  value="<?=(!empty($flagTravelerUser['end_date']) ? $flagTravelerUser['end_date'] : "")?>" />
                                </div> <!-- end col -->

                                <div class="col-xl-3">           
                                    <label>Search by name: </label>
                                    <input type="text" id ="full_name" class="form-control filters_style" placeholder="Search name"  name="full_name"  value="<?=(!empty($flagTravelerUser['full_name']) ? $flagTravelerUser['full_name'] : "")?>" autocomplete="off" />
                                </div> 

                                <div class="col-xl-3" style= "margin-top: 1.8%">
                                    <button type="submit" class="form-control filters_style_input filter button">Filter</button>
                                    <a class= "form-control filters_style_input filter buttonReset"href="<?php echo base_url();?>index.php/admin/FlagUsers/resetFilterTravel">Reset</a>
                                    <i class="glyphicon glyphicon-calendar"></i> 
                                </div> <!-- end col -->

                            </div>
                        </form>

                        <div class = "row mt-4">
                            <table>
                                <tr>
                                    <th>Image</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Location</th>
                                    <th>Flag</th>
                                </tr>
                                <?php foreach($flagTravelerUsers as $travelerUsers) { ?>
                                    <tr>
                                        <td>
                                            <?php if(empty($travelerUsers['profile_image']) || $travelerUsers['profile_image'] == ''|| is_null($travelerUsers['profile_image']) ){ 
                                                
                                                $imageSource = SURL.'assets/images/male.png';
                                            }else{

                                                $imageSource = $travelerUsers['profile_image'];
                                            } ?>
                                            <img src="<?php echo $imageSource;?>" alt="" class="rounded-circle images avatar-sm bx-shadow-lg image2">
                                        </td>
                                        <td class= "userNameColorChange"><?php echo $travelerUsers['full_name']; ?></td>
                                        <td><?php echo $travelerUsers['email_address']; ?></td>
                                        <td><?php echo $travelerUsers['location']; ?></td>
                                        <td>
                                            <?php if( $travelerUsers['flag_reported'] == true || $travelerUsers['flag_reported'] == 1){ ?>
                                                
                                                <!-- $class = 'fas'; -->
                                                <img src="<?php echo SURL;?>assets/images/flag1.png" alt="" class="images avatar-sm bx-shadow-lg image2">
                                            <?php }else{ ?>

                                                <!-- $class = 'far'; -->
                                                <img src="<?php echo SURL;?>assets/images/flag6.png" alt="" class="images avatar-sm bx-shadow-lg image2">
                                            <?php }
                                            ?>
                                            <!-- <span><i class="<?php echo $class; ?> fa-flag fa-3x"></i></span> -->
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <div class="pagination" ><?php  echo $this->pagination->create_links(); ?></div>
                        </div>
                        <!-- end page title --> 

                        <!-- end row -->                       
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include('includes/footer.php');?>
                <!-- end Footer -->
            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->
        <!-- Vendor js -->
        <script src="<?php echo SURL;?>assets/js/vendor.min.js"></script>
        <!-- KNOB JS -->
        <script src="<?php echo SURL;?>assets/libs/jquery-knob/jquery.knob.min.js"></script>
        <!-- Chart JS -->
        <script src="<?php echo SURL;?>assets/libs/chart-js/Chart.bundle.min.js"></script>
        <!-- Jvector map -->
        <script src="<?php echo SURL;?>assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="<?php echo SURL;?>assets/libs/jqvmap/jquery.vmap.usa.js"></script>
        <!-- Datatable js -->
        <script src="<?php echo SURL;?>assets/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo SURL;?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="<?php echo SURL;?>assets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo SURL;?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
        <!-- Dashboard Init JS -->
        <script src="<?php echo SURL;?>assets/js/pages/dashboard.init.js"></script>
        <!-- App js -->
        <script src="<?php echo SURL;?>assets/js/app.min.js"></script>

        <script>
            $("#checkAll").click(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        </script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script>
            $(function() {
                availableTags = [];
                $.ajax({
                'url': '<?php echo SURL ?>index.php/admin/users/getFullNames',
                'type': 'POST',
                'data': "",
                'success': function (response) {
                    availableTags = JSON.parse(response);
                    $("#full_name").autocomplete({
                    source: availableTags
                    });
                }
                });
            });
        </script>
    </body>
</html>