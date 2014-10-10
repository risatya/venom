<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of about
 *
 * @author PT.SYDECO
 */
class about extends CI_Controller{
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

    
}

?>
