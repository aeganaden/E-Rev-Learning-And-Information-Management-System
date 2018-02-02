<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->helper('date');
        $this->load->library('form_validation');
    }

    public function index() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            $info = $this->session->userdata('userInfo');
            $student_temp = $this->session->userdata('userInfo')["user"]->student_department;
            $dept_temp = $this->Crud_model->fetch('professor', array('professor_department' => $student_temp));
            $feedback_status = $dept_temp[0]->professor_feedback_active;
            $data = array(
                'title' => "Feedback",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_c" => "",
                "s_f" => "selected-nav",
                "s_f" => "selected-nav"
            );
            $this->load->view('includes/header', $data);
            if ($feedback_status == 1) {                //checks if feedback is open
                $error = true;          //error holder
                $user_hold = $this->session->userdata('userInfo')['user'];
                $user_id = $user_hold->offering_id;
                $course_hold2 = $this->Crud_model->fetch('offering', array('offering_id' => $user_id))[0]->course_id;
                $course_hold = $this->Crud_model->fetch('course', array('course_id' => $course_hold2))[0];
                $enrollment_hold = $this->Crud_model->fetch('enrollment', array('enrollment_id' => $course_hold->enrollment_id))[0];
                if (empty($enrollment_hold) != 1) {       //check the fetched table and if it is active
                    if ($enrollment_hold->enrollment_is_active == 0) {
                        $error = false;
                        $this->load->view('feedback/feedback_main', $data);
                        include(APPPATH . 'views\feedback\custom1.php');
                    }
                }

                if ($error) {
                    $subject_hold = $this->Crud_model->fetch('subject', array('offering_id' => $user_id)); //error
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
                $this->load->view('feedback/error', $data);
                $this->load->view('feedback/custom4');
            }
        } else if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") { //show to fic
            $info = $this->session->userdata('userInfo');
            //******GET THE SECTION**********
            $col = array('offering_id', 'offering_name');
            $where = array('fic_id' => $info["user"]->fic_id);
            $sections = $this->Crud_model->data_distinct('offering', $col, $where);

            //******GET THE LECT ID**********
            foreach ($sections as $section) {
                $hold[0][] = $section->offering_id;
            }
            $validation[0] = $hold[0];
            $validation[0][] = "all";

            $col = 'lecturer_id';
            $where = array('lecturer_feedback_department' => $info["user"]->fic_department, 'enrollment_id' => $info['active_enrollment']);
            $lect_id = $this->Crud_model->fetch_select('lecturer_feedback', $col, $where, $hold[0], TRUE);

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

            $this->session->set_userdata('feedback', $validation);
            $data = array('title' => "Feedback");
            $this->load->view('includes/header', $data);

            $counter = 0;
            $temp = $this->session->userdata('feedback');

            if (!isset($_POST['section']) && !isset($_POST['lecturer'])) {
                $data = array(
                    'title' => "Feedback",
                    'info' => $info,
                    "s_h" => "",
                    "s_a" => "",
                    "s_c" => "",
                    "s_f" => "selected-nav",
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

                    $result_hold = array();
                    foreach ($result as $res) {
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
                        'title' => "Feedback",
                        'info' => $info,
                        "s_h" => "",
                        "s_a" => "",
                        "s_c" => "",
                        "s_f" => "selected-nav",
                        'sections' => $sections,
                        'lecturers' => $lect,
                        'feedback' => $result
                    );
                    $this->load->view('feedback/fic_view2', $data);
                } else {
                    $data = array(
                        'title' => "Feedback",
                        'info' => $info,
                        "s_h" => "",
                        "s_a" => "",
                        "s_c" => "",
                        "s_f" => "selected-nav",
                        'sections' => $sections,
                        'lecturers' => $lect,
                        'error' => "Invalid Input"
                    );
                    $this->load->view('feedback/fic_view2', $data);
                }
            } else {
                redirect("feedback");
            }
        } else if (true) { //show to ADMIN LAST
            echo "HEY ADMIN!";
            $join1 = array('lecturer', 'lecturer.lecturer_id = lecturer_feedback.lecturer_id');
            $join2 = array('offering', 'offering.offering_id = lecturer_feedback.offering_id');
            $jointype = "INNER";
            $result = $this->Crud_model->fetch_join('lecturer_feedback', NULL, $join1, $jointype, $join2);
            echo "<pre>";
            print_r($result);
            echo "</pre>";
//
        } else {
            redirect("");
        }

        $this->load->view('includes/footer');
    }

    public function content() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            $info = $this->session->userdata('userInfo');
            $course_id = $this->Crud_model->fetch('offering', array('offering_id' => $info["user"]->offering_id))[0]->course_id; //get course id from stud
            $enrollment_id = $this->Crud_model->fetch('course', array('course_id' => $course_id))[0]->enrollment_id; //get enrollment id from course
            $enrollment_active = $this->Crud_model->fetch('enrollment', array('enrollment_id' => $enrollment_id))[0]->enrollment_is_active; //get enrollment id from course
            $data = array(//gonna need to put this for header
                'title' => "Feedback",
                "s_h" => "",
                "s_a" => "",
                "s_c" => "",
                "s_f" => "selected-nav",
            );
            $this->load->view('includes/header', $data);
            if ($enrollment_active == 1) {
                $stud_id = $this->session->userdata('userInfo')['user']->student_id;
                $data = array(
                    'title' => "Feedback",
                    "s_h" => "",
                    "s_a" => "",
                    "s_c" => "",
                    "s_f" => "selected-nav",
                    'info' => $info
                );
                $segment = $this->uri->segment(3);
                $subject_hold2 = $this->Crud_model->fetch('subject', array('lecturer_id' => $segment))[0]->offering_id; //get offering_id on subject table from lecturer
                $subject_hold = $this->Crud_model->fetch('offering', array('offering_id' => $subject_hold2))[0]->course_id; //get course_id on offering table
                $offering_hold = $this->Crud_model->fetch('offering', array('offering_id' => $info["user"]->offering_id))[0]->course_id; //get course_id from student
                if ($this->Crud_model->fetch('lecturer_feedback', array('lecturer_id' => $segment, 'student_id' => $stud_id))[0]) {         //there is already record
//                    echo"<pre>";
//                    print_r($this->Crud_model->fetch('offering', array('course_id' => $subject_hold2))[0]);
//                    echo"</pre>";
                    $this->load->view('feedback/error', $data);
                    if ($subject_hold == $offering_hold) {                      //END OF VERIFYING, STUDENT ALREADY SUBMITTED
                        $this->load->view('feedback\submitted2.php');
                    } else {
                        $this->load->view('feedback\submitted.php');
                    }
                } else if ($subject_hold == $offering_hold) {                                            //didn't find anything on database
                $offering_id = $this->Crud_model->fetch('lecturer', array('lecturer_id' => $segment))[0];

                    if (empty($offering_id) != 1) {             //found offering_id, WHERE THE STUDENT SUBMITS THE FEEDBACK
                        $data = array(
                            'title' => "Feedback",
                            "s_h" => "",
                            "s_a" => "",
                            "s_c" => "",
                            "s_f" => "selected-nav",
                            'info' => $info,
                            'lect' => $offering_id
                        );
                        $this->load->view('feedback/feedback_content', $data);
                    } else {                                //unknown section
                        $this->load->view('feedback/error', $data);
                        include(APPPATH . 'views\feedback\custom5.php');
                    }
                } else {
                    redirect();
                }
            } else {
                $data = array(
                    'title' => "Feedback",
                    "s_h" => "",
                    "s_a" => "",
                    "s_c" => "",
                    "s_f" => "selected-nav",
                    'info' => $info
                );
                $this->load->view('feedback/error', $data);
                include(APPPATH . 'views\feedback\custom1.php');
            }
            $this->load->view('includes/footer');
        } else if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {

        } else {
            redirect();
        }
    }

    public function submit() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            /*  CHECKS THE CONNECTION TO THE ENROLLMEN  */
            $offering_id = $this->session->userdata('userInfo')['user']->offering_id;
            $course_id = $this->Crud_model->fetch('offering', array('offering_id' => $offering_id))[0]->course_id;
            $enrollment_id = $this->Crud_model->fetch('course', array('course_id' => $course_id))[0]->enrollment_id;
            $hold = $this->session->userdata('userInfo')["active_enrollment"];      //stored the enrollment_id of active
            /*  END */
            $data = array('title' => 'Feedback');
            $this->load->view('includes/header', $data);
            if ($this->session->userdata('userInfo')["active_enrollment"] == $enrollment_id) {   //checks if enrollment active is equals to involve student
                /*  student is qualified to submit  */
                date_default_timezone_set('Asia/Manila');
                $feedback = $this->input->post('feedback_content');
                /*  end     */
                /*  gets lecturer_id from url previous page */
                $url = $_SERVER['HTTP_REFERER'];
                $hold = array();
                $hold = explode("/", $url);
                $temp = $hold[count($hold) - 1];
                /*  end     */
                $data = array(
                    'lecturer_feedback_timedate' => time(),
                    'lecturer_feedback_comment' => $feedback,
                    'lecturer_feedback_department' => $this->session->userdata('userInfo')['user']->student_department,
                    'student_id' => $this->session->userdata('userInfo')['user']->student_id,
                    'lecturer_id' => $temp,
                    'enrollment_id' => $enrollment_id,
                    'offering_id' => $this->session->userdata('userInfo')['user']->offering_id
                );
                $this->Crud_model->insert('lecturer_feedback', $data);
                redirect('feedback');
            } else {    //the student is in an inactive enrollment; theoretically should work; not yet tested
                $this->load->view('feedback/error', $data);
                include(APPPATH . 'views\feedback\custom1.php');
            }
            $this->load->view('includes/footer');
//
        } else {
            redirect("home");
        }
    }

}
