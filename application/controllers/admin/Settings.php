<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('shop_helper');
        $this->load->model('Settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Allowed_miles_Model');
        $this->load->model('Shop_timing_Model');
    }

    public function index() {
        if (is_user_permitted('admin/page_management/menu_review') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['company_details'] = $this->Settings_Model->get_by(array("name" => 'company_details'), true);
        $this->page_content = $this->load->view('admin/settings/index',$this->page_content_data,true);

        $this->data['title'] = "Settings";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function other_settings_save() {
        // dd($this->input->post());
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            // dd(date("w", strtotime('tomorrow')));
            $id = $this->input->post('id');
            $data['name'] = 'other_settings';
            $value = $this->Settings_Model->data_form_post(array('active_reservation','redirect_to_online_order'));

            $json_value = json_encode($value);
            $data['value'] = $json_value;
            // dd($value);

            if (empty($id)) {
                $this->Settings_Model->save($data);
            } else {
                $this->Settings_Model->where_column = 'id';
                $this->Settings_Model->save($data, $id);
            }
            $this->session->set_flashdata('save_message','Information has been Updated successfully');
            redirect(base_url('admin/settings'));
        } else {
            redirect($this->admin);
        }
    }

    //opening_and_closing
    public function opening_and_closing() {
        if (is_user_permitted('admin/settings/opening_and_closing') == false) {
            redirect(base_url('admin/dashboard'));
        }
        
        $this->page_content_data['title'] = "Opening And Closing Time";
        $this->page_content_data['shop_timing_list'] = $this->Shop_timing_Model->get_shop_timing_list();
        $this->page_content_data['collection_row'] = $this->Shop_timing_Model->count_row_for_collection_shop_timing();
        $this->page_content_data['delivery_row'] = $this->Shop_timing_Model->count_row_for_delivery_shop_timing();
        $this->page_content = $this->load->view('admin/settings/opening_and_closing',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/settings/maintenance_mode_js',$this->page_content_data,true);

        $this->data['title'] = "Opening And Closing Time | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add_opening_and_closing_time() {
        if (is_user_permitted('admin/settings/opening_and_closing') == false) {
            redirect(base_url('admin/dashboard'));
        }
        
        $this->page_content_data['title'] = "Add Opening And Closing Time";
        $this->page_content = $this->load->view('admin/settings/add_opening_and_closing_time',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/add_opening_and_closing_time_js',$this->page_content_data,true);

        $this->data['title'] = "Opening And Closing Time | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_opening_and_closing_time($id = 0) {
        if (is_user_permitted('admin/settings/opening_and_closing') == false) {
            redirect(base_url('admin/dashboard'));
        }
        
        $this->page_content_data['title'] = "Edit Opening And Closing Time";
        $this->page_content_data['timing_details'] = $this->Shop_timing_Model->get($id, TRUE);
        $this->page_content = $this->load->view('admin/settings/edit_opening_and_closing_time',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/edit_opening_and_closing_time_js',$this->page_content_data,true);

        $this->data['title'] = "Opening And Closing Time | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function shop_timing_list() {
        if ($this->User_Model->loggedin() == TRUE) {
            $this->data['shop_timing_list'] = $this->Shop_timing_Model->get();
            redirect(base_url('admin/settings/opening_and_closing'));
            //$this->load->view('admin/settings/shop_timing/index', $this->data);
        } else {
            redirect($this->admin);
        }
    }

    public function shop_timing_insert() {
        if (is_user_permitted('admin/settings/opening_and_closing') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $data = $this->Shop_timing_Model->data_form_post(array('day_id', 'open_time', 'close_time', 'sort_order', 'order_type','collection_delivery_time'));

        $this->form_validation->set_rules('day_id', 'Please Select a day', 'required');
        $this->form_validation->set_rules('order_type', 'Please Select a order type', 'required');
        $this->form_validation->set_rules('open_time', 'Please Enter Open Time', 'required');
        $this->form_validation->set_rules('close_time', 'Please Enter Close Time', 'required');
        $this->form_validation->set_rules('sort_order', 'Please Enter Sort Order', 'required');

        if ($this->form_validation->run() === FALSE) {
            redirect(base_url('admin/settings/add_opening_and_closing_time'));
        } else {
            $this->Shop_timing_Model->save($data);
            $this->session->set_flashdata('save_message', 'Shop Timing saved successfully.');
            $this->shop_timing_list();
        }
    }

    public function shop_timing_update_action() {
        if (is_user_permitted('admin/settings/opening_and_closing') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $data = $this->Shop_timing_Model->data_form_post(array('id', 'day_id', 'open_time', 'close_time', 'sort_order','collection_delivery_time'));
        $id = $this->input->post('id');
        $this->form_validation->set_rules('day_id', 'Please Select a day', 'required');
        $this->form_validation->set_rules('open_time', 'Please Enter Open Time', 'required');
        $this->form_validation->set_rules('close_time', 'Please Enter Close Time', 'required');
        $this->form_validation->set_rules('sort_order', 'Please Enter Sort Order', 'required');
        if ($this->form_validation->run() === FALSE) {
            redirect(base_url('admin/settings/edit_opening_and_closing_time'));
        } else {
            $this->Shop_timing_Model->where_column = 'id';
            $result = $this->Shop_timing_Model->save($data, $id);
            $this->session->set_flashdata('save_message', 'Shop Timing updated successfully.');
            $this->shop_timing_list();
        }
    }

    public function menu_upload() {
        if (is_user_permitted('admin/settings/menu_upload') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->session->userdata(''));
        if ($this->User_Model->loggedin() == false && $this->session->userdata('user_role') != 1) {
            redirect($this->admin);
        }
        
        $this->page_content_data['title'] = "Menu Upload";
        $this->page_content = $this->load->view('admin/settings/menu_upload/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/menu_upload/index_js',$this->page_content_data,true);

        $this->data['title'] = "Menu Upload | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function set_menu_file_info_in_session() {
        if (is_user_permitted('admin/settings/menu_upload') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($_FILES['menu_file']);
        $file_type = $_FILES['menu_file']['type'];
        $file_data = '';
        $is_valid = false;
        // dd($file_type);
        if ($file_type == 'text/plain') {
            $is_valid = true;
            $fp = fopen($_FILES['menu_file']['tmp_name'], 'rb');
            while (($line = fgets($fp)) !== false) {
                if (explode('=', $line)[0] != 'data') {
                    $is_valid = false;
                    break;
                }
                $file_data .= $line;
            }
        }
        // dd($is_valid);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('is_valid' => $is_valid,'file_data' => $file_data)));
    }

    public function menu_upload_action() {
        // dd($this->input->post());
        $password = $this->input->post('password');
        $user_info = $this->User_Model->check_user_authentication($password);
        $is_authenticated = false;
        $msg = "User Authentication Failed";
        if ($user_info) {
            $is_authenticated = true;
            $msg = "Saved Succesfully";
            $value = "";
            $file_data = $this->input->post('file_data');
            if ($file_data) {
                $value = explode('=', $file_data)[1];
            }
            // dd($value[1]);
            // $value = $file_data;

            $id = $this->input->post('desktop_data_id');
            $name = 'desktop_data';
            // $value = json_encode($data);
            $is_save = false;
            if (!empty($id)) {
                $is_save = $this->Settings_Model->save(array('value' => $value,), $id);
            } else {
                $is_save = $this->Settings_Model->save(array('name' => $name,'value' => $value,));
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('is_authenticated' => $is_authenticated,'msg'=>$msg)));
    }

    public function maintenance_mode() {
        if (is_user_permitted('admin/settings/maintenance_mode') == false) {
            redirect(base_url('admin/dashboard'));
        }
        update_maintenance_mode();
        
        $this->page_content_data['title'] = "Maintenance Mode";
        $this->page_content = $this->load->view('admin/settings/maintenance_mode',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/maintenance_mode_js',$this->page_content_data,true);

        $this->data['title'] = "Maintenance Mode | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function maintenance_settings_insert() {
        if (is_user_permitted('admin/settings/maintenance_mode') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('id');
        $name = 'maintenance_mode_settings';
        $value = $this->Settings_Model->data_form_post(array('message', 'is_maintenance', 'is_app_maintenance', 'environment','image'));
        $is_for_today = $this->input->post('is_for_today');
        $is_for_tomorrow = $this->input->post('is_for_tomorrow');

        $is_for_today_array = array('status'=>$is_for_today,'date'=>null,'day_id'=>null);
        $is_for_tomorrow_array = array('status'=>$is_for_tomorrow,'date'=>null,'day_id'=>null);

        if ($is_for_today) {
            $is_for_today_array['date'] = date('Y-m-d');
            $is_for_today_array['day_id'] = date('w');
        }
        $value['is_for_today'] = $is_for_today_array;

        if ($is_for_tomorrow) {
            $is_for_tomorrow_array['date'] = date("Y-m-d", strtotime('tomorrow'));
            $is_for_tomorrow_array['day_id'] = date("w", strtotime('tomorrow'));
        }
        $value['is_for_tomorrow'] = $is_for_tomorrow_array;

        $value = json_encode($value);

        $is_save = false;            
        if (!empty($id)) {
            $is_save = $this->Settings_Model->save(array('value' => $value,), $id);
        } else {
            $is_save = $this->Settings_Model->save(array('name' => $name,'value' => $value,));
        }


        if ($is_save) {
            set_flash_save_message('Maintenance Mode update successfully');
        } else {
            set_flash_save_message('Maintenance Mode is not updated');
        }
        redirect($this->admin . '/settings/maintenance_mode');
    }

    public function maintenance_settings_images_upload() {
        // dd($_FILES["images"]);
        $is_upload = true;

        multiple_image_upload('images','assets/my_uploads/');
        $output = $this->maintenance_settings_show_images(false);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('is_upload' => $is_upload,'output'=>$output)));
    }

    public function maintenance_settings_show_images($is_ajax_call = true) {
        $directory = "assets/my_uploads/*.*";
        $this->data['images'] = glob($directory,GLOB_BRACE);
        $output = $this->load->view('admin/settings/maintenance_all_images_modal_data', $this->data, true);

        if ($is_ajax_call) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('output' => $output,)));
        } else {
            return $output;
        }
    }

    public function maintenance_settings_delete_images() {
        // dd($this->input->post());
        $is_delete = true;
        $directory = $this->input->post('image_path');

        if ($directory) {
            unlink($directory);
        }
        $output = $this->maintenance_settings_show_images(false);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('is_delete' => $is_delete,'output'=>$output)));
    }

    // public function maintenance_settings_save_image() {
    //     dd($this->input->post());
    //     $is_saved = true;
    //     $image_paths = $this->input->post('image_paths');
    //     $first_image_path = $image_paths[0];
    //     $is_save = $this->Settings_Model->save(array('value' => $value,), $id);
    //     dd($is_saved);

    //     $output = $this->maintenance_settings_show_images(false);

    //     $this->output->set_content_type('application/json')->set_output(json_encode(array('is_saved' => $is_saved,'output'=>$output)));
    // }

    public function shop_timing_delete($id = 0) {
        if (is_user_permitted('admin/settings/opening_and_closing') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->Shop_timing_Model->delete(intval($id));
        redirect('/admin/settings/opening_and_closing');
    }
    
    /* Discount */
    public function discount() {
        if (is_user_permitted('admin/settings/discount') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = "Discount Management";
        $this->page_content = $this->load->view('admin/settings/discount/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/discount/index_js',$this->page_content_data,true);

        $this->data['title'] = "Discount Management | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function discount_save() {
        // dd($this->input->post());
        if (is_user_permitted('admin/settings/discount') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $name = 'discount';

        if ($this->input->post('day_ids')) {
            $countDays = count($this->input->post('day_ids'));
            $value = array();

            for ($i=0; $i < $countDays; $i++) {
                $data['day_ids'] = $this->input->post('day_ids')[$i];
                $data['delivery_discount_percent'] = $this->input->post('delivery_discount_percent')[$i];
                $data['collection_discount_percent'] = $this->input->post('collection_discount_percent')[$i];
                $data['minimum_order_amount'] = $this->input->post('minimum_order_amount')[$i];
                $data['maximum_order_amount'] = $this->input->post('maximum_order_amount')[$i];
                array_push($value,$data);
            }
        }

        $data = $this->Settings_Model->data_form_post(array('discount_message_format','first_order_discount_percent','first_order_discount_minimum_order_amount','offer_information'));
        array_push($value,$data);

        $data = $this->Settings_Model->data_form_post(array('dailyDiscountAvailability','firstOrderAvailability'));
        array_push($value,$data);
        // echo "<pre>"; print_r($value); exit();

        // $value = $this->Settings_Model->data_form_post(array('delivery_discount_percent', 'discount_message_format',
        //     'delivery_discount_minimum_order_amount', 'collection_discount_percent', 
        //     'collection_discount_minimum_order_amount', 'minimum_delivery_order_amount', 'first_order_discount_percent',
        //     'first_order_discount_minimum_order_amount', 'offer_information','collections_day_ids[]',
        //     'delivery_day_ids[]',
        // ));
        
        $discount = $this->Settings_Model->get_by(array(
            'name' => $name,
        ), true);
        $is_save = false;
        if (!empty($discount)) {
            // updated
            $is_save = $this->Settings_Model->save(array(
                'name' => $name,
                'value' => json_encode($value),
            ), $discount->id);

        } else {
            // insert
            $is_save = $this->Settings_Model->save(array(
                'name' => $name,
                'value' => json_encode($value),
            ));
        }

        $message = ($is_save) ? 'Discount details is save successfully' : 'Discount details is not save';
        set_flash_save_message($message);
        redirect($this->admin . '/settings/discount');
    }

    // Service Charge
    public function service_charge() {
        if (is_user_permitted('admin/settings/service_charge') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $name = 'service_charge';
        $service_charge = $this->Settings_Model->get_by(array('name' => $name,),true);

        $service_charge_value = (!empty($service_charge)) ? $service_charge->value : null;
        $service_charge_data = (!empty($service_charge_value)) ? json_decode($service_charge_value,true) : array();

        $is_service_charge_applicable = 0;
        $for_collection = 0;
        $collection_cash = 0;
        $collection_cash_charge = 0;
        $collection_card = 0;
        $collection_card_charge = 0;

        $for_delivery = 0;
        $delivery_cash = 0;
        $delivery_cash_charge = 0;
        $delivery_card = 0;
        $delivery_card_charge = 0;
        $is_active_collection_cash = 0;
        $is_active_collection_card = 0;
        $is_active_delivery_cash = 0;
        $is_active_delivery_card = 0;

        if ($service_charge_data) {
            $is_service_charge_applicable = isset($service_charge_data['is_service_charge_applicable']) ? $service_charge_data['is_service_charge_applicable'] : 0;
            $for_collection = isset($service_charge_data['for_collection']) ? $service_charge_data['for_collection'] : 0;
            $is_active_collection_cash = isset($service_charge_data['is_active_collection_cash']) ? $service_charge_data['is_active_collection_cash'] : 0;
            $collection_cash_charge = isset($service_charge_data['collection_cash_charge']) ? $service_charge_data['collection_cash_charge'] : 0;
            $is_active_collection_card = isset($service_charge_data['is_active_collection_card']) ? $service_charge_data['is_active_collection_card'] : 0;
            $collection_card_charge = isset($service_charge_data['collection_card_charge']) ? $service_charge_data['collection_card_charge'] : 0;

            $for_delivery = isset($service_charge_data['for_delivery']) ? $service_charge_data['for_delivery'] : 0;
            $is_active_delivery_cash = isset($service_charge_data['is_active_delivery_cash']) ? $service_charge_data['is_active_delivery_cash'] : 0;
            $delivery_cash_charge = isset($service_charge_data['delivery_cash_charge']) ? $service_charge_data['delivery_cash_charge'] : 0;
            $is_active_delivery_card = isset($service_charge_data['is_active_delivery_card']) ? $service_charge_data['is_active_delivery_card'] : 0;
            $delivery_card_charge = isset($service_charge_data['delivery_card_charge']) ? $service_charge_data['delivery_card_charge'] : 0;
        }

        $this->page_content_data['service_charge_value'] = $service_charge_value;
        $this->page_content_data['is_service_charge_applicable'] = $is_service_charge_applicable;
        $this->page_content_data['for_collection'] = $for_collection;
        $this->page_content_data['is_active_collection_cash'] = $is_active_collection_cash;
        $this->page_content_data['collection_cash_charge'] = $collection_cash_charge;
        $this->page_content_data['is_active_collection_card'] = $is_active_collection_card;
        $this->page_content_data['collection_card_charge'] = $collection_card_charge;
        $this->page_content_data['for_delivery'] = $for_delivery;
        $this->page_content_data['is_active_delivery_cash'] = $is_active_delivery_cash;
        $this->page_content_data['delivery_cash_charge'] = $delivery_cash_charge;
        $this->page_content_data['is_active_delivery_card'] = $is_active_delivery_card;
        $this->page_content_data['delivery_card_charge'] = $delivery_card_charge;
        $this->page_content = $this->load->view('admin/settings/service_charge/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/service_charge/index_js',$this->page_content_data,true);

        $this->data['title'] = "Service Charge";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function service_charge_save() {
        if (is_user_permitted('admin/settings/service_charge') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $name = 'service_charge';
        $value = $this->Settings_Model->data_form_post(array('is_service_charge_applicable','for_collection','is_active_collection_cash','collection_cash_charge','is_active_collection_card','collection_card_charge','for_delivery','is_active_delivery_cash','delivery_cash_charge','is_active_delivery_card','delivery_card_charge',
        ));

        $service_charge = $this->Settings_Model->get_by(array('name' => $name,),true);
        $is_save = false;

        if(!empty($service_charge)){
            // updated
            $is_save = $this->Settings_Model->save(array(
                'name' => $name,
                'value' => json_encode($value),
            ),$service_charge->id);

        }else{
            // insert
            $is_save = $this->Settings_Model->save(array(
                'name' => $name,
                'value' => json_encode($value),
            ));
        }

        $message = ($is_save) ? 'servce charge details is save successfully' : 'servce charge details is not save';
        set_flash_save_message($message);
        redirect($this->admin.'/settings/service_charge');
    }

    // Packaging Charge
    public function packaging_charge() {
        if (is_user_permitted('admin/settings/packaging_charge') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $name = 'packaging_charge';
        $packaging_charge = $this->Settings_Model->get_by(array('name' => $name,),true);
        $packaging_charge_value = (!empty($packaging_charge)) ? $packaging_charge->value : null;
        $packaging_charge_data = (!empty($packaging_charge_value)) ? json_decode($packaging_charge_value,true) : array();

        $is_packaging_charge_applicable = 0;
        $is_for_collection = 0;
        $collection_packaging_charge = 0;

        $is_for_delivery = 0;
        $delivery_packaging_charge = 0;

        if ($packaging_charge_data) {
            $is_packaging_charge_applicable = isset($packaging_charge_data['is_packaging_charge_applicable']) ? $packaging_charge_data['is_packaging_charge_applicable'] : 0;
            $is_for_collection = isset($packaging_charge_data['is_for_collection']) ? $packaging_charge_data['is_for_collection'] : 0;
            $collection_packaging_charge = isset($packaging_charge_data['collection_packaging_charge']) ? $packaging_charge_data['collection_packaging_charge'] : 0;

            $is_for_delivery = isset($packaging_charge_data['is_for_delivery']) ? $packaging_charge_data['is_for_delivery'] : 0;
            $delivery_packaging_charge = isset($packaging_charge_data['delivery_packaging_charge']) ? $packaging_charge_data['delivery_packaging_charge'] : 0;
        }

        $this->page_content_data['packaging_charge_value'] = $packaging_charge_value;
        $this->page_content_data['is_packaging_charge_applicable'] = $is_packaging_charge_applicable;
        $this->page_content_data['is_for_collection'] = $is_for_collection;
        $this->page_content_data['collection_packaging_charge'] = $collection_packaging_charge;
        $this->page_content_data['is_for_delivery'] = $is_for_delivery;
        $this->page_content_data['delivery_packaging_charge'] = $delivery_packaging_charge;
        $this->page_content = $this->load->view('admin/settings/packaging_charge/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/packaging_charge/index_js',$this->page_content_data,true);

        $this->data['title'] = "Packaging Charge";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function packaging_charge_save() {
        if (is_user_permitted('admin/settings/packaging_charge') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $name = 'packaging_charge';
        $value = $this->Settings_Model->data_form_post(array('is_packaging_charge_applicable','is_for_collection','collection_packaging_charge','is_for_delivery','delivery_packaging_charge',
        ));
        // dd($value);

        $packaging_charge = $this->Settings_Model->get_by(array('name' => $name,),true);
        $is_save = false;

        if (!empty($packaging_charge)) {
            // updated
            $is_save = $this->Settings_Model->save(array(
                'name' => $name,
                'value' => json_encode($value),
            ),$packaging_charge->id);
        } else {
            // insert
            $is_save = $this->Settings_Model->save(array(
                'name' => $name,
                'value' => json_encode($value),
            ));
        }

        $message = ($is_save) ? 'packaging charge details is save successfully' : 'packaging charge details is not save';
        set_flash_save_message($message);
        redirect($this->admin.'/settings/packaging_charge');
    }

    public function booking_settings() {
        if (is_user_permitted('admin/settings/booking_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $name = 'booking_settings';
        $booking_settings = $this->Settings_Model->get_by(array('name' => $name,),true);
        $booking_settings_value = $booking_settings ? $booking_settings->value : null;
        $booking_settings_data = $booking_settings_value ? json_decode($booking_settings_value,true) : array();
        $closing_date = get_array_key_value('closing_date',$booking_settings_data);
        $sorted_dates = '';
        if ($closing_date) {
            $closing_date_array = explode(',', $closing_date);
            $sorted_dates = $this->get_sorted_closing_dates($closing_date_array);
        }

        $this->page_content_data['booking_settings_value'] = $booking_settings_value;
        $this->page_content_data['is_closed'] = get_array_key_value('is_closed',$booking_settings_data,0);
        $this->page_content_data['closing_date'] = $closing_date;
        $this->page_content_data['sorted_dates'] = $sorted_dates;
        $this->page_content_data['message'] = get_array_key_value('message',$booking_settings_data);
        $this->page_content_data['accepted_message'] = get_array_key_value('accepted_message',$booking_settings_data);
        $this->page_content_data['rejected_message'] = get_array_key_value('rejected_message',$booking_settings_data);
        
        $this->page_content = $this->load->view('admin/settings/booking_settings/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/booking_settings/index_js',$this->page_content_data,true);

        $this->data['title'] = "Booking Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function booking_settings_save() {
        if (is_user_permitted('admin/settings/booking_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $name = 'booking_settings';
        $value = $this->Settings_Model->data_form_post(array('is_closed','closing_date','message','accepted_message','rejected_message'));
        $closing_date = $value['closing_date'];
        $closing_date = explode(',', $closing_date);
        asort($closing_date);
        $value['closing_date'] = implode(',', $closing_date);

        if ($value['is_closed'] == 0) {
            $value['closing_date'] = "";
            $value['message'] = "";
        }
        $json_value = json_encode($value);
        // dd($json_value);

        $booking_settings = $this->Settings_Model->get_by(array('name' => $name,),true);
        $is_save = false;

        if (!empty($booking_settings)) {
            // Update
            $is_save = $this->Settings_Model->save(array('name' => $name,'value' => $json_value,),$booking_settings->id);
        } else {
            // insert
            $is_save = $this->Settings_Model->save(array('name' => $name,'value' => $json_value,));
        }

        $message = 'Booking settings have ';
        $message .= ($is_save) ? 'been saved successfully' : 'not been save succesfully';
        set_flash_save_message($message);
        redirect($this->admin.'/settings/booking_settings');
    }

    public function get_sorted_closing_dates($array_data) {
        $new_array = array();
        if (is_array($array_data)) {
            foreach ($array_data as $key => $value) {
                $value_array = explode('-', $value);
                if (array_key_exists($value_array[0], $new_array)) {
                    if (array_key_exists($value_array[1], $new_array[$value_array[0]])) {
                        array_push($new_array[$value_array[0]][$value_array[1]], $value_array[2]);
                    } else {
                        $new_array[$value_array[0]][$value_array[1]] = array($value_array[2]);
                    }
                    asort($new_array[$value_array[0]][$value_array[1]]);
                } else {
                    $new_array[$value_array[0]][$value_array[1]] = array($value_array[2]);
                }
                ksort($new_array[$value_array[0]]);
            }
            ksort($new_array);
        }
        return $new_array;
    }

    public function add_new_loyalty_program() {
        $rowCount = $this->input->post('rowCount');
        $data['rowCount'] = $rowCount;
        $output = $this->load->view('admin/settings/discount/add_new_loyalty_program_table',$data,true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function loyalty_program_save() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            // dd($this->input->post());
            $success_message = '';
            $error_message = '';

            if ($this->input->post('rowCount') > 0) {
                if ($this->input->post('rowCount')) {
                    $rowCount = $this->input->post('rowCount');
                    $value = array();

                    $data = $this->Settings_Model->data_form_post(array('loyaltyProgramAvailability'));
                    array_push($value,$data);

                    for ($i=0; $i < $rowCount; $i++) {
                        if ($this->input->post('status')[$i] != 'remove') {
                            $data['number_Of_order'] = $this->input->post('numberOfOrder')[$i];
                            $data['minimum_order_amount'] = $this->input->post('minimumOrderAmount')[$i];
                            $data['maximum_discount_amount'] = $this->input->post('maximumDiscountAmount')[$i];
                            $data['offer_type'] = $this->input->post('offerType')[$i];
                            $data['discount_amount'] = $this->input->post('discountAmount')[$i];
                            $data['description'] = $this->input->post('description')[$i];
                            array_push($value,$data);
                        }
                    }
                }
                // dd($value);
                
                $name = 'loyalty_programs';
                $loyalty_program = $this->Settings_Model->get_by(array('name' => $name,), true);
                $is_save = false;
                if (!empty($loyalty_program)) {
                    // updated
                    $is_save = $this->Settings_Model->save(array('name' => $name,'value' => json_encode($value),), $loyalty_program->id);
                } else {
                    // insert
                    $is_save = $this->Settings_Model->save(array('name' => $name,'value' => json_encode($value),));
                }

                if ($is_save === true) {
                    $success_message = 'Loyalty Program Details is save successfully';
                } else {
                    $error_message = 'Loyalty Program Details is not save';
                }
            } else {
                $error_message = 'Add Loyalty Program First';
            }

            $this->session->set_flashdata('loyalty_success_msg', $success_message);
            $this->session->set_flashdata('loyalty_error_msg', $error_message);
            redirect($this->admin.'/settings/discount');
        } else {
            redirect($this->admin);
        }
    }

    //Open time and close time
//    public function shop_timing_add_form() {
//        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
//            if ($this->input->is_ajax_request()) {
//
//                $this->load->view('admin/settings/shop_timing/add_form', $this->data);
//            } else {
//                redirect($this->admin . '/shop/edit');
//            }
//        } else {
//            redirect($this->admin);
//        }
//    }
//    public function shop_timing_update_form() {
//        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
//            if ($this->input->is_ajax_request()) {
//                $day_id = $_POST['day_id'];
//                $open_time = $_POST['open_time'];
//                $close_time = $_POST['close_time'];
//
//                $this->data['timing_details'] = array(
//                    'day_id' => $day_id,
//                    'open_time' => $open_time,
//                    'close_time' => $close_time
//                );
//
//                $this->load->view('admin/settings/shop_timing/edit_form', $this->data);
//            } else {
//                redirect($this->admin . '/shop/edit');
//            }
//        } else {
//            redirect($this->admin);
//        }
//    }
//area_postcode

    public function area_coverage() {
        if (is_user_permitted('admin/settings/area_coverage') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = 'Coverage Area';
        $this->page_content_data['allowed_postcodes_list'] = $this->Allowed_postcodes_Model->get();
        $this->page_content = $this->load->view('admin/settings/area_coverage/index',$this->page_content_data,true);

        $this->data['title'] = "Coverage Area";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add_coverage_area() {
        if (is_user_permitted('admin/settings/area_coverage') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = 'Add New Area';
        $this->page_content = $this->load->view('admin/settings/area_coverage/add',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/area_coverage/add_js','',true);

        $this->data['title'] = "Coverage Area | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_coverage_area($id = 0) {
        if ($this->User_Model->loggedin() == TRUE) {
            $allowed_postcode = $this->Allowed_postcodes_Model->get($id, true);
            $this->page_content_data['title'] = 'Edit New Area';
            $this->page_content_data['allowed_postcode'] = $allowed_postcode;
            $this->page_content = $this->load->view('admin/settings/area_coverage/edit',$this->page_content_data,true);
            $this->custom_js = $this->load->view('admin/settings/area_coverage/edit_js','',true);

            $this->data['title'] = "Coverage Area | Edit";
            $this->load->view('admin/master/master_index',$this->data);

            // $this->load->view('admin/header');
            // $this->load->view('admin/settings/edit_coverage_area', $this->data);
            // $this->load->view('admin/script_page');
        } else {
            redirect($this->admin);
        }
    }

    public function postcode_delete($id = 0) {
        if ($this->User_Model->loggedin() == TRUE) {
            $this->Allowed_postcodes_Model->delete($id);
            redirect(base_url('admin/settings/area_coverage'));
        } else {
            redirect($this->admin);
        }
    }

    public function postcode_save() {
        if (is_user_permitted('admin/settings/area_coverage') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = trim($this->input->post('id'));
        $from_data = $this->Allowed_postcodes_Model->data_form_post(array('id', 'postcode', 'delivery_charge', 'min_order_for_delivery','min_amount_for_free_delivery_charge'));

        $this->form_validation->set_rules('postcode', 'Postcode', 'required');
        $this->form_validation->set_rules('delivery_charge', 'Delivery Charge', 'required');
        $this->form_validation->set_rules('min_order_for_delivery', 'Min Order For Delivery', 'required');

        if ($this->form_validation->run() === FALSE) {
            redirect(base_url('admin/settings/add_coverage_area'));
        } else {
            if (empty($id)) {
                $is_postcode_exists = $this->Allowed_postcodes_Model->is_postcode_exists($from_data['postcode']);
                if (!$is_postcode_exists) {
                    $result = $this->Allowed_postcodes_Model->save($from_data);
                    $this->session->set_flashdata('save_message', 'Information has been saved successfully.');
                    redirect(base_url('admin/settings/add_coverage_area'));
                } else {
                    $this->session->set_flashdata('error_message', 'postcode Already Exists.');
                    redirect(base_url('admin/settings/add_coverage_area'));
                }
            } else {
                $is_postcode_exists_for_update = $this->Allowed_postcodes_Model->is_postcode_exists_for_update($id, $from_data['postcode']);
                if (!$is_postcode_exists_for_update) {
                    $result = $this->Allowed_postcodes_Model->save($from_data, $id);
                    $this->session->set_flashdata('save_message', 'Information has been updated successfully.');
                    redirect(base_url('admin/settings/area_coverage/'));
                } else {
                    $this->session->set_flashdata('error_message', 'Postcode Already Exists.');
                    redirect(base_url('admin/settings/edit_coverage_area/' . $id));
                }
            }
        }
    }

    public function post_code() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $this->load->model('Allowed_postcodes_Model');
                /* Post Code */
                $this->data['allowed_postcodes_list'] = $this->Allowed_postcodes_Model->get();
                $this->load->view('admin/settings/post_code/index', $this->data);
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    //allowed_miles
    public function allowed_miles() {
        if (is_user_permitted('admin/settings/allowed_miles') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Allowed Miles";
        $this->page_content_data['allowed_miles_list'] = $this->Allowed_miles_Model->get();
        $this->page_content = $this->load->view('admin/settings/allowed_miles',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/menu/buy_and_get/index_js',$this->page_content_data,true);

        $this->data['title'] = "Allowed Miles | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add_allowed_miles() {
        if (is_user_permitted('admin/settings/allowed_miles') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Add Allowed Miles";
        $this->page_content = $this->load->view('admin/settings/add_allowed_miles',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/add_allowed_miles_js',$this->page_content_data,true);

        $this->data['title'] = "Allowed Miles | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_allowed_miles($id = 0) {
        if (is_user_permitted('admin/settings/allowed_miles') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $allowed_miles = $this->Allowed_miles_Model->get($id, true);

        $this->page_content_data['title'] = "Edit Allowed Miles";
        $this->page_content_data['allowed_miles'] = $allowed_miles;
        $this->page_content = $this->load->view('admin/settings/edit_allowed_miles',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/edit_allowed_miles_js',$this->page_content_data,true);

        $this->data['title'] = "Allowed Miles | Edit";
        $this->load->view('admin/master/master_index',$this->data);


        // $this->load->view('admin/header');
        // $this->load->view('admin/settings/edit_allowed_miles', $this->data);
        // $this->load->view('admin/script_page');
    }

    public function allowed_miles_save() {
        if (is_user_permitted('admin/settings/allowed_miles') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = trim($this->input->post('id'));
        $from_data = $this->Allowed_miles_Model->data_form_post(array('id', 'delivery_radius_miles', 'delivery_charge', 'min_order_for_delivery','min_amount_for_free_delivery_charge'));

        $this->form_validation->set_rules('delivery_radius_miles', 'Delivery Radius Miles', 'required');
        $this->form_validation->set_rules('delivery_charge', 'Delivery Charge', 'required');
        $this->form_validation->set_rules('min_order_for_delivery', 'Min Order For Delivery', 'required');

        if ($this->form_validation->run() === FALSE) {
            redirect(base_url($this->admin . '/settings/add_allowed_miles'));
        } else {
            if (empty($id)) {
                $is_allowed_miles_exists = $this->Allowed_miles_Model->is_allowed_miles_exists($from_data['delivery_radius_miles']);
                if (!$is_allowed_miles_exists) {
                    $result = $this->Allowed_miles_Model->save($from_data);
                    $this->session->set_flashdata('save_message', 'Information has been saved successfully.');
                    redirect(base_url('admin/settings/allowed_miles'));
                } else {
                    $this->session->set_flashdata('error_message', 'Delivery Radius Miles Already Exists.');
                    redirect(base_url('admin/settings/add_allowed_miles'));
                }
            } else {
                $is_allowed_miles_exists_for_update = $this->Allowed_miles_Model->is_allowed_miles_exists_for_update($id, $from_data['delivery_radius_miles']);
                if (!$is_allowed_miles_exists_for_update) {
                    $result = $this->Allowed_miles_Model->save($from_data, $id);
                    $this->session->set_flashdata('save_message', 'Information has been updated successfully.');
                    redirect(base_url('admin/settings/allowed_miles/'));
                } else {
                    $this->session->set_flashdata('error_message', 'Delivery Radius Miles Already Exists.');
                    redirect(base_url('admin/settings/edit_allowed_miles/' . $id));
                }
            }
        }
    }

    public function allowed_miles_delete($id = 0) {
        if (is_user_permitted('admin/settings/allowed_miles') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->Allowed_miles_Model->delete($id);
        redirect($this->admin . '/settings/allowed_miles');
    }

    //Currency Settings
    public function currency() {
        if (is_user_permitted('admin/settings/currency') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Currency Settings";
        $this->page_content_data['currency'] = $this->Settings_Model->get_by(array("name" => 'currency'), true);
        $this->page_content = $this->load->view('admin/settings/currency_settings',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/business_information_settings_js',$this->page_content_data,true);

        $this->data['title'] = "Currency Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function currency_settings_save() {
        if (is_user_permitted('admin/settings/currency') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('id');
        $data = $this->Settings_Model->data_form_post(array('id', 'name'));
        $value = $this->Settings_Model->data_form_post(array('symbol', 'placement'));
        $json_value = json_encode($value);
        $data['value'] = $json_value;

        $this->form_validation->set_rules('symbol', 'Symbol', 'required');
        $this->form_validation->set_rules('placement', 'Placement', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/header');
            $currency = $this->Settings_Model->get_by(array("name" => 'currency'), true);
            $this->data['currency'] = $currency;
            $this->load->view('admin/settings/currency_settings', $this->data);
            $this->load->view('admin/script_page');
        } else {
            if (empty($id)) {
                $this->Settings_Model->save($data);
                $this->session->set_flashdata('save_message', 'Currency Settings has been saved successfully');
                redirect($this->admin . '/settings/currency');
            } else {
                $this->Settings_Model->where_column = 'id';
                $this->Settings_Model->save($data, $id);
                $this->session->set_flashdata('save_message', 'Currency Settings has been updated successfully');
                redirect($this->admin . '/settings/currency');
            }
        }
    }

    //Social Media Settings
    public function social_media() {
        if (is_user_permitted('admin/settings/social_media') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Social Media Settings";
        $this->page_content_data['social_media'] = $this->Settings_Model->get_by(array("name" => 'social_media'), true);
        $this->page_content = $this->load->view('admin/settings/social_media_settings',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/settings/social_media_settings_js',$this->page_content_data,true);

        $this->data['title'] = "Social Media Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);

        // $this->load->view('admin/header', $this->data);
        // $this->load->view('admin/settings/social_media_settings', $this->data);
        // $this->load->view('admin/script_page');
    }

    public function social_media_settings_save() {
        if (is_user_permitted('admin/settings/social_media') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('id');
        $data = $this->Settings_Model->data_form_post(array('id', 'name'));
        $value = $this->Settings_Model->data_form_post(array('facebook', 'twitter', 'youtube', 'linkedIn', 'googlePlus', 'skype', 'tripadvisor', 'instagram'));
        $json_value = json_encode($value);
        $data['value'] = $json_value;
        if (empty($id)) {
            $this->Settings_Model->save($data);
            $this->session->set_flashdata('save_message', 'Social Media Settings has been saved successfully');
            redirect($this->admin . '/settings/social_media');
        } else {
            $this->Settings_Model->where_column = 'id';
            $this->Settings_Model->save($data, $id);
            $this->session->set_flashdata('save_message', 'Social Media Settings has been updated successfully');
            redirect($this->admin . '/settings/social_media');
        }
    }

    //Business Information Settings
    public function business_information_settings() {
        if (is_user_permitted('admin/settings/business_information_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Business information Settings";
        $this->page_content_data['currency'] = $this->Settings_Model->get_by(array("name" => 'currency'), true);
        $this->page_content_data['company_details'] = $this->Settings_Model->get_by(array("name" => 'company_details'), true);
        $this->page_content = $this->load->view('admin/settings/business_information_settings',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/business_information_settings_js',$this->page_content_data,true);

        $this->data['title'] = "Business information Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function image_load() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $new_name = $_FILES["file"]['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = './assets/my_uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                $is_upload = $this->upload->do_upload('file');
                $d = array('upload_data' => $this->upload->data());
                $responseData = array();
                if ($is_upload) {
                    $path = 'assets/my_uploads/' . $d['upload_data']['file_name'];
                    $responseData = array(
                        'isUploaded' => true,
                        'imagePath' => $path,
                        'fullPath' => base_url($path),
                        'message' => '  <p class="success">Upload Successful</p>'
                    );
                } else {
                    $error_message = $this->upload->display_errors();
                    $responseData = array(
                        'isUploaded' => false,
                        'imagePath' => null,
                        'fullPath' => null,
                        'message' => '<p class="error">Upload Error,Because ' . $error_message . ', Try Again</p>',
                        'error' => '<p class="error">' . $error_message . '</p>'
                    );
                }
                $this->output->set_content_type('application/json')->set_output(json_encode($responseData));
            } else {
                //redirect($this->admin . '/shop/edit');
                redirect($this->admin);
            }
        } else {
            redirect($this->admin);
        }
    }

    public function business_information_settings_save() {
        if (is_user_permitted('admin/settings/business_information_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $id = $this->input->post('id');
        $data = $this->Settings_Model->data_form_post(array('id', 'name'));
        $value = $this->Settings_Model->data_form_post(array('company_name', 'email', 'contact_number', 'company_address', 'company_logo', 'favicon', 'food_type','postcode', 'pickup_time', 'city', 'minimum_order_amount', 'minimum_order_amount_text','delivery_time', 'cc_email', 'latitude', 'longitude','per_slot_collection_order','per_slot_delivery_order' ));
        $json_value = json_encode($value);
        $data['value'] = $json_value;
        $this->form_validation->set_rules('company_name', 'Company Name', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/header', $this->data);
            $this->data['currency'] = $this->Settings_Model->get_by(array("name" => 'currency'), true);
            $this->data['company_details'] = $this->Settings_Model->get_by(array("name" => 'company_details'), true);
            $this->load->view('admin/settings/business_information_settings', $this->data);
            $this->load->view('admin/script_page');
        } else {
            if (empty($id)) {
                $this->Settings_Model->save($data);
                $this->session->set_flashdata('save_message', 'Information has been Saved successfully');
                redirect($this->admin . '/settings/business_information_settings');
            } else {
                $this->Settings_Model->where_column = 'id';
                $this->Settings_Model->save($data, $id);
                $this->session->set_flashdata('save_message', 'Information has been Updated successfully');
                redirect($this->admin . '/settings/business_information_settings');
            }
        }
    }

    //Weekend Off Settings
    public function weekend_off() {
        if (is_user_permitted('admin/settings/weekend_off') == false) {
            redirect(base_url('admin/dashboard'));
        }
        update_weekend_off();
        
        $this->page_content_data['title'] = "Weekend Off Settings";
        $this->page_content_data['weekend_off'] = $this->Settings_Model->get_by(array("name" => 'weekend_off'), true);
        $this->page_content = $this->load->view('admin/settings/weekend_off/index',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/settings/maintenance_mode_js',$this->page_content_data,true);

        $this->data['title'] = "Weekend Off Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function weekend_off_save() {
        if (is_user_permitted('admin/settings/weekend_off') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $id = $this->input->post('id');
        $data['name'] = 'weekend_off';
        $value = $this->Settings_Model->data_form_post(array('day_ids','is_off_all_holidays'));
        $is_closed_for_today = $this->input->post('is_closed_for_today');
        $is_closed_for_tomorrow = $this->input->post('is_closed_for_tomorrow');
        $is_closed_for_this_weeks = $this->input->post('is_closed_for_this_weeks');

        $is_closed_for_today_array = array('status'=>$is_closed_for_today,'date'=>null,'day_id'=>null);
        $is_closed_for_tomorrow_array = array('status'=>$is_closed_for_tomorrow,'date'=>null,'day_id'=>null);
        $is_closed_for_this_weeks_array = array('status'=>null,'start_date'=>null,'end_date'=>null,'day_ids'=>null);

        if ($is_closed_for_this_weeks) {
            $sunday = strtotime('next Sunday -1 week');
            $sunday = date('w', $sunday) == date('w') ? strtotime(date("Y-m-d",$sunday)." +7 days") : $sunday;
            $saturday = strtotime(date("Y-m-d",$sunday)." +6 days");
            $is_closed_for_this_weeks_array['status'] = 1;
            $is_closed_for_this_weeks_array['start_date'] = date('Y-m-d',$sunday);
            $is_closed_for_this_weeks_array['end_date'] = date('Y-m-d',$saturday);
            $is_closed_for_this_weeks_array['day_ids'] = $is_closed_for_this_weeks;
        }
        $value['is_closed_for_this_weeks'] = $is_closed_for_this_weeks_array;

        if ($is_closed_for_today) {
            $is_closed_for_today_array['date'] = date('Y-m-d');
            $is_closed_for_today_array['day_id'] = date('w');
        }
        $value['is_closed_for_today'] = $is_closed_for_today_array;

        if ($is_closed_for_tomorrow) {
            $is_closed_for_tomorrow_array['date'] = date("Y-m-d", strtotime('tomorrow'));
            $is_closed_for_tomorrow_array['day_id'] = date("w", strtotime('tomorrow'));
        }
        $value['is_closed_for_tomorrow'] = $is_closed_for_tomorrow_array;

        $json_value = json_encode($value);
        $data['value'] = $json_value;

        if (empty($id)) {
            $this->Settings_Model->save($data);
            $this->session->set_flashdata('save_message','Information has been Saved successfully');
            redirect($this->admin.'/settings/business_information_settings');
        } else {
            $this->Settings_Model->where_column = 'id';
            $this->Settings_Model->save($data, $id);
            $this->session->set_flashdata('save_message','Information has been Updated successfully');
            redirect($this->admin.'/settings/weekend_off');
        }
    }

    //About us Settings
    public function about_us() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            $this->data['title'] = "About Us Settings";
            $this->load->view('admin/header');
            $this->data['about_us'] = $this->Settings_Model->get_by(array("name" => 'about_us'), true);
            $this->load->view('admin/settings/about_us_settings', $this->data);
            $this->load->view('admin/script_page');
        } else {
            redirect($this->admin);
        }
    }

    public function about_us_image_load() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $new_name = $_FILES["file"]['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = './assets/my_uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                $is_upload = $this->upload->do_upload('file');
                $d = array('upload_data' => $this->upload->data());
                if ($is_upload) {
                    $path = '/assets/my_uploads/' . $d['upload_data']['file_name'];
                    ?>
                    <div class="image-url">
                        <input type="hidden" name="about_us_logo" value="<?= $path ?>">

                        <p class="success-message">Upload Successful</p>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="image-url">
                        <p class="error">Upload Error,Try Again</p>
                    </div>
                    <script>
                        $('.progress').css({'display': 'none'});
                    </script>
                    <?php
                }
            } else {
                //redirect($this->admin . '/shop/edit');
                redirect($this->admin);
            }
        } else {
            redirect($this->admin);
        }
    }

    public function about_us_save() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {

            $id = $this->input->post('id');
            $data = $this->Settings_Model->data_form_post(array('id', 'name'));
            $value = $this->Settings_Model->data_form_post(array('description', 'about_us_logo'));
            $json_value = json_encode($value);
            $data['value'] = $json_value;
            if (empty($id)) {
                $this->Settings_Model->save($data);
                $this->session->set_flashdata('save_message', 'Information has been Saved successfully');
                redirect($this->admin . '/settings/about_us');
            } else {
                $this->Settings_Model->where_column = 'id';
                $this->Settings_Model->save($data, $id);
                $this->session->set_flashdata('save_message', 'Information has been Updated successfully');
                redirect($this->admin . '/settings/about_us');
            }
        } else {
            redirect($this->admin);
        }
    }

    // payment settings
    public function payment_settings() {
        if (is_user_permitted('admin/settings/payment_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        
        $this->page_content_data['title'] = "Payment Settings";
        $this->page_content_data['payment_settings'] = $this->Settings_Model->get_by(array("name" => 'payment_settings'), true);
        $this->page_content = $this->load->view('admin/settings/payment_settings',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/payment_settings_js',$this->page_content_data,true);

        $this->data['title'] = "Payment Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function payment_settings_insert() {
        if (is_user_permitted('admin/settings/payment_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('id');
        $data = $this->Settings_Model->data_form_post(array('id', 'name'));
        $payment_getway = $this->input->post('payment_gateway');

        $value = $this->Settings_Model->data_form_post(array('payment_gateway','payment_mode','order_type','payment_method','dine_in','reservation','reservation_amount','tips_for_card','tips_for_cash','surcharge','lp_status','lp_earn_rate'));

        $json_value = json_encode($value);
        $data['value'] = $json_value;
        if (empty($id)) {
            $this->Settings_Model->save($data);
        } else {
            $this->Settings_Model->where_column = 'id';
            $this->Settings_Model->save($data, $id);
        }

        redirect($this->admin . '/settings/payment_settings');
    }

    //paypal settings
    public function paypal_settings() {
        if (is_user_permitted('admin/settings/paypal_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        
        $this->page_content_data['title'] = "Paypal Settings";
        $this->page_content_data['paypal_settings'] = $this->Settings_Model->get_by(array("name" => 'paypal_settings'), true);
        $this->page_content_data['payment_settings'] = $this->Settings_Model->get_by(array("name" => 'payment_settings'), true);
        $this->page_content = $this->load->view('admin/settings/paypal_settings',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/settings/payment_settings_js',$this->page_content_data,true);

        $this->data['title'] = "Paypal Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function paypal_settings_insert() {
        if (is_user_permitted('admin/settings/paypal_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('id');
        $data = $this->Settings_Model->data_form_post(array('id', 'name'));
        $value = $this->Settings_Model->data_form_post(array('display_name','paypal_api_username', 'sandbox_client_id', 'sandbox_client_secret', 'production_client_id', 'production_client_secret', 'environment', 'currency'));
        $json_value = json_encode($value);
        $data['value'] = $json_value;
        if (empty($id)) {
            $this->Settings_Model->save($data);
        } else {
            $this->Settings_Model->where_column = 'id';
            $this->Settings_Model->save($data, $id);
        }
        redirect($this->admin . '/settings/paypal_settings');
    }

    //stripe settings
    public function stripe_settings() {
        if (is_user_permitted('admin/settings/stripe_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = "Stripe Settings";
        $this->page_content_data['stripe_settings'] = $this->Settings_Model->get_by(array("name" => 'stripe_settings'), true);
        $this->page_content = $this->load->view('admin/settings/stripe_settings',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/settings/payment_settings_js',$this->page_content_data,true);

        $this->data['title'] = "Stripe Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function stripe_settings_insert() {
        if (is_user_permitted('admin/settings/stripe_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('id');
        $data = $this->Settings_Model->data_form_post(array('id'));
        $data['name'] = 'stripe_settings';
        $value = $this->Settings_Model->data_form_post(array('display_name', 'publishable_key', 'secret_key'));
        $json_value = json_encode($value);
        $data['value'] = $json_value;
        if (empty($id)) {
            $this->Settings_Model->save($data);
        } else {
            $this->Settings_Model->where_column = 'id';
            $this->Settings_Model->save($data, $id);
        }

        redirect($this->admin . '/settings/stripe_settings');
    }

//nochecx_settings
    public function nochecx_settings() {
        if (is_user_permitted('admin/settings/nochecx_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = "Nochecx Settings";
        $this->page_content_data['nochecx_settings'] = $this->Settings_Model->get_by(array("name" => 'nochecx_settings'), true);
        $this->page_content = $this->load->view('admin/settings/nochecx_settings',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/settings/payment_settings_js',$this->page_content_data,true);

        $this->data['title'] = "Nochecx Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function nochecx_settings_insert() {
        if (is_user_permitted('admin/settings/nochecx_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('id');
        $data = $this->Settings_Model->data_form_post(array('id', 'name'));
        $value = $this->Settings_Model->data_form_post(array('display_name', 'nochecx_success_url', 'nochecx_cancel_url', 'nochecx_description', 'nochecx_merchant_email', 'nochecx_callback_url', 'nochecx_cancel_url'));
        $json_value = json_encode($value);
        $data['value'] = $json_value;
        if (empty($id)) {
            $this->Settings_Model->save($data);
            $this->session->set_flashdata('save_message', 'Nochex Details is inserted successfully');
        } else {
            $this->Settings_Model->where_column = 'id';
            $this->Settings_Model->save($data, $id);
            $this->session->set_flashdata('save_message', 'Nochex Details is updated successfully');
        }

        redirect($this->admin . '/settings/nochecx_settings');
    }

//pay360_settings
    public function pay360_settings() {
        if (is_user_permitted('admin/settings/pay360_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = "Pay360 Settings";
        $this->page_content_data['pay360_settings'] = $this->Settings_Model->get_by(array("name" => 'pay360_settings'), true);
        $this->page_content = $this->load->view('admin/settings/pay360_settings',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/settings/payment_settings_js',$this->page_content_data,true);

        $this->data['title'] = "Pay360 Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function pay360_settings_insert() {
        if (is_user_permitted('admin/settings/pay360_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();
        $id = $this->input->post('id');
        $data = $this->Settings_Model->data_form_post(array('id', 'name'));
        $value = $this->Settings_Model->data_form_post(array('pay360_merchant_id','pay360_isv_id','pay360_api_id','pay360_api_key','pay360_payment_api_key','pay360_jwt','pay360_description','pay360_payment_mode'));
        $json_value = json_encode($value);
        $data['value'] = $json_value;
        // echo "<pre>"; print_r($data); exit();
        if (empty($id)) {
            $this->Settings_Model->save($data);
            $this->session->set_flashdata('save_message', 'Pay360 Details is inserted successfully');
        } else {
            $this->Settings_Model->where_column = 'id';
            $this->Settings_Model->save($data, $id);
            $this->session->set_flashdata('save_message', 'Pay360 Details is updated successfully');
        }
        redirect($this->admin . '/settings/pay360_settings');
    }

    //sagepay_settings
    public function sagepay_settings() {
        if (is_user_permitted('admin/settings/sagepay_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = "Sagepay Settings";
        $this->page_content_data['sagepay_settings'] = $this->Settings_Model->get_by(array("name" => 'sagepay_settings'), true);
        $this->page_content = $this->load->view('admin/settings/sagepay_settings',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/settings/payment_settings_js',$this->page_content_data,true);

        $this->data['title'] = "Sagepay Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function sagepay_settings_insert() {
        if (is_user_permitted('admin/settings/sagepay_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $id = $this->input->post('id');
        $data = $this->Settings_Model->data_form_post(array('id', 'name'));
        $value = $this->Settings_Model->data_form_post(array('display_name','environment','vendor_name','sandbox_server','sandbox_integration_key','sandbox_integration_password','production_server','production_integration_key','production_integration_password','description'));
        $json_value = json_encode($value);
        $data['value'] = $json_value;
        // echo "<pre>"; print_r($data); exit();
        if (empty($id)) {
            $this->Settings_Model->save($data);
            $this->session->set_flashdata('save_message', 'Sagepay Details is inserted successfully');
        } else {
            $this->Settings_Model->where_column = 'id';
            $this->Settings_Model->save($data, $id);
            $this->session->set_flashdata('save_message', 'Sagepay Details is updated successfully');
        }
        redirect($this->admin . '/settings/sagepay_settings');
    }

    //sagepay_settings
    public function cardstream_settings() {
        if (is_user_permitted('admin/settings/cardstream_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = "Cardstream Settings";
        $this->page_content_data['cardstream_settings'] = $this->Settings_Model->get_by(array("name" => 'cardstream_settings'), true);
        $this->page_content = $this->load->view('admin/settings/cardstream_settings',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/settings/payment_settings_js',$this->page_content_data,true);

        $this->data['title'] = "Cardstream Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function cardstream_settings_insert() {
        if (is_user_permitted('admin/settings/cardstream_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $id = $this->input->post('id');
        $data = $this->Settings_Model->data_form_post(array('id', 'name'));
        $value = $this->Settings_Model->data_form_post(array('display_name','signature_key','environment','url_mode','marchant_account_id','redirect_url','test_hosted_url','live_hosted_url','test_direct_url','live_direct_url','description'));
        $json_value = json_encode($value);
        $data['value'] = $json_value;
        // echo "<pre>"; print_r($data); exit();
        if (empty($id)) {
            $this->Settings_Model->save($data);
            $this->session->set_flashdata('save_message', 'Cardstream Details is inserted successfully');
        } else {
            $this->Settings_Model->where_column = 'id';
            $this->Settings_Model->save($data, $id);
            $this->session->set_flashdata('save_message', 'Cardstream Details is updated successfully');
        }
        redirect($this->admin . '/settings/cardstream_settings');
    }

    //barclycard_settings
    public function barclycard_settings() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            $this->data['title'] = "Barclycard_settings";
            $this->load->view('admin/header', $this->data);
            $this->data['barclycard_settings'] = $this->Settings_Model->get_by(array("name" => 'barclycard_settings'), true);
            $this->load->view('admin/settings/barclycard_settings', $this->data);
            $this->load->view('admin/script_page');
        } else {
            redirect($this->admin);
        }
    }

    public function barclycard_settings_insert() {
        //sagepay_vendor_url  sagepay_encryption_password  sagepay_success_url sagepay_failure_url sagepay_vendor_email sagepay_description
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                $data = $this->Settings_Model->data_form_post(array('id', 'name'));
                $value = $this->Settings_Model->data_form_post(array('sagepay_vendor_url', 'sagepay_encryption_password', 'sagepay_success_url', 'sagepay_failure_url', 'sagepay_vendor_email', 'sagepay_description'));
                var_dump($value);
                $json_value = json_encode($value);
                $data['value'] = $json_value;
                if (empty($id)) {
                    $this->Settings_Model->save($data);
                } else {
                    $this->Settings_Model->where_column = 'id';
                    $this->Settings_Model->save($data, $id);
                }
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    //worldpay_settings
    public function worldpay_settings() {
        if (is_user_permitted('admin/settings/worldpay_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = "Worldpay Settings";
        $this->page_content_data['worldpay_settings'] = $this->Settings_Model->get_by(array("name" => 'worldpay_settings'), true);
        $this->page_content = $this->load->view('admin/settings/worldpay_settings',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/settings/payment_settings_js',$this->page_content_data,true);

        $this->data['title'] = "Worldpay Settings | Index";
        $this->load->view('admin/master/master_index',$this->data);

        // $this->load->view('admin/header', $this->data);
        // $this->load->view('admin/settings/worldpay_settings', $this->data);
        // $this->load->view('admin/script_page');
    }

    public function worldpay_settings_insert() {
        if (is_user_permitted('admin/settings/pay360_settings') == false) {
            redirect(base_url('admin/dashboard'));
        }
        //sagepay_vendor_url  sagepay_encryption_password  sagepay_success_url sagepay_failure_url sagepay_vendor_email sagepay_description
        $id = $this->input->post('id');
        $data = $this->Settings_Model->data_form_post(array('id','name'));
        $value = $this->Settings_Model->data_form_post(array('worldpay_status','worldpay_application_id','worldpay_currency'));
        // echo "<pre>"; print_r($value); exit();
        $json_value = json_encode($value);
        $data['value'] = $json_value;
        if (empty($id)) {
            $this->Settings_Model->save($data);
            $this->session->set_flashdata('save_message', 'Worldpay Details is inserted successfully');
        } else {
            $this->Settings_Model->where_column = 'id';
            $this->Settings_Model->save($data, $id);
            $this->session->set_flashdata('save_message', 'Worldpay Details is updated successfully');
        }
        redirect($this->admin.'/settings/worldpay_settings');
    }

//meta_data_settings
    public function meta_data_settings() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            $this->data['title'] = "meta_data_settings";
            $this->load->view('admin/header', $this->data);
            $this->data['meta_data_settings'] = $this->Settings_Model->get_by(array("name" => 'meta_data_settings'), true);
            $this->load->view('admin/settings/meta_data_settings', $this->data);
            $this->load->view('admin/script_page');
        } else {
            redirect($this->admin);
        }
    }

    public function meta_data_settings_insert() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                $data = $this->Settings_Model->data_form_post(array('id', 'name'));
                $value = $this->Settings_Model->data_form_post(array('meta_title', 'meta_description', 'meta_keywords'));
                $json_value = json_encode($value);
                $data['value'] = $json_value;
                if (empty($id)) {
                    $this->Settings_Model->save($data);
                } else {
                    $this->Settings_Model->where_column = 'id';
                    $this->Settings_Model->save($data, $id);
                }
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function settings_home_insert() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            $id = $this->input->post('id');
            $data = $this->Settings_Model->data_form_post(array('id', 'name'));
            $value = $this->Settings_Model->data_form_post(array('company_name', 'email', 'contact_number', 'company_address', 'company_logo'));
            $json_value = json_encode($value);
            $data['value'] = $json_value;
            if (empty($id)) {
                $this->Settings_Model->save($data);
                $this->session->set_flashdata('save_message', 'Save successful');
            } else {
                $this->Settings_Model->where_column = 'id';
                $this->Settings_Model->save($data, $id);
                $this->session->set_flashdata('save_message', 'Update successful');
            }
            redirect($this->admin . '/settings');
        } else {
            redirect($this->admin);
        }
    }

    public function smtp_config() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            $this->data['title'] = "Settings-Email";
            $this->load->view('admin/header', $this->data);
            $this->data['smtp_config'] = $this->Settings_Model->get_by(array("name" => 'smtp_config'), true);
            $this->load->view('admin/settings/smtp_config', $this->data);
            $this->load->view('admin/script_page');
        } else {
            redirect($this->admin);
        }
    }

    public function smtp_config_insert() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            $id = $this->input->post('id');
            $data = $this->Settings_Model->data_form_post(array('id', 'name'));
            $value = $this->Settings_Model->data_form_post(array('host', 'user', 'password', 'form'));
            $json_value = json_encode($value);
            $data['value'] = $json_value;
            if (empty($id)) {
                $is_save = $this->Settings_Model->save($data);
                $this->session->set_flashdata('save_message', 'Save successful');
            } else {
                $this->Settings_Model->where_column = 'id';
                $is_save = $this->Settings_Model->save($data, $id);
                $this->session->set_flashdata('save_message', 'Update successful');
            }
            redirect($this->admin . '/settings/smtp_config');
        } else {
            redirect($this->admin);
        }
    }

    public function why_we_are() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            $this->data['title'] = "Settings-Why We Are";
            $this->load->view('admin/header', $this->data);
            $this->data['why_we_are'] = $this->Settings_Model->get_by(array("name" => 'why_we_are'), true);
            $this->load->view('admin/settings/why_we_are', $this->data);
        } else {
            redirect($this->admin);
        }
    }

    public function why_we_are_insert() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            $id = $this->input->post('id');
            if (empty($id)) {
                $data = array('id', 'name', 'value');
                $this->Settings_Model->save($this->Settings_Model->data_form_post(array('id', 'name', 'value')));
                $this->session->set_flashdata('save_message', 'Save successful');
            } else {

                $this->Settings_Model->where_column = 'id';
                $this->Settings_Model->save($this->Settings_Model->data_form_post(array('id', 'name', 'value')), $id);
                $this->session->set_flashdata('save_message', 'Update successful');
            }
            redirect($this->admin . '/settings/why_we_are');
        } else {
            redirect($this->admin);
        }
    }

    public function present_offer() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            $this->data['title'] = "Settings-Why We Are";
            $this->load->view('admin/header', $this->data);
            $this->data['present_offer'] = $this->Settings_Model->get_by(array("name" => 'present_offer'), true);
            $this->load->view('admin/settings/present_offer', $this->data);
        } else {
            redirect($this->admin);
        }
    }

    public function present_offer_insert() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {

            $id = $this->input->post('id');
            $data = $this->Settings_Model->data_form_post(array('id', 'name'));
            $value = $this->Settings_Model->data_form_post(array('offer_description'));
            $new_name = $_FILES["offer_image"]['name'];

            $config['file_name'] = $new_name;
            $config['upload_path'] = './assets/uploads/settings/';
            $config['allowed_types'] = 'gif|jpg|png';
            $this->load->library('upload', $config);

            $is_upload = $this->upload->do_upload('offer_image');
            $d = array('upload_data' => $this->upload->data());
            $present_offer = $this->Settings_Model->get_by(array("name" => 'present_offer'), true);
            if (($d['upload_data']['file_size'])) {
                if (!$is_upload) {
                    $error = array('error' => $this->upload->display_errors());
                    var_dump($error);
                } else {
                    $d = array('upload_data' => $this->upload->data());
                    $path = '/assets/uploads/settings/' . $d['upload_data']['file_name'];
                    $value['offer_image'] = $path;
                    if (!empty($present_offer)) {
                        $details = json_decode($present_offer->value);
                    } else {
                        $details = '';
                    }
                    $path = !empty($details) ? $details->offer_image : '';
                    unlink('.' . $path);
                }
            } else {

                if (!empty($present_offer)) {
                    $details = json_decode($present_offer->value);
                } else {
                    $details = '';
                }
                $value['offer_image'] = !empty($details) ? $details->offer_image : '';
            }

            $json_value = json_encode($value);
            $data['value'] = $json_value;
            echo "id" . $id;
            if (empty($id)) {
                $this->Settings_Model->save($data);
                $this->session->set_flashdata('save_message', 'Save successful');
            } else {
                $this->Settings_Model->where_column = 'id';
                $this->Settings_Model->save($data, $id);
                $this->session->set_flashdata('save_message', 'Update successful');
            }
            redirect($this->admin . '/settings/present_offer');
        } else {
            redirect($this->admin);
        }
    }

    public function home_meta_insert() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                $data = $this->Settings_Model->data_form_post(array('id', 'name'));
                $value = $this->Settings_Model->data_form_post(array('meta_title', 'meta_description', 'meta_keywords'));
                $json_value = json_encode($value);
                $data['value'] = $json_value;
                if (empty($id)) {
                    $this->Settings_Model->save($data);
                } else {
                    $this->Settings_Model->where_column = 'id';
                    $this->Settings_Model->save($data, $id);
                }
                var_dump($data);
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function checkout_settings_insert() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                $data = $this->Settings_Model->data_form_post(array('id', 'name'));
                $value = $this->Settings_Model->data_form_post(array('button_placement', 'is_guest_checkout'));
                $json_value = json_encode($value);
                $data['value'] = $json_value;
                if (empty($id)) {
                    $this->Settings_Model->save($data);
                } else {
                    $this->Settings_Model->where_column = 'id';
                    $this->Settings_Model->save($data, $id);
                }
                var_dump($data);
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function maintenance_mode_settings_insert() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                $data = $this->Settings_Model->data_form_post(array('id', 'name'));
                $value = $this->Settings_Model->data_form_post(array('is_maintenance_mode_on', 'maintenance_message'));
                $json_value = json_encode($value);
                $data['value'] = $json_value;
                if (empty($id)) {
                    $this->Settings_Model->save($data);
                } else {
                    $this->Settings_Model->where_column = 'id';
                    $this->Settings_Model->save($data, $id);
                }
                var_dump($data);
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function google_analytics_verification_settings_insert() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                $data = $this->Settings_Model->data_form_post(array('id', 'name'));
                $value = $this->Settings_Model->data_form_post(array('google_verification_code', 'google_analytics_account_id'));
                $json_value = json_encode($value);
                $data['value'] = $json_value;
                if (empty($id)) {
                    $this->Settings_Model->save($data);
                } else {
                    $this->Settings_Model->where_column = 'id';
                    $this->Settings_Model->save($data, $id);
                }
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function address_settings_insert() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                $data = $this->Settings_Model->data_form_post(array('id', 'name'));
                $value = $this->Settings_Model->data_form_post(array('address_line_1', 'address_line_2', 'address_line_3', 'city', 'postcode', 'latitude', 'longitude', 'phone'));
                var_dump($value);
                $json_value = json_encode($value);
                $data['value'] = $json_value;
                if (empty($id)) {


                    $this->Settings_Model->save($data);
                } else {
                    $this->Settings_Model->where_column = 'id';
                    die();
                    $this->Settings_Model->save($data, $id);
                }
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function site_font_settings() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');

                $data = $this->Settings_Model->data_form_post(array('id', 'name'));
                $value = $this->Settings_Model->data_form_post(
                        array('basket_font_size', 'basket_font_color', 'address_font_size', 'address_font_color', 'phone_font_size',
                            'phone_font_color', 'order_button_font_size', 'order_button_font_color', 'title_font_size',
                            'title_font_color', 'menu_font_size', 'menu_font_color', 'time_font_size', 'time_font_color',
                            'menu_offer_font_size', 'menu_offer_font_color', 'footer_1_offer_font_size', 'footer_1_offer_font_color',
                            'footer_2_offer_font_size', 'footer_2_offer_font_color'));

                $json_value = json_encode($value);
                $data['value'] = $json_value;
                if (empty($id)) {
                    $this->Settings_Model->save($data);
                } else {
                    $this->Settings_Model->where_column = 'id';
                    $this->Settings_Model->save($data, $id);
                }
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function site_skins_settings() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                $data = $this->Settings_Model->data_form_post(array('id', 'name'));

                $value = $this->Settings_Model->data_form_post(array('site_background_color', 'site_theme', 'background_image', 'menu_file'));

                var_dump($value);
                $json_value = json_encode($value);
                $data['value'] = $json_value;
                if (empty($id)) {
                    $this->Settings_Model->save($data);
                } else {
                    $this->Settings_Model->where_column = 'id';
                    $this->Settings_Model->save($data, $id);
                }
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function menu_file_upload() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {

            if ($this->input->is_ajax_request()) {
                $new_name = $_FILES["file"]['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = './assets/uploads/';
                $config['allowed_types'] = 'pdf';
                $this->load->library('upload', $config);
                $is_upload = $this->upload->do_upload('file');
                $d = array('upload_data' => $this->upload->data());
                if ($is_upload) {
                    $path = '/assets/uploads/' . $d['upload_data']['file_name'];
                    ?>
                    <div class="menu-file-url">
                        <div class="form-group row margin-top-1">
                            <label for="menu-file" class="col-xs-12 col-sm-3 col-form-label"></label>

                            <div class="col-xs-12 col-sm-9">
                                <input type="hidden" name="menu_file" value="<?= $path ?>">

                                <p>Upload Success Full</p>
                                <h5><a class="view-menu" href="<?= base_url($path) ?>"
                                       target="_blank"
                                       title="<?= $path ?>">View Menu</a></h5>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="menu-file-url">
                        <p class="error">Upload Error,Try Again</p>
                    <?php echo $this->upload->display_errors(); ?>
                    </div>
                    <script>
                        $('.progress').css({'display': 'none'});
                    </script>
                    <?php
                }
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    /*
     *
     * Allowed Post Code
     *
     * */


    /* Allowed Miles/distance settings */

    public function distance_add() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $this->load->view('admin/settings/distance/add_distance', $this->data);
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function distance_list() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $this->load->model('Allowed_miles_Model');
                /* Post Code */
                $this->data['allowed_miles_list'] = $this->Allowed_miles_Model->get();
                $this->load->view('admin/settings/distance/index', $this->data);
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function distance_delete() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                if (!empty($id)) {
                    $this->load->model('Allowed_miles_Model');
                    $this->Allowed_miles_Model->delete($id);
                }
                /* Post Code */
                $this->data['allowed_miles_list'] = $this->Allowed_miles_Model->get();
                $this->load->view('admin/settings/distance/index', $this->data);
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function distance_edit() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                if (!empty($id)) {
                    $this->load->model('Allowed_miles_Model');
                    $allowed_miles = $this->Allowed_miles_Model->get($id, true);
                    $this->data['allowed_miles'] = $allowed_miles;
                    $this->load->view('admin/settings/distance/edit_distance', $this->data);
                }
                /* Post Code */
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function distance_save() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                $this->load->model('Allowed_miles_Model');
                $from_data = $this->Allowed_miles_Model->data_form_post(array('id', 'delivery_radius_miles', 'delivery_charge', 'min_order_for_delivery'));

                if (empty($id)) {
                    $result = $this->Allowed_miles_Model->save($from_data);
                    if (!$result) {
                        $this->load->view('admin/settings/distance/add_distance', $this->data);
                    }
                } else {
                    $result = $this->Allowed_miles_Model->save($from_data, $id);
                    if (!$result) {
                        $this->load->view('admin/settings/distance/edit_distance', $this->data);
                    }
                }
                if ($result) {
                    /* Post Code */
                    $this->data['allowed_miles_list'] = $this->Allowed_miles_Model->get();
                    $this->load->view('admin/settings/distance/index', $this->data);
                }
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function food_allergy_settings_insert() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                $data = $this->Settings_Model->data_form_post(array('id', 'name'));
                $value = $this->Settings_Model->data_form_post(array('food_allergy_description', 'food_allergy_image'));
                $json_value = json_encode($value);
                $data['value'] = $json_value;
                if (empty($id)) {
                    $this->Settings_Model->save($data);
                } else {
                    $this->Settings_Model->where_column = 'id';
                    $this->Settings_Model->save($data, $id);
                }
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function image_load_food_allergy() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $new_name = $_FILES["file"]['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = './assets/uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                $is_upload = $this->upload->do_upload('file');
                $d = array('upload_data' => $this->upload->data());
                if ($is_upload) {
                    $path = '/assets/uploads/' . $d['upload_data']['file_name'];
                    ?>
                    <div class="image-url">
                        <input type="hidden" name="food_allergy_image" value="<?= $path ?>">

                        <p>Upload Success Full</p>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="image-url">
                        <p class="error">Upload Error,Try Again</p>
                    </div>
                    <script>
                        $('.progress').css({'display': 'none'});
                    </script>
                    <?php
                }
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    public function image_load_background_image() {
        if ($this->User_Model->loggedin() == true && $this->session->userdata('user_role') == 1) {
            if ($this->input->is_ajax_request()) {
                $new_name = $_FILES["file"]['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = './assets/uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                $is_upload = $this->upload->do_upload('file');
                $d = array('upload_data' => $this->upload->data());
                if ($is_upload) {
                    $path = '/assets/uploads/' . $d['upload_data']['file_name'];
                    ?>
                    <div class="image-url">
                        <input type="hidden" name="background_image" value="<?= $path ?>">

                        <p>Upload Success Full</p>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="image-url">
                        <p class="error">Upload Error,Try Again</p>
                    </div>
                    <script>
                        $('.progress').css({'display': 'none'});
                    </script>
                    <?php
                }
            } else {
                redirect($this->admin . '/shop/edit');
            }
        } else {
            redirect($this->admin);
        }
    }

    //Home Promo Settings
    public function home_promo() {
        if (is_user_permitted('admin/settings/home_promo') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $home_promo = $this->Settings_Model->get_by(array("name" => 'home_promo'), true);
        $this->page_content_data['home_promo'] = $home_promo;
        $this->page_content = $this->load->view('admin/settings/home_promo',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/home_promo_js','',true);

        $this->data['title'] = "Home Promo Settings";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function home_promo_save() {
        if (is_user_permitted('admin/settings/menu_upload') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        // dd(json_encode($this->input->post()));
        $value = $this->Settings_Model->data_form_post(array('description','button_url','button_text','promo_image_link','is_show','is_show_in_menu'));
        $promo_image = $this->input->post('promo_image');
        $promo_image = explode(',', $promo_image);
        $value['promo_image'] = $promo_image[0];

        $status = $this->input->post('date_status');
        $date_of_permanence = array('status'=>$status,'date'=>null);

        if ($status) {
            $date = $this->input->post('promo_valid_date');
            $date_of_permanence['date'] = $date;
        }
        $value['date_of_permanence'] = $date_of_permanence;

        $json_value = json_encode($value);
        $data['name'] = 'home_promo';
        $data['value'] = $json_value;
        // dd($data);
        $home_promo = $this->Settings_Model->get_by(array("name" => 'home_promo'), true);
        if (empty($home_promo)) {
            $this->Settings_Model->save($data);
            $this->session->set_flashdata('save_message', 'Information has been Saved successfully');
            redirect($this->admin . '/settings/home_promo');
        } else {
            $id = $home_promo->id;
            $this->Settings_Model->where_column = 'id';
            $this->Settings_Model->save($data, $id);
            $this->session->set_flashdata('save_message', 'Information has been Updated successfully');
            redirect($this->admin . '/settings/home_promo');
        }
    }

    public function image_upload() {
        if ($this->User_Model->loggedin()) {
            if ($this->input->is_ajax_request()) {
                $new_name = $_FILES["file"]['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = './assets/my_uploads/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $this->load->library('upload', $config);
                $is_upload = $this->upload->do_upload('file');
                $d = array('upload_data' => $this->upload->data());

                $responseData = array();
                if ($is_upload) {
                    $path = '/assets/my_uploads/' . $d['upload_data']['file_name'];
                    $responseData = array(
                        'isUploaded' => true,
                        'imagePath' => $path,
                        'fullPath' => base_url($path),
                        'message' => '  <p class="success">Upload Successful</p>'
                    );
                } else {
                    $error_message = strip_tags($this->upload->display_errors());
                    $responseData = array(
                        'isUploaded' => true,
                        'imagePath' => null,
                        'fullPath' => null,
                        'message' => '<p class="error">Upload Error ,Because ' . $error_message . '</p>',
                        'error' => '<p class="error">' . $error_message . '</p>'
                    );
                }
                $this->output->set_content_type('application/json')->set_output(json_encode($responseData));
            } else {
                //redirect($this->admin . '/shop/edit');
                redirect($this->admin);
            }
        } else {
            redirect($this->admin);
        }
    }

}