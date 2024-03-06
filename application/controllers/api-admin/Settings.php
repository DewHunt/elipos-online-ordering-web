<?php
/**
 * Created by IntelliJ IDEA.
 * User: Asus
 * Date: 12-Sep-19
 * Time: 11:54 AM
 */

class Settings extends ApiAdmin_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('shop_helper');
        $this->load->helper('settings');
        $this->load->model('Settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Allowed_miles_Model');
        $this->load->model('Shop_timing_Model');
        // $this->Settings_Model->where_column = 'name';
    }

    public function get_business_information_settings(){
        if($this->checkMethod('GET')){
            if ($this->is_token_verified()) {
                // dd($this->input->post());
                $name = 'company_details';
                $data = $this->Settings_Model->get_by(array("name" => $name), true);
                $value = get_property_value('value',$data);
                $responseData = json_decode($value,true);
                $responseData['company_logo'] = base_url($responseData['company_logo']);
                $responseData['favicon'] = base_url($responseData['favicon']);
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }
            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function business_information_settings_save() {
        if($this->checkMethod('POST')){
            if ($this->is_token_verified()) {
                $data = $this->input->post('data');
                if ($data) {
                    $data = json_decode($data);
                    if ($data->company_name) {
                        $settings_info = $this->Settings_Model->get_by(array("name"=>'company_details'),true);
                        if ($settings_info) {                        
                            $value = array(
                                'company_name'=>$data->company_name,
                                'email'=>$data->email,
                                'contact_number'=>$data->contact_number,
                                'company_address'=>$data->company_address,
                                'food_type'=>$data->food_type,
                                'postcode'=>$data->postcode,
                                'pickup_time'=>$data->pickup_time,
                                'city'=>$data->city,
                                'minimum_order_amount'=>$data->minimum_order_amount,
                                'minimum_order_amount_text'=>$data->minimum_order_amount_text,
                                'delivery_time'=>$data->delivery_time,
                                'cc_email'=>$data->cc_email,
                                'latitude'=>$data->latitude,
                                'longitude'=>$data->longitude,
                                'per_slot_collection_order'=>$data->per_slot_collection_order,
                                'per_slot_delivery_order'=>$data->per_slot_delivery_order
                            );

                            $settings_info_value = json_decode($settings_info->value,true);

                            $company_logo = get_array_key_value('company_logo',$settings_info_value);
                            if (isset($_FILES["company_logo"]) && $_FILES["company_logo"]) {
                                $company_logo = image_upload('company_logo',$_FILES["company_logo"],'assets/my_uploads/');
                            }

                            $favicon = get_array_key_value('favicon',$settings_info_value);
                            if (isset($_FILES["favicon"]) && $_FILES["favicon"]) {
                                $favicon = image_upload('favicon',$_FILES["favicon"],'assets/my_uploads/');
                            }

                            $value['company_logo'] = $company_logo;
                            $value['favicon'] = $favicon;
                            
                            $value = json_encode($value);
                            $is_save = $this->Settings_Model->save(array('value' => $value), $settings_info->id);
                            if ($is_save) {
                                $responseData = array('status'=>200,'message'=>'Business Information update successfully');
                            } else {
                                $responseData = array('status'=>200,'message'=>'Business Information is not updated');
                            }
                        } else {
                            $responseData = array('status'=>404,'message'=>'Data Not Found');
                        }
                    } else {
                        $responseData = array('status'=>400,'message'=>'Bad Request');
                    }
                } else {
                    $responseData = array('status'=>400,'message'=>'Bad Request');
                }
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }

            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function get_home_promo(){
        if($this->checkMethod('GET')){
            if ($this->is_token_verified()) {
                $name = 'home_promo';
                $data = $this->Settings_Model->get_by(array("name" => $name), true);
                $value = get_property_value('value',$data);
                $responseData = json_decode($value,true);
                $responseData['promo_image'] = base_url($responseData['promo_image']);
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }
            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function update_home_promo() {
        if ($this->checkMethod('POST')) {
            if ($this->is_token_verified()) {
                $data = $this->input->post('data');
                if ($data) {
                    $data = json_decode($data);
                    $status = $data->date_status;
                    $date = $data->promo_valid_date;
                    if (($status == 1 && $date) || (($status == 0 || $status == "") && (empty($date) || $date))) {
                        $settings_info = $this->Settings_Model->get_by(array("name"=>'home_promo'),true);
                        if ($settings_info) {
                            $value = array(
                                'description'=>$data->description,
                                'button_url'=>$data->button_url,
                                'button_text'=>$data->button_text,
                                'promo_image_link'=>$data->promo_image_link,
                                'is_show'=>$data->is_show,
                                'is_show_in_menu'=>$data->is_show_in_menu
                            );

                            $date_of_permanence = array('status'=>$status,'date'=>null);

                            if ($status) {
                                $date_of_permanence['date'] = $date;
                            }
                            $value['date_of_permanence'] = $date_of_permanence;

                            $settings_info_value = json_decode($settings_info->value,true);

                            $promo_image = get_array_key_value('promo_image',$settings_info_value);
                            if (isset($_FILES["promo_image"]) && $_FILES["promo_image"]) {
                                $promo_image = image_upload('promo_image',$_FILES["promo_image"],'assets/promo_images/');
                            }
                            $value['promo_image'] = $promo_image;
                            
                            $value = json_encode($value);
                            $is_save = $this->Settings_Model->save(array('value' => $value), $settings_info->id);
                            if ($is_save) {
                                $responseData = array('status'=>200,'message'=>'Home Promo update successfully');
                            } else {
                                $responseData = array('status'=>200,'message'=>'Home Promo is not updated');
                            }
                        } else {
                            $responseData = array('status'=>404,'message'=>'Data Not Found');
                        }
                    } else {
                        $responseData = array('status'=>400,'message'=>'Bad Request');
                    }
                } else {
                    $responseData = array('status'=>400,'message'=>'Bad Request');
                }
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }

            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    private function uploadFile($postValue, $fileName) {
        if (!is_dir('assets/uploads')) {
            mkdir('./uploads',0777, TRUE);
        }
        $config['file_name'] = $fileName.'-'.time();
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $this->load->library('upload', $config);
        $is_upload = $this->upload->do_upload($postValue);
        $d = array('upload_data' => $this->upload->data());
        if ($is_upload) {
            return 'assets/uploads/' . $d['upload_data']['file_name'];
        } else {
            return null;
        }
    }

    public function get_weekend_off() {
        if ($this->checkMethod('GET')) {
            if ($this->is_token_verified()) {
                $weekend_off = $this->Settings_Model->get_by(array("name" => 'weekend_off'), true);
                $value = get_property_value('value',$weekend_off);
                $responseData = json_decode($value,true);
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }
            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function weekend_off_save() {
        if($this->checkMethod('POST')){
            if ($this->is_token_verified()) {
                $data = $this->input->post('data');
                if ($data) {
                    $settings_info = $this->Settings_Model->get_by(array("name" => 'weekend_off'),true);
                    if ($settings_info) {
                        $data = json_decode($data);
                        $value = array('day_ids'=>$data->day_ids,'is_off_all_holidays'=>$data->is_off_all_holidays);
                        $is_closed_for_today = $data->is_closed_for_today;
                        $is_closed_for_tomorrow = $data->is_closed_for_tomorrow;
                        $is_closed_for_this_weeks = $data->is_closed_for_this_weeks;

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
                        $value = json_encode($value);

                        $is_save = $this->Settings_Model->save(array('value' => $value,), $settings_info->id);
                        if ($is_save) {
                            $responseData = array('status'=>200,'message'=>'Weekend and Holidays update successfully');
                        } else {
                            $responseData = array('status'=>200,'message'=>'Weekend and Holidays is not updated');
                        }
                    } else {
                        $responseData = array('status'=>404,'message'=>'Data Not Found');
                    }
                } else {
                    $responseData = array('status'=>400,'message'=>'Bad Request');
                }
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }

            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function get_currency() {
        if ($this->checkMethod('GET')) {
            if ($this->is_token_verified()) {
                $weekend_off = $this->Settings_Model->get_by(array("name" => 'currency'), true);
                $value = get_property_value('value',$weekend_off);
                $responseData = json_decode($value,true);
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }
            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function currency_save() {
        if($this->checkMethod('POST')){            
            if ($this->is_token_verified()) {
                // dd($this->input->post());
                $data = $this->input->post('data');
                if ($data) {
                    $data = json_decode($data);
                    if ($data->symbol && $data->placement) {
                        $settings_info = $this->Settings_Model->get_by(array("name" => 'currency'),true);
                        if ($settings_info) {
                            $value = json_encode($data);
                            $is_save = $this->Settings_Model->save(array('value' => $value), $settings_info->id);
                            if ($is_save) {
                                $responseData = array('status'=>200,'message'=>'Currency Settings update successfully');
                            } else {
                                $responseData = array('status'=>200,'message'=>'Currency is not updated');
                            }
                        } else {
                            $responseData = array('status'=>404,'message'=>'Data Not Found');
                        }
                    } else {
                        $responseData = array('status'=>400,'message'=>'Bad Request');
                    }                
                } else {
                    $responseData = array('status'=>400,'message'=>'Bad Request');
                }
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }            
            
            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function get_maintenance_mode() {
        if ($this->checkMethod('GET')) {
            if ($this->is_token_verified()) {
                $rowData = $this->Settings_Model->get_by(array("name" => 'maintenance_mode_settings'), true);
                $value = get_property_value('value',$rowData);
                $responseData = json_decode($value,true);
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }
            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function maintenance_mode_save() {
        if($this->checkMethod('POST')){
            if ($this->is_token_verified()) {
                $data = $this->input->post('data');
                if ($data) {
                    $settings_info = $this->Settings_Model->get_by(array("name"=>'maintenance_mode_settings'),true);
                    if ($settings_info) {
                        $data = json_decode($data);
                        $value = array(
                            'message'=>$data->message,
                            'is_maintenance'=>$data->is_maintenance,
                            'is_app_maintenance'=>$data->is_app_maintenance,
                            'environment'=>$data->environment
                        );
                        $is_for_today = $data->is_for_today;
                        $is_for_tomorrow = $data->is_for_tomorrow;
                        if (empty($is_for_today)) {
                            $is_for_today = 0;
                        }

                        if (empty($is_for_tomorrow)) {
                            $is_for_tomorrow = 0;
                        }

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

                        $settings_info_value = json_decode($settings_info->value,true);
                        $image = get_array_key_value('image',$settings_info_value,'assets/no-imgee.jpg');
                        if (isset($_FILES["image"]) && $_FILES["image"]) {
                            $image = image_upload('image',$_FILES["image"],'assets/my_uploads/');
                        }
                        $value['image'] = $image;

                        $value = json_encode($value);
                        $is_save = $this->Settings_Model->save(array('value' => $value), $settings_info->id);
                        if ($is_save) {
                            $responseData = array('status'=>200,'message'=>'Maintenance Mode update successfully');
                        } else {
                            $responseData = array('status'=>200,'message'=>'Maintenance Mode is not updated');
                        }
                    } else {
                        $responseData = array('status'=>404,'message'=>'Data Not Found');
                    }
                } else {
                    $responseData = array('status'=>400,'message'=>'Bad Request');
                }
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }
            
            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function social_media() {
        if ($this->checkMethod('GET')) {
            if ($this->is_token_verified()) {
                $name = 'social_media';
                $rowData = $this->Settings_Model->get_by(array("name" => $name), true);
                $value = get_property_value('value',$rowData);
                $responseData = json_decode($value,true);
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }
            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function social_media_save() {
        if($this->checkMethod('POST')) {
            if ($this->is_token_verified()) {
                $value = $this->input->post('data');
                if ($value) {
                    $name = 'social_media';
                    $settings_info = $this->Settings_Model->get_by(array("name" => $name),true);
                    if ($settings_info) {
                        $is_save = $this->Settings_Model->save(array('value' => $value,), $settings_info->id);
                        if ($is_save) {
                            $responseData = array('status'=>200,'message'=>'Social Medai update successfully');
                        } else {
                            $responseData = array('status'=>200,'message'=>'Social Media is not updated');
                        }
                    } else {
                        $responseData = array('status'=>404,'message'=>'Data Not Found');
                    }
                } else {
                    $responseData = array('status'=>400,'message'=>'Bad Request');
                }
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }
            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    //opening_and_closing
    public function get_shop_timings() {
        if ($this->checkMethod('GET')) {
            if ($this->is_token_verified()) {
                $this->Shop_timing_Model->db->select('* ,TIME_FORMAT(`open_time`,"%h:%i %p") AS `openTimeText`,TIME_FORMAT(`close_time`,"%h:%i %p") AS `closeTimeText`');
                $this->Shop_timing_Model->db->order_by('sort_order', 'ASC');
                $shop_timing_list = $this->Shop_timing_Model->get();
                $responseData = array(
                    'shopTimings' => $shop_timing_list,
                    'responseMessage' => 'Data is given',
                );
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }
            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function shop_timing_save() {
        if ($this->checkMethod('POST')) {
            if ($this->is_token_verified()) {
                $data = $this->input->post('data');
                if ($data) {
                    $data = json_decode($data);
                    $id = $data->id;
                    $day_id = $data->day_id;
                    $order_type = $data->order_type;
                    $sort_order = $data->sort_order;
                    $open_time = $data->open_time;
                    $close_time = $data->close_time;
                    $collection_delivery_time = $data->collection_delivery_time;

                    if ($id && $day_id >= 0 && $order_type && $sort_order && $open_time && $close_time) {
                        $value = array(
                            'day_id' => $day_id,
                            'open_time' => $open_time,
                            'close_time' => $close_time,
                            'sort_order' => $sort_order,
                            'order_type' => $order_type,
                            'collection_delivery_time' => $collection_delivery_time,
                        );
                        $is_save = false;

                        $this->Shop_timing_Model->where_column = 'id';
                        $is_save = $this->Shop_timing_Model->save($value,$id);

                        if ($is_save) {
                            $responseData = array('status'=>200,'message'=>'Opening and Closing Time update successfully');
                        } else {
                            $responseData = array('status'=>200,'message'=>'Opening and Closing Time is not updated');
                        }
                    } else {
                        $responseData = array('status'=>400,'message'=>'Bad Request');
                    }
                } else {
                    $responseData = array('status'=>400,'message'=>'Bad Request');
                }
            } else {
                $responseData = array('status'=>408,'message'=>'Request Timeout Or Session Expired');
            }

            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function shop_timing_delete($id = 0) {
        if ($this->checkMethod('POST')) {
            $isDeleted = $this->Shop_timing_Model->delete(intval($id));
            $responseData = array(
                'isDeleted' =>$isDeleted ,
                'responseMessage' => ($isDeleted) ? 'Shop Time is successfully deleted' : 'Shop Time is not deleted',
            );
            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function payment() {
        if ($this->checkMethod('GET')) {
            $name = 'payment_settings';
            $rowData = $this->Settings_Model->get_by(array("name" => $name), true);
            $value = get_property_value('value',$rowData);
            $value = json_decode($value,true);

            $paymentGatewayList = [
                ['name'=>'paypal','title'=>'Paypal'],
                ['name'=>'stripe','title'=>'Stripe'],
                ['name'=>'nochex','title'=>'Nochex'],
            ];

            $orderTypes = [
                ['name'=>'delivery_and_collection','title'=>'Delivery and collection'],
                ['name'=>'delivery','title'=>'Delivery'],
                ['name'=>'collection','title'=>'Collection'],
            ];

            $paymentMethods = [
                ['name'=>'both','title'=>'Cash and Online'],
                ['name'=>'cash','title'=>'Cash Only'],
                ['online'=>'card','title'=>'Online Only'],
            ];

            $this->setResponseJsonOutput(array(
                'settingsData'=>$value,
                'paymentGatewayList'=>$paymentGatewayList,
                'paymentMethods'=>$paymentMethods,
                'orderTypes'=>$orderTypes,
            ),ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function payment_save() {
        if ($this->checkMethod('POST')) {
            $name = 'payment_settings';
            $data = $this->input->post($name);
            $isSave = false;
            if (!empty($data)) {
                $this->Settings_Model->where_column = 'name';
                $isSave = $this->Settings_Model->save(['value'=>$data], $name);
            }
            $responseData = array(
                'isSave' => $isSave,
                'responseMessage' => ($isSave) ? 'Save Successfully' : 'Save Unsuccessful',
            );
            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function paypal() {
        if ($this->checkMethod('GET')) {
            $name = 'paypal_settings';
            $rowData =  $this->Settings_Model->get_by(array("name" => $name), true);
            $sData = get_property_value('value',$rowData);
            $sData = json_decode($sData,true);

            $currencies = get_currency_array();
            $newCurrencies = array();
            foreach ($currencies as $key => $value){
                array_push($newCurrencies,['name'=>$key,'title'=>$value.'('.$key.')',]);
            }
            $this->setResponseJsonOutput(array('settingsData'=>$sData,'currencies'=>$newCurrencies,),ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function paypal_save() {
        if($this->checkMethod('POST')){
            $name = 'paypal_settings';
            $data = $this->input->post($name);
            $isSave = false;
            if (!empty($data)) {
                $this->Settings_Model->where_column = 'name';
                $isSave = $this->Settings_Model->save(['value'=>$data], $name);
            }
            $responseData = array(
                'isSave' => $isSave,
                'responseMessage' => ($isSave)?'Save Successfully':'Save Unsuccessful',
            );
            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function stripe() {
        if ($this->checkMethod('GET')) {
            $name = 'stripe_settings';
            $rowData = $this->Settings_Model->get_by(array("name" => $name), true);
            $value = get_property_value('value',$rowData);
            $value = json_decode($value,true);
            $this->setResponseJsonOutput($value,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function stripe_save() {
        if($this->checkMethod('POST')){
            $name = 'stripe_settings';
            $data = $this->input->post($name);
            $isSave = false;
            if(!empty($data)){
                $this->Settings_Model->where_column = 'name';
                $isSave = $this->Settings_Model->save(['value'=>$data], $name);
            }
            $responseData = array(
                'isSave' => $isSave,
                'responseMessage' => ($isSave)?'Save Successfully':'Save Unsuccessful',
            );
            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function nochex() {
        if ($this->checkMethod('GET')) {
            $name = 'nochecx_settings';
            $rowData = $this->Settings_Model->get_by(array("name" => $name), true);
            $value = get_property_value('value',$rowData);
            $value = json_decode($value,true);
            $this->setResponseJsonOutput($value,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function nochex_save() {
        if($this->checkMethod('POST')){
            $name = 'nochecx_settings';
            $data = $this->input->post($name);
            $isSave = false;
            if(!empty($data)){
                $this->Settings_Model->where_column = 'name';
                $isSave = $this->Settings_Model->save(['value'=>$data], $name);
            }
            $responseData = array(
                'isSave' => $isSave,
                'responseMessage' => ($isSave)?'Save Successfully':'Save Unsuccessful',
            );
            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function area_coverage() {
        if ($this->checkMethod('GET')) {
            $this->load->model('Allowed_postcodes_Model');
            $coverageAreaList = $this->Allowed_postcodes_Model->get();
            $this->setResponseJsonOutput(array('coverageAreas'=>$coverageAreaList),ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function area_coverage_save() {
        if ($this->checkMethod('POST')) {
            $id = trim($this->input->post('id'));
            $from_data = $this->Allowed_postcodes_Model->data_form_post(array('id', 'postcode', 'delivery_charge', 'min_order_for_delivery'));

            $this->form_validation->set_rules('postcode', 'Postcode', 'required');
            $this->form_validation->set_rules('delivery_charge', 'Delivery Charge', 'required');
            $this->form_validation->set_rules('min_order_for_delivery', 'Min Order For Delivery', 'required');
            /*($isSave)?'Save Successfully':'Save Unsuccessful'*/

            $isSave = false;
            $responseData = array('isSave' => $isSave,'responseMessage' => '');

            if ($this->form_validation->run() === FALSE) {
                $responseData['responseMessage']=validation_errors();
            } else {
                if (empty($id)) {
                    $is_postcode_exists = $this->Allowed_postcodes_Model->is_postcode_exists($from_data['postcode']);
                    if (!$is_postcode_exists) {
                        $isSave = $this->Allowed_postcodes_Model->save($from_data);
                        $responseData['responseMessage'] = ($isSave) ? 'Save Successfully' : 'Save Unsuccessful';

                    } else {
                        $responseData['responseMessage'] = 'Postcode Already Exists';
                    }
                } else {
                    $is_postcode_exists_for_update = $this->Allowed_postcodes_Model->is_postcode_exists_for_update($id, $from_data['postcode']);
                    if (!$is_postcode_exists_for_update) {
                        $isSave = $this->Allowed_postcodes_Model->save($from_data, $id);
                        $responseData['responseMessage'] = ($isSave) ? 'Update Successfully' : 'Update Unsuccessful';
                    } else {
                        $responseData['responseMessage'] = 'Postcode Already Exists.';
                    }
                }
            }

            $responseData['isSave'] = $isSave;
            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function area_coverage_delete($id = 0) {
        if ($this->checkMethod('POST')) {
            $isDeleted = $this->Allowed_postcodes_Model->delete(intval($id));
            $responseData = array(
                'isDeleted' => $isDeleted,
                'responseMessage' => ($isDeleted) ? 'Coverage Area is successfully deleted' : 'Coverage Area is not deleted',
            );
            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    //allowed_miles
    public function allowed_miles() {
        if ($this->checkMethod('GET')) {
            $this->load->model('Allowed_postcodes_Model');
            $allowed_miles_list = $this->Allowed_miles_Model->get();
            $this->setResponseJsonOutput(array(
                'allowedMiles'=>$allowed_miles_list
            ),ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function allowed_mile_save() {
        if ($this->checkMethod('POST')) {
            $id = trim($this->input->post('id'));
            $from_data = $this->Allowed_miles_Model->data_form_post(array('id', 'delivery_radius_miles', 'delivery_charge', 'min_order_for_delivery'));
            $this->form_validation->set_rules('delivery_radius_miles', 'Delivery Radius Miles', 'required');
            $this->form_validation->set_rules('delivery_charge', 'Delivery Charge', 'required');
            $this->form_validation->set_rules('min_order_for_delivery', 'Min Order For Delivery', 'required');
            $isSave = false;
            $responseData = array('isSave' => $isSave,'responseMessage' => '');
            if ($this->form_validation->run() === FALSE) {
                $responseData['responseMessage'] = validation_errors();
            } else {
                if (empty($id)) {
                    $is_allowed_miles_exists = $this->Allowed_miles_Model->is_allowed_miles_exists($from_data['delivery_radius_miles']);
                    if (!$is_allowed_miles_exists) {
                        $isSave = $this->Allowed_miles_Model->save($from_data);
                        $responseData['responseMessage'] = ($isSave) ? 'Save Successfully' : 'Save Unsuccessful';
                    } else {
                        $responseData['responseMessage'] = 'Delivery Radius Miles Already Exists.';
                    }
                } else {
                    $is_allowed_miles_exists_for_update = $this->Allowed_miles_Model->is_allowed_miles_exists_for_update($id, $from_data['delivery_radius_miles']);
                    if (!$is_allowed_miles_exists_for_update) {
                        $isSave = $this->Allowed_miles_Model->save($from_data, $id);
                        $responseData['responseMessage'] = ($isSave) ? 'Update Successfully' : 'Update Unsuccessful';
                    } else {
                        $responseData['responseMessage'] = 'Delivery Radius Miles Already Exists.';
                    }
                }
            }

            $responseData['isSave'] = $isSave;
            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function allowed_mile_delete($id = 0) {
        if ($this->checkMethod('POST')) {
            $isDeleted = $this->Allowed_miles_Model->delete($id);;
            $responseData = array(
                'isDeleted' =>$isDeleted ,
                'responseMessage' => ($isDeleted)?'Allowed Mile is successfully deleted':'Allowed Mile is not deleted',
            );
            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function discount() {
        if ($this->checkMethod('GET')) {
            $name = 'discount';
            $discount = $this->Settings_Model->get_by(array('name' => $name,), true);
            $value = get_property_value('value',$discount);
            $value = (!empty($value)) ? json_decode($value,true) : null;
            $this->setResponseJsonOutput($value,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function discount_save() {
        if ($this->checkMethod('POST')) {
            $name = 'discount';
            $value = $this->input->post('discount');
            $is_save = false;
            if (!empty($value)) {
                // updated
                $this->Settings_Model->where_column = 'name';
                $is_save = $this->Settings_Model->save(array('name' => $name,'value' => $value,),$name);
            }

            $message = ($is_save) ? 'Discount details is save successfully' : 'Discount details is not save';
            $responseData['isSave'] = $is_save;
            $responseData['responseMessage'] = $message;
            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }
    }
}