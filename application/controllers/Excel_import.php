<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_import extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
    }

    public function index() {
        echo APPPATH;
        $data = array(
            'title' => "Upload Excel",
        );
        $this->load->view('includes/header', $data);
        $this->load->view('excel_reader/excel_main');
        $this->load->view('includes/footer');
    }

    public function import_data() {
        require(APPPATH . 'third_party\PhpOffice\PhpSpreadsheet\IOFactory.php');

        $config['upload_path'] = FCPATH . 'assets\uploads\\';
        $config['allowed_types'] = 'xls|csv|xlsx';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('userfile')) {
            //$data = array('upload_data' => $this->upload->data());
            $inputFileName = $this->upload->data();

            $inputFileType = 'Xlsx';

            /**  Create a new Reader of the type defined in $inputFileType  * */
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            /**  Load $inputFileName to a Spreadsheet Object  * */
            $spreadsheet = $reader->load($inputFileName);

            //$this->load->view('excel_reader/upload_success', $data);
        } else {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('excel_reader/excel_main', $error);
        }

        $this->load->library('spreadsheet_excel_reader');



//        $config = array(
//            'upload_path' => './',
//            'allowed_types' => 'xls|csv'
//        );
//        $this->load->library('upload', $config);
//        if ($this->upload->do_upload('file')) {
//            $data = $this->upload->data();
//            @chmod($data['full_path'], 0777);
//        } else {
//            echo 'wtf!';
//        }
    }

}
