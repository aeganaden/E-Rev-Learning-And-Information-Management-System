<?php

class Feedback extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->helper('date');
    }

    public function index() {

        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            $student_temp = $this->session->userdata('userInfo')["user"]->student_program;
            $dept_temp = $this->Crud_model->fetch('professor', array('professor_department' => $student_temp));
            $feedback_status = $dept_temp[0]->professor_feedback_active;
            $this->load->view('includes/header', $data);
            if ($feedback_status == 1) {                //checks if feedback is open
                $error = true;          //error holder
                $data = array(
                    'title' => "Feedback"
                );
                $info["user"] = new stdClass();

                include(APPPATH . 'views\feedback\hold1.php');
                $user_hold = $this->session->userdata('userInfo')['user'];
                $user_id = $user_hold->course_id;
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
                    echo "<pre>";
                    print_r($subject_hold);
                    echo "</pre>";
                    if (empty($subject_hold) != 1) {
                        foreach ($subject_hold as $subject) {           //get all subjs in a CORREL
//                        print_r($subject) . "<br>test";
                        }
                    } else {

                    }
                }
//            $offering_id = $offering_hold->offering_id;
//            $data = array(
//                'title' => "Feedback"
//            );
//            $info["user"] = new stdClass();
//            $this->load->view('includes/header', $data);
//            include(APPPATH . 'views\feedback\hold1.php');      //<span>
//            $offering_hold = $this->session->userdata('userInfo')['user'];
//            $offering_id = $offering_hold->offering_id;
//            $enrollment_is_active = $this->Crud_model->fetch('enrollment', array('enrollment_id' => $offering_id));
//            echo "<pre>";
//            print_r($enrollment_is_active);
//            echo "</pre>";
//            if ($offering_id != FALSE && $enrollment_is_active[0]->enrollment_is_active == 1) {
//                $topic_hold = $this->Crud_model->fetch('topic', array('offering_id' => $offering_id))[0];
//                $topic_id = $topic_hold->topic_id;
//                echo "<pre>";
//                print_r($topic_hold);
//                echo "</pre>";
//                if ($topic_id != FALSE) {
//                    $info["user"]->topic = $topic_hold->topic_name;
//                    $result = $this->Crud_model->fetch('lecturer', array('topic_id' => $topic_id))[0];
//                    echo "<pre>";
//                    print_r($this->Crud_model->fetch('lecturer', array('topic_id' => $topic_id)));
//                    echo "</pre>";
//                    if ($result != FALSE) {
//                        if (!empty($result)) {
//                            $info["user"]->id = $result->lecturer_id;
//                            $info["user"]->firstname = $result->firstname;
//                            $info["user"]->midname = $result->midname;
//                            $info["user"]->lastname = $result->lastname;
//                            $info["user"]->email = $result->lecturer_email;
//                            $info["identifier"] = "student";
//                            $data = array(
//                                'title' => "Feedback",
//                                'info' => $info
//                            );
//                            $this->load->view('feedback/feedback_main', $data);
//                            include(APPPATH . 'views\feedback\custom1.php');
//                        }
//                    } else {
//                        include(APPPATH . 'views\feedback\custom4.php');
//                    }
//                } else {                    //lecturer_id
//                    include(APPPATH . 'views\feedback\custom3.php');
//                }
//            } else {                        //Error: lecturer not fetched
//                include(APPPATH . 'views\feedback\custom2.php');
//            }
            } else {                    //shows the feedback is not yet activated
                $this->load->view('feedback/feedback_main', $data);
            }
        } else if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "lecturer") {
            echo "side of lecturer";
        } else {
            redirect("");
        }
        $this->load->view('includes/footer');
    }

    public function content() {
        //print_r($this->session->userdata('userInfo'));
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            $temp = $this->uri->segment(3);
            $offering_id = $this->Crud_model->fetch('lecturer', array('lecturer_id' => $temp));
            if ($offering_id != FALSE) {
                print_r($offering_id);
                if (($offering_id[0]->lecturer_offering_id) == ($this->session->userdata('userInfo')['user']->offering_id)) {
                    $lect["user"] = new stdClass();
                    $info["user"] = new stdClass();
                    $result = $offering_id[0];
                    //print_r($this->session->userdata('userInfo')['user']);

                    $lect["id"] = $result->lecturer_id;
                    $lect["firstname"] = $result->lecturer_firstname;
                    $lect["midname"] = $result->lecturer_midname;
                    $lect["lastname"] = $result->lecturer_lastname;
                    $lect["expertise"] = $result->lecturer_expertise;
                    $lect["email"] = $result->lecturer_email;

                    $result = $this->session->userdata('userInfo')['user'];
                    $info["id"] = $result->id;
                    $info["firstname"] = $result->firstname;
                    $info["midname"] = $result->midname;
                    $info["lastname"] = $result->lastname;
                    $info["email"] = $result->email;
                    $info["identifier"] = "student";
                    $data = array(
                        'title' => "Feedback",
                        'lect' => $lect,
                        'info' => $info
                    );
                    $this->load->view('includes/header', $data);
                    $this->load->view('feedback/feedback_content');
                    $this->load->view('includes/footer');
                } else {
                    echo "test1";
//                    redirect("");
                }
            } else {
                echo "test2";
//                redirect("");
            }
        } else {
            echo "test3";
//            redirect("");
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
