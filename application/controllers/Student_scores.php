
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

    public function checkCourse($id) {
        $info = $this->session->userdata('userInfo');
        $course = $this->Crud_model->fetch("course", array("course_department" => $info['user']->fic_department));
        $arrayCourseId = array();
        $checker = 0;
        foreach ($course as $key => $value) {
            $arrayCourseId[] = $value->course_id; 
        }

        foreach ($arrayCourseId as $key => $arrVal) {
            if ($id == $arrVal) { 
                $checker = 1;
            }
        } 
        return $checker; 
    }

    public function importData() {


        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            if (!empty($course_id = $this->uri->segment(3)) && is_numeric($course_id)) {
                // echo $this->checkCourse($course_id);
             if ($this->checkCourse($this->uri->segment(3)) == 0) { 
                echo '<script type="text/javascript">'; 
                echo "alert('You don\'t have access with this module');"; 
                echo 'window.history.back();';
                echo '</script>';
            } 
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

    public function importDataSpecific() {
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
                    $this->load->view('student_scores_import_specific');
                    $this->load->view('includes/footer');
                } elseif ($info['identifier'] == "administrator") {
                    redirect('Admin');
                } else {
                    redirect('Welcome', 'refresh');
                }
            } else { 
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

    public function specific_read_excel() { //made by mark
        if ($this->session->userdata('userInfo')['logged_in'] == 1 && $this->session->userdata('userInfo')['identifier'] == "fic") {
            if (!empty($segment = $this->uri->segment(3)) && is_numeric($segment)) {
                $info = $this->session->userdata('userInfo');

                require "./application/vendor/autoload.php";

                $config['upload_path'] = "./assets/uploads/";
                $config['allowed_types'] = 'xls|csv|xlsx';
                $config['max_size'] = '10000';
                $config["file_name"] = "student_scores_specific" . time();

                $this->load->library('upload', $config);

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
                    "title" => "Home - Learning Management System | FEU - Institute of Techonology",
                    "info" => $info,
                    "program" => $program,
                    "course_id" => $segment,
                    "s_h" => "",
                    "s_a" => "",
                    "s_f" => "",
                    "s_c" => "",
                    "s_t" => "",
                    "s_s" => "",
                    "s_co" => "",
                    "s_ss" => "selected-nav"
                );
                $this->load->view('includes/header', $data);

                if ($this->upload->do_upload('excel_file')) {       //success upload
                    $upload_data = $this->upload->data();

                    /** Load $inputFileName to a Spreadsheet Object  * */
                    $spreadsheet = IOFactory::load($upload_data["full_path"]);
                    //reference: https://phpspreadsheet.readthedocs.io/en/develop/topics/accessing-cells/#accessing-cells

                    $sheetnames = $spreadsheet->getSheetNames();

                    //CHECKING - SPREADSHEET 1
                    $spreadsheet->setActiveSheetIndex(1);
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                    $type_of_score = $this->input->post('type_of_score');
                    $counter = 0;
                    foreach ($sheetData as $key => $subsheetData) {
                        if ($key != 1) {
                            if (is_numeric($subsheetData["B"]) && (fmod($subsheetData["B"], 1) == 0) &&
                                is_numeric($subsheetData["C"]) && (fmod($subsheetData["C"], 1) == 0)) {
                                if ($subsheetData["B"] >= 0 && $subsheetData["C"] >= 0) {
                                    if ($subsheetData["B"] >= $subsheetData["C"]) {
                                        $temp = array(
                                            "data_scores_type" => $type_of_score,
                                            "data_scores_score" => $subsheetData["B"],
                                            "data_scores_passing" => $subsheetData["C"]
                                        );
                                        $data_scores[] = $temp;
                                        unset($temp);

                                        $sheet2_list_of_topics[$counter]["topics"] = $subsheetData["A"];
                                        $counter++;
                                    } else {
                                        $error_message[] = "Row " . $key . ": PASSING SCORE must be greater than or equal to TOTAL SCORE";
                                    }
                                } else {
                                    $error_message[] = "Row " . $key . ": TOTAL SCORE and PASSING SCORE cannot be zero";
                                }
                            } else {
                                $error_message[] = "Row " . $key . ": TOTAL SCORE and PASSING SCORE should be whole numbers";
                                break;
                            }
                        } else {                //checks row 1
                            if (strcmp($subsheetData["A"], "topics") != 0) {
                                $error_message[] = "Row " . $key . "A: Should be labeled as 'topics'";
                            }
                            if (strcmp($subsheetData["B"], "total score") != 0) {
                                $error_message[] = "Row " . $key . "A: Should be labeled as 'total score'";
                            }
                            if (strcmp($subsheetData["C"], "passing score") != 0) {
                                $error_message[] = "Row " . $key . "A: Should be labeled as 'passing score'";
                            }
                        }
                    }
                    $this->db->trans_begin();
                    //compute the ids
                    $last_id = $this->Crud_model->fetch_last("data_scores", "data_scores_id");
                    $fetch_last_id = $last_id->data_scores_id;
                    $this->Crud_model->insert_batch("data_scores", $data_scores);
                    $last_id = $fetch_last_id + count($data_scores);
                    for ($fetch_last_id; $fetch_last_id < $last_id; $fetch_last_id++) {
                        $data_scores_id[] = $fetch_last_id + 1;
                    }
                    $insert_student_scores;
                    //CHECKING - SPREADSHEET 0
                    $spreadsheet->setActiveSheetIndex(0);
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                    $array_size = count($sheetData);

                    for ($i = 1; $i <= $array_size; $i++) {
                        //RECOMMENDATION: get all column or row values then check if all is empty, if so, then declared as empty row or column [BUG].
                        if ($i != 1) {
                            //LAST - check the stud numbers on section, and other validations
                            $counter = 0;

                            foreach ($sheetData[$i] as $key => $subsheetData) {
                                if ($key != "A") {          //get only scores
//                                    print_r("key: " . $key . " val: " . $subsheetData . "<br>");
                                    if (!empty($subsheetData) && "" != trim($subsheetData)) {
                                        if ($subsheetData >= $data_scores[$counter]["data_scores_passing"]) {           //pass
                                            $is_failed = 0;
                                        } else {
                                            $is_failed = 1;
                                        }
                                        if ($data_scores[$counter]["data_scores_score"] < $subsheetData) {
                                            $error_message[] = "Error on $i$key: Student's score($subsheetData) cannot be greater than the total score(" . $data_scores[$counter]["data_scores_score"] . ")";
                                        }
                                        if (0 > $subsheetData) {
                                            $error_message[] = "Error on $i$key: Student's score($subsheetData) cannot be a negative number";
                                        }
                                        $temp[] = array(
                                            "student_scores_is_failed" => $is_failed,
                                            "student_scores_score" => $subsheetData,
                                            "student_scores_stud_num" => $sheetData[$i]["A"],
                                            "student_scores_topic_id" => $result[$counter]->topic_id,
                                            "course_id" => $segment,
                                            "data_scores_id" => $data_scores_id[$counter]
                                        );
                                        $counter++;
                                        $insert_student_scores[] = $temp[0];
                                        unset($temp);
                                    } else {
                                        $error_message[] = "Error on $i$key: Cells cannot be empty";
                                        $counter++;
                                    }
                                } else {
                                    //collect student numbers
                                    if (is_numeric($subsheetData) && fmod($subsheetData, 1) == 0) {
                                        if (strlen($subsheetData) == 9) {
                                            $stud_ids[] = $subsheetData;
                                        } else {
                                            $error_message[] = "Invalid student number on <b>$i$key</b>: $subsheetData. Should be 9-digit number";
                                        }
                                    } else {
                                        $error_message[] = "Invalid student number on $i$key: $subsheetData";
                                    }
                                }
                            }
                        } else {                            //1st row - checking of the word student number and the topics indicated
                            foreach ($sheetData[$i] as $key => $subsheet) {
//                                echo strlen($subsheet) . " " . $key . "(result here) <br>";
                                if ("" == trim($subsheet) && strlen($subsheet) == 0 && empty($subsheet)) {
                                    $error_message[] = "Empty cell on 1" . $key;
                                    break;
                                } else {
                                    if ($key == "A") {               //correct
                                        if (strtolower($subsheet) != "student number") {
                                            $error_message[] = "Cell 1A should be 'student number'";
                                        }
                                    } else {                    //get all topic names
                                        $topic_names[] = $subsheet;
                                    }
                                }
                            }

                            if (!isset($error_message)) {
                                $wherein = array(
                                    0 => "topic_name",
                                    1 => $topic_names
                                );
                                $join = array(
                                    array("subject as sub", "cou.course_id = sub.course_id"),
                                    array("topic as top", "top.subject_id = sub.subject_id")
                                );
                                $where = array(
                                    "cou.course_id" => $segment,
                                    "cou.course_department" => $info['user']->fic_department
                                );
                                $col = "top.topic_name, top.topic_id";
                                $result = $this->Crud_model->fetch_join2("course as cou", $col, $join, NULL, $where, NULL, NULL, $wherein);
                                if (count($result) != count($topic_names)) {
                                    $error_message[] = "Check if the topics covered is valid, also check the spelling";
                                    $message = "&emsp;&emsp;- Topic results: ";
                                    foreach ($result as $subresult) {
                                        $message = $message . "'" . $subresult->topic_name . "' ";
                                    }
                                    $error_message[] = $message;
                                } else {
                                    for ($x = 0; $x < count($result); $x++) {
                                        if (strcasecmp($sheet2_list_of_topics[$x]["topics"], $topic_names[$x]) != 0) {
                                            $error_message[] = "Topics in sheet 1 and 2, and the arrangement of topics should match";
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //check the students in section
                    $wherein = array(
                        0 => "student_num",
                        1 => $stud_ids
                    );
                    $join = array(
                        array("offering as off", "off.offering_id = stud.offering_id"),
                        array("course as cou", "cou.course_id = off.course_id"),
                        array("enrollment as enr", "enr.enrollment_id = cou.enrollment_id")
                    );
                    $where = array(
                        "cou.course_id" => $segment,
                        "cou.course_department" => $info['user']->fic_department,
                        "stud.student_department" => $info['user']->fic_department,
                        "off.offering_department" => $info['user']->fic_department,
                        "off.offering_name" => strtoupper($sheetnames[0]),
                        "enr.enrollment_id" => $info["active_enrollment"]
                    );
                    $col = "stud.student_num";
                    $stud_section = $this->Crud_model->fetch_join2("student as stud", $col, $join, NULL, $where, NULL, NULL, $wherein);
                    if (count($stud_section) != count($stud_ids)) {
                        $error_message[] = "Student number/s not included to the indicated section";
                    }
                    //insert
                    if (empty($error_message)) {
                        $this->Crud_model->insert_batch("student_scores", $insert_student_scores);
                    } else {
                        $error_message[] = "Please edit the file and upload it again";
                    }

                    if (isset($error_message) && !empty($error_message)) {
                        $data = array("error_message" => $error_message);
                        $this->load->view('student_scores_import_specific', $data);
                    } else {
                        if ($this->db->trans_status() === FALSE) {
                            $error_message[] = "There is an error inserting data to database";
                            $data = array("error_message" => $error_message);
                            $this->load->view('student_scores_import_specific', $data);
                            $this->db->trans_rollback();
                            if (file_exists($upload_data["full_path"])) {      //file is deleted when there's error
                            unlink($upload_data["full_path"]);
                        }
                        } else {                                //success
                            $this->db->trans_commit();
                            redirect("Student_scores/view_scores");
                        }
                    }
                } else {            //upload failed
                    $error_message[] = $this->upload->display_errors();
                    $data = array("error_message" => $error_message);
                    $this->load->view('student_scores_import_specific', $data);
                }
                $this->load->view('includes/footer');
            } else {
                redirect("Student_scores");
            }
        } else {
            redirect();
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
                        window.location.href='" . base_url() . "Student_scores';
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
            redirect("Home");
        }
    }

    public function view_dataScores() {
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
                $this->load->view('student_scores_data');
                $this->load->view('includes/footer');
            } elseif ($info['identifier'] == "administrator") {
                redirect('Admin');
            } else {
                redirect('Welcome', 'refresh');
            }
        } else {
            redirect("Home");
        }
    }

    public function view_allScores() {
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
                $this->load->view('student_scores_all');
                $this->load->view('includes/footer');
            } elseif ($info['identifier'] == "administrator") {
                redirect('Admin');
            } else {
                redirect('Welcome', 'refresh');
            }
        } else {
            redirect("Home");
        }
    }

}

/* End of file Student_scores.php */
/* Location: ./application/controllers/Student_scores.php */
