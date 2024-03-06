<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sidedishes_Model extends Ex_Model {

    protected $table_name = 'sidedishes';
    protected $primary_key = 'SideDishesId';

    public function __construct() {
        parent::__construct();
    }

    public function is_SideDishesId_exist($id = 0) {
        $this->where_column = 'SideDishesId';
        return $this->get($id, true);
    }

    public function get_modifier_by_modifier_category($modifier_category_id = "") {
        $where_condition = "";

        if ($modifier_category_id) {
            $where_condition = "WHERE `sidedishes`.`ModifierCategoryId` IN ($modifier_category_id)";
        }

        $results = $this->db->query("
            SELECT `sidedishes`.*,`modifier_category`.`ModifierCategoryName`,`modifier_category`.`ModifierLimit`
            FROM `sidedishes`
            INNER JOIN `modifier_category` ON `modifier_category`.`ModifierCategoryId` = `sidedishes`.`ModifierCategoryId`
            $where_condition
            ORDER BY `sidedishes`.`ModifierCategoryId` ASC,`sidedishes`.`SortOrder` ASC
        ")->result();
        return $results;
    }

    public function is_exists_modifier_name($name = null,$categoryId = 0) {
        $this->db->where('SideDishesName',trim($name));
        $this->db->where('ModifierCategoryId',$categoryId);
        $count_result = $this->db->count_all_results($this->table_name);
        return ($count_result > 0) ? true : false;
    }

    public function is_modifier_name_exist_for_update($id = 0, $name = null,$categoryId = 0) {
        $this->db->where('SideDishesId != ',$id);
        $this->db->where('ModifierCategoryId',$categoryId);
        $this->db->where('SideDishesName',trim($name));
        return $this->db->count_all_results($this->table_name) > 0 ? true : false;
    }

    public function get_modifier_category() {
        $this->db->select('sidedishes.*,modifier_category.ModifierCategoryName,modifier_category.ModifierLimit');
        $this->db->order_by('modifier_category.ModifierCategoryName','ASC');
        $this->db->order_by('sidedishes.SortOrder','ASC');
        $this->db->from('sidedishes');
        $this->db->join('modifier_category','modifier_category.ModifierCategoryId=sidedishes.ModifierCategoryId');
        return $this->db->get()->result();

    }

    public function get_by_modifier_category_id($modifier_category_id = 0) {
        $results = $this->db->query("
            SELECT `sidedishes`.*,`modifier_category`.`ModifierCategoryName`,`modifier_category`.`ModifierLimit`
            FROM `sidedishes`
            INNER JOIN `modifier_category` ON `modifier_category`.`ModifierCategoryId` = `sidedishes`.`ModifierCategoryId`
            WHERE `sidedishes`.`ModifierCategoryId` = $modifier_category_id
            ORDER BY `sidedishes`.`SortOrder` ASC
        ")->result();
        return $results;
        // $this->db->order_by('SortOrder','ASC');
        // return $this->get_by(array('ModifierCategoryId'=>$modifier_category_id));
    }

    public function get_modifier_by_id($sideDishesId = 0) {
        $this->db->select('sidedishes.*,modifier_category.ModifierCategoryName,modifier_category.ModifierLimit');
        $this->db->from('sidedishes');
        $this->db->join('modifier_category','modifier_category.ModifierCategoryId=sidedishes.ModifierCategoryId');
        $this->db->where('sidedishes.sideDishesId',$sideDishesId);
        return $this->db->get()->row();
    }

    public function get_modifier_by_ids($side_dish_ids = '') {
        if ($side_dish_ids) {
            $results = $this->db->query("
                SELECT `sidedishes`.*,`modifier_category`.`ModifierCategoryName`,`modifier_category`.`ModifierLimit`
                FROM `sidedishes`
                INNER JOIN `modifier_category` ON `modifier_category`.`ModifierCategoryId` = `sidedishes`.`ModifierCategoryId`
                WHERE `sidedishes`.`sideDishesId` IN ($side_dish_ids)
                ORDER BY `sidedishes`.`SortOrder` ASC
            ")->result();
            return $results;
        }
        return array();
    }

    public function getAllAsModifierCategories() {
        $side_dish_as_modifier_category = array();
        $m_ModifierCategories = new Modifier_Category_Model();
        $modifierCategories = $m_ModifierCategories->get_all();
        if (!empty($modifierCategories)) {
            foreach ($modifierCategories as $modifierCategory){
                $modifier_category_id = $modifierCategory->ModifierCategoryId;
                // $side_dish_as_modifier_category['ModifierCategoryName'] = $show_side_dish;
                $side_dishes_by_modifier_category_id = $this->get_by_modifier_category_id($modifier_category_id);
                $modifierCategoryArray = (array)$modifierCategory;
                $modifierCategoryArray['SideDishes'] = $side_dishes_by_modifier_category_id;
                array_push($side_dish_as_modifier_category,$modifierCategoryArray);
            }
        }
        return $side_dish_as_modifier_category;
    }

    public function getAllByIds($ids = array()) {
        if (!empty($ids)) {
            $this->db->where_in('SideDishesId',$ids);
            return $this->get();
        } else {
            return array();
        }
    }

    public function get_sort_order_by_modifier_category_id($modifier_category_id) {
        $result = 0;
        if ($modifier_category_id) {
            $result = $this->db->query("SELECT MAX(`SortOrder`) AS `SortOrder` FROM `sidedishes` WHERE `ModifierCategoryId` = $modifier_category_id")->row()->SortOrder;
        }
        return $result;
    }
}
