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
		$this->load->view('courseware/courseware-fic');
		$this->load->view('includes/footer');
	}

	public function fetchCoursewares()
	{
		$topic_id = $this->input->post("topic_id");
		if ($data = $this->Crud_model->fetch("courseware",array("topic_id"=>$topic_id))) {
			foreach ($data as $key => $value) {
				$value->date_added = date("M d, Y",$value->courseware_date_added);
				$value->date_edited = date("M d, Y",$value->courseware_date_edited);
			}
			echo json_encode($data);
		}else{
			echo "false";
		}
	}

	public function fetchQuestions()
	{
		$courseware_id = $this->input->post("cw_id");

		if ($data = $this->Crud_model->fetch("courseware_question",array("courseware_id"))) {
			echo $this->load->view('courseware/load_questions', array("data"=>$data), TRUE);
		}else{
			echo json_encode("false");
		}

	}

	public function updateQuestion()
	{
		$id = $this->input->post("q_id");
		$content = $this->input->post("content");

		if ($this->Crud_model->update("courseware_question",array("courseware_question_question"=>$content),array("courseware_question_id"=>$id))) {
			echo json_encode(true);
		}else{
			echo "Update question failed";
		}

	}
	public function updateAnswer()
	{
		$id = $this->input->post("a_id");
		$content = $this->input->post("content");

		if ($this->Crud_model->update("choice",array("choice_choice"=>$content),array("choice_id"=>$id))) {
			echo json_encode(true);
		}else{
			echo "Update question failed";
		}

	}

	public function fetchCorrectAnswer()
	{

		$q_id = $this->input->post("q_id");
		$a_id = $this->input->post("a_id");

		
		$where = array(
			"courseware_question_id"=>$q_id,
			"choice_is_answer"=>1
		);
		// Fetch correct answer
		if ($answer = $this->Crud_model->fetch("choice",$where)) {
			$answer = $answer[0];
			// Update correct answer
			$this->Crud_model->update("choice",array("choice_is_answer"=>0),array("choice_id"=>$answer->choice_id));
			$this->Crud_model->update("choice",array("choice_is_answer"=>1),array("choice_id"=>$a_id));
			
			
			echo json_encode($answer->choice_id);
		}else{
			$this->Crud_model->update("choice",array("choice_is_answer"=>1),array("choice_id"=>$a_id));
			// echo json_encode("Failed to fetch answer");
			echo json_encode(false);
		}
	}

}

/* End of file Coursewares_fic.php */
/* Location: ./application/controllers/Coursewares_fic.php */

