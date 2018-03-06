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

		if ($student_scores) {

			foreach ($student_scores as $key => $value) {
			// check if exists in remedial_courseware
				if ($check = $this->Crud_model->fetch("remedial_coursewares",array("student_scores_id"=>$value->student_scores_id))) {
					// explode topic
					// echo "string";
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
							$this->Crud_model->update("remedial_coursewares",$data,array("remedial_coursewares_id"=>$check[$i_key]->remedial_coursewares_id));
							echo $check[$i_key]->remedial_coursewares_id;
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
			case 'EEE':
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

}

/* End of file RemedialCourses.php */
/* Location: ./application/controllers/RemedialCourses.php */