<?php

date_default_timezone_set('Asia/Manila');
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('Crud_model');
    }

    public function index() {
        $this->session->unset_userdata('insertion_info');


        // echo strtotime("+3 day 9 hours");
        // die();

        /* =============================================================
          =            FETCH ACTIVE SEASON/TERM - ENROLLMENT            =
          ============================================================= */

          $active_enrollment = $this->Crud_model->fetch("enrollment", array("enrollment_is_active" => 1));
          $active_enrollment = $active_enrollment[0];

          /* =====  End of FETCH ACTIVE SEASON/TERM - ENROLLMENT  ====== */

        /* ==============================================
          =         LECTURER'S FEEDBACK BY MARK          =
          ============================================== */

          $col = array('lecturer_id,id_number,image_path, CONCAT(firstname, " ",midname, " ",lastname) AS full_name', FALSE);
          $feedback = $this->Crud_model->fetch_join('lecturer', $col);

        /* ==============================================
          =            COSML REPORTS FETCHING            =
          ============================================== */


        // Fetch Schedule
          $report_cosml = $this->Crud_model->fetch("schedule");

        // Count Schedule
          $count_res = $this->Crud_model->countResult("schedule");

          $this->verify_login();

          if ($report_cosml) {
            foreach ($report_cosml as $key => $value) {
                // Fetch Offering Data
                $offering_data = $this->Crud_model->fetch("offering", array("offering_id" => $value->offering_id));
                $offering_data = $offering_data[0];
                $report_cosml_offering = $this->Crud_model->fetch("course", array("course_id" => $offering_data->course_id));

                foreach ($report_cosml_offering as $key => $course) {

                    // Insert offering data to object
                    $value->course_code = $course->course_course_code;
                    $value->course_title = $course->course_course_title;
                    // fetch section
                    $section = $this->Crud_model->fetch("offering", array("course_id" => $course->course_id));
                    $section = $section[0];
                    $value->course_section = $section->offering_name;
                    $value->professor_id = $course->professor_id;
                    $value->enrollment_id = $course->enrollment_id;
                }
                $professor = $this->Crud_model->fetch("professor", array("professor_id" => $value->professor_id));
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

        /* =====  End of COSML REPORTS FETCHING  ====== */


        /* ==========================================
          =            LECTURERS SCHEDULE            =
          ========================================== */


          $schedule = $this->Crud_model->fetch("schedule");

          foreach ($schedule as $key => $sched) {
            // fetch lecturer
            $lecturer = $this->Crud_model->fetch("lecturer", array("lecturer_id" => $sched->lecturer_id));
            $lecturer = $lecturer[0];
            $sched->id_number = $lecturer->id_number;
            $sched->firstname = $lecturer->firstname;
            $sched->midname = $lecturer->midname;
            $sched->lastname = $lecturer->lastname;
            $sched->expertise = $lecturer->lecturer_expertise;
            $sched->status = $lecturer->lecturer_status;
            // fetch course

            $offering = $this->Crud_model->fetch("offering", array("offering_id" => $sched->offering_id));
            $offering = $offering[0];

            $course = $this->Crud_model->fetch("course", array("course_id" => $offering->course_id));
            $course = $course[0];

            $sched->offering = $course->course_course_code;

            // fetch subject
            $subject = $this->Crud_model->fetch("subject", array("offering_id" => $offering->course_id));
            $subject = $subject[0];
            $sched->subject = $subject->subject_name;
        }

        // echo "<pre>";
        // print_r($lecturer);
        // die();

        /* =====  End of LECTURERS SCHEDULE  ====== */


        /* ===========================================
          =            Lecturer Attendance            =
          =========================================== */

          $lecturer = $this->Crud_model->fetch("lecturer");


          /* =====  End of Lecturer Attendance  ====== */



          $data = array(
            "title" => "Administrator - Learning Management System | FEU - Institute of Techonology",
            "div_cosml_data" => $report_cosml,
            "course" => $course_total,
            "schedule" => $schedule,
            "lecturer" => $lecturer,
            "feedback" => $feedback
        );
          $this->load->view('includes/header', $data);
          $this->load->view('admin');
          $this->load->view('includes/footer');
      }

      public function Announcements() {
        // update date
        $ann_full = $this->Crud_model->fetch("announcement");
        if ($ann_full) {
            foreach ($ann_full as $key => $value) {
                $seconds = $value->announcement_end_datetime - $value->announcement_start_datetime;
                $days = ceil($seconds / (3600 * 24));
                if ($days < 0) {
                    $this->Crud_model->update("announcement", array("announcement_is_active" => 0), array("announcement_id" => $value->announcement_id));
                }
            }
        }
        $this->verify_login();

        $announcement = $this->Crud_model->fetch("announcement", array("announcement_is_active" => 1));
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
        $data = $data[0];
        $data->end_time = date("M d, Y", $data->announcement_end_datetime);
        echo json_encode($data);
    }

    public function updateAnnouncement() {
        $title = $this->input->post("title");
        $content = $this->input->post("content");
        $audience = $this->input->post("audience");
        $edited_at = time();
        $id = $this->input->post("id");
        $data = array(
            "announcement_title" => $title,
            "announcement_content" => $content,
            "announcement_end_datetime" => strtotime($this->input->post("date")),
            "announcement_start_datetime" => time(),
            "announcement_audience" => $audience,
            "announcement_edited_at" => $edited_at
        );

        if ($this->Crud_model->update("announcement", $data, array("announcement_id" => $id))) {
            echo json_encode("success");
        }
    }

    public function addAnnouncement() {

        $column = "";
        $info = $this->session->userdata('userInfo');

        $title = $this->input->post("title");
        $content = $this->input->post("content");
        $audience = "";

        $i = 0;
        $len = count($_POST['audience']);
        foreach ($_POST['audience'] as $aud) {
            $c = ",";
            if ($i == $len - 1) {
                $c = "";
            }

            $audience.=$aud . $c;
            $i++;
        }

        $data = array(
            "announcement_title" => strip_tags($title),
            "announcement_content" => strip_tags($content),
            "announcement_created_at" => time(),
            "announcement_edited_at" => time(),
            "announcement_is_active" => 1,
            "announcement_audience" => strip_tags($audience),
            "announcement_start_datetime" => time(),
            "announcement_end_datetime" => strtotime($this->input->post("end_time")),
            "announcement_announcer" => strip_tags(ucwords($info["user"]->firstname . " " . $info["user"]->lastname))
        );
        if ($this->Crud_model->insert("announcement", $data)) {
            redirect('Admin/announcements', 'refresh');
            // echo "<pre>";
            // print_r( $data);
        }
    }

    public function deleteAnnouncement() {
        $id = $this->input->post("id");
        if ($this->Crud_model->update("announcement", array("announcement_is_active" => 0), array("announcement_id" => $id))) {
            echo json_encode(true);
        }
    }

    public function verify_login() {
        $info = $this->session->userdata('userInfo');

        if ($info['identifier'] != "administrator") {
            redirect('Home', 'refresh');
        } elseif (!$info['logged_in']) {
            redirect('Welcome', 'refresh');
        }
    }

    function diff($date1, $date2, $format = false) {
        $diff = date_diff(date_create($date1), date_create($date2));
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

        /* =============================================================
          =            FETCH ACTIVE SEASON/TERM - ENROLLMENT            =
          ============================================================= */

          $active_enrollment = $this->Crud_model->fetch("enrollment", array("enrollment_is_active" => 1));
          $active_enrollment = $active_enrollment[0];

          /* =====  End of FETCH ACTIVE SEASON/TERM - ENROLLMENT  ====== */
          $sum = 0;
          $total_hours = 0;
          $lec_id = $this->uri->segment(3);
          $lec_data = $this->Crud_model->fetch("lecturer", array("lecturer_id" => $lec_id));
          $lec_data = $lec_data[0];
          $interval = "";
          $total_time = array();

          $lec_attendance = $this->Crud_model->fetch("lecturer_attendance", array("lecturer_id" => $lec_id));
          foreach ($lec_attendance as $key => $value) {

            // fetch schedule
            $sched = $this->Crud_model->fetch("schedule", array("offering_id" => $value->offering_id));
            $sched = $sched[0];
            $sched_in = $sched->schedule_start_time;
            $sched_out = $sched->schedule_end_time;

            // $diff_sched_in = $this->dateDiffMinutes($sched_in,$lec_in);
            // $diff_sched_out = $this->dateDiffMinutes($sched_out,$lec_out);
            $lec_in = date("o-m-d h:i", $value->lecturer_attendance_in);
            $lec_out = date("o-m-d h:i", $value->lecturer_attendance_out);
            $interval = $this->diff($lec_in, $lec_out);
            $sum = $interval['h'] . ":" . $interval['i'];
            array_push($total_time, $sum);
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
        $schedule = $this->Crud_model->fetch("schedule", array("lecturer_id" => $this->uri->segment(3)));
        foreach ($schedule as $key => $value) {
            $offering = $this->Crud_model->fetch("offering", array("offering_id" => $value->offering_id));
            $offering = $offering[0];
            $value->offering_section = $offering->offering_name;


            $course = $this->Crud_model->fetch("course", array("course_id" => $offering->course_id));
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

    public function charts_student() {
        $students = $this->Crud_model->fetch("student");
        $data = array();
        $me = $ce = $ee = $ece = 0;
        if ($students) {
            foreach ($students as $key => $value) {
                switch ($value->student_department) {
                    case 'CE':
                    $ce++;
                    break;
                    case 'ME':
                    $me++;
                    break;
                    case 'ECE':
                    $ece++;
                    break;
                    case 'EE':
                    $ee++;
                    break;

                    default:
                        # code...
                    break;
                }
            }
        }
        array_push($data, $me, $ce, $ee, $ece);

        echo json_encode($data);
    }

    // fic
    public function updateStatus() {
        $id = $this->input->post("id");
        $val = $this->input->post("val");
        if ($this->Crud_model->update("fic", array("fic_status" => $val), array("fic_id" => $id))) {
            echo json_encode("true");
        }
    }

    public function more_feedback()
    {
        $id = $this->input->post("id");

        $col = array('lecturer_feedback_timedate, lecturer_feedback_comment,image_path, CONCAT(firstname, " ",midname, " ",lastname) AS full_name', FALSE);
        $join1 = array('lecturer', 'lecturer.lecturer_id = lecturer_feedback.lecturer_id');
        $join2 = array('offering', 'offering.offering_id = lecturer_feedback.offering_id');
        $jointype = "INNER";
        $where = array('lecturer_feedback.lecturer_id' => $id);
        
        if ($feedback = $this->Crud_model->fetch_join('lecturer_feedback', $col, $join1, $jointype, $join2, $where)) {
           for ($i=0; $i < sizeof($feedback); $i++) { 

            $feedback[$i]["date"] = date("M d, Y",$feedback[$i]["lecturer_feedback_timedate"]);
        }
    }else{
        $feedback = "false";
    }
    echo json_encode($feedback);
}

public function fetchLecturer()
{
    $id = $this->input->post("id");
    $data = $this->Crud_model->fetch("lecturer",array("lecturer_id"=>$id));
    $data = $data[0];
    echo json_encode($data);

}

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */