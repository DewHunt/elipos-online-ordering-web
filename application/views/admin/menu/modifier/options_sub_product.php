<select id="sub_product_id" name="sub_product_id" class="form-control select2">
    <option value="">Please Select</option>
    <?php foreach ($sub_product_list as $sub_product): ?>
        <?php
            $select = '';
            if ($sub_product->selectiveItemId == $session_sub_product_id) {
                $select = 'selected';
            }
        ?>
        <option value="<?= $sub_product->selectiveItemId ?>" <?= $select ?>><?= $sub_product->selectiveItemName ?></option>        
    <?php endforeach ?>
</select>