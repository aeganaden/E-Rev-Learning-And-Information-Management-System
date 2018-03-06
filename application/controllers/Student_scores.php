
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

                $this->load->view('includes/header', $data);
                if ($this->upload->do_upload('excel')) {       //success upload
                    $upload_data = $this->upload->data();
                    $input = $this->input->post(array('type_of_score', 'total_score', 'passing_score'));

                    /** Load $inputFileName to a Spreadsheet Object  * */
                    $spreadsheet = IOFactory::load($upload_data["full_path"]);
                    //reference: https://phpspreadsheet.readthedocs.io/en/develop/topics/accessing-cells/#accessing-cells
                    //topic: "Retrieving a range of cell values to an array"
                    $var = $spreadsheet->getSheetNames();

                    /* MATCHING OFFERING NAME ON FETCHED DATA ABOVE */
                    foreach ($sections as $key => $value) {
                        if (strtolower($value->offering_name) == strtolower($var[0])) {
                            $match_offering = $value->offering_id;     //stored offering_id that matched on excel
                            break;
                        }
                    }
                    if (!isset($match_offering)) {
                        $error_message[] = "Wrong section";
                    }
                    /* END - MATCHING OFFERING NAME ON FETCHED DATA ABOVE */

                    $spreadsheet->setActiveSheetIndex(0);
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                    $isit = true;
                    $topic_list = $this->input->post("topic_list");
                    foreach ($topic_list as $temp) {
                        if (!is_numeric($temp)) {
                            $isit = false;
                            break;
                        }
                    }

                    //print_r($sheetData);
                    foreach ($sheetData as $key => $val) {
                        if ($key != 1 && $isit) {        //row 2 and beyond
                            if (!empty($val["A"]) && !empty($val["B"])) {       //checks if empty
                                if (is_int((int) $val["A"]) && is_int((int) $val["B"])) {       //checks if int; store to new variable and do what you want
                                    if (strlen((string) $val["A"]) == 9 && (int) $input["total_score"] >= (int) $val["B"]) {
//                                        echo $input["type_of_score"] . "<br>";      //data_scores_id
//                                        echo $input["total_score"] . "<br>";        //total_Score
//                                        echo $input["passing_score"] . "<br>";      //passing_score
//                                        echo "offering_id: " . $match_offering;     //offering_id
//                                        echo "<br>" . "stud num " . $val["A"];      //stud_id
//                                        echo "<br>" . "stud score " . $val["B"];    //stud_score
                                        $is_pass = $input["passing_score"] > $val["B"] ? 1 : 0;
                                        $student_scores_table[] = array(
                                            "student_scores_is_failed" => $is_pass,
                                            "student_scores_score" => $val["B"],
                                            "student_scores_stud_num" => $val["A"],
                                            "student_scores_topic_id" => implode(",", $topic_list),
                                            "course_id" => $segment
                                        );
                                    } else {
                                        $error_message[] = "Row " . $key . ": Make sure the student number has 9 digits and the score is not greater than the total score";
                                    }
                                } else {
                                    $error_message[] = "Column A and B, row 2 and beyond should be numbers. Row: " . $key;
                                }
                            } else if (empty($val["A"]) && !empty($val["B"])) {     //may laman si A, walang laman si B
                                $error_message[] = "Blank cell on: " . $key . "A";
                            } else if (!empty($val["A"]) && empty($val["B"])) {     //walang laman si A, wmay laman si B
                                $error_message[] = "Blank cell on: " . $key . "B";
                            } else {                        //impossible na mapuntahan to kasi di magfefetch ng empty sa baba kung wala namang mafefetch
                                $error_message[] = "Blank row in " . $key;
                            }
                        } else {
                            //checks if it is correct
                            if (!(strtolower($val["A"]) == "student number" || strtolower($$val["A"]) == "student_number")) {
                                $error_message[] = "1A should be 'student_number' or 'student number'";
                            }
                            if (!(strtolower($val["B"]) == "score" || strtolower($val["B"]) == "scores")) {
                                $error_message[] = "1B should be 'score' or 'scores'";
                            }
                        }
                    }
                    if (isset($error_message)) {
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
                    } else {//insert to dbase
                        //insert data_scores first
                        $this->db->trans_begin();
                        $temp = array(
                            "data_scores_type" => $input["type_of_score"],
                            "data_scores_score" => $input["total_score"],
                            "data_scores_passing" => $input["passing_score"],
                        );
                        $this->Crud_model->insert('data_scores', $temp);
                        $last_id = $this->db->insert_id();
                        foreach ($student_scores_table as $key => $temp) {
                            $student_scores_table[$key]["data_scores_id"] = $last_id;
                        }
//                        echo"<pre>";
//                        print_r($student_scores_table);
                        $this->Crud_model->insert_batch('student_scores', $student_scores_table);
                        if ($this->db->trans_status() === FALSE) {
//                            print_r($this->db->error());
                            $this->db->trans_rollback();
                            $error_message[] = "There is an error uploading data to the database";
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
                    } else {
                        $this->db->trans_commit();
                        echo "<script>
                        alert('Successfully added!');
                        window.location.href='".base_url()."Student_scores';
                        </script>";
                        // echo '<script>alert("Successfully added!")</script>';
                        // redirect("");
                    }
                }
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
                redirect("Student_scores");
            }
            $this->load->view('includes/footer', $data);
        } else {            //not logged in and not fic
            redirect();
        }
    }

    public function view_scores() {
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
                $this->load->view('student_scores_view');
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

    public function view_sections() {
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            $info = $this->session->userdata('userInfo');
            $segment = $this->uri->segment(3);          //LAST
            echo $segment;
        } else {
            redirect("Student_scores");
        }
    }

}

/* End of file Student_scores.php */
/* Location: ./application/controllers/Student_scores.php */
