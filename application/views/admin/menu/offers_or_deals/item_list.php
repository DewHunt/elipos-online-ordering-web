<?php // dd($deals_items); ?>
<style type="text/css">
    .pan-mb { margin-bottom: 5px; }
</style>

<div id="accordion" role="tablist" aria-multiselectable="true">
    <div class="list-item">
        <?php if ($deals_items): ?>
            <?php foreach ($deals_items as $key => $item): ?>
                <?php
                    if (!is_array($item)) {
                        $item = (array) $item;
                    }
                ?>
                <div class="panel panel-default pan-mb">
                    <div class="panel-heading" role="tab">
                        <span class="pull-right btn btn-sm btn-danger remove-item" data-key="<?= $key ?>" style="cursor: pointer"><i class="fa fa-times"></i></span>
                        <span class="pull-right btn btn-sm btn-success edit-item" data-key="<?= $key ?>" style="cursor: pointer"><i class="fa fa-pencil-square-o"></i></span>
                        <h5>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $key ?>" aria-expanded="true" aria-controls="collapseOne">
                                <?php echo ($key + 1).'. &nbsp;'.$item['title'].' ('.$item['limit'].') ' ?>
                            </a>
                        </h5>
                    </div>

                    <div id="collapse<?= $key ?>" class="collapse" role="tabpanel" aria-labelledby="">
                        <div class="panel-body">
                            <?php
                                $productIds = $item['productIds'];
                                $subProductIds = $item['subProductIds'];
                                $productIds = (!empty($productIds)) ? json_decode($productIds,true) : array();
                                $subProductIds = (!empty($subProductIds)) ? json_decode($subProductIds,true) : array();
                                $productAsModifierLimit = $item['productAsModifierLimit'];
                                $subProductAsModifierLimit = $item['subProductAsModifierLimit'];
                                $productAsModifierLimit = (!empty($productAsModifierLimit)) ? json_decode($productAsModifierLimit,true) : array();
                                $subProductAsModifierLimit = (!empty($subProductAsModifierLimit)) ? json_decode($subProductAsModifierLimit,true) : array();
                                $data_array = array(
                                    'productIds' => $productIds,
                                    'subProductIds' => $subProductIds,
                                    'productAsModifierLimit' => $productAsModifierLimit,
                                    'subProductAsModifierLimit' => $subProductAsModifierLimit,
                                    'item_index' => $key,
                                );
                                $product_block = $this->load->view('admin/menu/offers_or_deals/item_products',$data_array,true);
                                echo $product_block;
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>

