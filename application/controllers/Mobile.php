<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
    }

    public function login() {
//        $_POST['username'] = "mgbabaran";
//        $_POST['password'] = "mark";
        $where = array(
            "username" => $_POST['username'],
            "password" => $_POST['password']
        );

        if ($result['result'] = $this->Crud_model->fetch_array("student", NULL, $where)) {
            $result['result'][0]['full_name'] = ucwords($result['result'][0]['firstname'] . " " . $result['result'][0]['midname'] . " " . $result['result'][0]['lastname']);
            $result['result'][0]['identifier'] = "Student";
            print_r(json_encode($result));
        } else if ($result['result'] = $this->Crud_model->fetch_array("fic", NULL, $where)) {
            $result['result'][0]['full_name'] = ucwords($result['result'][0]['firstname'] . " " . $result['result'][0]['midname'] . " " . $result['result'][0]['lastname']);
            $result['result'][0]['identifier'] = "Faculty in Charge";
            if ($result['result'][0]['fic_status'] == 1) {
                print_r(json_encode($result));
            } else {
                print_r("");
            }
        } else if ($result['result'] = $this->Crud_model->fetch_array("prof", NULL, $where)) {
            $result['result'][0]['full_name'] = ucwords($result['result'][0]['firstname'] . " " . $result['result'][0]['midname'] . " " . $result['result'][0]['lastname']);
            $result['result'][0]['identifier'] = "Professor";
            print_r(json_encode($result));
        } else {
            print_r("");
        }
    }

    public function announcement() {
        $_POST['department'] = "CE";
        /*
         * 1 = CE
         * 2 = ECE
         * 3 = EE
         * 4 = ME
         */
        $temp = 0;
        switch ($_POST['department']) {
            case "CE":
                $temp = 1;
                break;
            case "ECE":
                $temp = 2;
                break;
            case "EE":
                $temp = 3;
                break;
            case "ME":
                $temp = 4;
                break;
        }

        $where = array(
            "announcement_end_datetime >" => strtotime("now"),
            "announcement_is_active" => 1
        );
        $col = array(
            "announcement_title", "announcement_content", "announcement_created_at", "announcement_end_datetime", "announcement_start_datetime", "announcement_announcer"
        );

        $like[0] = "announcement_audience";
        $like[1] = "$temp";
        $orderby[0] = "announcement_created_at";
        $orderby[1] = "DESC";
        if ($result['result'] = $this->Crud_model->fetch_select("announcement", $col, $where, NULL, NULL, NULL, $like, true, $orderby)) {
            foreach ($result['result'] as $key => $res) {
                $result['result'][$key]['announcement_created_at'] = date("M d, Y | g:i A", $res["announcement_created_at"]);
                $result['result'][$key]['announcement_end_datetime'] = date("M d, Y | g:i A", $res["announcement_end_datetime"]);
                $result['result'][$key]['announcement_start_datetime'] = date("M d, Y | g:i A", $res["announcement_start_datetime"]);
            }
            print_r(json_encode($result));
        } else {
            print_r("");
        }
    }

    public function feedback() {            //LAST - need to change source vars
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            $info = $this->session->userdata('userInfo');
            $student_temp = $this->session->userdata('userInfo')["user"]->student_department;
            $dept_temp = $this->Crud_model->fetch('professor', array('professor_department' => $student_temp));
            $feedback_status = $dept_temp[0]->professor_feedback_active;

            if ($feedback_status == 1) {                //checks if feedback is open
                $error = true;          //error holder
                $user_hold = $this->session->userdata('userInfo')['user'];
                $user_id = $user_hold->offering_id;
                $course_hold2 = $this->Crud_model->fetch('offering', array('offering_id' => $user_id))[0]->course_id;
                $course_hold = $this->Crud_model->fetch('course', array('course_id' => $course_hold2))[0];
                $enrollment_hold = $this->Crud_model->fetch('enrollment', array('enrollment_id' => $course_hold->enrollment_id))[0];
                if (empty($enrollment_hold) != 1) {       //check the fetched table and if it is active
                    if ($enrollment_hold->enrollment_is_active == 0) {
                        $result['message'][0]['content'] = "No data";
                        print_r(json_encode($result));
                    }
                }

                if ($error) {
                    $subject_hold = $this->Crud_model->fetch('subject', array('offering_id' => $user_id));
                    $lect = array();
                    $inner_counter = 0;
                    if (empty($subject_hold) != 1) {
                        foreach ($subject_hold as $subject) {
                            $lect_id = $subject->lecturer_id;
                            $lect_hold = $this->Crud_model->fetch('lecturer', array('lecturer_id' => $lect_id))[0];
                            $lect_hold->topic = $subject_hold[$inner_counter]->subject_name;
                            if ($this->Crud_model->fetch('lecturer_feedback', array('lecturer_id' => $lect_id, 'student_id' => $user_hold->student_id))[0]) {
                                $lect_hold->sent_feedback = 1;
                            } else {
                                $lect_hold->sent_feedback = 0;
                            }
                            array_push($lect, $lect_hold);
                            $inner_counter++;
                        }

                        $data = array(
                            'title' => "Feedback",
                            "s_h" => "",
                            "s_a" => "",
                            "s_c" => "",
                            "s_f" => "selected-nav",
                            'info' => $info,
                            'lect' => $lect,
                        );
                        $this->load->view('feedback/feedback_main', $data);
                    } else {
                        $this->load->view('feedback/feedback_main', $data);
                        include(APPPATH . 'views\feedback\custom3.php');
                    }
                }
            } else {
                $result['result'][0]['message'] = "Feedbcak is not yet activated";
                print_r(json_encode($result));
            }
        }
    }

}
