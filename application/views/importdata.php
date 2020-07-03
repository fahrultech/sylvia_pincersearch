<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<style>
#dm,#dtm,#trm,#trtm,#dtmm{
    display:none
}
</style>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title float-left">Import Data</h4>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">Import Data</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="mb-4" style="text-align:center">Import File</h4>
                        <div style="margin:auto" class="col-5">
                          <div class="dm" style="text-align:center">
                            <div class="alert barangmasuk alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                               Barang Masuk <span class="jumlahBarangMasuk"></span> pcs
                            </div>
                          </div>
                          <div class="dtm" style="text-align:center">
                            <div class="alert barangtidakmasuk alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                               Barang Tidak Masuk <span class="jumlahBarangTidakMasuk"></span> pcs
                            </div>
                          </div>
                          <div class="trm" style="text-align:center">
                            <div class="alert barangtidakmasuk alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                               Transaksi Masuk <span class="transaksiMasuk"></span> pcs
                            </div>
                          </div>
                          <div class="trtm" style="text-align:center">
                            <div class="alert barangtidakmasuk alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                               Transaksi Tidak Masuk <span class="transaksiTidakMasuk"></span> pcs
                            </div>
                          </div>
                          <div class="dtmm" style="text-align:center">
                            <div class="alert barangkosong alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                               File Tidak Ada
                            </div>
                          </div>
                        </div>
                        <form method="post" id="importbarang" enctype="multipart/form-data">
                            <div style="text-align:center" class="jumlahRow">
                            <div class="progress m-b-20">
                                <div class="progress-bar" role="progressbar"  aria-valuenow="50%" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            </div>
                            <div class="sk-fading-circle">
                            <div class="sk-circle1 sk-circle"></div>
                            <div class="sk-circle2 sk-circle"></div>
                            <div class="sk-circle3 sk-circle"></div>
                            <div class="sk-circle4 sk-circle"></div>
                            <div class="sk-circle5 sk-circle"></div>
                            <div class="sk-circle6 sk-circle"></div>
                            <div class="sk-circle7 sk-circle"></div>
                            <div class="sk-circle8 sk-circle"></div>
                            <div class="sk-circle9 sk-circle"></div>
                            <div class="sk-circle10 sk-circle"></div>
                            <div class="sk-circle11 sk-circle"></div>
                            <div class="sk-circle12 sk-circle"></div>
                        </div>
                            <div style="text-align:center;margin-top:40px">
                                <input name="file" type="file" id="file" accept=".xls, .xlsx">
                                <button class="btn btn-sm btn-primary" type="submit">Simpan</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
    <script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.form.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/parsleyjs/parsley.min.js')?>"></script>

<script>
$('.sk-fading-circle').hide();
$('.dm').hide();
$('.dtm').hide();
$('.trm').hide();
$('.trtm').hide();
$('.dtmm').hide();
$(document).ready(function(){
    $('.jumlahRow').hide();
    $('#importbarang').on('submit', function(event){
		event.preventDefault();
        if($('input[name="file"]').get(0).files.length === 0){
            $('.dtmm').show();
        }else{
           $.ajax({
			url:"Importdata/import",
			method:"POST",
			data:new FormData(this),
            dataType: "JSON",
			contentType:false,
			cache:false,
			processData:false,
            beforeSend:function(){
                $('.sk-fading-circle').show();
            },
            complete : function(){
                $('.sk-fading-circle').hide();
            },
			success:function(data){
                console.log(data);
                $('#file').val('');
                $('.dm').show();
                $('.dtm').show();
                $('.trm').show();
                $('.trtm').show();
                $('.dtmm').hide();
                $('.jumlahBarangMasuk').text(data[0].barangMasuk);
                $('.jumlahBarangTidakMasuk').text(data[0].barangTidakMasuk);
                $('.transaksiMasuk').text(data[1].trMasuk);
                $('.transaksiTidakMasuk').text(data[1].trTidakMasuk);
                $('.barangmasuk').addClass('show');
                $('.barangtidakmasuk').addClass('show');
			},
            error: function(request, status, error){
                alert(error);
            }
		})
        }
		
	});
})
</script>