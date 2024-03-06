<?php

class Desktop_data extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->model('Settings_Model');
        $this->load->model('Category_Model');
        $this->load->model('Parentcategory_Model');
        $this->load->model('Fooditem_Model');
        $this->load->model('Foodtype_Model');
        $this->load->model('Selectionitems_Model');
        $this->load->model('Sidedishes_Model');
        $this->load->model('Modifier_Category_Model');
        $this->load->model('Showsidedish_Model');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Content-Type: application/json");
    }

    public function index() {
        $name = 'desktop_data';
        if (isset($_POST['data'])) {
            $data['value'] = $_POST['data'];
            if ((!empty($data['value'])) || ($data['value'] != null)) {
                $data['name'] = $name;
                $is_save = false;
                if (empty($this->get_desktop_data_form_settings())) {
                    $is_save = $this->Settings_Model->save($data);
                } else {
                    $this->Settings_Model->where_column = 'name';
                    $is_save = $this->Settings_Model->save($data, $name);
                }
                if ($is_save) {
                    $array_data = json_decode($this->get_desktop_data_form_settings());
                    $this->save_category_list($array_data);
                    $this->save_parentCategory_list($array_data);
                    $this->save_fooditem_list($array_data);
                    $this->save_food_types_list($array_data);
                    //$this->save_fooditem_list($array_data);
                    $this->save_selection_items_list($array_data);
                    $this->save_side_dishes_entity_list($array_data);
                    echo 'yes';
                } else {
                    echo 'no';
                }
            } else {
                echo 'no';
            }
        }
    }

    private function save_modifier_categoryList($array_data){
        $m_modifier_category = new Modifier_Category_Model();
        $modifier_categoryList = property_exists($array_data, 'modifier_categoryList') ? $array_data->modifier_categoryList : '';
        if (!empty($modifier_categoryList)) {
            $category_ids = array();
            foreach ($modifier_categoryList as $category) {
                $data = json_decode(json_encode($category), true);
                if ($m_modifier_category->is_category_id_exist($category->ModifierCategoryId)) {
                    array_push($category_ids,$category->ModifierCategoryId);
                    $is_update = $m_modifier_category->save($data, $category->ModifierCategoryId);
                    // echo $is_update?'Update':'Update Fail';
                } else {
                    $is_save = $m_modifier_category->save($data);
                    $id = $m_modifier_category->db->insert_id();
                    array_push($category_ids,$id);
                    // echo $is_save?'Save':'Save Fail';
                }
            }
            $m_modifier_category->db->where_not_in('ModifierCategoryId',$category_ids);
            $m_modifier_category->db->delete($m_modifier_category->get_table_name());
        }
    }


    private function save_show_side_dish($array_data){
        $m_show_side_dish = new Showsidedish_Model();
        $show_side_dishes = property_exists($array_data, 'showsidedishList') ? $array_data->showsidedishList : '';
        if (!empty($show_side_dishes)) {
            $show_side_dishes_ids = array();
            foreach ($show_side_dishes as $show_side_dishe) {
                $data = json_decode(json_encode($show_side_dishe), true);
                if ($m_show_side_dish->is_side_dish_id_exist($show_side_dishe->Id)) {
                    array_push($show_side_dishes_ids,$show_side_dishe->Id);
                    $is_update = $m_show_side_dish->save($data, $show_side_dishe->Id);
                    // echo $is_update?'Update':'Update Fail';
                } else {
                    $is_save = $m_show_side_dish->save($data);
                    $id = $m_show_side_dish->db->insert_id();
                    array_push($show_side_dishes_ids,$id);
                    // echo $is_save?'Save':'Save Fail';
                }
            }
            $m_show_side_dish->db->where_not_in('Id',$show_side_dishes_ids);
            $m_show_side_dish->db->delete($m_show_side_dish->get_table_name());
        }
    }

    private function get_desktop_data_form_settings() {
        $desktop_data = $this->Settings_Model->get_by(array("name" => 'desktop_data'), true);
        if (!empty($desktop_data)) {
            $details = $desktop_data->value;
        } else {
            $details = '';
        }
        return $details;
    }

    function show_data() {
        $array_data = json_decode($this->get_desktop_data_form_settings());
        $this->save_category_list($array_data);
        $this->save_parentCategory_list($array_data);
        $this->save_fooditem_list($array_data);
        $this->save_food_types_list($array_data);
        // $this->save_fooditem_list($array_data);
        $this->save_selection_items_list($array_data);
        $this->save_side_dishes_entity_list($array_data);
        $this->save_modifier_categoryList($array_data);
        $this->save_show_side_dish($array_data);

        $this->db->query("UPDATE fooditem SET foodItemFullName = NULL  WHERE foodItemFullName = ''");
        $this->db->query("UPDATE selectionitems SET selectiveItemFullName = NULL WHERE selectiveItemFullName=''");
      
        echo '<pre>'; print_r($array_data); echo '</pre>';
    }


    private function save_category_list($array_data) {
        $category_list = property_exists($array_data, 'CategoryList') ? $array_data->CategoryList : '';
        if (!empty($category_list)) {
            $category_ids = array();
            foreach ($category_list as $category) {
                $data = json_decode(json_encode($category), true);
                if ($this->Category_Model->is_category_id_exist($category->categoryId)) {
                    array_push($category_ids,$category->categoryId);
                    $is_update = $this->Category_Model->save($data, $category->categoryId);
                    // echo $is_update?'Update':'Update Fail';
                } else {
                    $is_save = $this->Category_Model->save($data);
                    $id = $this->Category_Model->db->insert_id();
                    array_push($category_ids,$id);
                    // echo $is_save?'Save':'Save Fail';
                }
            }

            $this->Category_Model->db->where_not_in('categoryId',$category_ids);
            $this->Category_Model->db->delete($this->Category_Model->get_table_name());
        }
    }

    private function save_parentCategory_list($array_data) {
        $parentCategory_list = property_exists($array_data, 'ParentCategoryList') ? $array_data->ParentCategoryList : '';
        if (!empty($parentCategory_list)) {
            $parent_category_ids = array();
            foreach ($parentCategory_list as $parentCategory) {
                $data = json_decode(json_encode($parentCategory), true);
                if ($this->Parentcategory_Model->is_parentCategoryId_exist($parentCategory->parentCategoryId)) {
                    array_push($parent_category_ids,$parentCategory->parentCategoryId);
                    $is_update = $this->Parentcategory_Model->save($data, $parentCategory->parentCategoryId);
                    // echo $is_update?'Update':'Update Fail';
                } else {
                    $is_save = $this->Parentcategory_Model->save($data);
                    $id = $this->Parentcategory_Model->db->insert_id();
                    array_push($parent_category_ids,$id);
                    // echo $is_save?'Save':'Save Fail';
                }
            }

            $this->Parentcategory_Model->db->where_not_in('parentCategoryId',$parent_category_ids);
            $this->Parentcategory_Model->db->delete($this->Parentcategory_Model->get_table_name());
        }
    }

    private function save_fooditem_list($array_data) {
        $fooditem_list = property_exists($array_data, 'FoodItemList') ? $array_data->FoodItemList : '';

        if (!empty($fooditem_list)) {
            $fooditem_list_ids = array();
            foreach ($fooditem_list as $fooditem) {
                $data = json_decode(json_encode($fooditem), true);
                if ($this->Fooditem_Model->is_foodItemId_exist($fooditem->foodItemId)) {
                    array_push($fooditem_list_ids,$fooditem->foodItemId);
                    if (array_key_exists('image_path',$data)) {
                        unset($data['image_path']);
                    }

                    $is_update = $this->Fooditem_Model->save($data, $fooditem->foodItemId);
                    // echo $is_update?'Update':'Update Fail';
                } else {
                    $is_save = false;
                    $is_save = $this->Fooditem_Model->save($data);
                    if ($is_save) {
                        $id = $this->Fooditem_Model->db->insert_id();
                        array_push($fooditem_list_ids,$id);
                    }
                    // echo $is_save?'Save':'Save Fail';
                }
            }
            $this->Fooditem_Model->db->where_not_in('foodItemId',$fooditem_list_ids);
            $this->Fooditem_Model->db->delete($this->Fooditem_Model->get_table_name());
        }
    }

    private function delete_foodsitems() {
    }

    private function save_food_types_list($array_data) {
        $food_types_list = property_exists($array_data, 'FoodTypeEntityList') ? $array_data->FoodTypeEntityList : '';
        if (!empty($food_types_list)) {
            $food_types_list_ids = array();
            foreach ($food_types_list as $food_type) {
                $data = json_decode(json_encode($food_type), true);
                if ($this->Foodtype_Model->is_foodTypeId_exist($food_type->foodTypeId)) {
                    array_push($food_types_list_ids,$food_type->foodTypeId);
                    $is_update = $this->Foodtype_Model->save($data, $food_type->foodTypeId);
                    // echo $is_update?'Update':'Update Fail';
                } else {
                    $is_save = $this->Foodtype_Model->save($data);
                    // echo $is_save?'Save':'Save Fail';
                    $id = $this->Foodtype_Model->db->insert_id();
                    array_push($food_types_list_ids,$id);
                }
            }

            $this->Foodtype_Model->db->where_not_in('foodTypeId',$food_types_list_ids);
            $this->Foodtype_Model->db->delete($this->Foodtype_Model->get_table_name());
        }
    }

    private function save_selection_items_list($array_data) {
        $selection_items_list = property_exists($array_data, 'SelectionItemsList') ? $array_data->SelectionItemsList : '';
        if (!empty($selection_items_list)) {
            $selection_items_list_ids = array();
            foreach ($selection_items_list as $selection_item) {
                $data = json_decode(json_encode($selection_item), true);
                if ($this->Selectionitems_Model->is_selectiveItemId_exist($selection_item->selectiveItemId)) {
                    array_push($selection_items_list_ids,$selection_item->selectiveItemId);
                    $is_update = $this->Selectionitems_Model->save($data, $selection_item->selectiveItemId);
                    // echo $is_update?'Update':'Update Fail';
                } else {
                    $is_save = $this->Selectionitems_Model->save($data);
                    $id = $this->Selectionitems_Model->db->insert_id();
                    array_push($selection_items_list_ids,$id);
                    // echo $is_save?'Save':'Save Fail';
                }
            }

            $this->Selectionitems_Model->db->where_not_in('selectiveItemId',$selection_items_list_ids);
            $this->Selectionitems_Model->db->delete( $this->Selectionitems_Model->get_table_name());
        }
    }

    private function save_side_dishes_entity_list($array_data) {
        $side_dishes_entity_list = property_exists($array_data, 'SideDishesEntityList') ? $array_data->SideDishesEntityList : '';
        if (!empty($side_dishes_entity_list)) {
            $side_dishes_entity_list_ids = array();
            foreach ($side_dishes_entity_list as $side_dishes_entity_item) {
                $data = json_decode(json_encode($side_dishes_entity_item), true);
                if ($this->Sidedishes_Model->is_SideDishesId_exist($side_dishes_entity_item->SideDishesId)) {
                    array_push($side_dishes_entity_list_ids,$side_dishes_entity_item->SideDishesId);
                    $is_update = $this->Sidedishes_Model->save($data, $side_dishes_entity_item->SideDishesId);
                    // echo $is_update?'Update':'Update Fail';
                } else {
                    $is_save = $this->Sidedishes_Model->save($data);
                    $id = $this->Sidedishes_Model->db->insert_id();
                    array_push($side_dishes_entity_list_ids,$id);
                    // echo $is_save?'Save':'Save Fail';
                }
            }

            $this->Sidedishes_Model->db->where_not_in('SideDishesId',$side_dishes_entity_list_ids);
            $this->Sidedishes_Model->db->delete( $this->Sidedishes_Model->get_table_name());
        }
    }

    public function get_maintanance_info() {
        $CI = & get_instance();
        $maintenance_mode_settings = $CI->Settings_Model->get_by(array("name" => 'maintenance_mode_settings'), true);
        $info = (!empty($maintenance_mode_settings)) ? ($maintenance_mode_settings->value) : '';
        echo  ($info);    
    }
    
    public function update_maintanance_info() {
        // echo  'dsfsd';  die;
        if (!empty($this->input->post('data'))) {
            $data = $this->input->post('data');
            $key = $this->input->post('key'); //accept or reject

            if($key == 'KFG33XXC') {
                $CI = & get_instance();
                $maintenance_mode_settings = $CI->Settings_Model->get_by(array("name" => 'maintenance_mode_settings'), true);
                $id = $maintenance_mode_settings->id;
                $name = 'maintenance_mode_settings';
                // $value = $this->Settings_Model->data_form_post(array('message', 'is_maintenance', 'is_app_maintenance', 'environment'));
                // $value = json_encode($value);
                $is_save = false;
                if (!empty($id)) {
                    $is_save = $this->Settings_Model->save(array('value' => $data), $id);
                } else {
                    $is_save = $this->Settings_Model->save(array('name' => $name,'value' => $data));
                }

                if ($is_save) {
                    echo 'Maintenance Mode update successfully' ;
                } else {
                    echo 'Maintenance Mode is not updated';
                }
            } else {
                echo 'invalid request';
            }
        } else {
           echo 'invalid request';
        }    
    }
}
