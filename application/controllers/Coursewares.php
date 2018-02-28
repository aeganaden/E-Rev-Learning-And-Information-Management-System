<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Manila");

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
		$this->load->view('courseware/courseware');
		$this->load->view('includes/footer');
	}

	public function fetchTopics()
	{
		$id = $this->input->post("id");
		if ($data = $this->Crud_model->fetch("topic",array("subject_id"=>$id))) {
			echo json_encode($data);
		}else{
			echo json_encode(false);
		}
	}

	public function fetchQuestions()
	{
		$courseware_id = $this->input->post("cw_id");

		if ($data = $this->Crud_model->fetch("courseware_question",array("courseware_id"=>$courseware_id,"courseware_question_status"=>1))) {
			echo $this->load->view('courseware/load_questions_student', array("data"=>$data), TRUE);
		}else{
			$data = array(
				"message_l" => "No questions available yet",
				"message_r" => "",
			);
			echo $this->load->view('chibi/err-sad.php', array("data"=>$data), TRUE);

		}

	}
	public function countQuestion()
	{
		$courseware_id = $this->input->post("cw_id");

		if ($data = $this->Crud_model->fetch("courseware_question",array("courseware_id"=>$courseware_id,"courseware_question_status"=>1))) {
			echo json_encode(true);
		}else{
			echo json_encode("No Questions Yet");
		}

	}

}

/* End of file Coursewares.php */
/* Location: ./application/controllers/Coursewares.php */