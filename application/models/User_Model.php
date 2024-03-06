<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends Ex_Model {

    protected $table_name = 'user';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public $rules = array(
        'name_or_email' => array(
            'field' => 'name_or_email',
            'label' => 'user Name or Email',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
            ),
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'userPassword',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => 'Provide  valid %s.',
            )
        )
    );
    public $user_registration_rules = array(
        'name' => array(
            'field' => 'name',
            'label' => 'User Name',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
            ),
        ),
        'email' => array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'trim|required|valid_email',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
            ),
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'userPassword',
            'rules' => 'trim|required',
        ),
        'confirm_password' => array(
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'trim|required|matches[password]',
        )
    );

    public function login() {
        $name_or_email = $this->input->post('name_or_email');
        $password = sha1($this->input->post('password'));
        $sqlString = "SELECT * FROM `user` WHERE `user_name` = '$name_or_email' AND `password` = '$password' OR `email` = '$name_or_email' AND `password` = '$password'";
        $user = $this->queryString($sqlString);
        if (!empty($user) && count($user)) {
            $data = array(
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->user_name,
                'user_email' => $user->email,
                'full_name' => $user->name,
                'user_loggedin' => true,
            );
            $this->session->set_userdata($data);
        }
        return $user;
    }

    public function logout() {
        $this->session->set_userdata('user_loggedin', false);
    }

    public function loggedin() {
        return (bool) $this->session->userdata('user_loggedin');
    }

    public function new_user() {
        $data = $this->data_form_post(array('name', 'user_name', 'email', 'role'));
        if (!$this->is_email_registered()) {
            if (!$this->is_user_name_exist()) {
                if($this->is_password_match_check()) {
                    $data['password'] = sha1(trim($this->input->post('password')));
                    $is_save = $this->save($data);
                    if ($is_save) {
                        return $result = 'Saved successfully';
                        ?>
                        <?php
                        $this->session->set_flashdata('is_user_added', true);
                    } else {
                        $this->session->set_flashdata('is_user_added', true);
                    }
                } else {
                    return $result = 'Password doest not match';
                }
            } else {
                return $result = 'user name already exists';
            }
        } else {
            return $result = 'email already exists';
        }
    }

    public function update_user() {
        $data = $this->data_form_post(array('id', 'name', 'email', 'role'));
        $data['password'] = sha1($this->input->post('password'));
        $this->save($data, $data['id']);
    }

    public function get_users_order_by() {
        $this->order_by = 'id';
        $this->order = 'DESC';
        return $this->get_order_by();
    }

    public function is_email_registered() {
        $email = trim($this->input->post('email'));
        $this->search_column_name = 'email';
        return !empty($this->get_numbers_of_rows($email)) ? true : false;
    }

    public function is_user_name_exist() {
        $name = $this->input->post('user_name');
        $this->search_column_name = 'user_name';
        return !empty($this->get_numbers_of_rows($name)) ? true : false;
    }

    public function is_password_match_check() {
        $password = trim($this->input->post('password'));
        $confirm_password = trim($this->input->post('confirm_password'));
        if ($password == $confirm_password) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_user_authentication($password) {
        $result = "";
        if (!empty($password)) {
            $password = sha1(trim($password));
            $user_name = $this->session->userdata('user_name');
            $result = $this->db->query("SELECT * FROM `user` WHERE `user_name` = '$user_name' AND `password` = '$password'")->row();
        }

        return $result;
    }

    public function get_user_by_id($id = 0) {
        $result = $this->db->query("SELECT * FROM `user` WHERE `id` = $id")->row();
        return $result;
    }

    public function get_all_users($role = 0) {
        $where_query = "";
        if ($role != 1 || $role > 0) {
            if ($role == 2) {
                $where_query = "WHERE `user`.`role` >= $role";
            } else if ($role == 3) {
                $where_query = "WHERE `user`.`role` = $role";
            }
        }
        $results = $this->db->query("
            SELECT `user`.*, `user_roles`.`name` AS `user_role_name`
            FROM `user`
            LEFT JOIN `user_roles` ON `user_roles`.`role` = `user`.`role`
            $where_query
            ORDER BY `user`.`name` ASC
        ")->result();
        return $results;
    }
}
