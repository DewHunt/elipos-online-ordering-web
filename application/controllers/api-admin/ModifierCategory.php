<?php

class ModifierCategory extends ApiAdmin_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('Modifier_Category_Model');

    }

    public function index(){
        if($this->checkMethod('GET')){
            $modifier_categories=$this->Modifier_Category_Model->get_all();
            $this->setResponseJsonOutput(array(
                'modifierCategories'=>$modifier_categories,
            ),ApiAdmin_Controller::HTTP_OK);
        }

    }


    public function save(){
        if($this->checkMethod('POST')){
            $this->load->library('form_validation');
            $m_modifier_category=new Modifier_Category_Model();
            $ModifierCategoryId=intval($this->input->post('ModifierCategoryId'));
            if($ModifierCategoryId>0){
                $this->form_validation->set_rules($m_modifier_category->edit_rules);
            }else{
                $this->form_validation->set_rules($m_modifier_category->add_rules);
            }
            $data=$m_modifier_category->data_form_post(array('ModifierCategoryName','ModifierLimit','SortOrder'));
            $this->session->set_flashdata('form_data',$data);
            $responseData=array(
                'isSave'=>false,
                'responseMessage'=>'',
            );
            if ($this->form_validation->run()) {
                if($ModifierCategoryId>0){
                    $modifier_category=$m_modifier_category->get_by(
                        array(
                            'ModifierCategoryId!='=>$ModifierCategoryId,
                            'ModifierCategoryName'=>$data['ModifierCategoryName']
                        ), true
                    );
                    $is_save=false;
                    if(empty($modifier_category)){
                        $data['ModifierCategoryId']=$ModifierCategoryId;
                        $is_save = $m_modifier_category->save($data,$ModifierCategoryId);
                        $responseData['isSave']=$is_save;
                        $responseData['responseMessage']=($is_save)?'Modifier Category is Updated successfully':'Modifier Category is  not updated';
                    }else{
                        $responseData['isSave']=$is_save;
                        $responseData['responseMessage']='Modifier Category is already exist';
                    }
                }else{
                    $is_save = $m_modifier_category->save($data,$ModifierCategoryId);
                    $responseData['isSave']=$is_save;
                    $responseData['responseMessage']=($is_save)?'Modifier Category is save successfully':'Modifier Category is not save ';
                }
            }else{
                $responseData['responseMessage']=validation_errors();
            }

            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
            }
    }

    public function delete($id=0){
        if($this->checkMethod('POST')){
            $isDeleted=$this->Modifier_Category_Model->delete(intval($id));
            $responseMessage=($isDeleted)?'Category is deleted successfully':'Category is not deleted';
            $modifier_categories=$this->Modifier_Category_Model->get_all();
            $responseData=array(
                'isDeleted'=>$isDeleted,
                'responseMessage'=>$responseMessage,
                'modifierCategories'=>$modifier_categories,
            );
            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }

    }



}