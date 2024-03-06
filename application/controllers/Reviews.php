<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews extends Frontend_Controller {

    public $product;
    public function __construct() {
        parent:: __construct();
        $this->load->model('Customer_Model');
        $this->load->model('Feedback_model');
    }

    public function index() {
        $this->data['title'] = "Reviews";
        $this->data['all_feedbacks'] = $this->Feedback_model->get_all_approved_feedbacks();
        $this->data['reviews_reports'] = $this->get_ratings_details();
        // dd($this->data);
        $this->page_content = $this->load->view('reviews/reviews', $this->data, true);
        $this->footer = $this->load->view('footer', $this->data, true);
        $this->load->view('index', $this->data);
    }

    function get_ratings_details() {
        $totalRatings = $this->Feedback_model->get_ratings_total();
        $fiveStar = $this->Feedback_model->get_ratings_wise_total(5);
        $fourStar = $this->Feedback_model->get_ratings_wise_total(4);
        $threeStar = $this->Feedback_model->get_ratings_wise_total(3);
        $twoStar = $this->Feedback_model->get_ratings_wise_total(2);
        $oneStar = $this->Feedback_model->get_ratings_wise_total(1);

        $fiveStarAvg = number_format(($fiveStar/$totalRatings)*100, 2, '.', '');
        $fourStarAvg = number_format(($fourStar/$totalRatings)*100, 2, '.', '');
        $threeStarAvg = number_format(($threeStar/$totalRatings)*100, 2, '.', '');
        $twoStarAvg = number_format(($twoStar/$totalRatings)*100, 2, '.', '');
        $oneStarAvg = number_format(($oneStar/$totalRatings)*100, 2, '.', '');
        $averageRatings = $this->Feedback_model->get_average_ratings();

        return [$totalRatings,$fiveStarAvg,$fourStarAvg,$threeStarAvg,$twoStarAvg,$oneStarAvg,$averageRatings];
    }

    function get_sorted_feedbacks() {
        $sortBy = $this->input->post('sortBy');

        if ($sortBy == 'newest') {
            $all_feedbacks = $this->Feedback_model->get_all_approved_feedbacks();
        } else if ($sortBy == 'highest') {
            $all_feedbacks = $this->Feedback_model->get_all_highest_to_lowest_feedbacks();
        } else {
            $all_feedbacks = $this->Feedback_model->get_all_lowest_to_highest_feedbacks();
        }

        $this->data['all_feedbacks'] = $all_feedbacks;
        $output = $this->load->view('reviews/reviews_lists',$this->data,true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('output'=>$output)));
    }

    public function save() {
        // dd($this->input->post());
        $rating_taste = $this->input->post('foodStar');
        $rating_service = $this->input->post('serviceStar');
        $rating_price = $this->input->post('atmosphereStar');
        $choosed_order_types = $this->input->post('choosedOrderTypes');
        $ratings = ($rating_taste + $rating_service + $rating_price) / 3;
        $ratings = number_format($ratings, 1, '.', '');

        $save_data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'message' => $this->input->post('message'),
            'rating_taste' => $rating_taste,
            'rating_service' => $rating_service,
            'rating_price' => $rating_price,
            'ratings' => $ratings,
            'choosed_order_types' => $this->input->post('choosedOrderTypes'),
            'is_approved' => $ratings >= 4 ? 1 : 0,
            'created_at' => get_current_date_time()
        );

        $isSaved = $this->Feedback_model->save($save_data);
        $output = '';
        if ($isSaved) {
            $this->data['all_feedbacks'] = $this->Feedback_model->get_all_approved_feedbacks();
            $this->data['reviews_reports'] = $this->get_ratings_details();
            $reviews_report = $this->load->view('reviews/reviews_report',$this->data,true);
            $reviews_lists = $this->load->view('reviews/reviews_lists',$this->data,true);
        }

        $message = ($isSaved) ? 'Thanks for giving your feedback' : 'Sorry your feedback not saved.';
        $this->output->set_content_type('application/json')->set_output(json_encode(array('isSaved'=>$isSaved,'message'=>$message,'reviews_lists'=>$reviews_lists,'reviews_report'=>$reviews_report)));
    }
}
