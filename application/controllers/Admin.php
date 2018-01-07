<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('session'); 
		$this->load->model('Crud_model');
	}
	public function index()
	{
		// Fetch Schedule
		$report_cosml = $this->Crud_model->fetch("schedule");
		// Count Schedule
		$count_res = $this->Crud_model->countResult("schedule");

		$this->verify_login();
		
		for ($i=0; $i < $count_res; $i++) { 
			// Fetch Offering Data
			$report_cosml_offering = $this->Crud_model->fetch("offering",array("offering_id"=>$report_cosml[$i]->offering_id));

			// Insert offering data to object
			$report_cosml[$i]->course_code = $report_cosml_offering[$i]->offering_course_code;
			$report_cosml[$i]->course_title = $report_cosml_offering[$i]->offering_course_title;
			$report_cosml[$i]->course_section = $report_cosml_offering[$i]->offering_section;
			$report_cosml[$i]->lecturer_id = $report_cosml_offering[$i]->offering_lecturer_id;
			$report_cosml[$i]->enrollment_id = $report_cosml_offering[$i]->enrollment_id;

			// Fetch Lecturer's data
			$report_cosml_lecturer = $this->Crud_model->fetch("lecturer",array("lecturer_id"=>$report_cosml[$i]->lecturer_id));
			$report_cosml[$i]->lecturer_name = $report_cosml_lecturer[$i]->lecturer_firstname." ".$report_cosml_lecturer[$i]->lecturer_lastname;

			// Fetch Enrollment Data
			$report_cosml_enrollment = $this->Crud_model->fetch("enrollment",array("enrollment_id"=>$report_cosml[$i]->enrollment_id));
			$report_cosml[$i]->term = $report_cosml_enrollment[$i]->enrollment_term;
			$report_cosml[$i]->sy = $report_cosml_enrollment[$i]->enrollment_sy;

		}
		$data = array(
			"title" => "Administrator - Learning Management System | FEU - Institute of Techonology",
			"div_cosml_data" => $report_cosml
		);
		$this->load->view('includes/header',$data);
		$this->load->view('admin');
		$this->load->view('includes/footer');
	}

	public function Announcements()
	{
		$this->verify_login();
		$data = array(
			"title" => "Announcements - Learning Management System | FEU - Institute of Techonology"
		);
		$this->load->view('includes/header',$data);
		$this->load->view('announcement');
		$this->load->view('includes/footer');
	}

	public function verify_login()
	{
		$info = $this->session->userdata('userInfo');
		if (!$info['logged_in'] && $info['identifier']=="administrator"){
			redirect('Welcome','refresh');
		}elseif ( $info['identifier']=="lecturer" || $info['identifier']=="student"|| $info['identifier']=="professor") {
			redirect('Home','refresh');
		}elseif(!$info['logged_in']){
			redirect('Welcome','refresh');
		}
	}



}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */