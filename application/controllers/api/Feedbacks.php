<?php
class Feedbacks extends Api_Controller
{
    public function __construct() {
        parent:: __construct();
        $this->load->model('Feedback_model');
    }

    public function get_all_approved_feedbacks() {
        $feedbacks = $this->Feedback_model->get_all_approved_feedbacks();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('feedbacks' => $feedbacks)));
    }

    public function save() {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $name = get_property_value('name', $data);
        $email = get_property_value('email', $data);
        $message = get_property_value('message', $data);
        $rating_taste = get_property_value('rateTaste', $data);
        $rating_service = get_property_value('rateService', $data);
        $rating_price = get_property_value('ratePrice', $data);
        $choosed_order_types = get_property_value('choosedOrderTypes', $data);
        $ratings = ($rating_taste + $rating_service + $rating_price) / 3;
        $ratings = number_format($ratings, 1, '.', '');
        $name = $this->security->xss_clean($name);
        $message = $this->security->xss_clean($message);
        $email = $this->security->xss_clean($email);

        $save_data = array(
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'rating_taste' => $rating_taste,
            'rating_service' => $rating_service,
            'rating_price' => $rating_price,
            'ratings' => $ratings,
            'choosed_order_types' => $choosed_order_types,
            'is_approved' => $ratings >= 4 ? 1 : 0,
            'created_at' => get_current_date_time()
        );

        $isSave = $this->Feedback_model->save($save_data);

        $message = ($isSave) ? 'Thanks for giving your feedback' : 'Sorry your feedback not saved.';
        $this->output->set_content_type('application/json')->set_output(json_encode(array('isSave' => $isSave, 'message' => $message)));
    }
}