<select id="product_id" name="product_id" class="form-control select2">
    <option value="">Please Select</option>
    <?php foreach ($product_lists as $product): ?>
        <?php
            $select = '';
            if ($product->foodItemId == $session_product_id) {
                $select = 'selected';
            }
        ?>
        <option value="<?= $product->foodItemId ?>" <?= $select ?>><?= $product->foodItemName ?></option>        
    <?php endforeach ?>
</select>