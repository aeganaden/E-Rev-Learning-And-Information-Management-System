<?php
date_default_timezone_set('Asia/Manila');
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('Crud_model');
    }

    public function dateDiffHours($value1, $value2) {

        return intval($dateDiff/60);
    }

    public function dateDiffMinutes($value1, $value2) {
     $dateDiff = intval((strtotime($value1)-strtotime($value2))/60);
     return $dateDiff%60;
 }

 public function index() {
    $this->session->unset_userdata('insertion_info');

        // echo strtotime("+3 day 9 hours");
        // die();

        /*=============================================================
        =            FETCH ACTIVE SEASON/TERM - ENROLLMENT            =
        =============================================================*/
        
        $active_enrollment = $this->Crud_model->fetch("enrollment", array("enrollment_is_active"=>1));
        $active_enrollment = $active_enrollment[0];
        
        /*=====  End of FETCH ACTIVE SEASON/TERM - ENROLLMENT  ======*/
        

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
                $offering_data = $this->Crud_model->fetch("offering",array("offering_id"=>$value->offering_id));
                $offering_data = $offering_data[0];
                $report_cosml_offering = $this->Crud_model->fetch("course", array("course_id" => $offering_data->course_id));

                foreach ($report_cosml_offering as $key => $course) {

                    // Insert offering data to object
                    $value->course_code = $course->course_course_code;
                    $value->course_title = $course->course_course_title;
                    // fetch section
                    $section = $this->Crud_model->fetch("offering",array("course_id"=>$course->course_id));
                    $section = $section[0];
                    $value->course_section = $section->offering_name;
                    $value->professor_id = $course->professor_id;
                    $value->enrollment_id = $course->enrollment_id;
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

        $course_total = $this->Crud_model->fetch("course");

        /*=====  End of COSML REPORTS FETCHING  ======*/
        
        
        /*==========================================
        =            LECTURERS SCHEDULE            =
        ==========================================*/
        

        $schedule = $this->Crud_model->fetch("schedule");

        foreach ($schedule as $key => $sched) {
            // fetch lecturer
            $lecturer = $this->Crud_model->fetch("lecturer",array("lecturer_id"=>$sched->lecturer_id));
            $lecturer = $lecturer[0];
            $sched->lecturer_id = $lecturer->lecturer_id;
            $sched->firstname =$lecturer->firstname;
            $sched->midname =$lecturer->midname;
            $sched->lastname =$lecturer->lastname;
            $sched->expertise = $lecturer->lecturer_expertise;
            $sched->status = $lecturer->lecturer_status;
            // fetch course

            $offering = $this->Crud_model->fetch("offering",array("offering_id"=>$sched->offering_id));
            $offering = $offering[0];

            $course = $this->Crud_model->fetch("course", array("course_id"=>$offering->course_id));
            $course = $course[0];

            $sched->offering = $course->course_course_code;

            // fetch subject
            $subject = $this->Crud_model->fetch("subject", array("course_id"=>$course->course_id));
            $subject = $subject[0];
            $sched->subject = $subject->subject_name;
        }

        // echo "<pre>";

        // print_r($lecturer);
        // die();
        
        /*=====  End of LECTURERS SCHEDULE  ======*/


        /*===========================================
        =            Lecturer Attendance            =
        ===========================================*/
        
        $lecturer = $this->Crud_model->fetch("lecturer");

        
        /*=====  End of Lecturer Attendance  ======*/
        


        $data = array(
            "title" => "Administrator - Learning Management System | FEU - Institute of Techonology",
            "div_cosml_data" => $report_cosml,
            "course" => $course_total,
            "schedule"=>$schedule,
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

    function diff($date1, $date2, $format = false) 
    {
        $diff = date_diff( date_create($date1), date_create($date2) );
        if ($format)
            return $diff->format($format);

        return array('y' => $diff->y,
            'm' => $diff->m,
            'd' => $diff->d,
            'h' => $diff->h,
            'i' => $diff->i,
            's' => $diff->s
        );
    }
    function AddPlayTime($times) {
        $minutes = 0;
    // loop throught all the times
        foreach ($times as $time) {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }

        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;

    // returns the time already formatted
        return sprintf('%02d Hours %02d Minutes', $hours, $minutes);
    }
    public function viewAttendance() {

        /*=============================================================
        =            FETCH ACTIVE SEASON/TERM - ENROLLMENT            =
        =============================================================*/
        
        $active_enrollment = $this->Crud_model->fetch("enrollment", array("enrollment_is_active"=>1));
        $active_enrollment = $active_enrollment[0];
        
        /*=====  End of FETCH ACTIVE SEASON/TERM - ENROLLMENT  ======*/
        $sum = 0;
        $total_hours = 0;
        $lec_id = $this->uri->segment(3);
        $lec_data = $this->Crud_model->fetch("lecturer", array("lecturer_id" => $lec_id));
        $lec_data =  $lec_data[0];
        $interval = "";
        $total_time = array();

        $lec_attendance = $this->Crud_model->fetch("lecturer_attendance", array("lecturer_id" => $lec_id));
        foreach ($lec_attendance as $key => $value) {

           // fetch schedule 
           $sched = $this->Crud_model->fetch("schedule",array("offering_id"=>$value->offering_id));
           $sched = $sched[0];
           $sched_in  = $sched->schedule_start_time;
           $sched_out  = $sched->schedule_end_time;

           // $diff_sched_in = $this->dateDiffMinutes($sched_in,$lec_in);
           // $diff_sched_out = $this->dateDiffMinutes($sched_out,$lec_out);
           $lec_in = date("o-m-d h:i",$value->lecturer_attendance_in);
           $lec_out = date("o-m-d h:i",$value->lecturer_attendance_out);
           $interval =$this->diff( $lec_in, $lec_out );
           $sum =  $interval['h'].":".$interval['i'];
           array_push($total_time,$sum);
       }



       $data = array(
        "title" => "Administrator - Learning Management System | FEU - Institute of Techonology",
        "lecturer" => $lec_data,
        "attendance" => $lec_attendance,
        "hours_rendered" => $this->AddPlayTime($total_time),

    );
       $this->load->view('includes/header', $data);
       $this->load->view('admin-attendance');
       $this->load->view('includes/footer');
   }

   public function viewClassList() {
    // $subject = $this->Crud_model->fetch("subject", array("lecturer_id" => $this->uri->segment(3)));
    $schedule = $this->Crud_model->fetch("schedule",array("lecturer_id" => $this->uri->segment(3)));
    foreach ($schedule as $key => $value) {
        $offering = $this->Crud_model->fetch("offering", array("offering_id"=>$value->offering_id));
        $offering = $offering[0];
        $value->offering_section = $offering->offering_name;


        $course = $this->Crud_model->fetch("course",array("course_id"=>$offering->course_id));
        $course = $course[0];
        $value->program = $course->course_department;

        // fetch course
        // $course = $this->Crud_model->fetch("course",array("course_id"=>$value->course_id));
        // $course = $course[0];
        // $value->program = $course->course_department;
        // // fetch offering
        // $offering = $this->Crud_model->fetch("offering", array("course_id"=>$course->course_id));
        // $offering = $offering[0];
        // $value->offering_section = $offering->offering_name;

    }
    // echo "<pre>";
    // print_r( $student);
    // die();
    $data = array(
        "title" => "Class List - Learning Management System | FEU - Institute of Techonology",
        "schedule" => $schedule,
    );
    $this->load->view('includes/header', $data);
    $this->load->view('admin-classlist');
    $this->load->view('includes/footer');
}

public function fetchOffering() {
    $id = $this->input->post("id");
    $where = array(
        "course_id" => $id
    );

    $data = $this->Crud_model->fetch("course", $where);
    if ($data) {
        echo json_encode($data);
    }
}

public function updateOffering() {
    $id = $this->input->post("id");
    $title = $this->input->post("title");
    $code = $this->input->post("code");
    $data = array(
        "course_course_code" => $code,
        "course_course_title" => $title,
    );
    if ($this->Crud_model->update("course", $data, array("course_id" => $id))) {
        echo json_encode(true);
    }
}

public function deleteOffering() {
    $id = $this->input->post("id");
    if ($this->Crud_model->delete("course", array("course_id" => $id))) {
        echo json_encode(true);
    }
}

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */