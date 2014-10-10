<?php

class inputproductshow extends CI_Controller {
    public function index($xstart = 0, $xSearch = '') {
        $idpegawai = $this->session->userdata('idx');
        if (!empty($idpegawai)) {
            if ($xstart <= -1) {
                $xstart = 0;
            } $this->session->set_userdata('awal', $xstart);
            $head['ajax'] = '<script language="javascript" type="text/javascript" src="' . base_url() . 'ajax/ajaxinputproductshow.js"></script>' . "\n" .
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
   
        $this->load->model('modelproductshow');
        $xcontent = '';
        $xcontent.='
                  <div class="page-header"><h1>Product</h1><hr><hr><hr><hr></div> ';
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
        $xcontent.='<h3>List Product</h3>';

        $this->load->helper('form');
        $end = 10;
//        $this->load->model('modelslider');
        $query = $this->modelproductshow->getListproductbyproduct($xstart, $end, 'DESC', $xSearch);
        $xend = $this->modelproductshow->getSumproduct()->jumlah;
//        $xcontent = '';

        $xcontent.='<table class="table table-hover table-striped">';
        $xcontent.='<thead>';
        $xcontent.='<tr>';
        $xcontent.='<td style="width:2%;">No </td>';
        $xcontent.='<td style="width:20%;">Product</td>';
        $xcontent.='<td style="width:25%;">Image</td>';
        $xcontent.='<td style="width:45%;">Description</td>';
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
            $xcontent.='<td>' . $row->product . '</td>';
            $xcontent.='<td><img src="' . urldecode(@$row->img) . '" alt="" width=100%></td>';
            $xcontent.='<td>' . $row->readmore . '</td>';

            $xcontent.='<td class="center">';
            $xcontent.='<a  onclick = "add(' . $row->idproduct . ');" data-toggle="tooltip" title="Edit" class="btn btn-default btn-mini"><i class="icon-pencil"></i></a>';
            $xcontent.='<a  onclick = "deletedata(\'' . $row->idproduct . '\',\'' . $row->product . '\');" data-toggle="tooltip" title="Hapus" class="btn btn-default btn-mini"><i class="icon-trash icon-red"></i></a>';
			$xcontent.='<a onclick = "addgallery(' . $row->idproduct . ');" data-toggle="tooltip" title="add gallery" class="btn btn-default btn-mini">add gallery</a>';
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

	function getfromaddpalsu() {
        $this->load->helper('json');
        $this->load->helper('adds');
        $this->load->model('modelproductshow');
        $this->load->model('modelcategory');
        $this->load->model('modelsubcategory');
		
        $this->load->helper('form');
        $idproduct = $_POST['idproduct'];
        /*memilih id category yang dipilih di databasae*/
        $row = $this->modelproductshow->getdetail($idproduct);
        $arraysubcategory=$this->modelsubcategory->getdetailsubcategory(@$row->idsubcategory);
        $idcategory=@$arraysubcategory->idx;
        /*memilih subcategory yang terpilih*/
        $arraysubcategory=$this->modelsubcategory->getarraysubcategory(@$idcategory);
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
        $xcontent.='<input type="hidden" id="idproduct" value="' . $idproduct . '"/>';
        $xcontent.='<label style="float: left; width: 100px;">Product :</label>' . form_input('product',@$row->product, 'id="product"') . '<div id="clears"></div>';
		$xcontent.='<label style="float: left; width: 100px;">Category :</label>' . form_dropdown('idcategory', $this->modelcategory->getArraycategoryproduct(), @$idcategory, 'id="idcategory" onchange="tampilsubcategory(this.value)"') . '<div id="clears"></div>';
		$xcontent.='<label style="float: left; width: 100px;">Subcategory :</label><div id="tampilsubcategory">' . form_dropdown('idsubcategory', @$arraysubcategory,@$row->idsubcategory, 'id="idsubcategory"') . '</div><div id="clears"></div>';
        
        $xcontent.='<label style="float: left; width: 100px;">Image Home</label>' . form_input('img', urldecode(@$row->img), 'id="images_slider" style="float: left; "');
        $xcontent.=form_button('Browse', 'Browse', 'onclick="BrowseServer('.$petik_buka.'images_slider'.$petik_tutup.')" style="margin-left: 15px;float:left;"') . '<div id="clears"></div>';
       
        
       
        
        
        $xcontent.='<label style="float: left; width: 100px;">Specification </label><div style="clear:both; height:15px;"></div>' . form_textarea('specification', urldecode(@$row->specification), 'class="ckeditor" id="desc_slider"');
		$xcontent.='<label style="float: left; width: 100px;">Description </label><div style="clear:both; height:15px;"></div>' . form_textarea('description', urldecode(@$row->description), 'class="ckeditor" id="desc_slider2"');
		
	

        $xcontent.='</div>';
        $xcontent.=' </div>';
        $this->json_data['data'] = $xcontent;
        echo json_encode($this->json_data);
    }
	
	
	function addgallery() {
		$this->load->helper('json');

        $this->load->model('modelproductshow');
        $this->load->model('modelcategory');
        $this->load->model('modelsubcategory');
		
		
		
        $this->load->helper('form');
        $idproduct = $_POST['idproduct'];
		
		$query = $this->modelproductshow->getImagesGallery($idproduct);
		
		$detailProduct=$this->modelproductshow->getdetailproduct($idproduct);
        $nm_product=$detailProduct->product;
        /**/
        $petik_buka="'";
        $petik_tutup="'";

        $xcontent = '';
        $xcontent.='<div class="btn-group-table btn-group">';
        $xcontent.='<a onclick = "saveimage();" class="btn btn-success" type="button"><i class="icon-plus-sign icon-white"></i> Simpan</a>';
        $xcontent.='<a onclick="cancel();" class="btn btn-danger" type="button"><i class="icon-trash icon-white"></i> Batal</a>';
        $xcontent.=' </div>';
        $xcontent.=' <div class="content-cage">';
        $xcontent.='<div class="header"><i class="trt_keyboard"></i><span class="devider"></span> Add Images Gallery '.$nm_product.'</div>';
        $xcontent.='<div id="form">';
        $xcontent.='<input type="hidden" id="idproduct" value="' . $idproduct . '"/>';        
        $xcontent.='<label style="float: left; width: 100px;">Add Image</label>' . form_input('images_gallery', urldecode(@$row->image), 'id="images_gallery" style="float: left; "');
        $xcontent.=form_button('Browse', 'Browse', 'onclick="BrowseServer('.$petik_buka.'images_gallery'.$petik_tutup.')" style="margin-left: 15px;float:left;"') . '<div id="clears"></div>';
		
		$xcontent.='<table class="table table-hover table-striped">';
        $xcontent.='<thead>';
        $xcontent.='<tr>';
        $xcontent.='<td style="width:2%;">No</td>';
        $xcontent.='<td style="width:25%;">Image</td>';

        $xcontent.='<td style="width:8%;">Pilihan</td>';
        $xcontent.='</tr>';
        $xcontent.='</thead>';
		$xcontent.='<tbody>';
		$no=1;
		
		foreach ($query->result() as $row) {
		$xcontent.='<tr>';
        $xcontent.='<td>'.$no++.'</td>';
        $xcontent.='<td><img src="' . urldecode(@$row->galeryImage) . '" alt="" width="150px" height="150px"></td>';
    
        $xcontent.='<td class="center">';
        $xcontent.='<a  onclick = "deletedataimage(' . $row->galeryKode . ');" data-toggle="tooltip" title="Hapus" class="btn btn-default btn-mini"><i class="icon-trash icon-red"></i></a>';
        $xcontent.='</td>';
        $xcontent.='</tr>';
		}
		$xcontent.='</tbody>';

		$xcontent.='</table>';
		 
		
        $xcontent.='</div>';
        $xcontent.=' </div>';
        $this->json_data['data'] = $xcontent;
        echo json_encode($this->json_data);
    }
	
    function getfromadd() {
        $this->load->helper('json');
        $this->load->helper('adds');
        $this->load->model('modelproduct');
        $this->load->model('modelcategory');
        $this->load->model('modelsubcategory');
        $petik_buka="'";
        $petik_tutup="'";
		
        $this->load->helper('form');
        $idproduct = $_POST['idproduct'];
        $row = $this->modelproduct->getdetailproduct($idproduct);
       

        $xcontent = '';
        $xcontent.='<div class="btn-group-table btn-group">';
        $xcontent.='<a onclick = "save();" class="btn btn-success" type="button"><i class="icon-plus-sign icon-white"></i> Simpan</a>';
        $xcontent.='<a onclick="cancel();" class="btn btn-danger" type="button"><i class="icon-trash icon-white"></i> Batal</a>';
        $xcontent.=' </div>';
        $xcontent.=' <div class="content-cage">';
        $xcontent.='<div class="header"><i class="trt_keyboard"></i><span class="devider"></span> Input Product</div>';
        $xcontent.='<div id="form">';
        $xcontent.='<input type="hidden" id="idproduct" value="' .$idproduct. '"/>';
        $xcontent.='<label style="float: left; width: 100px;">Product :</label>' . form_input('product', @$row->product, 'id="product"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Category :</label>' . form_dropdown('id_category', $this->modelcategory->getArraycategoryproduct(), @$row->idcategory, 'id="id_category" onchange="tampilsubcategory(this.value)"') . '<div id="clears"></div>';
		$xcontent.='<label style="float: left; width: 100px;">Subcategory :</label><div id="tampilsub">' . form_dropdown('idsubcategory', $this->modelsubcategory->getArraysubcategoryblank(), @$row->idcategory, 'id="idsubcategory"') . '</div><div id="clears"></div>';
       
        $xcontent.='<label style="float: left; width: 100px;">Search Image File 1</label>' . form_input('img', urldecode(@$row->img), 'id="images_slider" style="float: left; "');
        $xcontent.=form_button('Browse', 'Browse', 'onclick="BrowseServer('.$petik_buka.'images_slider'.$petik_tutup.')" style="margin-left: 15px;float:left;"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Image 1 </label>' . form_input('image_1', urldecode(@$row->img), 'id="images_slider1" style="float: left; "');
        $xcontent.=form_button('Browse', 'Browse', 'onclick="BrowseServer('.$petik_buka.'images_slider1'.$petik_tutup.')" style="margin-left: 15px;float:left;"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Image 2 </label>' . form_input('image_2', urldecode(@$row->img), 'id="images_slider2" style="float: left; "');
        $xcontent.=form_button('Browse', 'Browse', 'onclick="BrowseServer('.$petik_buka.'images_slider2'.$petik_tutup.')" style="margin-left: 15px;float:left;"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Image 3 </label>' . form_input('image_3', urldecode(@$row->img), 'id="images_slider3" style="float: left; "');
        $xcontent.=form_button('Browse', 'Browse', 'onclick="BrowseServer('.$petik_buka.'images_slider3'.$petik_tutup.')" style="margin-left: 15px;float:left;"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Image 4 </label>' . form_input('image_4', urldecode(@$row->img), 'id="images_slider4" style="float: left; "');
        $xcontent.=form_button('Browse', 'Browse', 'onclick="BrowseServer5('.$petik_buka.'images_slider4'.$petik_tutup.')" style="margin-left: 15px;float:left;"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Image 5 </label>' . form_input('image_5', urldecode(@$row->img), 'id="images_slider5" style="float: left; "');
        $xcontent.=form_button('Browse', 'Browse', 'onclick="BrowseServer('.$petik_buka.'images_slider5'.$petik_tutup.')" style="margin-left: 15px;float:left;"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Image 6 </label>' . form_input('image_6', urldecode(@$row->img), 'id="images_slider6" style="float: left; "');
        $xcontent.=form_button('Browse', 'Browse', 'onclick="BrowseServer('.$petik_buka.'images_slider6'.$petik_tutup.')" style="margin-left: 15px;float:left;"') . '<div id="clears"></div>';
        $xcontent.='<label style="float: left; width: 100px;">Specification </label><div style="clear:both; height:15px;"></div>' . form_textarea('desc_slider', urldecode(@$row->description), 'class="ckeditor" id="desc_slider"');
        $xcontent.='<label style="float: left; width: 100px;">Description </label><div style="clear:both; height:15px;"></div>' . form_textarea('description', urldecode(@$row->description), 'class="ckeditor" id="desc_slider2"');
		
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
        $this->load->model('modelproductshow');
        $idproduct = $_POST['idproduct'];
        $product = $_POST['product'];
        $img = $_POST['img'];
        $image1 = $_POST['image1'];
        $image2 = $_POST['image2'];
        $image3 = $_POST['image3'];
        $image4 = $_POST['image4'];
        $image5 = $_POST['image5'];
        $image6 = $_POST['image6'];
        $description=$_POST['description'];
        $specification=$_POST['specification'];
        $idsubcategory=$_POST['idsubcategory'];
        $data=array(
					"product"=>$product,
					"description"=>$description,
					"specification"=>$specification,
					"idsubcategory"=>$idsubcategory,
					"img"=>$img,
					"image1"=>$image1,
					"image2"=>$image2,
					"image3"=>$image3,
					"image4"=>$image4,
					"image5"=>$image5,
					"image6"=>$image6
					);
        if ($idproduct == 0) {
           $this->modelproductshow->insert($data);
        } else {
           $this->modelproductshow->update($data,$idproduct);
        }
    }

    function delete() {
        $this->load->model("modelproductshow");
        $idproduct = $_POST['idproduct'];
        $this->modelproductshow->delete($idproduct);
    }
	
	function deleteimage() {
        $this->load->model("modelproductshow");
        $idproduct = $_POST['idproduct'];
        $this->modelproductshow->deleteimage($idproduct);
    }
	
	
	function saveimage() {
        $this->load->model('modelproductshow');
        $idproduct = $_POST['idproduct'];
        $image = $_POST['image'];
		$galeryKode= "";
        $data=array(
					"galeryKode"=>$galeryKode,
					"productKode"=>$idproduct,
					"galeryImage"=>$image
					);
       
           $this->modelproductshow->insertimage($data);
    }
	

}

?>
