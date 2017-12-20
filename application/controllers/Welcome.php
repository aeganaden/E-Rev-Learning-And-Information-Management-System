<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function index()
	{
		$data = array(
			"title" => "Engineering Correl - Learning Management System | FEU - Institute of Techonology"
		);
		$this->load->view('includes/header',$data);
		$this->load->view('welcome');
		$this->load->view('includes/footer');
	}

}
