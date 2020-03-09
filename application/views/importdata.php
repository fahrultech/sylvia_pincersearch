<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<style>
    
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
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 style="text-align:center">Import File</h4>
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
                            <input name="file" type="file" id="file" required accept=".xls, .xlsx">
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
<script>
$('.sk-fading-circle').hide();
$(document).ready(function(){
    $('.jumlahRow').hide();
    $('#importbarang').on('submit', function(event){
		event.preventDefault();
		$.ajax({
			url:"importData/import",
			method:"POST",
			data:new FormData(this),
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
                $('#file').val('');
				alert(data);
			},
            error: function(request, status, error){
                alert(error);
            }
		})
	});
})
</script>