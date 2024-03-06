<!-- All JS File  -->

<!-- Jquery -->
<script type="text/javascript" src="<?= base_url('assets/jquery/jquery-1.9.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/jquery/jquery-ui.1.10.4.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/jquery/jquery.validate.min.js') ?>"></script>

<!-- CK Editor -->
<script type="text/javascript" src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/fastclick/lib/fastclick.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/nprogress/nprogress.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/Chart.js/dist/Chart.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/gauge.js/dist/gauge.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/iCheck/icheck.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/skycons/skycons.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/Flot/jquery.flot.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/Flot/jquery.flot.pie.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/Flot/jquery.flot.time.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/Flot/jquery.flot.stack.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/Flot/jquery.flot.resize.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/flot.orderbars/js/jquery.flot.orderBars.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/flot-spline/js/jquery.flot.spline.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/flot.curvedlines/curvedLines.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/DateJS/build/date.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/jqvmap/dist/jquery.vmap.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/jqvmap/dist/maps/jquery.vmap.world.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') ?>"></script>

<!-- Date Time -->
<script type="text/javascript" src="<?= base_url('assets/admin/datepicker/js/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/datepicker/js/daterangepicker.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/datepicker/js/bootstrap-datepicker.js') ?>"></script>

<script type="text/javascript" src="<?= base_url('assets/admin/theme/build/js/custom.js') ?>"></script>

<!-- Color Picker -->
<script type="text/javascript" src="<?= base_url('assets/colorpicker/bootstrap-colorpicker.min.js') ?>"></script>

<!-- Select 2 -->
<script type="text/javascript" src="<?= base_url('assets/vendor/select2-4.0.0/select2.min.js') ?>"></script>

<!-- Sweet Alert -->
<script type="text/javascript" src="<?= base_url('assets/admin/sweetalert2/js/sweetalert2.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url('assets/my_design/admin_design/vendors/bootstrap/dist/js/bootstrap.min.js') ?>"></script>

<!-- Datatables -->
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/datatables.net/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/theme/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')?>"></script>

<!-- FastClick -->
<script type="text/javascript" src="<?= base_url('assets/my_design/admin_design/vendors/fastclick/lib/fastclick.js') ?>"></script>

<!-- NProgress -->
<script type="text/javascript" src="<?= base_url('assets/my_design/admin_design/vendors/nprogress/nprogress.js') ?>"></script>

<!-- jQuery custom content scroller -->
<script type="text/javascript" src="<?= base_url('assets/my_design/admin_design/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') ?>"></script>

<!-- Custom Theme Scripts -->
<script type="text/javascript" src="<?= base_url('assets/admin/theme/build/js/custom.js') ?>"></script>

<!-- Multi Selectable Tree Structure -->
<script type="text/javascript" src="<?= base_url('assets/multi_selectable_tree_structure/jquery.tree-multiselect.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2();
        $('#color').colorpicker();
        $('.list-dt').DataTable({
            "bSort": false,
            "lengthMenu": [[500, 1000, 2000, 5000,-1], [500, 1000, 2000, 5000,"All"]]
        });
    });
    
    toggleFullScreen();
    function toggleFullScreen() {
        $('#turnFullScreen').click(function () {
            var element = document.documentElement;
            if (!IsFullScreenCurrently()) {
                GoInFullscreen(element);
                toggleFullScreen();
            } else {
                GoOutFullscreen();
                toggleFullScreen();
                console.log('click');
            }
        });
    }

    function IsFullScreenCurrently() {
        var full_screen_element = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement || null;
        console.log(full_screen_element);
        // If no element is in full-screen
        if (full_screen_element === null)
            return false;
        else
            return true;
    }

    function GoInFullscreen(element) {
        if (element.requestFullscreen)
            element.requestFullscreen();
        else if (element.mozRequestFullScreen)
            element.mozRequestFullScreen();
        else if (element.webkitRequestFullscreen)
            element.webkitRequestFullscreen();
        else if (element.msRequestFullscreen)
            element.msRequestFullscreen();
    }

    function GoOutFullscreen() {
        if (document.exitFullscreen)
            document.exitFullscreen();
        else if (document.mozCancelFullScreen)
            document.mozCancelFullScreen();
        else if (document.webkitExitFullscreen)
            document.webkitExitFullscreen();
        else if (document.msExitFullscreen)
            document.msExitFullscreen();
    }
</script>
<!-- /side navigation -->