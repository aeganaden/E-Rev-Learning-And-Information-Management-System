<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();


		$this->load->library('session'); 
		$this->load->model('Crud_model');
	}

	public function index()
	{
		$info = $this->session->userdata('userInfo');
		

		switch ($info["identifier"]) {
			case 'student':
			if (isset($info["user"]->student_id)) {

				$info["user"]->id = $info["user"]->student_id;
				$info["user"]->firstname = $info["user"]->student_firstname;
				$info["user"]->midname = $info["user"]->student_midname;
				$info["user"]->lastname = $info["user"]->student_lastname;
				$info["user"]->program = $info["user"]->student_program;
				$info["user"]->email = $info["user"]->student_email;
				unset($info["user"]->student_firstname);
				unset($info["user"]->student_midname);
				unset($info["user"]->student_lastname);
				unset($info["user"]->student_program);
				unset($info["user"]->student_email);
				unset($info["user"]->student_id);

			}
			break;

			case 'professor':
			if (isset($info["user"]->professor_id)) {
				$info["user"]->id = $info["user"]->professor_id;
				$info["user"]->midname = $info["user"]->professor_midname;
				$info["user"]->lastname = $info["user"]->professor_lastname;
				$info["user"]->department = $info["user"]->professor_department;
				$info["user"]->email = $info["user"]->professor_email;
				unset($info["user"]->professor_firstname);
				unset($info["user"]->professor_midname);
				unset($info["user"]->professor_lastname);
				unset($info["user"]->professor_department);
				unset($info["user"]->professor_email);
				unset($info["user"]->professor_id);
			}
			break;
			case 'lecturer':
			if (isset($info["user"]->lecturer_id)) {
				$info["user"]->id = $info["user"]->lecturer_id;
				$info["user"]->firstname = $info["user"]->lecturer_firstname;
				$info["user"]->midname = $info["user"]->lecturer_midname;
				$info["user"]->lastname = $info["user"]->lecturer_lastname;
				$info["user"]->expertise = $info["user"]->lecturer_expertise;
				$info["user"]->email = $info["user"]->lecturer_email;
				unset($info["user"]->lecturer_firstname);
				unset($info["user"]->lecturer_midname);
				unset($info["user"]->lecturer_lastname);
				unset($info["user"]->lecturer_expertise);
				unset($info["user"]->lecturer_email);
				unset($info["user"]->lecturer_id);
			}
			break;

			default:
			break;
		}
		
		// echo "<pre>";
		// print_r($info);

		
		// die();
		
		if ($info['logged_in'] && $info['identifier']!="administrator"){
			$data = array(
				"title" => "Home - Learning Management System | FEU - Institute of Techonology",
				"info"=>$info
			);
			$this->load->view('includes/header',$data);
			$this->load->view('home');
			$this->load->view('includes/footer');
		}elseif($info['identifier']=="administrator"){
			redirect('Admin');
		}else{
			redirect('Welcome','refresh');
		}
	}

	public function Activity()
	{
		$activity_details = $this->Crud_model->fetch("activity");
		$info = $this->session->userdata('userInfo');
		$activity = $this->Crud_model->fetch("activity");

		if ($info['logged_in'] && $info['identifier']!="administrator"){
			$data = array(
				"title" => "Activity - Learning Management System | FEU - Institute of Techonology",
				"info"=>$info,
				"activity"=>$activity_details
			);
			$this->load->view('includes/header',$data);
			$this->load->view('home-activity');
			$this->load->view('includes/footer');
		}elseif($info['identifier']=="administrator"){
			redirect('Admin');
		}else{
			redirect('Welcome','refresh');
		}
	}

	

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */