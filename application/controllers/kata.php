<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kata
 *
 * @author PT.SYDECO
 */
class kata extends CI_Controller {

    //put your code here
    public function index($xstart = 0, $xSearch = '') {
        $idpegawai = $this->session->userdata('idx');

        if (!empty($idpegawai)) {
            if ($xstart <= -1) {
                $xstart = 0;
            } $this->session->set_userdata('awal', $xstart);
            $head['ajax'] = '<script language="javascript" type="text/javascript" src="' . base_url() . 'ajax/ajaxkata.js"></script>' . "\n" .
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
        $this->load->model('modelaboutus');

        $this->load->helper('form');
//        $idx = $_POST['idx'];
        $row = $this->modelaboutus->getorderdetailaboutus(0, 1, 'DESC', 2);

        $xcontent = '';
        $xcontent.='<div class="btn-group-table btn-group">';
        $xcontent.='<a onclick = "save();" class="btn btn-success" type="button"><i class="icon-plus-sign icon-white"></i> Simpan</a>';
        $xcontent.='<a onclick="cancel();" class="btn btn-danger" type="button"><i class="icon-trash icon-white"></i> Batal</a>';
        $xcontent.=' </div>';
        $xcontent.=' <div class="content-cage">';
        $xcontent.='<div class="header"><i class="trt_keyboard"></i><span class="devider"></span> Input Slider</div>';
        $xcontent.='<div id="form">';
        $xcontent.='<input type="hidden" id="idx" value="' . @$row->idx . '"/>';
        $xcontent.='<label style="float: left; width: 100px;">Title :</label>' . form_input('about', @$row->title, 'id="about"') . '<div id="clears"></div>';


        $xcontent.='<label style="float: left; width: 100px;">Search Image File 1</label>' . form_input('images_slider', urldecode(@$row->img), 'id="images_slider" style="float: left; "');
        $xcontent.=form_button('Browse', 'Browse', 'onclick="BrowseServer()" style="margin-left: 15px;float:left;"') . '<div id="clears"></div>';


        $xcontent.='<label style="float: left; width: 100px;">Description </label><div style="clear:both; height:15px;"></div>' . form_textarea('description', urldecode(@$row->description), 'class="ckeditor" id="description"');

        $xcontent.='</div>';
        $xcontent.=' </div>';
        return $xcontent;
    }

    function save() {
        $this->load->model("modelaboutus");
        $idx = $_POST['idx'];
        $title = $_POST['title'];
        $img = $_POST['img'];
        $description = $_POST['description'];
        if ($idx == 0) {
            $this->modelaboutus->insertaboutus($idx, $title, $img, $description);
        } else {
            $this->modelaboutus->updateaboutus($idx, $title, $img, $description);
        }
    }

    function detele($idx) {
        $this->load->model("modelaboutus");
        $idx = $_POST['idx'];

        $this->modelaboutus->deleteaboutus($idx);
    }

}

?>
