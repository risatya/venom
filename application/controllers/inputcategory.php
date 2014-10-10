<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inputcategory
 *
 * @author PT.SYDECO
 */
class inputcategory extends CI_Controller {

    //put your code here
    public function index($xstart = 0, $xSearch = '') {
        $idpegawai = $this->session->userdata('idx');

        if (!empty($idpegawai)) {
            if ($xstart <= -1) {
                $xstart = 0;
            } $this->session->set_userdata('awal', $xstart);
            $head['ajax'] = '<script language="javascript" type="text/javascript" src="' . base_url() . 'ajax/ajaxinputcategory.js"></script>' . "\n" .
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

    function getdatacontent($xstart, $xSearch) {
        $this->load->model('modelcategory');
        $xcontent = '';
        $xcontent.='
                  <div class="page-header"><h1>Category</h1><hr><hr><hr><hr></div> ';
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
        $xcontent.='<h3>List Category</h3>';

        $this->load->helper('form');
        $end = 10;
//        $this->load->model('modelslider');
        $query = $this->modelcategory->getListcategory($xstart, $end, $xSearch, 'DESC');
        $xend = $this->modelcategory->getsumcategory()->jumlah;
//        $xcontent = '';

        $xcontent.='<table class="table table-hover table-striped">';
        $xcontent.='<thead>';
        $xcontent.='<tr>';
        $xcontent.='<td style="width:2%;">Idx</td>';
        $xcontent.='<td style="width:30%;">Category</td>';
        $xcontent.='<td style="width:5%;">Menu Navigator</td>';
        $xcontent.='<td style="width:5%;">Sort order</td>';
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
            $xcontent.='<td>' . $row->category . '</td>';
            $xcontent.='<td>' . $row->isnav . '</td>';
            $xcontent.='<td>' . $row->sort_order . '</td>';
            $xcontent.='<td class="center">';
            $xcontent.='<a  onclick = "add(' . $row->idx . ');" data-toggle="tooltip" title="Edit" class="btn btn-default btn-mini"><i class="icon-pencil"></i></a>';
            $xcontent.='<a  onclick = "deletedata(\'' . $row->idx . '\',\'' . $row->category . '\');" data-toggle="tooltip" title="Hapus" class="btn btn-default btn-mini"><i class="icon-trash icon-red"></i></a>';
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
        $this->load->model('modelproduct');
        $this->load->model('modelcategory');
//        $this->load->model('modelimageproduct');
        $this->load->helper('form');
        $idx = $_POST['idx'];
        $row = $this->modelcategory->getDetailcategory($idx);

        $xcontent = '';
        $xcontent.='<div class="btn-group-table btn-group">';
        $xcontent.='<a onclick = "save();" class="btn btn-success" type="button"><i class="icon-plus-sign icon-white"></i> Simpan</a>';
        $xcontent.='<a onclick="cancel();" class="btn btn-danger" type="button"><i class="icon-trash icon-white"></i> Batal</a>';
        $xcontent.=' </div>';
        $xcontent.=' <div class="content-cage">';
        $xcontent.='<div class="header"><i class="trt_keyboard"></i><span class="devider"></span> Input Slider</div>';
        $xcontent.='<div id="form">';
        $xcontent.='<input type="hidden" id="idx" value="' . @$row->idx . '"/>';
        $xcontent.='<label style="float: left; width: 100px;">Category :</label>' . form_input('category', @$row->category, 'id="category"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Is Menu Navigator </label>' . form_dropdown('isnav', $this->isnav(), @$row->isnav, 'id="isnav"') . '<div id="clears"></div>';
        $xcontent.='<input type="hidden" id="parent" value=""/>';
        $xcontent.='<label style="float: left; width: 100px;">Sort Order :</label>' . form_input('sort_order', @$row->sort_order, 'id="sort_order"') . '<div id="clears"></div>';

        $xcontent.='<input type="hidden" id="bentuk_tampilan" value=""/>';
        $xcontent.='<input type="hidden" id="link" value=""/>';
        
        $xcontent.='</div>';
        $xcontent.=' </div>';
        $this->json_data['data'] = $xcontent;
        echo json_encode($this->json_data);
    }

    function bentuktampilan() {
        $isnav = array();
        $isnav['0'] = 'Contact';
        $isnav['1'] = 'About';
        $isnav['2'] = 'News';
        return $isnav;
    }

    function getlink() {
        $isnav = array();
        $isnav[''] = 'Home';
        $isnav['product'] = 'product';

        return $isnav;
    }

    function isnav() {
        $isnav = array();
        $isnav['N'] = 'No';
        $isnav['Y'] = 'Yes';
        return $isnav;
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
        $idx = $_POST['idx'];
        $this->load->model('modelcategory');
        $category = $_POST['category'];
        $parent = $_POST['parent'];
        $isnav = $_POST['isnav'];
        $sort_order = $_POST['sort_order'];
        if ($isnav == 'Y' && $parent != 0) {
            $is_parent = 'N';
        } else {
            $is_parent = 'Y';
        }
        $link='product';
        $bentuk_tampilan=$_POST['bentuk_tampilan'];
        if ($idx == 0) {
            $this->modelcategory->insertcategory('', $category, $parent, $isnav, $sort_order, $link, $is_parent,$bentuk_tampilan);
        } else {
            $this->modelcategory->updatecategory($idx, $category, $parent, $isnav, $sort_order, $link, $is_parent,$bentuk_tampilan);
//           
        }
    }

    function delete() {
        $idx = $_POST['idx'];
        $this->load->model('modelcategory');
        $this->modelcategory->detelecategory($idx);
    }

}

?>
