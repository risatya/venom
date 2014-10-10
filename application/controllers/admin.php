<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin
 *
 * @author ASUS
 */
class admin extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $idpegawai = $this->session->userdata('idx');
        if (!empty($idpegawai)) {
//            $this->load->model('modelmenu');
            $head['ajax'] = '<script language="javascript" type="text/javascript" src="' . base_url() . 'ajax/ajaxadmin.js"></script>';
            $head['content'] = $this->getcontent();
//            $head['logout'] = $this->modelmenu->getlogout();
//            $head['menu'] = $this->modelmenu->getMenu();
//            $this->modelmenu->menuatas()
            $this->load->view('contentadminhome', $head);
        } else {
            $head['ajax'] = '<script language="javascript" type="text/javascript" src="' . base_url() . 'ajax/ajaxadmin.js"></script>';
            $head['menu'] = '';
            $head['logout'] = '';
            $head['content'] = $this->formlogin();
            $this->load->view('admin', $head);
        }
    }

    function formlogin() {
        $this->load->helper('form');

        $xcontent = '';
//        $xcontent.= '<div id="form_login"><div id="login">';
//        $xcontent.='<img src="' . base_url() . 'css/images/lockscreen.png" >';
//        $xcontent.='<h3>Please enter your login details</h3>';
//        $xcontent.='<img src="' . base_url() . 'css/images/login.png" style="float: right; margin-right: 30px;">';
//        $xcontent.='<label>User Name</label>' . form_input('edUser', '', 'id="edUser" placeholder="User Name"') . '';
//        $xcontent.='<label>Password</label>' . form_password('edPassword', '', 'id="edPassword" placeholder="Password"') . '';
//        $xcontent.=form_button('login', 'Login', 'onclick="login();"');
//
//        $xcontent.='</div></div>';
         $xcontent.='<div class="container">
		<div class="form-signin">
			<a href="#"><img src="' . base_url() . 'img/logo.png" style=""></a>
			<hr>

			<input type="text" name="username" id="username" class="input-block-level  placeholder="Username" autofocus>
			<input type="password" name="password" class="input-block-level" placeholder="Password" id="edpass">

			<button class="btn" onclick="login();"><i class="trt_door_in"></i> Login</button>
			<a href="' . base_url() . '" class="btn" data-toggle="tooltip" title="Kembali ke halaman utama"><i class="trt_house"></i></a>

			

		</div>
	</div>';
        return $xcontent;
    }

    function getcontent() {
        $this->load->model('modelmenu');
        $xcontent = '';
        $xcontent.=$this->modelmenu->menuadmin();
        $xcontent.='<div class="container-fluid inner-content" >';
        $xcontent.=$this->modelmenu->leftmenuadmin();
        $xcontent.=$this->getdatacontent();
        $xcontent.=' </div>';
        return $xcontent;
    }

    function getdatacontent() {
        $this->load->model('modelvisited');
     
        $xcontent = '';
        $xcontent.='<div class="span10">
                  <div class="page-header"><h1>Dashboard</h1></div> ';
        $xcontent.="";
        $xcontent.='<div class="content-cage">
					  <div id="line" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
					</div>';
        $xcontent.=' </div>';
        return $xcontent;
    }

    function login() {
        
       $this->load->helper('json');
        $username = $_POST['edUser'];
        $passwd = $_POST['edPassword'];
        $this->load->model('modeladmin');
        $rowuser = $this->modeladmin->getdataLogin($username, $passwd);
        $this->json_data['data'] = false;
        if (!empty($rowuser->idx)) {
            $this->session->set_userdata('idx', $rowuser->idx);
            $this->json_data['data'] = true;
            $this->json_data['location'] = site_url() . "admin/";
        }
        echo json_encode($this->json_data);
        
    }

    function logout() {
//        $this->session->sess_destroy();
        $this->session->unset_userdata('idx');
        redirect(site_url() . "admin", '');
    }

}

?>
