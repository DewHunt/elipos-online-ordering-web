<?php

class Modifier extends ApiAdmin_Controller
{
public $units = array(
['id' => 'Pics'],
['id' => 'Kg'],
['id' => 'Litre'],
['id' => 'Dozzon']
);
    public function __construct() {
        parent::__construct();
        $this->load->model('Sidedishes_Model');

    }

    public function index(){
        if($this->checkMethod('GET')){
            $this->load->model('Modifier_Category_Model');
            $modifier_categories=$this->Modifier_Category_Model->get_all();
            $modifiers=$this->Sidedishes_Model->get_modifier_category();

            $this->setResponseJsonOutput(array(
                'modifiers'=>$modifiers,
                'modifierCategories'=>$modifier_categories,
                'units'=>$this->units,
            ),ApiAdmin_Controller::HTTP_OK);
        }

    }


  public function save(){
        if($this->checkMethod('POST')){
            $this->load->library('form_validation');

            $sideDishesId=intval($this->input->post('SideDishesId'));


            $this->form_validation->set_rules('SideDishesName', 'Modifier Name', 'required');
            $this->form_validation->set_rules('ModifierCategoryId', 'Modifier Category ', 'required');
            $this->form_validation->set_rules('UnitPrice', 'Price', 'required');
            $this->form_validation->set_rules('Unit', 'Unit', 'required');
            $this->form_validation->set_rules('VatRate', 'Vat Rate', 'required');
            $this->form_validation->set_rules('SortOrder', 'Sort Order', 'required');

            $form_data=$this->Sidedishes_Model->data_form_post(array('SideDishesName','ModifierCategoryId','UnitPrice','Unit','VatRate','SortOrder'));
            $form_data['OptionsColor']='#FF0000';
            $form_data['ButtonHight']='100';
            $form_data['ButtonWidth']='100';
            $form_data['FontSetting']='Arial,Bold,12';
            $form_data['Forecolor']='#008000';

            $responseData=array(
                'isSave'=>false,
                'responseMessage'=>'',
            );
            $modifier_name= $form_data['SideDishesName'];
            $ModifierCategoryId= $form_data['ModifierCategoryId'];
            if ($this->form_validation->run()) {
                if($sideDishesId>0){
                    $is_exists_modifier_name = $this->Sidedishes_Model->is_exists_modifier_name($modifier_name,$ModifierCategoryId);
                    $is_save=false;
                    if(!$is_exists_modifier_name){
                        $form_data['SideDishesId']=$sideDishesId;
                    $this->Sidedishes_Model->where_column='SideDishesId';
                        $is_save = $this->Sidedishes_Model->save($form_data,$sideDishesId);
                        $responseData['isSave']=$is_save;
                        $responseData['responseMessage']=($is_save)?'Modifier  is Updated successfully':'Modifier  is  not updated';
                    }else{
                        $responseData['isSave']=$is_save;
                        $responseData['responseMessage']='Modifier  is already exist';
                    }
                }else{
                    $is_save = $this->Sidedishes_Model->save($form_data);
                    $responseData['isSave']=$is_save;
                    $responseData['responseMessage']=($is_save)?'Modifier  is save successfully':'Modifier  is not save ';
                }
            }else{
                $responseData['responseMessage']=validation_errors();
            }

            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function delete($id=0){
        if($this->checkMethod('POST')){
            $isDeleted=$this->Sidedishes_Model->delete(intval($id));
            $responseMessage=($isDeleted)?'Modifier is deleted successfully':'Modifier is not deleted';
            $responseData=array(
                'isDeleted'=>$isDeleted,
                'responseMessage'=>$responseMessage,
            );

            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }

    }

    public function getAssignedModifier(){
        if($this->checkMethod('GET')){
            $this->load->model('Showsidedish_Model');
            $category_id = trim($this->input->get('categoryId'));
            $product_id = trim($this->input->get('productId'));
            $sub_product_id = trim($this->input->get('subProductId'));
            $productLevelCategoryId=$this->Showsidedish_Model->get_productLevelCategoryId($category_id,$product_id,$sub_product_id);
            $categoryId=$productLevelCategoryId['categoryId'];
            $level=$productLevelCategoryId['level'];
            $conditions=array(
                'showsidedish.CategoryId'=>$categoryId,
                'showsidedish.productLevel'=>$level
            );
            $assignedModifiers = $this->Showsidedish_Model->get_assigned_modifiers($conditions);
            $responseData=array(
                'assignedModifiers'=>$assignedModifiers,
                'responseMessage'=>'',
            );
            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function assignModifier() {
        if ($this->checkMethod('POST')) {
            $this->load->model('Modifier_Category_Model');
            $this->load->model('Showsidedish_Model');
            $category_id = trim($this->input->post('categoryId'));
            $product_id = trim($this->input->post('productId'));
            $sub_product_id= trim($this->input->post('subProductId'));
            /*
             * 1.if foodItemId and  selectiveItemId is null then it is category wise modifier limit else,
             *  2.if foodItemId is not null and selectiveItemId is null then it is product wise modifier limit else ,
             * 3.if selectiveItemId is not null and foodItemId is null then it is sub product wise modifier limit else
            */
            $modifiersAsLimit= $this->input->post('modifiersAsLimit');
            $m_modifier_category=new Modifier_Category_Model();
            $modifier_categories=$m_modifier_category->get_ids();

            /*
             * CategoryId is CategoryId if ProductLevel=1
             * CategoryId is selectiveItemId if ProductLevel=2
             * CategoryId is selectionItemId if ProductLevel=3
             *
             * */


           // $modifier_categories_ids=(!empty($modifier_categories))?array_column($modifier_categories,'ModifierCategoryId'):array();

            $m_showsidedish_Model=new Showsidedish_Model();
            $productLevelCategoryId=$m_showsidedish_Model->get_productLevelCategoryId($category_id,$product_id,$sub_product_id);

            $categoryId=$productLevelCategoryId['categoryId'];
            $productLevel=$productLevelCategoryId['level'];

            $conditions=array(
                'showsidedish.CategoryId'=>$categoryId,
                'showsidedish.productLevel'=>$productLevel
            );

            $m_showsidedish_Model->delete_assigned_modifier($conditions);


            if (!empty($modifiersAsLimit)) {
                $modifiersAsLimit=json_decode($modifiersAsLimit,true);
                foreach ($modifiersAsLimit as $modifierLimit) {
                    $modifierLimit['ProductLevel']=$productLevel;
                    $this->Showsidedish_Model->save($modifierLimit);
                }
            }
            $this->setResponseJsonOutput(array(
               'responseMessage'=>'Save successfully',
            ));

        }

    }



}