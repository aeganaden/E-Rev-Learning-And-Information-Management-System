<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;

class testing extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->load->helper('download');
        $this->load->helper('string');
    }

    public function index() {
        $this->load->view('includes/header', array("title" => "Testing"));
        $this->load->view('test/main');
        $this->load->view('includes/footer');
    }

    public function testing() {
        /* =============================================================
          =            FETCH ACTIVE SEASON/TERM - ENROLLMENT            =
          ============================================================= */
          $active_enrollment = $this->Crud_model->fetch("enrollment", array("enrollment_is_active" => 1));
          $active_enrollment = $active_enrollment[0];
          /* =====  End of FETCH ACTIVE SEASON/TERM - ENROLLMENT  ====== */

        // necessary initialization
          $sum = 0;
          $total_hours = 0;
        $lec_id = 1; //lec id
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
                                    $lain = str_replace("%", "", $l_a_in->format("%h%i"));
                                    $sain = str_replace("%", "", $s_t_start->format("%h%i"));
                                    if ($sain > $lain) {
                                        $d_in_f = $d_in->format('%h%i') * -1;
                                    } else {
                                        $d_in_f = $d_in->format('%h%i') * 1;
                                    }


                                    if ($d_in_f == 0) {
                                        $remarks_s = "Exact Time In";
                                    } elseif ($d_in_f < 0 && $d_in_f > ($padding_start * -1)) {
                                        $remarks_s = "Early Time In";
                                    } elseif ($d_in_f > 0 && $d_in_f < $padding_start_late) {
                                        $remarks_s = "Late Time In";
                                    } else {
                                        $remarks_s = "-";
                                    }

                                    $laout = str_replace("%", "", $l_a_out->format("%h%i"));
                                    $saout = str_replace("%", "", $s_t_end->format("%h%i"));
                                    if ($saout > $laout) {
                                        $d_out_f = $d_out->format('%h%i') * -1;
                                    } else {
                                        $d_out_f = $d_out->format('%h%i') * 1;
                                    }
                                    if ($d_out_f == 0) {
                                        $remarks_e = "Exact Time Out";
                                    } elseif ($d_out_f < 0) {
                                        $remarks_e = "Early Dismissal";
                                    } elseif ($d_out_f > 0 && $d_out_f < $padding_end_late) {
                                        $remarks_e = "Late Dismissal";
                                    } else {
                                        $remarks_e = "Overtime";
                                    }

                                    if ($remarks_s == "-") {
                                        $remarks_e = "";
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

                                    $lec_in = date("h:i", $value->attendance_in_time);
                                    $lec_out = date("h:i", $l_a_e->attendance_out_time);
                                    $stend = date("h:i", $schedule->schedule_end_time);
                                    $interval = $this->diff($lec_in, $lec_out);
                                    if ($remarks_e == "Overtime" && $remarks_s != "-") {
                                        $interval = $this->diff($lec_in, $stend);
                                        // echo $lec_in."---".$stend."<br>";
                                    }
                                    $sum = $interval['h'] . ":" . $interval['i'];
                                    $attendance_data['hours_rendered'] = $sum;

                                    if ($remarks_s == "-") {
                                        $attendance_data['hours_rendered'] = 0;
                                        $sum = "0:0";
                                    }
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
    }

    public function testing2(){
        $registrationIds[] = "fqRFW3I6EDc:APA91bF8mDoIhgK0_HaPVSltL4IzEznubgWU988gaXJ6-OzluccnevgkqkN50LwQeCLbY9NmbDymHe2-QGTr2hANbwzZvuXNCykOnjs4UQj7wYmD8yiW0PiQ_t-xJvnY9SP40KdCr8bB";
        $registrationIds[] = "dBRgejJTydw:APA91bEnfrxFh7eUYE3-JGsxNoRhqbyNcZ1QyCwn7hIsWL7GHnTh7lQYR4QPCTMwQmz9cCDM4vL1T9KWB2plA45ne5ix8P0ZINiueas6QjziYEO-gtdzvg3kM7MJnBnH2YAAAs5blK1f";
        // prep the bundle
        $msg = array(
            'body'   => 'While off',
            'title'     => 'Announcement from QA'
        );
        $fields = array(
            'registration_ids' => $registrationIds,
            'notification' => $msg,
            'data' => array('test'=>"this is test")
        );

        $headers = array(
            'Authorization: key=AIzaSyDHyR3pW8tUInWPa-SD1odWq7WRyiI6z5k',
            'Content-Type: application/json',
            'project_id: 756991022347'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        $result = json_decode($result);
        echo "<pre>";
        print_r($result);
    }

    private function diff($date1, $date2, $format = false) {
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

}
