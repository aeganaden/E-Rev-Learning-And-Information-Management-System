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
		
		foreach ($report_cosml as $key => $value) {
			// Fetch Offering Data
			$report_cosml_offering = $this->Crud_model->fetch("offering",array("offering_id"=>$value->offering_id));

			foreach ($report_cosml_offering as $key => $offer) {
				
			// Insert offering data to object
				$value->course_code = $offer->offering_course_code;
				$value->course_title = $offer->offering_course_title;
				$value->course_section = $offer->offering_section;
				$value->lecturer_id = $offer->offering_lecturer_id;
				$value->enrollment_id = $offer->enrollment_id;
			}

			// Fetch Lecturer's data
			$value_lecturer = $this->Crud_model->fetch("lecturer",array("lecturer_id"=>$value->lecturer_id));
			foreach ($value_lecturer as $key => $lecturer) {
				$value->lecturer_name = $lecturer->lecturer_firstname." ".$lecturer->lecturer_lastname;
				$value->lecturer_firstname = $lecturer->lecturer_firstname;
				$value->lecturer_middlename = $lecturer->lecturer_midname;
				$value->lecturer_lastname = $lecturer->lecturer_lastname;
				$value->lecturer_expertise = $lecturer->lecturer_expertise;
				$value->lecturer_status = $lecturer->lecturer_status;
			}

			// Fetch Enrollment Data
			$value_enrollment = $this->Crud_model->fetch("enrollment",array("enrollment_id"=>$value->enrollment_id));
			foreach ($value_enrollment as $key => $enroll) {
				$value->term = $enroll->enrollment_term;
				$value->sy = $enroll->enrollment_sy;
			}
		}

		$data = array(
			"title" => "Administrator - Learning Management System | FEU - Institute of Techonology",
			"div_cosml_data" => $report_cosml
		);
		$this->load->view('includes/header',$data);
		$this->load->view('admin');
		$this->load->view('includes/footer');
	}

	public function fetchLecturer()
	{
		$fetched = $this->Crud_model->make_datatables();
		$data = array();
		foreach ($fetched as $row) {
			$sub_array = array();
			$sub_array[] = $row->lecturer_attendance_date;
			$sub_array[] = $row->lecturer_attendance_in;
			$sub_array[] = $row->lecturer_attendance_out;
			$data[]=$sub_array;
		}

		$output = array(
			"draw"=>intval($_POST["draw"]),
			"recordsTotal" => $this->Crud_model->get_all_data(),
			"recordsFiltered" => $this->Crud_model->get_filtered_data(),
			"data"=>$data
		);
		echo json_encode($output);
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