<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coursewares_fic extends CI_Controller {
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
		}elseif ($info['identifier']!='fic') {
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
		$this->load->view('courseware-fic');
		$this->load->view('includes/footer');
	}

	public function fetchCoursewares()
	{
		$topic_id = $this->input->post("topic_id");
		if ($data = $this->Crud_model->fetch("courseware_question",array("topic_id"=>$topic_id))) {
			echo json_encode($data);
		}else{
			echo "false";
		}
	}

}

/* End of file Coursewares_fic.php */
/* Location: ./application/controllers/Coursewares_fic.php */

