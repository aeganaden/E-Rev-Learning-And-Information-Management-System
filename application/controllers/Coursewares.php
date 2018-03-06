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
			"s_c"=> "selected-nav",
			"s_t" => "",
			"s_s" => "",
			"s_co" => "",
			"s_ss" => "",
			"s_rc" => "",
			"s_ga" => "",
			
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

	public function fetchQuestionJson()
	{
		$cw_id = $this->input->post("cw_id");
		if ($data = $this->Crud_model->fetch("courseware_question", array("courseware_id"=> $cw_id,"courseware_question_status"=>1))) {
			echo json_encode($data);
		}else{
			echo json_encode(false);
		}
	}

	public function insertAnswer()
	{
		$info = $this->session->userdata('userInfo');
		$answer = $this->input->post("answer");
		$q_id = $this->input->post("q_id");
		$cw_id = $this->input->post("cw_id");
		$data = array(
			"courseware_question_id"=>$q_id,
			"choice_id"=>$answer, 
			"student_id"=> $info['user']->student_id, 
			"courseware_id"=> $cw_id, 
		);

		if ($this->Crud_model->insert("student_answer",$data)) {

			$last = $this->Crud_model->fetch_last("student_answer","student_answer_id");

			$count_correct = 0;
			if ($correct_choices = $this->Crud_model->fetch("choice",array("courseware_question_id"=>$q_id,"choice_id"=>$answer,"choice_is_answer"=>1))) {
				$this->Crud_model->update("student_answer",array("choice_is_correct"=>1),array("student_answer_id"=>$last->student_answer_id));


			}else{
				echo json_encode(false);

			}

		}
	}

	public function updateAnswer()
	{
		$info = $this->session->userdata('userInfo');
		$answer = json_decode(stripslashes($this->input->post("answer")));
		$q_id = json_decode(stripslashes($this->input->post("q_id")));
		$cw_id = $this->input->post("cw_id");



		$data_where = array(
			"student_id"=> $info['user']->student_id, 
			"courseware_id"=> $cw_id, 
		);

		if ($existing = $this->Crud_model->fetch("student_answer",$data_where)) {
			foreach ($existing as $key => $value) {
				$data = array(
					"courseware_question_id"=>$q_id[$key],
					"choice_id"=>$answer[$key],
				);

				if ($this->Crud_model->update("student_answer",$data,array("student_answer_id"=>$value->student_answer_id))) {
					if ($correct_choices = $this->Crud_model->fetch("choice",array("courseware_question_id"=>$q_id[$key],"choice_id"=>$answer[$key],"choice_is_answer"=>1))) {
						$this->Crud_model->update("student_answer",array("choice_is_correct"=>1),array("student_answer_id"=>$value->student_answer_id));
					}else{
						$this->Crud_model->update("student_answer",array("choice_is_correct"=>0),array("student_answer_id"=>$value->student_answer_id));
					}
				}
			}


		}else{
			echo json_encode(false);

		}

	}

	public function countCorrect()
	{
		$cw_id = $this->input->post("cw_id");
		$student_id = $this->input->post("student_id");
		$where = array(
			"courseware_id"=>$cw_id,
			"student_id"=>$student_id,
			"choice_is_correct"=>1
		);

		$score = $this->Crud_model->countResult("student_answer",$where);

		echo json_encode($score);

	}

	public function isExisting()
	{
		$cw_id = $this->input->post("cw_id");
		$student_id = $this->input->post("student_id");
		$where = array(
			"courseware_id"=>$cw_id,
			"student_id"=>$student_id
		);

		if ($this->Crud_model->fetch("student_answer",$where)) {
			echo  json_encode(true);
		}else{
			echo  json_encode(false);
		}

	}

	public function insertGrade()
	{
		$cw_id = $this->input->post("cw_id");
		$student_id = $this->input->post("student_id");
		$score = $this->input->post("score");
		$time = $this->input->post("time");

		// grade assessment total
		$total = $this->Crud_model->countResult("courseware_question",array("courseware_id"=>$cw_id));

		// data
		$data = array(
			"courseware_id"=>$cw_id,
			"student_id"=>$student_id,
			"grade_assessment_total"=>$total,
			"grade_assessment_score"=>$score,
		);

		// insertion to grade assessment
		if ($this->Crud_model->insert("grade_assessment",$data)) {
			$last_g = $this->Crud_model->fetch_last("grade_assessment","grade_assessment_id");
			$data_time = array(
				"courseware_time_time"=>$time,
				"grade_assessment_id"=>$last_g->grade_assessment_id,
			);

			if ($this->Crud_model->insert("courseware_time",$data_time)) {
				
				$data = array(
					"message_l" => "Successfully submitted answers!",
					"message_r" => "Please check grade assessment navigation for the scores!",
				);
				echo $this->load->view('chibi/suc-happy.php', array("data"=>$data), TRUE);
			}else{
				echo json_encode(false);
			}
		}else{
			echo json_encode(false);
		}


	}



}

/* End of file Coursewares.php */
/* Location: ./application/controllers/Coursewares.php */