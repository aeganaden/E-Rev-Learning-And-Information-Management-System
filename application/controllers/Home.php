<?php

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

        // echo "<pre>";
        // print_r($info);
        // die();

        if ($info['logged_in'] && $info['identifier'] != "administrator") {
            $data = array(
                "title" => "Home - Learning Management System | FEU - Institute of Techonology",
                "info" => $info
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
        $this->session->unset_userdata('insertion_info');
        $activity_details = $this->Crud_model->fetch("activity");
        $info = $this->session->userdata('userInfo');
        $activity = $this->Crud_model->fetch("activity");
        $id = $info['user']->id;
        // $offering = $this->Crud_model->fetch("offering", array("offering_lecturer_id" => $id));


        if ($info['logged_in'] && $info['identifier'] != "administrator") {
            $data = array(
                "title" => "Activity - Learning Management System | FEU - Institute of Techonology",
                "info" => $info,
                "activity" => $activity_details,
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

    /* COMMENT DAHIL ERROR SA SIDE KO - MARK
      public function fetchSchedule()
      {
      $id = $this->input->post("id");
      $data = $this->Crud_model->fetch("schedule",array("offering_id"=>$id));
      $data = $data[0];
      $data->min = $data->
      echo json_encode($data);
      }
     */

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