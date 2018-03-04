<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class testing extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
    }

    private function index() {
        $data = array("title" => "testing");
        $this->load->view('includes/header', $data);
        $this->load->view('test/main');
        $this->load->view('includes/footer');
    }

    private function testing_upload() {
//        excel_file
        require "./application/vendor/autoload.php";

        $config['upload_path'] = "./assets/uploads/";
        $config['allowed_types'] = 'xls|csv|xlsx';
        $config['max_size'] = '10000';
        $config["file_name"] = "testing_" . time();

        $this->load->library('upload', $config);
        $data = array(
            'title' => "Imported"
        );
        $this->load->view('includes/header', $data);
        if ($this->upload->do_upload('excel_file')) {
            $upload_data = $this->upload->data();
            echo"<pre>";
            print_r($upload_data);
            echo"<br>";
            $spreadsheet = IOFactory::load($upload_data["full_path"]);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            print_r($sheetData);
        }
    }

}
