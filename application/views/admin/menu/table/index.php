<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/table/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Table</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
	    <table class="table table-striped table-bordered dt-responsive list-dt" id="details-table">
	        <thead class="thead-default">
	            <tr>
	                <th width="20px">SL</th>
	                <th width="500px">Table Number</th>
	                <th width="80px">Capacity</th>
	                <th width="80px">Status</th>
	                <th width="50px">Action</th>
	            </tr>
	        </thead>

	        <tbody>
	            <?php $sl = 1 ?>
	            <?php foreach ($table_list as $table): ?>                            
	                <tr>
	                    <td><?= $sl++ ?></td>
	                    <td><?= $table->table_number ?></td>
	                    <td><?= $table->table_capacity ?></td>
	                    <td><?= $table->status == 0 ? 'Vacant' : 'Booked' ?></td>
	                    <td class="text-center">
	                        <a href="<?= base_url("admin/table/edit/$table->id") ?>" class="btn btn-primary btn-sm">
	                            <i class=" fa fa-pencil-square-o" aria-hidden="true"></i>
	                        </a>

	                        <a onclick="return delete_confirm();" href="<?= base_url("admin/table/delete/$table->id") ?>" class="btn btn-danger btn-sm">
	                            <i class="fa fa-times" aria-hidden="true"></i>
	                        </a>
	                    </td>
	                </tr>
	            <?php endforeach ?>
	        </tbody>
	    </table>
    </div>
</div>