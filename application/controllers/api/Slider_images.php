<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider_images extends Api_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->helper('directory');
    }

    public function all_images() {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $slider_images_path = './assets/images/mobile_apps/sliders/';
            $slider_images = directory_map($slider_images_path, 1);
            $path = base_url().'assets/images/mobile_apps/sliders/';
            foreach ($slider_images as $key => $image) {
                $slider_images[$key] = $path.$image;
            }
            $response_data = array('status' => 200,'images'=>$slider_images);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }
}