<?php

class Feedback extends CI_Controller {

    public function index() {
        $data = array(
            "title" => "Feedback"
        );
        $this->load->view('includes/header', $data);
        $this->load->view('feedback/feedback_main');
        $this->load->view('includes/footer');
    }

}