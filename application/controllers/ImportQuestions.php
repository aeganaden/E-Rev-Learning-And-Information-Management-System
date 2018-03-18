<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Manila");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportQuestions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
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

        if ($info['logged_in'] && $info['identifier'] != "administrator") {
            $data = array(
                "title" => "Home - Learning Management System | FEU - Institute of Techonology",
                "info" => $info,
                "program" => $program,
                "s_h" => "",
                "s_a" => "",
                "s_f" => "",
                "s_c" => "selected-nav",
                "s_t" => "",
                "s_s" => "",
                "s_co" => "",
                "s_ss" => "",
                "s_ga" => "",
                "s_rc" => "",
            );
            $this->load->view('includes/header', $data);
            $this->load->view('courseware/initial_import_questions');
            $this->load->view('includes/footer');
        } elseif ($info['identifier'] == "administrator") {
            redirect('Admin');
        } else {
            redirect('Welcome', 'refresh');
        }
    }

    public function viewCoursewares() {
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

        if ($info['logged_in'] && $info['identifier'] != "administrator") {
            $data = array(
                "title" => "Home - Learning Management System | FEU - Institute of Techonology",
                "info" => $info,
                "program" => $program,
                "s_h" => "",
                "s_a" => "",
                "s_f" => "",
                "s_c" => "selected-nav",
                "s_t" => "",
                "s_s" => "",
                "s_co" => "",
                "s_ss" => "",
                "s_ga" => "",
                "s_rc" => "",
            );
            $this->load->view('includes/header', $data);
            $this->load->view('courseware/import_questions');
            $this->load->view('includes/footer');
        } elseif ($info['identifier'] == "administrator") {
            redirect('Admin');
        } else {
            redirect('Welcome', 'refresh');
        }
    }

    public function importQuestions() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
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
            $data = array(
                "title" => "Upload Question",
                "info" => $info,
                "program" => $program,
                "s_h" => "",
                "s_a" => "",
                "s_f" => "",
                "s_c" => "selected-nav",
                "s_t" => "",
                "s_s" => "",
                "s_co" => "",
                "s_ss" => "",
                "s_ga" => "",
                "s_rc" => ""
            );
            $this->load->view('includes/header', $data);
            $this->load->view('courseware/upload_questions', $data);
            $this->load->view('includes/footer');
        } elseif ($info['identifier'] == "administrator") {
            redirect('Admin');
        } else {
            redirect('Welcome', 'refresh');
        }
    }

    public function checkimport() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            if (!empty($segment = $this->uri->segment(3)) && is_numeric($segment)) {
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
                $data = array(
                    "title" => "Upload Question",
                    "info" => $info,
                    "program" => $program,
                    "s_h" => "",
                    "s_a" => "",
                    "s_f" => "",
                    "s_c" => "selected-nav",
                    "s_t" => "",
                    "s_s" => "",
                    "s_co" => "",
                    "s_ss" => "",
                    "s_ga" => "",
                    "s_rc" => ""
                );
                require "./application/vendor/autoload.php";
                $config['upload_path'] = "./assets/uploads/";
                $config['allowed_types'] = 'xls|csv|xlsx';
                $config['max_size'] = '2048000';
                $config["file_name"] = "questions_" . time();
                $this->load->library('upload', $config);
                $this->load->view('includes/header', $data);
                $error_message = null;
                /* INITIALIZE */

                if ($this->upload->do_upload('excel_file')) {//success upload
                    $upload_data = $this->upload->data();
                    $spreadsheet = IOFactory::load($upload_data["full_path"]);
                    $spreadsheet->setActiveSheetIndex(0);
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                    //returns index value (A,B,C,...)
                    if ($sheetData[1]["A"] == "questions" && $sheetData[1]["B"] == "answer" && $index_choices = array_search("choices", $sheetData[1])) {
                        $this->db->trans_begin();
                        //loop for question
                        for ($i = 2; $i <= count($sheetData); $i++) {       //loop for per column
                            if (!empty($sheetData[$i]["A"])) {
                                $hold_questions[] = array(
                                    "courseware_question_question" => $sheetData[$i]["A"],
                                    "courseware_question_status" => 1,
                                    "courseware_id" => $segment
                                );
                            } else {
                                $error_message[] = "Questions cannot be blank. Found error on row " . $i . "A";
                            }
                        }

                        //insert batch here
                        $this->Crud_model->insert_batch("courseware_question", $hold_questions);
                        if ($this->db->error()["code"] != 0) {
                            $error_message[] = $this->db->error()["message"];
                        }
                        $first_id = $this->db->insert_id();

                        //loop for answer
                        for ($i = 2; $i <= count($sheetData); $i++) {       //loop for per row
                            $counter = 0;
                            $go_to_choices = false;
                            $is_there_answer = 0;
                            $is_there_choice = 0;
                            foreach ($sheetData[$i] as $key => $choice) {       //loop for per col
                                if ($key == $index_choices) {               //yung letter nagmatch whereas located yung choice col
                                    $go_to_choices = true;
                                }
                                if (!$go_to_choices && $counter != 0 && !empty($choice)) {  //answer only
                                    $hold_choices[] = array(
                                        "choice_choice" => $choice,
                                        "choice_is_answer" => 1,
                                        "courseware_question_id" => $first_id
                                    );
                                    $is_there_answer++;
                                } else if ($go_to_choices && "" != trim($choice)) {   //other choices
                                    $hold_choices[] = array(
                                        "choice_choice" => $choice,
                                        "choice_is_answer" => 0,
                                        "courseware_question_id" => $first_id
                                    );
                                    $is_there_choice++;
                                }
                                $counter++;
                            }
                            if ($is_there_answer == 0) {
                                $error_message[] = "There should be atleast 1 answer";
                            }
                            if ($is_there_choice == 0) {
                                $error_message[] = "There should be atleast 1 choice";
                            }
                            $first_id++;
                        }

                        $this->Crud_model->insert_batch("choice", $hold_choices);
                        if ($this->db->error()["code"] != 0) {
                            $error_message[] = $this->db->error()["message"];
                        }

                        if ($this->db->trans_status() === FALSE) {          //error dbase
                            $this->db->trans_rollback();
                            $error_message[] = "An error occured while processing the data.";

                            $data = array(
                                "error_message" => $error_message
                            );
                            $this->load->view('courseware/upload_questions', $data);
                        } else {                                            //success dbase
                            if (!empty($error_message)) {
                                $this->db->trans_rollback();
                                $data = array(
                                    "error_message" => $error_message
                                );
                                $this->load->view('courseware/upload_questions', $data);
                            } else {
                                $this->db->trans_commit();
                                $this->load->view('includes/footer');
                                $this->load->view("courseware/alert_success_insert.php");
                            }
                        }
                    } else {
                        $error_message[] = "Row 1 should have the following:";
                        $error_message[] = "&emsp;'questions' located at row 1A";
                        $error_message[] = "&emsp;'answer' located at row 1B";
                        $error_message[] = "&emsp;'choices' anywhere in row 1 beyond 'answer'";
                        $data = array(
                            "error_message" => $error_message
                        );
                        $this->load->view('courseware/upload_questions', $data);
                    }
                } else {                                                                //failed upload
                    $error_message[] = $this->upload->display_errors();
                    $data = array(
                        "error_message" => $error_message
                    );
                    $this->load->view('courseware/upload_questions', $data);
                }
                //erase the file
//                if (file_exists($this->upload->data()["full_path"])) {                  //file is deleted when there's error
//                    unlink($this->upload->data()["full_path"]);
//                }
                $this->load->view('includes/footer');
            } else {                                                            //error sa segment
                redirect("ImportQuestions/");
            }
        } elseif ($info['identifier'] == "administrator") {
            redirect('Admin');
        } else {
            redirect('Welcome', 'refresh');
        }
    }

}

/* End of file ImportQuestions.php */
/* Location: ./application/controllers/ImportQuestions.php */