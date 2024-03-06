<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/menu/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Menu</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
    	<div class="menu-list-div"><?= $menu_list_table ?></div>
    </div>
</div>