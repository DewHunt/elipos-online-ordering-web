<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Frontend_Controller
{
    public $product;
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('product');
        $this->load->library('cart');
        $this->load->library('user_agent');
        $this->load->helper('form');
        $this->load->helper('settings_helper');
        $this->load->helper('shop_helper');
        $this->load->helper('product_helper');
        $this->load->model('Customer_Model');
        $this->load->model('Deals_Model');      
        $this->load->model('Voucher_Model');
        $this->load->model('Deals_Item_Model');
        $this->load->model('Settings_Model');
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Shop_timing_Model');
        $this->load->model('FreeItem_Model');
        $this->load->model('Showsidedish_Model');
        $this->load->model('Allowed_miles_Model');
        $this->load->model('Table_model');
        $this->load->model('sqlite/House_information_model');
        $this->load->model('Booking_customer_Model');
        $this->load->model('Fooditem_Model');
        $this->load->model('Selectionitems_Model');
        $this->load->model('Sidedishes_Model');
        $this->data['is_valid_postcode'] = false;
        $this->product = new Product();
        isTodayIsHoliday();
    }

    public function index() {
        // dd($this->session->userdata());
        // dd(is_home_promo_active_for_menu());
        $this->Customer_Model->logout_guest_customer();

        $this->FreeItem_Model->removeAllFreeItem();

        $order_type = $this->input->get('OrderType', true);
        $order_type = xss_clean($order_type);
        $order_type_status_based_on_url = true;
        set_order_type_to_session($order_type);
        if (!empty($order_type) && $order_type == 'dine_in') {
            $order_type_status_based_on_url = false;
        }
        $this->session->set_userdata('menu_page_session', base_url('menu'));

        $this->data['price'] = 0;
        $this->data['quantity'] = 0;
        $this->data['product_object'] = $this->product;
        $this->data['title'] = "Menu";
        $this->data['order_type_status_based_on_url'] = $order_type_status_based_on_url;
        $this->data['product_cart'] = $this->load->view('cart/index', $this->data, true);
        $this->data['cart_content'] = $this->load->view('menu2/content_cart', $this->data, true);
        $this->data['shop_open_close_modal'] = $this->load->view('shop_open_close_modal', $this->data, true);

        $this->page_content = $this->load->view('menu2/index', $this->data, true);
        $this->footer = $this->load->view('footer', $this->data, true);
        $this->load->view('index', $this->data);
    }

    public function inside() {
        // redirect('menu');
        $this->data['product_object'] = $this->product;
        $this->data['title'] = "Menu";
        $this->data['shop_open_close_modal'] = $this->load->view('shop_open_close_modal', $this->data, true);
        $this->page_content = $this->load->view('menu2/inside', $this->data, true);
        $this->load->view('index', $this->data);
    }

    public function set_pre_order() {
        if ($this->input->is_ajax_request()) {
            if (is_shop_closed()) {
                $this->session->set_userdata('is_pre_order', true);
            } else {
                $this->session->set_userdata('is_pre_order', false);
            }
        }
    }

    public function add_product_buy_get_info_to_cart($category_id,$food_item_id) {
        $data = array();
        $is_item_buy_get_valid = is_buy_get_valid(0,$food_item_id);
        $data['is_buy_get_discount'] = false;
        $data['buy_get_id'] = 0;
        $data['buy_qty'] = false;
        $data['get_qty'] = false;
        if ($is_item_buy_get_valid) {
            $buy_get_id = $is_item_buy_get_valid->id;
            $data['is_buy_get_discount'] = true;
            $data['buy_get_id'] = $buy_get_id;
            $data['buy_qty'] = $is_item_buy_get_valid->buy_qty;
            $data['get_qty'] = $is_item_buy_get_valid->get_qty;
        } else {
            $is_category_product_buy_get_valid = is_buy_get_valid($category_id,$food_item_id);
            if ($is_category_product_buy_get_valid ) {
                $buy_get_id = $is_category_product_buy_get_valid->id;
                $data['is_buy_get_discount'] = true;
                $data['buy_get_id'] = $buy_get_id;
                $data['buy_qty'] = $is_category_product_buy_get_valid->buy_qty;
                $data['get_qty'] = $is_category_product_buy_get_valid->get_qty;
            } else {
                $is_category_buy_get_valid = is_buy_get_valid($category_id);
                if ($is_category_buy_get_valid ) {
                    $buy_get_id = $is_category_buy_get_valid->id;
                    $data['is_buy_get_discount'] = true;
                    $data['buy_get_id'] = $buy_get_id;
                    $data['buy_qty'] = $is_category_buy_get_valid->buy_qty;
                    $data['get_qty'] = $is_category_buy_get_valid->get_qty;
                }
            }
        }
        return $data;
    }

    public function add_to_cart() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('item_id');
            $quantity = $this->input->post('quantity');
            $comments = $this->input->post('comments');
            $comments = xss_clean($comments);
            $side_dish_ids = $this->input->post('side_dish_ids');

            $cart_content = $this->cart->contents();
            $is_product_exists = false;
            if ($cart_content) {
                foreach ($cart_content as $item) {
                    $is_side_dish_diff = false;
                    if (isset($item['side_dish_ids']) && is_array($side_dish_ids) && empty(array_diff($item['side_dish_ids'], $side_dish_ids)) && empty(array_diff($side_dish_ids,$item['side_dish_ids']))) {
                        $is_side_dish_diff = true;
                    }
                    if (isset($item['product_id']) && $item['product_id'] == $id && $is_side_dish_diff === true) {
                        $category_id = $item['category_id'];
                        $is_product_exists = true;
                        $isAddedToCart = true;
                        $data = array(
                            'rowid' => $item['rowid'],
                            'qty' => $item['qty'] + $quantity
                        );
                        $is_updated = $this->cart->update($data);
                        if ($item['is_buy_get_discount'] === true) {
                            $this->update_cart_data_for_buy_get_amount($category_id);
                        }
                    }
                }
            }

            if ($is_product_exists === false) {
                $this->data['quantity'] = $quantity;
                $side_dish_description = '';
                $side_dish_total_price = 0;
                $order_type = 'both';
                $isAddedToCart = false;
                $side_dish_id_array = array();
                if (!empty($side_dish_ids)) {
                    $side_dishes = $this->product->get_side_dishes_by_ids($side_dish_ids);
                    foreach ($side_dishes as $side_dish) {
                        if (!empty($side_dish)) {
                            $side_dish_total_price += $side_dish->UnitPrice;
                            $side_dish_info_array = array(
                                'id' => $side_dish->SideDishesId,
                                'side_dish_name' => $side_dish->SideDishesName,
                                'unit_price' => $side_dish_total_price,
                                'vat' => $side_dish->VatRate,
                            );
                            array_push($side_dish_id_array, $side_dish->SideDishesId);
                            $side_dish_description .= $side_dish->SideDishesName . ' + ';
                        }
                    }
                    $side_dish_description = substr($side_dish_description, 0, -3);
                    $side_dish_description = '( ' . $side_dish_description . ' )';
                }

                $order_type = '';
                $product = $this->product->get_product(trim($id));
                $session_order_type = get_sess_order_type();
                $vat_rate = $product->vatRate;
                $product_id = $product->foodItemId;
                $name = $product->foodItemName;
                if ($product->food_item_printed_description) {
                    $name .= $product->food_item_printed_description;
                }
                $category_id = $product->categoryId;
                $regular_price = $this->product->get_product_price_by_order_type(trim($id),$session_order_type);

                if ($product) {
                    $order_type = $product->order_type;
                    if ((!empty($side_dish_info_array))) {
                        $side_dish_price = $side_dish_info_array['unit_price'];
                        $price = $regular_price + $side_dish_price;
                        $item_vat = ($vat_rate * $price) / 100;
                        $data = array (
                            'id' => $t = time(),
                            'isDeal' => false,
                            'product_id' => $product_id,
                            'category_id' => $category_id,
                            'sub_product_id' => 0,
                            'name' => $name,
                            'qty' => $quantity,
                            'price' => $price,
                            'regular_price' => $regular_price,
                            'vat' => $item_vat,
                            'side_dish' => $side_dish_description,
                            'cat_level' => 3,
                            'side_dish_ids' => $side_dish_id_array,
                            'side_dish_name' => $side_dish_info_array['side_dish_name'],
                            'side_dish_price' => $side_dish_info_array['unit_price'],
                            'side_dish_vat' => $side_dish_info_array['vat'],
                            'order_type' => $order_type,
                            'is_category_discount' => $product->categoryIsDiscount,
                            'is_item_discount' => $product->isDiscount,
                            'is_deals_discount' => 0,
                        );
                    } else {
                        $item_vat = ($vat_rate * $regular_price) / 100;
                        $data = array(
                            'id' => $t = time(),
                            'isDeal' => false,
                            'product_id' => $product_id,
                            'category_id' => $category_id,
                            'sub_product_id' => 0,
                            'name' => $name,
                            'qty' => $quantity,
                            'price' => $regular_price,
                            'regular_price' => $regular_price,
                            'vat' => $item_vat,
                            'side_dish' => $side_dish_description,
                            'cat_level' => 3,
                            'order_type' => $order_type,
                            'is_category_discount' => $product->categoryIsDiscount,
                            'is_item_discount' => $product->isDiscount,
                            'is_deals_discount' => 0,
                        );
                    }
                    $data['printed_description'] = $product->food_item_printed_description;

                    $product_buy_get_info = $this->add_product_buy_get_info_to_cart($product->categoryId,$product->foodItemId);
                    $data['is_buy_get_discount'] = $product_buy_get_info['is_buy_get_discount'];
                    $data['buy_get_id'] = $product_buy_get_info['buy_get_id'];
                    $data['buy_qty'] = $product_buy_get_info['buy_qty'];
                    $data['get_qty'] = $product_buy_get_info['get_qty'];
                    $data['free_item_qty'] = 0;
                    $data['buy_get_amount'] = 0;
                    $data['comments'] = $comments;

                    if (isItemAddAbleToCart($order_type)) {
                        $isAddedToCart = true;
                        $this->cart->insert($data);
                    }
                    
                    if ($data['is_buy_get_discount'] === true) {
                        $this->update_cart_data_for_buy_get_amount($category_id,$data['buy_get_id']);
                    }
                }
            }

            $cart_content = $this->load->view('cart/index', $this->data, true);
            $mobile_cart = $this->load->view('cart/mobile', $this->data, true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'modal' => null,
                'mobile_cart' => $mobile_cart,
                'isAddedToCart' => $isAddedToCart,
                'cart_content' => $cart_content,
                'hasSideDish' => false,
                'sideDishesAsCategory' => null
            )));
        } else {
            redirect('menu');
        }
    }

    public function update_cart_data_for_buy_get_amount($category_id = 0,$buy_get_id = 0) {
        $cart_contents = $this->cart->contents();
        $buy_get_amount = 0;
        $total_qty = 0;
        $buy_qty = 0;
        $get_qty = 0;
        $buy_get_cart_contents = array();

        foreach ($cart_contents as $cart_item) {
            if ($cart_item['is_buy_get_discount'] === true && $cart_item['category_id'] == $category_id && $cart_item['buy_get_id'] == $buy_get_id) {
                $total_qty += $cart_item['qty'];
                $buy_qty = $cart_item['buy_qty'];
                $get_qty = $cart_item['get_qty'];

                if ($cart_item['buy_get_amount'] > 0) {
                    $updateData = array(
                        'rowid' => $cart_item['rowid'],
                        'free_item_qty' => 0,
                        'buy_get_amount' => 0,
                    );
                    $this->cart->update($updateData);
                }
                array_push($buy_get_cart_contents, $cart_item);
            }            
        }
        // dd($buy_get_cart_contents);
        $regular_price = array_column($buy_get_cart_contents,'regular_price');
        array_multisort($regular_price,SORT_ASC,$buy_get_cart_contents);

        $multiplier = $buy_qty + 1;
        $offerQty = intval($total_qty / $multiplier);
        // if (($total_qty - ($total_qty % $multiplier)) % $multiplier == 0) {
            // $offerQty = intval($total_qty / $multiplier);
        // }

        if ($buy_get_cart_contents) {
            $updateData = array();
            foreach ($buy_get_cart_contents as $buy_get_cart_item) {
                if ($buy_get_cart_item['qty'] != 0 && $offerQty > $buy_get_cart_item['qty']) {
                    $offerQty -= $buy_get_cart_item['qty'];
                    $buy_get_amount = ($buy_get_cart_item['qty'] * $get_qty * $buy_get_cart_item['regular_price']);
                    $cart_data = array(
                        'rowid' => $buy_get_cart_item['rowid'],
                        'free_item_qty' => $buy_get_cart_item['qty'],
                        'buy_get_amount' => $buy_get_amount,
                    );
                    array_push($updateData, $cart_data);
                } else {
                    $buy_get_amount = ($offerQty * $get_qty * $buy_get_cart_item['regular_price']);
                    $cart_data = array(
                        'rowid' => $buy_get_cart_item['rowid'],
                        'free_item_qty' => $offerQty,
                        'buy_get_amount' => $buy_get_amount,
                    );
                    array_push($updateData, $cart_data);
                    break;
                }
            }
            $this->cart->update($updateData);
        }
    }

    public function update_cart() {
        if ($this->input->is_ajax_request()) {
            $this->data['price'] = 0;
            $this->data['quantity'] = 0;
            $current_quantity = 0;
            $data = $_POST;
            $row_id = $data['row_id'];
            $plus_minus = $data['plus_minus'];
            // $previous_quantity = $data['qty'];
            $item = $this->cart->get_item($row_id);

            $id = $data['id'];
            $is_updated = false;
            if (!empty($item)) {
                $previous_quantity = $item['qty'];
                $buy_get_id = $item['buy_get_id'];

                if ($plus_minus == 'plus') {
                    $data = array(
                        'rowid' => $row_id,
                        'qty' => ($previous_quantity + 1)
                    );
                    $is_updated = $this->cart->update($data);
                } else {
                    if ($previous_quantity > 1) {
                        $data = array(
                            'rowid' => $row_id,
                            'qty' => ($previous_quantity - 1)
                        );
                        $is_updated = $this->cart->update($data);
                    }
                }
                if ($item['is_buy_get_discount'] === true) {
                    $category_id = $item['category_id'];
                    $this->update_cart_data_for_buy_get_amount($category_id,$buy_get_id);
                }
                $item = $this->cart->get_item($row_id);
            }

            $cart_content = $this->load->view('cart/index', $this->data, true);
            $mobile_cart = $this->load->view('cart/mobile', $this->data, true);

            $m_customer = new Customer_Model();
            $order_type = $this->session->userdata('order_type_session');
            $cart_total = $this->cart->total();
            $customer_id = 0;
            if($m_customer->customer_is_loggedIn()){
                $customer_id = $m_customer->get_logged_in_customer_id();
            }
            $discount = $m_customer->get_discount_amount($this->cart->contents(),$order_type,$customer_id);

            // $total_amount = $cart_total - $discount;

            $delivery_charge = 0;
            if (!empty($order_type)) {
                if ($order_type == 'collection') {
                    $delivery_charge = 0;
                } else if ($order_type == 'delivery') {
                    $delivery_charge = (!empty($this->session->userdata('delivery_charge'))) ? $this->session->userdata('delivery_charge') : 0;
                }
            } else {
                $delivery_charge = 0;
                $this->session->set_userdata('order_type_session', 'collection');
            }

            $total_amount = ($cart_total + $delivery_charge) - $discount;

            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                    'mobile_cart' => $mobile_cart,
                    'cart_content' => $cart_content,
                    'price' => get_array_key_value('subtotal', $item),
                    'quantity' => get_array_key_value('qty', $item),
                    'isUpdated' => $is_updated,
                    'total' => get_price_text($total_amount),
                    'subTotal' => get_price_text($cart_total),
                    'discount' => get_price_text($discount),
                    'deliveryCharge' => get_price_text($delivery_charge),
                )
            ));
        }
    }

    public function get_product() {
        if ($this->input->is_ajax_request()) {
            $product_id = $this->input->post('product_id');
            $session_order_type = get_sess_order_type();
            $product = null;
            $modal = null;
            $product_order_type = null;
            $status = null;

            if (!empty($product_id)) {
                $product = $this->Fooditem_Model->get($product_id);
                $get_product_availability = $this->product->get_product_availability_by_order_type($product_id,$session_order_type);
                $product_order_type = $get_product_availability['product_order_type'];
                $status = $get_product_availability['status'];

                $sideDishesAsCategory = array();
                if (!empty($product) and $status === true) {
                    // $m_show_side_dish = new Showsidedish_Model();
                    // $sideDishesAsCategory = $m_show_side_dish->get_product_assigned_modifiers($product->categoryId, $product->foodItemId);
                    $this->data['product'] = $product;
                    $modal = $this->load->view('menu2/product_modal', $this->data, true);
                }
            }

            $responseData = array(
                'product' => $product,
                'sideDishesAsCategory' => $sideDishesAsCategory,
                'modal' => $modal,
                'product_order_type' => $product_order_type,
                'status' => $status,
            );

            $this->output->set_content_type('application/json')->set_output(json_encode($responseData));
        } else {
            redirect('menu');
        }
    }

    public function get_sub_product() {
        if ($this->input->is_ajax_request()) {
            $product_id = $this->input->post('product_id');
            $productName = '';
            $modal = null;
            $product_order_type = null;
            $status = null;
            $session_order_type = get_sess_order_type();

            if (!empty($product_id)) {
                $get_product_availability = $this->product->get_product_availability_by_order_type($product_id,$session_order_type);
                $product_order_type = $get_product_availability['product_order_type'];
                $status = $get_product_availability['status'];

                $product = $this->Fooditem_Model->get_product_by_id($product_id);
                $sub_products = $this->Selectionitems_Model->get_sub_product_by_product_id($product_id);
                $productName = $product->foodItemName;
                // dd($sub_products);
                if (!empty($product) && !empty($sub_products) && $status === true) {
                    $this->data['sub_products'] = $sub_products;
                    $this->data['product'] = $product;
                    $modal = $this->load->view('menu2/sub_product_modal', $this->data, true);
                }
            }

            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'modal' => $modal,
                'productName' => $productName,
                'product_order_type' => $product_order_type,
                'status' => $status,
            )));
        } else {
            redirect('menu');
        }
    }

    public function get_sub_porduct_for_half_and_half() {
        if ($this->input->is_ajax_request()) {
            $category_id = $this->input->post('category_id');
            $product_id = $this->input->post('product_id');
            $sub_product_ids = $this->input->post('sub_product_ids');
            $selected_product_size_id = $this->input->post('selected_product_size_id');
            $portion = $this->input->post('portion');
            $output = '';
            if ($product_id) {
                $sub_products = array();
                if ($sub_product_ids) {
                    $sub_products = $this->Selectionitems_Model->get_sub_product_by_product_id_and_ids($product_id,$sub_product_ids);
                }
                $this->data['category_id'] = $category_id;
                $this->data['selected_product_size_id'] = $selected_product_size_id;
                $this->data['portion'] = $portion;
                $this->data['sub_products'] = $sub_products;
                $output = $this->load->view('menu2/half_sub_product_lists',$this->data,true);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('output'=>$output)));
        } else {
            redirect('menu');
        }
    }

    public function get_modifiers_for_half_and_half() {
        if ($this->input->is_ajax_request()) {
            $category_id = $this->input->post('category_id');
            $product_id = $this->input->post('product_id');
            $sub_product_id = $this->input->post('sub_product_id');
            $portion = $this->input->post('portion');
            if ($sub_product_id) {
                $this->data['category_id'] = $category_id;
                $this->data['product_id'] = $product_id;
                $this->data['sub_product_id'] = $sub_product_id;
                $this->data['portion'] = $portion;
                $modifiers = $this->Showsidedish_Model->get_sub_product_assigned_modifiers($category_id,$product_id,$sub_product_id);
                // dd($modifiers);
                $this->data['modifiers'] = $modifiers;
                $output = $this->load->view('menu2/half_modifier_lists',$this->data,true);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('output'=>$output)));
        } else {
            redirect('menu');
        }        
    }

    public function get_deal() {
        if ($this->input->is_ajax_request()) {
            $dealsId = $this->input->post('dealsId');
            $deal = $this->Deals_Model->get_by_id($dealsId);
            // dd($deal);
            $modal = null;
            if (!empty($deal)) {
                $deals_items = $this->Deals_Item_Model->get_by_deals_id($deal->id);
                // dd($deals_items);
                $total_deals_items_limit = $this->Deals_Item_Model->get_total_limit_by_deals_id($deal->id);
                $session_order_type = get_sess_order_type();

                $deal_or_offer_availability = $this->product->get_deals_or_offer_availability_by_order_type($dealsId,$session_order_type);
                $deal_order_type = $deal->deal_order_type;
                $status = $deal_or_offer_availability['status'];
                $is_half_and_half = intval($deal->is_half_and_half);

                if ($status === true) {
                    $this->data['deal'] = $deal;
                    $this->data['deals_items'] = $deals_items;
                    $this->data['total_deals_items_limit'] = $total_deals_items_limit->limit;
                    if ($is_half_and_half == 0) {
                        $this->data['deal_items_block'] = $this->load->view('menu/deal_items', $this->data, true);;
                        $modal = $this->load->view('menu/deals_modal', $this->data, true);
                    } else {
                        $half_deal_item = $deals_items[0];
                        $deal_item_id = $half_deal_item['id'];
                        $productIds = $half_deal_item['productIds'];
                        $subProductIds = $half_deal_item['subProductIds'];
                        $productIds = (!empty($productIds)) ? json_decode($productIds,true) : array();
                        $subProductIds = (!empty($subProductIds)) ? json_decode($subProductIds,true) : array();

                        $products = array();
                        if ($productIds) {
                            $this->Fooditem_Model->db->where_in('foodItemId',$productIds);
                            $products = $this->Fooditem_Model->get_all_products();
                        }
                        // dd($sub_products);

                        $this->data['deal_item_id'] = $deal_item_id;
                        $this->data['products'] = $products;
                        $this->data['sub_product_ids'] = implode(',', $subProductIds);
                        $modal = $this->load->view('menu2/half_deals_modal', $this->data, true);
                    }                    
                }

                $responseData = array('modal'=>$modal,'deal_order_type'=>$deal_order_type,'status'=>$status,'is_half_and_half'=>$is_half_and_half);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($responseData));
        } else {
            redirect('menu');
        }
    }

    public function add_to_cart_sub_product() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('sub_product_id');
            $quantity = $this->input->post('quantity');
            $this->data['quantity'] = $quantity;
            $sub_product = $this->product->get_sub_product_by_id(trim($id));
            $isAddedToCart = false;
            $modal = '';
            $hasSideDish = false;
            if (!empty($sub_product)) {
                $sub_product_category_id = $this->Selectionitems_Model->get_sub_product_category_id($sub_product->selectiveItemId);
                $sideDishesAsCategory = $this->Showsidedish_Model->get_sub_product_assigned_modifiers($sub_product_category_id->categoryId,$sub_product->foodItemId,$sub_product->selectiveItemId);
                $isAddedToCart = false;
                $hasSideDish = true;
                $this->data['sub_product'] = $sub_product;
                $this->data['assigned_modifier_by_category_id'] = $sideDishesAsCategory;
                $modal = $this->load->view('menu2/sub_product_with_modifier_modal', $this->data, true);
            }

            $cart_content = $this->load->view('cart/index', $this->data, true);
            $mobile_cart = $this->load->view('cart/mobile', $this->data, true);

            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'modal' => $modal,
                'mobile_cart' => $mobile_cart,
                'cart_content' => $cart_content,
                'isAddedToCart' => $isAddedToCart,
                'hasSideDish' => $hasSideDish
            )));
        } else {
            redirect('menu');
        }
    }

    public function add_to_cart_sub_product_with_modifier() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('item_id');
            $side_dish_ids = $this->input->post('side_dish_ids');
            $comments = $this->input->post('comments');
            $comments = (!empty($comments)) ? xss_clean($comments) : '';
            $quantity = $this->input->post('quantity');
            $side_dish_description = '';
            $side_dish_total_price = 0;

            $side_dish_id_array = array();
            if (!empty($side_dish_ids)) {
                $side_dishes = $this->product->get_side_dishes_by_ids($side_dish_ids);
                foreach ($side_dishes as $side_dish) {
                    if (!empty($side_dish)) {
                        $side_dish_total_price += $side_dish->UnitPrice;
                        $side_dish_info_array = array(
                            'id' => $side_dish->SideDishesId,
                            'side_dish_name' => $side_dish->SideDishesName,
                            'unit_price' => $side_dish_total_price,
                            'vat' => $side_dish->VatRate,
                        );
                        array_push($side_dish_id_array, $side_dish->SideDishesId);
                        $side_dish_description .= $side_dish->SideDishesName . ' + ';
                    }
                }
                $side_dish_description = substr($side_dish_description, 0, -3);
                $side_dish_description = '( ' . $side_dish_description . ' )';
            }

            $order_type = '';
            $sub_product = $this->product->get_sub_product_by_id(trim($id));
            $session_order_type = get_sess_order_type();
            $isAddedToCart = false;
            $data = array();
            if (!empty($sub_product)) {
                // $price = $sub_product->takeawayPrice;
                $regular_price = $this->product->get_product_price_by_order_type($sub_product->foodItemId,$session_order_type,$sub_product->selectiveItemId,true);
                $order_type = $sub_product->order_type;

                $vat_rate = $sub_product->vatRate;
                $name = $sub_product->selectiveItemName;
                if ($sub_product->selection_item_printed_description) {
                    $name .= $sub_product->selection_item_printed_description;
                }
                $food_item_id = $sub_product->foodItemId;
                $category_id = $sub_product->categoryId;
                if ((!empty($side_dish_info_array))) {
                    $side_dish_price = $side_dish_info_array['unit_price'];
                    $price = $regular_price + $side_dish_price;
                    $item_vat = ($vat_rate * $price) / 100;
                    $data = array(
                        'id' => $t = time(),
                        'isDeal' => false,
                        'product_id' => $food_item_id,
                        'category_id' => $category_id,
                        'sub_product_id' => $sub_product->selectiveItemId,
                        'name' => $name,
                        'qty' => $quantity,
                        'price' => $price,
                        'regular_price' => $regular_price,
                        'vat' => $item_vat,
                        'side_dish' => $side_dish_description,
                        'cat_level' => 3,
                        'side_dish_ids' => $side_dish_id_array,
                        'side_dish_name' => $side_dish_info_array['side_dish_name'],
                        'side_dish_price' => $side_dish_info_array['unit_price'],
                        'side_dish_vat' => $side_dish_info_array['vat'],
                        'order_type' => $order_type,
                        'is_category_discount' => $sub_product->categoryIsDiscount,
                        'is_item_discount' => $sub_product->isDiscount,
                        'is_deals_discount' => 0,
                    );
                } else {
                    $item_vat = ($vat_rate * $regular_price) / 100;
                    $data = array(
                        'id' => $t = time(),
                        'isDeal' => false,
                        'product_id' => $food_item_id,
                        'category_id' => $category_id,
                        'sub_product_id' => $sub_product->selectiveItemId,
                        'name' => $name,
                        'qty' => $quantity,
                        'price' => $regular_price,
                        'regular_price' => $regular_price,
                        'vat' => $item_vat,
                        'side_dish' => $side_dish_description,
                        'food_item_id' => $food_item_id,
                        'cat_level' => 4,
                        'order_type' => $order_type,
                        'is_category_discount' => $sub_product->categoryIsDiscount,
                        'is_item_discount' => $sub_product->isDiscount,
                        'is_deals_discount' => 0,
                    );

                }
                $data['printed_description'] = $sub_product->selection_item_printed_description;

                $product_buy_get_info = $this->add_product_buy_get_info_to_cart($category_id,$sub_product->foodItemId);
                $data['is_buy_get_discount'] = $product_buy_get_info['is_buy_get_discount'];
                $data['buy_get_id'] = $product_buy_get_info['buy_get_id'];
                $data['buy_qty'] = $product_buy_get_info['buy_qty'];
                $data['get_qty'] = $product_buy_get_info['get_qty'];
                $data['free_item_qty'] = 0;
                $data['buy_get_amount'] = 0;
                $data['comments'] = $comments;

                $isAddedToCart = true;
            }

            if (!empty($data)) {
                $data['comments'] = $comments;
                $this->cart->insert($data);
            }
            if ($data['is_buy_get_discount'] === true) {
                $this->update_cart_data_for_buy_get_amount($category_id,$data['buy_get_id']);
            }
            $cart_content = $this->load->view('cart/index', $this->data, true);
            $mobile_cart= $this->load->view('cart/mobile', $this->data, true);

            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'mobile_cart' => $mobile_cart,
                'cart_content' => $cart_content,
                'isAddedToCart' => $isAddedToCart
            )));
        } else {
            redirect('menu');
        }
    }

    public function remove_item_from_cart() {
        if ($this->input->is_ajax_request()) {
            $this->data['price'] = 0;
            $this->data['quantity'] = 0;
            $data = $this->cart->contents();
            $row_id = $_POST['row_id'];            
            $item = $this->cart->get_item($row_id);
            $is_buy_get_discount = isset($item['is_buy_get_discount']) ? $item['is_buy_get_discount'] : 0;
            $buy_get_id = isset($item['buy_get_id']) ? $item['buy_get_id'] : 0;
            $category_id = isset($item['category_id']) ? $item['category_id'] : 0;
            $data[$row_id]['qty'] = 0;
            $this->cart->update($data);
                    
            if ($is_buy_get_discount === true) {
                $this->update_cart_data_for_buy_get_amount($category_id,$buy_get_id);
            }
            $cart_content = $this->load->view('cart/index', $this->data, true);
            $mobile_cart= $this->load->view('cart/mobile', $this->data, true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'mobile_cart' => $mobile_cart,
                'cart_content' => $cart_content,
            )));
        }
    }

    public function get_cart_view() {
        if ($this->input->is_ajax_request()) {
            $cart_content = $this->load->view('cart/index', $this->data, true);
            $mobile_cart = $this->load->view('cart/mobile', $this->data,true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'cart_content'=>$cart_content,
                'mobile_cart'=>$mobile_cart
            )));
        }
    }

    public function deals_add_to_cart() {
        if ($this->input->is_ajax_request()) {
            $dealId = $this->input->post('dealId');
            $dealDetails = $this->input->post('dealDetails');

            // check order type of deals and order types of customer
            $order_type = 'both';
            $deal = $this->Deals_Model->get_by_id($dealId);
            $order_type = $deal->order_type;
            $dealPrice = $deal->price;
            $totalDealsPrice = $dealPrice;
            $dealItems = $this->Deals_Item_Model->get_by_deals_id($dealId);
            $newDealItems = array();

            $totalModifierPrice = 0;
            $productsText = '';

            foreach ($dealItems as $item) {
                $limit = 0;
                $elements = $this->Deals_Model->getDealsItem($dealDetails, $item['id']);
                $dealsItem = array();
                $itemProducts = array();
                foreach ($elements as $element) {
                    $limit++;
                    if ($item['limit'] < $limit) {
                        break;
                    }

                    $itemDetails = array();
                    $productId = $element['productId'];
                    $subProductId = $element['subProductId'];
                    $element_quantity = $element['quantity'];
                    $product = null;
                    $subProduct = null;
                    if (!empty($productId)) {
                        $product = $this->Fooditem_Model->get_product_by_id(trim($productId));
                    }

                    if (!empty($subProductId)) {
                        $subProduct = $this->Selectionitems_Model->get_sub_product_by_id(trim($subProductId));
                        $productsText = (empty($productsText)) ? $subProduct->selectiveItemName : $productsText.'+'.$subProduct->selectiveItemName;
                    } else {
                        if (!empty($product)) {
                            $productsText = (empty($productsText)) ? $product->foodItemName : $productsText.'+'.$product->foodItemName;
                        }
                    }

                    $modifiers = array_key_exists('modifiers', $element) ? $element['modifiers'] : null;
                    $newModifiers = array();
                    if (!empty($modifiers)) {
                        $modifierText = '';
                        foreach ($modifiers as $modifier) {
                            $sideDishesId = $modifier['id'];
                            $quantity = $modifier['quantity'];
                            $newModifier = $this->Sidedishes_Model->get_modifier_by_id(trim($sideDishesId));
                            if (!empty($newModifier)) {
                                $modifierText = empty($modifierText) ? $newModifier->SideDishesName : $modifierText.'+'.$newModifier->SideDishesName;
                                $modifierUnitPrice = $newModifier->UnitPrice;
                                $totalModifierPrice += $quantity * $modifierUnitPrice;
                                $newModifier = (array)$newModifier;
                                $newModifier['quantity'] = $quantity;

                                array_push($newModifiers, $newModifier);
                            }
                        }
                        $productsText .= " [{$modifierText}]";
                    }

                    $itemDetails['portion'] = '';
                    $itemDetails['quantity'] = $element_quantity;
                    $itemDetails['product'] = $product;
                    $itemDetails['subProduct'] = $subProduct;
                    $itemDetails['modifiers'] = $newModifiers;
                    array_push($itemProducts, $itemDetails);
                }

                $dealsItem['isHalfDeal'] = false;
                $dealsItem['productsText'] = $productsText;
                $dealsItem['id'] = $item['id'];
                $dealsItem['title'] = $item['title'];
                $dealsItem['description'] = $item['description'];
                $dealsItem['limit'] = $item['limit'];
                $dealsItem['dealsId'] = $item['dealsId'];
                $dealsItem['itemProducts'] = $itemProducts;
                array_push($newDealItems, $dealsItem);
            }

            $name = $deal->title;
            if ($deal->deal_printed_description) {
                $name .= $deal->deal_printed_description;
            }
            $productsText = "({$productsText})";

            $data = array(
                'id' => $t = time(),
                'name' => $name,
                'isDeal' => true,
                'qty' => 1,
                'price' => $totalDealsPrice + $totalModifierPrice,
                'deals' => array('deal' => $deal,'dealItems' => $newDealItems),
                'dealsText' => $productsText,
                'side_dish' => $productsText,
                'order_type' => $order_type,
                'is_category_discount' => 0,
                'is_item_discount' => 0,
                'is_deals_discount' => $deal->is_discount,
                'is_buy_get_discount' => false,
                'buy_get_id' => 0,
                'buy_qty' => false,
                'get_qty' => false,
                'free_item_qty' => 0,
                'buy_get_amount' => 0,
                'printed_description' => $deal->deal_printed_description,
            );

            // print_array($data);

            if (!empty($dealDetails)) {
                if (isItemAddAbleToCart($order_type)) {
                    $this->cart->insert($data);
                }
                $this->get_cart_view();
            }
        }
    }

    public function add_to_cart_half_and_half_deal() {
        if ($this->input->is_ajax_request()) {
            // dd($this->input->post());
            $deal_id = $this->input->post('deal_id');
            $deal_item_id = $this->input->post('deal_item_id');
            $total_deals_price = $this->input->post('total_price');
            $total_modifier_price = $this->input->post('total_modifier_price');

            $first_product_id = $this->input->post('first_product_id');
            $first_sub_product_id = $this->input->post('first_sub_product_id');
            $first_half_modifier_ids = $this->input->post('first_half_modifier_ids');
            $first_half_price = $this->input->post('first_half_price');
            $first_half_modifier_price = $this->input->post('first_half_modifier_price');

            $second_product_id = $this->input->post('second_product_id');
            $second_sub_product_id = $this->input->post('second_sub_product_id');
            $second_half_modifier_ids = $this->input->post('second_half_modifier_ids');
            $second_half_price = $this->input->post('second_half_price');
            $second_half_modifier_price = $this->input->post('second_half_modifier_price');

            $dealsItem = array();
            $itemProducts = array();
            $itemDetails = array();

            $deal = $this->Deals_Model->get_by_id($deal_id);
            $deal_item = $this->Deals_Item_Model->get_deal_item_by_id($deal_item_id);
            $order_type = 'both';
            $order_type = $deal->order_type;
            $products_text = '';
            $products_and_modifiers_text = '';
            $side_dish_text = '';
            $newDealItems = array();

            $first_product = $this->Fooditem_Model->get_product_by_id(trim($first_product_id));
            $first_sub_product = $this->Selectionitems_Model->get_sub_product_by_id(trim($first_sub_product_id));
            if ($first_half_modifier_ids) {
                $first_half_modifier_ids = implode(',', $first_half_modifier_ids);
            }
            $first_modifiers = $this->Sidedishes_Model->get_modifier_by_ids($first_half_modifier_ids);
            $products_text = $products_text.$first_sub_product->selectiveItemName;
            $products_and_modifiers_text = $products_and_modifiers_text.$first_sub_product->selectiveItemName;
            $new_modifiers = array();
            if ($first_modifiers) {
                $modifier_name = array();
                foreach ($first_modifiers as $modifier) {
                    array_push($modifier_name, $modifier->SideDishesName);
                    $modifier = (array) $modifier;
                    $modifier['quantity'] = 1;
                    array_push($new_modifiers, $modifier);
                }
                $modifier_name = '('.implode(' + ', $modifier_name).')';
                $products_and_modifiers_text = $products_and_modifiers_text.' '.$modifier_name; 
            }

            $itemDetails['portion'] = 'First Half';
            $itemDetails['quantity'] = 1;
            $itemDetails['product'] = $first_product;
            $itemDetails['subProduct'] = $first_sub_product;
            $itemDetails['modifiers'] = $new_modifiers;
            array_push($itemProducts, $itemDetails);

            $second_product = $this->Fooditem_Model->get_product_by_id(trim($second_product_id));
            $second_sub_product = $this->Selectionitems_Model->get_sub_product_by_id(trim($second_sub_product_id));
            if ($second_half_modifier_ids) {
                $second_half_modifier_ids = implode(',', $second_half_modifier_ids);
            }
            $second_modifiers = $this->Sidedishes_Model->get_modifier_by_ids($second_half_modifier_ids);
            $products_text = $products_text.' + '.$second_sub_product->selectiveItemName;
            $products_and_modifiers_text = $products_and_modifiers_text.' + '.$second_sub_product->selectiveItemName;
            $new_modifiers = array();
            if ($second_modifiers) {
                $modifier_name = array();
                foreach ($second_modifiers as $modifier) {
                    array_push($modifier_name, $modifier->SideDishesName);
                    $modifier = (array) $modifier;
                    $modifier['quantity'] = 1;
                    array_push($new_modifiers, $modifier);
                }
                $modifier_name = '('.implode(' + ', $modifier_name).')';
                $products_and_modifiers_text = $products_and_modifiers_text.' '.$modifier_name;
            }
            // dd($products_and_modifiers_text);

            $itemDetails['portion'] = 'Second Half';
            $itemDetails['quantity'] = 1;
            $itemDetails['product'] = $second_product;
            $itemDetails['subProduct'] = $second_sub_product;
            $itemDetails['modifiers'] = $new_modifiers;
            array_push($itemProducts, $itemDetails);

            $dealsItem['isHalfDeal'] = true;
            $dealsItem['productsText'] = $products_text;
            $dealsItem['id'] = $deal_item->id;
            $dealsItem['title'] = $deal_item->title;
            $dealsItem['description'] = $deal_item->description;
            $dealsItem['limit'] = $deal_item->limit;
            $dealsItem['dealsId'] = $deal_item->dealsId;
            $dealsItem['itemProducts'] = $itemProducts;
            array_push($newDealItems, $dealsItem);

            $data = array(
                'id' => $t = time(),
                'name' => $deal->title,
                'isDeal' => true,
                'qty' => 1,
                'price' => $total_deals_price,
                'deals' => array('deal'=>$deal,'dealItems'=>$newDealItems),
                'dealsText' => $products_and_modifiers_text,
                'side_dish' => $products_and_modifiers_text,
                'order_type' => $order_type,
                'is_category_discount' => 0,
                'is_item_discount' => 0,
                'is_deals_discount' => $deal->is_discount,
                'is_buy_get_discount' => false,
                'buy_get_id' => 0,
                'buy_qty' => false,
                'get_qty' => false,
                'free_item_qty' => 0,
                'buy_get_amount' => 0,
            );
            // dd($data);

            if ($first_product && $second_product) {
                if (isItemAddAbleToCart($order_type)) {
                    $this->cart->insert($data);
                }
                $this->get_cart_view();
            }
        } else {
            redirect('menu');
        }        
    }

    public function update_cart_buy_get_info() {
        $cart_contents = $this->cart->contents();
        if ($cart_contents) {
            foreach ($cart_contents as $cart) {
                if ($cart['isDeal'] == false) {
                    $category_id = isset($cart['category_id']) ? $cart['category_id'] : 0;
                    $product_id = isset($cart['product_id']) ? $cart['product_id'] : 0;
                    $product_buy_get_info = $this->add_product_buy_get_info_to_cart($cart['category_id'],$cart['product_id']);
                        
                    $updateData = array(
                        'rowid' => $cart['rowid'],
                        'is_buy_get_discount' => $product_buy_get_info['is_buy_get_discount'],
                        'buy_get_id' => $product_buy_get_info['buy_get_id'],
                        'buy_qty' => $product_buy_get_info['buy_qty'],
                        'get_qty' => $product_buy_get_info['get_qty'],
                        'free_item_qty' => 0,
                        'buy_get_amount' => 0,
                    );
                    $this->cart->update($updateData);
                }
            }
        }
    }

    public function update_cart_data_by_order_type() {
        $cart_contents = $this->cart->contents();
        $session_order_type = get_sess_order_type();
        if ($cart_contents) {
            foreach ($cart_contents as $cart) {
                $is_update = true;
                if (isset($cart['is_loyalty_program_discount']) && $cart['is_loyalty_program_discount'] == 1) {
                    $is_update = false;
                }

                if ($is_update) {
                    if (isset($cart['product_id']) && !empty($cart['product_id'])) {
                        $get_product_availability = $this->product->get_product_availability_by_order_type($cart['product_id'],$session_order_type);
                    }

                    if (isset($cart['deals']['deal']->id) && !empty($cart['deals']['deal']->id)) {
                        $get_product_availability = $this->product->get_deals_or_offer_availability_by_order_type($cart['deals']['deal']->id,$session_order_type);
                    }
                    $category_id = isset($cart['category_id']) ? $cart['category_id'] : 0;
                    $buy_get_id = isset($cart['buy_get_id']) ? $cart['buy_get_id'] : 0;

                    $rowid = $cart['rowid'];
                    if ($get_product_availability['status'] === true) {
                        $qty = $cart['qty'];
                        if (isset($cart['side_dish_price']) && $cart['side_dish_price'] > 0) {
                            $side_dish_price = $cart['side_dish_price'];
                        } else {
                            $side_dish_price = 0;
                        }

                        if (isset($cart['product_id']) && !empty($cart['product_id'])) {
                            $regular_price = $this->product->get_product_price_by_order_type($cart['product_id'],$session_order_type);
                            $price = $regular_price + $side_dish_price;
                        }

                        if (isset($cart['sub_product_id']) && !empty($cart['sub_product_id'])) {
                            $regular_price = $this->product->get_product_price_by_order_type($cart['product_id'],$session_order_type,$cart['sub_product_id'],true);
                            $price = $regular_price + $side_dish_price;
                        }

                        if (isset($cart['deals']['deal']->id) && !empty($cart['deals']['deal']->id)) {
                            $regular_price = $cart['price'];
                            $price = $regular_price + $side_dish_price;
                        }

                        if (isset($cart['isFree']) && $cart['isFree'] == true) {
                            $regular_price = $cart['price'];
                            $price = $regular_price + $side_dish_price;
                        }
                    } else {
                        $regular_price = 0;
                        $price = 0;
                        $qty = 0;
                    }
                    
                    $updateData = array(
                        'rowid' => $rowid,
                        'price' => $price,
                        'regular_price' => $regular_price,
                        'qty' => $qty,
                    );
                    $this->cart->update($updateData);
                            
                    if (isset($cart['is_buy_get_discount']) && $cart['is_buy_get_discount'] === true && isset($cart['is_reorder']) == false) {
                        $this->update_cart_data_for_buy_get_amount($category_id,$buy_get_id);
                    }
                }
            }
        }
    }

    public function get_order_type_session() {
        if ($this->input->is_ajax_request()) {
            $order_type = $this->input->post('order_type');
            $session_order_type = $this->session->userdata('order_type_session');
            $delivery_postcode = '';
            if ($this->input->post('delivery_postcode')) {
                $delivery_postcode = $this->input->post('delivery_postcode');
            } else if ($this->session->userdata('delivery_post_code')) {
                $delivery_postcode = $this->session->userdata('delivery_post_code');
            }            

            $cartData = $this->cart->contents();
            $cartOrderTypeChangeMessage = '';
            $isValidOrderType = true;
            // $isValidOrderType = isCartValidWithOrderType(trim($order_type),$cartData);

            if ($isValidOrderType) {
                set_order_type_to_session($order_type);
            } else {
                $cartHasItemOf = ($order_type == 'collection') ? 'Delivery' : 'Collection';
                $cartOrderTypeChangeMessage = 'Your cart has only for '.$cartHasItemOf.' Item';
            }

            $response_data['previous_total_cart_item'] = count($this->cart->contents());
            $this->update_cart_buy_get_info();
            $this->update_cart_data_by_order_type();
            $response_data['current_total_cart_item'] = count($this->cart->contents());
            $this->unset_dinein_table_from_session();

            $minimum_order_amount_for_collection = 0;
            $min_amount_for_free_delivery_charge = 0;
            $delivery_charge = 0;
            $minimum_order_amount = 0;

            if (!empty($delivery_postcode)) {
                $m_allowed_post_code_model = new Allowed_postcodes_Model();
                $delivery_details = $m_allowed_post_code_model->get_delivery_charge_by_postcode($delivery_postcode);

                if (!empty($delivery_details)) {
                    $delivery_charge = $delivery_details->delivery_charge;
                    $minimum_order_amount = $delivery_details->min_order_for_delivery;
                    $min_amount_for_free_delivery_charge = $delivery_details->min_amount_for_free_delivery_charge;
                    $delivery_postcode = $delivery_details->postcode;
                }
            }
            $this->session->set_userdata('delivery_charge', $delivery_charge);
            $this->session->set_userdata('minimum_order_amount', $minimum_order_amount);
            $this->session->set_userdata('min_amount_for_free_delivery_charge', $min_amount_for_free_delivery_charge);
            $this->session->set_userdata('delivery_post_code', $delivery_postcode);

            $current_order_type = $this->session->userdata('order_type_session');
            if ($current_order_type == 'collection') {
                $shop_details = get_company_details();
                $minimum_order_amount_for_collection = get_property_value('minimum_order_amount', $shop_details);
                $this->session->set_userdata('minimum_order_amount', $minimum_order_amount_for_collection);
            }

            $order_type = $this->session->userdata('order_type_session');
            $response_data['order_type'] = $order_type;
            $response_data['cartOrderTypeChangeMessage'] = $cartOrderTypeChangeMessage;
            $response_data['minimum_order_amount_for_collection'] = $minimum_order_amount_for_collection;
            $response_data['isValidWithOrderType'] = $isValidOrderType;
            $response_data['cart_data'] = $this->load->view('cart/index', $this->data, true);
            $response_data['mobile_cart_data'] = $this->load->view('cart/mobile', $this->data, true);
            $response_data['cart_summary'] = $this->load->view('cart/summary', $this->data, true);
            $is_pre_order = is_pre_order();
            $this->data['is_pre_order'] = $is_pre_order;
            // $this->order_type = $order_type;

            $response_data['delivery_collection_time'] = $this->load->view('my_account/delivery_collection_time', $this->data, true);
            $response_data['session_dine_in_table_number_id'] = $this->session->userdata('dine_in_table_number_id');
            $response_data['session_dine_in_table_number'] = $this->session->userdata('dine_in_table_number');

            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function get_all_tables() {
        $this->data['table_lists'] = $this->Table_model->get_all_table();
        $modal_data = $this->load->view('menu2/table_list',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('modal_data'=>$modal_data)));
    }

    public function set_dinein_table_in_session() {
        $table_number = $this->input->post('dine_in_table');
        $table_info = $this->Table_model->get_table_by_id($table_number);
        $this->session->set_userdata('dine_in_table_number_id',$table_info->id);
        $this->session->set_userdata('dine_in_table_number',$table_info->table_number);
        $session_dine_in_table_number_id = $this->session->userdata('dine_in_table_number_id');
        $session_dine_in_table_number = $this->session->userdata('dine_in_table_number');
        $cart_data = $this->load->view('cart/index',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'session_dine_in_table_number_id' => $session_dine_in_table_number_id,
            'session_dine_in_table_number' => $session_dine_in_table_number,
            'cart_data' => $cart_data
        )));
    }

    public function unset_dinein_table_from_session() {
        $session_order_type = get_sess_order_type();

        if ($session_order_type != 'dine_in') {
            $this->session->unset_userdata('dine_in_table_number_id');
            $this->session->unset_userdata('dine_in_table_number');
        }
    }

    public function getPostcodeSuggestion() {
        if ($this->input->is_ajax_request()) {
            $orderType = $this->input->post('order_type');
            if ($orderType == 'delivery') {
                $postcode = $this->input->post('postcode');
                $jsonPostcode = $this->getPostcodeByString($postcode);
                $jsonAddress = $this->getAdressByPostcode($postcode);

                // $jsonPostcodeResult = $this->getAdressByPostcode($postcode);
            } else {
                $postcodeArray = "";
            }

            $response_data['jsonPostcode'] = $jsonPostcode;
            $response_data['jsonAddress'] = $jsonAddress;

            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function addComa($previousData, $currentData) {
        if (!empty($previousData) && !empty($currentData)) {
            return ", ".$currentData;
        } else {
            return $currentData;
        }        
    }

    public function getPostcodeByString($postcode) {
        $postcodeList = $this->House_information_model->getPostcodeByString($postcode);
        $postcodeArray = array_column($postcodeList,'Postcode');
        return json_encode($postcodeArray);
    }

    public function getAdressByPostcode($postcode) {
        $postcodeResult = $this->House_information_model->getHouseInformationByPostcode($postcode);

        $addressArray = array();
        foreach ($postcodeResult as $singlePostCode) {
            $address = "";
            if ($singlePostCode->OrganisationName) {
                $address .= $singlePostCode->OrganisationName.', ';
            }
            
            if ($singlePostCode->BuildingName) {
                $address .= $singlePostCode->BuildingName;
            }

            if ($singlePostCode->SubBuilding) {
                $address .= $this->addComa($singlePostCode->BuildingName,$singlePostCode->SubBuilding);
            }

            if ($singlePostCode->BuildingNumber > 0) {
                $address .= ' '.$singlePostCode->BuildingNumber;
            }
            
            if ($singlePostCode->ThoroughfareAndDescriptor) {
                $address .= ' '.$singlePostCode->ThoroughfareAndDescriptor;
            }

            if ($singlePostCode->DependantThoroughfareAndDescriptor) {
                $address .= ', '.$singlePostCode->DependantThoroughfareAndDescriptor;
            }

            array_push($addressArray,trim($address));                    
        }

        return json_encode($addressArray);
    }

    public function get_delivery_charge_postcodewise() {
        //get input from delivery postcode textbox
        if ($this->input->is_ajax_request()) {
            $delivery_charge = 0;
            $postcode_first_three = '';
            $minimum_order_amount = 0;
            $min_amount_for_free_delivery_charge = 0;
            $response_data = array();

            $delivery_post_code = '';
            $is_valid_post_code = false;

            $order_type = $this->input->post('order_type');
            if (!empty($order_type) && $order_type === 'collection') {
                $delivery_charge = 0;
                $is_valid_post_code = true;
            } else {
                $postcode = trim($this->input->post('delivery_postcode'));
                $this->session->set_userdata('delivery_post_code', $postcode);

                $jsonPostcodeResult = $this->getAdressByPostcode($postcode);


                // first Check with geo location
                $m_allowed_miles = new Allowed_miles_Model();
                $allowed_miles = $m_allowed_miles->getDistanceDeliveryCharge($postcode);
                if (!empty($allowed_miles)) {
                    $delivery_charge = $allowed_miles->delivery_charge;
                    $minimum_order_amount = $allowed_miles->min_order_for_delivery;
                    $min_amount_for_free_delivery_charge = $allowed_miles->min_amount_for_free_delivery_charge;
                    $delivery_post_code = $postcode;
                    $is_valid_post_code = true;
                } else {
                    $m_allowed_post_code_model = new Allowed_postcodes_Model();
                    $delivery_details = $m_allowed_post_code_model->get_delivery_charge_by_postcode($postcode);
                    if (!empty($delivery_details)) {
                        $delivery_charge = $delivery_details->delivery_charge;
                        $minimum_order_amount = $delivery_details->min_order_for_delivery;
                        $min_amount_for_free_delivery_charge = $delivery_details->min_amount_for_free_delivery_charge;
                        $delivery_post_code = $delivery_details->postcode;
                        $is_valid_post_code = true;
                    }
                }
            }
            
            if (!$is_valid_post_code) {
                $response_data['message'] = $m_allowed_miles->get_miles_error_message();
            }

            $response_data['delivery_charge'] = $delivery_charge;
            $response_data['is_valid_post_code'] = $is_valid_post_code;
            $response_data['minimum_order_amount'] = $minimum_order_amount;
            $this->session->set_userdata('delivery_charge', $delivery_charge);
            $this->session->set_userdata('minimum_order_amount', $minimum_order_amount);
            $this->session->set_userdata('min_amount_for_free_delivery_charge', $min_amount_for_free_delivery_charge);
            $this->session->set_userdata('is_valid_post_code', $is_valid_post_code);
            $delivery_charge_session = $this->session->userdata('delivery_charge');
            $response_data['cart_data'] = $this->load->view('cart/index', $this->data, true);
            $response_data['cart_summary'] = $this->load->view('cart/summary', $this->data, true);
            $response_data['jsonPostcodeResult'] = $jsonPostcodeResult;

            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function get_delivery_type() {
        if ($this->input->is_ajax_request()) {
            $type = $this->input->post('delivery_type');
            $delivery_charge_info_array = array('message' => 'true','order_type' => 'collection');
            $this->session->set_userdata('delivery_charge_info_session', $delivery_charge_info_array);
            $this->data['product_cart'] = $this->load->view('cart/index', $this->data, true);
        }
    }

    public function get_current_order_type() {
        if ($this->input->is_ajax_request()) {
            $order_type = $this->session->userdata('order_type_session');
            $this->output->set_content_type('application/json')->set_output(json_encode(array('orderType' => $order_type)));
        }
    }

    public function reorder() {
        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            if ($this->input->is_ajax_request()) {
                if (!empty($this->cart->contents())) {
                    $this->cart->destroy();
                }

                $id = $this->input->post('id');
                $order_information = $this->Order_information_Model->get($id, true);
                set_sess_order_type($order_information->order_type);

                if (!empty($order_information)) {
                    $m_order_details = new Order_details_Model();
                    $order_details_column = array('order_id' => $order_information->id,'order_deals_id' => 0);
                    if ($this->FreeItem_Model->is_enabled_free_item() === false) {
                        $order_details_column['is_free'] = 0;
                    }
                    $order_details = $m_order_details->getDetails($order_details_column);
                    $count = 0;
                    if (!empty($order_details)) {
                        foreach ($order_details as $detail) {
                            $side_dish = $this->Order_side_dish_Model->get_where('order_details_id', $detail->id);
                            $side_dish_description = '';
                            $side_dish_total_price = 0;
                            $side_dish_id_array = array();
                            foreach ($side_dish as $dish) {
                                $side_dish = $this->product->get_side_dish_by_id(trim($dish->side_dish_id));
                                if (!empty($side_dish)) {
                                    $side_dish_total_price += $side_dish->UnitPrice;
                                    $side_dish_info_array = array(
                                        'id' => $side_dish->SideDishesId,
                                        'product_id' => $id,
                                        'side_dish_name' => $side_dish->SideDishesName,
                                        'unit_price' => $side_dish_total_price,
                                        'vat' => $side_dish->VatRate,
                                    );
                                    array_push($side_dish_id_array, $side_dish->SideDishesId);
                                    $side_dish_description .= $side_dish->SideDishesName . ' + ';
                                }
                            }
                            if (!empty($side_dish)) {
                                $side_dish_description = substr($side_dish_description, 0, -3);
                                $side_dish_description = '( ' . $side_dish_description . ' )';
                            }
                            $price = $detail->unit_price;
                            $regular_price = $detail->regular_price;
                            $vat_rate = $detail->vat_total;
                            $name = $detail->product_name;
                            $product_id = $detail->product_id;
                            $product_info = $this->product->get_product(trim($product_id));
                            $category_id = $product_info->categoryId;
                            $sub_product_id = $detail->selection_item_id;
                            $item_vat = ($vat_rate * $price) / 100;
                            $time = time();

                            $data = array(
                                'id' => $time + $count,
                                'isDeal' => false,
                                'product_id' => $product_id,
                                'category_id' => $category_id,
                                'isFree' => $detail->is_free,
                                'sub_product_id' => $sub_product_id,
                                'name' => $name,
                                'qty' => $detail->quantity,
                                'price' => $price,
                                'regular_price' => $regular_price,
                                'vat' => $item_vat,
                                'side_dish_ids' => $side_dish_id_array,
                                'side_dish' => $side_dish_description,
                                'cat_level' => $detail->cat_level,
                                'comments' => $detail->item_comments,
                                'order_type' => $product_info->order_type,
                                'is_category_discount' => $product_info->categoryIsDiscount,
                                'is_item_discount' => $product_info->isDiscount,
                                'is_deals_discount' => 0,
                            );

                            $product_buy_get_info = $this->add_product_buy_get_info_to_cart($category_id,$product_info->foodItemId);
                            $data['is_buy_get_discount'] = $product_buy_get_info['is_buy_get_discount'];
                            $data['buy_get_id'] = $product_buy_get_info['buy_get_id'];
                            $data['buy_qty'] = $product_buy_get_info['buy_qty'];
                            $data['get_qty'] = $product_buy_get_info['get_qty'];
                            $data['free_item_qty'] = 0;
                            $data['buy_get_amount'] = 0;
                            $data['is_reorder'] = true;
                            if (!empty($product_info)) {
                                if (isItemAddAbleToCart($product_info->order_type)) {
                                    $this->cart->insert($data);
                                    $count += 1;
                                }
                            }
                        }
                        $this->cart->contents();
                    }
                    $this->session->set_userdata('order_type_session', $order_information->order_type);
                    $this->data['product_cart'] = $this->load->view('cart/index', $this->data, true);
                }

                $this->output->set_content_type("application/json")->set_output(json_encode(array('status'=>true,'redirect'=>base_url('menu'))));
            }
        } else {
            redirect('menu');
        }
    }

    public function check_delivery_time() {
        //get input from delivery postcode textbox
        if ($this->input->is_ajax_request()) {          
            $company_details = $this->Settings_Model->get_by(array("name" => 'company_details'), true);
            $details = json_decode($company_details->value);
            // var_dump($details);
            
            $order_limit = 0;
            $order_type = get_sess_order_type();
            
            if($order_type == 'delivery'){
                $order_limit = get_property_value('per_slot_delivery_order',$details);                
            } elseif ($order_type == 'collection' || $order_type == 'dine_in') {                
                $order_limit = get_property_value('per_slot_collection_order',$details);
            }
            
            $delivery_time = $this->input->post('delivery_time');            
            
            $this->db->where('delivery_time', $delivery_time);
            $this->db->where('order_type', $order_type);
            $order_infos = $this->Order_information_Model->get();

            // $order_infos= $this->Order_information_Model->get_where('delivery_time',$delivery_time);
            // count($array);
            // var_dump(count($order_infos));
            
            if(count($order_infos)>=$order_limit && $delivery_time !='0000-00-00 00:00:00'){
                $response_data['result'] = 1;
            } else {
                $response_data['result'] = 0;
            }

            // $response_data['result'] = 0;
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function get_special_notes() {
        if ($this->input->is_ajax_request()) {
            $special_notes = $this->input->post('special_notes');
            $this->session->set_userdata('special_notes_session', $special_notes);
        }
    }
}