<?php

class Feedback extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
    }

    public function index() {
        $allItems = $this->Crud_model->fetch("lecturer");
        $data = array(
            'title' => "Feedback",
            'lecturer' => $allItems,
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
