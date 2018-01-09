<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$info = $this->session->userdata('userInfo');
		// echo "<pre>";
		// print_r($data);
		if ($info['logged_in'] && $info['identifier']!="administrator"){
			$data = array(
				"title" => "Home - Learning Management System | FEU - Institute of Techonology"
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

	

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */