<?php

class inputuser extends CI_Controller {

    public function index($xstart = 0, $xSearch = '') {
        $idpegawai = $this->session->userdata('idx');

        if (!empty($idpegawai)) {
            if ($xstart <= -1) {
                $xstart = 0;
            } $this->session->set_userdata('awal', $xstart);
            $head['ajax'] = '<script language="javascript" type="text/javascript" src="' . base_url() . 'ajax/ajaxinputuser.js"></script>';
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

    function getdatacontent($xstart, $xSearch) {
        $this->load->model('modeluser');
        $xcontent = '';
        $xcontent.='
                  <div class="page-header"><h1>User</h1><hr><hr><hr><hr></div> ';
        $xcontent.='<div id="content">';
        $xcontent.='<div class="btn-group-table btn-group">';
        $xcontent.='<a onclick = "add(0);" class="btn btn-success" type="button"><i class="icon-plus-sign icon-white"></i> Tambah</a>';
//        $xcontent.='<a class="btn btn-danger" type="button"><i class="icon-trash icon-white"></i> Hapus</a>';
        $xcontent.=' </div>';
        $xcontent.='<div class="pull-right">';
        $xcontent.='<div class="input-append">
				  <input type="text" placeholder="Kata kunci" id="edSearch">
				  <button onclick = "search(0);" class="btn" type="button"><i class="icon-search"></i></button>
				</div>';
        $xcontent.=' </div>';
        $xcontent.='<h3>List User</h3>';

        $this->load->helper('form');
        $end = 9;
//        $this->load->model('modelslider');
        $query = $this->modeluser->getListuserbyusername($xstart, $end, 'DESC', $xSearch);
        $xend = $this->modeluser->getSumuser()->jumlah;
//        $xcontent = '';

        $xcontent.='<table class="table table-hover table-striped">';
        $xcontent.='<thead>';
        $xcontent.='<tr>';
        $xcontent.='<td style="width:2%;">Idx</td>';
        $xcontent.='<td style="width:10%;">User Name</td>';
        $xcontent.='<td style="width:25%;">Password</td>';
        $xcontent.='<td style="width:35%;">Nama</td>';
        $xcontent.='<td style="width:20%;">Email</td>';
        $xcontent.='<td style="width:8%;">Pilihan</td>';
        $xcontent.='</tr>';
        $xcontent.='</thead>';
        $xcontent.='<tbody>';
        $i = 0;
        $xlimit = ceil($xend / $end);
        if ($xstart == 0) {
            $no = 1;
        } else {
            $no = $xstart + 1;
        }

        foreach ($query->result() as $row) {
            $xcontent.='<tr>';
            $xcontent.='<td>' . $no++ . '</td>';
            $xcontent.='<td>' . $row->username . '</td>';
            $xcontent.='<td>' . $row->passwd . '</td>';
            $xcontent.='<td>' . $row->email . '</td>';
            $xcontent.='<td>' . $row->nama . '</td>';
            $xcontent.='<td class="center">';
            $xcontent.='<a  onclick = "add(' . $row->idx . ');" data-toggle="tooltip" title="Edit" class="btn btn-default btn-mini"><i class="icon-pencil"></i></a>';
            $xcontent.='<a  onclick = "deletedata(\'' . $row->idx . '\',\'' . $row->nama . '\');" data-toggle="tooltip" title="Hapus" class="btn btn-default btn-mini"><i class="icon-trash icon-red"></i></a>';
            $xcontent.='</td>';
            $xcontent.='</tr>';
        }
        $xcontent.='</tbody>';
        $xcontent.='<thead>';
        $xcontent.='<tr>';
        $xcontent.='<td colspan="6">';
        $xcontent.='<img src="' . base_url() . 'images/first.png" style="border:none;width:20px;cursor:pointer;margin-right: 5px;float:left;" onclick = "search(1);"/>';
        $xcontent.='<img src="' . base_url() . 'images/prev1.png" style="border:none;width:20px;cursor:pointer;margin-right: 5px;float:left;" onclick = "search(' . ($xstart - $end) . ');"/>';


        for ($i; $i < $xlimit; $i++) {

            $xcontent.=' <div style="cursor:pointer;float:left;margin-right: 5px;" onclick = "search(' . ($i * $end) . ');">' . ($i + 1) . '</div> ';
        }
        $xcontent.='<img src="' . base_url() . 'images/next1.png" style="border:none;width:20px;cursor:pointer;margin-right: 5px;" onclick = "search(' . ($xstart + $end) . ');"/>';
        $xcontent.='<img src="' . base_url() . 'images/last.png" style="border:none;width:20px;cursor:pointer;" onclick = "search(' . ($xend ) . ');"/>';
        $xcontent.='</td>';
//        $xcontent.='<td >Search ' . form_input('edSearch', '', 'id="edSearch" onchange="searchnews(0);"') . '</td>';

        $xcontent.='</tr>';
        $xcontent.='</thead>';
        $xcontent.='</table>';
        $xcontent.=' </div>';

        $xcontent.=' </div>';
        return $xcontent;
    }

    function getfromadd() {
        $this->load->helper('json');
        $this->load->helper('adds');
        $this->load->model('modeluser');
        $this->load->model('modelcategory');

        $this->load->helper('form');
        $idx = $_POST['idx'];
        $row = $this->modeluser->getdetailuser($idx);

        $xcontent = '';
        $xcontent.='<div class="btn-group-table btn-group">';
        $xcontent.='<a onclick = "save();" class="btn btn-success" type="button"><i class="icon-plus-sign icon-white"></i> Simpan</a>';
        $xcontent.='<a onclick="cancel();" class="btn btn-danger" type="button"><i class="icon-trash icon-white"></i> Batal</a>';
        $xcontent.=' </div>';
        $xcontent.=' <div class="content-cage">';
        $xcontent.='<div class="header"><i class="trt_keyboard"></i><span class="devider"></span> Input Product</div>';
        $xcontent.='<div id="form">';
        $xcontent.='<input type="hidden" id="idx" value="' . @$row->idx . '"/>';
        $xcontent.='<label style="float: left; width: 100px;">User Name :</label>' . form_input('username', @$row->username, 'id="username"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Password :</label>' . form_input('passwd', @$row->passwd, 'id="passwd"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Email :</label>' . form_input('email', @$row->email, 'id="username"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Nama :</label>' . form_input('nama', @$row->nama, 'id="nama"') . '<div id="clears"></div>';
        
        
        $xcontent.='</div>';
        $xcontent.=' </div>';
        $this->json_data['data'] = $xcontent;
        echo json_encode($this->json_data);
    }

    function search() {
        $xstart = $_POST['xstart'];
        $Search = $_POST['edSearch'];
        $this->load->helper('json');
        if (($xstart + 0) == -99) {
            $xstart = $this->session->userdata('awal', $xstart);
        }
        if ($xstart + 0 <= -1) {
            $xstart = 0;
            $this->session->set_userdata('awal', $xstart);
        } else {
            $this->session->set_userdata('awal', $xstart);
        }
        $this->json_data['tabledata'] = $this->getdatacontent($xstart, $Search);
//      $this->json_data['tabledata'] =$xstart; 
        echo json_encode($this->json_data);
    }

    function save() {
        $this->load->model("modeluser");
        $idx = $_POST['idx'];
        $username = $_POST['username'];
        $passwd = $_POST['passwd'];
        $email = $_POST['email'];
//        $randcode = $_POST['randcode'];
        $nama = $_POST['nama'];
        if ($idx == 0) {
            $this->modeluser->insertuser($idx, $username, $passwd, $email, '', $nama);
        } else {
            $this->modeluser->updateuser($idx, $username, $passwd, $email, '', $nama);
        }
    }

    function detele($idx) {
        $this->load->model("modeluser");
        $idx = $_POST['idx'];

        $this->modeluser->deleteuser($idx);
    }

}

?>