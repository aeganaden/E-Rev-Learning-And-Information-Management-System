<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SubjectArea extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');

            $col = 'sl.subject_list_id, sl.subject_list_name, yl.year_level_name, yl.year_level_id';
            $where = array('sl.subject_list_department' => $info['user']->professor_department, 'sl.subject_list_is_active' => 1);
            $join = array(
                array(
                    "year_level as yl", "sl.year_level_id = yl.year_level_id"
                )
            );
            $subject_list = $this->Crud_model->fetch_join2("subject_list as sl", $col, $join, NULL, $where);

            foreach ($subject_list as $subsl) {
                $year_holder[$subsl->year_level_id][$subsl->year_level_name][] = "— " . $subsl->subject_list_name;
            }

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

    public function view() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            if (!empty($segment = $this->uri->segment(3)) && is_numeric($segment)) {    //course_id
                $info = $this->session->userdata('userInfo');

//                $col = 'sl.subject_list_id, sl.subject_list_name, yl.year_level_name, yl.year_level_id';
                $col = "tl.topic_list_id, tl.topic_list_name";
                $where = array(
                    'sl.subject_list_department' => $info['user']->professor_department,
                    'sl.subject_list_is_active' => 1,
                    'sl.year_level_id' => $segment
                );
                $join = array(
                    array("year_level as yl", "sl.year_level_id = yl.year_level_id"),
                    array("subject_list_has_topic_list as sltl", "sl.subject_list_id = sltl.subject_list_id"),
                    array("topic_list as tl", "tl.topic_list_id = sltl.topic_list_id")
                );
                $topic_list = $this->Crud_model->fetch_join2("subject_list as sl", $col, $join, NULL, $where);
                //LAST - FORMATTING OF TOPICS
//                echo "<pre>";
//                print_r($topic_list);
//                echo "</pre>";
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
                    "topic_list" => $topic_list
                );
                $this->load->view('includes/header', $data);
                $this->load->view('subject_area/view');
                $this->load->view('includes/footer');
            } else {
                redirect("SubjectArea");
            }
        } else {
            redirect();
        }
    }

}
