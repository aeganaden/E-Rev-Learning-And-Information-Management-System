<?php

class Feedback extends CI_Controller {

    public function index() {
        $this->load->view('includes/header');
        $this->load->view('feedback/feedback_main');
        $this->load->view('includes/footer');
    }

}
