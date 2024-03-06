<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_manager extends Admin_Controller {
	public function __construct() {
        parent:: __construct();
        $this->load->helper("url");
        $this->load->model('User_Model');

        if (!$this->User_Model->loggedin()) {
            redirect('admin');
        }
	}

	public function set_images_directory_in_session() {
		$directory = $this->input->post('directory');
        $this->session->set_userdata('image_manager_directory',$directory);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('directory' => $directory)));
	}

    public function images_upload() {
        // dd($this->input->post());
        $is_upload = true;
        $directory = $this->session->userdata('image_manager_directory');

        multiple_image_upload('images',$directory);
        $output = $this->set_images_in_modal(false);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('is_upload' => $is_upload,'output'=>$output)));
    }

    public function set_images_in_modal($is_ajax_call = true) {
    	$directory = $this->session->userdata('image_manager_directory');
        // dd($directory);
    	$this->data['images'] = array();
    	if ($directory && file_exists($directory)) {
	        $directory = $directory."*.*";
	        $this->data['images'] = glob($directory,GLOB_BRACE);
    	}
    	$output = $this->load->view('admin/image_manager/image_manager_modal', $this->data, true);

        if ($is_ajax_call) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('output' => $output,)));
        } else {
            return $output;
        }
    }

    public function delete_images() {
        // dd($this->input->post());
        $is_delete = true;
        $directory = $this->input->post('image_path');

        if ($directory) {
            unlink($directory);
        }
        $output = $this->set_images_in_modal(false);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('is_delete' => $is_delete,'output'=>$output)));
    }
}
?>