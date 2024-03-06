<tr id="rowId_<?= $rowCount ?>">
    <td id="colData_<?= $rowCount ?>">
        <div class="row">
            <div class="col-lg-2">
                <label>Number Of Order</label>
                <div class="form-group">
                    <input class="form-control" type="number" class="numberOfOrder" name="numberOfOrder[]" value="">
                </div>
            </div>

            <div class="col-lg-3">
                <label>Minimum Order Amount</label>
                <div class="form-group">
                    <input class="form-control" type="number" class="minimumOrderAmount" name="minimumOrderAmount[]" value="">
                </div>
            </div>

            <div class="col-lg-3">
                <label>Maximum Discount Amount</label>
                <div class="form-group">
                    <input class="form-control" type="number" class="maximumDiscountAmount" name="maximumDiscountAmount[]" value="">
                </div>
            </div>

            <div class="col-lg-2">
                <label>Offer Type</label>
                <div class="form-group">
                    <?php
                        $offerTypeArray = array('fixed' => 'Fixed','percentage' => 'Percantage','others' => 'Others');
                    ?>
                    <select class="form-control select2 offerType" row-count="<?= $rowCount ?>" name="offerType[]">
                        <option value="">Select Offer Type</option>
                        <?php foreach ($offerTypeArray as $key => $value): ?>
                            <?php
                                if (get_array_key_value('offer_type',$loyalty_program) == $key) {
                                    $select = "selected";
                                } else {
                                    $select = "";
                                }                                                                
                            ?>
                            <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <label>Discount Amount</label>
                <div class="form-group">
                    <input class="form-control" type="number" min="0" step="0.01" class="discountAmount" name="discountAmount[]" value="">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <label>Description</label>
                <div class="form-group">
                    <textarea class="form-control" rows="2" class="description" id="description_<?= $rowCount ?>" name="description[]"></textarea>
                </div>
            </div>
            <input type="hidden" id="statusId_<?= $rowCount ?>" name="status[]" value="add">
            <input type="hidden" id="rowStatusId_<?= $rowCount ?>" name="rowStatus[]" value="old">
        </div>
    </td>
    <td class="text-center" id="colBtn_<?= $rowCount ?>">
        <span class="btn- btn-sm btn-danger" id="removeBtnId_<?= $rowCount ?>" onclick="remove_loyalty_program(<?= $rowCount ?>)">
            <i class="fa fa-trash"></i>
        </span>
        <span class="btn- btn-sm btn-primary" id="restoreBtnId_<?= $rowCount ?>" onclick="restore_loyalty_program(<?= $rowCount ?>)" style="display: none;">
            <i class="fa fa-plus"></i>
        </span>
    </td>
</tr>