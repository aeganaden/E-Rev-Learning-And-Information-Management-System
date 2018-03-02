<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class testing extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->load->library('Excelfile');
    }

    public function index() {
        $data = array("title" => "testing");
        $this->load->view('includes/header', $data);
        $this->load->view('test/main');
        $this->load->view('includes/footer');
    }

    public function testing_upload() {
//        excel_file
        $config['upload_path'] = FCPATH . 'assets\uploads\\';
        $config['allowed_types'] = 'xls|csv|xlsx';
        $config['max_size'] = '10000';
        $stack_hold = array();

        $this->load->library('upload', $config);
        $data = array(
            'title' => "Imported"
        );
        $this->load->view('includes/header', $data);
        if ($this->upload->do_upload('userfile')) {
            
        }

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load("test.xlsx");

        $worksheet = $spreadsheet->getActiveSheet();

        echo '<table>' . PHP_EOL;
        foreach ($worksheet->getRowIterator() as $row) {
            echo '<tr>' . PHP_EOL;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            //    even if a cell value is not set.
            // By default, only cells that have a value
            //    set will be iterated.
            foreach ($cellIterator as $cell) {
                echo '<td>' .
                $cell->getValue() .
                '</td>' . PHP_EOL;
            }
            echo '</tr>' . PHP_EOL;
        }
        echo '</table>' . PHP_EOL;
    }

}
