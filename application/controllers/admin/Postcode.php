<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Postcode extends Admin_Controller {

    public $product;

    public function __construct() {
        parent:: __construct();
        $this->load->helper("url");
        $this->load->model('User_Model');
        $this->load->model('Postcode_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->library("pagination");

        if (!$this->User_Model->loggedin()) {
            redirect('admin');
        } else {
            $this->load->library('CSVReader');
        }
    }

    public function update() {
        $lib_csb = new CSVReader();
        $file_url = base_url('assets/postcode.csv');
        $is_exist = is_url_exist($file_url);
        // $is_exist = file_exists('assets/postcode.csv');
        if (!$this->db->table_exists('postcode')) {
            $this->load->dbforge();
            $this->dbforge->add_key('id', TRUE);
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'postcode' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '15',
                    'unique' => TRUE,
                ),
                'district' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '80',
                ),
                'latitude' => array(
                    'type' => 'FLOAT',
                ),
                'longitude' => array(
                    'type' => 'FLOAT',
                ),
                'postal_town' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '80',
                ),
                'county' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '80',
                ),
                'country' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '80',
                ),
            );
            $this->dbforge->add_field($fields);
            $this->dbforge->create_table('postcode', TRUE);
        } else {
            $this->Postcode_Model->clean_table();
        }

        if ($is_exist) {
            $csvData = $lib_csb->parse_file(base_url('assets/postcode.csv'), true);
            $postcodes = array();
            foreach ($csvData as $key => $data) {
                $newData['postcode'] = array_key_exists('postcode', $data) ? $data['postcode'] : $data['Postcode'];
                $newData['district'] = array_key_exists('district', $data) ? $data['district'] : $data['District'];
                $newData['postal_town'] = array_key_exists('postal_town', $data) ? $data['postal_town'] : '';
                $newData['county'] = array_key_exists('county', $data) ? $data['county'] : $data['County'];
                $newData['country'] = array_key_exists('country', $data) ? $data['country'] : $data['Country'];
                $newData['latitude'] = array_key_exists('latitude', $data) ? $data['latitude'] : $data['Latitude'];
                $newData['longitude'] = array_key_exists('longitude', $data) ? $data['longitude'] : $data['Longitude'];

                $existPostcode = $this->Postcode_Model->get_by(array('postcode' => $newData['postcode']), true);

                if (empty($existPostcode)) {
                    array_push($postcodes, $newData);
                } else {
                    // update
                    $this->Postcode_Model->save($newData, $existPostcode);
                }
            }

            if (!empty($postcodes)) {
                $is_updated = $this->Postcode_Model->insert_batch($postcodes);
                if ($is_updated) {
                    $status = 'success';
                    $title = 'Success';
                    $message = 'Postcode Is Updated';
                } else {
                    $status = 'error';
                    $title = 'Error';
                    $message = 'Postcode Is Not Updated';
                }
            }
        } else {
            $status = 'error';
            $title = 'Error';
            $message = 'File "postcode.csv" Not Found';
        }

        $this->session->set_userdata('update_status',$status);
        $this->session->set_userdata('update_title',$title);
        $this->session->set_userdata('update_message',$message);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'title'=>$title,'message'=>$message)));
        // redirect(base_url("admin/postcode/all"));
    }

    public function edit() {
        if ($this->input->is_ajax_request()) {
            if ($this->User_Model->loggedin()) {
                $id = $this->input->post('id');
                $postcode = $this->input->post('postcode');
                $longitude = $this->input->post('longitude');
                $latitude = $this->input->post('latitude');
                $postcode = formatUKPostcode($postcode);
                $isValid = check_postcode_uk($postcode);

                $m_postcode = new Postcode_Model();
                $isEdited = false;
                $message = '';
                if ($isValid) {
                    $postcodeObj = $m_postcode->get_by(array('postcode' => $postcode,'id!=' => $id,), true);
                    if (empty($postcodeObj)) {
                        $isEdited = $m_postcode->save(array('postcode' => $postcode,'latitude' => $latitude,'longitude' => $longitude,), $id);
                    } else {
                        $message = 'Postcode is already exist';
                    }
                } else {
                    $message = 'Postcode is not valid';
                }

                if ($isEdited) {
                    $postcode = $m_postcode->get_by(array('id' => $id), true);
                    $message = 'Postcode is edited successfully';
                    $postcode->distance = number_format($m_postcode->get_distance($postcode->postcode), 2);
                } else {
                    $message = (empty($message)) ? 'Postcode is not edited' : $message;
                }

                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'isEdited' => $isEdited,
                    'postcode' => $postcode,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $response_data = array(
                    'status' => 200,
                    'message' => 'Postcode is not edited',
                    'isEdited' => false,
                    'postcode' => null,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            redirect($this->admin . '/dashboard');
        }
    }

    public function insert() {
        if ($this->input->is_ajax_request()) {
            if ($this->User_Model->loggedin()) {
                $postcode = $this->input->post('postcode');
                $postcode = formatUKPostcode($postcode);
                $isValid = check_postcode_uk($postcode);
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
                $m_postcode = new Postcode_Model();
                $isAdded = false;
                $newPostcode = null;
                if ($isValid) {
                    $postcodeObj = $m_postcode->get_by(array('postcode' => $postcode,), true);

                    if (empty($postcodeObj)) {
                        $isAdded = $m_postcode->save(array(
                            'postcode' => $postcode,
                            'latitude' => $latitude,
                            'longitude' => $longitude,
                            'country' => '',
                            'county' => '',
                            'postal_town' => '',
                        ));
                        if ($isAdded) {
                            $newPostcode = $m_postcode->get_by(array('postcode' => $postcode,), true);
                            $newPostcode->distance = number_format($m_postcode->get_distance($postcode), 2);
                        }
                        $message = ($isAdded) ? 'Postcode is added successfully' : 'Postcode is not added';
                    } else {
                        $message = 'Postcode already exist';
                    }
                } else {
                    $message = 'Postcode is not  valid';
                }

                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'isAdded' => $isAdded,
                    'postcode' => $newPostcode,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $response_data = array(
                    'status' => 200,
                    'message' => 'Postcode is not added',
                    'isEdited' => false,
                    'postcode' => null,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            redirect($this->admin . '/dashboard');
        }
    }

    public function delete() {
        if ($this->input->is_ajax_request()) {
            if ($this->User_Model->loggedin()) {
                $id = $this->input->post('id');
                $m_postcode = new Postcode_Model();
                $isAdded = false;
                $newPostcode = null;

                $isDeleted = $m_postcode->delete($id);
                $message = ($isDeleted) ? 'Postcode is deleted successfully' : 'Postcode is not deleted';
                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'isDeleted' => $isDeleted,
                    'postcode' => $newPostcode,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $response_data = array(
                    'status' => 200,
                    'message' => 'Postcode is not added',
                    'isEdited' => false,
                    'postcode' => null,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            redirect($this->admin . '/dashboard');
        }
    }

    public function set_limit_in_session() {
        $limit = $this->input->post('limit');
        $is_saved = true;
        $this->session->set_userdata('session_limit',$limit);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('is_saved'=>$is_saved)));
    }

    public function all() {
        if (is_user_permitted('admin/postcode/all') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $limit = 1000;
        $session_limit = $this->session->userdata('session_limit');
        if ($session_limit) {
            $limit = $session_limit;
        }

        $config = array();
        $config["base_url"] = base_url("admin/postcode/all");
        $config["total_rows"] = $this->Postcode_Model->get_total_postcode();
        $config["per_page"] = $limit;
        $config["uri_segment"] = 4;

        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        $this->pagination->initialize($config);
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $postcodes_list = $this->Postcode_Model->get_postcode($start,$limit);

        $this->page_content_data['limit'] = $limit;
        $this->page_content_data['start'] = $start;
        $this->page_content_data['postcodes_list'] = $postcodes_list;
        $this->page_content_data['total_postcodes'] = $this->Postcode_Model->get_total_postcode();
        $this->page_content_data["links"] = $this->pagination->create_links();
        $this->page_content_data["update_status"] = $this->session->userdata('update_status');
        $this->page_content_data["update_title"] = $this->session->userdata('update_title');
        $this->page_content_data["update_message"] = $this->session->userdata('update_message');
        $this->session->unset_userdata('update_status');
        $this->session->unset_userdata('update_title');
        $this->session->unset_userdata('update_message');

        if ($this->input->is_ajax_request()) {
            $postcode_table_output = $this->load->view('admin/settings/postcode/postcode_table', $this->page_content_data, true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('postcode_table_output'=>$postcode_table_output
            )));
        } else {
            $this->page_content_data['title'] = "Post Code List";
            $this->page_content = $this->load->view('admin/settings/postcode/list',$this->page_content_data,true);
            $this->custom_js = $this->load->view('admin/settings/postcode/list_js',$this->page_content_data,true);

            $this->data['title'] = "Post Code | Index";
            $this->load->view('admin/master/master_index',$this->data);

            // $this->load->view('admin/header');
            // $this->load->view('admin/settings/postcode/list', $this->data);
            // $this->load->view('admin/script_page');
        }
    }

    public function search_postcode() {
        if ($this->input->is_ajax_request()) {
            $limit = $this->input->post('limit');
            $start = $this->input->post('start');
            $postcodes_list = array();
            $is_success = false;
            if (empty($limit)) {
                $limit = 1000;
            }

            if (empty($start)) {
                $start = 0;
            }

            $search_data = $this->input->post('search_data');
            $total_search_postcode = 0;
            if ($search_data != '') {
                $postcodes_list = $this->Postcode_Model->search_postcode($search_data);
                if ($postcodes_list) {
                    $total_search_postcode = count($postcodes_list);
                }
                $is_success = true;
            }


            $config = array();
            $config["base_url"] = base_url("admin/postcode/all");
            $config["total_rows"] = $total_search_postcode;
            $config["per_page"] = $limit;
            $config["uri_segment"] = 4;

            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] ="</ul>";
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";

            $this->pagination->initialize($config);

            $this->data['limit'] = $limit;
            $this->data['start'] = $start;
            $this->data['postcodes_list'] = $postcodes_list;
            $this->data['total_postcodes'] = $this->Postcode_Model->get_total_postcode();
            $this->data['total_search_postcode'] = $total_search_postcode;
            $this->data["links"] = $this->pagination->create_links();
            
            $postcode_table_output = $this->load->view('admin/settings/postcode/postcode_table', $this->data, true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('is_success'=>$is_success,'postcode_table_output'=>$postcode_table_output
            )));
        }
    }

    public function search_postcode_by_distance() {
        if ($this->input->is_ajax_request()) {
            $limit = $this->input->post('limit');
            $start = $this->input->post('start');
            $postcodes_list = array();
            $is_success = false;
            if (empty($limit)) {
                $limit = 1000;
            }

            if (empty($start)) {
                $start = 0;
            }

            $search_distance = $this->input->post('distance');
            $total_search_postcode = 0;
            if ($search_distance != '') {
                $postcodes_list = $this->Postcode_Model->get_postcode(0,0,$search_distance);;
                if ($postcodes_list) {
                    $total_search_postcode = count($postcodes_list);
                }
                $is_success = true;
            }

            $config = array();
            $config["base_url"] = base_url("admin/postcode/all");
            $config["total_rows"] = $total_search_postcode;
            $config["per_page"] = $limit;
            $config["uri_segment"] = 4;

            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] ="</ul>";
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";

            $this->pagination->initialize($config);
            // echo "<pre>"; print_r($config); exit();

            $this->data['limit'] = $limit;
            $this->data['start'] = $start;
            $this->data['postcodes_list'] = $postcodes_list;
            $this->data['total_postcodes'] = $this->Postcode_Model->get_total_postcode();
            $this->data['total_search_postcode'] = $total_search_postcode;
            $this->data["links"] = $this->pagination->create_links();
            
            $postcode_table_output = $this->load->view('admin/settings/postcode/postcode_table', $this->data, true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('is_success'=>$is_success,'postcode_table_output'=>$postcode_table_output
            )));
        }
    }

    public function get_postcode_form() {
        if ($this->input->is_ajax_request()) {
            if ($this->User_Model->loggedin()) {
                $postcode_id = $this->input->post('postcode_id');
                $url = $this->input->post('url');
                $form_type = $this->input->post('form_type');
                $is_success = false;

                $this->data['url'] = $url;
                $this->data['form_type'] = $form_type;
                if ($form_type == 'add') {
                    $is_success = true;
                    $this->data['postcode_info'] = '';
                    $this->data['btn_name'] = 'Save';
                } elseif ($form_type == 'edit') {
                    $postcode_info = $this->Postcode_Model->get_postcode_by_id($postcode_id);
                    $edit_output = '';
                    // echo "<pre>"; print_r($postcode_info); exit();

                    if ($postcode_info) {
                        $is_success = true;
                        $this->data['postcode_info'] = $postcode_info;
                        $this->data['url'] = $url;
                        $this->data['btn_name'] = 'Update';
                    }
                }
                $form_output = $this->load->view('admin/settings/postcode/postcode_form', $this->data, true);
                
                $this->output->set_content_type('application/json')->set_output(json_encode(array('is_success'=>$is_success,'form_output'=>$form_output)));
            }
        } else {
            redirect($this->admin . '/dashboard');
        }
    }

    public function postcode_save() {
        if ($this->User_Model->loggedin() == TRUE) {
            $id = trim($this->input->post('id'));
            $from_data = $this->Allowed_postcodes_Model->data_form_post(array('id','postcode','latitude','longitude'));
            $url = $this->input->post('url');

            $this->form_validation->set_rules('postcode', 'Postcode', 'required');
            $this->form_validation->set_rules('latitude', 'Latitude', 'required');
            $this->form_validation->set_rules('longitude', 'Longitude', 'required');

            if ($this->form_validation->run() === FALSE) {
                redirect($url);
            } else {
                if (empty($id)) {
                    $is_postcode_exists = $this->Postcode_Model->is_postcode_exists($from_data['postcode']);
                    if (!$is_postcode_exists) {
                        $result = $this->Postcode_Model->save($from_data);
                        $this->session->set_flashdata('success_message', 'Information has been saved successfully.');
                        redirect($url);
                    } else {
                        $this->session->set_flashdata('error_message', 'Postcode Already Exists.');
                        redirect($url);
                    }
                } else {
                    $is_postcode_exists = $this->Postcode_Model->is_postcode_exists($from_data['postcode'],$id);
                    if (!$is_postcode_exists) {
                        $result = $this->Postcode_Model->save($from_data, $id);
                        $this->session->set_flashdata('success_message', 'Information has been updated successfully.');
                        redirect($url);
                    } else {
                        $this->session->set_flashdata('error_message', 'Postcode Already Exists.');
                        redirect($url);
                    }
                }
            }
        } else {
            redirect($this->admin);
        }
    }

    public function delete_postcode() {
        if ($this->input->is_ajax_request()) {
            $postcode_id = $this->input->post('postcode_id');
            $is_success = false;

            if ($postcode_id) {
                $is_success = true;
                $this->db->delete('postcode', array('id' => $postcode_id));
            }
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('is_success'=>$is_success)));
        } else {
            redirect($this->admin.'/dashboard');
        }
    }

    public function get_upload_form() {
        if ($this->input->is_ajax_request()) {
            if ($this->User_Model->loggedin()) {
                $is_success = true;
                $form_output = $this->load->view('admin/settings/postcode/upload_form', $this->data, true);                
                $this->output->set_content_type('application/json')->set_output(json_encode(array('is_success'=>$is_success,'form_output'=>$form_output)));
            }
        } else {
            redirect($this->admin.'/dashboard');
        }
    }

    public function upload_excel_file() {
        if ($this->input->is_ajax_request()) {
            if (isset($_FILES["excel_file"])) {
                $new_name = 'postcode';
                $config['file_name'] = trim($new_name);
                $config['upload_path'] = './assets/';
                $config['allowed_types'] = 'xlsx|csv|xls';
                $config['overwrite'] = TRUE;
                $this->load->library('upload', $config);
                $is_upload = $this->upload->do_upload('excel_file');
                $d = array('upload_data' => $this->upload->data());
                // echo $is_upload;
                // echo "<pre>"; print_r($d); exit();
                $responseData = array();
                if ($is_upload) {
                    $path = '/assets/'.$d['upload_data']['file_name'];
                    $responseData = array(
                        'is_uploaded' => true,
                        'file_path' => $path,
                        'full_path' => base_url($path),
                        'message' => 'File Upload Successful'
                    );
                } else {
                    $error_message = $this->upload->display_errors();
                    $responseData = array(
                        'is_uploaded' => false,
                        'file_path' => null,
                        'full_path' => null,
                        'message' => $error_message,
                        // 'message' => 'Upload Error,Because '.$error_message.', Try Again',
                        'error' => $error_message
                    );
                }
            } else {
                $responseData = array(
                    'is_uploaded' => false,
                    'file_path' => null,
                    'full_path' => null,
                    'message' => 'Please Select Excel File',
                );
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($responseData));
        } else {
            //redirect($this->admin . '/shop/edit');
            // redirect($this->admin);
        }
    }
}