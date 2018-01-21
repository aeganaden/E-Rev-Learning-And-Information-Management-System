<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
    }

    public function login() {
//        $_POST['username'] = "mgbabaran";
//        $_POST['pass'] = "mark";
        $where = array(
            "username" => $this->input->post("username"),
            "password" => $this->input->post("pass")
        );

        if ($result = $this->Crud_model->fetch("student", $where)[0]) {

        } else if ($result = $this->Crud_model->fetch("professor", $where)) {

        } else if ($result = $this->Crud_model->fetch("admin", $where)) {

        }
        $hold['user_details'] = array();
        $hold['user_details'] = $result;
        print_r(json_encode($hold));
    }

}
