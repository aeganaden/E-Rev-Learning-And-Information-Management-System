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

        if ($result['result'] = $this->Crud_model->fetch_array("student", NULL, $where)) {
            $result['result'][0]['full_name'] = ucwords($result['result'][0]['firstname'] . " " . $result['result'][0]['midname'] . " " . $result['result'][0]['lastname']);
            $result['result'][0]['identifier'] = "student";
            print_r(json_encode($result));
        } else if ($result = $this->Crud_model->fetch_array("fic", NULL, $where)) {
            $result['result'][0]['full_name'] = ucwords($result['result'][0]['firstname'] . " " . $result['result'][0]['midname'] . " " . $result['result'][0]['lastname']);
            $result['result'][0]['identifier'] = "fic";
            print_r(json_encode($result));
        } else if ($result = $this->Crud_model->fetch("prof", $where)) {
            $result['result'][0]['full_name'] = ucwords($result['result'][0]['firstname'] . " " . $result['result'][0]['midname'] . " " . $result['result'][0]['lastname']);
            $result['result'][0]['identifier'] = "prof";
            print_r(json_encode($result));
        } else {
            print_r("");
        }
    }

}
