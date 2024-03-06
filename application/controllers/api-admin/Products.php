<?php

class Products extends ApiAdmin_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Fooditem_Model');
        $this->load->model('Deals_Model');
        $this->load->model('Showsidedish_Model');
        $this->load->model('Deals_Item_Model');
        $this->load->model('Sidedishes_Model');
        $this->load->model('Modifier_Category_Model');
        $this->load->model('FreeItem_Model');
    }

    public function index() {
        $this->load->model('Category_Model');
        $this->load->model('Foodtype_Model');

        $this->load->model('Parentcategory_Model');
        $this->load->model('Product_Size_Model');

        $parentCategoryList = $this->Parentcategory_Model->get();
        $foodTypeList = $this->Foodtype_Model->get();
        $categories = $this->Category_Model->getAllCategories();
        $productSizes = $this->Product_Size_Model->get();
        $units = array(
            ['id' => 'Per Piece'],
            ['id' => 'Per Pound'],
            ['id' => 'Per Kg'],
            ['id' => 'Per Letter']
        );

        $weekDays = array(
            ['id' => 1, 'name' => 'Monday'],
            ['id' => 2, 'name' => 'Tuesday'],
            ['id' => 3, 'name' => 'Wednesday'],
            ['id' => 4, 'name' => 'Thursday'],
            ['id' => 5, 'name' => 'Friday'],
            ['id' => 6, 'name' => 'Saturday'],
            ['id' => 0, 'name' => 'Sunday']
        );
        $this->setResponseJsonOutput(array(
            'categories' => $categories,
            'foodTypeList' => $foodTypeList,
            'weekDays' => $weekDays,
            'productSizes' => $productSizes,
            'itemUnits' => $units,
            'categoryTypes' => array(
                array('id' => 0,'name' => 'Food'),
                array('id' => 1,'name' => 'No Food')

            ),
            'parentCategoryList' => $parentCategoryList,
        ), ApiAdmin_Controller::HTTP_OK);
    }

    public function get($productCategoryId = 0) {
        $this->Fooditem_Model->db->select('foodItemId,parentCategoryId,foodtypeId,categoryId,foodItemName,foodItemFullName,description,itemStock,takeawayPrice,tablePrice,barPrice,vatRate,vatStatus,itemUnit,orderable,productSizeId,close_on,SortOrder');
        $this->Fooditem_Model->db->where('categoryId', intval($productCategoryId));
        $this->Fooditem_Model->db->order_by('SortOrder', 'ASC');
        $products = $this->Fooditem_Model->get();
        $this->setResponseJsonOutput(array('products' => $products), ApiAdmin_Controller::HTTP_OK);
    }

    public function save() {
        if ($this->checkMethod('POST')) {
            $this->load->library('form_validation');
            $foodItemId = trim($this->input->post('foodItemId'));
            $foodItemId = (!empty($foodItemId)) ? $foodItemId : 0;
            $parent_category_id = trim($this->input->post('parentCategoryId'));
            $food_type_id = trim($this->input->post('foodtypeId'));
            $category_id = trim($this->input->post('categoryId'));
            $product_name = trim($this->input->post('foodItemName'));
            $product_full_name = trim($this->input->post('foodItemFullName'));
            $productSizeId = trim($this->input->post('productSizeId'));
            $sort_order = trim($this->input->post('SortOrder'));
            $table_price = trim($this->input->post('tablePrice'));
            $takeaway_price = trim($this->input->post('takeawayPrice'));
            $bar_price = trim($this->input->post('barPrice'));
            $unit = trim($this->input->post('itemUnit'));
            $vat_rate = trim($this->input->post('vatRate'));
            $vat_included = trim($this->input->post('vatStatus'));
            $description = trim($this->input->post('description'));
            $close_on_days = $this->input->post('close_on');
            $orderable = $this->input->post('orderable');

            if (empty($orderable)) {
                $orderable = true;
            } else {
                $orderable = !$orderable;
            }

            if (!empty($close_on_days)) {
                $close_on_days = explode(',', $close_on_days);
                $close_on_days = json_encode($close_on_days);
            } else {
                $close_on_days = '';
            }

            $form_data = array(
                //'foodItemId' => $foodItemId,
                'parentCategoryId' => $parent_category_id,
                'foodtypeId' => $food_type_id,
                'categoryId' => $category_id,
                'foodItemName' => $product_name,
                'foodItemFullName' => (!empty($product_full_name)) ? $product_full_name : null,
                'description' => $description,
                'productSizeId' => $productSizeId,
                'tableView' => 1,
                'takeawayView' => 1,
                'barView' => 1,
                'itemStock' => 0,
                'qtyStatus' => 1,
                'tablePrice' => !empty($table_price) ? $table_price : 0,
                'takeawayPrice' => !empty($takeaway_price) ? $takeaway_price : 0,
                'barPrice' => !empty($bar_price) ? $bar_price : 0,
                'tableCost' => 0,
                'takeawayCost' => 0,
                'barCost' => 0,
                'vatRate' => $vat_rate,
                'vatStatus' => $vat_included,
                'itemUnit' => $unit,
                'product_plu' => '',
                'ButtonHight' => 75,
                'ButtonWidth' => 150,
                'ItemColor' => '#00FF00',
                'SortOrder' => $sort_order,
                'FontSetting' => 'Arial,Regular,14.25',
                'Forecolor' => '#8080C0',
                'close_on' => $close_on_days,
                'orderable' => $orderable
            );

            $this->form_validation->set_rules('parentCategoryId', 'Parent Category', 'required');
            $this->form_validation->set_rules('foodtypeId', 'Food Type', 'required');
            $this->form_validation->set_rules('categoryId', 'Category Type', 'required');
            $this->form_validation->set_rules('foodItemName', 'Product Short Name', 'required');
            $this->form_validation->set_rules('SortOrder', 'Sort Order', 'required');
            $this->form_validation->set_rules('tablePrice', 'Table Price', 'required');
            $this->form_validation->set_rules('takeawayPrice', 'Takeaway Price', 'required');
            $this->form_validation->set_rules('barPrice', 'Bar Price', 'required');
            $this->form_validation->set_rules('itemUnit', 'Unit', 'required');
            $this->form_validation->set_rules('vatRate', 'Vat Rate', 'required');

            $responseData = array('isSave' => false,'responseMessage' => '',);
            if ($this->form_validation->run() === FALSE) {
                $responseData['responseMessage'] = validation_errors();
            } else {
                if ($foodItemId > 0) {
                    $is_product_name_exist_for_update = $this->Fooditem_Model->is_product_name_exist_for_update($foodItemId, $product_name);
                    if (!$is_product_name_exist_for_update) {
                        $this->Fooditem_Model->where_column = 'foodItemId';
                        $form_data['foodItemId'] = $foodItemId;
                        $isSave = $this->Fooditem_Model->save($form_data, $foodItemId);
                        $responseData['isSave'] = $isSave;
                        if ($isSave) {
                            $responseData['responseMessage'] = 'Product information has been updated successfully';
                        } else {
                            $responseData['responseMessage'] = 'Product information is not updated successfully';
                        }
                    } else {
                        $responseData['responseMessage'] = 'Product name already exists';
                    }
                } else {
                    /*Save New Product*/
                    $product_name_exist = $this->Fooditem_Model->is_product_name_exist($product_name);
                    if (!$product_name_exist) {
                        $is_inserted = $this->Fooditem_Model->save($form_data);
                        $responseData['isSave'] = $is_inserted;
                        if ($is_inserted) {
                            $responseData['responseMessage'] = 'Product information has been saved successfully';
                        } else {
                            $responseData['responseMessage'] = 'Product information is not saved successfully';
                        }
                    } else {
                        $responseData['responseMessage'] = 'Product name already exists';
                    }
                }
            }

            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function delete($id = 0) {
        if ($this->checkMethod('POST')) {
            $isDeleted = $this->Fooditem_Model->delete(intval($id));
            $responseMessage = ($isDeleted) ? 'Product is deleted successfully' : 'Product is not deleted';
            $responseData = array('isDeleted' => $isDeleted,'responseMessage' => $responseMessage,);
            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function all_menus() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
            if ($this->is_token_verified()) {
                $m_deals = new Deals_Model();
                $m_show_side_dish = new Showsidedish_Model();
                $product_object = new Product();

                $request_body = file_get_contents('php://input');
                $data = json_decode($request_body);

                $categories = $product_object->get_categories();
                $currentDayName = strtolower(date('l'));
                $categories_array = array();
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        $category_id = $category->categoryId;
                        $category_array = array();
                        $category_array = (array) $category;
                        if ($category->isPackage) {
                            $category_array['packages'] = $m_deals->getDealsItemByCategory($category);
                            $category_array['products'] = null;
                        } else {
                            $products = $product_object->get_product_by_category_id($category_id);
                            $products_array = array();
                            if (!empty($products)) {
                                $product_array = array();
                                $i = 0;
                                foreach ($products as $product) {
                                    $sub_products_array = array();
                                    $product_array = json_decode(json_encode($product),true);
                                    $product_id = $product->foodItemId;
                                    $sub_products = $product_object->get_sub_product($product_id);
                                    if (!empty($sub_products)) {
                                        $sub_products_array = json_decode(json_encode($sub_products),true);
                                    }
                                    $product_array['has_sub_product'] = (!empty($sub_products_array)) ? 1 : 0;
                                    $product_array['sub_products'] = $sub_products_array;
                                    array_push($products_array,$product_array);
                                }
                            }
                            // set all products
                            $category_array['products'] = $products_array;
                            $category_array['packages'] = null;
                        }
                        array_push($categories_array,$category_array);
                    }
                }

                $dealsCategories = $product_object->get_deals_categories();
                $dealsCategoriesArray = array();
                if (!empty($dealsCategories)) {
                    $mDeals = new Deals_Model();
                    foreach ($dealsCategories as $dealsCategory) {
                        $dealsCategoryArray = array();
                        if($dealsCategory->isDeals){
                            $dealsArray = $mDeals->getDealsItemByCategory($dealsCategory);
                            $dealsCategoryArray = (array)$dealsCategory;
                            $dealsCategoryArray['deals'] = $dealsArray;
                        }
                        array_push($dealsCategoriesArray,$dealsCategoryArray);
                    }
                }

                $allAssignedModifiersAsProductCategory = $m_show_side_dish->get_all_assigned_modifiers_as_product_categories();
                $showSideDish = $m_show_side_dish->get();
                $m_sideDish = new Sidedishes_Model();
                $allSideDishesAsModifierCategory = $m_sideDish->getAllAsModifierCategories();
                $m_modifier_category = new Modifier_Category_Model();
                $modifiersCategories = $m_modifier_category->get_all();
                $freeItemsDetails = $this->FreeItem_Model->getFreeItemDetailsForApi();
                $data = array(
                    'categories'=>$categories_array,
                    'dealsName'=>$product_object->get_offers_or_deals_name(),
                    'dealsCategories'=>(!empty($dealsCategoriesArray))?$dealsCategoriesArray:null,
                    'showSideDishes'=>$showSideDish,
                    'modifiersCategories'=>$modifiersCategories,
                    'allSideDishesAsModifierCategory'=>$allSideDishesAsModifierCategory,
                    'freeItemsDetails' => $freeItemsDetails,
                );

                $response_data = array('status'=>200,'message'=>'Menu data is provided','data'=>$data,);
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $response_data = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad Request',);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
    }

    public function update_menu() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
            if ($this->is_token_verified()) {
                $data = $this->input->post('data');
                if ($data) {
                    $data = json_decode($data);
                    $id = $data->id;
                    $level = $data->level;
                    if ($id || $level) {
                        $is_closed_for_today = $data->is_closed_for_today;
                        $is_deactive = $data->is_deactive;
                        if ($is_closed_for_today != "" && $is_deactive != "") {
                            if ($level == 1) {
                                $table_name = 'category';
                                $this->db->where('categoryId',$id);
                            } else if ($level == 2) {
                                $table_name = 'fooditem';
                                $this->db->where('foodItemId',$id);
                            } else if ($level == 3) {
                                $table_name = 'selectionitems';
                                $this->db->where('categoryId',$id);
                            } else if ($level == 4) {
                                $table_name = 'category';
                                $this->db->where('categoryId',$id);
                                $this->db->where('isDeals',1);
                            } else if ($level == 5) {
                                $table_name = 'deals';
                                $this->db->where('id',$id);
                            }

                            $date = null;
                            if ($is_closed_for_today == 1) {
                                $date = date('Y-m-d');
                                $active_status = 0;
                            } else {
                                $active_status = 0;
                                if ($is_deactive == 0) {
                                    $active_status = 1;
                                }
                            }

                            // echo $active_status;
                            // dd($data);
                            $value = array('active' => $active_status,'date' => $date);
                            $this->db->update($table_name, $value);

                            if ($this->db->affected_rows() >= 0) {
                                $response_data = array('status'=>200,'message'=>'Update Menu Succesfully');
                            } else if ($this->db->trans_status() === FALSE) {
                                $response_data = array('status'=>200,'message'=>'Update Failed');
                            }
                        } else {
                            $response_data = array('status'=>400,'message'=>'Bad Request');
                        }                
                    } else {
                        $response_data = array('status'=>400,'message'=>'Bad Request');
                    }
                } else {
                    $response_data = array('status'=>400,'message'=>'Bad Request');
                }
            } else {
                $response_data = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad Request');
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
    }
}