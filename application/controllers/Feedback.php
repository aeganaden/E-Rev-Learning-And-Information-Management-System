<?php

class Feedback extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->helper('date');
    }

    public function index() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "student") {
            $data = array(
                'title' => "Feedback"
            );
            $info["user"] = new stdClass();
            $this->load->view('includes/header', $data);
            include(APPPATH . 'views\feedback\hold1.php');
            $offering_id = $this->session->userdata('userInfo')['user']->offering_id;
            if ($offering_id != FALSE) {
                $lecturer_id = $this->Crud_model->fetch('offering', array('offering_id' => $offering_id))[0]->offering_lecturer_id;
                if ($lecturer_id != FALSE) {
                    $result = $this->Crud_model->fetch('lecturer', array('lecturer_id' => $lecturer_id))[0];
                    if ($result != FALSE) {
                        if (!empty($result)) {
                            $info["user"]->id = $result->lecturer_id;
                            $info["user"]->firstname = $result->lecturer_firstname;
                            $info["user"]->midname = $result->lecturer_midname;
                            $info["user"]->lastname = $result->lecturer_lastname;
                            $info["user"]->expertise = $result->lecturer_expertise;
                            $info["user"]->email = $result->lecturer_email;
                            $info["identifier"] = "student";
                            $data = array(
                                'title' => "Feedback",
                                'info' => $info
                            );
                            $this->load->view('feedback/feedback_main', $data);
                            include(APPPATH . 'views\feedback\custom1.php');
                        }
                    } else {
                        include(APPPATH . 'views\feedback\custom4.php');
                    }
                } else {
                    include(APPPATH . 'views\feedback\custom3.php');
                }
            } else {
                include(APPPATH . 'views\feedback\custom2.php');
            }
        } else if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "lecturer") {

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
                    redirect("");
                }
            } else {
                redirect("");
            }
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
