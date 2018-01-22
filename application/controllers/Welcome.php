<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->library('session');
		$this->load->model('Crud_model');
	}
	public function index()
	{
		$info = $this->session->userdata('userInfo');
		
		if ($info['logged_in'] && $info['identifier']!="administrator"){
			redirect('Home','refresh');
		}elseif($info['identifier']=="administrator"){
			redirect('Admin');
		}else{
			$data = array(
				"title" => "Engineering Correl - Learning Management System | FEU - Institute of Techonology",
				"info"=>$info,
			);
			$this->load->view('includes/header',$data);
			$this->load->view('welcome');
			$this->load->view('includes/footer');
		}
	}

	public function fetchSchedule()
	{
		$offering_id = $this->input->post("id");
		$data = $this->Crud_model->fetch("schedule",array("offering_id"=>$offering_id));
		foreach ($data as $key => $value) {
			$value->day = date("l",$value->schedule_start_time);

			$value->s_h = date("G",$value->schedule_start_time);
			$value->s_min = date("i",$value->schedule_start_time);
			$value->s_d= date("d",$value->schedule_start_time);
			$value->s_m= date("m",$value->schedule_start_time);

			$value->e_h = date("G",$value->schedule_end_time);
			$value->e_min = date("i",$value->schedule_end_time);
			$value->e_d= date("d",$value->schedule_start_time);
			$value->e_m= date("m",$value->schedule_start_time);
		}
		echo json_encode($data);
	}

}
	// public function register_validation()
	// {
	// 	$this->load->library('form_validation');
	// 	$this->form_validation->set_rules('reg_firstname','First Name','required|regex_match[/^[a-zA-Z_ ]*$/]|max_length[100]');
	// 	$this->form_validation->set_rules('reg_midname','Middle Name','required|regex_match[/^[a-zA-Z_ ]*$/]|max_length[100]');
	// 	$this->form_validation->set_rules('reg_lastname','Surname','required|regex_match[/^[a-zA-Z_ ]*$/]|max_length[100]');
	// 	$this->form_validation->set_rules('reg_username','Username','required|alpha_numeric|max_length[100]|is_unique[lecturer.username]');
	// 	$this->form_validation->set_rules('reg_email','Email','required|valid_email|max_length[100]|is_unique[lecturer.email]');
	// 	$this->form_validation->set_rules('reg_password','Password','required|alpha_numeric|max_length[100]|min_length[8]');
	// 	$this->form_validation->set_rules('reg_conf_password','Confirm Password','required|alpha_numeric|max_length[100]|matches[reg_password]|min_length[8]');
	// 	$this->form_validation->set_rules('reg_expertise','Expertise','required|max_length[150]');



	// 	if($this->form_validation->run() == false){
	// 		$data = array(
	// 			'reg_firstname' => strip_tags(form_error('reg_firstname')), 
	// 			'reg_midname' => strip_tags(form_error('reg_midname')), 
	// 			'reg_lastname' => strip_tags(form_error('reg_lastname')), 
	// 			'reg_username' => strip_tags(form_error('reg_username')), 
	// 			'reg_email' => strip_tags(form_error('reg_email')), 
	// 			'reg_password' => strip_tags(form_error('reg_password')), 
	// 			'reg_conf_password' => strip_tags(form_error('reg_conf_password')), 
	// 			'reg_expertise' => strip_tags(form_error('reg_expertise')), 
	// 		);
	// 		echo json_encode($data);
	// 	}else{
	// 		echo json_encode("true");
	// 	}


	// }

	// public function insertData()
	// {
	// 	$data = array(
	// 		"firstname"=>$this->input->post("reg_firstname"),
	// 		"midname"=>$this->input->post("reg_midname"),
	// 		"lastname"=>$this->input->post("reg_lastname"),
	// 		"lecturer_expertise"=>$this->input->post("reg_expertise"),
	// 		"username"=>$this->input->post("reg_username"),
	// 		"password"=>$this->input->post("reg_password"),
	// 		"email"=>$this->input->post("reg_email"),
	// 	);
	// 	if ($this->Crud_model->insert("lecturer",$data)) {
	// 		echo json_encode("true");
	// 	}
	// }




