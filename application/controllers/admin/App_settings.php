<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_settings extends Admin_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('App_Settings_Model');
        $this->load->helper('directory');
    }

    public function index() {
        if ($this->User_Model->loggedin()) {
        } else {
            redirect($this->admin);
        }
    }

    public function app_menu() {
        if (is_user_permitted('admin/app_settings/app_menu') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $menu_lists = $this->App_Settings_Model->get_decoded_value_by_name('app_menu');
        // dd($menu_lists);

        $this->page_content_data['title'] = "App Menu Lists";
        $this->page_content_data['menu_lists'] = $menu_lists;
        $this->page_content = $this->load->view('admin/app_settings/app_menu/index',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/app_settings/pages/index_js',$this->page_content_data,true);

        $this->data['title'] = "App Menu Lists | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add_app_menu() {
        if (is_user_permitted('admin/app_settings/app_menu') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['page_title'] = "Add App Menu";
        $this->page_content_data['btnName'] = "Save";
        $this->page_content_data['menu_info'] = '';
        $this->page_content = $this->load->view('admin/app_settings/app_menu/add_edit_form',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/app_settings/pages/index_js',$this->page_content_data,true);

        $this->data['title'] = "App Menu | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_app_menu($id) {
        if (is_user_permitted('admin/app_settings/app_menu') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $menu_lists = $this->App_Settings_Model->get_decoded_value_by_name('app_menu');
        $menu_info = '';
        if ($menu_lists) {
            foreach ($menu_lists as $menu) {
                if ($menu->id == $id) {
                    $menu_info = $menu;
                }
            }
        }

        $this->page_content_data['page_title'] = "Edit App Menu";
        $this->page_content_data['btnName'] = "Update";
        $this->page_content_data['menu_info'] = $menu_info;
        $this->page_content = $this->load->view('admin/app_settings/app_menu/add_edit_form',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/app_settings/pages/index_js',$this->page_content_data,true);

        $this->data['title'] = "App Menu | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save_app_menu() {
        if (is_user_permitted('admin/app_settings/app_menu') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $name = 'app_menu';
        $id = $this->input->post('id');
        $value = $this->App_Settings_Model->data_form_post(array('id','title','component','path','btnColor','sortingNumber','homeSortingNumber','iconName','isActive','isShow','showInHome'));
        if ($_FILES["iconImagePath"]["name"]) {
            $iconImagePath = image_upload('iconImagePath',$_FILES["iconImagePath"],'assets/images/mobile_apps/icon_images/');
        } else {
            $iconImagePath = $this->input->post('previousIconImagePath');
        }

        if ($_FILES["homeIconImagePath"]["name"]) {
            $homeIconImagePath = image_upload('homeIconImagePath',$_FILES["homeIconImagePath"],'assets/images/mobile_apps/icon_images/');
        } else {
            $homeIconImagePath = $this->input->post('previousHomeIconImagePath');
        }

        $value['iconImagePath'] = $iconImagePath;
        $value['homeIconImagePath'] = $homeIconImagePath;
        
        $menu_lists = $this->App_Settings_Model->get_decoded_value_by_name($name);

        if ($id) {
            if ($menu_lists) {
                foreach ($menu_lists as $key => $menu) {
                    if ($menu->id == $id) {
                        $menu_lists[$key] = $value;
                    }
                }
            }
        } else {
            $value['id'] =  rand();
            if (is_array($menu_lists) && $menu_lists) {
                array_push($menu_lists, $value);
            } else {
                $menu_lists = array($value);
            }
        }

        $is_save = $this->App_Settings_Model->save_by_name($name,json_encode($menu_lists,JSON_NUMERIC_CHECK));
        if ($is_save) {
            redirect(base_url('admin/app_settings/app_menu'));
        }
    }

    public function home_page() {
        // dd($this->top_image());
        if (is_user_permitted('admin/app_settings/home_page') == false) {
            redirect(base_url('admin/dashboard'));
        }
        
        $no_img = base_url().'assets/images/no-image.jpg';
        $this->page_content_data['title'] = "Home Pages";
        $this->page_content_data['home_page'] = $this->App_Settings_Model->get_decoded_value_by_name('home_page');
        $this->page_content_data['no_img'] = $no_img;
        $this->page_content_data['background_image'] = $this->background_image();
        $this->page_content_data['top_image'] = $this->top_image();
        $this->page_content_data['logo_image'] = $this->logo_image();
        $this->page_content_data['slider_images'] = $this->slider_images();
        $this->page_content_data['notification_images'] = $this->notification_images();
        $this->page_content = $this->load->view('admin/app_settings/pages/home/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/app_settings/pages/home/index_js',$this->page_content_data,true);

        $this->data['title'] = "Home Pages | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save_home_page() {
        if (is_user_permitted('admin/app_settings/home_page') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $name = 'home_page';
        $value = $this->App_Settings_Model->data_form_post(array('isBackgroundImageShow','isTopImageShow','isLogoImageShow','isSliderShow','isMenuButtonShow','isHomeImageIconShow','isChevronIcon','homeIconImageSide','backgroundColor'));
        if (empty($value['backgroundColor'])) {
            $value['backgroundColor'] = 'none';
        }

        $is_save = $this->App_Settings_Model->save_by_name($name,json_encode($value,JSON_NUMERIC_CHECK));

        $message = ($is_save) ? 'Saved successfully' : 'Save failed';
        $this->session->set_flashdata('message', $message);
        redirect(base_url('admin/app_settings/home_page'));
    }

    public function upload_image() {
        // dd($this->input->post());
        if (isset($_FILES['backgroundImage'])) {
            $currentImage = $this->input->post('currentImage');
            $this->delete_image($currentImage);
            image_upload('backgroundImage',$_FILES["backgroundImage"],'assets/images/mobile_apps/background/','background');
        }
        if (isset($_FILES['topImage'])) {
            $currentImage = $this->input->post('currentImage');
            $this->delete_image($currentImage);
            image_upload('topImage',$_FILES["topImage"],'assets/images/mobile_apps/top-image/');
        }
        if (isset($_FILES['logoImage'])) {
            $currentImage = $this->input->post('currentImage');
            $this->delete_image($currentImage);
            image_upload('logoImage',$_FILES["logoImage"],'assets/images/mobile_apps/logo/');
        }
        if (isset($_FILES['sliderImages'])) {
            multiple_image_upload('sliderImages','assets/images/mobile_apps/sliders/');
        }
        if (isset($_FILES['notificationImages'])) {
            multiple_image_upload('notificationImages','assets/images/mobile_apps/notifications/');
        }
        redirect(base_url('admin/app_settings/home_page'));
    }

    public function delete_image($image_path = '') {
        if (empty($image_path)) {
            $image_path = $this->input->post('imagePath');
        }
        $output = '';
        if ($image_path) {
            $path = explode(base_url(),$image_path);
            if (is_array($path) && isset($path[1])) {
                $path = $path[1];
                $is_file_exist = file_exists($path);
                if ($is_file_exist) {
                    $is_deleted = unlink($path);
                    if ($is_deleted) {
                        $deleteFor = $this->input->post('deleteFor');
                        if ($deleteFor == 'top-img' || $deleteFor == 'logo-img' || $deleteFor == 'background-img') {
                            $output = base_url().'assets/images/no-image.jpg';
                        }
                        if ($deleteFor == 'slider-img') {
                            $this->data['slider_images'] = $this->slider_images();
                            $output = $this->load->view('admin/app_settings/pages/home/slider_image_lists',$this->data,true);
                        }
                        if ($deleteFor == 'notification-img') {
                            $this->data['notification_images'] = $this->notification_images();
                            $output = $this->load->view('admin/app_settings/pages/home/notification_image_lists',$this->data,true);
                        }
                    }
                }
            }

        }
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('output'=>$output)));
        }
    }

    public function slider_images() {
        $slider_images_path = './assets/images/mobile_apps/sliders/';
        $slider_images = directory_map($slider_images_path, 1);
        $path = base_url().'assets/images/mobile_apps/sliders/';
        if ($slider_images) {
            foreach ($slider_images as $key => $image) {
                $slider_images[$key] = $path.$image;
            }
        }
        return $slider_images;
    }

    public function notification_images() {
        $notification_images_path = './assets/images/mobile_apps/notifications/';
        $notification_images = directory_map($notification_images_path, 1);
        $path = base_url().'assets/images/mobile_apps/notifications/';
        if ($notification_images) {
            foreach ($notification_images as $key => $image) {
                $notification_images[$key] = $path.$image;
            }
        }
        return $notification_images;
    }

    public function background_image() {
        $top_images_path = './assets/images/mobile_apps/background/';
        $path = base_url().'assets/images/mobile_apps/background/';
        $all_images = directory_map($top_images_path, 1);
        $background_image = $all_images ? $path.$all_images[0] : '';
        return $background_image;
    }

    public function top_image() {
        $top_images_path = './assets/images/mobile_apps/top-image/';
        $path = base_url().'assets/images/mobile_apps/top-image/';
        $all_images = directory_map($top_images_path, 1);
        $top_image = $all_images ? $path.$all_images[0] : '';
        return $top_image;
    }

    public function logo_image() {
        $logo_images_path = './assets/images/mobile_apps/logo/';
        $path = base_url().'assets/images/mobile_apps/logo/';
        $all_images = directory_map($logo_images_path, 1);
        $logo_image = $all_images ? $path.$all_images[0] : '';
        return $logo_image;
    }

    public function get_page_settings(){
        if ($this->input->is_ajax_request()) {
            if ($this->User_Model->loggedin()) {
                $name=$this->input->post('name');
                $m_app_settings=new App_Settings_Model();
                $value=$m_app_settings->get_value_by_name($name);
                $this->data['value']=(!empty($value))?json_decode($value,true):null;
                $settingsModalContent=$this->load->view('admin/app_settings/pages/home_settings',$this->data,true);
                $this->output->set_content_type('application/json')->set_output(json_encode(array(
                    'isLogIn' =>true,
                    'settingsModalContent' =>$settingsModalContent,
                )));
            } else {
                $this->output->set_content_type('application/json')->set_output(json_encode(array(
                    'isLogIn' =>false,
                    'tableData' =>null,
                )));
            }
        } else {
            redirect($this->admin);
        }
    }

    public function android_version() {
        if (is_user_permitted('admin/app_settings/android_version') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $android_version = $this->App_Settings_Model->get_decoded_value_by_name('android_version');
        // dd($android_version);

        $this->page_content_data['title'] = "Android Version";
        $this->page_content_data['android_version'] = $android_version;
        $this->page_content = $this->load->view('admin/app_settings/android_version/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/app_settings/android_version/index_js',$this->page_content_data,true);

        $this->data['title'] = "Android Version | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function get_android_version_info() {
        $android_version = $this->App_Settings_Model->get_decoded_value_by_name('android_version');
        $this->output->set_content_type('application/json')->set_output(json_encode(array('android_version' => $android_version,)));   
    }

    public function save_android_version() {
        if (is_user_permitted('admin/settings/android_version') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $name = 'android_version';
        $value = $this->App_Settings_Model->data_form_post(array('play_store_url','package_name','update_url','current_app_version'));

        $is_save = $this->App_Settings_Model->save_by_name($name,json_encode($value,JSON_NUMERIC_CHECK));

        $android_version = $this->App_Settings_Model->get_decoded_value_by_name('android_version');

        $message = ($is_save) ? 'Saved successfully' : 'Save failed';
        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'is_save'=>$is_save,
            'android_version'=>$android_version,
            'message'=>$message
        ),JSON_NUMERIC_CHECK));
    }

    public function ios_version() {
        if (is_user_permitted('admin/app_settings/ios_version') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $ios_version = $this->App_Settings_Model->get_decoded_value_by_name('ios_version');
        // dd($ios_version);

        $this->page_content_data['title'] = "iOS Version";
        $this->page_content_data['ios_version'] = $ios_version;
        $this->page_content = $this->load->view('admin/app_settings/ios_version/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/app_settings/ios_version/index_js',$this->page_content_data,true);

        $this->data['title'] = "iOS Version | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function get_ios_version_info() {
        $ios_version = $this->App_Settings_Model->get_decoded_value_by_name('ios_version');
        $this->output->set_content_type('application/json')->set_output(json_encode(array('ios_version' => $ios_version,)));   
    }

    public function save_ios_version() {
        if (is_user_permitted('admin/settings/ios_version') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $name = 'ios_version';
        $value = $this->App_Settings_Model->data_form_post(array('app_store_url','package_name','ios_app_id','update_url','current_app_version'));

        $is_save = $this->App_Settings_Model->save_by_name($name,json_encode($value,JSON_NUMERIC_CHECK));

        $ios_version = $this->App_Settings_Model->get_decoded_value_by_name('ios_version');

        $message = ($is_save) ? 'Saved successfully' : 'Save failed';
        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'is_save'=>$is_save,
            'ios_version'=>$ios_version,
            'message'=>$message
        ),JSON_NUMERIC_CHECK));  
    }
}