<style type="text/css">
    table.dataTable.nowrap th, table.dataTable.nowrap td { white-space: normal !important; }
    h3 { margin: 0px; padding: 0px; }
    @media print {
        @page { margin: 0; }
        body { margin: 1.6cm; }
    }
    .feedback-tab { font-family: Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%; }
    .feedback-tab td, .feedback-tab th { border: 1px solid #ddd;}
    .feedback-tab td { padding: 8px; }
    .feedback-tab tr:nth-child(even){ background-color: #f2f2f2; }
    .feedback-tab tr:hover { background-color: #ddd; }
    .feedback-tab th { padding-top: 10px; padding-bottom: 3px; text-align: center; background-color: #959595; color: white; }
    .data-div { color: #000; font-weight: 700; }
    .txt-center { text-align: center; }
    .fa-star,.fa-star-half-o { color: #008000; }
    .btn-close { background: #702963; color: #ffffff }
    .btn-close:hover {  color: #ffffff }
    .ratings { margin-bottom: 5px; }
    .progress { margin-bottom: 5px; }
    .progress-bar { background: #008000; }
    .progress-container { padding-bottom: 0px; }
    .progress-label { float: left; padding: 0px 6px; text-align: center; line-height: 20px; }
    .progress-body { padding: 0px 6px; }
    .avg-ratings,.total-posts { font-weight: bold; }
    .avg-ratings { font-size: 60px; color: #008000; margin: 0px; }
    .avg-rating-star { font-size: 20px; }
    .total-posts { font-size: 14px; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
        </div>
    </div>

    <div class="panel-body">
        <div class="ratings"><?php $this->load->view('admin/feedback/reports') ?></div>
    	<div class="list-div"><?php $this->load->view('admin/feedback/list_table') ?></div>
    </div>
</div>

<div class="modal fade view-feedback-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="text-xs-center"  style="font-size:2rem">Feedback</h4>
            </div> -->
            <div class="view-data"></div>
        </div>
    </div>
</div>