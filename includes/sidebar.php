<style>

    .nameStyle{
        color: black;
        font-weight : bold;
        font-size   : 15px
    }

    .styleClass > li > a.active{
        color: #B11859;
    }
    .styleClass > li > a{
        color: #18243C;
    }


</style>
<div class="left-side-menu" style="box-shadow:none">
    <div class="slimscroll-menu">
        <!--- Sidemenu -->
        <?php         
            $userArray = $this->session->userdata('user_data');
            
        ?>
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="<?php echo SURL;?>assets/images/users/avatar-4.jpg" alt="user-image" class="rounded-circle">
                        <span class="pro-user-name ml-1 nameStyle">
                            <?php echo $userArray['full_name'];?> <i class="mdi mdi-chevron-down"></i> 
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <div class="dropdown-item noti-title">
                            <h6 class="m-0">
                                Welcome !
                            </h6>
                        </div>
                        <div class="dropdown-divider"></div>

                        <a href= "<?php echo base_url();?>index.php/admin/Login/logoutUser" class="dropdown-item notify-item">
                            <i class="dripicons-power"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>

                <li class="mt-4">
                    <a href="<?php echo base_url();?>index.php/admin/Dashboard/index">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="hasSubmenu">
                    <a href="#" data-target="#menu-style3" data-toggle="collapse1"><i class=" mdi mdi-account-outline"></i>
                    <span>Signed up users</span></a>

                    <ul class="collapse1 styleClass" id="menu-style3">

                        <li class="">
                        
                            <a href="<?php echo base_url();?>index.php/admin/Users/index">
                                <i class=" mdi mdi-account-outline"></i>
                                <span> Buyers </span>
                            </a>
                                        
                        </li>
                        <li class="mt-2">                        
                            <a href="<?php echo base_url();?>index.php/admin/Users/traveler">
                                <i class=" mdi mdi-account-outline"></i>
                                <span> Traveler </span>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="hasSubmenu">
                    <a href="#" data-target="#menu-style4" data-toggle="collapse2"><i class="far fa-credit-card"></i>
                    <span>Transection</span></a>

                    <ul class="collapse2 styleClass" id="menu-style4">

                        <li class="">
                        
                        <a href="<?php echo base_url();?>index.php/admin/Trasection/index">
                            <i class="far fa-credit-card"></i>
                            <span> Buyers </span>
                        </a>
                                        
                    </li>
                        <li class="mt-2">                        
                            <a href="<?php echo base_url();?>index.php/admin/Trasection/trasectionTraveler">
                                <i class="far fa-credit-card"></i>
                                <span> Traveler </span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="hasSubmenu">
                    <a href="#" data-target="#menu-style5" data-toggle="collapse3"><i class="fas fa-user-lock"></i>
                    <span>Flag users</span></a>

                    <ul class="collapse3 styleClass" id="menu-style5">

                        <li class="">
                        
                        <a href="<?php echo base_url();?>index.php/admin/FlagUsers/index">
                            <i class="fas fa-user-lock"></i>
                            <span> Buyers </span>
                        </a>
                                        
                    </li>
                        <li class="mt-2">                        
                            <a href="<?php echo base_url();?>index.php/admin/FlagUsers/flagTraveler">
                                <i class="fas fa-user-lock"></i>
                                <span> Traveler </span>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="">
                    <a href="<?php echo base_url();?>index.php/admin/Support/tickets">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Support </span>
                    </a>
                </li>
                <!-- 
                <li class="hasSubmenu">
                    <a href="#" data-target="#menu-style6" data-toggle="collapse4"><i class="fas fa-headphones"></i>
                    <span>Support</span></a>

                    <ul class="collapse4 styleClass" id="menu-style6">

                        <li class="">
                        
                            <a href="<?php echo base_url();?>index.php/admin/Support/index">
                                <i class="fas fa-headphones"></i>
                                <span> Buyers </span>
                            </a>
                                        
                        </li>
                        <li class="mt-2">                        
                            <a href="<?php echo base_url();?>index.php/admin/Support/travelerSupport">
                                <i class="fas fa-headphones"></i>
                                <span> Traveler </span>
                            </a>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->
</div>