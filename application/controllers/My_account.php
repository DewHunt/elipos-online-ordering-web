<?php

class My_account extends Frontend_Controller {

    public $product;
    public $m_customer;

    public function __construct() {
        parent:: __construct();
        $this->product = new Product();
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->helper('cookie');
        $this->load->helper(array('form'));
        $this->load->model('Customer_Model');
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('Table_model');
        $this->m_customer = new Customer_Model();
    }

    public function index() {
        $this->data['product_object'] = $this->product;
        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            if (!empty($this->cart->contents())) {
                redirect('menu');
            } else {
                redirect('my_account/customer_order_list');
            }
        } else {
            list($captcha_image,$captcha_text) = get_captcha_image();
            $this->session->set_userdata('signup_captcha_text',$captcha_text);
            $this->data['title'] = "My Account";
            $this->data['captcha_image'] = $captcha_image;
            $this->page_content = $this->load->view('my_account/login_form',$this->data,true);
            $this->footer = $this->load->view('footer',$this->data,true);
            $this->load->view('index',$this->data);
        }
    }

    public function refresh_captcha() {
        list($captcha_image,$captcha_text) = get_captcha_image();
        $this->session->set_userdata('signup_captcha_text',$captcha_text);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('captcha_image'=>$captcha_image)));
    }

    public function check_captcha() {
        $is_matched = false;
        $session_captcha_text = $this->session->userdata('signup_captcha_text');
        $captcha_text = $this->input->post('captchaText');
        if ($session_captcha_text && $captcha_text) {
            if ($session_captcha_text == $captcha_text) {
                $is_matched = true;
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($is_matched));     
    }

    public function login_action() {
        // dd($this->input->get());
        $login_type = '';
        if ($this->input->get('login_type')) {
            $login_type = $this->input->get('login_type');
        }

        $this->form_validation->set_rules($this->Customer_Model->customer_login_rules);
        if ($this->form_validation->run() == true || $login_type == 'guest') {
            if ($this->input->post('email')) {
                $email = $this->input->post('email');
            } else {
                $email = $this->input->get('email');
            }

            if ($this->input->post('password')) {
                $password = sha1($this->input->post('password'));
            } else {
                $password = $this->input->get('password');
            }
            // echo $password; exit();

            $this->Customer_Model->login($email,$password);

            if ($this->Customer_Model->customer_is_loggedIn() == true) {
                $customer = $this->Customer_Model->get_by((array('email' => $email,'password' => $password)), true);
                $this->session->set_flashdata('is_customer_login', true);
                $menu_url_session = $this->session->userdata('menu_url_session');
                $m_customer_action = new Customer_Action_Model();
                $m_customer_action->save_action('Login',$customer->id);
                !empty($menu_url_session) ? redirect('order') : redirect('menu');
            } else {
                $this->session->set_flashdata('customer_login_error', 'Please Check Email Or Password');
                redirect('my_account');
            }
        } else {
            $this->session->set_flashdata('form_validation_error_login', validation_errors());
            redirect('my_account');
        }
    }

    public function registration_action() {
        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            redirect(base_url());
        } else {
            $this->form_validation->set_rules($this->Customer_Model->customer_registration_rules);
            $data = $this->Customer_Model->data_form_post(array('title','first_name','last_name','email','mobile','billing_postcode'));
            $is_matched = false;
            $session_captcha_text = $this->session->userdata('signup_captcha_text');
            $captcha_text = $this->input->post('captcha_text');
            if ($session_captcha_text && $captcha_text) {
                if ($session_captcha_text == $captcha_text) {
                    $is_matched = true;
                }
            }

            if ($this->form_validation->run() == false || $is_matched == false) {
                $errors = validation_errors();
                if ($is_matched == false) {
                    $errors = "Captcha not matched.";
                }
                $this->session->set_flashdata('form_validation_error', $errors);
                redirect('my_account');
            } else {
                /* check email is already registered */
                $this->Customer_Model->search_column_name = 'email';
                // dd($this->Customer_Model->get_numbers_of_rows($this->input->post('email')));

                if ($this->Customer_Model->get_numbers_of_rows($this->input->post('email'))) {
                    $this->session->set_flashdata('customer_email_exist', 'This email '.$this->input->post('email').' Already Registered');
                    $customer_email_exist_message = 'This email '.$this->input->post('email').' Already Registered';
                    $base_url_my_account = base_url('my_account');
                    echo "<script>alert('".$customer_email_exist_message."');"."window.location.href='$base_url_my_account';</script>";
                } else {
                    $password = $this->input->post('password');
                    $data['password'] = sha1($password);
                    $is_save = $this->Customer_Model->save($data);

                    if ($is_save) {
                        $customer = $this->Customer_Model->get_customer_by_id($this->db->insert_id());
                        // $this->send_registered_mail($customer);
                        // dd($customer);

                        $shop = get_company_details();

                        $companyName = get_property_value('company_name', $shop);
                        $email = get_property_value('email', $customer);

                        $customerInformation = array('customerInfo' => $customer,'companyName' => $companyName,);

                        $subject = "Registration Confirmation Of ".$companyName;
                        $body = $this->load->view('email_template/customer_email', $customerInformation, true);
                        $customerName = get_customer_full_name($customer);
                         
                        $this->load->library('PHPMailer_Lib');
             
                        $lib = new PHPMailer_Lib();
                        $isSend = $lib->sendMail($subject,$body,$email,$customerName);

                        $this->Customer_Model->login($data['email'], $data['password']);
                        $this->session->set_flashdata('is_customer_login', true);
                        $registration_success_alert_message = 'Customer Registeration Succcessful';

                        $menu_url_session = $this->session->userdata('menu_url_session');
                        $base_url = !empty($menu_url_session) ? redirect('order') : redirect('menu');
                        echo "<script>alert('" . $registration_success_alert_message . "'); " . "window.location.href='$base_url';</script>";
                    }
                }
            }
        }
    }

    public function send_registered_mail($customer) {
        // dd($customer->email);
        $shop = get_company_details();
        $companyName = get_property_value('company_name', $shop);
        $customer_email = $customer->email;
        $customerName = get_customer_full_name($customer);
        $email = get_property_value('email', $customer);
        
        $config = Array(
            'protocol' => 'smtp',
            'mailpath' => 'ssl://' . trim(get_smtp_host_url()),
            'smtp_host' => 'ssl://' . trim(get_smtp_host_url()),
            'smtp_port' => 465,
            'smtp_user' => trim(get_smtp_host_user()), // change it to yours
            'smtp_pass' => trim(get_smtp_host_user_password()), // change it to yours
            'mailtype' => 'html',
        );
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
        $this->email->to(trim($customer_email));
        $this->email->subject("Registration Confirmation Of ".$companyName);
        $this->data['customerInfo'] = $customer;
        $this->data['companyName'] = $companyName;
        $body = $this->load->view('email_template/customer_email', $this->data, true);
        $this->email->message($body);
        return $this->email->send();
    }

    public function logout() {
        if ($this->Customer_Model->customer_is_loggedIn()) {
            $login_type = $this->session->userdata('login_type');
            $m_customer_action = new Customer_Action_Model();
            $customer_id = $this->session->userdata('customer_id');
            $m_customer_action->save_action('Logout',$customer_id);
            
            if ($login_type == 'customer') {
                $this->cart->destroy();
            }
            $this->Customer_Model->logout();
            //delete_cookie('delivery_type', $domain, $path);
            $this->session->unset_userdata('delivery_charge_info_session'); //delivery
            $this->session->unset_userdata('delivery_charge_info_session'); //collection
            $this->session->unset_userdata('special_notes_session'); //special notes
            redirect('menu');
        } else {
            redirect('my_account');
        }
    }

    public function is_email_exist() {
        if ($this->input->is_ajax_request()) {
            if ($this->Customer_Model->is_email_registered()) {
                echo "<p class='message-email-exist' style='color: red'>This email already registered by another account. Try another email</p>";
            }
        } else {
            redirect('menu');
        }
    }

    public function is_email_exist_without_this_id() {
        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                $email = $this->input->post('email');
                $sql = "SELECT * FROM user WHERE NOT id='$id'and email='$email'";

                if (!empty($this->Customer_Model->queryString($sql))) {
                    echo "<p class='message-email-exist' style='color: red'>Email Already registered by another Customer. Try another</p>";
                }
            } else {
                redirect('admin/user');
            }
        } else {
            redirect('admin');
        }
    }

    public function recovery() {
        if (!$this->Customer_Model->customer_is_loggedIn()) {
            $this->session->unset_userdata('password_recovery_email');
            $this->session->unset_userdata('password_recovery_customer');
            $this->session->unset_userdata('password_recovery_code');
            $postcode_by_limit = $this->Allowed_postcodes_Model->get_postcode_by_limit();
            $this->data['postcode_by_limit'] = $postcode_by_limit;
            $this->data['title'] = 'Forget Password:' . get_company_name();

            $this->page_content = $this->load->view('my_account/recover_password_email', $this->data,true);
           $this->footer = $this->load->view('footer',$this->data,true);
            $this->load->view('index');
        } else {
            redirect('my_account');
        }
    }

    public function check_email() {
        if ($this->input->is_ajax_request()) {
            if (!$this->Customer_Model->customer_is_loggedIn()) {
                $this->form_validation->set_rules($this->Customer_Model->email_rules);
                if ($this->form_validation->run()) {
                    $this->data['message'] = '';
                    $email = $this->input->post('email');
                    $customer = $this->Customer_Model->get_customer_by_email($email);
                    if (!empty($customer)) {
                        $code = null;
                        for ($i = 0; $i < 6; $i++) {
                            $code .= mt_rand(1, 9);
                        }
                        $is_save = $this->Customer_Model->save(array('temp_code' => $code), $customer->id);

                        if ($is_save) {
                            $this->session->set_userdata('password_recovery_email', $email);
                            $this->session->set_userdata('password_recovery_customer', $customer);
                            $is_email_sent = $this->send_mail($code);
                            if ($is_email_sent) {
                                $this->data['customer'] = $customer;
                                $this->load->view('my_account/recover_password_code', $this->data);
                            } else {
                                ?>
                                <p class="error"> Email can not sent</p>
                                <?php
                            }
                        } else {
                            // redirect('my_account/recovery');
                            ?>
                            <p class="error"><?= $email ?> Temp code not sent</p>
                            <?php
                        }
                    } else {
                        ?>
                        <p class="error"><?= $email ?> Did not found your input email</p>
                        <?php
                    }
                } else {
                    ?>
                    <p class="error">Please insert an email</p>
                    <?php
                }
            }
        } else {
            redirect('my_account');
        }
    }

    private function send_mail($code) {
        if (!$this->Customer_Model->customer_is_loggedIn()) {
            $customer_email =$this->session->userdata('password_recovery_email');
            $config = Array(
                'protocol' => 'smtp',
                'mailpath' => 'ssl://' . trim(get_smtp_host_url()),
                'smtp_host' => 'ssl://' . trim(get_smtp_host_url()),
                'smtp_port' => 465,
                'smtp_user' => trim(get_smtp_host_user()), // change it to yours
                'smtp_pass' => trim(get_smtp_host_user_password()), // change it to yours
                'mailtype' => 'html',
            );
            $this->load->library('email');
            $this->email->initialize($config);
            /// $this->email->reply_to(trim(get_company_contact_email()), get_smtp_mail_form_title());
            $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
            $this->email->to(trim($customer_email));
            $this->email->subject(get_company_name() . ' Account password recovery code');
            $this->data['code'] = $code;
            $body = $this->load->view('email_template/password_recovery', $this->data, true);
            $this->email->message($body);
            return $this->email->send();
        } else {
            return false;
        }
    }

    public function check_code() {
        if ($this->input->is_ajax_request()) {
            if (!$this->Customer_Model->customer_is_loggedIn()){
                $this->form_validation->set_rules($this->Customer_Model->code_rules);
                if ($this->form_validation->run()) {
                    $code = trim($this->input->post('code'));
                    $this->session->set_userdata('password_recovery_code', $code);
                    $email = $this->session->userdata('password_recovery_email');
                    $customer = $this->session->userdata('password_recovery_customer');
                    $customer_id = $customer->id;
                    $is_code_valid = $this->Customer_Model->is_code_exist_with_email($customer_id, $code, $email);

                    if ($is_code_valid) {
                        $this->load->view('my_account/recover_password_reset', $this->data);
                    } else {
                        $this->data['customer'] = $customer;
                        $this->data['message'] = "Code didn't match ";
                        $this->load->view('my_account/recover_password_code', $this->data);
                    }
                } else {
                    ?>
                    <p class="error">Code is not valid</p>
                    <?php
                }
            }
        } else {
            redirect('my_account/recovery');
        }
    }

    public function recovery_password_reset() {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules($this->Customer_Model->recovery_password_reset_rules);
            if ($this->form_validation->run()) {
                $password = $this->input->post('password');
                $email = $this->session->userdata('password_recovery_email');
                $this->session->unset_userdata('password_recovery_email');
                $this->session->unset_userdata('password_recovery_code');
                $customer = $this->session->userdata('password_recovery_customer');
                $is_update = false;
                if (!empty($customer)) {
                    $customer_id = (!empty($customer)) ? $customer->id : '';
                    $m_customer_action=new Customer_Action_Model();
                    $password = sha1($password);
                    $action_data = array(
                        'previous_password' => $customer->password,
                        'current_password' => $password
                    );
                    $is_update = $this->Customer_Model->update_password_recovery($customer_id, $password);
                }

                if ($is_update) {
                    $m_customer_action->save_action('Password Recovery',$customer_id,json_encode($action_data));
                    $this->Customer_Model->save(array('temp_code' => null), $customer_id);
                    $this->session->set_userdata('is_customer_password_update', true);
                    $is_customer_exist = $this->Customer_Model->login($email, $password);
                    if ($is_customer_exist) {
                        $this->session->set_flashdata('is_customer_login', true);
                        $this->output->set_content_type("application/json")->set_output(json_encode(array('status' => true, 'redirect' => base_url('my_account/profile'))));
                    } else {
                        $this->session->set_flashdata('customer_login_error', 'No match for  email and password');
                        $this->output->set_content_type("application/json")->set_output(json_encode(array('status' => true, 'redirect' => base_url('my_account'))));
                    }
                } else {
                    $this->output->set_content_type("application/json")->set_output(json_encode(array('status' => true, 'redirect' => base_url('my_account/recovery'))));
                }
            } else {
                redirect('my_account/recovery');
            }
        } else {
            redirect('my_account/recovery');
        }
    }

    public function reset_password() {
        if ($this->Customer_Model->customer_is_loggedIn()) {
            $postcode_by_limit = $this->Allowed_postcodes_Model->get_postcode_by_limit();
            $this->data['postcode_by_limit'] = $postcode_by_limit;
            $this->data['title'] = 'Reset Password:'.get_company_name();

            $this->page_content = $this->load->view('customer_account_details/password_reset', $this->data, true);
            $this->footer = $this->load->view('footer',$this->data,true);
            $this->load->view('index',$this->data);
        } else {
            redirect('my_account/login');
        }
    }

    public function password_reset() {
        if ($this->Customer_Model->customer_is_loggedIn()) {
            $this->form_validation->set_rules($this->Customer_Model->password_reset_rules);
            if ($this->form_validation->run()) {
                $customer_id = $this->Customer_Model->get_logged_in_customer_id();
                $old_password = $this->input->post('current_password');
                $old_password = sha1($old_password);
                $is_matched = $this->Customer_Model->is_password_match_with_id($customer_id, $old_password);
                if ($is_matched) {
                    $new_password = $this->input->post('password');
                    $data['password'] = sha1($new_password);
                    $is_save = $this->Customer_Model->save($data, $customer_id);
                    if ($is_save) {
                        $this->session->set_flashdata('success_message', "Your password updated successfully");
                    } else {
                        $this->session->set_flashdata('success_message', "Password doesn't updated successfully. Something went wrong");
                    }
                    $customer_info = $this->Customer_Model->get_customer_by_id($customer_id);
                    $this->send_changed_password_mail($customer_info);
                    redirect('my_account/reset_password');
                } else {
                    $this->session->set_flashdata('error_message', "Current password didn't match.");
                    redirect('my_account/reset_password');
                }
            } else {
                redirect('my_account/reset_password');
            }
        } else {
            redirect('my_account/login');
        }
    }

    private function send_changed_password_mail($customer_info) {
        // dd($customer_info);
        if ($this->Customer_Model->customer_is_loggedIn()) {
            $ip = get_user_ip_address();
            $api_keys = "5d33e81130e343be882b84b782cd4e93";
            $url = "https://api.ipgeolocation.io/ipgeo?apiKey=".$api_keys."&ip=".$ip;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Cache-Control: no-cache",
                    "Content-Type: application/json"
                )
            ));

            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);
            
            if (empty($error)) {
                $customer_email = $customer_info->email;
                $config = Array(
                    'protocol' => 'smtp',
                    'mailpath' => 'ssl://' . trim(get_smtp_host_url()),
                    'smtp_host' => 'ssl://' . trim(get_smtp_host_url()),
                    'smtp_port' => 465,
                    'smtp_user' => trim(get_smtp_host_user()), // change it to yours
                    'smtp_pass' => trim(get_smtp_host_user_password()), // change it to yours
                    'mailtype' => 'html',
                );
                $this->load->library('email');
                $this->email->initialize($config);
                /// $this->email->reply_to(trim(get_company_contact_email()), get_smtp_mail_form_title());
                $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
                $this->email->to(trim($customer_email));
                $this->email->subject('Security Alert');
                $this->data['customer_info'] = $customer_info;
                $this->data['location'] = json_decode($response);
                $body = $this->load->view('email_template/changed_password', $this->data, true);
                $this->email->message($body);
                return $this->email->send();
            }
            return false;
        } else {
            return false;
        }
    }

    public function customer_account_details() {
        // dd(get_company_logo_url());
        $this->Customer_Model->logout_guest_customer();
        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            $customer_id = $this->session->userdata('customer_id');
            $customer = $this->Customer_Model->get($customer_id, true);

            $this->data['title'] = "Profile";
            $this->data['product_object'] = $this->product;
            $this->data['customer'] = $customer;
            $this->page_content=  $this->load->view('customer_account_details/customer_profile', $this->data,true);
            $this->footer = $this->load->view('footer',$this->data,true);
            $this->load->view('index',$this->data);
        } else {
            redirect('my_account');
        }
    }

    public function customer_profile_update() {
        $this->Customer_Model->logout_guest_customer();
        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            $this->form_validation->set_rules($this->Customer_Model->customer_profile_update_rules);
            if ($this->form_validation->run() == TRUE) {
                $this->Customer_Model->where_column = 'id';
                $id = trim($this->input->post('id'));
                $email = trim($this->input->post('email'));
                $email_duplicate_check = $this->Customer_Model->get_login_customer_email_update_duplicate_check($id, $email);

                if (!empty($email_duplicate_check)) {
                    $this->session->set_flashdata('duplicate_email_found_error_message', 'This email ' . $email . ' Already registered.');
                    redirect('my_account/customer_account_details');
                } else {
                    $data = $this->Customer_Model->data_form_post(array('id', 'title', 'first_name', 'last_name', 'email', 'mobile', 'billing_address_line_1', 'billing_postcode', 'billing_city'));
                    $previous_info = $this->Customer_Model->get($id);
                    $is_save = $this->Customer_Model->save($data, $id);
                    if ($is_save) {
                        $action_data = array('previous_info' => $previous_info,'after_update_info' => $data);
                        $m_customer_action = new Customer_Action_Model();
                        $m_customer_action->save_action('Profile Update',$id,json_encode($action_data));
                        $this->session->set_flashdata('customer_profile_update_success_message', 'Information has been Updated Successfully.');
                        redirect('my_account/customer_account_details');
                    }
                }
            } else {
                $this->session->set_flashdata('form_validation_error', validation_errors());
                redirect('my_account/customer_account_details');
            }
        } else {
            redirect('my_account');
        }
    }

    public function customer_order_list() {
        $this->Customer_Model->logout_guest_customer();
        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            $customer_id = $this->session->userdata('customer_id');
            $customer = $this->Customer_Model->get($customer_id, true);
            $this->Order_information_Model->db->order_by('id','DESC');
            $order_information_list = $this->Order_information_Model->get_where('customer_id', $customer->id);
            
            $this->data['title'] = "Orders";
            $this->data['product_object'] = $this->product;
            $this->data['customer'] = $customer;
            $this->data['order_information_list'] = $order_information_list;
            $this->page_content = $this->load->view('customer_account_details/customer_order_list', $this->data,true);
            $this->footer = $this->load->view('footer',$this->data,true);
            $this->load->view('index');
        } else {
            redirect('my_account');
        }
    }

    public function get_order() {
        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            if ($this->input->is_ajax_request()) {
                $id = $this->input->post('id');
                $customer_id = $this->session->userdata('customer_id');
                $customer = $this->Customer_Model->get($customer_id, true);
                $order_details = $this->Order_details_Model->get_where('order_id',$id);
                $order_info = $this->Order_information_Model->get_order_info_by_id($id);
                $table_info = '';
                if (!empty($order_info) && $order_info->table_number != NULL) {
                    $table_info = $this->Table_model->get_table_by_id($order_info->table_number);
                }
                $this->data['order_details'] = $order_details;
                $this->data['table_info'] = $table_info;
                $this->data['customer'] = $customer;
                $this->data['order_information'] = $this->Order_information_Model->get($id,true);;
                $this->load->view('customer_account_details/order_view_modal', $this->data);
            }

        } else {
            redirect('my_account');
        }
    }


    public function email_template() {
        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            $id = '3';
            $body = $this->Order_information_Model->get_order_email_template($id);
            echo $body;
        } else {
            redirect('my_account');
        }
    }
}
