<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class testing extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->load->helper('download');
    }

    public function index() {
        $data = array("title" => "testing");
        $this->load->view('includes/header', $data);

        require "./application/vendor/autoload.php";

        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Hello')
                ->setCellValue('B2', 'world!')
                ->setCellValue('C1', 'Hello')
                ->setCellValue('D2', 'world!');

        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save("05featuredemo.xlsx");
        force_download('./05featuredemo.xlsx', NULL);
    }

    private function testing_upload() {

    }

}
