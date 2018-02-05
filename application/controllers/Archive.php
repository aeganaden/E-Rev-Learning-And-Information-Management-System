<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archive extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->library('session');
		$this->load->model('Crud_model');
	}

	public function index()
	{
		$data = array(
			"title" => "Archive - Learning Management System | FEU - Institute of Techonology"
		);
		$this->load->view('includes/header', $data);
		$this->load->view('archive');
		$this->load->view('includes/footer');
	}

}

/* End of file Archive.php */
/* Location: ./application/controllers/Archive.php */