<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
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


	public function register_validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('reg_firstname','First Name','required|trim|max_length[50]');
	}



}
