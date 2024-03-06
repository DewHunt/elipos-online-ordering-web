<style type="text/css">
    .css-content { height: 460px; overflow: auto; }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right" style="display: none;">
                <a href="<?= base_url('admin/page_management/add_page_design') ?>" class="btn btn-success">
                    <i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;Add Page Design
                </a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="design-list">
            <?= $this->load->view('admin/page_settings/page_design/list',$this->page_content_data['all_design'],true); ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="designModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <h4 class="modal-title">CSS Content</h4>
            </div> -->
            <div class="modal-body">
                <div class="css-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>