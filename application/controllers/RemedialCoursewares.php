<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RemedialCoursewares extends CI_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Crud_model');
	}

	public function index()
	{
		// remedial coursewares insertion
		$info = $this->session->userdata('userInfo');
		$student_scores = $this->Crud_model->fetch("student_scores",array("student_scores_stud_num"=>$info['user']->student_id,"student_scores_is_failed"=>1));
		$checker = 0;

		if ($student_scores) {

			foreach ($student_scores as $key => $value) {
			// check if exists in remedial_courseware
				if ($check = $this->Crud_model->fetch("remedial_coursewares",array("student_scores_id"=>$value->student_scores_id))) {
					foreach ($check as $c_key => $c_value) {
						if ($c_value->is_done == 0) {
							$checker = 1;
							// explode topic
							$topics = explode(",", $value->student_scores_topic_id);

							foreach ($topics as $i_key => $i_value) {
							// fetch courseware
								$courseware = $this->Crud_model->fetch("courseware",array("topic_id"=>$topics[$i_key]));
								$courseware = $courseware[0];	
								if ($courseware) {
									$data = array(
										"student_scores_id"=>$value->student_scores_id,
										"courseware_id"=>$courseware->courseware_id,
									);
									$this->Crud_model->update("remedial_coursewares",$data,array("remedial_coursewares_id"=>$check[$key]->remedial_coursewares_id));
								}
							}
						}
					}
					if ($checker == 0) {
						$info = $this->session->userdata('userInfo');
						if ($this->Crud_model->update("student",array("student_is_blocked"=>0),array("student_id"=>$info['user']->student_id))) {
							$info['user']->student_is_blocked = 0;
							redirect('Home','refresh');
						}

					}
				}else{
					// explode topic
					$topics = explode(",", $value->student_scores_topic_id);

					foreach ($topics as $i_key => $i_value) {
					// fetch courseware
						$courseware = $this->Crud_model->fetch("courseware",array("topic_id"=>$topics[$i_key]));
						$courseware = $courseware[0];	
						if ($courseware) {
							$data = array(
								"student_scores_id"=>$value->student_scores_id,
								"courseware_id"=>$courseware->courseware_id,
							);
							$this->Crud_model->insert("remedial_coursewares",$data);
						}
					// echo "<pre>";
					// print_r($courseware);
					}
				}
			}



		}






		$ident = $info['identifier'];
		$ident.="_department";
		$program = 0;

		switch ($info['user']->$ident) {
			case 'CE':
			$program = 1;
			break;
			case 'ECE':
			$program = 2;
			break;
			case 'EE':
			$program = 3;
			break;
			case 'ME':
			$program = 4;
			break;

			default:
			break;
		}



		if ($info['logged_in'] && $info['identifier'] != "administrator") {
			$data = array(
				"title" => "Home - Learning Management System | FEU - Institute of Techonology",
				"info" => $info,
				"program" => $program,
				"s_h" => "",
				"s_a" => "",
				"s_f" => "",
				"s_c" => "",
				"s_t" => "",
				"s_s" => "",
				"s_co" => "",
				"s_ss" => "",
				"s_ga" => "",
				"s_rc" => "selected-nav",
			);
			$this->load->view('includes/header', $data);
			$this->load->view('remedial-coursewares');
			$this->load->view('includes/footer');
		} elseif ($info['identifier'] == "administrator") {
			redirect('Admin');
		} else {
			redirect('Welcome', 'refresh');
		}
	}


	public function isExisting()
	{
		$cw_id = $this->input->post("cw_id");
		$student_id = $this->input->post("student_id");
		$where = array(
			"courseware_id"=>$cw_id,
			"student_id"=>$student_id
		);

		if ($this->Crud_model->fetch("remedial_student_answer",$where)) {
			echo  json_encode(true);
		}else{
			echo  json_encode(false);
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

		if ($this->Crud_model->insert("remedial_student_answer",$data)) {

			$last = $this->Crud_model->fetch_last("remedial_student_answer","remedial_student_answer_id");

			$count_correct = 0;
			if ($correct_choices = $this->Crud_model->fetch("choice",array("courseware_question_id"=>$q_id,"choice_id"=>$answer,"choice_is_answer"=>1))) {
				$this->Crud_model->update("remedial_student_answer",array("choice_is_correct"=>1),array("remedial_student_answer_id"=>$last->remedial_student_answer_id));

			}else{
				echo $this->db->error();
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

				if ($this->Crud_model->update("remedial_student_answer",$data,array("remedial_student_answer_id"=>$value->student_answer_id))) {
					if ($correct_choices = $this->Crud_model->fetch("choice",array("courseware_question_id"=>$q_id[$key],"choice_id"=>$answer[$key],"choice_is_answer"=>1))) {
						$this->Crud_model->update("remedial_student_answer",array("choice_is_correct"=>1),array("remedial_student_answer_id"=>$value->student_answer_id));
					}else{
						$this->Crud_model->update("remedial_student_answer",array("choice_is_correct"=>0),array("remedial_student_answer_id"=>$value->student_answer_id));
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

		$score = $this->Crud_model->countResult("remedial_student_answer",$where);

		echo json_encode($score);

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
			"remedial_grade_assessment_total"=>$total,
			"remedial_grade_assessment_score"=>$score,
			"remedial_grade_assessment_time"=>$time,
		);

		// insertion to grade assessment
		if ($this->Crud_model->insert("remedial_grade_assessment",$data)) {

			$data = array(
				"message_l" => "Successfully submitted answers!",
				"message_r" => "Please check grade assessment navigation for the scores!",
			);
			echo $this->load->view('chibi/suc-happy.php', array("data"=>$data), TRUE);
		}else{
			echo json_encode(false);
		}


	}



}

/* End of file RemedialCourses.php */
/* Location: ./application/controllers/RemedialCourses.php */