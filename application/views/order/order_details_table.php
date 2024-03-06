<table class="table" style="width: 100%; border-collapse: collapse;border: 1px solid #7f7f7f" >
    <thead class="">
        <tr style="background-color:#ededed">
            <th style="padding: 10px;text-align: left;border: 1px solid #7f7f7f">Name</th>
            <th style="padding: 10px;border: 1px solid #7f7f7f;text-align: right">Quantity</th>
            <th style="padding: 10px;border: 1px solid #7f7f7f;text-align: right" >Sub Total</th>
        </tr>
    </thead>

    <tbody>
        <?php
            $sub_total = 0;
            $product = new Product();
            $m_order_details = new Order_details_Model();
            $order_id = $order_information->id;
            $order_details = $m_order_details->get_by(array('order_id' => $order_id,'order_deals_id' => 0));
        ?>
        <?php foreach ($order_details as $detail): ?>
            <?php
                $side_dish = $this->Order_side_dish_Model->get_all_by_order_details_id($detail->id);
                $side_dish_description = '';
                $side_dish_total_price = 0;
                $side_dish_id_array = array();
                foreach ($side_dish as $dish) {
                   // $side_dish = $product->get_side_dish_by_id(trim($dish->side_dish_id));
                    if (!empty($dish)) {
                        $side_dish_description .=$dish->side_dish_name.' + ';
                    }
                }
                if (!empty($side_dish)) {
                    $side_dish_description = substr($side_dish_description, 0, -3);
                    $side_dish_description = '( ' . $side_dish_description . ' )';
                }
                $sub_total = ($sub_total + $detail->amount) - $detail->buy_get_amount;
                $item_amount = $detail->amount - $detail->buy_get_amount;
            ?>
            <tr>
                <td style="border: 1px solid #7f7f7f;padding: 5px"><?= $detail->product_name . $side_dish_description?>
                    <?=(!empty($detail->item_comments))?"<br>".$detail->item_comments:''?>
                </td>
                <td align="right" style="border: 1px solid #7f7f7f;padding: 5px"><?= $detail->quantity?></td>
                <td align="right" style="border: 1px solid #7f7f7f;padding: 5px;text-align: right">
                    <?= get_price_text($item_amount, 2)?>
                </td>
            </tr>
        <?php endforeach ?>

        <?php
            $this->load->model('Order_Deals_Model');
            $m_order_deals = new Order_Deals_Model();
            $orderDeals = $m_order_deals->get_by(array('order_id' => $order_id));
            // $newArray = $m_order_deals->getDealsByOrderId($order_id);
        ?>

        <?php if ($orderDeals): ?>
            <?php foreach ($orderDeals as $orderDeal): ?>
                <?php
                    $sub_total += $orderDeal->quantity * $orderDeal->price;
                    $items = $orderDeal->itemsDetails;
                    $items = (!empty($items)) ? json_decode($items,true) : null;
                ?>
                <tr>
                    <td style="border: 1px solid #7f7f7f;padding: 5px">
                        <?= $orderDeal->title ?>
                        <?php if ($items): ?>
                            <?php $itemSl = 0; ?>
                            <?php foreach ($items as $item): ?>
                                <?php
                                    // dd($item['isHalfDeal']);
                                    $itemProducts = $item['itemProducts'];
                                    $item_title = ++$itemSl.' '.$item['title'];
                                ?>
                                <?php if (isset($item['isHalfDeal'])): ?>
                                    <?php if ($item['isHalfDeal'] == false): ?>
                                        <br><strong style="padding-left: 10px"><?= $item_title ?></strong>
                                    <?php endif ?>
                                <?php else: ?>
                                    <br><strong style="padding-left: 10px"><?= $item_title ?></strong>
                                <?php endif ?>
                                <?php if ($itemProducts): ?>
                                    <?php $productSl = 1; ?>
                                    <?php foreach ($itemProducts as $itemProduct): ?>
                                        <?php
                                            $subProduct = $itemProduct['subProduct'];
                                        ?>
                                        <?php if (isset($item['isHalfDeal']) && $item['isHalfDeal'] == true): ?>
                                            <?php if (isset($itemProduct['portion']) && !empty($itemProduct['portion'])): ?>
                                                <br><strong style="padding-left: 10px"><?= $itemProduct['portion'] ?></strong>
                                            <?php endif ?>
                                        <?php endif ?>
                                        <br>
                                        <strong>
                                            <span style="padding-left: 30px">
                                                <?php
                                                    if ($subProduct) {
                                                        echo $subProduct['selectiveItemName'];
                                                    } else {
                                                        $product = $itemProduct['product'];
                                                        if ($product) {
                                                            echo $product['foodItemName'];
                                                        }
                                                    }
                                                    $productSl++;
                                                    $modifiers = $itemProduct['modifiers'];
                                                ?>
                                            </span>
                                        </strong>
                                        <?php if ($modifiers): ?>
                                            <?php $modifierSl = 1; ?>
                                            <?php foreach ($modifiers as $modifier): ?>
                                                <?php
                                                    $modifier_title = $modifier['SideDishesName'].' ('.$modifier['UnitPrice'].' X '.$modifier['quantity'].')';
                                                ?>
                                                <br>
                                                <strong style="font-size: 10px;padding-left: 55px;font-weight: 700"><?= $modifier_title ?></strong>                                               
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endif ?>
                    </td>
                    <td align="right" style="border: 1px solid #7f7f7f; padding: 5px"><?= $orderDeal->quantity?></td>
                    <td align="right" style="border: 1px solid #7f7f7f; padding: 5px; text-align: right">
                        <?= get_price_text($orderDeal->price * $orderDeal->quantity)?>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>

        <?php
            $tips_amount = $order_information->tips;
            $order_total = $order_information->order_total;
            $discount = $order_information->discount;
            $delivery_charge = $order_information->delivery_charge;
            // $net_total=$order_total+$delivery_charge;
            $surcharge = $order_information->surcharge;
            $service_charge = $order_information->service_charge;
            $packaging_charge = $order_information->packaging_charge;
        ?>
        <tr>
            <td colspan="2" align="right" style="border: none;padding: 5px">Total Amount:</td>
            <td align="right" style="border: none;padding: 5px"><?= get_price_text($sub_total, 2) ?></td>
        </tr>

        <?php if ($discount > 0): ?>
            <tr>
                <td colspan="2" align="right" style="border: none;padding: 5px">Discount:</td>
                <td align="right" style="border: none;padding: 5px"><?= get_price_text($discount, 2) ?></td>
            </tr>
        <?php endif ?>

        <?php if ($service_charge > 0): ?>            
            <tr>
                <td colspan="2" align="right" style="border: none;padding: 5px">Service Charge:</td>
                <td align="right" style="border: none;padding: 5px"><?= get_price_text($service_charge, 2) ?></td>
            </tr>
        <?php endif ?>

        <?php if ($packaging_charge > 0): ?>
            <tr>
                <td colspan="2" align="right" style="border: none;padding: 5px">Parcel Box:</td>
                <td align="right" style="border: none;padding: 5px"><?= get_price_text($packaging_charge, 2) ?></td>
            </tr>
        <?php endif ?>

        <?php if ($surcharge > 0): ?>
            <tr>
                <td colspan="2" align="right" style="border: none;padding: 5px">Card Fee:</td>
                <td align="right" style="border: none;padding: 5px"><?= get_price_text($surcharge, 2) ?></td>
            </tr>
        <?php endif ?>

        <?php if ($delivery_charge > 0): ?>
            <tr>
                <td colspan="2" align="right" style="border: none;padding: 5px">Delivery Charge:</td>
                <td align="right" style="border: none;padding: 5px"><?= get_price_text($delivery_charge, 2) ?></td>
            </tr>
        <?php endif ?>

        <?php if ($tips_amount > 0): ?>
            <tr>
                <td colspan="2" align="right" style="border: none;padding: 5px">Tips:</td>
                <td align="right" style="border: none;padding: 5px"><?= get_price_text($tips_amount, 2) ?></td>
            </tr>
        <?php endif ?>

        <tr>
            <td colspan="2" align="right" style="border: none; padding: 5px">Amount To Pay:</td>
            <td align="right" style="border: none; padding: 5px"><?= get_price_text($order_total, 2) ?></td>
        </tr>
    </tbody>
</table>