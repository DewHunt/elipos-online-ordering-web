<?php

class Gallery_management extends Admin_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('directory');
        $this->load->helper("url");
        $this->load->helper("file");
    }

    public function index() {
        if (is_user_permitted('admin/gallery_management') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = "Gallery Management";
        // $this->page_content_data['page_content'] = $this->load->view('admin/gallery/index', $this->data, true);
        $this->page_content = $this->load->view('admin/gallery/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/gallery/index_js',$this->page_content_data,true);

        $this->data['title'] = "Gallery Management | Index";
        $this->load->view('admin/master/master_index',$this->data);

        // $this->load->view('admin/admin_template', $this->data);
    }

    public function delete_file() {
        if (is_user_permitted('admin/gallery_management') == false) {
            redirect(base_url('admin/dashboard'));
        }
        dd($this->input->post());
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

    public function delete_all_gallery_images() {
        if (is_user_permitted('admin/gallery_management') == false) {
            redirect(base_url('admin/dashboard'));
        }
        delete_files('./assets/images/gallery/', TRUE);
        redirect('admin/gallery_management');
    }

    public function upload_images() {
        if (is_user_permitted('admin/gallery_management') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($_FILES['gallery_images']);
        $directory = 'assets/images/gallery/';
        $image_paths = multiple_image_upload('gallery_images',$directory);
        redirect('admin/gallery_management');
    }
}
