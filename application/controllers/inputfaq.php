<?php

class inputfaq extends CI_Controller {
    public function index($xstart = 0, $xSearch = '') {
        $idpegawai = $this->session->userdata('idx');
        if (!empty($idpegawai)) {
            if ($xstart <= -1) {
                $xstart = 0;
            } $this->session->set_userdata('awal', $xstart);
            $head['ajax'] = '<script language="javascript" type="text/javascript" src="' . base_url() . 'ajax/ajaxinputfaq.js"></script>' . "\n" .
                    '<script language="javascript" type="text/javascript" src="' . base_url() . 'js/ckeditor/ckeditor.js"></script>' . "\n" .
                    '<script language="javascript" type="text/javascript" src="' . base_url() . 'js/ckfinder/ckfinder.js"></script>'. "\n" .
                    '<script language="javascript" type="text/javascript" src="' . base_url() . 'js/jquery.js"></script>';
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
   
        $this->load->model('modelfaq');
        $this->load->model('modelcategory');
        
        $xcontent = '';
        $xcontent.='
                  <div class="page-header"><h1>FAQ</h1><hr><hr><hr><hr></div> ';
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
        $xcontent.='<h3>List FAQ</h3>';

        $this->load->helper('form');
        $end = 10;
//        $this->load->model('modelslider');
        $query = $this->modelfaq->getListfaq($xstart, $end, 'DESC', $xSearch);
        $xend = $this->modelfaq->getSumfaq()->jumlah;
//        $xcontent = '';

        $xcontent.='<table class="table table-hover table-striped">';
        $xcontent.='<thead>';
        $xcontent.='<tr>';
        $xcontent.='<td style="width:2%;">No </td>';
        $xcontent.='<td style="width:35%;">Question</td>';
        $xcontent.='<td style="width:40%;">Answer</td>';
        $xcontent.='<td style="width:15%;">Category</td>';
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
			$datacategory=$this->modelcategory->getdetailcategory($row->idcategory);
			$category=@$datacategory->category;
            $xcontent.='<tr>';
            $xcontent.='<td>' . $no++ . '</td>';
            $xcontent.='<td>' . $row->question . '</td>';
            $xcontent.='<td>' . $row->answer . '</td>';
            $xcontent.='<td>' . @$category . '</td>';

            $xcontent.='<td class="center">';
            $xcontent.='<a  onclick = "add(' . $row->idfaq . ');" data-toggle="tooltip" title="Edit" class="btn btn-default btn-mini"><i class="icon-pencil"></i></a>';
            $xcontent.='<a  onclick = "deletedata(\'' . $row->idfaq . '\',\'' . $row->question . '\');" data-toggle="tooltip" title="Hapus" class="btn btn-default btn-mini"><i class="icon-trash icon-red"></i></a>';
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
	function mencoba(){
		
	}
	function getfromadd() {
        $this->load->helper('json');
        $this->load->helper('adds');
        $this->load->model('modelproductshow');
        $this->load->model('modelcategory');
        $this->load->model('modelfaq');
		
        $this->load->helper('form');
        $idfaq = $_POST['idfaq'];
        /*memilih id category yang dipilih di databasae*/
        $row = $this->modelfaq->getdetail($idfaq);
       
        /**/
        $petik_buka="'";
        $petik_tutup="'";

        $xcontent = '';
        $xcontent.='<div class="btn-group-table btn-group">';
        $xcontent.='<a onclick = "save();" class="btn btn-success" type="button"><i class="icon-plus-sign icon-white"></i> Simpan</a>';
        $xcontent.='<a onclick="cancel();" class="btn btn-danger" type="button"><i class="icon-trash icon-white"></i> Batal</a>';
        $xcontent.=' </div>';
        $xcontent.=' <div class="content-cage">';
        $xcontent.='<div class="header"><i class="trt_keyboard"></i><span class="devider"></span> Input Product</div>';
        $xcontent.='<div id="form">';
        $xcontent.='<input type="hidden" id="idfaq" value="' . $idfaq . '"/>';
		$xcontent.='<label style="float: left; width: 100px;">Category :</label>' . form_dropdown('idcategory', $this->modelcategory->getArraycategory(), @$row->idcategory, 'id="idcategory"') . '<div id="clears"></div>';
		$xcontent.='<label style="float: left; width: 100px;">Question :</label>' . form_textarea('question', urldecode(@$row->question), 'class="question" id="question" style="width:980px;height:30px"');
        $xcontent.='<label style="float: left; width: 100px;">Answer </label><div style="clear:both; height:15px;"></div>' . form_textarea('answer', urldecode(@$row->answer), 'class="ckeditor" id="desc_slider"');
		
	

        $xcontent.='</div>';
        $xcontent.=' </div>';
        $this->json_data['data'] = $xcontent;
        echo json_encode($this->json_data);
    }
   
    function getsubcategory() {
		$this->load->model('modelsubcategory');
		$this->load->helper('json');
        $this->load->helper('adds');
        $this->load->helper('form');
		$idx=$_POST['idx'];
		
		$xcontent=form_dropdown('id_subcategory', $this->modelsubcategory->getarraysubcategory($idx), @$row->idsubcategory, 'id="idsubcategory"') . '</div><div id="clears"></div>';
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
        $this->load->model('modelfaq');
        $idfaq = $_POST['idfaq'];
        $idcategory = $_POST['idcategory'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];

        $data=array(
					"idfaq"=>$idfaq,
					"idcategory"=>$idcategory,
					"question"=>$question,
					"answer"=>$answer
					);
        if ($idfaq == 0) {
           $this->modelfaq->insert($data);
        } else {
           $this->modelfaq->update($data,$idfaq);
        }
    }

    function delete() {
        $this->load->model("modelproductshow");
        $idproduct = $_POST['idproduct'];
        $this->modelproductshow->delete($idproduct);
    }
	

}

?>
