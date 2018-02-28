<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SubjectArea extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            $info = $this->session->userdata('userInfo');

//            $data = array(
//                "topic_list_name" => "alGebra",
//                "topic_list_is_active" => 1
//            );
//            $result = $this->Crud_model->insert("topic_list", $data);
//            print_r($result);
//            if ($result['code'] == 1062) {
//                echo "duplicate";
//            }
            $col = 'sl.subject_list_id, sl.subject_list_name, yl.year_level_name';
            $where = array('sl.subject_list_department' => $info['user']->fic_department, 'sl.subject_list_is_active' => 1);
            $join = array(
                array(
                    "year_level as yl", "sl.year_level_id = yl.year_level_id"
                )
            );
            $result = $this->Crud_model->fetch_join2("subject_list as sl", $col, $join, NULL, $where);
            echo "<pre>";
            print_r($result);

//            set_cookie("subject_area", $value);

            $data = array(
                "title" => "Subject Area Management",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_c" => "",
                "s_f" => "",
                "result" => $result
            );
            $this->load->view('includes/header', $data);
            $this->load->view('subject_area/main');
            $this->load->view('includes/footer');
        } else {
            redirect("");
        }
    }

}
