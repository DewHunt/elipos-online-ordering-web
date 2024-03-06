<?php
echo sprintf('<option value="" >%s</option>','Please Select');

foreach ($sub_product_list_by_product_id as $sub_product) {
    $result = '';
    if ( $sub_product_id ==$sub_product->selectiveItemId) {
        $result = 'selected="selected"';
    } else {
        $result = '';
    }

    echo sprintf('<option value="%d" %s>%s</option>',$sub_product->selectiveItemId,$result,$sub_product->selectiveItemName);
}