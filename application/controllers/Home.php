<?php
date_default_timezone_set("Asia/Manila");

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Crud_model');
    }

    public function index() {
        $this->session->unset_userdata('insertion_info');
        $info = $this->session->userdata('userInfo');
        // $info = $this

        // update date
        $ann_full = $this->Crud_model->fetch("announcement");
        if ($ann_full) {
          foreach ($ann_full as $key => $value) {
            $seconds = $value->announcement_end_datetime - $value->announcement_start_datetime;
            $days = ceil($seconds/(3600*24));
            // echo date("M d, Y h:i A",$value->announcement_end_datetime);
            if ($days <= 0) {

              $this->Crud_model->update("announcement",array("announcement_is_active"=>0),array("announcement_id"=>$value->announcement_id));
          }
      }
  }

  if ($scores_upload = $this->Crud_model->fetch("student_scores",array("student_scores_is_failed"=>1))) { 
    foreach ($scores_upload as $key => $value) {
        $this->Crud_model->update("student",array("student_is_blocked"=>1),array("student_id"=>$value->student_scores_stud_num));
    }
}

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
    $this->load->view('home');
    $this->load->view('includes/footer');
} elseif ($info['identifier'] == "administrator") {
    redirect('Admin');
} else {
    redirect('Welcome', 'refresh');
}
}

public function Activity() {
    $info = $this->session->userdata('userInfo');
    if ($info['identifier'] == "administrator") {
        redirect('Admin', 'refresh');
    } elseif ($info['identifier'] != "fic") {
        redirect('Home', 'refresh');
    } elseif (!$info['logged_in']) {
        redirect('Welcome', 'refresh');
    }

    $this->session->unset_userdata('insertion_info');
    $activity_details = $this->Crud_model->fetch("activity",array("activity_status"=>1));
    $info = $this->session->userdata('userInfo');
    // $activity = $this->Crud_model->fetch("activity");

    switch ($info['identifier']) {
        case 'fic':
        $info['user']->id = $info['user']->fic_id;
        break;
        case 'student':
        $info['user']->id = $info['user']->student_id;
                # code...
        break;
        case 'professor':
        $info['user']->id = $info['user']->professor_id;
                # code...
        break;

        default:
                # code...
        break;
    }
        // $id = $info['user']->id;
        // $offering = $this->Crud_model->fetch("offering", array("offering_lecturer_id" => $id));


    if ($info['logged_in'] && $info['identifier'] != "administrator") {
        $data = array(
            "title" => "Activity - Learning Management System | FEU - Institute of Techonology",
            "info" => $info,
            "activity" => $activity_details,
            "s_h" => "",
            "s_a" => "selected-nav",
            "s_f" => "",
            "s_c" => "",
            "s_t" => "",
            "s_s" => "",
            "s_co" => "",
            "s_ss" => "",
            "s_rc" => "",
            "s_ga" => "",
                    // "offering" => $offering
        );
        $this->load->view('includes/header', $data);
        $this->load->view('home-activity');
        $this->load->view('includes/footer');
    } elseif ($info['identifier'] == "administrator") {
        redirect('Admin');
    } else {
        redirect('Welcome', 'refresh');
    }
}

// ss
public function fetchSchedule()
{
  $id = $this->input->post("id");
  $data = $this->Crud_model->fetch("schedule",array("offering_id"=>$id));

  echo json_encode($data);
}


public function updateActivity() {
    $id = $this->input->post("id");
    $sched_id =  $this->input->post("sched_id"); 
    $time_s = strtotime($this->input->post("time_s"));
    $time_e = strtotime($this->input->post("time_e"));
    $date = strtotime($this->input->post("date"));
    $venue = strip_tags($this->input->post("venue"));
    $desc = strip_tags($this->input->post("desc")); 
    $offering = strip_tags($this->input->post("offering")); 
    $lecturer_id = strip_tags($this->input->post("lecturer_id")); 
    // $dateFull = strtotime($date . " " . $time);

    // validation
    if(empty(str_replace(' ','', strip_tags($venue)))){echo json_encode("Venue must not be empty");}
    elseif (empty(str_replace(' ','', $desc))) {echo json_encode("Description must not be empty");}
    elseif (empty(str_replace(' ','', $time_s))) {echo json_encode("Starting time must not be NULL");}
    elseif (empty(str_replace(' ','', $time_e))) { echo json_encode("End time must not be NULL");}
    elseif (empty(str_replace(' ','', $date))) {echo json_encode("Date must not be NULL");}
    elseif ($time_e <= $time_s) {echo json_encode("Start Time must be earlier than End Time");}
    else{
        $data = array(
            "activity_description" => $desc,
            "activity_venue" => $venue,
            "lecturer_id"=>$lecturer_id,
            "activity_schedule_id"=>$sched_id,
            "offering_id"=>$offering,
        );
        $data_sched = array(
            "activity_schedule_date"=>$date,
            "activity_schedule_start_time"=>$time_s,
            "activity_schedule_end_time"=>$time_e,
        );
        if ($this->Crud_model->update("activity", $data, array("activity_id" => $id))) {
         if ($this->Crud_model->update("activity_schedule",$data_sched,array("activity_schedule_id"=>$sched_id))) {
            echo json_encode(true);
        }else{
            echo json_encode("Update Activity Failed - Sched");
        }
    }else{
        echo json_encode("Update Activity Failed");
    }
}
}



