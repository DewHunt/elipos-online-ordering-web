<?php

class Page_Management extends Admin_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Page_Settings_Model');
        $this->load->model('Page_design_model');
        $this->load->helper('directory');
        $this->load->helper("url");
        $this->load->helper("file");
    }

    public function index() {
        if (is_user_permitted('admin/page_management') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "All Pages";
        $this->page_content_data['pages'] = $this->Page_Settings_Model->get();
        $this->page_content = $this->load->view('admin/page_settings/index',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/menu/buy_and_get/index_js',$this->page_content_data,true);

        $this->data['title'] = "Page Management | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_page($id = 0) {
        if (is_user_permitted('admin/page_management') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Edit Page";
        $this->page_content_data['page_details'] = $this->Page_Settings_Model->get($id);
        $this->page_content = $this->load->view('admin/page_settings/edit_form',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/page_settings/edit_form_js',$this->page_content_data,true);

        $this->data['title'] = "Page Management | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function update_page_settings() {
        if (is_user_permitted('admin/page_management') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $form_data = $this->Page_Settings_Model->data_form_post(
            array('title', 'content', 'id', 'is_show')
        );
        $is_save = false;
        $id = $form_data['id'];
        $image_path = $this->upload_image();
        if (!empty($id)) {
            if (!empty($image_path)) {
                $form_data['image'] = $image_path;
            }
            $is_save = $this->Page_Settings_Model->save($form_data, $id);
        }
        if ($is_save) {
            set_flash_save_message('Page details is updated successfully');
            redirect($this->admin . '/page_management');
        } else {
            set_flash_save_message('Page details is not updated');
            redirect($this->admin . '/page_management/edit_page' . $id);
        }
    }

    public function home() {
        if (is_user_permitted('admin/page_management/home') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Home Pages";
        $this->page_content_data['pages'] = $this->Page_Settings_Model->get();
        $this->page_content = $this->load->view('admin/page_settings/home/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/page_settings/home/index_js',$this->page_content_data,true);

        $this->data['title'] = "Home Page | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function menu_review() {
        if (is_user_permitted('admin/page_management/menu_review') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Menu Review Tab";
        $this->page_content_data['menu_review'] = $this->Settings_Model->get_by(array("name" => 'menu_review'), true);
        $this->page_content = $this->load->view('admin/page_settings/menu/review',$this->page_content_data,true);

        $this->data['title'] = "Menu Review Tab";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function menu_review_save() {
        if (is_user_permitted('admin/page_management/menu_review') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('id');
        $data = $this->Settings_Model->data_form_post(array('id', 'name'));
        $value = $this->Settings_Model->data_form_post(array('trip_advisor'));
        $json_value = json_encode($value);
        $data['value'] = $json_value;;
        if (empty($id)) {
            $this->Settings_Model->save($data);
            $this->session->set_flashdata('save_message', 'Information has been Saved successfully');
        } else {
            $this->Settings_Model->where_column = 'id';
            $this->Settings_Model->save($data, $id);
            $this->session->set_flashdata('save_message', 'Information has been Updated successfully');
        }
        redirect($this->admin . '/page_management/menu_review');
    }

    public function upload_banner_images() {
        if (is_user_permitted('admin/page_management') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $path = 'assets/images/home_slider/';
        $config = array(
            'upload_path' => $path,
            'allowed_types' => 'jpg|gif|png',
            'overwrite' => 1,
        );
        $fi = new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS);
        $this->load->library('upload', $config);
        $images = array();
        $files = $_FILES['banner_images'];

        $i = iterator_count($fi);
        foreach ($files['name'] as $key => $image) {
            $_FILES['banner_images[]']['name'] = $files['name'][$key];;
            $_FILES['banner_images[]']['type'] = $files['type'][$key];
            $_FILES['banner_images[]']['tmp_name'] = $files['tmp_name'][$key];
            $_FILES['banner_images[]']['error'] = $files['error'][$key];
            $_FILES['banner_images[]']['size'] = $files['size'][$key];
            $this->upload->initialize($config);

            $config['file_name'] = $i++;

            if ($this->upload->do_upload('banner_images[]')) {
                $this->upload->data();
            } else {
                return false;
            }
        }
        redirect('admin/page_management/home');
    }

    public function welcome_image_save() {
        if (is_user_permitted('admin/page_management/home') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $path = './assets/images/home-welcome/';
        $config = array(
            'upload_path' => $path,
            'allowed_types' => 'jpg|jpeg',
            'overwrite' => 1,
        );

        $this->load->library('upload', $config);
        $first_image = $_FILES[1]['name'];
        if (!empty($first_image)) {
            clearstatcache();
            $file_path = $path . '1.jpg';
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $config['file_name'] = '1';
            $this->upload->initialize($config);
            $this->upload->do_upload('1');
        }

        $second_image = $_FILES[2]['name'];
        if (!empty($second_image)) {
            clearstatcache();
            $file_path = $path . '2.jpg';
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $config['file_name'] = '2';
            $this->upload->initialize($config);
            $this->upload->do_upload('2');
        }

        $third_image = $_FILES[3]['name'];
        if (!empty($third_image)) {
            clearstatcache();
            $file_path = $path . '3.jpg';
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $config['file_name'] = '3';
            $this->upload->initialize($config);
            $this->upload->do_upload('3');
        }

        $fourth_image = $_FILES[4]['name'];
        if (!empty($fourth_image)) {
            clearstatcache();
            $file_path = $path . '4.jpg';
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $config['file_name'] = '4';
            $this->upload->initialize($config);
            $this->upload->do_upload('4');
        }

        $fifth_image = $_FILES[5]['name'];
        if (!empty($fifth_image)) {
            clearstatcache();
            $file_path = $path . '5.jpg';
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $config['file_name'] = '5';
            $this->upload->initialize($config);
            $this->upload->do_upload('5');
        }
        redirect('admin/page_management/home');
    }

    public function upload_app_image() {
        if (is_user_permitted('admin/page_management') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $path = 'assets/images/';
        $config = array(
            'upload_path' => $path,
            'allowed_types' => 'jpg|jpeg',
            'overwrite' => 1,
        );
        $this->load->library('upload', $config);
        $apps_image = $_FILES['apps']['name'];

        if (!empty($apps_image)) {
            clearstatcache();
            $file_path = $path . 'apps.jpg';
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $config['file_name'] = 'apps';
            $this->upload->initialize($config);
            $this->upload->do_upload('apps');
        }
        redirect('admin/page_management/home');
    }

    private function upload_image() {
        $path = '';
        if ($this->User_Model->loggedin()) {
            if(isset($_FILES["file"])){
                $new_name = $_FILES["file"]['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = './assets/uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                $is_upload = $this->upload->do_upload('file');
                $d = array('upload_data' => $this->upload->data());
                if ($is_upload) {
                    $path = '/assets/uploads/' . $d['upload_data']['file_name'];
                }
                return $path;
            } else {
                return $path;
            }
        } else {
            return $path;
        }
    }

    public function delete_file() {
        if (is_user_permitted('admin/page_management') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $is_logout = true;
            $is_deleted = false;
            if ($this->User_Model->loggedin() == true) {
                $is_logout = false;
                clearstatcache();
                $file_path = $this->input->post('path');
                $is_file_exist = file_exists($file_path);
                if (file_exists($file_path)) {
                    $is_deleted = unlink($file_path);
                }
            }
            $response_data = array('is_logout' => $is_logout, 'is_deleted' => $is_deleted, 'file_path' => $file_path, 'is_file_exist' => $is_file_exist);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function page_design() {
        if (is_user_permitted('admin/page_management') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Page Design";
        $this->page_content_data['all_design'] = $this->Page_design_model->get_all();
        $this->page_content = $this->load->view('admin/page_settings/page_design/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/page_settings/page_design/index_js',$this->page_content_data,true);

        $this->data['title'] = "Menu Design";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add_page_design() {
        if (is_user_permitted('admin/page_management') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Edit Page Design";
        $this->page_content_data['page_design'] = '';
        $this->page_content = $this->load->view('admin/page_settings/page_design/add_edit',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/page_settings/page_design/add_edit_js',$this->page_content_data,true);

        $this->data['title'] = "Menu Design";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_page_design($id) {
        if (is_user_permitted('admin/page_management') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Edit Page Design | Write CSS for Modify Design";
        $this->page_content_data['page_design'] = $this->Page_design_model->get_by_id($id);
        $this->page_content = $this->load->view('admin/page_settings/page_design/add_edit',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/page_settings/page_design/add_edit_js',$this->page_content_data,true);

        $this->data['title'] = "Menu Design";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save_menu_design() {
        if (is_user_permitted('admin/page_management') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $data = $this->Page_design_model->data_form_post(array('id','name','file_location','value'));
        $id = $data['id'];
        $data['file_location'] = 'assets/theme/css/';

        $plain_text = $data['value'];
        $plain_text = strip_tags($plain_text);
        $plain_text = str_replace(PHP_EOL,'',$plain_text);

        // create folder if not exists
        if (file_exists($data['file_location']) == false) {
            mkdir($data['file_location'], 0777, true);
        }

        // make file name on the basis of forward slash exists at the last of the string
        $file_name = "{$data['file_location']}{$data['name']}.css";
        if (substr($data['file_location'],-1) != '/') {
            $file_name = "{$data['file_location']}/{$data['name']}.css";
        }

        // Save our content to the file.
        file_put_contents($file_name, $plain_text); 
        // dd($data);
        if (empty($id)) {
            $this->Page_design_model->save($data);
            $this->session->set_flashdata('save_message', 'Information has been Saved successfully');
        } else {
            $this->Page_design_model->where_column = 'id';
            $this->Page_design_model->save($data, $id);
            $this->session->set_flashdata('save_message', 'Information has been Updated successfully');
        }
        redirect($this->admin . '/page_management/page_design');
    }

    public function view_page_design() {
        $id = $this->input->post('id');
        $page_design = $this->Page_design_model->get_by_id($id);
        $this->data['page_design'] = $page_design;
        $this->output->set_content_type('application/json')->set_output(json_encode(array('page_design'=>$page_design)));
    }

    public function delete_page_design() {
        $id = $this->input->post('id');
        $this->db->delete('page_design', array('id' => $id));
        $msg = 'Information Deleted Successfully';

        $this->data['all_design'] = $this->Page_design_model->get_all();
        $list = $this->load->view('admin/page_settings/page_design/list',$this->data,true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('list'=>$list,'msg'=>$msg)));
    }
}
