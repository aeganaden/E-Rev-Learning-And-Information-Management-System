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

            $col = 'sl.subject_list_id, sl.subject_list_name, yl.year_level_name';
            $where = array('sl.subject_list_department' => $info['user']->fic_department, 'sl.subject_list_is_active' => 1);
            $join = array(
                array(
                    "year_level as yl", "sl.year_level_id = yl.year_level_id"
                )
            );
            $subject_list = $this->Crud_model->fetch_join2("subject_list as sl", $col, $join, NULL, $where);
//            print_r($subject_list);

            foreach ($subject_list as $subsl) {
                $year_holder[$subsl->year_level_name][] = "—" . $subsl->subject_list_name;
            }
//            print_r($year_holder);

            $data = array(
                "title" => "Subject Area Management",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_f" => "",
                "s_c" => "",
                "s_t" => "",
                "s_s" => "selected-nav",
                "s_co" => "",
                "s_ss" => "",
                "year_holder" => $year_holder
            );
            $this->load->view('includes/header', $data);
            $this->load->view('subject_area/main');
            $this->load->view('includes/footer');
        } else {
            redirect("");
        }
    }

}
