<?php
class SubProducts extends ApiAdmin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Fooditem_Model');
        $this->load->model('Selectionitems_Model');
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
        $this->Selectionitems_Model->db->distinct('foodItemId');
        $productIds=$this->Selectionitems_Model->get();
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
            $categories = $this->Category_Model->getAllCategories();
            $this->Fooditem_Model->db->order_by('SortOrder', 'ASC');
            $products=$this->Fooditem_Model->get();
            $this->Selectionitems_Model->db->order_by('SortOrder', 'ASC');
            $subProducts = $this->Selectionitems_Model->get();
            $this->setResponseJsonOutput(array(
                'subProducts' => $subProducts,
                'products' => $products,
                'categories' => $categories,
            ), ApiAdmin_Controller::HTTP_OK);
        }

    }

    public function get($productId=0)
    {


        $this->Selectionitems_Model->db->select('selectiveItemId,foodItemId,
        selectiveItemName,selectiveItemFullName,takeawayPrice,
        tablePrice,barPrice,vatRate,productSizeId,SortOrder,IF(vatIncluded=1,"true","false") as vatIncluded');
        $this->Selectionitems_Model->db->where('foodItemId', intval($productId));
        $this->Selectionitems_Model->db->order_by('SortOrder', 'ASC');
        $subProducts = $this->Selectionitems_Model->get();
        $this->setResponseJsonOutput(array(
            'subProducts' => $subProducts
        ), ApiAdmin_Controller::HTTP_OK);
    }


    public function save()
    {
        if ($this->checkMethod('POST')) {
            $this->load->library('form_validation');

            $foodItemId= trim($this->input->post('foodItemId'));
            $selectiveItemId = trim($this->input->post('selectiveItemId'));
            $selectiveItemId = (!empty($selectiveItemId)) ? $selectiveItemId : 0;

            $sub_product_name = trim($this->input->post('selectiveItemName'));
            $sub_product_full_name = trim($this->input->post('selectiveItemFullName'));
            $productSizeId = trim($this->input->post('productSizeId'));
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
                'productSizeId' => $productSizeId,
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
                    $is_product_name_exist_for_update = $this->Selectionitems_Model->is_product_name_exist_for_update($selectiveItemId, $sub_product_name);
                    if (!$is_product_name_exist_for_update) {
                        $this->Selectionitems_Model->where_column = 'selectiveItemId';
                        $form_data['selectiveItemId'] = $selectiveItemId;
                        $isSave = $this->Selectionitems_Model->save($form_data, $selectiveItemId);
                        $responseData['isSave'] = $isSave;
                        if ($isSave) {
                            $responseData['responseMessage'] = 'Sub Product information has been updated successfully';
                        } else {
                            $responseData['responseMessage'] = 'Sub Product information is not updated successfully';
                        }
                    } else {
                        $responseData['responseMessage'] = 'Sub Product name already exists';
                    }
                } else {
                    /*Save New Product*/

                    $sub_product_name_exist = $this->Selectionitems_Model->is_sub_product_name_exist($sub_product_name);

                    if (!$sub_product_name_exist) {
                        $is_inserted = $this->Selectionitems_Model->save($form_data);
                        $responseData['isSave'] = $is_inserted;
                        if ($is_inserted) {
                            $responseData['responseMessage'] = 'Product information has been saved successfully';
                        } else {
                            $responseData['responseMessage'] = 'Product information is not saved successfully';
                        }
                    } else {
                        $responseData['responseMessage'] = 'Sub Product name already exists';
                    }
                }


            }

            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);


        }
    }

    public function delete($id = 0)
    {
        if ($this->checkMethod('POST')) {
            $isDeleted = $this->Selectionitems_Model->delete(intval($id));
            $responseMessage = ($isDeleted) ? 'Sub Product is deleted successfully' : 'Sub Product is not deleted';
            $responseData = array(
                'isDeleted' => $isDeleted,
                'responseMessage' => $responseMessage,
            );

            $this->setResponseJsonOutput($responseData, ApiAdmin_Controller::HTTP_OK);
        }
    }


}