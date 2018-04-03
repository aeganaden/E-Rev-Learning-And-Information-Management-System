<?php

date_default_timezone_set("Asia/Manila");

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->helper('security');
    }

    public function index() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            $info = $this->session->userdata('userInfo');
            $data = array(
                'title' => "Feedback - Learning Management System | FEU - Institute of Techonology",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_c" => "",
                "s_f" => "selected-nav",
                "s_c" => "",
                "s_t" => "",
                "s_s" => "",
                "s_co" => "",
                "s_ss" => "",
                "s_rc" => "",
                "s_ga" => "",
            );
            $this->load->view('includes/header', $data);

            $col = "professor_feedback_active";
            $where = array(
                "professor_department" => $info["user"]->student_department
            );
            $feedback_is_active = $this->Crud_model->fetch_select("professor", $col, $where);

            //check if active feedback
            if ($feedback_is_active[0]->professor_feedback_active == 1) {
                $col = array('sub.subject_name, sub.subject_id, lec.id_number, lec.firstname, lec.midname, lec.lastname, lec.lecturer_id, lec.image_path, CONCAT(lec.firstname, " ",lec.midname, " ",lec.lastname) AS full_name', FALSE);
                $join = array(
                    array("offering as off", "stud.offering_id = off.offering_id"),
                    array("course as cou", "cou.course_id = off.course_id"),
                    array("subject as sub", "sub.course_id = cou.course_id"),
                    array("lecturer as lec", "lec.lecturer_id = sub.lecturer_id")
                );
                $where = array(
                    "off.offering_id" => $info["user"]->offering_id,
                    "stud.student_num" => $info["user"]->student_num,
                    "cou.enrollment_id" => $info["active_enrollment"]
                );
                $lecturers = $this->Crud_model->fetch_join2("student as stud", $col, $join, NULL, $where);
                if (!empty($lecturers)) {
                    foreach ($lecturers as $sublect) {
                        $lect_ids[] = $sublect->lecturer_id;
                    }
                    $col = "lecturer_id";
                    $where = array(
                        "lecturer_feedback_department" => $info["user"]->student_department,
                        "enrollment_id" => $info["active_enrollment"],
                        "student_id" => $info["user"]->student_id,
                        "offering_id" => $info["user"]->offering_id
                    );
                    $wherein[0] = "lecturer_id";
                    $wherein[1] = $lect_ids;
                    $already_submitted = $this->Crud_model->fetch_select("lecturer_feedback", $col, $where, NULL, NULL, $wherein);

                    //checks if stud already submitted
                    if (!empty($already_submitted)) {   //not yet submitted
                        foreach ($already_submitted as $subalready_submitted) {
                            $counter = 0;
                            if (in_array($subalready_submitted->lecturer_id, $lect_ids)) {
                                $already_submitted[$counter]->sent_feedback = 1;

                                foreach ($lecturers as $sublecturers) {
                                    $lecturers[$counter]->sent_feedback = 1;
                                    $counter++;
                                }
                            }
                        }
                    }
                    $data = array(
                        "lect" => $lecturers
                    );
                    $this->load->view('feedback/feedback_main', $data);
                } else {
                    $data = array(
                        "lect" => "no lect"
                    );
                    $this->load->view('feedback/feedback_main', $data);
                }
            } else {                        //not active feedback
                $this->load->view('feedback/error');
                $this->load->view('feedback/custom4');
            }
        } else if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") { //show to fic
            $info = $this->session->userdata('userInfo');
            $data = array(
                'title' => "Feedback",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_c" => "",
                "s_f" => "selected-nav",
                "s_c" => "",
                "s_t" => "",
                "s_s" => "",
                "s_co" => "",
                "s_ss" => "",
                "s_rc" => "",
                "s_ga" => ""
            );
            $this->load->view('includes/header', $data);

            // GET THE ACTIVE ENROLLMENT
            $col = array('course_id');
            if ($temp = $this->Crud_model->fetch_select('course', $col, array('enrollment_id' => $info["active_enrollment"], 'course_department' => $info["user"]->fic_department))) {

                $wherein[0] = 'course_id';
                foreach ($temp as $temp2) {
                    $wherein[1][] = $temp2->course_id;
                }

                //******GET THE SECTION**********
                $col = array('offering_id', 'offering_name');
                $where = array('fic_id' => $info["user"]->fic_id);
                if ($sections = $this->Crud_model->fetch_select('offering', $col, $where, NULL, NULL, $wherein)) {

                    //******GET THE LECT ID**********
                    foreach ($sections as $section) {
                        $hold[0][] = $section->offering_id;
                    }
                    $validation[0] = $hold[0];
                    $validation[0][] = "all";

                    $col = 'lecturer_id';
                    $where = array('lecturer_feedback_department' => $info["user"]->fic_department, 'enrollment_id' => $info['active_enrollment']);
                    $lect_id = $this->Crud_model->fetch_select('lecturer_feedback', $col, $where, $hold[0], TRUE);
                    if (!empty($lect_id)) {
//******FETCH THE LECTS USING ID**********
                        unset($hold);       //erase the data fetched from above
                        $hold[0] = 'lecturer_id';
                        foreach ($lect_id as $temp) {
                            $hold[1][] = $temp->lecturer_id;           //recreate $hold
                        }
                        $validation[1] = $hold[1];   //lecturer_id
                        $validation[1][] = "all";
                        $col = array('lecturer_id', 'firstname', 'midname', 'lastname', 'image_path');
                        $where = array('lecturer_feedback_department' => $info["user"]->fic_department, 'enrollment_id' => $info['active_enrollment']);
                        $lect = $this->Crud_model->fetch_select('lecturer', $col, NULL, $hold);

                        $counter = 0;
                        $temp = $validation;

                        if (!isset($_POST['section']) && !isset($_POST['lecturer'])) {
                            $data = array(
                                'sections' => $sections,
                                'lecturers' => $lect
                            );
                            $this->load->view('feedback/fic_view2', $data);
                        } else if (isset($_POST['section']) && isset($_POST['lecturer'])) {         //kung nakaselect na
                            if (in_array($_POST['section'], $temp[0]) && in_array($_POST['lecturer'], $temp[1])) {
                                $sel_section = $_POST['section'];
                                $sel_lecturer = $_POST['lecturer'];
//                    $result = array();
                                if (strcasecmp("all", $sel_section) == 0 && strcasecmp("all", $sel_lecturer) == 0) {
                                    $where = array('lecturer_feedback_department' => $info["user"]->fic_department);
                                } else if (strcasecmp("all", $sel_section) == 0) {
                                    $where = array('lecturer_feedback_department' => $info["user"]->fic_department, 'lecturer_id' => $sel_lecturer);
                                } else if (strcasecmp("all", $sel_lecturer) == 0) {
                                    $where = array('lecturer_feedback_department' => $info["user"]->fic_department, 'offering_id' => $sel_section);
                                } else {
                                    $where = array('lecturer_feedback_department' => $info["user"]->fic_department, 'offering_id' => $sel_section, 'lecturer_id' => $sel_lecturer);
                                }
                                $col = array('lecturer_feedback_timedate', 'lecturer_feedback_comment', 'lecturer_id', 'offering_id');
                                $result = $this->Crud_model->fetch_select('lecturer_feedback', $col, $where);

                                $counter = 0;
                                if (!empty($result)) {
                                    $result_hold = array();
                                    foreach ($result as $res) {
                                        //checks xss
                                        if (strpos(strtolower($res->lecturer_feedback_comment), '<script>') !== false &&
                                                strpos(strtolower($res->lecturer_feedback_comment), '</script>') !== false) {
                                            $result[$counter]->lecturer_feedback_comment = $this->security->xss_clean($res->lecturer_feedback_comment) .
                                                    "<br><span class='red-text'>(Possible Cross-Site Scripting attack)</span>";
                                        } else {
                                            $result[$counter]->lecturer_feedback_comment = $this->security->xss_clean($res->lecturer_feedback_comment);
                                        }
                                        $counter++;

                                        foreach ($sections as $section) {
                                            if ($section->offering_id == $res->offering_id) {
                                                $res->offering_id = $section->offering_name;
                                                foreach ($lect as $lect2) {
                                                    if ($lect2->lecturer_id == $res->lecturer_id) {
                                                        $res->lecturer_id = $lect2->firstname . " " . $lect2->midname . " " . $lect2->lastname;
                                                        $res->image_path = $lect2->image_path;
                                                    }
                                                }
                                                $result_hold[] = $res;
                                                break;              //just for faster iteration
                                            }
                                        }
                                    }

                                    $data = array(
                                        'sections' => $sections,
                                        'lecturers' => $lect,
                                        'feedback' => $result
                                    );
                                    $this->load->view('feedback/fic_view2', $data);
                                } else {
                                    $data = array(
                                        'sections' => $sections,
                                        'lecturers' => $lect,
                                        'feedback' => $result
                                    );
                                    $this->load->view('feedback/fic_view2', $data);
                                }
                            } else {
                                $data = array(
                                    'sections' => $sections,
                                    'lecturers' => $lect,
                                    'error' => "Invalid Input"
                                );
                                $this->load->view('feedback/fic_view2', $data);
                            }
                        } else {
                            redirect("Feedback");
                        }
                    } else {
                        redirect("Feedback");
                    }
                } else {
                    $data = array(
                        'sections' => null,
                        'lecturers' => null
                    );
                    $this->load->view('feedback/fic_view2', $data);
                }
            } else {
                $info = $this->session->userdata('userInfo');

                $ident = $info['identifier'];
                $ident.="_department";
                $program = 0;

                switch ($info['user']->$ident) {
                    case 'CE':
                        $program = 1;
                        break;
                    case 'ECE':
                        $program = 2;
                        break;
                    case 'EE':
                        $program = 3;
                        break;
                    case 'ME':
                        $program = 4;
                        break;

                    default:
                        break;
                }


                if ($info['logged_in'] && $info['identifier'] != "administrator") {
                    $data = array(
                        "title" => "Home - Learning Management System | FEU - Institute of Techonology",
                        "info" => $info,
                        "program" => $program,
                        "s_h" => "selected-nav",
                        "s_a" => "",
                        "s_f" => "",
                        "s_c" => "",
                        "s_t" => "",
                        "s_s" => "",
                        "s_co" => "",
                        "s_ss" => "",
                        "s_ga" => "",
                        "s_rc" => "",
                    );
                    $this->load->view('includes/header', $data);

                    $this->load->view('includes/home-sidenav');
                    $this->load->view('includes/home-navbar');


                    $data_c = array(
                        "message_l" => "No feedback available yet",
                        "message_r" => "",
                    );
                    $this->load->view('chibi/err-sad.php', array("data" => $data_c));

                    $this->load->view('includes/footer');
                } elseif ($info['identifier'] == "administrator") {
                    redirect('Admin');
                } else {
                    redirect('Welcome', 'refresh');
                }


                $this->load->view('includes/footer');
            }
        } else if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") { //show to prof
            $info = $this->session->userdata('userInfo');
            $data = array('title' => "Feedback",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_c" => "",
                "s_f" => "selected-nav",
                "s_c" => "",
                "s_t" => "",
                "s_s" => "",
                "s_co" => "",
                "s_ss" => "",
                "s_rc" => "",
                "s_ga" => ""
            );
            $this->load->view('includes/header', $data);

