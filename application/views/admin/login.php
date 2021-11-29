<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Log In | Flighteno</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Flighteno" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo SURL;?>assets/images/favicon.png">

        <!-- App css -->
       <!-- App css -->
        <link href="<?php echo SURL;?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo SURL;?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo SURL;?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="authentication-bg authentication-bg-pattern d-flex align-items-center">        
        <div class="account-pages w-100 mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mb-4">
                                    <a href="">
                                        <span><img src="<?php echo SURL;?>assets/images/logo.png" alt="" height="50"></span>
                                    </a>
                                </div>

                                <form action="<?php echo base_url();?>index.php/admin/Login/VerifyLogin" method="post" class="pt-2">
                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Email address</label>
                                        <input class="form-control" name="email" type="email" id="emailaddress" required="" placeholder="Enter your email">
                                    </div>

                                    <div class="form-group mb-3">
                                        <!-- <a href="auth-recoverpassword.html" class="text-muted float-right"><small>Forgot your password?</small></a> -->
                                        <label for="password">Password</label>
                                        <input class="form-control" name="password" type="password" required="" id="password" placeholder="Enter your password">
                                    </div>

                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                        <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-success btn-block" type="submit"> Log In </button>
                                    </div>

                                </form>
                                <div class="mt-2"> <?php if($this->session->flashdata('error')) echo $this->session->flashdata('error'); ?></div>
                                <!-- <div class="row mt-3">
                                    <div class="col-12 text-center">
                                        <p class="text-muted mb-0">Don't have an account? <a href="auth-register.html" class="text-dark ml-1"><b>Sign Up</b></a></p>
                                    </div> 
                                </div> -->
                                <!-- end row -->

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <!-- Vendor js -->
        <script src="<?php echo SURL;?>/assets/js/vendor.min.js"></script>    
        <!-- http://18.196.35.17/flighteno-services/assets/js/ -->

        <!-- App js -->
        <script src="<?php echo SURL;?>/assets/js/app.min.js"></script>
        
    </body>
</html>