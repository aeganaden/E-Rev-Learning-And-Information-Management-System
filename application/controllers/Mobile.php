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
//        $_POST['department'] = "CE";
        $_POST['department'] = strtoupper($_POST['department']);
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

    public function feedback() {
//        $_POST['identifier'] = "Student";
//        $_POST['firstname'] = "IAN";
//        $_POST['midname'] = "BACULI";
//        $_POST['lastname'] = "AdRe";
//        $_POST['student_id'] = '201511438';
//        $_POST['department'] = "CE";
//        $_POST['offering_id'] = 1;
//        print_r($this->Crud_model->mobile_check("student", "student_id", $like) == true);
//        print_r(strtolower($identifier) == "student");
        $like[0] = "firstname";
        $like[1] = $_POST['firstname'];
        $like[2] = "midname";
        $like[3] = $_POST['midname'];
        $like[4] = "lastname";
        $like[5] = $_POST['lastname'];
        $like[6] = "student_id";
        $like[7] = $_POST['student_id'];
        $identifier = $_POST['identifier'];

        if ($this->Crud_model->mobile_check("student", "student_id", $like) && strtolower($identifier) == "student") {  //checked
            //INITIALIZATION
            $department = $_POST['department'];
            $offering_id = $_POST['offering_id'];

//            $info = $this->session->userdata('userInfo');
//            $student_temp = $this->session->userdata('userInfo')["user"]->student_department;
            $col = array('lecturer.lecturer_id, lecturer.image_path, offering.offering_name, subject.subject_name, CONCAT(lecturer.firstname, " ",lecturer.midname, " ",lecturer.lastname) AS full_name', false);
            $join2 = array('enrollment', 'enrollment.enrollment_id = course.enrollment_id');
            $join1 = array('course', 'course.course_id = offering.course_id');
            $jointype = "INNER";
            $where = array('offering.offering_id' => $offering_id);
            $result_hold = $this->Crud_model->fetch_join('offering', NULL, $join1, $jointype, $join2, $where);  //get the enrollment active of current enrollment base on stud

            if ($result_hold[0]->enrollment_is_active == 1) {          //checks if enrollment of stud is active
                $dept_temp = $this->Crud_model->fetch('professor', array('professor_department' => $department));
                $feedback_status = $dept_temp[0]->professor_feedback_active;
                if ($feedback_status == 1) {                //checks if feedback is open
                    $col = array('lecturer.lecturer_id, lecturer.image_path, offering.offering_name, subject.subject_name, CONCAT(lecturer.firstname, " ",lecturer.midname, " ",lecturer.lastname) AS full_name', false);
                    $join2 = array('lecturer', 'lecturer.lecturer_id = subject.lecturer_id');
                    $join1 = array('subject', 'subject.offering_id = offering.offering_id');
                    $jointype = "INNER";
                    $where = array('subject.offering_id' => $offering_id);
                    $result_hold = $this->Crud_model->fetch_join('offering', $col, $join1, $jointype, $join2, $where);

                    //get active enrollment
                    $col = array("enrollment_id", FALSE);
                    $enrollment = $this->Crud_model->fetch_select("enrollment", $col, array("enrollment_is_active" => 1));

                    $counter = 0;
                    foreach ($result_hold as $val) {              //checks if feedback already done and added to array if so
                        $where = array("lecturer_feedback_department" => $department, "student_id" => $like[7], "lecturer_id" => $val->lecturer_id, "enrollment_id" => $enrollment[0]->enrollment_id);
                        if ($this->Crud_model->fetch("lecturer_feedback", $where)) {
                            $result_hold[$counter]->feedback_done = 1;
                        } else {
                            $result_hold[$counter]->feedback_done = 0;
                        }
                        $counter++;
                    }
                    $result["result"] = $result_hold;     //transfer
                    print_r(json_encode($result));
                } else {
                    $result['message'][0]['message'] = "Feedback is not yet activated";
                    print_r(json_encode($result));
                }
            } else {                //stud's enrollment is inactive
                $result['message'][0]['message'] = "No data";
                print_r(json_encode($result));
            }
        }
    }

}
