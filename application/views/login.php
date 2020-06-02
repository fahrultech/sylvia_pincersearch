<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>PincerSearch - Penerapan Market Basket Analisis</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico');?>">

        <!-- App css -->
        <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/icons.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/metismenu.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/style.css')?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/js/modernizr.min.js');?>"></script>
        <style>
         body.bg-accpunt-pages{
             background : #64c5b1!important;
         }
         .btn-login{
             background-color : #64c5b1!important;
             border : 1px solid #64c5b1!important;
             color : #f1f1f1!important;
         }
        </style>
    </head>
    <body class="bg-accpunt-pages">
        <!-- HOME -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="wrapper-page">
                            <div class="account-pages">
                                <div class="account-box">
                                    <div class="account-logo-box">
                                        <h2 class="text-uppercase text-center">
                                           Sign In
                                        </h2>
                                        
                                    </div>
                                    <div class="account-content">
                                        <form method="post" class="form-horizontal" action="<?php echo base_url('login/proses');?>">
                                            <div class="row">	
                                                 <div class="col-12">
                                                 <?php
			                                        // Validasi error, jika username atau password tidak cocok
			                                        if (validation_errors() || $this->session->flashdata('result_login')) {
		                                          ?>
			                                     <div class="alert alert-danger animated fadeInDown" role="alert">
					                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
					                                  <strong>Peringatan!</strong>
					                                  <?php 
						                               // Menampilkan error
						                               echo validation_errors(); 
						                               // Session data users 
					                                   echo $this->session->flashdata('result_login'); ?>
			                                     </div> 
		                                         <?php 
			                                       } 
                                                 ?>
                                                 </div>		
                                            </div>
                                            <div class="form-group m-b-20 row">
                                                <div class="col-12">
                                                    <label for="emailaddress">Username</label>
                                                    <input class="form-control" type="text" name="username" id="username" placeholder="Masukkan username">
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                   <!--  <a href="page-recoverpw.html" class="text-muted pull-right"><small>Forgot your password?</small></a> -->
                                                    <label for="password">Password</label>
                                                    <input class="form-control" type="password" name="password" id="password" placeholder="Masukkan password">
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">

                                                    <div class="checkbox checkbox-success">
                                                       <!--  <input id="remember" type="checkbox" checked="">
                                                        <label for="remember">
                                                            Remember me
                                                        </label> -->
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                    <button class="btn btn-md btn-block btn-login waves-effect waves-light" type="submit">Sign In</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end card-box-->
                        </div>
                        <!-- end wrapper -->
                    </div>
                </div>
            </div>
          </section>
          <!-- END HOME -->
        <script>
            var resizefunc = [];
        </script>
        <!-- jQuery  -->
        <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/popper.min.js');?>"></script><!-- Popper for Bootstrap -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/metisMenu.min.js')?>"></script>
        <script src="<?php echo base_url('assets/js/waves.js');?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.slimscroll.js');?>"></script>

        <!-- App js -->
        <script src="<?php echo base_url('assets/js/jquery.core.js');?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.app.js');?>"></script>

    </body>
</html>