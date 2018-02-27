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

//            $col = array('', FALSE);
//            $join = array(
//                array(
//                    "subject_list_has_topic_list as sltl", "sltl.topic_list_id = tl.topic_list_id"
//                ),
//                array(
//                    "subject_list as sl", "sl.subject_list_id = sltl.subject_list_id"
//                )
//            );
//            $where = array('sl.subject_list_is_active' => 1, 'sl.subject_list_department' => $info["user"]->fic_department);
//            $result = $this->Crud_model->fetch_join2('topic_list as tl', NULL, $join, NULL, $where);
//
//            print_r($result);
            $data = array(
                "topic_list_name" => "alGebra",
                "topic_list_is_active" => 1
            );
            $result = $this->Crud_model->insert("topic_list", $data);
            print_r($result);
            if ($result['code'] == 1062) {
                echo "duplicate";
            }
            $data = array(
                "title" => "Topic Management",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_c" => "",
                "s_f" => ""
            );
            $this->load->view('includes/header', $data);
            $this->load->view('topics/main');
            $this->load->view('includes/footer');
        }
    }

}
