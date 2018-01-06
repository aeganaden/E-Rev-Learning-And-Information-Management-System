<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$data = array(
			"title" => "Home - Learning Management System | FEU - Institute of Techonology"
		);
		$this->load->view('includes/header',$data);
		$this->load->view('home');
		$this->load->view('includes/footer');
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */