<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');

            if (is_array($hold = $this->get_active_enrollment())) {        //checks if this is array, else it is error coz multiple active enrollment
                $enrollment_active = $hold[0]->enrollment_id;

                $col = 'cou.course_id, cou.course_course_title, cou.course_course_code';
                $where = array('cou.enrollment_id' => $enrollment_active, 'cou.course_department' => $info["user"]->professor_department);
                $result = $this->Crud_model->fetch_select("course as cou", $col, $where);
//                echo"<pre>";
//                print_r($result[0]);
                foreach ($result as $key => $res) {
                    $result[$key]->course_id_sha = substr(sha1($res->course_id), 1, 10);
                }

                $data = array(
                    "title" => "Section Management",
                    'info' => $info,
                    "s_h" => "",
                    "s_a" => "",
                    "s_c" => "",
                    "s_f" => "",
                    "result" => $result
                );
                $this->load->view('includes/header', $data);
                $this->load->view('course/main');
                $this->load->view('includes/footer');
            } else {
                echo $hold;
            }
        } else {
            redirect("");
        }
    }

    public function view() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');

            if (is_array($hold = $this->get_active_enrollment())) {        //checks if this is array, else it is error coz multiple active enrollment
                $enrollment_active = $hold[0]->enrollment_id;

                $col = 'cou.course_id, cou.course_course_title, cou.course_course_code';
                $where = array('cou.enrollment_id' => $enrollment_active, 'cou.course_department' => $info["user"]->professor_department, "cou.professor_id" => $info["user"]->professor_id);
                $result = $this->Crud_model->fetch_select("course as cou", $col, $where);
                $segment = $this->uri->segment(3);  //get segment
                $isit = false;                      //holder if it is confirmed
                foreach ($result as $key => $res) {
                    if ($segment == substr(sha1($res->course_id), 1, 10)) {
                        $isit = true;
                        $hold_key = $key;
                        break;
                    }
                }
                if ($isit) {
//                    echo "<pre>";
//                    print_r($result[$hold_key]);
                    $result[$hold_key];
                    $col = 'off.offering_id, off.offering_name';
                    $where = array("off.course_id" => $result[$hold_key]->course_id);

                    $result = $this->Crud_model->fetch_select("offering as off", $col, $where);

                    $data = array(
                        "title" => "Section Management",
                        'info' => $info,
                        "s_h" => "",
                        "s_a" => "",
                        "s_c" => "",
                        "s_f" => "",
                        "result" => $result
                    );
                    $this->load->view('includes/header', $data);
                    $this->load->view('course/view');
                    $this->load->view('includes/footer');
                } else {
                    redirect("Course");
                }
            } else {
                echo $hold;
            }
        }
    }

    private function get_active_enrollment() {
        $where = array("enrollment_is_active" => 1);
        if (count($result = $this->Crud_model->fetch_select("enrollment", NULL, $where)) != 1) {
            return "There are multiple active enrollment.";
        } else {
            return $result;
        }
    }

}
