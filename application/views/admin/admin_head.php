<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Food Portal | Admin</title>

    <!-- Bootstrap -->
    <link href="<?= base_url('assets/my_design/admin_design/vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <!--<link href="<? /*= base_url('assets/my_design/admin_design/vendors/font-awesome/css/font-awesome.min.css') */ ?>"
              rel="stylesheet">-->

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url('assets/my_design/admin_design/vendors/nprogress/nprogress.css') ?>" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="<?= base_url('assets/my_design/admin_design/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') ?>" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="<?= base_url('assets/my_design/admin_design/build/css/custom.min.css') ?>" rel="stylesheet">

    <link type="text/css" href="<?= base_url('assets/admin/my_design_admin/css/style.css') ?>" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato"/>

    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>

    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

    <!--code edit start-->
    <link href="<?= base_url('assets/my_design/admin_design/vendors/iCheck/skins/flat/green.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/my_design/admin_design/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') ?>"
        rel="stylesheet">

    <link href="<?= base_url('assets/my_design/admin_design/vendors/jqvmap/dist/jqvmap.min.css') ?>" rel="stylesheet">
    <!-- <link href="<? base_url('assets/my_design/admin_design/vendors/bootstrap-daterangepicker/daterangepicker.css') ?>" rel="stylesheet"> -->
    <link href="<?= base_url('assets/my_design/admin_design/vendors/bootstrap-daterangepicker/daterangepicker.scss') ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendor/select2-4.0.0/select2.min.css') ?>">

    <script src="<?= base_url('assets/my_design/admin_design/vendors/fastclick/lib/fastclick.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/nprogress/nprogress.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/Chart.js/dist/Chart.min.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/gauge.js/dist/gauge.min.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/iCheck/icheck.min.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/skycons/skycons.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/Flot/jquery.flot.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/Flot/jquery.flot.pie.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/Flot/jquery.flot.time.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/Flot/jquery.flot.stack.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/Flot/jquery.flot.resize.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/flot.orderbars/js/jquery.flot.orderBars.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/flot-spline/js/jquery.flot.spline.min.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/flot.curvedlines/curvedLines.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/DateJS/build/date.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/jqvmap/dist/jquery.vmap.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/jqvmap/dist/maps/jquery.vmap.world.js') ?>"></script>

    <script src="<?= base_url('assets/my_design/admin_design/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/admin/datepicker/css/daterangepicker.css')?>" />
    <script src="<?=base_url('assets/admin/datepicker/js/moment.min.js') ?>"></script>
    <script src="<?=base_url('assets/admin/datepicker/js/daterangepicker.js') ?>"></script>
    <script src="<?= base_url('assets/admin/theme/build/js/custom.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/vendor/select2-4.0.0/select2.min.js') ?>"></script>

    <style type="text/css">
        .select2-container--default .select2-selection--single {
            border: 1px solid #ccc; border-radius: 0px;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ccc;
            border-radius: 0px;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2();

            $('.search-select-multiple').select2({
                // dropdownAutoWidth: true,
                // multiple: true,
                // width: '100%',
                // height: '30px',
                placeholder: "Select",
                // allowClear: true
            });
        });
    </script>
</head>