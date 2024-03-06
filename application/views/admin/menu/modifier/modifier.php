<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4>Modifier List</h4></div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info btn-md" href="<?= base_url('admin/modifier/assign_modifier') ?>"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Assign Modifier</a>
                <a class="btn btn-info btn-md" href="<?= base_url('admin/modifier/add_modifier') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Modifier</a>
            </div>
        </div>
        
    </div>

    <div class="panel-body">
        <div class="modifier-form-div"><?= $modifier_form_div ?></div>

        <div class="modifier-list-div"><?= $modifier_list_table ?></div>
    </div>
</div>


