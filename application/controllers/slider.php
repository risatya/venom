<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of slider
 *
 * @author PT.SYDECO
 */
class slider extends CI_Controller {

    //put your code here
    public function index($xstart = 0, $xSearch = '') {
        $idpegawai = $this->session->userdata('idx');

        if (!empty($idpegawai)) {
            if ($xstart <= -1) {
                $xstart = 0;
            } $this->session->set_userdata('awal', $xstart);
            $head['ajax'] = '<script language="javascript" type="text/javascript" src="' . base_url() . 'ajax/ajaxslider.js"></script>' . "\n" .
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
        $xcontent.=$this->getdatacontent($xstart, $xSearch);
        $xcontent.=' </div>';
        return $xcontent;
    }

    function getdatacontent($xstart, $xSearch) {
        $this->load->model('modelslider');

        $xcontent = '';
        $xcontent.='<div class="span10">
                  <div class="page-header"><h1>Slider</h1><hr><hr><hr><hr></div> ';
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
        $xcontent.='<h3>List Slider</h3>';

        $this->load->helper('form');
        $end = 10;
        $this->load->model('modelslider');
        $query = $this->modelslider->getListsliderbyTitle($xstart, $end, 'DESC', $xSearch);
        $xend = $this->modelslider->getSumslider()->jumlah;
//        $xcontent = '';

        $xcontent.='<table class="table table-hover table-striped">';
        $xcontent.='<thead>';
        $xcontent.='<tr>';
        $xcontent.='<td style="width:2%;">Idx</td>';
        $xcontent.='<td style="width:10%;">Title</td>';
        $xcontent.='<td style="width:25%;">Image</td>';
        $xcontent.='<td style="width:35%;">Description</td>';

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
            $xcontent.='<td>' . $row->Title . '</td>';
            $xcontent.='<td><img src="' . urldecode(@$row->image) . '" alt="" width=100%></td>';
            $xcontent.='<td>' . $row->readmore . '</td>';
    
            $xcontent.='<td class="center">';
            $xcontent.='<a  onclick = "add(' . $row->idx . ');" data-toggle="tooltip" title="Edit" class="btn btn-default btn-mini"><i class="icon-pencil"></i></a>';
            $xcontent.='<a  onclick = "deletedata(\'' . $row->idx . '\',\'' . $row->Title . '\');" data-toggle="tooltip" title="Hapus" class="btn btn-default btn-mini"><i class="icon-trash icon-red"></i></a>';
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
        $this->load->model('modelslider');
        $this->load->helper('form');
        $idx = $_POST['idx'];
        $row = $this->modelslider->getdetailslider($idx);
        $xcontent = '';
        $xcontent.='<div class="btn-group-table btn-group">';
        $xcontent.='<a onclick = "save();" class="btn btn-success" type="button"><i class="icon-plus-sign icon-white"></i> Simpan</a>';
        $xcontent.='<a href="' . base_url() . 'slider" class="btn btn-danger" type="button"><i class="icon-trash icon-white"></i> Batal</a>';
        $xcontent.=' </div>';
        $xcontent.=' <div class="content-cage">';
        $xcontent.='<div class="header"><i class="trt_keyboard"></i><span class="devider"></span> Input Slider</div>';
        $xcontent.='<div id="form">';
//        $xcontent.=form_button('save', 'Save', 'onclick="save();"');
//        $xcontent.=form_button('cancel', 'Cancel', 'onclick="cancel();"') . '<div id="clears"></div><hr></hr><div id="clears"></div>';
        $xcontent.='<input type="hidden" id="idx" value="' . @$row->idx . '"/>';
        $xcontent.='<label style="float: left; width: 100px;">Title :</label>' . form_input('title_slider', @$row->Title, 'id="title_slider"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Image</label>' . form_input('images_slider', urldecode(@$row->image), 'id="images_slider" style="float: left; "');
        $xcontent.=form_button('Browse', 'Browse', 'onclick="BrowseServer()" style="margin-left: 15px;float:left;"') . '<div id="clears"></div>';

        $xcontent.='<input type="hidden" id="link_slider" value=""/>' . '<div id="clears"></div>';
        $xcontent.=' <input type="hidden" id="sort_slider" value=""/>' . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Description</label><div style="clear:both; height:15px;"></div>' . form_textarea('desc_slider', urldecode(@$row->description), 'class="ckeditor" id="desc_slider"');
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
        $this->load->model("modelslider");
        $idx = $_POST['idx'];
        $Title = $_POST['Title'];
        $image = $_POST['image'];
        $link = $_POST['link'];
        $sort_order = $_POST['sort_order'];
        $description = $_POST['description'];
        if ($idx == 0) {
            $this->modelslider->insertslider($idx, $Title, $image, $link, $sort_order, $description);
        } else {
            $this->modelslider->updateslider($idx, $Title, $image, $link, $sort_order, $description);
        }
    }

    function delete() {
        $idx = $_POST['idx'];
        $this->load->model('modelslider');
        $this->modelslider->deleteSlider($idx);
    }

}

?>
