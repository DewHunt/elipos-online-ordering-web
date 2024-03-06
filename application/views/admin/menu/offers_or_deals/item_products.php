<?php
    $m_foodItem = new Fooditem_Model();
    $m_selectItem = new Selectionitems_Model();
    $products = null;
    if ($productIds) {
        $m_foodItem->db->where_in('foodItemId',$productIds);
        $products = $m_foodItem->get_all_products();
    }
    $subProducts = null;
    if ($subProductIds) {
        $m_selectItem->db->where_in('selectiveItemId',$subProductIds);
        $subProducts = $m_selectItem->get_all_sub_products();
    }
?>

<table class="table table-bordered product">
    <thead>
        <th>Name</th>
        <th width="100px">Modifier Limit</th>
        <th width="100px" class="text-center action-col">Action</th>
    </thead>
    <?php
        $productAsModifierLimit = (!empty($productAsModifierLimit)) ? array_column($productAsModifierLimit,'limit','id') : array();
        $subProductAsModifierLimit = (!empty($subProductAsModifierLimit)) ? array_column($subProductAsModifierLimit,'limit','id') : array();
        // dd($item_index);
    ?>

    <tbody>
        <?php if ($products): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product->foodItemName ?></td>
                    <td class="text-right">
                        <?= array_key_exists($product->foodItemId,$productAsModifierLimit) ? $productAsModifierLimit[$product->foodItemId] : 0 ?>
                    </td>
                    <td class="text-center action-col">
                        <span class="btn btn-sm btn-danger remove-modifier-item" item-index="<?= $item_index ?>" item-id="<?= $product->foodItemId ?>" item-cat="productAsModifierLimit,productIds" style="cursor: pointer">
                            <i class="fa fa-times"></i>
                        </span>
                    </td>
                </tr>
            <?php endforeach ?>                
        <?php endif ?>

        <?php if ($subProducts): ?>
            <?php foreach ($subProducts as $subProduct): ?>                    
                <tr>
                    <td><?= $subProduct->selectiveItemName ?></td>
                    <td class="text-right">
                        <?= array_key_exists($subProduct->selectiveItemId,$subProductAsModifierLimit) ? $subProductAsModifierLimit[$subProduct->selectiveItemId] : 0 ?>
                    </td>
                    <td class="text-center action-col">
                        <span class="btn btn-sm btn-danger remove-modifier-item" item-index="<?= $item_index ?>" item-id="<?= $subProduct->selectiveItemId ?>" item-cat="subProductAsModifierLimit,subProductIds" style="cursor: pointer">
                            <i class="fa fa-times"></i>
                        </span>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>
