<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<footer class="footer text-right">
                    2017 - 2018 © SYILVIA WINDY KHARISMA PUTRI
                </footer>
            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->
        <!-- jQuery  -->
        <script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
        <script src="<?php echo base_url('assets/js/popper.min.js')?>"></script><!-- Popper for Bootstrap -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
        <script src="<?php echo base_url('assets/js/metisMenu.min.js')?>"></script>
        <script src="<?php echo base_url('assets/js/waves.js')?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.slimscroll.js')?>"></script>

        <!-- Required datatable js -->
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap4.min.js');?>"></script>
        <!-- Buttons examples -->
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.buttons.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/buttons.bootstrap4.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/jszip.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/pdfmake.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/vfs_fonts.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/buttons.html5.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/buttons.print.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/buttons.colVis.min.js');?>"></script>
        <!-- Responsive examples -->
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.responsive.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/responsive.bootstrap4.min.js');?>"></script>
        <!-- Date Picker and Moment.js -->
        <script src="<?php echo base_url('assets/plugins/moment/moment.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');?>"></script>
        <!-- App js -->
        <script src="<?php echo base_url('assets/js/jquery.core.js')?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.app.js')?>"></script>
        <script>
            $(document).ready(function(){
                jQuery('[name="tglawal"]').datepicker({
                    format: 'dd-MM-yyyy',
                    autoclose: true,
                    todayHighlight: true
                });
                jQuery('[name="tglakhir"]').datepicker({
                    format: 'dd-MM-yyyy',
                    autoclose: true,
                    todayHighlight: true
                });
                jQuery('[name="tanggal"]').datepicker({
                    format: 'dd-MM-yyyy',
                    autoclose: true,
                    todayHighlight: true
                });
            })
        </script>
    </body>
</html>