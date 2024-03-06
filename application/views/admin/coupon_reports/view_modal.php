<style type="text/css">
    .modal-body { max-height: calc(100vh - 212px); overflow-y: auto }
</style>

<div class="modal fade view-modal" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="text-xs-center"  style="font-size:2rem">Reports Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <table class="table table-condensed table-hover table-bordered info-div">
                            <thead>
                                <tr class="success">
                                    <th class="text-center" width="50px">SL</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center" width="300px">Email</th>
                                    <th class="text-center" width="150px">Mobile</th>
                                    <th class="text-center" width="100px">Total Used Up</th>
                                </tr>
                            </thead>
                            <?php if ($details_info): ?>                        
                                <tbody>
                                    <?php
                                        $sl = 1;
                                        $total_used = 0;
                                    ?>
                                    <?php foreach ($details_info as $info): ?>
                                        <?php
                                            $total_used += $info->total_coupon_usages;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $sl++ ?></td>
                                            <td><?= $info->customer_name ?></td>
                                            <td class="text-center"><?= $info->email ?></td>
                                            <td class="text-center"><?= $info->mobile ?></td>
                                            <td class="text-right"><?= $info->total_coupon_usages ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">Total</th>
                                        <th class="text-right"><?= $total_used ?></th>
                                    </tr>
                                </tfoot>
                            <?php else: ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-center">Information Not Found</td>
                                    </tr>
                                </tfoot>
                            <?php endif ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>