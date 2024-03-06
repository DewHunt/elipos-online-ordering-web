<?php
if ((string) $status === 'list') {
    echo '<option value="', '', '">', 'All', '</option>';
} elseif ((string) $status === 'add_or_update') {
    echo '<option value="', '', '">', 'Please Select', '</option>';
} else {

}
//echo (int)$category_food_type_id == (int)$food_type->foodTypeId ? 'selected="selected"' : '';
//        if (!empty($category_food_type_id) && ((int) $category_food_type_id > 0)) {
foreach ($food_type_list_by_parent_category_id as $food_type) {
    $result = '';
    if ((int) $category_food_type_id == (int) $food_type->foodTypeId) {
        $result = 'selected="selected"';
    }
    echo '<option ', $result, ' value="', $food_type->foodTypeId, '">', $food_type->foodTypeName, '</option>';
}
//        } else {
//            foreach ($food_type_list_by_parent_category_id as $food_type) {
//                echo '<option value="', $food_type->foodTypeId, '">', $food_type->foodTypeName, '</option>';
//            }
//        }