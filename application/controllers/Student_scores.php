
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Student_scores extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
    }

    public function index() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            $info = $this->session->userdata('userInfo');

            $ident = $info['identifier'];
            $ident.="_department";
            $program = 0;

            switch ($info['user']->$ident) {
                case 'CE':

                    $program = 1;
                    break;
                case 'EEE':
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
                    "s_c" => "",
                    "s_t" => "",
                    "s_s" => "",
                    "s_co" => "",
                    "s_ss" => "selected-nav",
                );
                $this->load->view('includes/header', $data);
                $this->load->view('student_scores');
                $this->load->view('includes/footer');
            } elseif ($info['identifier'] == "administrator") {
                redirect('Admin');
            } else {
                redirect('Welcome', 'refresh');
            }
        } else {
            redirect();
        }
    }

    public function importData() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            if (!empty($course_id = $this->uri->segment(3)) && is_numeric($course_id)) {

                $info = $this->session->userdata('userInfo');
                $ident = $info['identifier'];
                $ident.="_department";
                $program = 0;

                switch ($info['user']->$ident) {
                    case 'CE':
                        $program = 1;
                        break;
                    case 'EEE':
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
                        "course_id" => $course_id,
                        "s_h" => "",
                        "s_a" => "",
                        "s_f" => "",
                        "s_c" => "",
                        "s_t" => "",
                        "s_s" => "",
                        "s_co" => "",
                        "s_ss" => "selected-nav",
                    );
                    $this->load->view('includes/header', $data);
                    $this->load->view('student_scores_import');
                    $this->load->view('includes/footer');
                } elseif ($info['identifier'] == "administrator") {
                    redirect('Admin');
                } else {
                    redirect('Welcome', 'refresh');
                }
            } else {                //no segment
                redirect("Student_scores");
            }
        } else {
            redirect();
        }
    }

    public function insertScore() {
        $total_s = $this->input->post("total_s");
        $total_s_alt = str_replace(" ", "", strip_tags($total_s));

        $passing_s = $this->input->post("passing_s");
        $passing_s_alt = str_replace(" ", "", strip_tags($passing_s));

        $select = $this->input->post("select");
        $select_alt = str_replace(" ", "", strip_tags($select));


        if (empty($total_s_alt) || empty($passing_s_alt) || empty($select_alt)) {
            echo json_encode("Values cannot be NULL");
        } elseif ($total_s <= $passing_s) {
            echo json_encode("Total Score must not be greater than passing score");
        } elseif (is_numeric($total_s) == false || is_numeric($passing_s) == false) {
            echo json_encode("Total Score and Passing Score Must be numeric only");
        } elseif ($total_s < 1 || $passing_s < 1) {
            echo json_encode("No negative and 0 value");
        } else {
            if ($this->Crud_model->insert("data_scores", array("data_scores_type" => $select, "data_scores_score" => $total_s, "data_scores_passing" => $select))) {
                echo json_encode(true);
            } else {
                echo json_encode("Problem in inserting Data Scores");
            }
        }
    }

    public function read_excel() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            if (!empty($segment = $this->uri->segment(3)) && is_numeric($segment)) {
                $info = $this->session->userdata('userInfo');
                require "./application/vendor/autoload.php";

                $config['upload_path'] = "./assets/uploads/";
                $config['allowed_types'] = 'xls|csv|xlsx';
                $config['max_size'] = '10000';
                $config["file_name"] = "student_scores_" . time();

                $this->load->library('upload', $config);
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

                /* MATCHING OFFERING NAME ON FETCHED DATA ABOVE */
//                print_r($sections);
                foreach ($sections as $key => $value) {
                    if ($value->offering_name == "V21") {
                        $math_offering = $value->offering_name;     //stored offering_id that matched on excel
                        break;
                    }
                }
                /* END - MATCHING OFFERING NAME ON FETCHED DATA ABOVE */

                $this->load->view('includes/header', $data);
                if ($this->upload->do_upload('excel')) {       //success upload
                    $upload_data = $this->upload->data();

                    $input = $this->input->post(array('type_of_score', 'total_score', 'passing_score'));

                    /** Load $inputFileName to a Spreadsheet Object  * */
                    $spreadsheet = IOFactory::load($upload_data["full_path"]);
                    //reference: https://phpspreadsheet.readthedocs.io/en/develop/topics/accessing-cells/#accessing-cells
                    //topic: "Retrieving a range of cell values to an array"
                    print_r($spreadsheet->getActiveSheet());
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                    //print_r($sheetData);
//                    foreach ($sheetData as $key => $val) {
//                        if ($key != 1) {        //row 2 and beyond
//                            if (!empty($val["A"]) && !empty($val["B"])) {       //checks if empty
//                                if (is_int((int) $val["A"]) && is_int((int) $val["B"])) {       //checks if int; store to new variable and do what you want
//                                    if (strlen((string) $val["A"]) == 9) {    //WARNING!!!!!!!!!!!!!!!!!
//                                        echo $input["type_of_score"] . "<br>";
//                                        echo $input["total_score"] . "<br>";
//                                        echo $input["passing_score"] . "<br>";
//                                        print_r($last_upload);
//                                        echo "<br>" . "stud num " . $val["A"];
//                                        echo "<br>" . "stud score " . $val["B"];
//                                    } else {
//                                        $error_message[] = "Row " . $key . ": Make sure the student number has 9 digits and the score is not greater than the total score";
//                                    }
//                                } else {
//                                    $error_message[] = "Column A and B, row 2 and beyond should be numbers. Row: " . $key;
//                                }
//                            } else if (empty($val["A"]) && !empty($val["B"])) {     //may laman si A, walang laman si B
//                                $error_message[] = "Blank cell on: " . $key . "A";
//                            } else if (!empty($val["A"]) && empty($val["B"])) {     //walang laman si A, wmay laman si B
//                                $error_message[] = "Blank cell on: " . $key . "B";
//                            } else {                        //impossible na mapuntahan to kasi di magfefetch ng empty sa baba kung wala namang mafefetch
//                                $error_message[] = "Blank row in " . $key;
//                            }
//                        } else {
//                            //checks if it is correct
//                            if (!(strtolower($val["A"]) == "student number" || strtolower($$val["A"]) == "student_number")) {
//                                $error_message[] = "1A should be 'student_number' or 'student number'";
//                            }
//                            if (!(strtolower($val["B"]) == "score" || strtolower($val["B"]) == "scores")) {
//                                $error_message[] = "1B should be 'score' or 'scores'";
//                            }
//                        }
//                    }
//                    if (isset($error_message)) {
//                        $data = array(
//                            'title' => "Imported",
//                            "info" => $info,
//                            "s_h" => "",
//                            "s_a" => "",
//                            "s_f" => "",
//                            "s_c" => "",
//                            "s_t" => "",
//                            "s_s" => "",
//                            "s_co" => "",
//                            "s_ss" => "selected-nav",
//                            "error_message" => $error_message
//                        );
//                        $this->load->view('student_scores_import', $data);
//                        if (file_exists($this->upload->data()["full_path"])) {      //file is deleted when there's error
//                            unlink($this->upload->data()["full_path"]);
//                        }
//                    } else {                                        //insert to dbase
//                    }
                } else {            //upload failed
                    $error_message[] = $this->upload->display_errors();
                    $data = array(
                        'title' => "Imported",
                        "info" => $info,
                        "s_h" => "",
                        "s_a" => "",
                        "s_f" => "",
                        "s_c" => "",
                        "s_t" => "",
                        "s_s" => "",
                        "s_co" => "",
                        "s_ss" => "selected-nav",
                        "error_message" => $error_message
                    );
                    $this->load->view('student_scores_import', $data);
                    if (file_exists($this->upload->data()["full_path"])) {      //file is deleted when there's error
                        unlink($this->upload->data()["full_path"]);
                    }
                }
            } else {            //no segment
                //code here
                echo "<br>";
                print_r($this->upload->display_errors());
//                redirect("Student_scores");
            }
            $this->load->view('includes/footer', $data);
        } else {            //not logged in and not fic
            redirect();
        }
    }

}

/* End of file Student_scores.php */
/* Location: ./application/controllers/Student_scores.php */
