<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		$this->verify_login();
		$data = array(
			"title" => "Administrator - Learning Management System | FEU - Institute of Techonology"
		);
		$this->load->view('includes/header',$data);
		$this->load->view('admin');
		$this->load->view('includes/footer');
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