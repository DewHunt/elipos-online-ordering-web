<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
        	<input class="form-control" type="hidden" name="image_directory" id="image-directory" value="assets/test_images/">
            <span class="btn btn-primary btn-md btn-block" id="btn-show-images"><i class="fa fa-check-square-o" aria-hidden="true"></i> Select Image</span>
        </div>
    </div>
</div>

<div class="modal fade" id="imageModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">All Images</h4>
            </div>
            <div class="modal-body">
                <div id="images-manager-div"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btn-save-image" data-dismiss="modal" image>Okay</button>
            </div>
        </div>
    </div>
</div>