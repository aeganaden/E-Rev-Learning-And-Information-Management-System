<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct() {
		parent::__construct();2
		$this->load->library('session');
		$this->load->model('Crud_model');
	}
	public function index()
	{
		$info = $this->session->userdata('userInfo');

		if (!$info['logged_in']) {
			$data = array(
				"title" => "Activity - Learning Management System | FEU - Institute of Techonology",
			);
			$this->load->view('includes/header', $data);
			$this->load->view('register');
			$this->load->view('includes/footer');
		} elseif ($info['identifier'] == "administrator") {
			redirect('Admin');
		} else {
			redirect('Home');
		}
	}

}

/* End of file Register.php */
/* Location: ./application/controllers/Register.php */


?>