<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class testing extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->load->helper('download');
    }

    public function index() {
        $this->load->view('includes/header', array("title" => "Testing"));
        $this->load->view('test/main');
        $this->load->view('includes/footer');
    }

    public function testing_upload() {
        require "./application/vendor/autoload.php";

        $config['upload_path'] = "./assets/uploads/";
        $config['allowed_types'] = 'xls|csv|xlsx';
        $config['max_size'] = '10000';
        $config["file_name"] = "student_scores_specific" . time();

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('excel_file')) {       //success upload
            $upload_data = $this->upload->data();

            /** Load $inputFileName to a Spreadsheet Object  * */
            $spreadsheet = IOFactory::load($upload_data["full_path"]);
            //reference: https://phpspreadsheet.readthedocs.io/en/develop/topics/accessing-cells/#accessing-cells

            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            echo "<pre>";
            print_r($sheetData);

            if (file_exists($upload_data["full_path"])) {      //file is deleted when there's error
                unlink($upload_data["full_path"]);
            }
        } else {
            echo "error upload";
            print_r($this->upload->display_errors());
        }
    }

}
