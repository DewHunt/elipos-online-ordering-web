<?php
class SubProductsFile extends ApiAdmin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Fooditem_Model');
        $this->load->model('Sub_product_files_Model');

    }

    public function index()
    {
        $this->load->model('Category_Model');
        $this->load->model('Foodtype_Model');

        $this->load->model('Parentcategory_Model');
        $this->load->model('Product_Size_Model');

        $parentCategoryList = $this->Parentcategory_Model->get();
        $foodTypeList = $this->Foodtype_Model->get();
        $categories = $this->Category_Model->getAllCategories();
        $productSizes = $this->Product_Size_Model->get();
        $this->Sub_product_files_Model->db->distinct('foodItemId');
        $productIds=$this->Sub_product_files_Model->get();
        $productsHasSubProducts=array();
        if(!empty($productIds)){
            $this->Fooditem_Model->db->order_by('SortOrder', 'ASC');
            $this->Fooditem_Model->db->where_in('foodItemId', array_column($productIds,'foodItemId'));
            $productsHasSubProducts=$this->Fooditem_Model->get();
        }
        $this->Fooditem_Model->db->order_by('SortOrder', 'ASC');
        $products=$this->Fooditem_Model->get();
        $units = array(
            ['id' => 'Per Piece'],
            ['id' => 'Per Pound'],
            ['id' => 'Per Kg'],
            ['id' => 'Per Letter']
        );

        $weekDays = array(
            ['id' => 1, 'name' => 'Monday'],
            ['id' => 2, 'name' => 'Tuesday'],
            ['id' => 3, 'name' => 'Wednesday'],
            ['id' => 4, 'name' => 'Thursday'],
            ['id' => 5, 'name' => 'Friday'],
            ['id' => 6, 'name' => 'Saturday'],
            ['id' => 0, 'name' => 'Sunday']
        );
        $this->setResponseJsonOutput(array(
            'categories' => $categories,
            'productsHasSubProducts' => $productsHasSubProducts,
            'foodTypeList' => $foodTypeList,
            'weekDays' => $weekDays,
            'productSizes' => $productSizes,
            'products' => $products,
            'itemUnits' => $units,
            'categoryTypes' => array(
                array(
                    'id' => 0,
                    'name' => 'Food'
                ),
                array(
                    'id' => 1,
                    'name' => 'No Food'
                )

            ),
            'parentCategoryList' => $parentCategoryList,
        ), ApiAdmin_Controller::HTTP_OK);
    }


    public function getAll(){
        if($this->checkMethod('GET')){
            $this->load->model('Category_Model');
            $this->load->model('Selectionitems_Model');
            $categories = $this->Category_Model->getAllCategories();
            $this->Fooditem_Model->db->order_by('SortOrder', 'ASC');
            $products=$this->Fooditem_Model->get();
            $this->Sub_product_files_Model->db->order_by('SortOrder', 'ASC');
            $subProductsFile = $this->Sub_product_files_Model->get();

            $this->Selectionitems_Model->db->select('selectiveItemId,foodItemId,SelectionItemFilesId');
            $assignedSubProductsFile= $this->Selectionitems_Model->get_by(array(
                'SelectionItemFilesId!='=>NULL,
            ));
            $this->setResponseJsonOutput(array(
                'subProductsFile' => $subProductsFile,
                'assignedSubProductsFile' => $assignedSubProductsFile,
                'products' => $products,
                'categories' => $categories,
            ), ApiAdmin_Controller::HTTP_OK);
        }

    }

    public function get()
    {
        if($this->checkMethod('GET')){
            $this->Sub_product_files_Model->db->select('selectiveItemId,foodItemId,
        selectiveItemName,selectiveItemFullName,takeawayPrice,
        tablePrice,barPrice,vatRate,SortOrder,IF(vatIncluded=1,"true","false") as vatIncluded');
            $this->Sub_product_files_Model->db->order_by('SortOrder', 'ASC');
            $subProducts = $this->Sub_product_files_Model->get();
            $this->setResponseJsonOutput(array(
                'subProducts' => $subProducts
            ), ApiAdmin_Controller::HTTP_OK);
        }

    }


    public function save()
    {
        if ($this->checkMethod('POST')) {
            $this->load->library('form_validation');
            $foodItemId= trim($this->input->post('foodItemId'));
            $foodItemId=(!empty($foodItemId))?$foodItemId:0;
            $selectiveItemId = trim($this->input->post('selectiveItemId'));
            $selectiveItemId = (!empty($selectiveItemId)) ? $selectiveItemId : 0;
            $sub_product_name = trim($this->input->post('selectiveItemName'));

            $sub_product_full_name = trim($this->input->post('selectiveItemFullName'));

            $sort_order = trim($this->input->post('SortOrder'));
            $table_price = trim($this->input->post('tablePrice'));
            $takeaway_price = trim($this->input->post('takeawayPrice'));
            $bar_price = trim($this->input->post('barPrice'));
            $vat_rate = trim($this->input->post('vatRate'));
            $vat_included = trim($this->input->post('vatIncluded'));

            $form_data = array(
                //'selectiveItemId' => $id,
                'selectiveItemName' => $sub_product_name,
                'selectiveItemFullName' => (!empty($sub_product_full_name))?$sub_product_full_name:null,
                'foodItemId' => $foodItemId,
                'tablePrice' => !empty($table_price) ? $table_price : 0,
                'takeawayPrice' => !empty($takeaway_price) ? $takeaway_price : 0,
                'barPrice' => !empty($bar_price) ? $bar_price : 0,
                'product4_plu' => '',
                'status' => 1,
                'selectiveItemStockQty' => 0,
                'vatIncluded' => $vat_included,
                'vatRate' => $vat_rate,
                'ButtonHight' => 100,
                'ButtonWidth' => 100,
                'SelectionItemColor' => '#0080FF',
                'SortOrder' => $sort_order,
                'FontSetting' => 'Arial,Bold,12',
                'Forecolor' => '#FFFFFF',
            );


            $this->form_validation->set_rules('selectiveItemName', 'Sub Product Short Name', 'required');
            $this->form_validation->set_rules('SortOrder', 'Sort Order', 'required');
            $this->form_validation->set_rules('tablePrice', 'Table Price', 'required');
            $this->form_validation->set_rules('takeawayPrice', 'Takeaway Price', 'required');
            $this->form_validation->set_rules('barPrice', 'Bar Price', 'required');
            $this->form_validation->set_rules('vatRate', 'Vat Rate', 'required');



            $responseData = array(
                'isSave' => false,
                'responseMessage' => '',
            );
            if ($this->form_validation->run() === FALSE) {
                $responseData['responseMessage'] = validation_errors();
            } else {

                if ($selectiveItemId > 0) {
                    $is_product_name_exist_for_update = $this->Sub_product_files_Model->is_sub_product_item_file_name_exist_for_update($selectiveItemId, $sub_product_name);
                    if (!$is_product_name_exist_for_update) {
                        $this->Sub_product_files_Model->where_column = 'selectiveItemId';
                        $form_data['selectiveItemId'] = $selectiveItemId;
                        $isSave = $this->Sub_product_files_Model->save($form_data, $selectiveItemId);
                        $responseData['isSave'] = $isSave;
                        if ($isSave) {
                            $responseData['responseMessage'] = 'Sub Product File information has been updated successfully';
                        } else {
                            $responseData['responseMessage'] = 'Sub Product File information is not updated successfully';
                        }
                    } else {
                        $responseData['responseMessage'] = 'Sub Product name already exists';
                    }
                } else {
                    /*Save New Product*/

                    $sub_product_name_exist = $this->Sub_product_files_Model->is_sub_product_item_file_name_exist($sub_product_name);

                    if (!$sub_product_name_exist) {
                        $is_inserted = $this->Sub_product_files_Model->save($form_data);
                        $responseData['isSave'] = $is_inserted;
                        if ($is_inserted) {
                            $responseData['responseMessage'] = 'Sub Product file information has been saved successfully';
                        } else {
                            $responseData['responseMessage'] = 'Sub Product file information is not saved successfully';
                        }
                    } else {
                        $responseData['responseMessage'] = 'Sub Product File name already exists';
                    }
                }


            }

            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);


        }
    }

    public function delete($id = 0)
    {
        if ($this->checkMethod('POST')) {
            $isDeleted = $this->Sub_product_files_Model->delete(intval($id));
            $responseMessage = ($isDeleted) ? 'Sub Product is deleted successfully' : 'Sub Product is not deleted';
            $responseData = array(
                'isDeleted' => $isDeleted,
                'responseMessage' => $responseMessage,
            );

            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }

    public function doAssign() {
            if($this->checkMethod('POST')){
                $assign_ids=$this->input->post('assign_ids');
                $delete_ids=$this->input->post('delete_ids');
                $foodItemId=$this->input->post('foodItemId');
                $this->load->model('Selectionitems_Model');
                $m_sub_product=$this->Selectionitems_Model;
                if(!empty($assign_ids)){
                    // Assign And Updated

                    $assign_ids=json_decode($assign_ids,true);
                    $m_sub_product_file=new Sub_product_files_Model();
                    $m_food_item=new Fooditem_Model();

                    foreach($assign_ids as $id){
                        $sub_product_file=$m_sub_product_file->get_by(array('selectiveItemId'=>$id),true);
                        if(!empty($sub_product_file)){
                            $sub_product=$m_sub_product->get_by(array('SelectionItemFilesId'=>$id,'	foodItemId'=>$foodItemId),true);
                            $sub_product_file_array=!empty($sub_product_file)?json_decode(json_encode($sub_product_file),true):null;
                            $food_item=$m_food_item->get($foodItemId);
                            $food_item_name=$food_item->foodItemName;
                            if(empty($sub_product)){

                                if(!empty($sub_product_file_array)){
                                    unset($sub_product_file_array['selectiveItemId']);
                                    $sub_product_file_array['selectiveItemName']=$sub_product_file->selectiveItemName.' '.$food_item_name;
                                    $sub_product_file_array['SelectionItemFilesId']=$id;
                                    $sub_product_file_array['foodItemId']=$foodItemId;
                                    $m_sub_product->save($sub_product_file_array);
                                    ;
                                }
                            }else{
                                // Updated
                                if(!empty($sub_product_file_array)){
                                    $updated_data=array();
                                    $updated_data['selectiveItemName']=$sub_product_file->selectiveItemName.' '.$food_item_name;
                                    $updated_data['tablePrice']=$sub_product_file->tablePrice;
                                    $updated_data['takeawayPrice']=$sub_product_file->takeawayPrice;
                                    $updated_data['barPrice']=$sub_product_file->barPrice;
                                    $SelectionItemFilesId= $sub_product->selectiveItemId;
                                    $m_sub_product->save($updated_data,$SelectionItemFilesId);

                                }
                            }
                        }


                    }


                }
                if(!empty($delete_ids)){
                    // Delete
                    $delete_ids=json_decode($delete_ids,true);
                    foreach($delete_ids as $id){
                        $m_sub_product->db->where('SelectionItemFilesId',$id);
                        $m_sub_product->db->where('foodItemId',$foodItemId);
                        $m_sub_product->db->limit(1);
                        $this->db->delete($m_sub_product->get_table_name());
                    }
                }

                $this->Sub_product_files_Model->db->order_by('SortOrder', 'ASC');
                $subProductsFile = $this->Sub_product_files_Model->get();

                $this->Selectionitems_Model->db->select('selectiveItemId,foodItemId,SelectionItemFilesId');
                $assignedSubProductsFile= $this->Selectionitems_Model->get_by(array(
                    'SelectionItemFilesId!='=>NULL,
                ));
                $responseData = array(
                    'isSave' => true,
                    'responseMessage' => 'Sub Product file assign/removed successfully',
                    'subProductsFile' => $subProductsFile,
                    'assignedSubProductsFile' => $assignedSubProductsFile,
                );

                $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
            }

    }




}