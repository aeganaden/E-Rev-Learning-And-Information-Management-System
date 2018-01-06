<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		$data = array(
			"title" => "Administrator - Learning Management System | FEU - Institute of Techonology"
		);
		$this->load->view('includes/header',$data);
		$this->load->view('admin');
		$this->load->view('includes/footer');
	}

	public function Announcements()
	{
		$data = array(
			"title" => "Announcements - Learning Management System | FEU - Institute of Techonology"
		);
		$this->load->view('includes/header',$data);
		$this->load->view('announcement');
		$this->load->view('includes/footer');
	}

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */