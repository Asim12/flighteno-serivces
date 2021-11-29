<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .searchBar {
            color: black;
            border-radius: 25px;
            border: 2px solid #fff;
        }
        .badge{
            position: absolute;
            top: 13px;
            margin-left: -1%;
            right: 105px;
            padding: 5px 7px;
            border-radius: 50%;
            background: red;
            color: black;
        }
    </style>
</head>

<?php
    $notificationData  =  getAdminNotification();
    $notificationCount =  countAdminNotification();
?>

<div class="navbar-custom" style="box-shadow:none">
    <ul class="list-unstyled topnav-menu float-right mb-0">
        <?php
            $userData = $this->session->userdata('user_data');
        ?>
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" style="min-width: 250px">    
                <i class="dripicons-bell noti-icon text-dark"></i>
                <span class="badge"><?php echo $notificationCount; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        <span class="float-right">
                            <a href="#" class="text-dark" id="markAllRead">
                                <small>Read all</small>
                            </a>
                        </span>Notification
                    </h5>
                </div>

                <div class="slimscroll noti-scroll" style="max-height: 374px"> 
                    <!-- item-->

                    <?php foreach ($notificationData as $notification) { 

                        $time_zone = date_default_timezone_get();
                        $join_date = $notification['created_date']->toDateTime()->format("Y-m-d H:i:s");                                                                
                        $last_time_ago = time_elapsed_string($join_date , $time_zone);

                    ?>
                        <a href="javascript:void(0);" class="dropdown-item notify-item active">
                            <div class="notify-icon">
                                <img src="<?php echo $notification['userData'][0]['profile_image'];?>" class="img-fluid rounded-circle" alt="" />
                            </div>
                            <p class="notify-details"><?php echo $notification['message']; ?><small title="<?php echo $join_date;?>" class="text-muted timeAgo"><?php echo $last_time_ago;?></small></p>
                        </a>

                    <?php } ?>
                </div>
            </div>
        </li>
    </ul>
    <ul class="list-unstyled menu-left mb-0">
        <li class="float-left">
            <a href="<?php echo base_url();?>index.php/admin/login/index" class="logo">
                <span class="logo-lg">
                    <img src="<?php echo SURL;?>assets/images/logo.png" alt="" height="50">
                </span>
                <span class="logo-sm">
                    <img src="<?php echo SURL;?>assets/images/favicon.png" alt="" height="34">
                </span>
            </a>
        </li>
        <li class="float-left">
            <a class="button-menu-mobile navbar-toggle">
                <div class="lines">
                    <span style="background-color: #558de6"></span>
                    <span style="background-color: #558de6"></span>
                    <span style="background-color: #558de6"></span>
                </div>
            </a>
        </li>
    </ul>
</div>
<script>
    $(document).ready(function(){
        $('#markAllRead').click(function(){
                $.ajax({
                    'url': '<?php echo base_url();?>index.php/admin/Dashboard/markAllReadss',
                    'type': 'POST',
                    'data': "",
                    'success': function (response) {
                        $('.badge').remove();
                    }
                });
        });
    });
</script>