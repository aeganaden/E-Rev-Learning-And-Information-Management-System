<?php
date_default_timezone_set("Asia/Manila");

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
			"s_c"=> "selected-nav",
			"s_t" => "",
			"s_s" => "",
			"s_co" => "",
			"s_ss" => "",

			
		);
		$this->load->view('includes/header', $data);
		$this->load->view('courseware/courseware-fic');
		$this->load->view('includes/footer');
	}

	public function fetchCoursewares()
	{
		$info = $this->session->userdata('userInfo');
		$stud_num = "";
		$topic_id = $this->input->post("topic_id");
		if ($data = $this->Crud_model->fetch("courseware",array("topic_id"=>$topic_id,"courseware_status"=>1))) {
			foreach ($data as $key => $value) {
				$value->date_added = date("M d, Y",$value->courseware_date_added);
				$value->date_edited = date("M d, Y h:i A",$value->courseware_date_edited);
				// fetch time
				if (isset($info['user']->student_id)) {
					$stud_num = $info['user']->student_id;
				}
				if ($ga = $this->Crud_model->fetch("grade_assessment",array("courseware_id"=>$value->courseware_id,"student_id"=>$stud_num))) {
					if ($time = $this->Crud_model->fetch_first("courseware_time","courseware_time_time")) {
						$value->time = $time->courseware_time_time;
					}
				}
			}
			echo json_encode($data);
		}else{
			echo "false";
		}
	}

	public function updateCourseware()
	{
		$cw_t = $this->input->post("cw_t");
		$cw_t_c = str_replace(' ', '', $cw_t);
		$cw_d = $this->input->post("cw_d");
		$cw_d_c = str_replace(' ', '', $cw_d);
		$cw_id = $this->input->post("cw_id");
		$data = array(
			"courseware_name"=>$cw_t,
			"courseware_description"=>$cw_d,
			"courseware_date_edited"=>time(), 
		);

		if (empty($cw_t_c) || empty($cw_d_c)) {
			echo json_encode("Both values must not be empty");	
		}else{
			if ($this->Crud_model->update("courseware",$data,array("courseware_id"=>$cw_id))) {
				echo json_encode(true);
			}else{
				echo json_encode("Failed to update courseware");
			}
		}	
	}

	public function addCourseware()
	{
		$cw_t = $this->input->post("cw_t");
		$cw_t_c = str_replace(' ', '', $cw_t);
		$cw_d = $this->input->post("cw_d");
		$cw_d_c = str_replace(' ', '', $cw_d);
		$t_id = $this->input->post("t_id");
		$data = array(
			"courseware_name"=>$cw_t,
			"courseware_description"=>$cw_d,
			"courseware_date_added"=>time(),
			"courseware_date_edited"=>time(),
			"topic_id"=>$t_id,
		);

		if (empty($cw_t_c) || empty($cw_d_c)) {
			echo json_encode("Both values must not be empty");	
		}else{
			if ($this->Crud_model->insert("courseware",$data)) {
				echo json_encode(true);
			}else{
				echo json_encode("Failed to insert courseware");
			}
		}
	}

	public function fetchQuestions()
	{
		$courseware_id = $this->input->post("cw_id");

		if ($data = $this->Crud_model->fetch("courseware_question",array("courseware_id"=>$courseware_id,"courseware_question_status"=>1))) {
			echo $this->load->view('courseware/load_questions', array("data"=>$data), TRUE);
		}else{
			$data = array(
				"message_l" => "No questions available yet",
				"message_r" => "Add some!",
			);
			echo $this->load->view('chibi/err-sad.php', array("data"=>$data), TRUE);

		}

	}

	public function deleteQuestion()
	{
		$id = $this->input->post("id");
		if ($this->Crud_model->where("courseware_question",array("courseware_question_id"=>$id))) {
			echo json_encode(true);
		}else{
			echo json_encode("Failed to delete Question");
		}
	}



	public function insertQuestion()
	{
		$q_id = $this->input->post("q_id");
		$cw_id = $this->input->post("cw_id");
		$content = $this->input->post("content");
		$answer1 = $this->input->post("answer1");
		$answer2 = $this->input->post("answer2");
		$answer3 = $this->input->post("answer3");
		$answer4 = $this->input->post("answer4");
		$i_a_1 = $this->input->post("i_a_1");
		$i_a_2 = $this->input->post("i_a_2");
		$i_a_3 = $this->input->post("i_a_3");
		$i_a_4 = $this->input->post("i_a_4");
		$choice_type = $this->input->post("choice_type");
		$tf_choice = $this->input->post("tf_choice");
		$content_c = str_replace(' ', '', $content);
		$answer1_c = str_replace(' ', '', $answer1);
		$answer2_c = str_replace(' ', '', $answer2);
		$answer3_c = str_replace(' ', '', $answer3);
		$answer4_c = str_replace(' ', '', $answer4);

		$check_i = true;

		if ($i_a_1 == 0 &&$i_a_2 == 0 &&$i_a_3 == 0 &&$i_a_4 == 0 ) {
			$check_i = false;
		}
		$data_q = array(
			"courseware_question_question"=>$content,
			"courseware_id"=>$cw_id
		);


		if ($choice_type == 1) {
			if (empty($content_c) || empty($answer1) || empty($answer2) || empty($answer3) || empty($answer4)) {
				echo json_encode("Question and Answers Must Not Be Empty");
			}elseif ($check_i == false) {
				echo json_encode("One answer must be mark");
			}else{


				$data_a = array(
					array(
						"choice_choice"=>$answer1, 
						"courseware_question_id"=>$q_id,
						"choice_is_answer"=>$i_a_1
					),
					array(
						"choice_choice"=>$answer2, 
						"courseware_question_id"=>$q_id,
						"choice_is_answer"=>$i_a_2
					),
					array(
						"choice_choice"=>$answer3, 
						"courseware_question_id"=>$q_id,
						"choice_is_answer"=>$i_a_3
					),
					array(
						"choice_choice"=>$answer4, 
						"courseware_question_id"=>$q_id,
						"choice_is_answer"=>$i_a_4
					),
				);

				if ($this->Crud_model->insert("courseware_question",$data_q)) {
					if ($this->Crud_model->insert_batch("choice",$data_a)) {
						echo json_encode(true);
					}else{
						echo json_encode("Err - Answer Insertion Failed");
					}
				}else{
					echo json_encode("Err - Question Insertion Failed");
				}
			}
		}else{
			if ($this->Crud_model->insert("courseware_question",$data_q)) {
				if ($tf_choice=="True") {
					$t_ia = 1;
					$f_ia = 0;
				}else{
					$t_ia = 0;
					$f_ia = 1;
				}
				$data_ans = array(
					array(
						"choice_choice"=>"<p>True</p>", 
						"courseware_question_id"=>$q_id,
						"choice_is_answer"=>$t_ia
					),
					array(
						"choice_choice"=>"<p>False</p>", 
						"courseware_question_id"=>$q_id,
						"choice_is_answer"=>$f_ia
					),
				);
				if ($this->Crud_model->insert_batch("choice",$data_ans)) {
					echo json_encode(true);
				}else{
					echo json_encode("Err - Answer Insertion Failed");
				}
			}else{
				echo json_encode("Err - Question Insertion Failed");
			}
		}




	}

	public function updateQuestion()
	{
		$id = $this->input->post("q_id");
		$content = $this->input->post("content");

		if ($this->Crud_model->update("courseware_question",array("courseware_question_question"=>$content),array("courseware_question_id"=>$id))) {
			echo json_encode(true);
			$cw_q_data = $this->Crud_model->fetch("courseware_question",array("courseware_question_id"=>$id));
			// $cw_q_data = $cw_q_data[0];
			// if ($this->Crud_model->update()) {
			// 	# code...
			// }
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

	public function countQuestion()
	{
		$table = $this->input->post("table");
		$cwid = $this->input->post("cwid");
		$data = $this->Crud_model->countResult($table,array("courseware_id"=>$cwid,"courseware_question_status"=>1));

		echo json_encode($data);
	}

	public function fetchLastQuestion()
	{
		$data = $this->Crud_model->fetch_last("courseware_question","courseware_question_id");
		
		if ($data) {
			$data = $data->courseware_question_id;
			$data = (int)$data;
			$data+=1;
			echo json_encode($data);
		}else{
			$data = 1;
			echo json_encode($data);
		}
	}


	public function ToggleCourseware()
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
			"s_c"=> "selected-nav",
			"s_t" => "",
			"s_s" => "",
			"s_co" => "",
			"s_ss" => "",

			
		);
		$this->load->view('includes/header', $data);
		$this->load->view('courseware/toggle_courseware');
		$this->load->view('includes/footer');
	}

	public function updateCoursewareStatus()
	{
		$value = $this->input->post("value");
		$id_cw = $this->input->post("id_cw");

		if ($this->Crud_model->update("courseware",array("courseware_status"=>$value),array("courseware_id"=>$id_cw))) {
			echo json_encode(true);
		}else{
			echo json_encode("Failed updating courseware status");
		}
	}

}

/* End of file Coursewares_fic.php */
/* Location: ./application/controllers/Coursewares_fic.php */

