<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class TopicManagement extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Crud_model'); 
	}

	public function index()
	{
		$info = $this->session->userdata('userInfo');

		 //FETCHING TOPICS
		$col = 'tl.topic_list_id, tl.topic_list_name, tl.topic_list_description';
		$where = array(
			'sl.subject_list_department' => $info['user']->professor_department,
			'sl.subject_list_is_active' => 1,
			'tl.topic_list_is_active' => 1
		);
		$join = array(
			array("subject_list_has_topic_list as sltl", "sltl.subject_list_id = sltl.topic_list_id"),
			array("subject_list as sl", "sl.subject_list_id = sltl.subject_list_id")
		);
		$topic_list = $this->Crud_model->fetch_join2("topic_list as tl", $col, $join, NULL, $where, TRUE);
		
		$data = array(
			"title" => "Topic Management", 
			"s_h" => "",
			"s_a" => "",
			"s_f" => "",
			'info' => $info,
			"s_c" => "",
			"s_t" => "",
			"s_top" => "selected-nav",
			"s_s" => "",
			"s_co" => "",
			"s_ss" => "", 
			"topic_holder" => $topic_list
		);
		$this->load->view('includes/header',$data);
		$this->load->view('topic-management/TopicManagement');
		$this->load->view('includes/footer');
	}

	public function addTopic()
	{
		
		$info = $this->session->userdata('userInfo');
		
		$data = array(
			"title" => "Topic Management", 
			"s_h" => "",
			"s_a" => "",
			"s_f" => "",
			'info' => $info,
			"s_c" => "",
			"s_t" => "",
			"s_top" => "selected-nav",
			"s_s" => "",
			"s_co" => "",
			"s_ss" => "",  
		);
		$this->load->view('includes/header',$data);
		$this->load->view('topic-management/addTopic');
		$this->load->view('includes/footer');
	}
	public function editTopic()
	{
		
		$info = $this->session->userdata('userInfo');
		
		$data = array(
			"title" => "Topic Management", 
			"s_h" => "",
			"s_a" => "",
			"s_f" => "",
			'info' => $info,
			"s_c" => "",
			"s_t" => "",
			"s_top" => "selected-nav",
			"s_s" => "",
			"s_co" => "",
			"s_ss" => "",  
		);
		$this->load->view('includes/header',$data);
		$this->load->view('topic-management/editTopic');
		$this->load->view('includes/footer');
	}
}

/* End of file TopicManagement.php */
/* Location: ./application/controllers/TopicManagement.php */
?>