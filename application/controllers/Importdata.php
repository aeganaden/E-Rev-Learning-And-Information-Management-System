<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importdata extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->load->library('Excelfile');
        $this->load->library('session');
    }

    public function index() {
        $this->session->unset_userdata('insertion_info');
        $userInfo = $this->session->userdata('userInfo')['user'];
        $temp = array('username' => $userInfo->username, 'password' => $userInfo->password);
        $temp = $this->Crud_model->fetch('admin', $temp);
        if ($temp) {
            $data = array(
                'title' => "Import Excel"
            );
            $this->load->view('includes/header', $data);
            $this->load->view('excel_reader/index');
            $this->load->view('includes/footer');
        } else {                    //kapag di naka login
            redirect("");
        }
    }

    public function credentialcheck() {
        $this->session->unset_userdata('insertion_info');
        $userInfo = $this->session->userdata('userInfo')['user'];
        $temp = array('username' => $userInfo->username, 'password' => $userInfo->password);
        $temp = $this->Crud_model->fetch('admin', $temp);
        if ($temp) {
            $data = array(
                'username' => $this->input->post('username'),
            );
            $userInfo = $this->Crud_model->fetch('admin', $data);
            if (!$userInfo) {
                $data = array(
                    'error' => 'Invalid account. Please try again.',
                    'title' => "Import Excel"
                );
                $this->load->view('includes/header', $data);
                $this->load->view('excel_reader/index');
                $this->load->view('includes/footer');
            } else {
                $userInfo = $userInfo[0];

//            if ($userInfo->password == sha1($this->input->post('password'))) {
                if ($userInfo->password == $this->input->post('password')) {
                    $insertion_info = array('logged_in' => true);
                    $this->session->set_userdata('insertion_info', $insertion_info);
                    redirect('importdata/uploadfile');
                } else {
                    $data = array(
                        'error' => 'Invalid account. Please try again.',
                    );

                    $this->load->view('includes/header', $data);
                    $this->load->view('excel_reader/index');
                    $this->load->view('includes/footer');
                }
            }
            $this->load->view('includes/footer');
        } else {                    //kapag di naka login
            redirect("");
        }
    }

    public function filecheck() {
        if (!empty($this->session->userdata('insertion_info')['logged_in']) && $this->session->userdata('insertion_info')['logged_in'] == 1) {
            $config['upload_path'] = FCPATH . 'assets\uploads\\';
            $config['allowed_types'] = 'xls|csv|xlsx';
            $config['max_size'] = '10000';
            $stack_hold = array();

            $this->load->library('upload', $config);
            $data = array(
                'title' => "Import Excel"
            );
            $this->load->view('includes/header', $data);
            if ($this->upload->do_upload('userfile')) {
                $data[] = array('upload_data' => $this->upload->data());
                $obj = PHPExcel_IOFactory::load($this->upload->data()["full_path"]);
                $sheetnames = $obj->getSheetNames();

                $counter = 0;
                include(APPPATH . 'views\excel_reader\custom1.php');

                $tab_names = $this->Crud_model->table_names();
                $error_counter = 0;              //for checking field/column names
                $alphas = range('A', 'Z');       //array for A-Z
                foreach ($sheetnames as $sheet) {
                    if (in_array($sheet, $tab_names)) {                  //found the table names are correct
                        $worksheet = $obj->getSheet($counter);
                        $hold[$sheet] = $worksheet->toArray(null, true, true, false);
                        $col_names = $this->Crud_model->col_names($sheet);
                        $name_counter = 0;
                        foreach ($hold[$sheet][0] as $col_hold) {           //check field/column names
                            if (!in_array($col_hold, $col_names) && empty($col_hold)) {
                                echo "There is no \"" . $col_hold . "\", located at 1" . $alphas[$name_counter] . ", field in the database table \"" . $sheet . "\" (missing column)<br>";
                                $error_counter++;
                            }
                            $name_counter++;
                        }
                        if ($error_counter == 0) {
                            for ($z = 1; $z < count($hold[$sheet]); $z++) {         //loop base on row on excel 2 and beyond
                                $inner_counter = 0;
                                foreach ($hold[$sheet][$z] as $col_hold) {          //getting values
                                    $col_data_hold = get_object_vars($this->Crud_model->col_data($sheet)[$inner_counter]);

                                    $col_type = $col_data_hold['type'];
                                    $col_length = $col_data_hold['max_length'];
                                    if ($col_type === "bigint" || $col_type === "tinyint" || $col_type === "int") {    //check data types
                                        if (($this->is_this_string_an_integer($col_hold) && $col_length >= strlen($col_hold) && !empty($col_hold)) || $col_hold == 0) { //kapag tinanggal rightmost, bawal ang 0
                                            $inner_counter == 0 ? $stack_hold = array($col_data_hold['name'] => $col_hold) : $stack_hold = $stack_hold + array($col_data_hold['name'] => $col_hold);
                                        } else {
                                            echo "The value \"" . $col_hold . "\", located at " . ($z + 1) . $alphas[$inner_counter] . " table '$sheet', does not qualify to \"" . $col_type . "\"<br>";
                                            $error_counter++;
                                            //break;
                                        }
                                    } else if ($col_type == "varchar" || $col_type == "text") { //check data types
                                        if (is_string($col_hold) == 1 && $col_length >= strlen($col_hold) && !empty($col_hold)) {
                                            $inner_counter == 0 ? $stack_hold = array($col_data_hold['name'] => $col_hold) : $stack_hold = $stack_hold + array($col_data_hold['name'] => $col_hold);
                                        } else {
                                            print_r($col_data_hold) . "<br>";
                                            echo "The value \"" . $col_hold . "\", located at " . ($z + 1) . $alphas[$inner_counter] . " table '$sheet', does not qualify to \"" . $col_type . "\"<br>";
                                            $error_counter++;
                                            //break;
                                        }
                                    }
                                    $inner_counter++;
                                }
                                $batch_holder[$sheet][] = $stack_hold;
                            }
                        } else {
                            $error_message_last = "The data from the file was not imported to the database due to the errors.<br>";
                        }
                    } else {                //no found table name like that
                        echo "There is no \"" . $sheet . "\" table in the database.<br>";
                        $error_counter++;
                        break;
                    }
                    $counter++;
                }
                if (!empty($error_message_last)) {          //error
                    echo "----------<br>";
                    echo $error_message_last;
                    $this->load->view('excel_reader/sample');       //changes text to error
                    if (file_exists($this->upload->data()["full_path"])) {
                        unlink($this->upload->data()["full_path"]);
                        echo "<b>The file is deleted.</b>";
                    }
                } else {                                    //success magiinsert na
                    include(APPPATH . 'views\excel_reader\custom2.php');
                    $temp_counter = 0;
                    $this->db->trans_begin();
                    foreach ($sheetnames as $sheet) {
                        $temp = $this->Crud_model->insert_batch($sheet, $batch_holder[$sheet])['message'];
                        if ($this->db->trans_status() === FALSE && !empty($temp)) {
                            echo "<br>***" . $temp . " on '$sheet' table";
                            $temp_counter++;
                            include(APPPATH . 'views\excel_reader\custom4.php');
                        } else {
                            echo "<br>Insertion success on table '$sheet'";
                        }
                    }
                    if ($temp_counter > 0) {
                        $this->db->trans_rollback();
                        echo "<br><b>Insertion fail. Transaction rollback.</b>";
                        if (file_exists($this->upload->data()["full_path"])) {
                            unlink($this->upload->data()["full_path"]) or die('failed deleting: ' . $this->upload->data()["full_path"]);
                        }
                    } else {
                        $this->db->trans_commit();
                    }
                    include(APPPATH . 'views\excel_reader\custom3.php');
                    include(APPPATH . 'views\excel_reader\custom5.php');
                }
                $this->load->view('includes/footer');
            } else {
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('includes/header', $data);
                $this->load->view('excel_reader/upload_file', $error);
                $this->load->view('includes/footer');
            }
        } else {
            redirect("");
        }
    }

    public function uploadfile() {

        if (!empty($this->session->userdata('insertion_info')['logged_in']) && $this->session->userdata('insertion_info')['logged_in'] == 1) {
            $data = array(
                'title' => "Import Excel"
            );
            $this->session->set_flashdata('credentialadmin', '1');
            $this->load->view('includes/header', $data);
            $this->load->view('excel_reader/upload_file');
            $this->load->view('includes/footer');
        } else {
            redirect("");
        }
    }

    public function sha1it() {
        echo sha1('admin');
    }

    function is_this_string_an_integer($string) {

        // Assume from the start that the string IS an integer.
        // If we hit any problems, we'll bail out and say it's NOT an integer.
        $is_integer = true;

        // Convert the string into an array of characters.
        $array_of_chars = str_split($string);

        // If there are no characters, we don't have an integer.
        if (empty($array_of_chars)) {
            $is_integer = false;
        }

        // If the first character is a zero, we don't have an integer.
        // Instead, we have a string with leading zeros.
        if ($is_integer && $array_of_chars[0] == '0') {
            $is_integer = false;
        }
        // If we still think it might be an integer,
        // step through each char and see if it's a legitimate digit.
        if ($is_integer) {
            foreach ($array_of_chars as $i => $char) {

                // Use PHP's ctype_digit() function to see if this
                // character is a digit. If not, we can bail.
                if (!ctype_digit($char)) {
                    $is_integer = false;
                    break;
                }
            }
        }

        // Finally, do we have an integer string or not?
        return $is_integer;
    }

}
