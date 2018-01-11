<?php

class Feedback extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
    }

    public function index() {
        $enrollment_id = $this->session->userdata('userInfo')['user']->enrollment_id;
        $offering_id = $this->session->userdata('userInfo')['user']->offering_id;
        $result = $this->Crud_model->fetch('offering', array('offering_id' => $offering_id))[0];
        if (empty($result->offering_lecturer_id)) { //last
            echo "wala";
        } else {
            echo "meron";
        }
        $data = array(
            'title' => "Feedback",
            'lecturer' => $allItems
        );
        $this->load->view('includes/header', $data);
        $this->load->view('feedback/feedback_main');
        $this->load->view('includes/footer');
    }

    public function content() {
        $data = array(
            "title" => "Feedback"
        );
        $this->load->view('includes/header', $data);
        $this->load->view('feedback/feedback_content');
        $this->load->view('includes/footer');
    }

}
