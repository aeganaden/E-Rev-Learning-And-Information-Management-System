<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_import extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->load->library('Excelfile');
    }

    public function index() {
        $data = array(
            'title' => "Import Excel",
        );
        $this->load->view('includes/header', $data);
        $this->load->view('excel_reader/excel_main');
        $this->load->view('includes/footer');
    }

    public function import_data() {

        $config['upload_path'] = FCPATH . 'assets\uploads\\';
        $config['allowed_types'] = 'xls|csv|xlsx';

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('userfile')) {
            $data = array(
                'upload_data' => $this->upload->data(),
                'title' => "Import Excel"
            );
            //echo ($this->upload->data()["full_path"]);
            $obj = PHPExcel_IOFactory::load($this->upload->data()["full_path"]);
            $cell = $obj->getActiveSheet()->getCellCollection();
            foreach ($cell as $cl) {
                $column = $obj->getActiveSheet()->getCell($cl)->getColumn();
                $row = $obj->getActiveSheet()->getCell($cl)->getRow();
                $data_value = $obj->getActiveSheet()->getCell($cl)->getValue();

                if ($row == 1) {
                    $header[$row][$column] = $data_value;
                } else {
                    $arr_data[$row][$column] = $data_value;
                }
            }
            $data['header'] = $header;
            $data['values'] = $arr_data;
            $this->load->view('includes/header', $data);
            $this->load->view('excel_reader/upload_success');
            $this->load->view('includes/footer');
        } else {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('excel_reader/excel_main', $error);
        }
    }

}
