<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('Crud_model');
    }

    public function dateDiffHours($value1, $value2) {
        return round($value2 / (60 * 60 )) - round($value1 / (60 * 60 ));
    }

    public function dateDiffMinutes($value1, $value2) {
        return round($value2 / (60 )) - round($value1 / (60));
    }

    public function index() {

        $this->session->unset_userdata('insertion_info');

        /*==============================================
        =            COSML REPORTS FETCHING            =
        ==============================================*/
        
        
        // Fetch Schedule
        $report_cosml = $this->Crud_model->fetch("schedule");

        // Count Schedule
        $count_res = $this->Crud_model->countResult("schedule");

        $this->verify_login();

        if ($report_cosml) {
            foreach ($report_cosml as $key => $value) {
                // Fetch Offering Data
                $report_cosml_offering = $this->Crud_model->fetch("offering", array("offering_id" => $value->offering_id));

                foreach ($report_cosml_offering as $key => $offer) {

                    // Insert offering data to object
                    $value->course_code = $offer->offering_course_code;
                    $value->course_title = $offer->offering_course_title;
                    $value->course_section = $offer->offering_section;
                    $value->professor_id = $offer->professor_id;
                    $value->enrollment_id = $offer->enrollment_id;
                }
                $professor = $this->Crud_model->fetch("professor",array("professor_id"=> $value->professor_id));
                foreach ($professor as $key => $prof) {
                    $value->professor_name = $prof->firstname . " " . $prof->lastname;
                }


                // Fetch Enrollment Data
                $value_enrollment = $this->Crud_model->fetch("enrollment", array("enrollment_id" => $value->enrollment_id));
                foreach ($value_enrollment as $key => $enroll) {
                    $value->term = $enroll->enrollment_term;
                    $value->sy = $enroll->enrollment_sy;
                }
            }
        }
        $offering_data = $this->Crud_model->fetch("offering");
        
        /*=====  End of COSML REPORTS FETCHING  ======*/
        
        
        /*==========================================
        =            LECTURERS SCHEDULE            =
        ==========================================*/
        
        // Fetch Active Enrollment Data
        $active_enrollment = $this->Crud_model->fetch("enrollment", array("enrollment_is_active"=>1));
        $active_enrollment = $active_enrollment[0];

        // fetch lecturer
        $lecturer = $this->Crud_model->fetch("lecturer");

        foreach ($lecturer as $key => $value) {

            // fetch topic
            $topic = $this->Crud_model->fetch("topic",array("topic_id"=>$value->topic_id));
            $topic = $topic[0];

            // fetch active Offering 
            $offering = $this->Crud_model->fetch("offering",array(
                "offering_id"=>$topic->offering_id,
                "enrollment_id"=>$active_enrollment->enrollment_id
            ));
            $offering = $offering[0];
            
            $schedule = $this->Crud_model->fetch("schedule",array("offering_id"=>$offering->offering_id));
            $schedule = $schedule[0];

            $value->schedule_id = $schedule->schedule_id;
            $value->start_time = $schedule->schedule_start_time;
            $value->end_time = $schedule->schedule_end_time;
            $value->venue = $schedule->schedule_venue;

            

        }

        echo "<pre>";
        print_r($lecturer);
        die();
        
        /*=====  End of LECTURERS SCHEDULE  ======*/
        


        $data = array(
            "title" => "Administrator - Learning Management System | FEU - Institute of Techonology",
            "div_cosml_data" => $report_cosml,
            "offering" => $offering_data,
            "lecturer"=>$lecturer
        );
        $this->load->view('includes/header', $data);
        $this->load->view('admin');
        $this->load->view('includes/footer');
    }

    public function Announcements() {
        $this->verify_login();
        $announcement = $this->Crud_model->fetch("announcement");
        $data = array(
            "title" => "Announcements - Learning Management System | FEU - Institute of Techonology",
            "announcement" => $announcement
        );
        $this->load->view('includes/header', $data);
        $this->load->view('announcement');
        $this->load->view('includes/footer');
    }

    public function fetchAnnouncement() {
        $announcement_id = $this->input->post("id");
        $data = $this->Crud_model->fetch("announcement", array("announcement_id" => $announcement_id));
        echo json_encode($data);
    }

    public function updateAnnouncement() {
        $title = $this->input->post("title");
        $content = $this->input->post("content");
        $status = $this->input->post("status");
        $edited_at = time();
        $id = $this->input->post("id");
        $data = array(
            "announcement_title" => $title,
            "announcement_content" => $content,
            "announcement_is_active" => $status,
            "announcement_edited_at" => $edited_at
        );

        if ($this->Crud_model->update("announcement", $data, array("announcement_id" => $id))) {
            echo json_encode("success");
        }
    }

    public function addAnnouncement() {
        $column = "";
        $info = $this->session->userdata('userInfo');
        // echo "<pre>";
        // print_r($info);
        // die();
        switch ($info["identifier"]) {
            case 'administrator':
            $column = "admin_id";
            break;
            case 'student':
            $column = "student_id";
            break;
            case 'lecturer':
            $column = "lecturer_id";
            break;
            case 'professor':
            $column = "professor_id";
            break;

            default:
                # code...
            break;
        }


        $title = $this->input->post("title");
        $content = $this->input->post("content");
        $audience = $this->input->post("ann_audience");
        $data = array(
            "announcement_title" => $title,
            "announcement_content" => $content,
            "announcement_created_at" => time(),
            "announcement_edited_at" => time(),
            "announcement_is_active" => time(),
            "announcement_audience" => $audience,
            "announcement_announcer" => ucwords($info["user"]->firstname . " " . $info["user"]->lastname)
        );
        if ($this->Crud_model->insert("announcement", $data)) {
            redirect('Admin/announcements', 'refresh');
        }
    }

    public function deleteAnnouncement() {
        $id = $this->input->post("id");
        if ($this->Crud_model->delete("announcement", array("announcement_id" => $id))) {
            echo json_encode(true);
        }
    }

    public function verify_login() {
        $info = $this->session->userdata('userInfo');
        if (!$info['logged_in'] && $info['identifier'] == "administrator") {
            redirect('Welcome', 'refresh');
        } elseif ($info['identifier'] == "lecturer" || $info['identifier'] == "student" || $info['identifier'] == "professor") {
            redirect('Home', 'refresh');
        } elseif (!$info['logged_in']) {
            redirect('Welcome', 'refresh');
        }
    }

    public function viewAttendance() {
        $sum = 0;
        $minutes = 0;
        $lec_id = $this->uri->segment(3);
        $lec_data = $this->Crud_model->fetch("lecturer", array("lecturer_id" => $lec_id));
        $lec_att_foreach = $this->Crud_model->fetch("lecturer_attendance", array("lecturer_lecturer_id" => $lec_id));
        $lec_data = $lec_data[0];
        $lec_attendance = $this->Crud_model->fetch("lecturer_attendance", array("offering_id" => $lec_data->lecturer_offering_id));

        foreach ($lec_att_foreach as $key => $value) {

            $sum += $this->dateDiffHours($value->lecturer_attendance_in, $value->lecturer_attendance_out);
            $minutes += $this->dateDiffMinutes($value->lecturer_attendance_in, $value->lecturer_attendance_out);
        }

        $minutes = (($sum * 60) - $minutes) * -1;

        $data = array(
            "title" => "Administrator - Learning Management System | FEU - Institute of Techonology",
            "lecturer" => $lec_data,
            "attendance" => $lec_attendance,
            "hours_rendered" => $sum,
            "minutes_rendered" => $minutes
        );
        $this->load->view('includes/header', $data);
        $this->load->view('admin-attendance');
        $this->load->view('includes/footer');
    }

    public function viewClassList() {
        $offering = $this->Crud_model->fetch("offering", array("offering_lecturer_id" => $this->uri->segment(3)));

        $data = array(
            "title" => "Class List - Learning Management System | FEU - Institute of Techonology",
            "offering" => $offering,
        );
        $this->load->view('includes/header', $data);
        $this->load->view('admin-classlist');
        $this->load->view('includes/footer');
    }

    public function fetchOffering() {
        $id = $this->input->post("id");
        $where = array(
            "offering_id" => $id
        );

        $data = $this->Crud_model->fetch("offering", $where);
        if ($data) {
            echo json_encode($data);
        }
    }

    public function updateOffering() {
        $id = $this->input->post("id");
        $title = $this->input->post("title");
        $code = $this->input->post("code");
        $data = array(
            "offering_course_code" => $code,
            "offering_course_title" => $title,
        );
        if ($this->Crud_model->update("offering", $data, array("offering_id" => $id))) {
            echo json_encode(true);
        }
    }

    public function deleteOffering() {
        $id = $this->input->post("id");
        if ($this->Crud_model->delete("offering", array("offering_id" => $id))) {
            echo json_encode(true);
        }
    }

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */