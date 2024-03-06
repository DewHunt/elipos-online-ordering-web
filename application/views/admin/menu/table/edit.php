<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/table') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Table Lists</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form id="add_table_form" action="<?= base_url('admin/table/update') ?>" method="post">
			<input class="form-control" type="hidden" name="table_id" value="<?= $table_info->id ?>">
        	<div class="row">
        		<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
        			<div class="form-group">
        				<label>Table Number</label>
        				<input class="form-control" type="text" id="tablenNumber" name="tablenNumber" value="<?= $table_info->table_number ?>">
        			</div>
        		</div>

        		<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
        			<div class="form-group">
        				<label>Table Capacity</label>
        				<input class="form-control" type="number" min="1" id="tableCapacity" name="tableCapacity" value="<?= $table_info->table_capacity ?>">
        			</div>
        		</div>

        		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right">
        			<button class="btn btn-primary btn-block" style="margin-top: 24px;"><i class="fa fa-save"></i>&nbsp;Update</button>
        		</div>
        	</div>
        </form>
    </div>
</div>