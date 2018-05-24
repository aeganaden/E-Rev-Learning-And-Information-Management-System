<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Topic extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model'); 
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
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

            foreach($topic_list as $top){
                $hold[] = $top->topic_list_id;
            }
            $col = "topic_list_id, topic_list_name, topic_list_description";
            $orderby[0] = "topic_list_name";
            $orderby[1] = "ASC";
            $wherenotin = array("topic_list_id", $hold);
            $not_used = $this->Crud_model->fetch_select("topic_list", $col, NULL, NULL, NULL, NULL, NULL, NULL, $orderby, NULL, $wherenotin);

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
                "topic_holder" => $topic_list,
                "unused" => $not_used
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
    public function submit_addTopic(){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');

            $this->form_validation->set_rules('topic_name', 'Topic Name', 'required|max_length[100]|min_length[5]');
            $this->form_validation->set_rules('topic_desc', 'Topic Description', 'required|min_length[5]');

            $error_message = [];
            $temp = $this->hack_check($this->input->post("topic_name"));
            if($temp["confirm"] === true){ //xss positive, repeat input
                $error_message[] = "The system detected invalid input in the Topic Name field. Please try again.";
            } else {
                $hold = $temp["string"];
                $where = array("topic_list_name" => $hold);
                $result = $this->Crud_model->fetch("topic_list", $where);
                if(empty($result)){
                    $topic_name = $hold;
                } else {
                    $error_message[] = "There is '$hold' already in the topic list";
                }
            }

            $temp = $this->hack_check($this->input->post("topic_desc"));
            if($temp["confirm"] === true){ //xss positive, repeat input
                $error_message[] = "The system detected invalid input in the Topic Name field. Please try again.";
            } else {
                $topic_desc = $temp["string"];
            }
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
                "error_message" => $error_message
            );
            $this->load->view('includes/header',$data);

            if ($this->form_validation->run() == FALSE || !empty($error_message)) { //wrong
                unset($data);
                $data = array(
                    "error_message" => $error_message
                );
                $this->load->view('topic/addTopic', $data);
            } else {
                $this->db->trans_begin();
                $insert_data = array(
                    "topic_list_name" => $topic_name,
                    "topic_list_is_active" => 1,
                    "topic_list_description" => $topic_desc
                );
                $this->Crud_model->insert("topic_list", $insert_data);

                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $error_message[] = "An unexpected error occured. Please try again. ";
                    unset($data);
                    $data = array(
                        "error_message" => $error_message
                    );
                    $this->load->view('topic/addTopic', $data);
                } else {
                    $this->db->trans_commit();
                    $this->load->view("topic/success_add_topic");
                }
            }
            
            $this->load->view('includes/footer');

        } else {
            redirect();
        }
    }

    public function editTopic(){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');

            if (!empty($segment = $this->uri->segment(3)) && is_numeric($segment)) {    //topic_list_id
                //FETCHING TOPICS
                $col = 'tl.topic_list_id, tl.topic_list_name, tl.topic_list_description';
                $where = array(
                    'sl.subject_list_department' => $info['user']->professor_department,
                    'sl.subject_list_is_active' => 1,
                    'tl.topic_list_is_active' => 1,
                    'tl.topic_list_id' => $segment
                );
                $join = array(
                    array("subject_list_has_topic_list as sltl", "tl.topic_list_id = sltl.topic_list_id"),
                    array("subject_list as sl", "sl.subject_list_id = sltl.subject_list_id")
                );
                $topic_list = $this->Crud_model->fetch_join2("topic_list as tl", $col, $join, NULL, $where, TRUE);
                // print_r($topic_list);
                $name = $topic_list[0]->topic_list_name;
                $desc = $topic_list[0]->topic_list_description;
                $id = $topic_list[0]->topic_list_id;

                if(!empty($topic_list)){
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
                        "topic_name" => $name,
                        "topic_desc" => $desc,
                        "topic_id" => $id
                    );
                    $this->load->view('includes/header',$data);
                    $this->load->view('topic/editTopic');
                    $this->load->view('includes/footer');
                } else {
                    redirect("Topic");
                }
            } else {
                redirect("Topic");
            }
        } else {
            redirect();
        }
    }

    public function submit_editTopic(){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            if (!empty($segment = $this->uri->segment(3)) && is_numeric($segment)) {    //topic_list_id
                $info = $this->session->userdata('userInfo');
                $this->form_validation->set_rules('topic_name', 'Topic Name', 'required|max_length[100]|min_length[5]');
                $this->form_validation->set_rules('topic_desc', 'Topic Description', 'required|min_length[5]');

                $error_message = [];
                $temp = $this->hack_check($this->input->post("topic_name"));
                if($temp["confirm"] === true){ //xss positive, repeat input
                    $error_message[] = "The system detected invalid input in the Topic Name field. Please try again.";
                } else {
                    //LAST! THIS TOPIC SHOULD BE EXEMPT!
                    $hold = $temp["string"];
                    $wherenotin = array("topic_list_id", array($segment));
                    $col = "topic_list_id";
                    $result = $this->Crud_model->fetch_select("topic_list", $col,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL, $wherenotin);
                    if(empty($result)){
                        $topic_name = $hold;
                    } else {
                        $error_message[] = "There is '$hold' already in the topic list";
                    }
                }

                $temp = $this->hack_check($this->input->post("topic_desc"));
                if($temp["confirm"] === true){ //xss positive, repeat input
                    $error_message[] = "The system detected invalid input in the Topic Name field. Please try again.";
                } else {
                    $topic_desc = $temp["string"];
                }


                //FETCHING TOPICS
                $col = 'tl.topic_list_id, tl.topic_list_name, tl.topic_list_description';
                $where = array(
                    'sl.subject_list_department' => $info['user']->professor_department,
                    'sl.subject_list_is_active' => 1,
                    'tl.topic_list_is_active' => 1,
                    'tl.topic_list_id' => $segment
                );
                $join = array(
                    array("subject_list_has_topic_list as sltl", "tl.topic_list_id = sltl.topic_list_id"),
                    array("subject_list as sl", "sl.subject_list_id = sltl.subject_list_id")
                );
                $topic_list = $this->Crud_model->fetch_join2("topic_list as tl", $col, $join, NULL, $where, TRUE);
                // print_r($topic_list);
                $name = $topic_list[0]->topic_list_name;
                $desc = $topic_list[0]->topic_list_description;
                $id = $topic_list[0]->topic_list_id;
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
                    "topic_name" => $name,
                    "topic_desc" => $desc,
                    "topic_id" => $id
                );
                $this->load->view('includes/header',$data);


                //from above
                if ($this->form_validation->run() == FALSE || !empty($error_message)) { //wrong
                    unset($data);
                    $data = array(
                        "error_message" => $error_message
                    );
                    $this->load->view('topic/editTopic', $data);
                } else {
                    $this->db->trans_begin();
                    $insert_data = array(
                        "topic_list_name" => $topic_name,
                        "topic_list_description" => $topic_desc
                    );
                    $where = array("topic_list_id" => $segment);
                    $this->Crud_model->update("topic_list", $insert_data, $where);

                    if ($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        $error_message[] = "An unexpected error occured. Please try again. ";
                        unset($data);
                        $data = array(
                            "error_message" => $error_message
                        );
                        $this->load->view('topic/editTopic', $data);
                    } else {
                        $this->db->trans_commit();
                        $this->load->view("topic/success_add_topic");
                    }
                }
                $this->load->view('includes/footer');
            } else {
                redirect("Topic");
            }
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

    private function hack_check($str){
        $return["confirm"] = false;
        $return["string"] = $str;
        $data = $this->security->xss_clean($str);
        if(strpos($data, '[removed]') !== FALSE){
            $return["confirm"] = true;
        }
        $return["string"] = html_escape($str);
        return $return;
    }
}

?>