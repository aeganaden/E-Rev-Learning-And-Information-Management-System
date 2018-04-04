<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManageCourseModules extends CI_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->helper('download');
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



		if ($info['logged_in'] && ($info['identifier'] == "fic" || $info['identifier'] == "professor")) {
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
			$this->load->view('course_modules/manage_course_modules');
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

			

			if ($info['logged_in'] && ($info['identifier'] == "fic" || $info['identifier'] == "professor")) {
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
				$this->load->view('course_modules/mview_course_modules');
				$this->load->view('includes/footer');
			} elseif ($info['identifier'] == "administrator") {
				redirect('Admin');
			} else {
				redirect('Welcome', 'refresh');
			}
		}
	}

	public function uploadCourseModule()
	{
		$status = "";
		$msg = "";


		$title = $this->input->post('cm_name');
		$subject_id = $this->uri->segment(3);  
		$topic_id = $this->uri->segment(4);  


		$config['upload_path']          = './assets/modules/';
		$config['allowed_types']        = 'pdf|doc|docx';
		$config['max_size']             = 20000; 
		$config['encrypt_name']             = true; 
	    // $config['encrypt_name']  			= "CM"sha1(time());

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('cm_file')){
			$error = array('error' => $this->upload->display_errors());

			$this->session->set_flashdata('error', $error);
			redirect('ManageCourseModules/viewCourseModules/'.$subject_id);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			// echo "<pre>";
			// print_r($data);
			// echo  $title;
			if ($data) {
				$data_insert = array(

					"course_modules_path"=>$data['upload_data']['file_name'],
					"course_modules_name"=>$title,
					"topic_id"=>$topic_id
				);
				$file_id = $this->Crud_model->insert("course_modules",$data_insert);
				if($file_id)
				{
					echo "<script>
					alert('Success');
					window.location.href='".base_url()."ManageCourseModules/viewCourseModules/".$subject_id."';
					</script>";
				}else{
					$this->session->set_flashdata('error_s', 'Try again later, error in inserting data');
				}
			}

		}

	}


	public function editCourseModuleName()
	{
		$cm_id = $this->input->post("cm_id");
		$title = $this->input->post("title");
		$data = array(
			"course_modules_name"=>$title
		);
		if ($this->Crud_model->update("course_modules",$data,array("course_modules_id"=>$cm_id))) {
			echo json_encode(true);
		}
	}

	public function deleteCourseModule()
	{
		$cm_id = $this->input->post("cm_id");
		if ($this->Crud_model->update("course_modules",array("course_modules_status"=>0),array("course_modules_id"=>$cm_id))) {
			echo json_encode(true);
		}
	}

	public function download($id){
		if(!empty($id)){
            //load download helper
			$this->load->helper('download');
			
            //get file info from database
			$fileInfo = $this->file->getRows(array('id' => $id));
			
            //file path
			$file = 'uploads/files/'.$fileInfo['file_name'];
			
            //download file from directory
			force_download($file, NULL);
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



		if ($info['logged_in'] && ($info['identifier'] == "fic")) {
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
			$this->load->view('course_modules/mv_course_modules');
			$this->load->view('includes/footer');
		} elseif ($info['identifier'] == "administrator") {
			redirect('Admin');
		} else {
			redirect('Welcome', 'refresh');
		}
	}

	public function downloadFile()
	{
		$filePath = $this->uri->segment(3);
		$pth    =   "./assets/modules/".$filePath;
		echo $pth;
		$nme    =   $filePath;
		force_download($pth, NULL);
	}
}
/* End of file ManageCourseModules.php */
/* Location: ./application/controllers/ManageCourseModules.php */
