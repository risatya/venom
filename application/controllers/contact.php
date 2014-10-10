<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contact
 *
 * @author PT.SYDECO
 */
class contact extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $ses = $this->session->userdata('ip');
        if (!empty($ses)) {
            $this->session->userdata('ip');
        } else {
            $ip = $this->input->ip_address();
            $this->session->set_userdata('ip', $ip);
            date_default_timezone_set('Asia/Jakarta');
            $timenow = date('r');
            $date_added = date('Y-m-d', strtotime($timenow));
            $this->load->model('modelvisited');
            $this->modelvisited->insertvisited('', $ip, $date_added);
        }
    }

    public function index() {

        $this->load->model('modelmenu');
        $this->load->model('modelcontact');

        $content['menu'] = $this->modelmenu->menuhome(2);




        $this->load->view('head', $content);
        $this->load->view('contentcontact');
        $this->load->view('footer');
    }

    function sendTomail() {
        $this->load->model('modelcontact');
        $ednama = $_POST['name'];
        $edmais = $_POST['email2'];
        $row = $this->modelcontact->getlastcontact(0, 1, 'DESC');
        $edmessage = $_POST['message'];
        $this->load->library('email');
        $this->email->from($edmais, $ednama);
        $this->email->to(@$row->email);
        $this->email->subject('Pertanyaan Customer');
        $this->email->message($edmessage);
        $this->email->send();
    }

}

?>
