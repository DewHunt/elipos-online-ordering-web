<select class="form-control select2 product" name="product_id[]" multiple>
    <option value="">Select Products</option>
    <?php if ($products): ?>
        <option value="all">All</option>
        <?php foreach ($products as $product): ?>
            <option value="<?= $product->foodItemId ?>"><?= $product->foodItemName ?></option>
        <?php endforeach ?>
    <?php endif ?>
</select>