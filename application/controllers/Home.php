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
  // echo "<pre>";
  // print_r($info);
  // die();

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
        "s_c" => ""
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
    $activity_details = $this->Crud_model->fetch("activity");
    $info = $this->session->userdata('userInfo');
    $activity = $this->Crud_model->fetch("activity");

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
            "s_c" => ""
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
    $this->session->unset_userdata('insertion_info');
    $id = $this->input->post("id");
    $time = $this->input->post("time");
    $date = $this->input->post("date");
    $desc = $this->input->post("desc");
    $dateFull = strtotime($date . " " . $time);

    $data = array(
        "activity_description" => $desc,
        "activity_date_time" => $dateFull
    );
    if ($this->Crud_model->update("activity", $data, array("activity_id" => $id))) {
        echo json_encode(true);
    }
}

public function deleteActivity() {
    $this->session->unset_userdata('insertion_info');
    $id = $this->input->post("id");
    $where = array(
        "activity_id" => $id
    );
    if ($this->Crud_model->delete("activity", $where)) {
        echo json_encode(true);
    }
}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */