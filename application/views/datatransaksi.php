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
                        <h4 class="page-title float-left">Data Transaksi</h4>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">Data Transaksi</li>
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
    <div id="modalDataTransaksi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Modal Heading</h4>
                </div>
                <div class="modal-body form">
                <form action="" class="form-horizontal">
                    <div class="form-group row">
                        <input type="text" name="idTransaksi" hidden>
                        <label class="col-form-label col-3" for="">Tanggal</label>
                        <div class="col-8">
                            <input class="form-control" data="" type="text" name="tanggal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3" for="">No Invoice</label>
                        <div class="col-8">
                            <input class="form-control" type="text" name="noInvoice">
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
        moment.locale("ID");
        let table;
        $('[name="tanggal"]').on('change', function(){
           $(this).attr('data',moment($(this).val()).format("YYYY-MM-DD"));
        })
        update = () => {
            let data = {
                "idTransaksi" : $('[name="idTransaksi"]').val(),
                "tanggal" : $('[name="tanggal"]').attr("data"),
                "noInvoice" : $('[name="noInvoice"]').val()
            }
            $.ajax({
                url : "datatransaksi/updatetransaksi",
                type : "POST",
                data : data,
                dataType : "JSON",
                success : function(data){
                    $('#modalDataTransaksi').modal('hide');
                    table.ajax.reload();
                }

            })
        }
        editTransaksi = id => {
            $('form')[0].reset();
            $.ajax({
                url : `datatransaksi/edittransaksi/${id}`,
                type : "GET",
                dataType : "JSON",
                success : function(data){
                    $('[name="idTransaksi"]').val(data.idTransaksi);
                    $('[name="tanggal"]').val(moment(data.tanggal).format("DD-MMMM-YYYY"));
                    $('[name="tanggal"]').attr("data",data.tanggal);
                    $('[name="noInvoice"]').val(data.noInvoice);
                    $('#modalDataTransaksi').modal('show');
                }
            })
        }
        hapusTransaksi = id => {
            if(confirm("Apakah Anda Yakin Akan Menghapus Data Ini")){
                $.ajax({
                url : `datatransaksi/hapustransaksi/${id}`,
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
        $(document).ready(function(){
            table = $('#tabelTransaksi').DataTable({
                "processing" : true,
                "serverSide" : true,
                "order" : [],
                "ajax" :{
                    "url" : "<?php echo site_url('datatransaksi/ajax_list');?>",
                    "type" : "POST"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "orderable": false
                },],
            });
        });		
    </script>
                
                