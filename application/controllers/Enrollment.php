<?php

date_default_timezone_set("Asia/Manila");
defined('BASEPATH') OR exit('No direct script access allowed');

class Enrollment extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        echo "test";
    }

}
