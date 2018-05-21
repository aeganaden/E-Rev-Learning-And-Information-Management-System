<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Topic extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model'); 
    }

    public function index(){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');

            //FETCHING TOPICS
            $col = 'tl.topic_list_id, tl.topic_list_name, tl.topic_list_description';
            $where = array(
                'sl.subject_list_department' => $info['user']->professor_department,
                'sl.subject_list_is_active' => 1,
                'tl.topic_list_is_active' => 1
            );
            $join = array(
                array("subject_list_has_topic_list as sltl", "tl.topic_list_id = sltl.topic_list_id"),
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
            $this->load->view('topic/main');
            $this->load->view('includes/footer');
        } else {
            redirect();
        }
    }

    public function addTopic(){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
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
            $this->load->view('topic/addTopic');
            $this->load->view('includes/footer');
        } else {
            redirect();
        }
    }
    public function editTopic(){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
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
            $this->load->view('topic/editTopic');
            $this->load->view('includes/footer');
        } else {
            redirect();
        }
    }
    public function deleteTopic(){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');
            $topic_id = 1;
            // $topic_id= $this->input->post("id");
            $col = "slhtl.subject_list_id, slhtl.topic_list_id";
            $where = array(
                "slhtl.topic_list_id" => $topic_id,
                "sl.subject_list_department" => $info['user']->professor_department,
                "sl.subject_list_is_active" => 1
            );
            $join = array(
                array("subject_list as sl", "sl.subject_list_id = slhtl.subject_list_id")
            );
            $result = $this->Crud_model->fetch_join2("subject_list_has_topic_list as slhtl", $col, $join, NULL, $where, NULL, TRUE);
            
            if(!empty($result)){
                foreach($result as $sub){
                    $subjects[] = (string)$sub["subject_list_id"];
                }
                $wherein[0] = "subject_list_id";
                $wherein[1] = $subjects;
                $where = array("topic_list_id" => $result[0]["topic_list_id"]);
                $this->db->trans_begin();
                $this->Crud_model->delete2("subject_list_has_topic_list", $where, $wherein);
                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    echo json_encode("false");
                } else {
                    $this->db->trans_commit();
                    echo json_encode("true");
                }
            } else {
                echo json_encode("false");
            }
        } else {
            redirect();
        }
    }
}

?>