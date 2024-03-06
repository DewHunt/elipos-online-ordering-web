<form method="POST" enctype="multipart/form-data" action="<?= base_url('admin/postcode/upload_excel_file') ?>" >
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<div class="form-group">
				<input class="form-control" type="file" id="excel_file" name="excel_file">
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right">
			<div class="form-group">
				<input class="btn btn-primary btn-md" type="submit" id="do-upload-excel-file" value="Upload">
				<span type="button" class="btn btn-default" data-dismiss="modal">Close</span>
			</div>
		</div>
	</div>
</form>