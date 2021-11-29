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

        <style>

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

            .cardDisplay{
                display: inline-block;
                width: max-content;
            }
            .boxStyle {
                border-radius: 25px;
                border: 2px solid #e9ecef;
                width: 100%;
            }
            .nameDesign{
                position: absolute;
                width: 158px;
                height: 22px;
                font-style: normal;
                font-weight: 600;
                font-size: 18px;
                line-height: 22px;
                color: #18243C;
            }

            .desigination{
              
                position: absolute;
                width: 158px;
                color: #7A7A7A;
            }

            .dashboardStyle{
                font-style: normal;
                font-weight: 800;
                font-size: 40px;
                color: #18243C;
                margin-top: 1%;
                margin-left: 0%;
                margin-bottom: 1%;
            }
            .divStyleRecet{
                display: flex;
                flex-direction: column;
                min-height: 92vh;
            }

            body{
                background-color: #f8f8f8;
            }
            .cardImageDesign{
                width: 43%;
                height: 215%;
                position: absolute;
                left: 34.53%;
                top: -81.34%;
            }

            .textColor{
                width: 67px;
                height: 48px;
                left: 366px;
                top: 373px;
                font-style: normal;
                font-weight: bold;
                font-size: 40px;
                line-height: 48px;
                letter-spacing: 1px;
                color: #18243C;
            }

            .muteText{
                width: 179px;
                height: 16px;
                left: 366px;
                top: 345px;
                font-style: normal;
                font-weight: 500;
                font-size: 18px;
                line-height: 16px;
                color: #686868;
            }

            .numberCard{
                width: 50px;
                height: 31px;
                left: 366px;
                top: 433px;
                font-style: normal;
                font-weight: bold;
                font-size: 26px;
                line-height: 31px;
                /* color: #16DB4D; */
            }

            .numberCardLast{
                width: 50px;
                height: 31px;
                left: 366px;
                top: 433px;
                font-style: normal;
                font-weight: bold;
                font-size: 26px;
                line-height: 31px;
                /* color: #FB0000; */
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
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                </div>
                            </div>
                        </div>     

                        <div class="row dashboardStyle">
                            <div class="col-12">
                                <div class="page-title-box">
                                </div>
                            </div>
                            Dashboard
                        </div>
                        <!-- end page title --> 
                        <div class="row">
                            <div class="col-xl-4 card-box boxStyle">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <span class="muteText">Total Users Signed Up </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <span class = "textColor" ><?php echo $users; ?></span>      
                                    </div>
                                    <div class="col-xl-6">
                                        <img src="<?php echo SURL;?>assets/images/first.png" alt="money" class="rounded-circle avatar-lg bx-shadow-lg" style="float:right" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <span class="numberCard <?php echo $signedUpUserColor;?>" > <?php echo number_format($percentageSignedUp, 1).'%'; ?></span>         
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 card-box boxStyle">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <span class="muteText">Active Users </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <span class="textColor" ><?php echo $active_users; ?></span>
                                    </div>
                                    <div class="col-xl-6">
                                        <img src="<?php echo SURL;?>assets/images/second.png" alt="money" class="rounded-circle avatar-lg bx-shadow-lg" style="float:right"  />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">    
                                        <span class="numberCard <?php echo $active_user_color;?>"><?php echo number_format($active_user_percentage , 1).'%'; ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 card-box boxStyle">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <span class="muteText">Inactive Users</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <span class="textColor"><?php echo $inActive_users; ?></span>
                                    </div>
                                    <div class="col-xl-6">
                                        <img src="<?php echo SURL;?>assets/images/third.png" alt="money" class="rounded-circle avatar-lg bx-shadow-lg" style="float:right" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <span class="numberCardLast  <?php echo $inactiveUserColor; ?>"><?php echo number_format( $inactiveUserPercentage , 1).'%'; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
        
                        <div class="row">
                            <div class="col-xl-9">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card-box boxStyle">
                                            <h4 class="header-title mb-3"  style="color: black; font-size: 30px">User Activity</h4>
                                            <div class="boxStyle" style="background-color : #0BB3EA; max-width: 95%">
                                                <canvas id="user_activity" width="800" height="300"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="card-box boxStyle">
                                            <h4 class="header-title mb-3" style="color: black; font-size: 30px">Total orders of travelers</h4>
                                            
                                            <div class="boxStyle" style ="max-width: 95%">
                                                <canvas id="travelers" width="800" height="300"></canvas>
                                            </div>
                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card-box boxStyle">
                                            <div class="media">
                                                <div class="media-body table-responsive">
                                                    <h5 class="mt-0">Recent Users</h5>
                                                    <p class="text-muted"><?php echo date('Y-m-d'); ?></p>
                                                    <table class="">
                                                        <?php foreach ($recentActivity as $activity) { ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="row" style= "margin-top: 30%">
                                                                        <div class="col-xl-6">

                                                                            <?php if(empty($activity['profileData'][0]['profile_image']) || $activity['profileData'][0]['profile_image'] == ''|| is_null($activity['profileData'][0]['profile_image']) ){ 
                                                                
                                                                                $imageSource = SURL.'assets/images/male.png';
                                                                            }else{

                                                                                $imageSource = $activity['profileData'][0]['profile_image'];
                                                                            } ?>
                                                                            <img src="<?php echo $imageSource;?>" class="rounded-circle avatar-sm bx-shadow-lg">
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <span class="nameDesign" class="ml-2"><?php echo $activity['profileData'][0]['full_name'][0]; ?></span><br/>
                                                                            <span class="text-muted desigination"><?php echo  $activity['message']; ?></span> 
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </table>
                                                    <div class="pagination" style= "padding-top: 6%;" ><?php  echo $this->pagination->create_links(); ?></div>
                                                </div>
                                            </div>
                                        </div> <!-- end card-box-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 card-box boxStyle" style= "background-color : #0BB3EA">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <h4 class="header-title" style="color:white; font-size :20px; font-weight:bold">30 Days</h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-6">
                                                <h5 style= "color: white; font-size: 12px;">Money Make Last</h5>
                                            </div>
                                            <div class="col-xl-6">
                                                <img src="<?php echo SURL;?>assets/images/ddd.png" alt="money" class="rounded-circle avatar-xlg bx-shadow-lg"style="float:right;" />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-12" >
                                                <h5 style= "color: white; font-weight: bold; font-size: 45px"><?php echo '$'.$totalEarnedCost; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
        <script>

            window.onload = function() {
                new Chart(document.getElementById("user_activity"), {
                    type: 'bar',
                    data: {
                        labels:  ['00AM', '2AM', '4AM', '6AM', '8PM', '10AM', '12AM','14PM','16PM', '18PM','20PM','22PM'],
                        datasets: [
                            {    
                                data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                                backgroundColor: ["#ffffff" ,"#ffffff" ,"#ffffff","#ffffff","#ffffff", "#ffffff","#ffffff", "#ffffff","#ffffff","#ffffff","#ffffff", "#ffffff"],
                                label: "user",
                                borderColor: "#0BB3EA",
                                fill: false,
                                display:false,
                            }
                        ]
                    },

                options: {
                    title: {
                        display: true,
                        text: 'Last 24 Hours',
                        fontColor: "white",
                        
                    },  
                    legend: {
                        labels: {
                            fontColor: "white",
                            fontSize: 18
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                fontColor: "white",
                                fontSize: 12,
                                stepSize: 1,
                                beginAtZero: true
                            },gridLines: {
                                display: false
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                fontColor: "white",
                                fontSize: 14,
                                stepSize: 1,
                                beginAtZero: true
                            },gridLines: {
                                display: false
                            }    
                        }]
                    }
                }

                });

                new Chart(document.getElementById("travelers"), {
                    type: 'bar',
                    data: {
                        labels: ['00AM', '2AM', '4AM', '6AM', '8AM', '10AM', '12AM','14PM','16PM', '18PM','20PM','22PM'],
                        datasets: [
                            { 
                                data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ],
                                backgroundColor: ["#027EF2" ,"#027EF2" ,"#027EF2","#027EF2","#027EF2", "#027EF2","#027EF2", "#027EF2","#027EF2","#027EF2","#027EF2", "#027EF2"],

                                label: "orders",
                                borderColor: "white",
                                fill: false,
                                display:false,
                            }
                        ]
                    },
                    options: {
                        title: {
                        }, scales: {
                        yAxes: [{
                            ticks: {
                            },gridLines: {
                                display: false
                            }
                        }],
                        xAxes: [{
                            ticks: {
                            },gridLines: {
                                display: false
                            }    
                        }]
                    }
                    }
                });
            
            }
        </script>
    </body>
</html>