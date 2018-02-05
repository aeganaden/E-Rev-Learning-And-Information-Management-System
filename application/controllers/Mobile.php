<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
    }

    public function login() {
//        $_POST['username'] = "mgbabaran";
//        $_POST['password'] = "mark";
        $where = array(
            "username" => $_POST['username'],
            "password" => $_POST['password']
        );

        if ($result = $this->Crud_model->fetch_array("student", NULL, $where)[0]) {

        } else if ($result = $this->Crud_model->fetch_array("fic", NULL, $where)[0]) {

        } else if ($result = $this->Crud_model->fetch("admin", $where)[0]) {

        }
        print_r(json_encode($result));
    }

}
