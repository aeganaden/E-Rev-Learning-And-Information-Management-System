<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importdata extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->load->library('Excelfile');
    }

    public function index() {
        $data = array(
            'title' => "Import Excel"
        );
//        $sample = array(
//            array(
//                'admin_id' => 3,
//                'username' => 'test',
//                'password' => '12345678901234567890123456789012345678abc'
//            ),
//            array(
//                'admin_id' => 4,
//                'username' => 'test',
//                'password' => '12345678901234567890123456789012345678abc'
//            )
//        );
//        if (!empty($this->Crud_model->insert_batch('admin', $sample)['message'])) {
//            echo $this->Crud_model->insert_batch('admin', $sample)['message'];
//        } else {
//            echo "succes";
//        }
        //$this->db->_error_message();
//        echo "<pre>";
//        print_r($this->Crud_model->table_names());
//        echo "</pre>";
//        $this->session->set_flashdata('file_path', 'test');
//        echo $this->session->flashdata('file_path');
        $this->load->view('includes/header', $data);
        $this->load->view('excel_reader/index');
        $this->load->view('includes/footer');
    }

    public function credentialcheck() {
        $data = array(
            'username' => $this->input->post('username'),
        );
        $userInfo = $this->Crud_model->fetch('admin', $data);
        if (!$userInfo) {
            $data = array(
                'error' => 'Invalid account. Please try again.',
            );

            $this->load->view('includes/header', $data);
            $this->load->view('excel_reader/index');
            $this->load->view('includes/footer');
        } else {
            $userInfo = $userInfo[0];

            if ($userInfo->password == sha1($this->input->post('password'))) {
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
    }

    public function filecheck() {
//$_SERVER['HTTP_REFERER']
        $config['upload_path'] = FCPATH . 'assets\uploads\\';
        $config['allowed_types'] = 'xls|csv|xlsx';
        $config['max_size'] = '10000';

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
                    foreach ($hold[$sheet][0] as $col_hold) {           //check field/column names
                        if (!in_array($col_hold, $col_names)) {
                            echo "There is no \"" . $col_hold . "\" field in the database table \"" . $sheet . "\"<br>";
                            $error_counter++;
                        }
                    }
                    if ($error_counter == 0) {
                        for ($z = 1; $z < count($hold[$sheet]); $z++) {         //loop base on row on excel 2 and beyond
                            $inner_counter = 0;

                            foreach ($hold[$sheet][$z] as $col_hold) {          //getting values
                                $col_data_hold = get_object_vars($this->Crud_model->col_data($sheet)[$inner_counter]);
                                //print_r($col_data_hold['type']);
                                $col_type = $col_data_hold['type'];
                                $col_length = $col_data_hold['max_length'];
                                if ($col_type === "bigint" || $col_type === "tinyint" || $col_type === "int") {    //check data types
                                    if (is_int((int) $col_hold) && $col_length >= strlen($col_hold) && !empty($col_hold)) {
                                        $inner_counter == 0 ? $stack_hold = array($col_data_hold['name'] => $col_hold) : array_push($stack_hold, array($col_data_hold['name'] => $col_hold));
                                        echo "<pre>";
                                        print_r($stack_hold);
                                        echo "</pre>";
                                    } else {
                                        echo "\"" . $col_hold . "\", located at " . ($z + 1) . $alphas[$inner_counter] . ", does not qualify to \"" . $col_type . ".<br>";
                                        $error_counter++;
                                        //break;
                                    }
                                } else if ($col_type === "varchar" || $col_type === "text") { //check data types
                                    if (is_string($col_hold) && $col_length >= strlen($col_hold) && !empty($col_hold)) {

                                    } else {
                                        echo "The value \"" . $col_hold . "\", located at " . ($z + 1) . $alphas[$inner_counter] . ", does not qualify to \"" . $col_type . ".<br>";
                                        $error_counter++;
                                        //break;
                                    }
                                }

                                $inner_counter++;
                            }
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
            if (!empty($error_message_last)) {
                echo $error_message_last;
                $this->load->view('excel_reader/sample', array('error_counter' => "Error(" . $error_counter . ")"));
            } else {
                include(APPPATH . 'views\excel_reader\custom2.php');
            }

            $this->load->view('includes/footer');
        } else {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('includes/header', $data);
            $this->load->view('excel_reader/upload_file', $error);
            $this->load->view('includes/footer');
        }
    }

    public function uploadfile() {
        $data = array(
            'title' => "Import Excel"
        );
        $this->session->set_flashdata('credentialadmin', '1');
        $this->load->view('includes/header', $data);
        $this->load->view('excel_reader/upload_file');
        $this->load->view('includes/footer');
    }

    public function sha1it() {
        echo sha1('testing');
    }

    public function test() {
        for ($x = 0; $x < 6; $x++) {
            $hold = array(
                'test1' => $x,
                'test2' => $x,
                'test3' => $x,
                'test4' => $x,
                'test5' => $x,
                'test6' => $x
            );
            $data[] = $hold;
        }
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

}
