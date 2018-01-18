<?php

class Feedback extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->helper('date');
    }

    public function index() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            $info = $this->session->userdata('userInfo');
            $student_temp = $this->session->userdata('userInfo')["user"]->student_program;
            $dept_temp = $this->Crud_model->fetch('professor', array('professor_department' => $student_temp));
            $feedback_status = $dept_temp[0]->professor_feedback_active;
            $data = array(
                'title' => "Feedback",
                'info' => $info
            );

            $this->load->view('includes/header', $data);
            if ($feedback_status == 1) {                //checks if feedback is open
                $error = true;          //error holder
                $user_hold = $this->session->userdata('userInfo')['user'];
                $user_id = $user_hold->offering_id;
                $course_hold = $this->Crud_model->fetch('course', array('course_id' => $user_id))[0];
                $enrollment_hold = $this->Crud_model->fetch('enrollment', array('enrollment_id' => $course_hold->enrollment_id))[0];
                if (empty($enrollment_hold) != 1) {       //check the fetch table and if it is active
                    if ($enrollment_hold->enrollment_is_active == 0) {
                        $error = false;
                        include(APPPATH . 'views\feedback\custom1.php');
                    }
                } else {
                    $error = false;
                    include(APPPATH . 'views\feedback\custom2.php');
                }

                if ($error) {
                    $course_id = $course_hold->course_id;
                    $subject_hold = $this->Crud_model->fetch('subject', array('course_id' => $course_id));
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
                            'info' => $info,
                            'lect' => $lect
                        );
                    } else {
                        include(APPPATH . 'views\feedback\custom3.php');
                    }
                }
            }
        } else if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "lecturer") {
            echo "side of lecturer";
        } else {
            redirect("");
        }
        $this->load->view('feedback/feedback_main', $data);
        $this->load->view('includes/footer');
    }

    public function content() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            $info = $this->session->userdata('userInfo');
            $course_id = $this->Crud_model->fetch('offering', array('offering_id' => $info["user"]->offering_id))[0]->course_id; //get course id from stud
            $enrollment_id = $this->Crud_model->fetch('course', array('course_id' => $course_id))[0]->enrollment_id; //get enrollment id from course
            $enrollment_active = $this->Crud_model->fetch('enrollment', array('enrollment_id' => $enrollment_id))[0]->enrollment_is_active; //get enrollment id from course
            $this->load->view('includes/header');
            if ($enrollment_active == 1) {
                $stud_id = $this->session->userdata('userInfo')['user']->student_id;
                $data = array(
                    'title' => "Feedback",
                    'info' => $info
                );
                $segment = $this->uri->segment(3);
                if ($this->Crud_model->fetch('lecturer_feedback', array('lecturer_id' => $segment, 'student_id' => $stud_id))[0]) {
                    $offering_hold = $this->Crud_model->fetch('lecturer_feedback', array('student_id' => $stud_id, 'student_id' => $stud_id));
//                print_r($offering_hold);
                    $data = array(
                        'title' => "Feedback",
                        'info' => $info,
                        'lect' => $offering_hold
                    );
                    echo "nagsubmit ka na!";
                } else {
                    $offering_id = $this->Crud_model->fetch('lecturer', array('lecturer_id' => $segment))[0];

                    if (empty($offering_id) != 1) {
                        $data = array(
                            'title' => "Feedback",
                            'info' => $info,
                            'lect' => $offering_id
                        );
                    } else {
                        echo "test1";
//                redirect("feedback");
                    }
                }
            } else {
                $data = array(
                    'title' => "Feedback",
                    'info' => $info
                );
                $this->load->view('feedback/error', $data);
            }
            //$this->load->view('feedback/feedback_content', $data);
            $this->load->view('includes/footer');
        } else if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "lecturer") {
            echo "lecturer view";
//            redirect("");
        } else {
            redirect("");
        }
    }

    public function submit() {

        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            $offering_id = $this->session->userdata('userInfo')['user']->offering_id;
            if ($offering_id != FALSE) {
                $lecturer_id = $this->Crud_model->fetch('offering', array('offering_id' => $offering_id))[0]->offering_lecturer_id;
                if ($lecturer_id != FALSE) {
                    $result = $this->Crud_model->fetch('lecturer', array('lecturer_id' => $lecturer_id))[0];
//                    $datestring = 'Year: %Y Month: %m Day: %d - %h:%i %a';
                    date_default_timezone_set('Asia/Manila');
                    if ($result != FALSE) {
                        $feedback = $this->input->post('feedback_content');
                        $data = array(
                            'lecturer_feedback_timedate' => time(),
                            'lecturer_feedback_comment' => $feedback,
                            'offering_id' => $this->session->userdata('userInfo')['user']->offering_id,
                            'student_id' => $this->session->userdata('userInfo')['user']->id
                        );
                        if ($this->Crud_model->insert('lecturer_feedback', $data)) {
                            redirect("");
                        } else {

                        }                                   //LAST
                    } else {
                        reidrect("");
                    }
                } else {
                    reidrect("");
                }
            } else {
                reidrect("");
            }
        } else {
            redirect("");
        }
    }

}