//******GET THE SECTION**********
            $col = array('course_id');
            if ($temp = $this->Crud_model->fetch_select('course', $col, array('enrollment_id' => $info["active_enrollment"], 'course_department' => $info["user"]->professor_department))) {

                $col = array('offering_id', 'offering_name');
                $where = array('offering_department' => $info["user"]->professor_department);
                $wherein[0] = 'course_id';
                foreach ($temp as $temp2) {
                    $wherein[1][] = $temp2->course_id;
                }
                $sections = $this->Crud_model->fetch_select('offering', $col, $where, NULL, NULL, $wherein);
                unset($temp);

                //******GET THE SECTION - END**********
                //******GET THE LECT ID**********
                $col = array('lecturer.lecturer_id, lecturer.image_path, CONCAT(lecturer.firstname, " ",lecturer.midname, " ",lecturer.lastname) AS full_name', FALSE);
                $join2 = array('lecturer', 'lecturer.lecturer_id = subject.lecturer_id');
                $join1 = array('subject', 'subject.course_id = course.course_id');
                $jointype = "INNER";
                $where = array('course.course_department' => $info["user"]->professor_department);

                if ($lecturers = $this->Crud_model->fetch_join('course', $col, $join1, $jointype, $join2, $where, TRUE)) {
                    //******GET THE LECT ID - END**********

                    foreach ($sections as $sec) {
                        $temp[0][] = $sec->offering_id;
                    }
                    foreach ($lecturers as $lect) {
                        $temp[1][] = $lect->lecturer_id;
                    }
                    $temp[0][] = 'all';
                    $temp[1][] = 'all';

                    if (!isset($_POST['section']) && !isset($_POST['lecturer'])) {
                        $data = array(
                            'sections' => $sections,
                            'lecturers' => $lecturers
                        );
                        $this->load->view('feedback/prof_view', $data);
                    } else if (isset($_POST['section']) && isset($_POST['lecturer'])) {         //kung nakaselect na
                        if (in_array($_POST['section'], $temp[0]) && in_array($_POST['lecturer'], $temp[1])) {
                            $sel_section = $_POST['section'];
                            $sel_lecturer = $_POST['lecturer'];
//                    $result = array();
                            if (strcasecmp("all", $sel_section) == 0 && strcasecmp("all", $sel_lecturer) == 0) {
                                $where = array('lecturer_feedback_department' => $info["user"]->professor_department, 'enrollment_id' => $info["active_enrollment"]);
                            } else if (strcasecmp("all", $sel_section) == 0) {
                                $where = array('lecturer_feedback_department' => $info["user"]->professor_department, 'lecturer.lecturer_id' => $sel_lecturer, 'enrollment_id' => $info["active_enrollment"]);
                            } else if (strcasecmp("all", $sel_lecturer) == 0) {
                                $where = array('lecturer_feedback_department' => $info["user"]->professor_department, 'offering.offering_id' => $sel_section, 'enrollment_id' => $info["active_enrollment"]);
                            } else {
                                $where = array('lecturer_feedback_department' => $info["user"]->professor_department, 'offering.offering_id' => $sel_section, 'lecturer.lecturer_id' => $sel_lecturer, 'enrollment_id' => $info["active_enrollment"]);
                            }
                            $col = array('lecturer_feedback.lecturer_feedback_timedate, lecturer_feedback.lecturer_feedback_comment, CONCAT(lecturer.firstname, " ",lecturer.midname, " ",lecturer.lastname) AS full_name, offering.offering_name, lecturer.image_path', FALSE);

                            $join1 = array('lecturer', 'lecturer.lecturer_id = lecturer_feedback.lecturer_id');
                            $join2 = array('offering', 'offering.offering_id = lecturer_feedback.offering_id');
                            $jointype = "INNER";
                            $result = $this->Crud_model->fetch_join('lecturer_feedback', $col, $join1, $jointype, $join2, $where);

                            $counter = 0;
                            foreach ($result as $subresult) {
                                if (strpos(strtolower($subresult->lecturer_feedback_comment), '<script>') !== false &&
                                        strpos(strtolower($subresult->lecturer_feedback_comment), '</script>') !== false) {
                                    $result[$counter]->lecturer_feedback_comment = $this->security->xss_clean($subresult->lecturer_feedback_comment) .
                                            "<br><span class='red-text'>(Possible Cross-Site Scripting attack)</span>";
                                } else {
                                    $result[$counter]->lecturer_feedback_comment = $this->security->xss_clean($subresult->lecturer_feedback_comment);
                                }

                                $counter++;
                            }
                            $data = array(
                                'sections' => $sections,
                                'lecturers' => $lecturers,
                                'feedback' => $result
                            );
                            $this->load->view('feedback/prof_view', $data);
                        } else {
                            $data = array(
                                'sections' => $sections,
                                'lecturers' => $lecturers,
                                'error' => "Invalid Input"
                            );
                            $this->load->view('feedback/prof_view', $data);
                        }
                    } else {
                        redirect("Feedback");
                    }
                } else {
                    $data = array(
                        'sections' => null,
                        'lecturers' => null
                    );
                    $this->load->view('feedback/prof_view', $data);
                }
            } else {
                $data = array(
                    'sections' => null,
                    'lecturers' => null
                );
                $this->load->view('feedback/prof_view', $data);
            }
        } else {
            redirect("");
        }

        $this->load->view('includes/footer');
    }

    public function content() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            $segment = $this->uri->segment(3);
            if (!empty($segment) && is_numeric($segment)) {
                $info = $this->session->userdata('userInfo');
                $data = array(//gonna need to put this for header
                    'title' => "Feedback",
                    'info' => $info,
                    "s_h" => "",
                    "s_a" => "",
                    "s_c" => "",
                    "s_f" => "selected-nav",
                    "s_c" => "",
                    "s_t" => "",
                    "s_s" => "",
                    "s_co" => "",
                    "s_ss" => "",
                    "s_rc" => "",
                    "s_ga" => "",
                );

                /* NEED TO CHECK IF THE STUD ALREADY SUBMITTED A FEEDBACK BASE ON SEGMENT */

                $this->load->view('includes/header', $data);
                $col = "professor_feedback_active";
                $where = array(
                    "professor_department" => $info["user"]->student_department
                );
                $feedback_is_active = $this->Crud_model->fetch_select("professor", $col, $where);

                //check if active feedback
                if ($feedback_is_active[0]->professor_feedback_active == 1) {
                    $col = 'lec.lecturer_expertise, lec.id_number, lec.firstname, lec.midname, lec.lastname, lec.lecturer_id, lec.image_path';
                    $join = array(
                        array("offering as off", "stud.offering_id = off.offering_id"),
                        array("course as cou", "cou.course_id = off.course_id"),
                        array("subject as sub", "sub.course_id = cou.course_id"),
                        array("lecturer as lec", "lec.lecturer_id = sub.lecturer_id")
                    );
                    $where = array(
                        "off.offering_id" => $info["user"]->offering_id,
                        "stud.student_num" => $info["user"]->student_num,
                        "cou.enrollment_id" => $info["active_enrollment"],
                        "lec.lecturer_id" => $segment
                    );
                    $lecturers = $this->Crud_model->fetch_join2("student as stud", $col, $join, NULL, $where);
                    if (!empty($lecturers)) {
                        $data = array(
                            'lect' => $lecturers[0]
                        );
                        $this->load->view('feedback/feedback_content', $data);
                    } else {                    //wrong segment
                        redirect("Feedback");
                    }
                } else {
                    redirect("Feedback");
                }
            } else {
                $this->load->view('feedback/error');
                $this->load->view('feedback/custom4');
            }
            $this->load->view('includes/footer');
        } else {
            redirect();
        }
    }

    public function submit() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            $segment = $this->uri->segment(3);
            $info = $this->session->userdata('userInfo');
            $data = array(//gonna need to put this for header
                'title' => "Feedback",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_c" => "",
                "s_f" => "selected-nav",
                "s_c" => "",
                "s_t" => "",
                "s_s" => "",
                "s_co" => "",
                "s_ss" => "",
                "s_rc" => "",
                "s_ga" => "",
            );
            $this->load->view('includes/header', $data);

            if (!empty($segment) && is_numeric($segment)) {
                $col = 'lec.lecturer_expertise, lec.id_number, lec.firstname, lec.midname, lec.lastname, lec.lecturer_id, lec.image_path';
                $join = array(
                    array("offering as off", "stud.offering_id = off.offering_id"),
                    array("course as cou", "cou.course_id = off.course_id"),
                    array("subject as sub", "sub.course_id = cou.course_id"),
                    array("lecturer as lec", "lec.lecturer_id = sub.lecturer_id")
                );
                $where = array(
                    "off.offering_id" => $info["user"]->offering_id,
                    "stud.student_num" => $info["user"]->student_num,
                    "cou.enrollment_id" => $info["active_enrollment"],
                    "lec.lecturer_id" => $segment
                );
                $lecturers = $this->Crud_model->fetch_join2("student as stud", $col, $join, NULL, $where);
                if (!empty($lecturers)) {
                    $this->form_validation->set_rules('feedback_content', "feedback", "required|min_length[10]|max_length[500]");
                    if ($this->form_validation->run() == FALSE) {       //wrong
                        $data = array(
                            'lect' => $lecturers[0]
                        );
                        $this->load->view('feedback/feedback_content', $data);
                        $this->load->view('includes/footer');
                    } else {
                        $data = array(
                            'lecturer_feedback_timedate' => time(),
                            'lecturer_feedback_comment' => $this->input->post('feedback_content'),
                            'lecturer_feedback_department' => $this->session->userdata('userInfo')['user']->student_department,
                            'student_id' => $this->session->userdata('userInfo')['user']->student_id,
                            'lecturer_id' => $segment,
                            'enrollment_id' => $this->session->userdata('userInfo')['active_enrollment'],
                            'offering_id' => $this->session->userdata('userInfo')['user']->offering_id
                        );
                        $this->Crud_model->insert('lecturer_feedback', $data);
                        redirect('Feedback');
                    }
                } else {
                    redirect("Feedback");
                }
            } else {
                redirect("Feedback");
            }
        } else {
            redirect();
        }
    }

    public function activateFeedback() {

        $info = $this->session->userdata('userInfo');
        $ident = $info['identifier'];
        $ident.="_department";
        $program = 0;

        switch ($info['user']->$ident) {
            case 'CE':
                $program = 1;
                break;
            case 'ECE':
                $program = 2;
                break;
            case 'EE':
                $program = 3;
                break;
            case 'ME':
                $program = 4;
                break;

            default:
                break;
        }

        $data = array(
            "title" => "Feedback - Learning Management System | FEU - Institute of Techonology",
            "info" => $info,
            "program" => $program,
            "s_h" => "",
            "s_a" => "",
            "s_f" => "",
            "s_c" => "",
            "s_c" => "",
            "s_t" => "selected-nav",
            "s_s" => "",
            "s_co" => "",
            "s_ss" => "",
            "s_rc" => "",
            "s_ga" => "",
        );
        $this->load->view('includes/header', $data);
        $this->load->view('feedback/feedback_prof_activation');
        $this->load->view('includes/footer');
    }

    public function credentialChecking() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $data = array(
            "username" => $username,
            "password" => $password,
        );

        if ($this->Crud_model->fetch("professor", $data)) {
            echo json_encode(true);
        } else {
            echo json_encode("No account found");
        }
    }

    public function check_status_feedback() {
        $prof_id = $this->input->post("prof_id");
        $data = $this->Crud_model->fetch("professor", array("professor_id" => $prof_id));
        $data = $data[0];
        if ($data) {
            echo json_encode($data->professor_feedback_active);
        }
    }

    public function update_status_feedback() {
        $prof_id = $this->input->post("prof_id");
        $value = $this->input->post("value");
        $data = array(
            "professor_feedback_active" => $value,
        );

        if ($this->Crud_model->update("professor", $data, array("professor_id" => $prof_id))) {
            echo json_encode(true);
        } else {
            echo json_encode("Error Updating Feedback Module Status");
        }
    }

}
