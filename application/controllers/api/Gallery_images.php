<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_images extends Api_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->helper('directory');
    }

    public function index() {
        $gallery_path = './assets/images/gallery/';
        $gallery_images = directory_map($gallery_path, 1);
        $path = base_url().'assets/images/gallery/';
        $this->output->set_content_type('application/json')->set_output(json_encode(array('path'=>$path,'images'=>$gallery_images)));
    }

    public function slider_images() {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $slider_images_path = './assets/images/mobile_apps/sliders/';
            $slider_images = directory_map($slider_images_path, 1);
            $path = base_url().'assets/images/mobile_apps/sliders/';
            if ($slider_images) {
                foreach ($slider_images as $key => $image) {
                    $slider_images[$key] = $path.$image;
                }
            }
            $response_data = array('status' => 200,'images'=>$slider_images);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function notification_images() {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $notification_images_path = './assets/images/mobile_apps/notifications/';
            $notification_images = directory_map($notification_images_path, 1);
            $path = base_url().'assets/images/mobile_apps/notifications/';
            if ($notification_images) {
                foreach ($notification_images as $key => $image) {
                    $notification_images[$key] = $path.$image;
                }
            }
            $response_data = array('status' => 200,'images'=>$notification_images);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function background_image() {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $top_images_path = './assets/images/mobile_apps/background/';
            $all_images = directory_map($top_images_path, 1);
            $path = base_url().'assets/images/mobile_apps/background/';
            $background_image = $all_images ? $path.$all_images[0] : '';
            $response_data = array('status' => 200,'image'=>$background_image);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function top_image() {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $top_images_path = './assets/images/mobile_apps/top-image/';
            $all_images = directory_map($top_images_path, 1);
            $path = base_url().'assets/images/mobile_apps/top-image/';
            $top_image = $all_images ? $path.$all_images[0] : '';
            if ($all_images) {
                foreach ($all_images as $key => $image) {
                    $all_images[$key] = $path.$image;
                }
            }
            $response_data = array('status' => 200,'images'=>$all_images,'image'=>$top_image);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function logo_image() {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $logo_images_path = './assets/images/mobile_apps/logo/';
            $all_images = directory_map($logo_images_path, 1);
            $path = base_url().'assets/images/mobile_apps/logo/';
            $logo_image = $all_images ? $path.$all_images[0] : '';
            if ($all_images) {
                foreach ($all_images as $key => $image) {
                    $all_images[$key] = $path.$image;
                }
            }
            $response_data = array('status' => 200,'images'=>$all_images,'image'=>$logo_image);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }
}