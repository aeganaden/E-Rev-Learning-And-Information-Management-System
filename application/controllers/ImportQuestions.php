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
            $this->load->view('courseware/dataImportQuestions');
            $this->load->view('includes/footer');
        } elseif ($info['identifier'] == "administrator") {
            redirect('Admin');
        } else {
            redirect('Welcome', 'refresh');
        }
    }

    public function uploadquestions() {
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
                echo"<pre>";
                //returns index value (A,B,C,...)
                if ($sheetData[1]["A"] == "questions" && $sheetData[1]["B"] == "answer" && $index_choices = array_search("choices", $sheetData[1])) {
                    for ($i = 2; $i <= count($sheetData); $i++) {
                        if (!empty($sheetData[$i]["A"])) {
                            $counter = 0;
                            foreach ($sheetData[$i] as $key => $answer) {
                                if ($key == $index_choices) {
                                    break;
                                } else if ($counter != 0 && !empty($answer)) {  //answer only
                                    //collect answers here
                                    echo "answers on question " . $i . " " . $answer . "<br>";
                                }
                                $counter++;
                            }
                        } else {
                            $error_message[] = "Questions cannot be blank. Found error on row " . $i . "A";
                        }
                        print_r($sheetData[$i]);
                    }
                } else {
                    $error_message[] = "Row 1 should have the following:";
                    $error_message[] = "&emsp;'questions' located at row 1A";
                    $error_message[] = "&emsp;'answer' located at row 1B";
                    $error_message[] = "&emsp;'choices' anywhere in row 1 beyond 'answer'";
                }

//                print_r($sheetData);
                echo"</pre>";

                $data = array(
                    "error_message" => $error_message
                );
                $this->load->view('courseware/upload_questions', $data);
            } else {//failed upload
                $error_message[] = $this->upload->display_errors();
                $data = array(
                    "error_message" => $error_message
                );
                $this->load->view('courseware/upload_questions', $data);
            }

            //erase the file
            if (file_exists($this->upload->data()["full_path"])) {      //file is deleted when there's error
                unlink($this->upload->data()["full_path"]);
            }
            $this->load->view('includes/footer');
        } else {
            redirect();
        }
    }

}

/* End of file ImportQuestions.php */
/* Location: ./application/controllers/ImportQuestions.php */