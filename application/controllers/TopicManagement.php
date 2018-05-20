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
		$data = array(
			"title" => "Subject Area Management", 
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
		$this->load->view('topic-management/TopicManagement');
		$this->load->view('includes/footer');
	}

}

/* End of file TopicManagement.php */
/* Location: ./application/controllers/TopicManagement.php */
?>