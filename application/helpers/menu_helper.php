<?php
function get_root_menu_list($user_role_id = 0,$menu_permission = false) {
    $these = &get_instance();
    $query = get_query_for_menu($user_role_id,$menu_permission);
    $result = $these->db->query("SELECT * FROM `menus` WHERE $query `parent_menu` IS NULL AND `status` = 1 ORDER BY `order_by` ASC")->result();
    return $result;
}

function get_menu_list($menu_id,$user_role_id = 0,$menu_permission = false) {
    $these = &get_instance();
    $query = get_query_for_menu($user_role_id,$menu_permission);
    $result = $these->db->query("SELECT * FROM `menus` WHERE $query `parent_menu` = $menu_id AND `status` = 1 ORDER BY `order_by` ASC")->result();
    return $result;
}

function get_query_for_menu($user_role_id = 0,$menu_permission = false) {
    $these = &get_instance();
    $query = "";
    if ($user_role_id > 0 && $menu_permission === true) {
        $user_role_info = $these->User_role_model->get_user_role_by_id($user_role_id);
        if ($user_role_info->role != 1) {
            $permission = empty($user_role_info->menu_permission) ? 1 : $user_role_info->menu_permission;         
            $query = "`id` IN ($permission) AND";
        }
    }
    return $query;
}

function checke_menu_permission($menu_id,$menu_permission) {
    $checked = "";
    if (in_array($menu_id,$menu_permission)) { 
        $checked = "checked";
    }
    return $checked;
}