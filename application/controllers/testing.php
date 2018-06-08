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

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20); //bigger space horizontally
        $doc = $spreadsheet->getActiveSheet();
        $doc->setCellValue("A1", 'Name:')
        ->setCellValue("B1", 'value');
        

        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save("filename");
        force_download("filename", NULL);

            //closes the tab
        echo "<script>window.close();</script>";
    } else {
        echo "error upload";
        print_r($this->upload->display_errors());
    }
}

}
