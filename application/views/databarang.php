<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
  #kdbarang,#nmbarang{
    display:none
  }
</style>
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
                        <h4 class="page-title float-left">Data Barang</h4>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">Data Barang</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                    <table class="table table-bordered table-striped table-condensed" id="tabelBarang">
                        <thead>
                            <tr>
                                <th width="80px">No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th width="200px">Action</th>
                            </tr>
                        </thead>
			        </table>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
    <div id="modalDataBarang" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Modal Heading</h4>
                </div>
                <div class="modal-body form">
                <form action="" class="form-horizontal">
                    <div class="form-group row">
                        <input type="text" name="idBarang" hidden>
                        <label class="col-form-label col-3" for="">Kode Barang</label>
                        <div class="col-8">
                            <input class="form-control" type="text" name="kodeBarang">
                            <ul class="parsley-errors-list filled" id="kdbarang">
                                <li class="parsley-required">Kode Barang Kosong.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3" for="">Nama Barang</label>
                        <div class="col-8">
                            <input class="form-control" type="text" name="namaBarang">
                            <ul class="parsley-errors-list filled" id="nmbarang">
                                <li class="parsley-required">Nama Barang Kosong.</li>
                            </ul>
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button onClick="update()" type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <?php $this->view('footer'); ?>
    <script>
        let table;
        update = () => {
            if(document.querySelector('[name="namaBarang"]').value === ""){
                $('#nmbarang').show()
            }else if(document.querySelector('[name="kodeBarang"]').value === ""){
                $('#kdbarang').show();
            }else{
                $.ajax({
                    url : "DataBarang/updateBarang",
                    type : "POST",
                    data : $('form').serialize(),
                    dataType : "JSON",
                    success : function(data){
                        if(data.status){
                            $('#modalDataBarang').modal('hide');
                            $('#nmbarang').hide()
                            $('#kdbarang').hide()
                            table.ajax.reload();
                        }
                    }
                })
            }
        }
        hapusBarang = id => {
                if(confirm("Apakah Anda Yakin Akan Menghapus Data Ini")){
                    $.ajax({
                    url : `DataBarang/hapusBarang/${id}`,
                    type: "POST",
                    dataType: "JSON",
                    success : function(data){
                        if(data.status){
                            table.ajax.reload();
                        }
                    }
                  })
                }
            }
        editBarang = id => {
            $('form')[0].reset();
            $('.modal-title').text('Edit Barang');
            $.ajax({
               url : `DataBarang/editBarang/${id}`,
               type : "GET",
               dataType : "JSON",
               success : function(data){
                   console.log(data);
                   $('[name="idBarang"]').val(data.idBarang);
                   $('[name="kodeBarang"]').val(data.kodeBarang);
                   $('[name="namaBarang"]').val(data.namaBarang);
                   $('#nmbarang').hide()
                   $('#kdbarang').hide()
                   $('#modalDataBarang').modal('show');
               }
            });
        }
        $(document).ready(function(){
            table = $('#tabelBarang').DataTable({
                "processing" : true,
                "serverSide" : true,
                "order" : [],
                "ajax" :{
                    "url" : "<?php echo site_url('DataBarang/ajax_list');?>",
                    "type" : "POST"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "orderable": false
                },],
            });
        });		
    </script>
                