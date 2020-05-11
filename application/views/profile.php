<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title float-left">Edit Profil</h4>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">Edit Profil</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
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
                      <form method="post" action="<?php echo base_url('Profile/simpan');?>" class="form-horizontal">
                        
                        <div class="form-group row">
                          <label for="" class="col-form-label col-2">Nama</label>
                          <div class="col-4">
                            <input hidden type="text" name="id" value="<?php echo $id; ?>">
                            <input name="nama" value="<?php echo $nama; ?>" type="text" class="form-control">
                            <?php echo form_error('nama') ?>  
                        </div>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-form-label col-2">Username</label>
                          <div class="col-4">
                            <input name="username" value="<?php echo $username ?>" type="text" class="form-control">
                            <?php echo form_error('username') ?>  
                        </div>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-form-label col-2">Password Baru</label>
                          <div class="col-4">
                            <input name="password" type="password" class="form-control">
                          </div>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save fa-fw"></i>Simpan</button>
                      </form>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
    <?php $this->view('footer'); ?>
                