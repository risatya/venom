<?php

class inputcontact extends CI_Controller {

    public function index($xstart = 0, $xSearch = '') {
        $idpegawai = $this->session->userdata('idx');

        if (!empty($idpegawai)) {
            if ($xstart <= -1) {
                $xstart = 0;
            } $this->session->set_userdata('awal', $xstart);
            $head['ajax'] = '<script language="javascript" type="text/javascript" src="' . base_url() . 'ajax/ajaxinputcontact.js"></script>' . "\n" .
                    '<script language="javascript" type="text/javascript" src="' . base_url() . 'js/ckeditor/ckeditor.js"></script>' . "\n" .
                    '<script language="javascript" type="text/javascript" src="' . base_url() . 'js/ckfinder/ckfinder.js"></script>';
            $head['content'] = $this->getcontent($xstart, $xSearch);
            $this->load->view('admin', $head);
        } else {
            redirect(site_url() . "admin", '');
        }
    }

    function getcontent($xstart, $xSearch) {
        $this->load->model('modelmenu');
        $xcontent = '';
        $xcontent.=$this->modelmenu->menuadmin();
        $xcontent.='<div class="container-fluid inner-content" >';
        $xcontent.=$this->modelmenu->leftmenuadmin();
        $xcontent.='<div class="span10">' . $this->getdatacontent($xstart, $xSearch);
        $xcontent.=' </div>';
        return $xcontent;
    }

    function getdatacontent() {
//        $this->load->model('modelproduct');
        $this->load->model('modelcontact');

        $this->load->helper('form');
//        $idx = $_POST['idx'];
        $row = $this->modelcontact->getlastcontact(0, 1, 'DESC');

        $xcontent = '';
        $xcontent.='<div class="btn-group-table btn-group">';
        $xcontent.='<a onclick = "save();" class="btn btn-success" type="button"><i class="icon-plus-sign icon-white"></i> Simpan</a>';
        $xcontent.='<a onclick="cancel();" class="btn btn-danger" type="button"><i class="icon-trash icon-white"></i> Batal</a>';
        $xcontent.=' </div>';
        $xcontent.=' <div class="content-cage">';
        $xcontent.='<div class="header"><i class="trt_keyboard"></i><span class="devider"></span> Input Contact</div>';
        $xcontent.='<div id="form">';
        $xcontent.='<input type="hidden" id="idx" value="' . @$row->idx . '"/>';
        $xcontent.='<label style="float: left; width: 100px;">Title :</label>' . form_input('name_company', @$row->name_company, 'id="name_company"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Telphone :</label>' . form_input('no_tlp1', @$row->no_tlp1, 'id="no_tlp1"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Telphone 2 :</label>' . form_input('no_tlp2', @$row->no_tlp2, 'id="no_tlp2"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">HP 1:</label>' . form_input('hp1', @$row->hp1, 'id="hp1"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">HP 2:</label>' . form_input('hp2', @$row->hp2, 'id="hp2"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">HP 3:</label>' . form_input('hp3', @$row->hp3, 'id="hp3"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Pin BB:</label>' . form_input('pin', @$row->pin, 'id="pin"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Email :</label>' . form_input('email', @$row->email, 'id="email"') . '<div id="clears"></div>';


        $xcontent.='<label style="float: left; width: 100px;">Facebook :</label>' . form_input('fb', @$row->fb, 'id="fb"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Twitter :</label>' . form_input('twitter', @$row->twitter, 'id="twitter"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">G + :</label>' . form_input('gplus', @$row->gplus, 'id="gplus"') . '<div id="clears"></div>';

        $xcontent.='<label style="float: left; width: 100px;">Alamat :</label>' . form_textarea('alamat', @$row->alamat, 'id="alamat" style="width:350px;"') . '<div id="clears"></div>';

        $xcontent.='<p>Login Information</p><div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">User Name :</label>' . form_input('username', @$row->username, 'id="username"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Password :</label>' . form_input('passwd', @$row->passwd, 'id="passwd"') . '<div id="clears"></div>';


        $xcontent.='</div>';
        $xcontent.=' </div>';
        return $xcontent;
    }

    function save() {
        $this->load->model("modelcontact");
        $idx = $_POST['idx'];
        $alamat = $_POST['alamat'];
        $no_tlp1 = $_POST['no_tlp1'];
        $name_company = $_POST['name_company'];
        $email = $_POST['email'];
        $pin = $_POST['pin'];
        $no_tlp2 = $_POST['no_tlp2'];
        $hp1 = $_POST['hp1'];
        $hp2 = $_POST['hp2'];
        $hp3 = $_POST['hp3'];
        $fb = $_POST['fb'];
        $twitter = $_POST['twitter'];
        $gplus = $_POST['gplus'];
        $username = $_POST['username'];
        $passwd = $_POST['passwd'];
        if ($idx == 0) {
            $this->modelcontact->insertcontact($idx, $alamat, $no_tlp1, $name_company, $email, $pin, $no_tlp2, $hp1, $hp2, $hp3, $fb, $twitter, $gplus, $username, $passwd);
        } else {
            $this->modelcontact->updatecontact($idx, $alamat, $no_tlp1, $name_company, $email, $pin, $no_tlp2, $hp1, $hp2, $hp3, $fb, $twitter, $gplus, $username, $passwd);
        }
    }

    function detele($idx) {
        $this->load->model("modelcontact");
        $idx = $_POST['idx'];

        $this->modelcontact->deletecontact($idx);
    }

}

?>