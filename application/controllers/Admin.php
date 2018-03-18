<?php

date_default_timezone_set('Asia/Manila');
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('Crud_model');
    }
    public function active_enrollment() {
        $active_enrollment = $this->Crud_model->fetch("enrollment", array("enrollment_is_active" => 1));
        $active_enrollment = $active_enrollment[0];
        return $active_enrollment->enrollment_id;
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

        /* =====  End of COSML REPORTS FETCHING  ====== */


        /* ================================================
          =            Course OFFERING per term            =
          ================================================ */

          if ($active_enrollment) {
            $course_total = $this->Crud_model->fetch("course", array("enrollment_id" => $active_enrollment->enrollment_id));
        } else {
            $course_total = null;
        }

        /* =====  End of Course OFFERING per term  ====== */



        /* ==========================================
          =            LECTURERS SCHEDULE            =
          ========================================== */
          $sched = (object) array();
          $schedule = array();
          if ($active_enrollment) {
            $course = $this->Crud_model->fetch("course", array("enrollment_id" => $active_enrollment->enrollment_id));
            if ($course) {
                foreach ($course as $key => $value) {
                    $offering = $this->Crud_model->fetch("offering", array("course_id" => $value->course_id));
                    if ($offering) {
                        foreach ($offering as $key => $i_value) {
                            $sched_for = $this->Crud_model->fetch("schedule", array("offering_id" => $i_value->offering_id));

                            if ($sched_for) {
                                $sched = $sched_for;
                                foreach ($sched_for as $key => $sched) {
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

                                    $sched->subject = $course->course_course_code;
                                }

                                array_push($schedule, $sched);
                            }
                        }
                    }
                }
            }
        }






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
            "feedback" => $feedback,
            "active_enrollment" => $active_enrollment,
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
                if ($days <= 0) {
                    $this->Crud_model->update("announcement", array("announcement_is_active" => 0), array("announcement_id" => $value->announcement_id));
                }
            }
        }
        $this->verify_login();



        $result = $this->get_active_enrollment();           //returns row if there's active s/y term
        $announcement = $this->Crud_model->fetch("announcement", array("announcement_is_active" => 1));
        if (is_array($result)) {
            $data = array(
                "title" => "Announcements - Learning Management System | FEU - Institute of Techonology",
                "announcement" => $announcement
            );
            $this->load->view('includes/header', $data);
            $this->load->view('announcement');
            $this->load->view('includes/footer');
        } else {
            $temp["message_r"] = "No S/Y Term active";
            $temp["message_l"] = "Create an S/Y Term";
            $data = array(
                "title" => "Announcements - Learning Management System | FEU - Institute of Techonology",
                "chibi" => $temp
            );
            $this->load->view('includes/header', $data);
            $this->load->view('announcement');
            $this->load->view('includes/footer');
        }
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

    function totalRenderedHours($times) {
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


        // necessary initialization

          $sum = 0;
          $total_hours = 0;
        $lec_id = $this->uri->segment(3); //lec id
        $lec_data = $this->Crud_model->fetch("lecturer", array("lecturer_id" => $lec_id));
        $lec_data = $lec_data[0];
        $interval = "";
        $test = array();
        $total_time = array();
        $x = 0;
        // create new object
        $attendance_data = array();

        // create array of object
        $attendance = array();
        // fetch active
        // fetch course
        $course = $this->Crud_model->fetch("course", array("enrollment_id" => $active_enrollment->enrollment_id));
        if ($course) {
            foreach ($course as $key => $value) {
                // fetch offering with course id that is active
                $offering = $this->Crud_model->fetch("offering", array("course_id" => $value->course_id));
                if ($offering) {
                    foreach ($offering as $key => $inner_value) {

                    // fetch lecturer
                        $lec_attendance = $this->Crud_model->fetch("lecturer_attendance", array("lecturer_id" => $lec_id, "offering_id" => $inner_value->offering_id));


                        if ($lec_attendance) {
                            foreach ($lec_attendance as $key => $lec) {
                            // echo $x++;
                            // fetch here then enclose the insertion data to foreach of schedule
                            // fetch schedule
                                $schedule = $this->Crud_model->fetch("schedule", array("schedule_id" => $lec->schedule_id));
                                $schedule = $schedule[0];

                            // Schedule start and time_in difference
                                $s_t_start = date_create(date("h:i a", $schedule->schedule_start_time));
                                $s_t_end = date_create(date("h:i a", $schedule->schedule_end_time));

                                $l_a_s = $this->Crud_model->fetch("attendance_in", array("lecturer_attendance_id" => $lec->lecturer_attendance_id));
                                foreach ($l_a_s as $key => $value) {
                                    $l_a_in = date_create(date("h:i a", $value->attendance_in_time));
                                    $d_in = date_diff($s_t_start, $l_a_in); 
                                    $l_a_e = $this->db->select('*')->where(array("lecturer_attendance_id" => $value->lecturer_attendance_id))->order_by('attendance_out_id', "desc")->limit(1)->get('attendance_out')->row();
                                    $l_a_out = date_create(date("h:i a", $l_a_e->attendance_out_time));
                                    $d_out = date_diff($s_t_end, $l_a_out);

                                // Remarks Section
                                    $padding_start = 20;
                                    $padding_start_late = 20;
                                    $padding_end_late = 20;
                                    $remarks_s = "";
                                    $remarks_e = "";
                                    // remove all % to compare
                                    $lain = str_replace("%", "",$l_a_in->format("%h%i"));
                                    $sain = str_replace("%", "",$s_t_start->format("%h%i"));
                                    if ($sain > $lain) {
                                        $d_in_f = $d_in->format('%h%i')*-1;
                                    }else{
                                        $d_in_f = $d_in->format('%h%i')*1;
                                    } 

                                    
                                    if ($d_in_f == 0) {
                                        $remarks_s = "Exact Time In";
                                    } elseif ($d_in_f < 0 && $d_in_f > ($padding_start * -1)) {
                                        $remarks_s = "Early Time In";
                                    } elseif ($d_in_f > 0 && $d_in_f < $padding_start_late) {
                                        $remarks_s = "Late Time In";
                                    } else {
                                        $remarks_s = "Absent";
                                    } 

                                    $laout = str_replace("%", "",$l_a_out->format("%h%i"));
                                    $saout = str_replace("%", "",$s_t_end->format("%h%i"));
                                    if ($saout > $laout) {
                                        $d_out_f = $d_out->format('%h%i')*-1;
                                    }else{
                                        $d_out_f = $d_out->format('%h%i')*1;
                                    }
                                    if ($d_out_f == 0) {
                                        $remarks_e = "Exact Time Out";
                                    } elseif ($d_out_f < 0) {
                                        $remarks_e = "Early Dismissal";
                                    } elseif ($d_out_f > 0 && $d_out_f < $padding_end_late) {
                                        $remarks_e = "Late Dismissal";
                                    } else {
                                        $remarks_e = "Absent";
                                    } 

                                    $attendance_data['lecturer_attendance_id'] = $lec->lecturer_attendance_id;

                                    $attendance_data['lecturer_attendance_date'] = $lec->lecturer_attendance_date;
                                    $attendance_data['lecturer_attendance_in'] = $value->attendance_in_time;
                                    $attendance_data['lecturer_attendance_out'] = $l_a_e->attendance_out_time;
                                    $attendance_data['sched_start'] = $schedule->schedule_start_time;
                                    $attendance_data['sched_end'] = $schedule->schedule_end_time;
                                    $attendance_data['remarks_s'] = $remarks_s;
                                    $attendance_data['remarks_e'] = $remarks_e;
                                // echo "<pre>";
                                // print_r($attendance);

                                    $lec_in = date("o-m-d h:i", $value->attendance_in_time);
                                    $lec_out = date("o-m-d h:i", $l_a_e->attendance_out_time);
                                    $interval = $this->diff($lec_in, $lec_out);
                                    $sum = $interval['h'] . ":" . $interval['i']; 
                                    $attendance_data['hours_rendered'] = $sum;
                                    $attendance[] = $attendance_data;
                                    array_push($total_time, $sum);
                                }
                            // echo $d_out->format('%r%i');
                            // echo "<br>";
                            }
                        }
                    }
                }
            }
        }


        // echo "<pre>";
        // print_r($attendance);

        if (empty($attendance[0])) {
            $attendance = false;
        }

        // end fetch active








        $data = array(
            "title" => "Administrator - Learning Management System | FEU - Institute of Techonology",
            "lecturer" => $lec_data,
            "attendance" => $attendance,
            "hours_rendered" => $this->totalRenderedHours($total_time),
            "total_time_array" => $total_time,
        );
        $this->load->view('includes/header', $data);
        $this->load->view('admin-attendance');
        $this->load->view('includes/footer');
    }

    public function viewClassList() {
        // $subject = $this->Crud_model->fetch("subject", array("lecturer_id" => $this->uri->segment(3)));
        $schedule = $this->Crud_model->fetch("schedule", array("lecturer_id" => $this->uri->segment(3)));
        if ($schedule) {
            foreach ($schedule as $key => $value) {

                $active_enrollment = $this->Crud_model->fetch("enrollment", array("enrollment_is_active" => 1));
                $active_enrollment = $active_enrollment[0];

                $course = $this->Crud_model->fetch("course", array("enrollment_id" => $active_enrollment->enrollment_id));
                if ($course) {
                    // echo "TRUE!!!!!!!!!!!!!!!!";
                    foreach ($course as $key => $i_value) {
                        $offering = $this->Crud_model->fetch("offering", array("offering_id" => $value->offering_id, "course_id" => $i_value->course_id));
                        if ($offering) {
                            $offering = $offering[0];
                            $value->offering_section = $offering->offering_name;
                            $value->program = $i_value->course_department;
                        }
                    }
                } else {
                    $schedule = null;
                    break;
                }
            }
        } else {
            $schedule = null;
        }
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

    // public function deleteOffering() {
    //     $id = $this->input->post("id");
    //     if ($this->Crud_model->delete("course", array("course_id" => $id))) {
    //         echo json_encode(true);
    //     }
    // }

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

    // prof
    public function updateStatusProf() {
        $id = $this->input->post("id");
        $val = $this->input->post("val");
        if ($this->Crud_model->update("professor", array("professor_status" => $val), array("professor_id" => $id))) {
            echo json_encode("true");
        }
    }

    public function more_feedback() {

        $id = $this->input->post("id");

        $col = array('lecturer_feedback_timedate, lecturer_feedback_comment,image_path, CONCAT(firstname, " ",midname, " ",lastname) AS full_name', FALSE);
        $join1 = array('lecturer', 'lecturer.lecturer_id = lecturer_feedback.lecturer_id');
        $join2 = array('offering', 'offering.offering_id = lecturer_feedback.offering_id');
        $jointype = "INNER";
        $where = array('lecturer_feedback.lecturer_id' => $id, "enrollment_id" => $this->active_enrollment());
        $this->db->order_by('lecturer_feedback_timedate', 'ASC');
        if ($feedback = $this->Crud_model->fetch_join('lecturer_feedback', $col, $join1, $jointype, $join2, $where)) {
            for ($i = 0; $i < sizeof($feedback); $i++) {

                $feedback[$i]->date = date("M d, Y", $feedback[$i]->lecturer_feedback_timedate);
            }
        } else {
            $feedback = "false";
        }
        echo json_encode($feedback);
    }

    public function fetchLecturer() {
        $id = $this->input->post("id");
        $data = $this->Crud_model->fetch("lecturer", array("lecturer_id" => $id));
        $data = $data[0];
        echo json_encode($data);
    }

    private function get_active_enrollment() { //MARK - GET ACTIVE ENROLLMENT. RETURN ROW OF ACTIVE
        $where = array("enrollment_is_active" => 1);
        if (!empty($result = $this->Crud_model->fetch_select("enrollment", NULL, $where)) && count($result) != 1) {
            return "There are multiple active enrollment.";
        } else if ($result) {
            return $result;
        } else {
            return "There is no activated enrollment";
        }
    }

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */