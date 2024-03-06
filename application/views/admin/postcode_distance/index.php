<script type="text/javascript" src="<?=base_url('assets/admin/theme/vendors/datatables.net/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/admin/theme/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/admin/theme/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')?>"></script>
<link  href="<?=base_url('assets/admin/theme/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">
<!--<link  href="<?/*=base_url('assets/admin/theme/vendors/datatables.net/css/jquery.dataTables.min.css')*/?>" rel="stylesheet">-->
<link href="<?=base_url('assets/admin/theme/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')?>" rel="stylesheet">

            <div class="">
                <div class="page-title">
                    <div class="title_left">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>All Postcodes and distances</h2>

                                <?php echo anchor(base_url('admin/postcode_distance/add'), '<i class="fa fa-plus" aria-hidden="true"></i> Add new postcode', 'class="btn btn-info btn-lg right-side-view"') ?>

                                <div class="clearfix"></div>
                            </div>

                            <?php
                            $this->load->view('admin/postcode_distance/table_data',$this->data);
                            ?>
                        </div>
                    </div>
                </div>
            </div>


