<?php
if ((string) $status === 'list') {
    echo '<option value="', '', '">', 'All', '</option>';
} elseif ((string) $status === 'add_or_update') {
    echo '<option value="', '', '">', 'Please Select', '</option>';
} else {

}
foreach ($category_list_by_food_type_id as $category) {
    $result = '';
    if ((int) $product_category_id == (int) $category->categoryId) {
        $result = 'selected="selected"';
    } else {
        $result = '';
    }
    echo '<option ', $result, ' value="', $category->categoryId, '">', $category->categoryName, '</option>';
}