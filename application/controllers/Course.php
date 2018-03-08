<?php

date_default_timezone_set("Asia/Manila");
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');

            if (is_array($hold = $this->get_active_enrollment())) {        //checks if this is array, else it is error coz multiple active enrollment
                $enrollment_active = $hold[0]->enrollment_id;

                $data = array(
                    "title" => "Section Management",
                    'info' => $info,
                    "s_h" => "",
                    "s_a" => "",
                    "s_c" => "",
                    "s_f" => "",
                    "s_s" => "",
                    "s_co" => "selected-nav",
                    "s_t" => ""
                );
                $this->load->view('includes/header', $data);

                $col = 'cou.course_id, cou.course_course_title, cou.course_course_code, cou.course_is_active';
                $where = array('cou.enrollment_id' => $enrollment_active, 'cou.course_department' => $info["user"]->professor_department);
                if ($result = $this->Crud_model->fetch_select("course as cou", $col, $where)) {

                    foreach ($result as $key => $res) {
                        $var = (string) $res->course_id;
                        $result[$key]->course_id_sha = $this->hash_id($var);
                    }
                    $data = array(
                        "result" => $result
                    );
                    $this->load->view('course/main', $data);
                } else {
                    $this->load->view('course/main');
                }
                $this->load->view('includes/footer');
            } else {
                redirect("Course");
            }
        } else {
            redirect("");
        }
    }

    public function view() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');

            if (is_array($hold = $this->get_active_enrollment())) {        //checks if this is array, else it is error coz multiple active enrollment
                $enrollment_active = $hold[0]->enrollment_id;

                $col = 'course_id, course_course_title, course_course_code, course_is_active';
                $where = array('enrollment_id' => $enrollment_active, 'course_department' => $info["user"]->professor_department,
                    "professor_id" => $info["user"]->professor_id);
                $isit = false;
                if ($course_orig = $this->Crud_model->fetch_select("course", $col, $where)) {

                    $segment = $this->uri->segment(3);  //get segment
                    foreach ($course_orig as $key => $res) {
                        $var = $res->course_id;
                        if ($segment == $this->hash_id($var)) {
                            $isit = true;
                            $hold_key = $key;
                            break;
                        }
                    }
                }
                $col = 'subject_list_name, year_level_name';
                $where = array('cou.enrollment_id' => $enrollment_active, 'cou.course_department' => $info["user"]->professor_department,
                    "cou.professor_id" => $info["user"]->professor_id, "sl.subject_list_department" => $info["user"]->professor_department,
                    "cou.course_id" => $var);
                $join = array(
                    array("year_level as yl", "yl.year_level_id = sl.year_level_id"),
                    array("course as cou", "cou.year_level_id = yl.year_level_id")
                );

                $subject_year_course = $this->Crud_model->fetch_join2("subject_list as sl", $col, $join, NULL, $where);
//                echo "<pre>";
//                print_r($subject_year_course);
                if ($isit) {
                    $course = $course_orig[$hold_key];
                    $col = 'off.offering_id, off.offering_name, sch.schedule_start_time, sch.schedule_end_time, sch.schedule_venue';
                    $where = array("off.course_id" => $course_orig[$hold_key]->course_id);
                    $join = array(
                        array(
                            "schedule as sch", "sch.offering_id = off.offering_id"
                        )
                    );

                    if ($result = $this->Crud_model->fetch_join2("offering as off", $col, $join, NULL, $where)) {
                        foreach ($result as $key => $res) {
                            $result[$key]->format_time = date("g:iA", $res->schedule_start_time) . "-" . date("g:iA", $res->schedule_end_time);
                            $result[$key]->format_day = date("D", $res->schedule_start_time);
                        }
                    }

                    $data = array(
                        "title" => "Section Management",
                        'info' => $info,
                        "s_h" => "",
                        "s_a" => "",
                        "s_c" => "",
                        "s_f" => "",
                        "s_s" => "",
                        "s_co" => "selected-nav",
                        "s_t" => "",
                        "result" => $result,
                        "course_title" => $course->course_course_title,
                        "course_code" => $course->course_course_code,
                        "subject_year_course" => $subject_year_course
                    );
                    $this->load->view('includes/header', $data);
                    $this->load->view('course/view');
                    $this->load->view('includes/footer');
                } else {
                    redirect("Course");
                }
            } else {
//                echo $hold;
                redirect("Course");
            }
        } else {
            redirect();
        }
    }

    public function add() {
//        echo $this->input->post("subject_area");
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');

            $this->form_validation->set_rules('course_code', "Course Code", "required|alpha_numeric_spaces|min_length[3]|max_length[20]");
            $this->form_validation->set_rules('course_title', "Course Title", "required|alpha_numeric_spaces|min_length[3]|max_length[100]");

            $where = array(
                "sl.subject_list_department" => $info["user"]->professor_department,
                "sl.subject_list_is_active" => 1
            );
            $join = array(array("subject_list as sl", "sl.year_level_id = yl.year_level_id"));
            $col = "yl.year_level_id, yl.year_level_name, sl.subject_list_id, sl.subject_list_name";
            $result = $this->Crud_model->fetch_join2("year_level as yl", $col, $join, NULL, $where, FALSE);

            foreach ($result as $key => $res) {     //group them base on year_level_id
                $var = $res->year_level_id;
                if ($this->input->post("subject-area") == $this->hash_id($var)) {
                    $hold_key = $var;
                }
                $result[$key]->year_level_id = $this->hash_id($var);
                $hold[$res->year_level_id][0][] = $res->subject_list_name;
                $hold[$res->year_level_id][1]["year_level_name"] = $res->year_level_name;
            }
            $data = array(
                "title" => "Course Management",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_c" => "",
                "s_f" => "",
                "s_s" => "",
                "s_co" => "selected-nav",
                "s_t" => "",
                "hold" => $hold
            );
            $this->load->view('includes/header', $data);
            if ($this->form_validation->run() == FALSE) {       //wrong
                $this->load->view('course/add');
            } else {
                $holdpost = $this->input->post(array('course_code', 'course_title'));
                $col = "course_id";
                $where = "(course_course_code='" . $holdpost["course_code"] . "' OR course_course_title='" .
                        $holdpost["course_title"] . "') AND enrollment_id='" . $this->get_active_enrollment()[0]->enrollment_id .
                        "' AND course_department='" . $info["user"]->professor_department . "'";

                if ($this->Crud_model->fetch_select("course", $col, $where)) {
                    $error_message[] = "Course Code and Coude Title should be unique to other courses in your department. (Duplicate data)";
                    $data = array(
                        "error_message" => $error_message
                    );
                    $this->load->view('course/add', $data);
                } else {
                    $data = array(
                        "course_course_code" => $holdpost["course_code"],
                        "course_course_title" => $holdpost["course_title"],
                        "course_department" => $info["user"]->professor_department,
                        "course_is_active" => 1,
                        "enrollment_id" => $this->get_active_enrollment()[0]->enrollment_id,
                        "professor_id" => $info["user"]->professor_id,
                        "year_level_id" => $hold_key
                    );
                    $result = $this->Crud_model->insert("course", $data);
                    $c_id = $this->db->insert_id();
                    $dept = $info["user"]->professor_department;
                    $this->add_subject($c_id, $dept);

                    redirect("Course");
                }
            }

            $this->load->view('includes/footer');
        } else {
            redirect();
        }
    }

    public function edit() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');
            if (is_array($hold = $this->get_active_enrollment())) {        //checks if this is array, else it is error coz multiple active enrollment
                $enrollment_active = $hold[0]->enrollment_id;

                $this->form_validation->set_rules('course_code', "Course Code", "required|alpha_numeric_spaces|min_length[3]|max_length[20]");
                $this->form_validation->set_rules('course_title', "Course Title", "required|alpha_numeric_spaces|min_length[3]|max_length[100]");

                if (!empty($segment = $this->uri->segment(3))) {
                    $col = 'cou.course_id, cou.course_course_title, cou.course_course_code, cou.course_is_active, cou.year_level_id';
                    $where = array('cou.enrollment_id' => $enrollment_active, 'cou.course_department' => $info["user"]->professor_department);
                    $result = $this->Crud_model->fetch_select("course as cou", $col, $where);
//                echo"<pre>";
//                print_r($result);
                    foreach ($result as $key => $res) {
                        $var = (string) $res->course_id;
                        if ($segment == $this->hash_id($var)) {
                            $course_key = $key;
                            $match_course = $var;
                            $match_year_level_id = $res->year_level_id;
                            break;
                        }
                    }
                    unset($hold);
                    $col = 'sl.subject_list_name, sl.subject_list_id, sl.year_level_id, yl.year_level_name';
                    $where = array("sl.subject_list_department" => $info["user"]->professor_department, "sl.subject_list_is_active" => 1);
                    $join = array(array("year_level as yl", "yl.year_level_id = sl.year_level_id"));
                    $cys = $this->Crud_model->fetch_join2("subject_list as sl", $col, $join, NULL, $where);

                    foreach ($cys as $key => $res) {     //group them base on year_level_id
                        $var = $res->year_level_id;
                        $cys[$key]->year_level_id = $this->hash_id($var);
                        $hash_holder[$this->hash_id($var)] = $var;
                        $hold[$res->year_level_id][0][] = $res->subject_list_name;
                        $hold[$res->year_level_id][1]["year_level_name"] = $res->year_level_name;
                    }
                    $var = $result[$course_key]->year_level_id;
                    $result[$course_key]->year_level_id = $this->hash_id($var);

                    $data = array(
                        "title" => "Course Management",
                        'info' => $info,
                        "s_h" => "",
                        "s_a" => "",
                        "s_c" => "",
                        "s_f" => "",
                        "s_s" => "",
                        "s_co" => "selected-nav",
                        "s_t" => "",
                        "select" => $hold,
                        "line" => $result[$course_key]
                    );
                    $this->load->view('includes/header', $data);
                    if ($this->form_validation->run() == FALSE) {       //wrong
                        $this->load->view('course/edit');
                    } else {                                //input are valid
                        $holdpost = $this->input->post(array('course_code', 'course_title', 'subject-area'));
                        $col = "course_id";
                        $where = "(course_course_code='" . $holdpost["course_code"] . "' OR course_course_title='" .
                                $holdpost["course_title"] . "') AND enrollment_id='" . $this->get_active_enrollment()[0]->enrollment_id .
                                "' AND course_department='" . $info["user"]->professor_department . "' AND course_id !='" . $match_course . "'";

                        if ($this->Crud_model->fetch_select("course", $col, $where)) {
                            $error_message[] = "Course Code and Coude Title should be unique to other courses in your department. (Duplicate data)";
                            $data = array(
                                "error_message" => $error_message
                            );
                            $this->load->view('course/edit', $data);
                        } else {            //no duplicate
                            $c_id = $match_course;
                            $dept = $info["user"]->professor_department;
                            $this->update_subject($c_id, $dept);

                            $where = array("course_id" => $match_course);
                            $data = array(
                                "course_course_code" => $holdpost["course_code"],
                                "course_course_title" => $holdpost["course_title"],
                                "year_level_id" => $hash_holder[$holdpost["subject-area"]]
                            );

                            $result = $this->Crud_model->update("course", $data, $where);
                            redirect("Course");
                        }
                    }
                    $this->load->view('includes/footer', $data);
                } else {
                    redirect("Course");
                }
            } else {
                redirect("Course");
            }
        } else {
            redirect();
        }
    }

    public function delete() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "professor") {
            $info = $this->session->userdata('userInfo');

            if (is_array($hold = $this->get_active_enrollment())) {        //checks if this is array, else it is error coz multiple active enrollment
                $enrollment_active = $hold[0]->enrollment_id;

                $col = 'cou.course_id, cou.course_course_title, cou.course_course_code';
                $where = array('cou.enrollment_id' => $enrollment_active, 'cou.course_department' => $info["user"]->professor_department,
                    "cou.professor_id" => $info["user"]->professor_id);
                $isit = false;
                if ($result = $this->Crud_model->fetch_select("course as cou", $col, $where)) {
                    $segment3 = $this->uri->segment(3);  //get segment
                    foreach ($result as $key => $res) {
                        $var = $res->course_id;
                        if ($segment3 == $this->hash_id($var)) {
                            $isit = true;
                            $hold_key = $key;
                            break;
                        }
                    }
                }
                $segment4 = $this->uri->segment(4);
                if ($isit && ($segment4 == 1 || $segment4 == 0)) {

                    $course = $result[$hold_key]->course_id;

                    $data = array("course_is_active" => (int) $segment4);
                    $where = array("course_id" => $course);
                    $result = $this->Crud_model->update("course", $data, $where);
                    echo $result;
                    if ($result > 0) {       //success
                        redirect("Course");
                    } else {
                        $this->load->view('includes/header');
                        $this->load->view('course/error_delete');
                        $this->load->view('includes/footer');
                    }
                } else {
                    redirect("Course");
                }
            } else {
                echo $hold;
            }
        } else {
            redirect();
        }
    }

    private function update_subject($c_id, $dept) {
        $where = "course_id='" . $c_id . "'";
        $result_subject_list = $this->Crud_model->fetch_select("subject", "subject_id", $where);
        echo "<pre>";
        foreach ($result_subject_list as $subsl) {
            $subject_id = $subsl->subject_id;
            $where = "subject_id='" . $subject_id . "'";
            $this->db->delete('topic', $where);
            $where = "subject_id='" . $subject_id . "'";
            $this->db->delete('subject', $where);
        }
        $this->add_subject($c_id, $dept);
//        $this->Crud_model->delete("course", array('course_id' => $c_id));
    }

    private function add_subject($c_id, $dept) {
        $where = "course_id='" . $c_id . "'";
        $result_course = $this->Crud_model->fetch_select("course", "year_level_id", $where)[0];

        $year_level_id = $result_course->year_level_id;
        $where = array(
            "year_level_id" => $year_level_id,
            "subject_list_department" => $dept,
            "subject_list_is_active" => 1
        );
        $result_sl = $this->Crud_model->fetch_select("subject_list", "subject_list_id, subject_list_name, subject_list_description", $where);
//        print_r($result_sl);

        foreach ($result_sl as $res) {
            $temp = array(
                "subject_name" => $res->subject_list_name,
                "subject_description" => $res->subject_list_description,
                "lecturer_id" => NULL,
                "course_id" => $c_id,
                "subject_list_id" => $res->subject_list_id
            );
            $this->Crud_model->insert("subject", $temp);
            $subject_id = $this->db->insert_id();

            $where = array(
                "sl.year_level_id" => $year_level_id,
                "sl.subject_list_department" => $dept,
                "sl.subject_list_id" => $res->subject_list_id,
                "tl.topic_list_is_active" => 1,
                "sl.subject_list_is_active" => 1
            );
            $col = "tl.topic_list_id, tl.topic_list_name, tl.topic_list_description";
            $join = array(
                array("subject_list_has_topic_list as slhtl", "slhtl.subject_list_id = sl.subject_list_id"),
                array("topic_list as tl", "tl.topic_list_id = slhtl.topic_list_id")
            );
            $result_slhtl = $this->Crud_model->fetch_join2("subject_list as sl", NULL, $join, NULL, $where);
//            print_r($result_slhtl);

            foreach ($result_slhtl as $subres) {
                $temp = array(
                    "topic_name" => $subres->topic_list_name,
                    "topic_description" => $subres->topic_list_description,
                    "topic_done" => 0,
                    "subject_id" => $subject_id,
                    "topic_list_id" => $subres->topic_list_id
                );
                $topic_batch[] = $temp;
            }
//            print_r($topic_batch);
            $this->Crud_model->insert_batch("topic", $topic_batch);
            unset($topic_batch);
        }
//        $this->Crud_model->delete("course", array('course_id' => $c_id));
    }

    private function get_active_enrollment() {
        $where = array("enrollment_is_active" => 1);
        if (count($result = $this->Crud_model->fetch_select("enrollment", NULL, $where)) != 1) {
            return "There are multiple active enrollment.";
        } else if ($result) {
            return $result;
        } else {
            return "There is no activated enrollment";
        }
    }

    private function hash_id($var) {
        return substr(sha1($var), 1, 10);
    }

}
