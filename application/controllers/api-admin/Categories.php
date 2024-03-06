<?php
/**
 * Created by IntelliJ IDEA.
 * User: Asus
 * Date: 09-Sep-19
 * Time: 5:20 PM
 */

class Categories extends ApiAdmin_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('Category_Model');
        $this->load->model('Foodtype_Model');
        $this->load->model('Parentcategory_Model');

        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index(){
        $parentCategoryList = $this->Parentcategory_Model->get();
        $foodTypeList = $this->Foodtype_Model->get();
        $categories=$this->Category_Model->getAllCategories();
        $this->setResponseJsonOutput(array(
            'categories'=>$categories,
            'foodTypeList'=>$foodTypeList,
            'categoryTypes'=>array(
                array(
                    'id'=>0,
                    'name'=>'Food'
                ),
                  array(
                      'id'=>1,
                      'name'=>'No Food'
                  )

            ),
            'parentCategoryList'=>$parentCategoryList,
        ),ApiAdmin_Controller::HTTP_OK);
    }

    public function get($id=0){
        $category=$this->Category_Model->get(intval($id));
        $this->setResponseJsonOutput(array('category'=>$category),ApiAdmin_Controller::HTTP_OK);
    }

    public function save(){
        if($this->checkMethod('POST')){
            $this->load->library('form_validation');
            $categoryId = trim($this->input->post('categoryId'));
            $parent_category_id = trim($this->input->post('parentCategoryId'));
            $food_type_id = trim($this->input->post('foodTypeId'));
            $category_type_id = trim($this->input->post('categoryTypeId'));
            $category_name = trim($this->input->post('categoryName'));
            $isOffersOrDeals= trim($this->input->post('isDeals'));
            
            $isPackage= trim($this->input->post('isPackage'));
            $sort_order = trim($this->input->post('SortOrder'));
            $orderType= trim($this->input->post('order_type'));

            $form_data = array(
                'parentCategoryId' => $parent_category_id,
                'foodTypeId' => $food_type_id,
                'categoryTypeId' => $category_type_id,
                'categoryName' => $category_name,
                'isDeals' => $isOffersOrDeals,
                'isPackage' => $isPackage,
                'order_type' => (!empty($orderType))?$orderType:'both',
                'tableView' => 1,
                'takeawayView' => 1,
                'barView' => 1,
                'backgroundColor' => '#408080',
                'ButtonHight' => 53,
                'ButtonWidth' => 128,
                'SortOrder' => $sort_order,
                'KitchenSectionId' => 11,
                'FontSetting' => 'Arial,Bold,12',
                'Forecolor' => '#FFFFFF',
                'PrintingSortOrder' => 2,
            );

            $this->form_validation->set_rules('parentCategoryId', 'Parent Category', 'required');
            $this->form_validation->set_rules('foodTypeId', 'Food Type', 'required');
            $this->form_validation->set_rules('categoryTypeId', 'Category Type', 'required');
            $this->form_validation->set_rules('categoryName', 'Category ', 'required');
            $this->form_validation->set_rules('SortOrder', 'Sort Order ', 'required');
            $responseData=array(
                'isSave'=>false,
                'responseMessage'=>'',
            );

            if ($this->form_validation->run()) {
                if(!empty($categoryId)&& $categoryId>0){
                    // check and Update
                    $category_name_exist_another = $this->Category_Model->is_category_name_exist_for_update($categoryId,$category_name);
                    if (empty($category_name_exist_another)) {
                        $form_data['categoryId']=$categoryId;
                        $this->Category_Model->where_column = 'categoryId';
                        $isSave= $this->Category_Model->save($form_data,$categoryId);
                        $responseData['isSave']=$isSave;
                        $responseData['responseMessage']='Category  is updated successfully';
                    } else {
                        $responseData['responseMessage']='Category Name already exists.';
                    }
                }else{
                    $category_name_exist = $this->Category_Model->is_category_name_exist($category_name);
                    if (!$category_name_exist) {
                        $isSave= $this->Category_Model->save($form_data);
                        $responseData['isSave']=$isSave;
                        $responseData['responseMessage']='Category  is saved successfully';
                    } else {
                        $responseData['responseMessage']='Category Name already exists';
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

            $isDeleted=$this->Category_Model->delete(intval($id));
            $responseMessage=($isDeleted)?'Category is deleted successfully':'Category is not deleted';
            $categories=$this->Category_Model->getAllCategories();
            $responseData=array(
                'isDeleted'=>$isDeleted,
                'responseMessage'=>$responseMessage,
                'categories'=>$categories,
            );

            $this->setResponseJsonOutput($responseData,ApiAdmin_Controller::HTTP_OK);
        }

    }





}