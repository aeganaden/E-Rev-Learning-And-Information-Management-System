<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CourseModules extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Crud_model');
	}

	public function index()
	{
		
		$info = $this->session->userdata('userInfo');

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



		if ($info['logged_in'] && $info['identifier'] == "student") {
			$data = array(
				"title" => "Course Modules - Learning Management System | FEU - Institute of Techonology",
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
			$this->load->view('course_modules/course_modules');
			$this->load->view('includes/footer');
		} elseif ($info['identifier'] == "administrator") {
			redirect('Admin');
		} else {
			redirect('Welcome', 'refresh');
		}
	}

	public function viewCourseModules()
	{
		$sub_id = $this->uri->segment(3);
		if ($sub_id) {
			$topic = $this->Crud_model->fetch("topic",array("subject_id"=>$sub_id));
			$info = $this->session->userdata('userInfo');

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

			

			if ($info['logged_in'] && ($info['identifier'] == "student")) {
				$data = array(
					"title" => "Course Modules - Learning Management System | FEU - Institute of Techonology",
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
					"topic"=>$topic
				);
				$this->load->view('includes/header', $data);
				$this->load->view('course_modules/stud_course_modules');
				$this->load->view('includes/footer');
			} elseif ($info['identifier'] == "administrator") {
				redirect('Admin');
			} else {
				redirect('Welcome', 'refresh');
			}
		}
	}

	public function viewModules()
	{
		$info = $this->session->userdata('userInfo');

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



		if ($info['logged_in'] && ($info['identifier'] == "student")) {
			$data = array(
				"title" => "Course Modules - Learning Management System | FEU - Institute of Techonology",
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
			$this->load->view('course_modules/v_course_modules');
			$this->load->view('includes/footer');
		} elseif ($info['identifier'] == "administrator") {
			redirect('Admin');
		} else {
			redirect('Welcome', 'refresh');
		}
	}

}

/* End of file CourseModules.php */
/* Location: ./application/controllers/CourseModules.php */