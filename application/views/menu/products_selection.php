<?php
    $m_foodItem = new Fooditem_Model();
    $m_selectItem = new Selectionitems_Model();
    $m_show_sidedish = new Showsidedish_Model();
    $products = null;
    $subProducts = null;

    if (!empty($productIds)) {
        $m_foodItem->db->where_in('foodItemId',$productIds);
        $products = $m_foodItem->get_all_products();
    }

    if (!empty($subProductIds)) {
        $m_selectItem->db->where_in('selectionitems.selectiveItemId',$subProductIds);
        $subProducts = $m_selectItem->get_all_sub_products();
    }
?>


<div class="product-selection-block" data-d="<?= $dealId ?>"  data-l="<?= $itemLimit ?>" data-it="<?= $item['id'] ?>">
    <div id="accordion<?= $item['id'] ?>" class="product-selector-accordion" role="tablist" aria-multiselectable="true">
        <span class="total-deal-item-qty-<?= $item['id'] ?>" total-deal-item-qty="0"></span>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <?php $categoryId = $product->categoryId; ?>
                <div class="card product-card">
                    <div role="tab" style="display: flex; padding: 5px;">
                        <div style="display: inline-flex;">
                            <div class="product-selection" data-c="<?= $categoryId ?>" data-p="<?= $product->foodItemId ?>" data-sp="0"></div>
                            <h5 class="mb-0" >
                                <a data-toggle="collapse" data-parent="#accordion<?= $item['id'] ?>" href="#collapse-<?= $product->foodItemId.'-'.$dealId ?>" aria-expanded="true" aria-controls="collapseOne">
                                    <?= $product->foodItemName ?>
                                </a>
                            </h5>
                        </div>
                        <div style="text-align: right; flex: 1; display: none;" class="deal-items-div deal-item-div-<?= $product->foodItemId ?>-0-<?= $dealId ?>">
                            <div style="display: inline-flex;" class="deal-item-qty-div">
                                <span class="dec-btn" deal-product-id="<?= $product->foodItemId ?>" deal-sub-product-id="0">
                                    <img src="<?= base_url('assets/images/minus.png') ?>" style="height: 25px; width: 25px" alt="" title=""/>
                                </span>
                                &nbsp;<span class="item-quantity-<?= $product->foodItemId ?>-0-<?= $dealId ?>" counted-item-qty="1">1</span>&nbsp;
                                <span class="inc-btn" deal-product-id="<?= $product->foodItemId ?>" deal-sub-product-id="0">
                                    <img src="<?= base_url('assets/images/menuplus.png') ?>" style="height: 25px; width: 25px" alt="" title=""/>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                        $assigned_modifier_by_category_id = null;
                        if (!empty($productAsModifierLimit)) {
                            $limit = array_key_exists($product->foodItemId,$productAsModifierLimit) ? $productAsModifierLimit[$product->foodItemId] : 0;
                            if ($limit > 0) {
                                $assigned_modifier_by_category_id = $m_show_sidedish->get_product_assigned_modifiers($categoryId,$product->foodItemId);
                            }
                        }
                    ?>

                    <?php if (!empty($assigned_modifier_by_category_id)): ?>
                        <div id="collapse-<?= $product->foodItemId.'-'.$dealId ?>" class="collapse" role="tabpanel" >
                            <div class="card-block">
                                <div class="modifier-selection-block" data-c="<?= $categoryId ?>" data-p="<?= $product->foodItemId ?>" data-sp="0">
                                    <?php
                                        $this->modifier_data['category_id'] = $categoryId;
                                        $this->modifier_data['product_id'] = $product->foodItemId;
                                        $this->modifier_data['sub_product_id'] = 0;
                                        $this->modifier_data['assigned_modifier_by_category_id'] = $assigned_modifier_by_category_id;
                                        $this->load->view('menu/modifier_selection',$this->modifier_data);
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        <?php endif ?>

        <?php if (!empty($subProducts)): ?>
            <?php foreach ($subProducts as $subProduct): ?>
                <?php $categoryId = $subProduct->categoryId;  ?>

                <div class="card product-card">
                    <div class="" role="tab" style="display: flex; padding: 5px;">
                        <div style="display: inline-flex;">
                            <div class="product-selection" data-c="<?= $categoryId ?>" data-p="<?= $subProduct->foodItemId ?>" data-sp="<?= $subProduct->selectiveItemId ?>">
                            </div>
                            <h5 class="mb-0" >
                                <a data-toggle="collapse" class="" data-parent="#accordion<?=$item['id']?>" href="#collapse-<?=$subProduct->foodItemId.'-'.$subProduct->selectiveItemId.'-'.$dealId?>" aria-expanded="true" aria-controls="collapseOne">
                                    <?= $subProduct->selectiveItemName ?>
                                </a>
                            </h5>
                        </div>

                        <div style="text-align: right; flex: 1; display: none;" class="deal-items-div deal-item-div-<?=$subProduct->foodItemId?>-<?=$subProduct->selectiveItemId?>-<?=$dealId?>">
                            <div style="display: inline-flex;">
                                <span class="dec-btn" deal-product-id="<?= $subProduct->foodItemId ?>"  deal-sub-product-id="<?= $subProduct->selectiveItemId ?>">
                                    <img src="<?= base_url('assets/images/minus.png') ?>" style="height: 25px; width: 25px" alt="" title=""/>
                                </span>
                                &nbsp;<span class="item-quantity-<?= $subProduct->foodItemId ?>-<?= $subProduct->selectiveItemId ?>-<?= $dealId ?>" counted-item-qty="1">1</span>&nbsp;
                                <span class="inc-btn" deal-product-id="<?= $subProduct->foodItemId ?>"  deal-sub-product-id="<?= $subProduct->selectiveItemId ?>">
                                    <img src="<?= base_url('assets/images/menuplus.png') ?>" style="height: 25px; width: 25px" alt="" title=""/>
                                </span>
                            </div>
                        </div>
                    </div>

                    <?php
                        $assigned_modifier_by_category_id = null;
                        if (!empty($subProductAsModifierLimit)) {
                            $limit = array_key_exists($subProduct->selectiveItemId,$subProductAsModifierLimit) ? $subProductAsModifierLimit[$subProduct->selectiveItemId] : 0;
                            if($limit > 0){
                                $assigned_modifier_by_category_id = $m_show_sidedish->get_sub_product_assigned_modifiers($categoryId,$subProduct->foodItemId,$subProduct->selectiveItemId);
                            }
                        }
                    ?>

                    <?php if (!empty($assigned_modifier_by_category_id)): ?>
                        <div id="collapse-<?=$subProduct->foodItemId.'-'.$subProduct->selectiveItemId.'-'.$dealId?>" class="collapse " role="tabpanel" >
                            <div class="card-block">
                                <div class="modifier-selection-block" data-c="<?= $categoryId ?>" data-p="<?= $subProduct->foodItemId ?>" data-sp="<?= $subProduct->selectiveItemId ?>">
                                    <?php
                                        $this->modifier_data['category_id'] = $categoryId;
                                        $this->modifier_data['product_id'] = $subProduct->foodItemId;
                                        $this->modifier_data['sub_product_id'] = $subProduct->selectiveItemId;
                                        $this->modifier_data['assigned_modifier_by_category_id'] = $assigned_modifier_by_category_id;
                                        // $this->load->view('menu/modifier_selection',array('categoryId'=>$categoryId,'assigned_modifier_by_category_id'=>$assigned_modifier_by_category_id));
                                        $this->load->view('menu/modifier_selection',$this->modifier_data);
                                    ?>
                                </div>
                            </div>
                        </div>                        
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>