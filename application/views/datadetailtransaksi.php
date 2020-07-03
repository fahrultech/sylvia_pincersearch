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

                        <h4 class="page-title float-left">Data Detail Transaksi</h4>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">Data Detail Transaksi</li>

                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                    <table class="table table-bordered table-striped table-condensed" id="tabelTransaksi">
                        <thead>
                            <tr>
                                <th width="80px">No</th>
                                <th>Tanggal</th>
                                <th>No Invoice</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <!-- <th width="200px">Action</th> -->
                            </tr>
                        </thead>
			        </table>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
    <?php $this->view('footer'); ?>
    <script>
        let table;
        $(document).ready(function(){
            table = $('#tabelTransaksi').DataTable({
                "processing" : true,
                "serverSide" : true,
                "order" : [],
                "ajax" :{
                    "url" : "<?php echo site_url('Datadetailtransaksi/ajax_list');?>",
                    "type" : "POST"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "orderable": false
                },],
            });
        });		
    </script>
                
                