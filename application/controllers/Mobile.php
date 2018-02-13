<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
    }

    public function login() {
//        $_POST['username'] = "mgbabaran";
//        $_POST['password'] = "mark";
        $where = array(
            "username" => $_POST['username'],
            "password" => $_POST['password']
        );

        if ($result['result'] = $this->Crud_model->fetch_array("student", NULL, $where)) {
            $result['result'][0]['full_name'] = ucwords($result['result'][0]['firstname'] . " " . $result['result'][0]['midname'] . " " . $result['result'][0]['lastname']);
            $result['result'][0]['identifier'] = "student";
            print_r(json_encode($result));
        } else if ($result['result'] = $this->Crud_model->fetch_array("fic", NULL, $where)) {
            $result['result'][0]['full_name'] = ucwords($result['result'][0]['firstname'] . " " . $result['result'][0]['midname'] . " " . $result['result'][0]['lastname']);
            $result['result'][0]['identifier'] = "fic";
            print_r(json_encode($result));
        } else if ($result['result'] = $this->Crud_model->fetch_array("prof", NULL, $where)) {
            $result['result'][0]['full_name'] = ucwords($result['result'][0]['firstname'] . " " . $result['result'][0]['midname'] . " " . $result['result'][0]['lastname']);
            $result['result'][0]['identifier'] = "prof";
            print_r(json_encode($result));
        } else {
            print_r("");
        }
    }

    public function announcement() {
        $_POST['department'] = "CE";
        /*
         * 1 = CE
         * 2 = ECE
         * 3 = EE
         * 4 = ME
         */
        $temp = 0;
        switch ($_POST['department']) {
            case "CE":
                $temp = 1;
                break;
            case "ECE":
                $temp = 2;
                break;
            case "EE":
                $temp = 3;
                break;
            case "ME":
                $temp = 4;
                break;
        }

        $where = array(
            "announcement_end_datetime >" => strtotime("now"),
            "announcement_is_active" => 1
        );
        $col = array(
            "announcement_title", "announcement_content", "announcement_created_at", "announcement_end_datetime", "announcement_start_datetime", "announcement_announcer"
        );

        $like[0] = "announcement_audience";
        $like[1] = "$temp";
        $orderby[0] = "announcement_created_at";
        $orderby[1] = "DESC";
        if ($result['result'] = $this->Crud_model->fetch_select("announcement", $col, $where, NULL, NULL, NULL, $like, true, $orderby)) {
            foreach ($result['result'] as $key => $res) {
                $result['result'][$key]['announcement_created_at'] = date("M d, Y", $res["announcement_created_at"]);
                $result['result'][$key]['announcement_end_datetime'] = date("M d, Y", $res["announcement_end_datetime"]);
                $result['result'][$key]['announcement_start_datetime'] = date("M d, Y", $res["announcement_start_datetime"]);
            }
            print_r(json_encode($result));
        } else {
            print_r("");
        }
    }

}
