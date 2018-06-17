<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;

class testing extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->load->helper('download');
        $this->load->helper('string');
    }

    public function index() {
        $this->load->view('includes/header', array("title" => "Testing"));
        $this->load->view('test/main');
        $this->load->view('includes/footer');
    }

    public function testing() {
        // $userdata = "";
        // $tokens = array();
        // foreach($userdata as $value) {
        //     array_push($tokens, $value->token);
        // }
        $tokens[] = "f8xgxGA61hE:APA91bEF0cHlHwPIZCV0GWTCRKUUqTpMAeaHomRS_iF3xb0bs_vgOdajvsAer9sVsaFLDauNtWOzfD3Ijn3dgbOuzQA_wEB3AOOxpeGpjXM6iu0s5_rQLbcGzki1yOFoz7l06u0KVNFW";
        $tokens[] = "fVi6djEk3XA:APA91bGdo98MvNguKPWmcpajzXchIm8F08JipP2W6Rl8v0LHw8tu_g5UGRE6wy1qkFGaYSGTGfIy0JYQEjnF7ravATQR_myddQJSPheA2rxiGbDX95xkkTg_aQxrglEQa4o2MuZyWuFF";
        $data = array(
            'operation' => 'create',
            'notification_key_name' => random_string('alnum'),
            'registration_ids'    => $tokens
        );
        $data_string = json_encode($data);
        $curl = curl_init('https://android.googleapis.com/fcm/notification');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Authorization: key=AIzaSyDHyR3pW8tUInWPa-SD1odWq7WRyiI6z5k', // api key ng firebase
                'project_id: 756991022347') // project id di ko sure kung saan nakikita to pero try mo nalang isearch
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result);

        //send notification
        // $data = array(
        //     'notification' => array('body' => 'Check it out', 
        //         'title' => 'New Announcement from Management',
        //         'sound' => 'default',
        //         'color' => 'black',
        //         'priority' => 'max'),
        //     'to'    => $result->notification_key
        // );

        // $data_string = json_encode($data);

        // $curl = curl_init('https://fcm.googleapis.com/fcm/send');

        // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");

        // curl_setopt($curl, CURLOPT_HTTPHEADER,
        //     array(
        //         'Content-Type: application/json',
        //         'Authorization: key=AIz') // api key ng firebase
        // );

        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        // $result = curl_exec($curl);
        // curl_close($curl);
        // echo $result;
    }

    public function testing2(){
        $registrationIds[] = "fqRFW3I6EDc:APA91bF8mDoIhgK0_HaPVSltL4IzEznubgWU988gaXJ6-OzluccnevgkqkN50LwQeCLbY9NmbDymHe2-QGTr2hANbwzZvuXNCykOnjs4UQj7wYmD8yiW0PiQ_t-xJvnY9SP40KdCr8bB";
        $registrationIds[] = "dBRgejJTydw:APA91bEnfrxFh7eUYE3-JGsxNoRhqbyNcZ1QyCwn7hIsWL7GHnTh7lQYR4QPCTMwQmz9cCDM4vL1T9KWB2plA45ne5ix8P0ZINiueas6QjziYEO-gtdzvg3kM7MJnBnH2YAAAs5blK1f";
        // prep the bundle
        $msg = array(
            'body'   => 'While off',
            'title'     => 'Announcement from QA'
        );
        $fields = array(
            'registration_ids' => $registrationIds,
            'notification' => $msg,
            'data' => array('test'=>"this is test")
        );

        $headers = array(
            'Authorization: key=AIzaSyDHyR3pW8tUInWPa-SD1odWq7WRyiI6z5k',
            'Content-Type: application/json',
            'project_id: 756991022347'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        $result = json_decode($result);
        echo "<pre>";
        print_r($result);
    }
}
