<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Manila");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Sections extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            $info = $this->session->userdata('userInfo');

            $enrollment = $this->get_active_enrollment()[0];
            $enrollment = $enrollment->enrollment_id;

            $col = "course_id ,course_course_code, course_course_title";
            $where = array(
                "course_department" => $info["user"]->fic_department,
                "course_is_active" => 1,
                "enrollment_id" => $enrollment
            );
            $result_course = $this->Crud_model->fetch_select("course", $col, $where);
//            echo "<pre>";
//            print_r($result_course);

            $data = array(
                "title" => "Sections",
                'info' => $info,
                "s_h" => "",
                "s_a" => "",
                "s_f" => "",
                "s_c" => "",
                "s_t" => "",
                "s_s" => "selected-nav",
                "s_co" => "",
                "s_ss" => "",
                "course" => $result_course
            );
            $this->load->view('includes/header', $data);
            $this->load->view('sections/main');
            $this->load->view('includes/footer');
        } else {
            redirect();
        }
    }

    public function view_sections() {
        //TYPE ON URL BAR, CAN ACCESS OTHER COURSES AND ADD SECTIONS

        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            $info = $this->session->userdata('userInfo');
            if (!empty($segment = $this->uri->segment(3)) && is_numeric($segment)) {    //course_id
                $col = "course_id";
                $where = array(
                    "course_id" => $segment,
                    "course_department" => $info["user"]->fic_department
                );
                if ($result_course = $this->Crud_model->fetch_select("course", $col, $where)) {
                    $col = "offering_id,offering_name";
                    $where = array(
                        "course_id" => $segment,
                        "offering_department" => $info["user"]->fic_department
                    );
                    $result_offering = $this->Crud_model->fetch_select("offering", $col, $where);

                    //GET COURSE DETAILS
                    $col = "course_course_code,course_course_title";
                    $where = array(
                        "course_id" => $segment,
                        "course_department" => $info["user"]->fic_department,
                        "enrollment_id" => $this->get_active_enrollment()[0]->enrollment_id         //enrollment id of active
                    );
                    $result_course = $this->Crud_model->fetch_select("course", $col, $where);
                    //END - COURSE DETAILS
                    //
                    //GET SUBJ-AREA
                    $enrollment_active = $this->get_active_enrollment()[0]->enrollment_id;
                    $col = 'subject_list_name, year_level_name';
                    $where = array(
                        'cou.enrollment_id' => $enrollment_active,
                        'cou.course_department' => $info["user"]->fic_department,
                        "sl.subject_list_department" => $info["user"]->fic_department,
                        "cou.course_id" => $segment);
                    $join = array(
                        array("year_level as yl", "yl.year_level_id = sl.year_level_id"),
                        array("course as cou", "cou.year_level_id = yl.year_level_id")
                    );

                    $subject_year_course = $this->Crud_model->fetch_join2("subject_list as sl", $col, $join, NULL, $where);
                    //END - GET SUBJ-AREA

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
                        "offering" => $result_offering,
                        "course" => $result_course,
                        "subject_year_course" => $subject_year_course
                    );
                    $this->load->view('includes/header', $data);
                    $this->load->view('sections/course_view');
                    $this->load->view('includes/footer');
                } else {        //wrong segment
                    redirect("Sections");
                }
            } else {        //no segment
                redirect("Sections");
            }
        } else {
            redirect();
        }
    }

    public function add() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            if (!empty($segment = $this->uri->segment(3)) && is_numeric($segment)) {
                $info = $this->session->userdata('userInfo');
                $col = "course_id";
                $where = array(
                    "course_id" => $segment,
                    "course_department" => $info["user"]->fic_department
                );
                if ($result_course = $this->Crud_model->fetch_select("course", $col, $where)) {
                    require "./application/vendor/autoload.php";
                    $config['upload_path'] = "./assets/uploads/";
                    $config['allowed_types'] = 'xls|csv|xlsx';
                    $config['max_size'] = '2048000';
                    $config["file_name"] = "section_" . time();
                    $this->load->library('upload', $config);

                    $lecturers = $this->Crud_model->fetch_select("lecturer");

                    //GET COURSE DETAILS
                    $col = "course_course_code,course_course_title";
                    $where = array(
                        "course_id" => $segment,
                        "course_department" => $info["user"]->fic_department,
                        "enrollment_id" => $this->get_active_enrollment()[0]->enrollment_id         //enrollment id of active
                    );
                    $result_course = $this->Crud_model->fetch_select("course", $col, $where);
                    //END - GET COURSE DETAILS
                    //GET SUBJ-AREA
                    $enrollment_active = $this->get_active_enrollment()[0]->enrollment_id;
                    $col = 'subject_list_name, year_level_name';
                    $where = array(
                        'cou.enrollment_id' => $enrollment_active,
                        'cou.course_department' => $info["user"]->fic_department,
                        "sl.subject_list_department" => $info["user"]->fic_department,
                        "cou.course_id" => $segment);
                    $join = array(
                        array("year_level as yl", "yl.year_level_id = sl.year_level_id"),
                        array("course as cou", "cou.year_level_id = yl.year_level_id")
                    );

                    $subject_year_course = $this->Crud_model->fetch_join2("subject_list as sl", $col, $join, NULL, $where);
                    //END - GET SUBJ-AREA

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
                        "lecturer" => $lecturers,
                        "course2" => $result_course,
                        "subject_year_course" => $subject_year_course
                    );
                    $this->load->view('includes/header', $data);

                    if ($this->upload->do_upload('excel_file')) {            //success upload
                        $upload_data = $this->upload->data();

                        $this->form_validation->set_rules('section_name', "Section Name", "required|alpha_numeric_spaces|min_length[2]|max_length[5]");

                        if ($this->form_validation->run() == FALSE) {       //wrong input
                            $this->load->view('sections/add');
                        } else {                                            //success
                            //SPREADSHEET SETUP
                            $spreadsheet = IOFactory::load($upload_data["full_path"]);
                            $spreadsheet->setActiveSheetIndex(0);
                            $sheetname = $spreadsheet->getSheetNames();
                            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                            //END - SPREADSHEET SETUP

                            $this->db->trans_begin();

                            //checks if there's already this name of section
                            $where = array(
                                "offering_name" => $this->input->post("section_name"),
                                "course_id" => $segment,
                                "offering_department" => $info["user"]->fic_department
                            );
                            $col = "offering_id";
                            $temp = $this->Crud_model->fetch_select("offering", $col, $where);

                            if (!$temp) {                                                       //checks if there's already this name of section
                            $temp = array(
                                "offering_name" => strtoupper($this->input->post("section_name")),
                                "offering_department" => $info["user"]->fic_department,
                                "course_id" => $segment,
                                "fic_id" => $info["user"]->fic_id
                            );
                            $this->Crud_model->insert('offering', $temp);
                            $section_id = $this->db->insert_id();
                            $sections = $this->get_sections();

                            $isit = false;

                                //check if correct col name
                            foreach ($sections as $subsec) {
                                if (strtolower((string) $sheetname[0]) == strtolower($subsec->offering_name) && strtolower($sheetname[1]) == "schedule") {
                                    $isit = true;
                                        if (strtolower($sheetData[1]["A"]) == "student number") {         //check first row col
                                            for ($i = 2; $i <= count($sheetData); $i++) {
                                                if ($sheetData[$i]["A"] !== null) {
                                                    if (strlen($sheetData[$i]["A"]) == 9) {
                                                        $stud_ids[] = $sheetData[$i]["A"];
                                                    } else {
                                                        $error_message[] = "Make sure the student number is valid. Row $i";
                                                        break;
                                                    }
                                                }
                                            }
                                            $all_studs = $this->Crud_model->fetch_select("student_list", NULL, NULL, NULL, NULL, array("student_id", $stud_ids));
                                            foreach ($all_studs as $suball_studs) {
                                                $list_of_id[] = $suball_studs->student_id;
                                                $temp = array(
                                                    "student_id" => $suball_studs->student_id,
                                                    "firstname" => $suball_studs->firstname,
                                                    "midname" => $suball_studs->midname,
                                                    "lastname" => $suball_studs->lastname,
                                                    "username" => $suball_studs->username,
                                                    "password" => $suball_studs->password,
                                                    "email" => $suball_studs->email,
                                                    "student_department" => $suball_studs->department,
                                                    "image_path" => $suball_studs->image_path,
                                                    "offering_id" => $section_id
                                                );
                                                $insert_batch_students[] = $temp;
                                            }
                                            //CHECKS IF STUD IS ALREADY ENROLLED
                                            $col = array("stud.student_id, off.offering_name, CONCAT(stud.firstname,' ',stud.midname,' ',stud.lastname) as full_name", FALSe);
                                            $where = array(
                                                "cou.enrollment_id" => $enrollment_active
                                            );
                                            $join = array(
                                                array("offering as off", "off.course_id = cou.course_id"),
                                                array("student as stud", "stud.offering_id = off.offering_id")
                                            );
                                            $wherein = array(
                                                "stud.student_id",
                                                $list_of_id
                                            );
                                            $temp = $this->Crud_model->fetch_join2("course as cou", $col, $join, NULL, $where, NULL, NULL, $wherein);
                                            if (!empty($temp)) {
                                                $temp = $temp[0];
                                                $error_message[] = $temp->student_id . " - " . $temp->full_name . " is already enrolled in " . $temp->offering_name;
                                            } else {
                                                $this->Crud_model->insert_batch("student", $insert_batch_students);
                                            }
                                        }
                                        break;
                                    }
                                }
                                if (!$isit) {
                                    $error_message[] = "This should be the format of your Excel:";
                                    $error_message[] = "&emsp;-First sheet's name: *name of section*";
                                    $error_message[] = "&emsp;-Second sheet's name: 'schedule'";
                                }
                                //change to the second sheet
                                $spreadsheet->setActiveSheetIndex(1);

                                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                                if (strtolower($sheetData[1]["A"]) == "day" && strtolower($sheetData[1]["B"]) == "start time" && strtolower($sheetData[1]["C"]) == "end time" && strtolower($sheetData[1]["D"]) == "venue") {
                                    if ((strlen(date("hia", strtotime($sheetData[2]["B"]))) == 6) && (strlen(date("hia", strtotime($sheetData[2]["C"]))) == 6) &&
                                        (date("hia", strtotime($sheetData[2]["B"])) < date("hia", strtotime($sheetData[2]["C"]))) &&
                                        (strtolower($sheetData[2]["A"]) == "monday" || strtolower($sheetData[2]["A"]) == "tuesday" ||
                                            strtolower($sheetData[2]["A"]) == "wednesday" || strtolower($sheetData[2]["A"]) == "thursday" ||
                                            strtolower($sheetData[2]["A"]) == "friday" || strtolower($sheetData[2]["A"]) == "saturday") &&
                                        (strlen(strtolower($sheetData[2]["D"]) <= 5))) {

                                        $start = strtotime(strtoupper($sheetData[2]["A"]) . " " . $sheetData[2]["B"]); 
                                    $end = strtotime(strtoupper($sheetData[2]["A"]) . " " . $sheetData[2]["C"]);
                                    $venue = strtoupper($sheetData[2]["D"]);

                                    $schedule = array(
                                        "schedule_start_time" => $start,
                                        "schedule_end_time" => $end,
                                        "schedule_venue" => $venue,
                                        "lecturer_id" => $this->input->post("lect_id"),
                                        "offering_id" => $section_id
                                    );

                                    $this->Crud_model->insert("schedule", $schedule); 
                                    } else {            //invalid time
                                        $isit2 = true;
                                        $error_message[] = "Make sure your schedule is valid. Check spellings and format of time:";
                                        $error_message[] = "&emsp;-Day: *day in week*";
                                        $error_message[] = "&emsp;-Start/End time: 00:00 am/pm";
                                    }
                                } else {
                                    $error_message[] = "Check your row 1 in schedule sheet:";
                                    $error_message[] = "&emsp;-A: 'day'";
                                    $error_message[] = "&emsp;-B: 'start time'";
                                    $error_message[] = "&emsp;-C: 'end time'";
                                    $error_message[] = "&emsp;-C: 'venue'";
                                }
                                $where = array(
                                    "course_id" => $segment
                                );
                                $changes = array(
                                    "lecturer_id" => $this->input->post("lect_id")
                                );
                                $this->Crud_model->update("subject", $changes, $where); //updates subject table
                                if (!empty($error_message)) {
                                    $data = array(
                                        "error_message" => $error_message
                                    );
                                    $this->load->view('sections/add', $data);
                                } else {                                            //goods
                                    if ($this->db->trans_status() === FALSE) {          //error dbase
                                        $this->db->trans_rollback();
                                        $error_message[] = "An error occured while processing the data.";

                                        $data = array(
                                            "error_message" => $error_message
                                        );
                                        $this->load->view('sections/add', $data);
                                    } else {                                            //success dbase
                                        $this->db->trans_commit();
                                        redirect("Sections/view_sections/" . $segment);
                                    }
                                }
                            } else {
                                $error_message[] = "Sections in a course should be unique to other. (Duplicate name)";
                                $data = array(
                                    "error_message" => $error_message
                                );
                                $this->load->view('sections/add', $data);
                            }
                        }
                    } else {                                        //failed upload
                        $error_message[] = $this->upload->display_errors();
                        $data = array(
                            "error_message" => $error_message
                        );
                        $this->load->view('sections/add', $data);
                        if (file_exists($this->upload->data()["full_path"])) {      //file is deleted when there's error
                        unlink($this->upload->data()["full_path"]);
                    }
                }
                $this->load->view('includes/footer');
                } else {            //wrong course
                    redirect("Sections");
                }
            } else {
                redirect("Sections");
            }
        } else {
            redirect();
        }
    }

    public function section_detail() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            $info = $this->session->userdata('userInfo');

            $data = array(
                "title" => "Sections",
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
            $this->load->view('sections/section_detail');
            $this->load->view('includes/footer');
        } else {
            redirect();
        }
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

    private function get_sections() {
        $segment = $this->uri->segment(3);
        $info = $this->session->userdata('userInfo');
        /* GETTING ALL OFFERINGS */
        $data = array(
            'title' => "Imported",
            "info" => $info
        );
        $col = "off.offering_name, off.offering_id";
        $where = array(
            "off.fic_id" => $info["user"]->fic_id,
            "off.offering_department" => $info["user"]->fic_department,
            "enr.enrollment_is_active" => 1,
            "cou.course_department" => $info["user"]->fic_department,
            "cou.course_id" => (int) $segment
        );
        $join = array(
            array("course as cou", "enr.enrollment_id = cou.enrollment_id"),
            array("offering as off", "cou.course_id = off.course_id")
        );
        $sections = $this->Crud_model->fetch_join2("enrollment as enr", $col, $join, NULL, $where, TRUE);
        /* END - GETTING ALL OFFERINGS */
        return $sections;
    }

}