public function deleteActivity() {
    $this->session->unset_userdata('insertion_info');
    $id = $this->input->post("id");
    $where = array(
        "activity_id" => $id
    );
    if ($this->Crud_model->update("activity",array("activity_status"=>0),$where)) {
        echo json_encode(true);
    }
}


public function addActivity()
{
    $lecturer = $this->input->post("lecturer");
    $offering = $this->input->post("offering");
    $type = $this->input->post("type");
    $date  = strtotime($this->input->post("date"));
    $s_time = strtotime($this->input->post("s_time")); 
    $e_time = strtotime($this->input->post("e_time"));
    $s_ampm = date("a",$s_time);
    $e_ampm = date("a",$e_time);
    $desc = strip_tags($this->input->post("desc"));
    $venue =strtoupper( strip_tags(str_replace(' ','',$this->input->post("venue"))));
    if($last = $this->Crud_model->fetch_last("activity_schedule","activity_schedule_id")){
        $last = $last->activity_schedule_id+1;
    }else{
        $last = 1;
    }

    $checker = false;
    $data = array(
        "activity_venue"=>$venue,
        "activity_description"=>$desc,
        "lecturer_id"=>$lecturer,
        "offering_id"=>$offering,
        "activity_details_id"=>$type,
        "activity_schedule_id"=>$last,
    );
    $data_sched = array(
        "activity_schedule_date"=>$date,
        "activity_schedule_start_time"=>$s_time,
        "activity_schedule_end_time"=>$e_time,
    );
    if ($s_ampm == $e_ampm) {
        if ($e_time < $s_time) {
            echo json_encode("Start Time must be earlier than End Time");
        }
    }
    if (empty($type) ||empty($lecturer) || empty($offering) || empty($date) || empty($s_time) || empty($e_time) || empty(str_replace(' ','',$desc))  || empty(str_replace(' ','',$venue)) ){
        echo json_encode("All values must not be null");
    }else{

        // fetch all duplicate venues
        $ven_chk = $this->Crud_model->fetch("activity",array("activity_venue"=>$venue,"activity_status"=>1));

        // check time and date
        if ($ven_chk) { 
            $u_date = $date;
            $u_time_s = $s_time;
            $u_time_e = $e_time;
            foreach ($ven_chk as $key => $value) {
                $date_ven_chk = $this->Crud_model->fetch("activity_schedule",array("activity_schedule_id"=>$value->activity_schedule_id));
                $date_ven_chk = $date_ven_chk[0];
                $vck_date = $date_ven_chk->activity_schedule_date;
                $vck_time_s = $date_ven_chk->activity_schedule_start_time;
                $vck_time_e =$date_ven_chk->activity_schedule_end_time;

                // print_r($date_ven_chk);

                if ($vck_date == $u_date && $vck_time_s == $u_time_s && $vck_time_e == $u_time_e) {
                    echo json_encode("Same time and date to an existing activity");
                    $checker = true;
                    break;
                }elseif($vck_date == $u_date){ 
                    if($u_time_s >= $vck_time_s && $u_time_s <= $vck_time_e){
                        echo json_encode("Start time is in range of a existing activity");
                        $checker = true;    
                        break;
                    }elseif($u_time_e >= $vck_time_s && $u_time_e <= $vck_time_e){
                        echo json_encode("End time is in range of a existing activity");
                        $checker = true;
                        break;
                    }elseif($u_time_s < $vck_time_s && $u_time_e < $vck_time_e){
                        echo json_encode("Your range of time is in between of an existing activity");
                        $checker = true;
                        break;
                    }elseif($u_time_s < $vck_time_s && $u_time_e > $vck_time_e){
                        echo json_encode("Your range of time is in ovarlaps an existing activity");
                        $checker = true;
                        break;
                    }
                }

            } 
        }

        if ($checker == false) {
            if ($this->Crud_model->insert("activity_schedule",$data_sched)) {
                if ($this->Crud_model->insert("activity",$data)) {
                    echo json_encode(true);
                }else{
                    echo json_encode("Actvity Details Insertion Failed");
                }
            }else{
                echo json_encode("Activity Schedule Insertion Failed");
            }
        }

    }
}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */