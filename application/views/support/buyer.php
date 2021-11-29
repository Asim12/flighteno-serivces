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

            .customStyle{
                font-size : 15px;
            }

            .styleHeader{

                color: black;
                font-weight : bold
            }


            /* pagination */
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
                        <div class = "row mt-4">
                            <div class="col-12 mt-3">
                                <h4 class="page-title styleHeader titleStyle">Support</h4>
                                <p class= "titleStyle2">Buyer</p>
                            </div> 
                            <table>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Order No.</th>
                                </tr>
                                <?php foreach ($buyer_res as $value){ ?>
                                <tr>
                                    <td>
                                        <?php if(empty($value['profileData'][0]['profile_image']) || $value['profileData'][0]['profile_image'] == ''|| is_null($value['profileData'][0]['profile_image']) ){ 
                                            $imageSource = SURL.'assets/images/male.png';
                                        }else{
                                            $imageSource = $value['profileData'][0]['profile_image'];
                                        } ?>
                                        <img src="<?php echo $imageSource;?>" alt="" class="rounded-circle images avatar-sm bx-shadow-lg image2">
                                    </td>
                                    <td class="userNameColorChange"><?php echo $value['profileData'][0]['full_name']; ?></td>
                                    <td><?php echo $value['subject']; ?></td>
                                    <td><?php echo $value['order_number']; ?></td>
                                </tr>
                               <?php } ?>
                            </table>
                            <div class="pagination" ><?php  echo $this->pagination->create_links(); ?></div>
                        </div>                      
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
    </body>
</html>