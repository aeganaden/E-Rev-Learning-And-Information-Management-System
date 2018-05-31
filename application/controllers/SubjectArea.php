<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SubjectArea extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->helper('cookie');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');
            //FETCHING SUBJECTS
            $col = 'sl.subject_list_id, sl.subject_list_name, yl.year_level_name, yl.year_level_id';
            $where = array('sl.subject_list_department' => $info['user']->professor_department, 'sl.subject_list_is_active' => 1);
            $join = array(
                array(
                    "year_level as yl", "sl.year_level_id = yl.year_level_id"
                )
            );
            $subject_list = $this->Crud_model->fetch_join2("subject_list as sl", $col, $join, NULL, $where);

            foreach ($subject_list as $subsl) {
                $year_holder[$subsl->year_level_id][$subsl->year_level_name][] = "— " . $subsl->subject_list_name;
            }

            //FETCHING TOPICS
            $col = 'subject_list_name, subject_list_description';
            $where = array(
                'subject_list_department' => $info['user']->professor_department,
                'subject_list_is_active' => 1
            );
            $subject_areas = $this->Crud_model->fetch_select("subject_list", $col, $where, NULL, TRUE);

            $data = array(
                "title" => "Subject Area Management",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_f" => "",
                "s_c" => "",
                "s_t" => "",
                "s_s" => "selected-nav",
                "s_co" => "",
                "s_ss" => "",
                "year_holder" => $year_holder,
                "subject_holder" => $subject_areas
            );
            $this->load->view('includes/header', $data);
            $this->load->view('subject_area/main');
            $this->load->view('includes/footer');
        } else {
            redirect("");
        }
    }

    public function form_data(){   
        $title = $this->input->post("title");
        $desc = $this->input->post("desc");
        $this->session->set_userdata('title', $title);
        $this->session->set_userdata('desc', $desc);
    }

    public function sub_view() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            if (!empty($segment = $this->uri->segment(3)) && is_numeric($segment)) {
                $info = $this->session->userdata('userInfo');

                $col = "tl.topic_list_id, tl.topic_list_name, tl.topic_list_description, sl.subject_list_name, sl.subject_list_id, subject_list_description";
                $where = array(
                    'sl.subject_list_department' => $info['user']->professor_department,
                    'sl.subject_list_is_active' => 1,
                    'tl.topic_list_is_active' => 1,
                    'sl.year_level_id' => $segment
                );
                $join = array(
                    array("year_level as yl", "sl.year_level_id = yl.year_level_id"),
                    array("subject_list_has_topic_list as sltl", "sl.subject_list_id = sltl.subject_list_id"),
                    array("topic_list as tl", "tl.topic_list_id = sltl.topic_list_id")
                );
                $topic_list = $this->Crud_model->fetch_join2("subject_list as sl", $col, $join, NULL, $where);

                if(!empty($topic_list)){
                    $dissect = [];
                    $record = [];
                    foreach($topic_list as $sub_topic){
                        $subj_id = $sub_topic->subject_list_id;
                        if(!array_search($subj_id, $record)){
                            $dissect[$subj_id]["subj_name"] = $sub_topic->subject_list_name;
                            $dissect[$subj_id]["subj_desc"] = $sub_topic->subject_list_description;
                            $temp = array(
                                "topic_list_id" => $sub_topic->topic_list_id,
                                "topic_list_name" => $sub_topic->topic_list_name,
                                "topic_list_desc" => $sub_topic->topic_list_description,
                            );
                            $dissect[$subj_id]["values"][] = $temp;
                        } else {
                            $temp = array(
                                "topic_list_id" => $sub_topic->topic_list_id,
                                "topic_list_name" => $sub_topic->topic_list_name,
                                "topic_list_descn" => $sub_topic->topic_list_description,
                            );
                            $dissect[$subj_id]["subj_values"][] = $temp;
                        }
                    }
                } else {
                    redirect("SubjectArea");
                }
                // echo "<pre>";
                // print_r($topic_list);
                // print_r($dissect);

                $data = array(
                    "title" => "Subject Area Management",
                    'info' => $info,
                    "s_h" => "",
                    "s_a" => "",
                    "s_f" => "",
                    "s_c" => "",
                    "s_t" => "",
                    "s_s" => "selected-nav",
                    "s_co" => "",
                    "s_ss" => "",
                    "dissect" => $dissect
                );
                $this->load->view('includes/header', $data);
                $this->load->view('subject_area/sub_view');
                $this->load->view('includes/footer');
            } else {
                redirect("SubjectArea");
            }
        } else {
            redirect();
        }
    }

    public function add_subject_area(){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');

            $result = $this->Crud_model->fetch_select("year_level");
            $col = "topic_list_id, topic_list_name, topic_list_description";
            $where = array("topic_list_is_active" => 1);
            $topics = $this->Crud_model->fetch_select("topic_list", $col, $where);
            $segYearLevel = $this->uri->segment(3);
            if ($segYearLevel) {

                // echo "<pre>";
                // print_r($this->update_topic_list($segYearLevel));
                // die;
                $res = $this->update_topic_list($segYearLevel);
                $data = array(
                    "title" => "Subject Area Management",
                    'info' => $info,
                    "s_h" => "",
                    "s_a" => "",
                    "s_f" => "",
                    "s_c" => "",
                    "s_t" => "",
                    "s_s" => "selected-nav",
                    "s_co" => "",
                    "s_ss" => "",
                    "option_select" => $result,
                    "topics" => $res
                );

            } else {
                $data = array(
                    "title" => "Subject Area Management",
                    'info' => $info,
                    "s_h" => "",
                    "s_a" => "",
                    "s_f" => "",
                    "s_c" => "",
                    "s_t" => "",
                    "s_s" => "selected-nav",
                    "s_co" => "",
                    "s_ss" => "",
                    "option_select" => $result,
                    "topics" => $topics
                );
            }

            $this->load->view('includes/header', $data); 
            $this->load->view('subject_area/add_subject_area');
            $this->load->view('includes/footer');
        } else {
            redirect();
        }
    }

    public function add_submit(){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');

            $data = array(
                "title" => "Subject Area Management",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_f" => "",
                "s_c" => "",
                "s_t" => "",
                "s_s" => "selected-nav",
                "s_co" => "",
                "s_ss" => ""
            );
            $this->load->view('includes/header', $data);

            $this->form_validation->set_rules('subject_area', 'Subject Area name', 'required|max_length[100]|min_length[5]');
            $this->form_validation->set_rules('subject_description', 'Subject Area description', 'required|min_length[5]');
            $this->form_validation->set_rules('year_level', 'Year Level', 'required|numeric');
            //rules for topics
            $rules = array(
                'required' => 'Please select at least 2 in the list of topics'
            );
            $this->form_validation->set_rules('topic_list[]', 'Topics', 'required', $rules);

            $error_message=[];

            $temp = $this->hack_check($this->input->post("subject_area"));
            if($temp["confirm"] === true){ //xss positive, repeat input
                $error_message[] = "The system detected invalid input in the Subject Area field. Please try again.";
            } else {
                $subject_area = $temp["string"];
                $is_duplicate = $this->Crud_model->fetch_select("subject_list", "subject_list_name", 
                    array("subject_list_name" => $subject_area, "subject_list_department" => $info['user']->professor_department));
                
                if(!empty($is_duplicate)){
                    $error_message[] = "There is '$subject_area' already in the subject area list";
                }
            }

            $temp = $this->hack_check($this->input->post("subject_description"));
            if($temp["confirm"] === true){ //xss positive, repeat input
                $error_message[] = "The system detected invalid input in the Subject Area desription field. Please try again.";
            } else {
                $subject_desc = $temp["string"];
            }

            $temp = $this->hack_check($this->input->post("year_level"));
            if($temp["confirm"] === true){ //xss positive, repeat input
                $error_message[] = "The system detected invalid input in the Year Level field. Please try again.";
            } else {
                $year_level = $temp["string"];
            }

            //GET TOPICS AND YEAR LEVEL
            $result = $this->Crud_model->fetch_select("year_level");
            $col = "topic_list_id, topic_list_name, topic_list_description";
            $where = array("topic_list_is_active" => 1);
            $topics = $this->Crud_model->fetch_select("topic_list", $col, $where);
            //END - GET TOPICS AND YEAR LEVEL

            if ($this->form_validation->run() == FALSE || !empty($error_message)) { //wrong
                unset($data);
                $data = array(
                    "option_select" => $result,
                    "topics" => $topics,
                    "error" => true,
                    "error_message" => $error_message
                );
                $this->load->view('subject_area/add_subject_area', $data);
            } else {
                $this->db->trans_begin();
                $insert_data = array(
                    "subject_list_name" => strtoupper($subject_area),
                    "subject_list_department" => $info['user']->professor_department,
                    "subject_list_is_active" => 1,
                    "subject_list_description" => $subject_desc,
                    "year_level_id" => $year_level
                );
                $result = $this->Crud_model->insert("subject_list", $insert_data);
                $last_id = $this->db->insert_id();

                $topics = $this->input->post("topic_list");
                $insert_batch = [];
                foreach($topics as $each){
                    $temp = array(
                        "subject_list_id" => $last_id,
                        "topic_list_id" => (int)$each+1
                    );
                    $insert_batch[] = $temp;
                }
                $this->Crud_model->insert_batch("subject_list_has_topic_list", $insert_batch);

                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $error_message[] = "An error occured when your action is on process. Please try again.";
                    unset($data);
                    $data = array(
                        "option_select" => $result,
                        "topics" => $topics,
                        "error" => true,
                        "error_message" => $error_message
                    );
                    $this->load->view('subject_area/add_subject_area', $data);
                } else {
                    $this->db->trans_commit();
                    $this->load->view("subject_area/success_add_subject_area");
                }
            }

            $this->load->view('includes/footer');
        } else {
            redirect();
        }
    }

    public function update_topic_list($id){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
        //call this kapag nagselect yung user sa year_level
            $info = $this->session->userdata('userInfo');
            $yl_id = $id;     //year_level_id
            $col = "tl.topic_list_id";
            $where = array(
                "sl.subject_list_department" => $info['user']->professor_department,
                "yl.year_level_id" => $yl_id,
                "sl.subject_list_is_active" => 1,
                "tl.topic_list_is_active" => 1
            );
            $join = array(
                array("subject_list_has_topic_list as slhtl", "tl.topic_list_id = slhtl.topic_list_id"),
                array("subject_list as sl", "slhtl.subject_list_id = sl.subject_list_id"),
                array("year_level as yl", "sl.year_level_id = yl.year_level_id")
            );
            $result = $this->Crud_model->fetch_join2("topic_list as tl", $col, $join, NULL, $where, TRUE); 

        // echo $this->db->last_query();

            if ($result) {
                foreach($result as $res){
                    $topic_ids[] = $res->topic_list_id;
                }
                $wherenotin[0] = "topic_list_id";
                $wherenotin[1] = $topic_ids;
                unset($result);
                $col = "topic_list_id, topic_list_name, topic_list_description";
                $orderby[0] = "topic_list_name";
                $orderby[1] = "ASC";
                $result = $this->Crud_model->fetch_select("topic_list", $col, NULL, NULL, TRUE, NULL, NULL, true, $orderby, NULL, $wherenotin);
            // unset($data);
            // $data["data"] = $result;
            // echo "<pre>";
            // print_r(json_encode($result));
                return $result;
            }else{
                $col = "topic_list_id, topic_list_name, topic_list_description";
                $orderby[0] = "topic_list_name";
                $orderby[1] = "ASC";
                $result = $this->Crud_model->fetch_select("topic_list", $col, NULL, NULL, TRUE, NULL, NULL, true, $orderby);
                return $result;
            }
        // print_r(json_encode($data));
        } else {
            redirect();
        }
    }

    public function edit_subjectarea(){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            if (!empty($segment_yl = $this->uri->segment(3)) && !empty($segment_subj = $this->uri->segment(4)) && is_numeric($segment_yl) && is_numeric($segment_subj)) {
                $info = $this->session->userdata('userInfo');

                $col = "sl.subject_list_name, sl.subject_list_id, sl.subject_list_description, yl.year_level_name, yl.year_level_id";
                $where = array(
                    "yl.year_level_id" => $segment_yl,
                    "sl.subject_list_department" => $info['user']->professor_department,
                    "sl.subject_list_id" => $segment_subj
                );
                $join = array(
                    array("year_level as yl", "yl.year_level_id = sl.year_level_id")
                );
                $subj = $this->Crud_model->fetch_join2("subject_list as sl", $col, $join, NULL, $where);

                $data = array(
                    "title" => "Subject Area Management",
                    'info' => $info,
                    "s_h" => "",
                    "s_a" => "",
                    "s_f" => "",
                    "s_c" => "",
                    "s_t" => "",
                    "s_s" => "selected-nav",
                    "s_co" => "",
                    "s_ss" => "",
                    "subj" => $subj
                );
                $this->load->view('includes/header', $data); 
                $this->load->view('subject_area/edit_subject_area');
                $this->load->view('includes/footer');
            } else {
                redirect("SubjectArea");
            }
        } else {
            redirect();
        }
    }

    public function edit_submit(){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            if (!empty($segment_yl = $this->uri->segment(3)) && !empty($segment_subj = $this->uri->segment(4)) && is_numeric($segment_yl) && is_numeric($segment_subj)) {
                $info = $this->session->userdata('userInfo');

                $col = "sl.subject_list_name, sl.subject_list_id, sl.subject_list_description, yl.year_level_name, yl.year_level_id";
                $where = array(
                    "yl.year_level_id" => $segment_yl,
                    "sl.subject_list_department" => $info['user']->professor_department,
                    "sl.subject_list_id" => $segment_subj
                );
                $join = array(
                    array("year_level as yl", "yl.year_level_id = sl.year_level_id")
                );
                $subj = $this->Crud_model->fetch_join2("subject_list as sl", $col, $join, NULL, $where);
                $error_message = [];
                if(!empty($subj)){
                    $this->form_validation->set_rules('subject_area', 'Subject Area name', 'required|max_length[100]|min_length[5]');
                    $this->form_validation->set_rules('subject_description', 'Subject Area description', 'required|min_length[5]');

                    $temp = $this->hack_check($this->input->post("subject_area"));
                    if($temp["confirm"] === true){ //xss positive, repeat input
                        $error_message[] = "The system detected invalid input in the Subject Area field. Please try again.";
                    } else {
                        $subj_name = $temp["string"];
                    }

                    $temp = $this->hack_check($this->input->post("subject_description"));
                    if($temp["confirm"] === true){ //xss positive, repeat input
                        $error_message[] = "The system detected invalid input in the Subject Area Description field. Please try again.";
                    } else {
                        $subj_desc = $temp["string"];
                    }

                    if(strcasecmp($subj_name, $subj[0]->subject_list_name) === 0 && strcasecmp($subj_desc, $subj[0]->subject_list_description) === 0){
                        $error_message[] = "Do not enter same words/characters. Please try again.";
                    }

                    $data = array(
                        "title" => "Subject Area Management",
                        'info' => $info,
                        "s_h" => "",
                        "s_a" => "",
                        "s_f" => "",
                        "s_c" => "",
                        "s_t" => "",
                        "s_s" => "selected-nav",
                        "s_co" => "",
                        "s_ss" => "",
                        "subj" => $subj
                    );
                    $this->load->view('includes/header', $data);
                    if ($this->form_validation->run() == FALSE || !empty($error_message)) { //wrong
                        unset($data);
                        $data = array(
                            "error_message" => $error_message
                        );
                        $this->load->view('subject_area/edit_subject_area', $data);
                    } else {
                        //GET ID'S WITH SAME NAME AND DESC
                        $record_name = $subj[0]->subject_list_name;
                        $record_desc = $subj[0]->subject_list_description;
                        $col = "subject_list_id";
                        $where = array(
                            "subject_list_name" => $record_name,
                            "subject_list_description" => $record_desc,
                            "subject_list_department" => $info['user']->professor_department
                        );
                        $with_same = $this->Crud_model->fetch_select("subject_list", $col, $where);

                        foreach($with_same as $same){
                            $list[] = $same->subject_list_id;
                        }

                        $wherenotin = array(
                            0 => "subject_list_id",
                            1 => $list
                        );
                        $col = "subject_list_id";
                        $where = array(
                            "subject_list_name" => $subj_name,
                            "subject_list_department" => $info['user']->professor_department
                        );
                        $subj_check = $this->Crud_model->fetch_select("subject_list", $col, $where, NULL, NULL,NULL, NULL, NULL, NULL, NULL, $wherenotin);

                        //THERE'S ALREADY THIS NAME IN THIS DEPT
                        if(!empty($subj_check)) {
                            $error_message[] = "There is already '$subj_name' Subject Area. Please try again.";
                        }
                            // LAST - update query
                        $check = false;
                        $this->db->trans_begin();
                        if(!empty($error_message)){
                            $check = true;
                        } else {
                            unset($data);
                            $data = [];
                            foreach($list as $li){
                                $temp = array(
                                    "subject_list_id" => $li,
                                    "subject_list_name" => strtoupper($subj_name),
                                    "subject_list_description" => $subj_desc,
                                );
                                $data[] = $temp;
                            }
                            $this->Crud_model->updatebatch("subject_list", $data, "subject_list_id");
                        }

                        if ($this->db->trans_status() === FALSE || $check){
                            $this->db->trans_rollback();
                            unset($data);
                            $data = array(
                                "error_message" => $error_message
                            );
                            $this->load->view('subject_area/edit_subject_area', $data);
                        } else {
                            $this->db->trans_commit();
                            $this->load->view("subject_area/success_edit_subject_area");
                        }
                    }
                    $this->load->view('includes/footer');
                } else {
                    redirect("SubjectArea");
                }
            } else {
                redirect("SubjectArea");
            }
        } else {
            redirect();
        }
    }

    public function delete_subject_area(){
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');
            $id = $this->input->post("id");
            if (!empty($segment = $this->uri->segment(3)) && is_numeric($segment) && !empty($id) && is_numeric($id)) {
                $where = array(
                    "subject_list_id" => $id,
                    "year_level_id" => $segment
                );
                $data = array("subject_list_is_active" => 0);
                $this->db->trans_begin();
                $result = $this->Crud_model->update("subject_list", $data, $where);

                if ($this->db->trans_status() === FALSE || $result = 0){
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
            reirect();
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
