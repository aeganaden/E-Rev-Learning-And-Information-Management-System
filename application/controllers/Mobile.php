<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
    }

    public function login() {
        $_POST['username'] = "riza";
        $_POST['password'] = "riza";
        $where = array(
            "username" => $_POST['username'],
            "password" => $_POST['password']
        );

        if ($result['result'] = $this->Crud_model->fetch_array("student", NULL, $where)) {
            $result['result'][0]['full_name'] = ucwords(strtolower($result['result'][0]['firstname'] . " " . $result['result'][0]['midname'] . " " . $result['result'][0]['lastname']));
            $result['result'][0]['identifier'] = "Student";
            $result['result'][0]['offering_id'];

            /* GETS THE ENROLLMENT ID OF STUD'S ENROLLMENT ID */
            $col = array('enrollment.enrollment_id', false);
            $join2 = array('enrollment', 'enrollment.enrollment_id = course.enrollment_id');
            $join1 = array('course', 'course.course_id = offering.course_id');
            $jointype = "INNER";
            $where = array('enrollment.enrollment_is_active' => 1, "offering.offering_id" => $result['result'][0]['offering_id']);
            $result_hold = $this->Crud_model->fetch_join('offering', $col, $join1, $jointype, $join2, $where);
            $result['result'][0]['enrollment_id'] = $result_hold[0]->enrollment_id;     //store the id of stud's enrollment
//            echo "<pre>";
//            print_r($result);

            print_r(json_encode($result));
        } else if ($result['result'] = $this->Crud_model->fetch_array("fic", NULL, $where)) {
            if ($result['result'][0]['fic_status'] == 1) {
                $result['result'][0]['full_name'] = ucwords($result['result'][0]['firstname'] . " " . $result['result'][0]['midname'] . " " . $result['result'][0]['lastname']);
                $result['result'][0]['identifier'] = "Faculty in Charge";

                /* GETS THE ENROLLMENT ID OF STUD'S ENROLLMENT ID */
                $col = array('enrollment.enrollment_id', false);
                $join2 = array('enrollment', 'enrollment.enrollment_id = course.enrollment_id');
                $join1 = array('course', 'course.course_id = offering.course_id');
                $jointype = "INNER";
                $where = array('enrollment.enrollment_is_active' => 1, "offering.fic_id" => $result['result'][0]['fic_id']);
                $result_hold = $this->Crud_model->fetch_join('offering', $col, $join1, $jointype, $join2, $where);
                $result['result'][0]['enrollment_id'] = $result_hold[0]->enrollment_id;     //store the id of stud's enrollment

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
//        $_POST['identifier'] = "FaCuLtY In cHarGe";
//        $_POST['firstname'] = "rIza";
//        $_POST['midname'] = "bLossOm";
//        $_POST['lastname'] = "mAlaYa";
//        $_POST['id'] = '1';
//        $_POST['department'] = "CE";
//        $_POST['offering_id'] = 1;

        $like[0] = "firstname";
        $like[1] = $_POST['firstname'];
        $like[2] = "midname";
        $like[3] = $_POST['midname'];
        $like[4] = "lastname";
        $like[5] = $_POST['lastname'];
        $identifier = $_POST['identifier'];
        if (strtolower($identifier) == "student") {
            $like[6] = "student_id";
        } else if (strtolower($identifier) == "faculty in charge") {
            $like[6] = "fic_id";
        }
        $like[7] = $_POST['id'];

        if (strtolower($identifier) == "student" && $this->Crud_model->mobile_check("student", "student_id", $like)) {
            //INITIALIZATION
            $department = $_POST['department'];
            $offering_id = $_POST['offering_id'];

//            $info = $this->session->userdata('userInfo');
//            $student_temp = $this->session->userdata('userInfo')["user"]->student_department;
            $col = array('enrollment.enrollment_is_active', false);
            $join2 = array('enrollment', 'enrollment.enrollment_id = course.enrollment_id');
            $join1 = array('course', 'course.course_id = offering.course_id');
            $jointype = "INNER";
            $where = array('offering.offering_id' => $offering_id);
            $result_hold = $this->Crud_model->fetch_join('offering', $col, $join1, $jointype, $join2, $where);  //get the enrollment active of current enrollment base on stud

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
        } else if (strtolower($identifier) == "faculty in charge" && $this->Crud_model->mobile_check("fic", "fic_id", $like)) {

            $department = $_POST['department'];

            $col = array('lecturer.lecturer_id, lecturer.image_path, lecturer_expertise, CONCAT(lecturer.firstname, " ",lecturer.midname, " ",lecturer.lastname) AS full_name', FALSE);
            $join2 = array('offering', 'offering.offering_id = subject.offering_id');
            $join1 = array('subject', 'subject.lecturer_id = lecturer.lecturer_id');
            $jointype = "INNER";
            $where = array('offering.offering_department' => $department);
            if ($result_hold = $this->Crud_model->fetch_join('lecturer', $col, $join1, $jointype, $join2, $where, TRUE)) {
                $result["result"] = $result_hold;
                print_r(json_encode($result));
            } else {
                $result['message'][0]['message'] = "No data";
                print_r(json_encode($result));
            }
        }
    }

    public function feedback_fetch() {
//        $_POST['lect_id'] = 1;
//        $_POST['stud_id'] = 201511281;
        $_POST['department'] = "CE";
//        $_POST['enrollment_id'] = 1;
//        $_POST['offering_id'] = 1;

        $_POST['identifier'] = "Faculty in Charge";
        $_POST['lect_id'] = 1;
        $_POST['lower_limit'] = 0;
        $_POST['higher_limit'] = 3;
        $_POST['enrollment_id'] = 1;
        $_POST['sort'] = "ASC";

        $identifier = $_POST['identifier'];
        $department = $_POST['department'];
        if (strtolower($identifier) == "student") {
            $lect_id = $_POST['lect_id'];
            $stud_id = $_POST['stud_id'];
            $enrollment_id = $_POST['enrollment_id'];
            $offering_id = $_POST['offering_id'];

            $where = array("lecturer_feedback_department" => $department, "student_id" => $stud_id, "lecturer_id" => $lect_id, "enrollment_id" => $enrollment_id, "offering_id" => $offering_id);
            $result_hold = $this->Crud_model->fetch("lecturer_feedback", $where);
            if ($this->Crud_model->fetch("lecturer_feedback", $where)) {      //already submitted
                $result['message'][0]['message'] = "Feedback already submitted";
                print_r(json_encode($result));
            } else {                        //get the expertise of lecturer
                $result_hold1 = $this->Crud_model->fetch_select("lecturer", array("lecturer_expertise", FALSE), array("lecturer_id" => $lect_id));
                $result["result"][0]["lecturer_expertise"] = $result_hold1[0]->lecturer_expertise;

                print_r(json_encode($result));
            }
        } else if (strtolower($identifier) == "faculty in charge") {
            $lect_id = $_POST['lect_id'];
            $enrollment_id = $_POST['enrollment_id'];
            $low = $_POST['lower_limit'];
            $high = $_POST['higher_limit'];
            $sort = strtoupper($_POST['sort']);

            $where = array(
                'lecturer_id' => $lect_id,
                'enrollment_id' => $enrollment_id,
                'lecturer_feedback_department' => $department
            );
            $orderby = array("lecturer_feedback_timedate", $sort);
            $limit = array($high, $low);
            $result = $this->Crud_model->fetch_select('lecturer_feedback', NULL, $where, NULL, NULL, NULL, NULL, NULL, $orderby, $limit);

            foreach ($result as $key) {
                $result[$key]->date = date("M d, Y | g:i A", $key->lecturer_feedback_timedate);
            }

            echo "<pre>";
            print_r($result);
        }
    }

    public function feedback_submit() {
        $lect_id = $_POST['lect_id'];
        $stud_id = $_POST['stud_id'];
        $department = $_POST['department'];
        $enrollment_id = $_POST['enrollment_id'];
        $offering_id = $_POST['offering_id'];
        $content = $_POST["content"];

        $data = array(
            "lecturer_feedback_timedate" => time(),
            "lecturer_feedback_department" => $department,
            "lecturer_feedback_comment" => $content,
            "student_id" => $stud_id,
            "lecturer_id" => $lect_id,
            "enrollment_id" => $enrollment_id,
            "offering_id" => $offering_id
        );
        if ($this->Crud_model->insert("lecturer_feedback", $data) > 0) {        //if successful
            $result['result'][0]['result'] = "Successful";
            print_r(json_encode($result));
        } else {
            $result['message'][0]['message'] = "Submitting failed";
            print_r(json_encode($result));
        }
    }

}
