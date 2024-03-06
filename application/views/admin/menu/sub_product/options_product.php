<select id="product_id" name="product_id" class="form-control select2">
    <option value="">Please Select</option>
    <?php if ($product_lists): ?>
        <option value="-1" selected>All</option>
        <?php foreach ($product_lists as $product): ?>
            <option value="<?= $product->foodItemId ?>"><?= $product->foodItemName ?></option>        
        <?php endforeach ?>
    <?php endif ?>
</select>