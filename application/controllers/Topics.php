<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Topics extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
    }

    public function index() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            $info = $this->session->userdata('userInfo');

            $col = "topic_list_name, topic_list_description";
//            $this->db->group_by("year_level_name");
            $result_topic_list = $this->Crud_model->fetch_select("topic_list", $col, NULL);

            $data = array(
                "title" => "Topic Management",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_f" => "",
                "s_c" => "",
                "s_t" => "selected-nav",
                "s_s" => "",
                "s_co" => "",
                "s_ss" => "",
                "topic_list" => $result_topic_list
            );
            $this->load->view('includes/header', $data);
            $this->load->view('topics/main');
            $this->load->view('includes/footer');
        }
    }

}
