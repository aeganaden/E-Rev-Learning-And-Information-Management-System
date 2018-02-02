<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coursewares extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Crud_model');
	}

	public function index()
	{
		$info = $this->session->userdata('userInfo');
		if (!$info) {
			redirect('Welcome','refresh');
		}elseif ($info['identifier']!='student') {
			redirect('Home','refresh');
		}
		$data = array(
			"title" => "Coursewares - Learning Management System | FEU - Institute of Techonology",
			"info"=>$info,
			"s_h"=> "",
			"s_a"=> "",
			"s_f"=> "",
			"s_c"=> "selected-nav"
			
		);
		$this->load->view('includes/header', $data);
		$this->load->view('courseware');
		$this->load->view('includes/footer');
	}

}

/* End of file Coursewares.php */
/* Location: ./application/controllers/Coursewares.php */