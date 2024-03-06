<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Food Portal | Admin</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/theme/vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/css/animate.min.css') ?>" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/theme/vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
        <!-- <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/css/font-awesome.min.css') ?>" rel="stylesheet"> -->
        <!-- <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"> -->
        <!-- NProgress -->
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/theme/vendors/nprogress/nprogress.css') ?>" rel="stylesheet">
        <!-- jQuery custom content scroller -->
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/theme/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') ?>" rel="stylesheet"/>
        <!-- Custom Theme Style -->
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/theme/build/css/custom.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/css/style.css') ?>" rel="stylesheet"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/css/family-lato.css') ?>" rel="stylesheet"/>
        <!-- <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato"/> -->
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/css/jquery-ui.css') ?>" rel="stylesheet"/>
        <!-- <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet"> -->
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendor/select2-4.0.0/select2.min.css') ?>">
        <!--code edit start-->
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/theme/vendors/iCheck/skins/flat/green.css') ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/theme/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/theme/vendors/jqvmap/dist/jqvmap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/theme/vendors/bootstrap-daterangepicker/daterangepicker.css') ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/colorpicker/bootstrap-colorpicker.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/datepicker/css/daterangepicker.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/sweetalert2/css/sweetalert2.min.css') ?>" />

        <!-- <link rel="stylesheet" type="text/css" href="<? base_url('assets/admin/theme/vendors/bootstrap-daterangepicker/daterangepicker.css') ?>" rel="stylesheet"> -->

        <!-- All JS File  -->
        <script src="<?= base_url('assets/jquery/jquery-1.9.1.min.js'); ?>"></script>
        <script src="<?= base_url('assets/jquery/jquery-ui.1.10.4.js'); ?>"></script>

        <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
        <!-- <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->

        <script src="<?= base_url('assets/jquery/jquery.validate.min.js') ?>"></script>
        <!-- <script src="<?= base_url('assets/admin/js/ckeditor.js') ?>"></script> -->
        <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>       
        <script src="<?= base_url('assets/admin/theme/vendors/fastclick/lib/fastclick.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/nprogress/nprogress.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/Chart.js/dist/Chart.min.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/gauge.js/dist/gauge.min.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/iCheck/icheck.min.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/skycons/skycons.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/Flot/jquery.flot.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/Flot/jquery.flot.pie.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/Flot/jquery.flot.time.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/Flot/jquery.flot.stack.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/Flot/jquery.flot.resize.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/flot.orderbars/js/jquery.flot.orderBars.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/flot-spline/js/jquery.flot.spline.min.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/flot.curvedlines/curvedLines.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/DateJS/build/date.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/jqvmap/dist/jquery.vmap.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/jqvmap/dist/maps/jquery.vmap.world.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') ?>"></script>
        <script src="<?= base_url('assets/admin/datepicker/js/moment.min.js') ?>"></script>
        <script src="<?= base_url('assets/admin/datepicker/js/daterangepicker.js') ?>"></script>
        <script src="<?= base_url('assets/admin/theme/build/js/custom.js') ?>"></script>
        <script src="<?= base_url('assets/vendor/select2-4.0.0/select2.min.js') ?>"></script>
        <script src="<?= base_url('assets/colorpicker/bootstrap-colorpicker.min.js') ?>"></script>
        <script src="<?= base_url('assets/admin/sweetalert2/js/sweetalert2.min.js') ?>"></script>

        <!-- <script type="text/javascript" src="<?= base_url('assets/colorpicker/main.js') ?>"></script> -->

        <style type="text/css">
            .select2-container--default .select2-selection--single { border: 1px solid #ccc; border-radius: 0px; }
            .select2-container--default .select2-selection--multiple { border: 1px solid #ccc; border-radius: 0px; }
        </style>

        <script type="text/javascript">
            $(document).ready(function () {
                $('.select2').select2();
                $('#color').colorpicker();
            });
        </script>
    </head>

    <body class="nav-md footer_fixed" style="font-family: 'Lato';">
    <!-- <body class="nav-md login fixed_footer" style="font-family: 'Lato';"> -->