<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Showsidedish_Model extends Ex_Model {
    protected $table_name = 'showsidedish';
    protected $primary_key = 'Id';

    public function __construct() {
        parent::__construct();
    }

    // public function get_assigned_modifier_category($category_id = 0) {
    //     $this->db->select('showsidedish.*,modifier_category.ModifierCategoryName,modifier_category.ModifierLimit,modifier_category.ModifierCategoryId');
    //     $this->db->order_by('modifier_category.ModifierCategoryName','ASC');
    //     $this->db->from('showsidedish');
    //     $this->db->where('showsidedish.CategoryId',$category_id);
    //     // showsidedish table SideDishId is ModifierCategoryId for desktop unchangeable purpose
    //     $this->db->join('modifier_category','modifier_category.ModifierCategoryId=showsidedish.SideDishId');
    //     return $this->db->get()->result();
    // }

    public function get_assigned_modifier_by_category_id($category_id) {
        // $query = $this->db->get_where($this->table_name, array('CategoryId' => $category_id));
        // $query = $this->db->query("SELECT SideDishesId as Id,SideDishesId as SideDishId ,SideDishesName, ModifierCategoryId,UnitPrice,VatRate,Unit,SortOrder FROM sidedishes  WHERE ModifierCategoryId IN(SELECT SideDishId FROM showsidedish WHERE CategoryId='$category_id') ORDER BY SortOrder ASC");
        // return $query->result();

        $show_side_dishes = $this->get_assigned_modifier_categories($category_id);
        $side_dish_as_modifier_category = array();
        $m_side_dishes = new Sidedishes_Model();
        foreach ($show_side_dishes as $show_side_dish) {
            $modifier_category_id = $show_side_dish->ModifierCategoryId;
            // $side_dish_as_modifier_category['ModifierCategoryName']=$show_side_dish;
            $side_dishes_by_modifier_category_id = $m_side_dishes->get_by_modifier_category_id($modifier_category_id);
            if (!empty($side_dishes_by_modifier_category_id)) {
                array_push($side_dish_as_modifier_category,array(
                    'ModifierCategoryName'=>$show_side_dish->ModifierCategoryName,
                    'ShowSideDishId'=>$show_side_dish->Id,
                    'ModifierCategoryId'=>$show_side_dish->ModifierCategoryId,
                    'Limit'=>$show_side_dish->ModifierLimit,
                    'SideDishes'=>$side_dishes_by_modifier_category_id
                ));
            }
        }
        return $side_dish_as_modifier_category;
    }

    public function get_categorywise_assigned_modifier($category_id, $modifier_id) {
        $query = $this->db->query("SELECT * FROM showsidedish WHERE CategoryId = '$category_id' AND SideDishId = '$modifier_id'");
        return $query->row();
    }

    public function get_assigned_modifier_categories($category_id = 0) {
        $this->db->select('showsidedish.*,modifier_category.ModifierCategoryName,modifier_category.ModifierLimit ,modifier_category.ModifierCategoryId');
        $this->db->order_by('modifier_category.ModifierCategoryName','ASC');
        $this->db->from('showsidedish');
        if (!empty($category_id) && intval($category_id) > 0) {
            $this->db->where('showsidedish.CategoryId',$category_id);
        }

        // showsidedish table SideDishId is ModifierCategoryId for desktop unchangeable purpose
        $this->db->join('modifier_category','modifier_category.ModifierCategoryId=showsidedish.SideDishId');
        return $this->db->get()->result();
    }

    public function get_product_assigned_modifiers($categoryId = 0,$productId = 0){
        $assignedModifiers = null;
        $firstConditions = array('CategoryId'=>$productId,'ProductLevel'=>2,);
        $assignedModifiers = $this->get_assigned_modifiers($firstConditions);

        if (!empty($assignedModifiers)) {
            return $this->side_dish_as_modifier_category($assignedModifiers);
        } else {
            $assignedModifiers = null;
            $secondConditions = array('CategoryId'=>$categoryId,'ProductLevel'=>1,);
            $assignedModifiers = $this->get_assigned_modifiers($secondConditions);
            return $this->side_dish_as_modifier_category($assignedModifiers);
        }
    }

    public function get_sub_product_assigned_modifiers($categoryId = 0,$productId = 0,$sub_product_id = 0) {
        $assignedModifiers = null;
        $firstConditions = array('CategoryId'=>$sub_product_id,'ProductLevel'=>3,);
        $secondConditions = array('CategoryId'=>$productId,'ProductLevel'=>2,);
        $lastConditions = array('CategoryId'=>$categoryId,'ProductLevel'=>1,);
        $assignedModifiers = $this->get_assigned_modifiers($firstConditions);

        if (!empty($assignedModifiers)) {
            return $this->side_dish_as_modifier_category($assignedModifiers);
        } else {
            $assignedModifiers = null;
            $assignedModifiers = $this->get_assigned_modifiers($secondConditions);
            if (!empty($assignedModifiers)) {
                return $this->side_dish_as_modifier_category($assignedModifiers);
            } else {
                $assignedModifiers = null;
                $assignedModifiers = $this->get_assigned_modifiers($lastConditions);
                return $this->side_dish_as_modifier_category($assignedModifiers);
            }
        }
        return null;
    }

    public function get_assigned_modifiers($conditions = array()) {
        // showsidedish table SideDishId is ModifierCategoryId for desktop unchangeable purpose
        $this->db->select('showsidedish.*,modifier_category.ModifierCategoryName,modifier_category.ModifierLimit as ModifierCategoryLimit,modifier_category.ModifierCategoryId,modifier_category.SortOrder,,modifier_category.isEdited,');
        $this->db->from('showsidedish');
        $this->db->join('modifier_category','modifier_category.ModifierCategoryId = showsidedish.SideDishId');
        if(!empty($conditions)){
            $this->db->where($conditions);
        }
        $this->db->order_by('modifier_category.ModifierCategoryName','ASC');
        return $this->db->get()->result();
    }

    public function side_dish_as_modifier_category($show_side_dishes) {
        $side_dish_as_modifier_category = array();
        $m_side_dishes = new Sidedishes_Model();
        foreach ($show_side_dishes as $show_side_dish) {
            $modifier_category_id = $show_side_dish->ModifierCategoryId;
            // $side_dish_as_modifier_category['ModifierCategoryName']=$show_side_dish;
            $side_dishes_by_modifier_category_id = $m_side_dishes->get_by_modifier_category_id($modifier_category_id);

            if (!empty($side_dishes_by_modifier_category_id)) {
                array_push($side_dish_as_modifier_category,array(
                    'ModifierCategoryName'=>$show_side_dish->ModifierCategoryName,
                    'ShowSideDishId'=>$show_side_dish->Id,
                    'ModifierCategoryId'=>$show_side_dish->ModifierCategoryId,
                    'Limit'=>$show_side_dish->ModifierLimit,
                    'SideDishes'=>$side_dishes_by_modifier_category_id
                ));
            }
        }
        return $side_dish_as_modifier_category;
    }

    public function get_all_assigned_modifier_categories() {
        $this->db->select('showsidedish.*,modifier_category.ModifierCategoryName,modifier_category.ModifierLimit,modifier_category.ModifierCategoryId');
        $this->db->from('showsidedish');
        $this->db->join('modifier_category','modifier_category.ModifierCategoryId=showsidedish.SideDishId');
        $this->db->order_by('modifier_category.ModifierCategoryName','ASC');
        return $this->db->get()->result();
    }

    public function get_all_assigned_modifiers_as_product_categories() {
        $distinctCategories = $this->get_district_categories();
        $modifierAsProductCategory = array();
        if (!empty($distinctCategories)) {
            foreach ($distinctCategories as $category) {
                $categoryId = $category->CategoryId;
                $modifiersAsCategory = $this->get_assigned_modifier_by_category_id($categoryId);
                if (!empty($modifiersAsCategory)) {
                    array_push($modifierAsProductCategory,array('categoryId'=>$categoryId,'modifiers'=>$modifiersAsCategory,));
                }
            }
        }
        return $modifierAsProductCategory;
    }

    public function get_district_categories() {
        $this->db->select('CategoryId');
        $this->db->group_by('CategoryId');
        return $this->db->get($this->table_name)->result();
    }

    public function is_side_dish_id_exist($id) {
        $this->where_column = 'Id';
        return $this->get($id, true);
    }

    public function get_productLevelCategoryId($category_id,$product_id,$sub_product_id) {
        $level = 0;
        if (empty($product_id) && empty($sub_product_id) && !empty($category_id)) {
            // as category wise modifier limit productLevel = 1
            $level = 1;
        } else if (empty($sub_product_id) && !empty($product_id)) {
            // as product wise modifier limit productLevel = 2
            $level = 2;
            $category_id = $product_id;
        } else if (!empty($product_id) && !empty($sub_product_id)) {
            // as sub product wise modifier limit productLevel = 3
            $level = 3;
            $category_id = $sub_product_id;
        }

        return array('level'=>$level,'categoryId'=>$category_id);
    }

    public function delete_assigned_modifier($conditions = array()) {
        $assigned_modifier_by_category_id = $this->get_assigned_modifiers($conditions);
        if (!empty($assigned_modifier_by_category_id)) {
            foreach ($assigned_modifier_by_category_id as $assigned_modifier) {
                $this->Showsidedish_Model->delete($assigned_modifier->Id);
            }
        }
    }
}