<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            $info = $this->session->userdata('userInfo');
            if (!empty($segment = $this->uri->segment(3)) && is_numeric($segment)) {
                $col = "offering_id,offering_name";
                $where = array(
                    "course_id" => $segment,
                    "offering_department" => $info["user"]->fic_department
                );
                $result_offering = $this->Crud_model->fetch_select("offering", $col, $where);
//                print_r($result_offering);

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
                    "offering" => $result_offering
                );
                $this->load->view('includes/header', $data);
                $this->load->view('sections/course_view');
                $this->load->view('includes/footer');
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

                require "./application/vendor/autoload.php";
                $config['upload_path'] = "./assets/uploads/";
                $config['allowed_types'] = 'xls|csv|xlsx';
                $config['max_size'] = '10000';
                $config["file_name"] = "section_" . time();
                $this->load->library('upload', $config);

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

                            echo "<pre>";
//                            print_r($sheetData);
                            $isit = false;
                            //check if correct col name
                            foreach ($sections as $subsec) {
                                if (strtolower((string) $sheetname[0]) == strtolower($subsec->offering_name) && strtolower($sheetname[1]) == "schedule") {
                                    $isit = true;
                                    if (strtolower($sheetData[1]["A"]) == "student number") {         //check first row col
                                        for ($i = 2; $i <= count($sheetData); $i++) {
                                            $stud_ids[] = $sheetData[$i]["A"];
                                        }
                                        $all_studs = $this->Crud_model->fetch_select("student_list", NULL, NULL, NULL, NULL, array("student_id", $stud_ids));
                                        foreach ($all_studs as $suball_studs) {
                                            $temp = array(
                                            );
                                        }
                                        print_r($all_studs);
                                    }

                                    break;
                                }
                            }

                            if (!$isit) {
                                $error_message[] = "This should be the format of your Excel:";
                                $error_message[] = "&nbsp;First sheet's name: <section>";
                                $error_message[] = "&nbsp;Second sheet's name: \'schedule\'";
                                $data = array(
                                    "error_message" => $error_message
                                );
                                $this->load->view('sections/add', $data);
                            } else {                                            //goods
                                if ($this->db->trans_status() === FALSE) {          //error dbase
                                    $this->db->trans_rollback();
                                } else {                                            //success dbase
                                    $this->db->trans_rollback();
                                }
                            }

                            //GET VALUES OF SCHEDULE BELOW
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
            } else {
                redirect("Sections");
            }
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
