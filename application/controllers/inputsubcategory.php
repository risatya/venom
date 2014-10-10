<?php
class inputsubcategory extends CI_Controller{

    //put your code here
    public function index($xstart = 0, $xSearch = '') {
        $idpegawai = $this->session->userdata('idx');

        if (!empty($idpegawai)) {
            if ($xstart <= -1) {
                $xstart = 0;
            } $this->session->set_userdata('awal', $xstart);
            $head['ajax'] = '<script language="javascript" type="text/javascript" src="' . base_url() . 'ajax/ajaxinputsubcategory.js"></script>' . "\n" .
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
        $this->load->model('modelsubcategory');
		$this->load->model('modelcategory');
        $xcontent = '';
        $xcontent.='
                  <div class="page-header"><h1>Subcategory</h1><hr><hr><hr><hr></div> ';
        $xcontent.='<div id="content">';
        $xcontent.='<div class="btn-group-table btn-group">';
        $xcontent.='<a onclick = "add_subctgr(0);" class="btn btn-success" type="button"><i class="icon-plus-sign icon-white"></i> Tambah</a>';
//        $xcontent.='<a class="btn btn-danger" type="button"><i class="icon-trash icon-white"></i> Hapus</a>';
        $xcontent.=' </div>';
        $xcontent.='<div class="pull-right">';
        $xcontent.='<div class="input-append">
				  <input type="text" placeholder="Kata kunci" id="edSearch">
				  <button onclick = "search(0);" class="btn" type="button"><i class="icon-search"></i></button>
				</div>';
        $xcontent.=' </div>';
        $xcontent.='<h3>List Subcategory</h3>';

        $this->load->helper('form');
        $end = 10;
        
       
        //
//        $this->load->model('modelslider');
        $query = $this->modelsubcategory->getListsubcategory($xstart, $end, $xSearch, 'DESC');
        $xend = $this->modelsubcategory->getsumsubcategory()->jumlah;
//        $xcontent = '';
		
        $xcontent.='<table class="table table-hover table-striped">';
        $xcontent.='<thead>';
        $xcontent.='<tr>';
        $xcontent.='<td style="width:2%;">No</td>';
        $xcontent.='<td style="width:30%;">Subcategory</td>';
        $xcontent.='<td style="width:20%;">Category Parent</td>';
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
			//ambil category
			$datacategory=$this->modelcategory->getdetailcategory($row->idx);
			$category=$datacategory->category;
			//
            $xcontent.='<tr>';
            $xcontent.='<td>' . $no++ . '</td>';
            $xcontent.='<td>' . $row->subcategory . '</td>';
            $xcontent.='<td align="center">' . $category. '</td>';
            $xcontent.='<td class="center">';
            $xcontent.='<a  onclick = "add_subctgr(' . $row->idsubcategory . ');" data-toggle="tooltip" title="Edit" class="btn btn-default btn-mini"><i class="icon-pencil"></i></a>';
            $xcontent.='<a  onclick = "deletedata(\'' . $row->idsubcategory . '\',\'' . $row->subcategory . '\');" data-toggle="tooltip" title="Hapus" class="btn btn-default btn-mini"><i class="icon-trash icon-red"></i></a>';
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
        $this->load->model('modelsubcategory');
        $this->load->model('modelcategory');
//        $this->load->model('modelimageproduct');
        $this->load->helper('form');
        $idsubcategory = $_POST['idsubcategory'];
        $row = $this->modelsubcategory->getDetailsubcategory($idsubcategory);//ambl data subcategory
        $arraycategory=$this->modelcategory->getArrayCategory();

        $xcontent = '';
        $xcontent.='<div class="btn-group-table btn-group">';
        $xcontent.='<a onclick = "save();" class="btn btn-success" type="button"><i class="icon-plus-sign icon-white"></i> Simpan</a>';
        $xcontent.='<a onclick="cancel();" class="btn btn-danger" type="button"><i class="icon-trash icon-white"></i> Batal</a>';
        $xcontent.=' </div>';
        $xcontent.=' <div class="content-cage">';
        $xcontent.='<div class="header"><i class="trt_keyboard"></i><span class="devider"></span> Input Slider</div>';
        $xcontent.='<div id="form">';
        $xcontent.='<input type="hidden" id="idsubcategory" value="' . @$row->idsubcategory . '" name="idsubcategory"/>';
        $xcontent.='<label style="float: left; width: 100px;">Subcategory:</label>' . form_input('subcategory', @$row->subcategory, 'id="subcategory" value="$row->subcategory"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Category Parent :</label>' . form_dropdown('idx', $arraycategory, @$row->idx, 'id="idx"') . '<div id="clears"></div>';
      
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
        $this->load->model('modelsubcategory');
        $subcategory = $_POST['subcategory'];
        $idsubcategory=$_POST['idsubcategory'];
        $idx = $_POST['idx'];
        $data=array('subcategory'=>$subcategory,'idx'=>$idx);
		
        if ($idsubcategory == 0) {
            $this->modelsubcategory->insertsubcategory($data);
        } else {
            $this->modelsubcategory->updatesubcategory($data,$idsubcategory);
		}
    }
    function delete() {
        $idsubcategory = $_POST['idsubcategory'];
        $this->load->model('modelsubcategory');
        $this->modelsubcategory->detelesubcategory($idsubcategory);
    }
}

?>
