<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Offers_or_deals extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('New_order_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Deals_Model');
        $this->load->model('Deals_Item_Model');
        $this->load->model('Category_Model');
        $this->load->model('Selectionitems_Model');
        $this->load->model('Fooditem_Model');
        $this->load->helper('user');
        $this->load->helper('shop');
        $this->load->helper('product');
    }

    public function index() {
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->Deals_Item_Model->unset_item_to_session();
        $this->session->set_userdata('session_is_half_and_half',false);
        $deals = $this->Deals_Model->get_all();
        $this->page_content_data['title'] = 'Offer or Deals';
        $this->page_content_data['deals'] = $deals;
        $this->page_content = $this->load->view('admin/menu/offers_or_deals/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/offers_or_deals/index_js',$this->page_content_data,true);

        $this->data['title'] = "Offer or Deals | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function get_sort_order() {
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $category_id = trim($this->input->post('category_id'));
            $max_sort_order =  $this->Deals_Model->get_sort_order_by_category_id($category_id);
            $sort_order = 1;
            if (!empty($max_sort_order) || $max_sort_order > 0) {
                $sort_order = $max_sort_order + 1;
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($sort_order));
        }        
    }

    public function add() {
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $deals_items = $this->Deals_Item_Model->get_items_from_session();
        $this->data['deals_items'] = $deals_items;
        $deals_items_view = $this->load->view('admin/menu/offers_or_deals/item_list',$this->data,true);

        $this->page_content_data['title'] = 'Add Offer or Deals';
        $this->page_content_data['deals_items_view'] = $deals_items_view;
        $this->page_content = $this->load->view('admin/menu/offers_or_deals/add',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/offers_or_deals/add_edit_js',$this->page_content_data,true);

        $this->data['title'] = "Offer or Deals | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit($id = 0) {
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }
        
        $deal = $this->Deals_Model->get_by_id($id);

        if (!empty($deal)) {
            $deals_items = $this->Deals_Item_Model->get_by_deals_id($id);
            $this->Deals_Item_Model->update_deals_items_to_session($deals_items);

            $this->item_list_data['deals_items'] = $deals_items;
            $dealsItemsView = $this->load->view('admin/menu/offers_or_deals/item_list',$this->item_list_data,true);

            $this->page_content_data['title'] = 'Edit Offer or Deals';
            $this->page_content_data['deal'] = $deal;
            $this->page_content_data['dealsItemsView'] = $dealsItemsView;
            $this->page_content = $this->load->view('admin/menu/offers_or_deals/edit',$this->page_content_data,true);
            $this->custom_js = $this->load->view('admin/menu/offers_or_deals/add_edit_js',$this->page_content_data,true);

            $this->data['title'] = "Offer or Deals | Edit";
            $this->load->view('admin/master/master_index',$this->data);
        } else {
            redirect( 'admin/offers_or_deals');
        }
    }

    public function view($id = 0) {
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }
        
        $deal = $this->Deals_Model->get_by_id($id);

        if (!empty($deal)) {
            $deals_items = $this->Deals_Item_Model->get_by_deals_id($id);
            $this->page_content_data['title'] = 'View Offer or Deals';
            $this->page_content_data['deal'] = $deal;
            $this->page_content_data['deals_items'] = $deals_items;
            $this->page_content = $this->load->view('admin/menu/offers_or_deals/view',$this->page_content_data,true);

            $this->data['title'] = "Offer or Deals | View";
            $this->load->view('admin/master/master_index',$this->data);
        } else {
            redirect( 'admin/offers_or_deals');
        }
    }

    public function save_item() {
        // dd($this->input->post());
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $index_key = $this->input->post('index_key');
            $title = $this->input->post('item_title');
            $description = $this->input->post('item_description');
            $limit = $this->input->post('item_limit');
            $product_ids = $this->input->post('product_ids');
            $sub_product_ids = $this->input->post('sub_product_ids');
            $productAsModifierLimit = $this->input->post('productAsModifierLimit');
            $subProductAsModifierLimit = $this->input->post('subProductAsModifierLimit');
            $is_half_and_half = $this->input->post('is_half_and_half');
            $this->session->set_userdata('session_is_half_and_half',false);
            if ($is_half_and_half == 'true') {
                $this->session->set_userdata('session_is_half_and_half',true);
            }

            if ($index_key >= 0) {
                // Item Will Update Here
                $deals_items = $this->Deals_Item_Model->get_items_from_session();
                if (array_key_exists($index_key,$deals_items)) {
                    $deals_items[$index_key]['title'] = $title;
                    $deals_items[$index_key]['description'] = $description;
                    $deals_items[$index_key]['limit'] = $limit;
                    $deals_items[$index_key]['productIds'] = $product_ids;
                    $deals_items[$index_key]['subProductIds'] = $sub_product_ids;
                    $deals_items[$index_key]['subProductAsModifierLimit'] = $subProductAsModifierLimit;
                    $deals_items[$index_key]['productAsModifierLimit'] = $productAsModifierLimit;
                    $this->Deals_Item_Model->update_deals_items_to_session($deals_items);
                }
            } else {
                // Item Will Save Here
                if (!(empty($product_ids) && empty($sub_product_ids))) {
                    $this->Deals_Item_Model->set_item_to_session(array(
                       'title'=>$title,
                       'description'=>$description,
                       'limit'=>$limit,
                       'productIds'=>$product_ids,
                       'subProductIds'=>$sub_product_ids,
                       'subProductAsModifierLimit'=>$subProductAsModifierLimit,
                       'productAsModifierLimit'=>$productAsModifierLimit,
                    ));
                }
            }
            $deals_items = $this->Deals_Item_Model->get_items_from_session();
            $this->data['deals_items'] = $deals_items;
            $deals_items_view = $this->load->view('admin/menu/offers_or_deals/item_list',$this->data,true);

            $this->output->set_content_type('application/json')->set_output(json_encode(array('dealsItemsView'=>$deals_items_view,'deals_items'=>$deals_items)));
        }
    }

    public function edit_item() {
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $index_key = $this->input->post('index_key');
            $deals_items = $this->Deals_Item_Model->get_items_from_session();
            $editable_item = $deals_items[$index_key];

            $this->data['editable_item'] = $editable_item;
            $this->data['index_key'] = $index_key;
            $deals_items_add_form = $this->load->view('admin/menu/offers_or_deals/deals_item_add_form',$this->data,true);

            $this->output->set_content_type('application/json')->set_output(json_encode(array('dealsItemsAddForm'=>$deals_items_add_form)));
        }
    }

    public function remove_item() {
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $is_half_and_half = $this->input->post('isHalfAndHalf');
            $this->session->set_userdata('session_is_half_and_half',false);
            if ($is_half_and_half == 'true') {
                $this->session->set_userdata('session_is_half_and_half',true);
            }
            $index_key = $this->input->post('index_key');
            $deals_items = $this->Deals_Item_Model->get_items_from_session();
            unset($deals_items[$index_key]);
            $this->Deals_Item_Model->update_deals_items_to_session($deals_items);
            $deals_items = $this->Deals_Item_Model->get_items_from_session();

            $this->data['deals_items'] = $deals_items;
            $deals_items_view = $this->load->view('admin/menu/offers_or_deals/item_list',$this->data,true);

            $this->output->set_content_type('application/json')->set_output(json_encode(array('dealsItemsView'=>$deals_items_view,'deals_items'=>$deals_items)));
        }
    }

    public function remove_modifier_item() {
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            // dd($this->input->post());
            $item_id = $this->input->post('item_id');
            $item_category_text = $this->input->post('item_category');
            $item_categories = explode(',', $item_category_text);
            $item_index = $this->input->post('item_index');
            $deals_items = $this->Deals_Item_Model->get_items_from_session();

            foreach ($item_categories as $category) {
                if (array_key_exists($category, $deals_items[$item_index])) {
                    $modifier_array = json_decode($deals_items[$item_index][$category],true);
                    if ($modifier_array) {
                        foreach ($modifier_array as $key => $modifier) {
                            if (is_array($modifier) && array_key_exists('id', $modifier)) {
                                if ($modifier['id'] == $item_id) {
                                    unset($modifier_array[$key]);
                                    break;
                                }
                            } elseif ($modifier == $item_id) {
                                unset($modifier_array[$key]);
                                break;
                            }
                            
                        }
                        $deals_items[$item_index][$category] = json_encode(array_values($modifier_array));
                    }
                }
            }
            $this->Deals_Item_Model->update_deals_items_to_session($deals_items);
            $deals_items = $this->Deals_Item_Model->get_items_from_session();

            $this->data['deals_items'] = $deals_items;
            $deals_items_view = $this->load->view('admin/menu/offers_or_deals/item_list',$this->data,true);

            $this->output->set_content_type('application/json')->set_output(json_encode(array('dealsItemsView'=>$deals_items_view)));
        }
    }

    public function getTotalDealItems() {
        $total_items = $this->Deals_Item_Model->get_total_items_from_session();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('totalItems'=>$total_items)));
    }

    public function insert() {
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $is_half_and_half = $this->input->post('is_half_and_half');
        $dealsItems = $this->Deals_Item_Model->get_items_from_session();

        if ($is_half_and_half > 0 && count($dealsItems) > 1) {
            set_flash_error_message('This is a half-and-half type offer and its have more than 1 deals items. Please select only 1 deal item.');
            redirect(base_url('admin/offers_or_deals/add'));
        }

        $availability = "";
        if ($this->input->post('availability')) {
            $availability = implode(',',$this->input->post('availability'));
        }
        $deals_data = $this->Deals_Model->data_form_post(array('categoryId','title','description','deal_printed_description','price','sort_order','is_discount','is_half_and_half','deal_order_type'));
        $deals_data['availability'] = $availability;
        $is_save = false;
        $is_save = $this->Deals_Model->save($deals_data);
        $dealsId = $this->Deals_Model->db->insert_id();


        $dataDealsItems = array();
        if (!empty($dealsItems)) {
            foreach ($dealsItems as $item) {
                $item['dealsId'] = $dealsId;
                array_push($dataDealsItems,$item);
            }
        }

        if (!empty($dataDealsItems)) {
            $this->Deals_Item_Model->db->insert_batch($this->Deals_Item_Model->get_table_name(),$dataDealsItems);
        }
        $message = ($is_save) ? 'Offer/Deal is added successfully' : 'Offer/Deal is not added ';
        set_flash_save_message($message);
        $this->Deals_Item_Model->unset_item_to_session();

        redirect( 'admin/offers_or_deals');
    }

    public function update() {
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $dealsId = $this->input->post('id');
        $is_half_and_half = $this->input->post('is_half_and_half');
        $dealsItems = $this->Deals_Item_Model->get_items_from_session();

        if ($is_half_and_half > 0 && count($dealsItems) > 1) {
            set_flash_error_message('This is a half-and-half type offer and its have more than 1 deals items. Please select only 1 deal item.');
            redirect( 'admin/offers_or_deals/edit/'.$dealsId);
        }

        $availability = implode(',',$this->input->post('availability'));
        $m_deals = new Deals_Model();
        $deals_data = $m_deals->data_form_post(array('id','categoryId','title','description','deal_printed_description','price','sort_order','is_discount','is_half_and_half','deal_order_type'));
        $deals_data['availability'] = $availability;
        $deal = $m_deals->get_by_id($dealsId);
        
        if (!empty($deal)) {
            $is_updated = $m_deals->save($deals_data,$dealsId);
            $dataDealsItems = array();
            $dealsItemIds = array();
            if (!empty($dealsItems)) {
                foreach ($dealsItems as $item){
                    $is_save = false;
                    if (!is_array($item)) {
                        $item = (array)$item;
                    }
                    $item['dealsId'] = $dealsId;
                    $id = array_key_exists('id',$item) ? $item['id'] : null;
                    if (!empty($id)) {
                        // update item
                        array_push($dealsItemIds,$id);
                        $this->db->where('id',$id);
                        $this->db->update('deals_items',$item);
                    } else {
                        // insert Item
                        $is_save = $this->Deals_Item_Model->save($item);
                        if ($is_save) {
                            $new_deals_item_id = $this->Deals_Item_Model->db->insert_id();
                            array_push($dealsItemIds,$new_deals_item_id);
                        }
                    }
                }
            }

            if (!empty($dealsItemIds)) {
                $this->Deals_Item_Model->db->where_not_in('id', $dealsItemIds);
                $this->Deals_Item_Model->db->where('dealsId', $dealsId);
                $this->Deals_Item_Model->db->delete($this->Deals_Item_Model->get_table_name());
            } else if(empty($dealsItems)) {
                $this->Deals_Item_Model->db->where('dealsId', $dealsId);
                $this->Deals_Item_Model->db->delete($this->Deals_Item_Model->get_table_name());
            }

            $message = ($is_updated) ? 'Deal/Offer is updated successfully' : 'Offer is not updated';
            set_flash_save_message($message);

            // redirect( 'admin/offers_or_deals/edit/'.$dealsId);
        }
        $this->Deals_Item_Model->unset_item_to_session();
        redirect( 'admin/offers_or_deals');
    }

    public function active_or_deactive_status() {
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $dealId = $this->input->post('dealId');
        $status = $this->input->post('status') == 1 ? 0 : 1;
        $fieldName = $this->input->post('fieldName');

        if ($fieldName == 1) {
            $fieldName = 'active';
        } elseif ($fieldName == 2) {
            $fieldName = 'orderable';
        } elseif ($fieldName == 3) {
            $fieldName = 'isHighlight';
        }        

        $this->Deals_Model->update_active_status($dealId,$status,$fieldName);
        $dealsInfo = $this->Deals_Model->get_deal_by_id($dealId);
        // echo "<pre>"; print_r($dealsInfo); exit();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('dealsInfo' => $dealsInfo)));
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/offers_or_deals') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $mDeals = new Deals_Model();
        $deal = $mDeals->get_by_id($id);
        if (!empty($deal)) {
            $isDeleted = $mDeals->delete($id);
            $this->Deals_Item_Model->delete_where(array('dealsId'=>intval($id)),false);
            $message = ($isDeleted) ? 'Offer/Deal is deleted successfully' : 'Offer/Deal is not deleted ';
            set_flash_save_message($message);
        } else {
            set_flash_save_message('No Such offer/deal found to delete');
        }
        redirect( 'admin/offers_or_deals');
    }
}
