<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelmenu
 *
 * @author ASUS
 */
class modelmenu extends CI_Model {

    //put your code here
    function getcontact() {
        $con = $this->getDeialcontact();
        $xstr = '<div id="box1_right">
                        <div style="float:right;font-size:11px;line-height:15px;font-family:Arial, Helvetica, sans-serif;font-weight:bold;margin-bottom:15px;">
                            <p style="float:right;">How to Order.  ' . @$con->alamat . '</p><br/>
                            <p style="float:right;font-weight:normal;font-style:italic;">Telp. ' . @$con->no_tlp1 . ', ' . @$con->no_tlp2 . ', HP. ' . @$con->pin . ', ' . @$con->hp1 . ', ' . @$con->hp2 . '</p><br/>
                            <p style="float:right;font-weight:normal;font-style:italic;">PIN BB. ' . @$con->pin . '</p>
                        </div>';
        return $xstr;
    }

    function getDeialcontact() {
        $xstr = "SELECT * from contact order by idx DESC limit 0,1";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function listli($parent, $sub = '') {
        return '<li ><a href="" >' . $parent . '</a>' . $sub . '</li>';
    }

    function listreecheck($id, $parent, $child, $link) {
        return '<li ><a href="' . base_url() . '' . $link . '" class="label">' . $parent . '<i class="icon-chevron-down"></i></a>' . $child . '</li>' . "\n";
    }

    function listparent($id, $parent, $child, $link) {
        return '<li ><a href="' . base_url() . '' . $link . '" ><strong>' . $parent . '</strong></a>' . $child . '</li>' . "\n";
    }

    function listparents($id, $parent, $child, $link) {
        return '<li class="active"><a href="' . base_url() . '' . $link . '" ><strong>' . $parent . '</strong></a>' . $child . '</li>' . "\n";
    }

    function getfooter() {
        $query = $this->getdetailfooter();

        $xstr = ' <ul>  ';
        foreach ($query->result() as $row) {
            if ($row->is_home != 'Yes') {
                $xstr.='<li><a href="' . base_url() . '" >' . $row->menu . '</a></li>';
            } else {
                $xstr.='<li><a href="' . $row->link . '/' . $row->idx . '" class="bordern">' . $row->menu . '</a></li>';
            }
        }
        $xstr.= ' </ul> ';
        return $xstr;
    }

    function menuadmin() {
        $this->load->model('modeladmin');
        $xcontent = '';
        $xcontent.='<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
			<div class="logo-center-mobile">
			<a href="#" class="nav-logo"></a>
			</div>
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="nav-collapse collapse">
            <ul class="nav">
         
				<li id="fat-menu" class="dropdown" > <a style="padding: 0px;" href="#" id="visit" role="button" class="dropdown-toggle" data-toggle="dropdown"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="visit">
                        <li><a tabindex="-1" href="' . base_url() . '">Visits Website</a></li>
                      </ul>
                      </li>
             			  
            </ul>			
			<ul class="nav pull-right">
			
			<li id="fat-menu" class="dropdown">
			  <a href="#" id="akun" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="trt_user_suit"></i> Hello, ' . @$this->modeladmin->getdatauser($this->session->userdata('idx'))->nama . ' <b class="caret"></b></a>
			  <ul class="dropdown-menu" role="menu" aria-labelledby="akun">
				<li><a tabindex="-1" href="' . base_url() . 'inputcontact"><i class="trt_user_suit"></i> My Profile</a></li>
				
				<li class="divider"></li>
				<li><a tabindex="-1" href="' . base_url() . 'admin/logout"><i class="trt_door_out"></i> Logout</a></li>
			  </ul>
			</li>
			
			</ul>
          </div>
        </div>
      </div>
    </div>';

        return $xcontent;
    }

    function leftmenuadmin() {
        $xcontent = '';
        $xcontent.='<div class="row-fluid">
              <div class="span2">
                  <ul class="nav nav-list sidebar-list">
                    <li class="active"><a href="' . base_url() . 'admin"><i class="icon-chevron-right"></i> <i class="trt_house"></i> Dashboard</a></li>
                   
                    <li><a href="' . base_url() . 'slider"><i class="icon-chevron-right"></i> <i class="trt_keyboard"></i> Slider</a></li>
                    <li><a href="' . base_url() . 'inputfaq"><i class="icon-chevron-right"></i> <i class="trt_keyboard"></i> FAQ</a></li>
                    <li><a href="' . base_url() . 'inputaboutus"><i class="icon-chevron-right"></i> <i class="trt_keyboard"></i> About Us</a></li>
                     <li><a href="' . base_url() . 'inputcategory"><i class="icon-chevron-right"></i> <i class="trt_keyboard"></i> Category</a></li> 
                     <li><a href="' . base_url() . 'inputsubcategory"><i class="icon-chevron-right"></i> <i class="trt_keyboard"></i> Subcategory</a></li>       
                     <li><a href="' . base_url() . 'inputproductshow"><i class="icon-chevron-right"></i> <i class="trt_keyboard"></i> My Product</a></li>  
                </ul>
          </div>  ';
        return $xcontent;
    }

    function getmenus($xParent = '') {
        if (!empty($xParent)) {
            $xParent = " WHERE parent = '" . $xParent . "' and isnav='Y'";
        } else {
            $xParent = " WHERE parent = '0' and isnav='Y'";
        }

        $xStr = "SELECT * FROM category $xParent order by sort_order DESC ";

        $query = $this->db->query($xStr);
        return $query;
    }

    function getChildMenuforTree($Query, $IsView = FALSE) {
        $buff = "";
        if (!empty($Query)) {
            foreach ($Query->result() as $row) {
                if ($IsView) {
                    $xChild = $this->getChildMenuforTree($this->getmenus($row->idx), $IsView);
                    $buff.=$this->listli($row->category, $xChild);
                } else {
                    $xChild = $this->getChildMenuforTree($this->getmenus($row->idx), $IsView);
                    if ($row->is_parent == 'Y') {
                        $buff.=$this->listreecheck($row->idx, $row->category, $xChild, $row->link . '/' . $row->idx);
                    } else {
                        $buff.=$this->listparent($row->idx, $row->category, $xChild, $row->link . '/' . $row->idx);
                    }
                }
            }
            if (!empty($buff)) {
                $buff = '<ul>' . $buff . '</ul>';
            }
        }
        return $buff;
    }

    function getMenuforTree($IsView = FALSE) {
        $buff = "";
        $query = $this->getmenus('');
        foreach ($query->result() as $row) {
            if ($IsView) {
                $xChild = $this->getChildMenuforTree($this->getmenus($row->idx), $IsView);
                $buff.=$this->listli($row->category, $xChild);
            } else {
                $xChild = $this->getChildMenuforTree($this->getmenus($row->idx), $IsView);
                if (empty($row->link)) {
                    $buff.=$this->listreecheck($row->idx, $row->category, $xChild, $row->link);
                } else {
                    $buff.=$this->listreecheck($row->idx, $row->category, $xChild, $row->link . '/' . $row->idx);
                }
            }
        }
        $buff = '<ul class="nav">' . $buff . '</ul>';
        return $buff;
    }

    function getmenuhome($idx) {
        $this->load->model('modelcategory');
        $idx1 = '';
        $idx2 = '';
        $idx3 = '';
        $idx4 = '';
        $idx5 = '';
        $idx6 = '';
        $idx7 = '';


        $query = $this->modelcategory->getListcategorybybaret(0, 10, 0, 'DESC');
       
        $xcontent = '<ul class="menu">';
        if ($idx =='') {
			$idx1 = 'class="active"';
			$xcontent.='   <li><a href="' . base_url() . '" '. $idx1 . ' >Home</a></li>';
		}
		else{
            $xcontent.='   <li><a href="' . base_url() . '" >Home</a></li>';
        }
        foreach ($query->result() as $row) {
            if(!empty($row->link)){
                $link=$row->link.'/'.$row->idx;
            }else{
                $link='';
            }
			
			$getTotalproduct=$this->db->query("select * from subcategory WHERE idx ='$row->idx'");
			$jum=$getTotalproduct->num_rows();
		
			 if ($jum == 1){
            if ($idx ==$row->idx) {

                $idx1 = 'class="active"';
				$qrSubCat = $this->modelcategory->getSubCat($idx);
				foreach ($qrSubCat->result() as $rowSubCat) {
					if($row->idx == $rowSubCat->idx){
				$xcontent.='	
									  <li><a href="' . base_url() . 'product/subcategory/' . $rowSubCat->idsubcategory . '"'. $idx1 . '>'.$row->category.'</a></li>
   								';	
					}
				}
				///////////////////////////////////////////////////////////////////////////////////////////////////////////
				$xcontent.='</li>';
            }else{
                $idx1 = 'class="active"';
				$qrSubCat = $this->modelcategory->getSubCat($row->idx);
				foreach ($qrSubCat->result() as $rowSubCat) {
					if($row->idx == $rowSubCat->idx){
				$xcontent.='	
									  <li><a href="' . base_url() . 'product/subcategory/' . $rowSubCat->idsubcategory . '">'.$row->category.'</a></li>
   								';	
					}
				}
				///////////////////////////////////////////////////////////////////////////////////////////////////////////
				$xcontent.='</li>';
			}
		}else{
			 if ($idx ==$row->idx) {

                $idx1 = 'class="active"';
                $xcontent.='   <li><a href="' . base_url() . '' .$link . '" ' . $idx1 . '>' . $row->category . '</a><ul>';
				//////////////////////////////////////////*Tambahan Soma*//////////////////////////////////////////////////
				$qrSubCat = $this->modelcategory->getSubCat($idx);
				foreach ($qrSubCat->result() as $rowSubCat) {
					if($row->idx == $rowSubCat->idx){
				$xcontent.='	
									  <li><a href="' . base_url() . 'product/subcategory/' . $rowSubCat->idsubcategory . '">'.$rowSubCat->subcategory.'</a></li>
   								';	
					}
				}
				///////////////////////////////////////////////////////////////////////////////////////////////////////////
				$xcontent.='</ul></li>';
            }else{
                $xcontent.='   <li><a href="' . base_url() . '' . $link . '" >' . $row->category . '</a><ul>';
				//////////////////////////////////////////*Tambahan Soma*//////////////////////////////////////////////////
				$qrSubCat = $this->modelcategory->getSubCat($row->idx);
				foreach ($qrSubCat->result() as $rowSubCat) {
					if($row->idx == $rowSubCat->idx){
				$xcontent.='	
									  <li><a href="' . base_url() . 'product/subcategory/' . $rowSubCat->idsubcategory . '">'.$rowSubCat->subcategory.'</a></li>
   								';	
					}
				}
				///////////////////////////////////////////////////////////////////////////////////////////////////////////
				$xcontent.='</ul></li>';
			}
		}
          
            
        }
        if ($idx ==103) {
			$idx1 = 'class="active"';
			$xcontent.='   <li><a href="' . base_url() . 'product/103" '. $idx1 . ' >Legacy</a>
							<ul>';
			$qrCat = $this->modelcategory->getCat($idx);
				foreach ($qrCat->result() as $rowCat) {
				$xcontent.='	
							 <li><a href="' . base_url() . 'product/sub/' . $rowCat->idx . '">'.$rowCat->category.'</a></li>';	
				}
								
   			$xcontent.='</ul></li>';
		}
		else{
            $xcontent.='   <li><a href="' . base_url() . 'product/103" >Legacy</a>
							<ul>';
				$qrCat = $this->modelcategory->getCat($idx);
				foreach ($qrCat->result() as $rowCat) {
				$xcontent.='	
							 <li><a href="' . base_url() . 'product/sub/' . $rowCat->idx . '">'.$rowCat->category.'</a></li>';	
				}
					
   				$xcontent.='</ul></li>';
        }
        if ($idx ==102) {
			$idx1 = 'class="active"';
			$xcontent.='   <li><a href="' . base_url() . 'product/102" '. $idx1 . ' >FAQ</a></li>';
		}
		else{
            $xcontent.='   <li><a href="' . base_url() . 'product/102" >FAQ</a></li>';
        }
        if ($idx ==23) {
			$idx1 = 'class="active"'; 
			$xcontent.='   <li><a href="' . base_url() . 'product/23" '. $idx1 . ' >Contact Us</a></li>';
		}
		else{
            $xcontent.='   <li><a href="' . base_url() . 'product/23" >Contact Us</a></li>';
        }
        if ($idx ==100) {
			$idx1 = 'class="active"';
			$xcontent.='   <li><a href="' . base_url() . 'product/100" '. $idx1 . ' >About Us</a></li>';
		}
		else{
            $xcontent.='   <li><a href="' . base_url() . 'product/100" >About Us</a></li>';
        }
        $xcontent.='</ul>';
        return $xcontent;
    }

}

?>
