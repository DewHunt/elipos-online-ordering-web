<?php


class Subscribers extends ApiAdmin_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Subscriber_Model');
    }

    public function index(){
        $subscribers= $this->Subscriber_Model->get();
        $this->setResponseJsonOutput(array(
            'subscribers'=>$subscribers,
        ),ApiAdmin_Controller::HTTP_OK);
    }

    public function save(){
        if($this->checkMethod('POST')){
            $this->load->library('form_validation');
            $id = trim($this->input->post('id'));
            $email= trim($this->input->post('email'));


            $this->form_validation->set_rules('email', 'Email', 'required');

            $responseData=array(
                'isSave'=>false,
                'responseMessage'=>'',
            );
            $form_data['email']=$email;
            if ($this->form_validation->run()) {
                if(!empty($id)&& $id>0){
                    // check and Update
                   $another_email=$this->Subscriber_Model->get_by(array('email'=>$email,'id!='=>$id),true);
                    if (empty($another_email)) {

                        $form_data['id']=$id;
                        $this->Subscriber_Model->where_column = 'id';
                        $isSave= $this->Subscriber_Model->save($form_data,$id);
                        $responseData['isSave']=$isSave;
                        $responseData['responseMessage']='Subscription is updated successfully';
                    } else {
                        $responseData['responseMessage']='This Email is already  subscribed.';
                    }
                }else{
                    $existEmail=$this->Subscriber_Model->get_by(array('email'=>$email,'id!='=>$id),true);
                    if (empty($existEmail)) {
                        $isSave= $this->Subscriber_Model->save($form_data);
                        $responseData['isSave']=$isSave;
                        $responseData['responseMessage']='Subscription successfully';
                    } else {
                        $responseData['responseMessage']='This Email is already subscribed';
                    }
                }

            } else {

                $responseData['responseMessage']=validation_errors();
            }
            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }



    }

    public function delete($id=0){
        if($this->checkMethod('POST')){
            $isDeleted=$this->Subscriber_Model->delete(intval($id));
            $responseMessage=($isDeleted)?'Subscription is deleted successfully':'Subscription is not deleted';
            $responseData=array(
                'isDeleted'=>$isDeleted,
                'responseMessage'=>$responseMessage,
            );

            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }

    }
}