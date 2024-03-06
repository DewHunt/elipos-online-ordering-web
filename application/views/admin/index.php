<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('admin/head',$this->data); ?>
    <link  href="<?=base_url('assets/admin/theme/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">
</head>

<body class="nav-md footer_fixed" style="font-family: 'Lato';">
<div class="container body">
    <div class="main_container">
        <?php $this->load->view('admin/navigation',$this->data); ?>

        <!-- page content -->
        <div class="right_col" role="main">
            <?= $page_content ?>
        </div>
        <!-- /page content -->
        
        <?php $this->load->view('admin/footer',$this->data); ?>
    </div>
</div>

<script type="text/javascript" src="<?=base_url('assets/admin/theme/vendors/datatables.net/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/admin/theme/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/admin/theme/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')?>"></script>

<?php  $this->load->view('admin/script_page'); ?>
</body>

</html>