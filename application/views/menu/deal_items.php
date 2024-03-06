<?php // dd($deals_items); ?>
<div id="accordion" role="tablist" aria-multiselectable="true">
    <div class="list-item">
        <?php if (!empty($deals_items)): ?>
            <?php foreach ($deals_items as $key => $item): ?>
                <?php if (!is_array($item)) { $item = (array) $item; } ?>

                <div class="card deal-block">
                    <div class="card-header" role="tab" id="item<?= $item['id'] ?>">
                        <h5 class="mb-0">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $key ?>" aria-expanded="true" aria-controls="collapseOne">
                                <?php if (count($deals_items) > 1) { echo ($key + 1).'. '; } ?>
                                <?= $item['title']." (".$item['limit'].")" ?>
                            </a>
                        </h5>
                    </div>

                    <div class="card-body deal-item-body">
                        <div id="collapse<?= $key ?>" class="collapse" role="tabpanel" aria-labelledby="">
                            <div class="card-block" style="padding-top: 0">
                                <?php
                                    $productIds = $item['productIds'];
                                    $subProductIds = $item['subProductIds'];
                                    $subProductAsModifierLimit = $item['subProductAsModifierLimit'];
                                    $productAsModifierLimit = $item['productAsModifierLimit'];
                                    $productIds = (!empty($productIds)) ? json_decode($productIds,true) : array();
                                    $subProductIds = (!empty($subProductIds)) ? json_decode($subProductIds,true) : array();
                                    $productAsModifierLimit = (!empty($productAsModifierLimit)) ? json_decode($productAsModifierLimit,true) : array();
                                    $subProductAsModifierLimit = (!empty($subProductAsModifierLimit)) ? json_decode($subProductAsModifierLimit,true) : array();
                                    $subProductAsModifierLimit = (!empty($subProductAsModifierLimit)) ? array_column($subProductAsModifierLimit,'limit','id') : array();
                                    $productAsModifierLimit = (!empty($productAsModifierLimit)) ? array_column($productAsModifierLimit,'limit','id') : array();

                                    $data_array = array(
                                        'productIds' => $productIds,
                                        'subProductIds' => $subProductIds,
                                        'productAsModifierLimit' => $productAsModifierLimit,
                                        'subProductAsModifierLimit' => $subProductAsModifierLimit,
                                        'item' => $item,
                                        'itemLimit' => $item['limit'],
                                        'dealId' => $deal->id,
                                    );
                                    // echo "<pre>"; print_r($data_array); exit();
                                    $product_block = $this->load->view('menu/products_selection',$data_array,true);

                                    echo $product_block;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>

