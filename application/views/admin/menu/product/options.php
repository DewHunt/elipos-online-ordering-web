<?php
if ((string) $status === 'list') {
    echo '<option value="', '', '">', 'All', '</option>';
} elseif ((string) $status === 'add_or_update') {
    echo '<option value="', '', '">', 'Please Select', '</option>';
} else {

}
foreach ($product_list_by_parent_category_id as $product) {
    $result = '';
    if ( $product_id ==$product->foodItemId) {
        $result = 'selected="selected"';
    } else {
        $result = '';
    }
    echo '<option ', $result, ' value="', $product->foodItemId, '">', $product->foodItemName, '</option>';
}