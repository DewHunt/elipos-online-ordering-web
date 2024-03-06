<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Feedback_model');
        $this->load->helper('shop');
    }

    public function index() {
        if (is_user_permitted('admin/feedback') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->data['title'] = "Feedback Lists";
        $this->data['feedback_lists'] = $this->Feedback_model->get_all_feedbacks();
        $this->data['reviews_reports'] = $this->get_ratings_details();

        $this->page_content = $this->load->view('admin/feedback/index',$this->data,true);
        $this->custom_js = $this->load->view('admin/feedback/index_js','',true);

        $this->data['title'] = "Feedback | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    function get_ratings_details() {
        $totalRatings = $this->Feedback_model->get_ratings_total();
        $fiveStar = $this->Feedback_model->get_ratings_wise_total(5);
        $fourStar = $this->Feedback_model->get_ratings_wise_total(4);
        $threeStar = $this->Feedback_model->get_ratings_wise_total(3);
        $twoStar = $this->Feedback_model->get_ratings_wise_total(2);
        $oneStar = $this->Feedback_model->get_ratings_wise_total(1);

        $fiveStarAvg = 0;
        $fourStarAvg = 0;
        $threeStarAvg = 0;
        $twoStarAvg = 0;
        $oneStarAvg = 0;
        if ($totalRatings > 0) {
            $fiveStarAvg = number_format(($fiveStar/$totalRatings)*100, 2, '.', '');
            $fourStarAvg = number_format(($fourStar/$totalRatings)*100, 2, '.', '');
            $threeStarAvg = number_format(($threeStar/$totalRatings)*100, 2, '.', '');
            $twoStarAvg = number_format(($twoStar/$totalRatings)*100, 2, '.', '');
            $oneStarAvg = number_format(($oneStar/$totalRatings)*100, 2, '.', '');
        }
        $averageRatings = $this->Feedback_model->get_average_ratings();

        return [$totalRatings,$fiveStarAvg,$fourStarAvg,$threeStarAvg,$twoStarAvg,$oneStarAvg,$averageRatings];
    }

    public function view() {
        if (is_user_permitted('admin/feedback') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('id');
        $this->data['feedback'] = $this->Feedback_model->get_feedback_by_id($id);
        $content = $this->load->view('admin/feedback/view',$this->data,true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('content' => $content)));
    }

    public function change_status(){
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if ($status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $data['is_approved'] = $status;

        $this->db->where('id',$id);
        $this->db->update('feedbacks', $data);
        $msg = 'Status Changed Successfully';

        $menu_lists = $this->Feedback_model->get_all_feedbacks();
        $feedback = $this->Feedback_model->get_feedback_by_id($id);

        $this->data['feedback_lists'] = $menu_lists;
        $list_table = $this->load->view('admin/feedback/list_table',$this->data,true);

        $this->data['feedback'] = $feedback;
        $content = $this->load->view('admin/feedback/view',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('msg'=>$msg,'list_table'=>$list_table,'content' => $content)));
    }

    public function delete(){
        $id = $this->input->post('id');
        $this->db->delete('feedbacks', array('id' => $id));
        $msg = 'Feedback Deleted Successfully';

        $feedback_lists = $this->Feedback_model->get_all_feedbacks();
        $this->data['feedback_lists'] = $feedback_lists;
        $list_table = $this->load->view('admin/feedback/list_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('msg'=>$msg,'list_table'=>$list_table)));
    }
}
