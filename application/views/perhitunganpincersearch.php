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
                        <h4 class="page-title float-left">Perhitungan PincerSearch</h4>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">PincerSearch</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <form class="form-horizontal" action="">
                            <div class="form-group row">
                                <label for="tglawal" class="col-form-label col-2">Tanggal Awal</label>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="tglawal">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tglakhir" class="col-form-label col-2">Tanggal Akhir</label>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="tglakhir">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="minsupport" class="col-form-label col-2">Min Support</label>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="minsupport">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="minconfidence" class="col-form-label col-2">Min Confidence</label>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="minconfidence">
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Hitung</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
                