<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of product
 *
 * @author PT.SYDECO
 */
class product extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $ses = $this->session->userdata('ip');
        if (!empty($ses)) {
            $this->session->userdata('ip');
        } else {
            $ip = $this->input->ip_address();
            $this->session->set_userdata('ip', $ip);
            date_default_timezone_set('Asia/Jakarta');
            $timenow = date('r');
            $date_added = date('Y-m-d', strtotime($timenow));
            $this->load->model('modelvisited');
            $this->modelvisited->insertvisited('', $ip, $date_added);
        }
    }

    public function index() {
        $this->load->model('modelhistory');
        $this->load->model('modelproduct');
        $this->load->model('modelaboutus');
        $this->load->model('modelcategory');
        $this->load->model('modelmenu');
        $this->load->model('modelcontact');
        $pageid = $this->uri->segment(2);
        $content['menu'] = $this->modelmenu->getmenuhome($pageid);


        $script = '<script type="text/javascript"> Cufon.now(); </script><script type="text/javascript">';

        $content['script'] = $script;
        $content['slider'] = '';
        $this->load->view('head', $content);
        if($pageid==23){
           $this->load->view('contentcontact');  
        }
        else if($pageid==22){
			$productId = $this->uri->segment(2);
           	$content['isiSub'] = $this->modelproduct->getSub($productId);
			$jumlah=$this->modelproduct->getTotalSub($productId)->row();
			$content['ada']=$jumlah->jumlah;
			$this->load->view('subcategory',$content);
        }
        /*ABOUT US*/
        else if($pageid==100){
			$this->load->model('modelaboutus');
			$data['title']=$this->modelaboutus->getaboutus(1)->title;
			$data['description']=$this->modelaboutus->getaboutus(1)->description;
            $this->load->view('aboutus',$data);
        }
        /*FAQ*/
        else if($pageid==102){
			$this->load->model('modelfaq');
			$data['faq']=$this->modelfaq->getallfaq();
            $this->load->view('faq',$data);
        }
		 else if($pageid==103){
			$content['isiCat']=  $this->modelproduct->getCat();
			$this->load->view('contenthome',$content);
        }
        /*AMO*/
        else{
			$idx = $this->uri->segment(2);
			$content['isiSub']=  $this->modelproduct->getSubCat($idx);
			$this->load->view('contentproduct',$content);
        }
        $this->load->view('footer', $content);
    }
    
	function legacy(){
		
	}
	function subcategory(){
		//tambahan Soma 03/10/2014
		$this->load->model('modelhistory');
        $this->load->model('modelproduct');
        $this->load->model('modelaboutus');
        $this->load->model('modelcategory');
        $this->load->model('modelmenu');
        $this->load->model('modelcontact');
		$pageid = $this->uri->segment(2);
		$content['menu'] = $this->modelmenu->getmenuhome($pageid);
        $script = '<script type="text/javascript"> Cufon.now(); </script><script type="text/javascript">';
		$productId = $this->uri->segment(3);
		$content['isiSub'] = $this->modelproduct->getSubProduct($productId);
		
		$jumlah=$this->modelproduct->getTotalSubProduct($productId)->row();
		$content['ada']=$jumlah->jumlah;
		
		
				
        $content['script'] = $script;
        $content['slider'] = '';
		$this->load->view('head', $content);
		$this->load->view('subcategory',$content);
		$this->load->view('footer', $content);
		///////////////////////////
	}
	
	function searchproduct(){
		//tambahan Soma 06/10/2014
		$cari = $this->input->post('search');
		$this->load->model('modelhistory');
        $this->load->model('modelproduct');
        $this->load->model('modelaboutus');
        $this->load->model('modelcategory');
        $this->load->model('modelmenu');
        $this->load->model('modelcontact');
		$pageid = $this->uri->segment(2);
		$content['menu'] = $this->modelmenu->getmenuhome($pageid);
        $script = '<script type="text/javascript"> Cufon.now(); </script><script type="text/javascript">';
		$productId = $this->uri->segment(3);
		$content['isiSub'] = $this->modelproduct->getPro($cari);
		
		$jumlah=$this->modelproduct->getTotalSubProduct($productId)->row();
		$content['jumlah']=$jumlah->jumlah;
		
		
		$total=$this->modelproduct->getTotalCari($cari)->row();
		$content['ada']=$total->jumlah;
		
				
        $content['script'] = $script;
        $content['slider'] = '';
		$this->load->view('head', $content);
		$this->load->view('subcategory',$content);
		$this->load->view('footer', $content);
		///////////////////////////
	}
	
	function sub(){
		//tambahan Soma 03/10/2014
				$this->load->model('modelhistory');
        $this->load->model('modelproduct');
        $this->load->model('modelaboutus');
        $this->load->model('modelcategory');
        $this->load->model('modelmenu');
        $this->load->model('modelcontact');
		$pageid = $this->uri->segment(2);
		$content['menu'] = $this->modelmenu->getmenuhome($pageid);
        $script = '<script type="text/javascript"> Cufon.now(); </script><script type="text/javascript">';
		$productId = $this->uri->segment(3);
		$content['isiSub'] = $this->modelproduct->getSub($productId);
		
		$jumlah=$this->modelproduct->getTotalSub($productId)->row();
		$content['ada']=$jumlah->jumlah;
		
		
				
        $content['script'] = $script;
        $content['slider'] = '';
		$this->load->view('head', $content);
		$this->load->view('subcategory',$content);
		$this->load->view('footer', $content);
		///////////////////////////
	}
	function detail(){
		//tambahan Soma 03/10/2014
		$this->load->model('modelhistory');
        $this->load->model('modelproduct');
        $this->load->model('modelaboutus');
        $this->load->model('modelcategory');
        $this->load->model('modelmenu');
        $this->load->model('modelcontact');
		$pageid = $this->uri->segment(2);
		$content['menu'] = $this->modelmenu->getmenuhome($pageid);
		$productid = $this->uri->segment(3);
		$content['isiSub'] = $this->modelproduct->getSubProductDetail($productid);
		
		$content['isiGallery'] = $this->modelproduct->getImageGallery($productid);
		
		
        $script = '<script type="text/javascript"> Cufon.now(); </script><script type="text/javascript">';
        $content['script'] = $script;
        $content['slider'] = '';
		$this->load->view('head', $content);
		$this->load->view('slideproduct',$content);
		$this->load->view('footer', $content);
		////////////////////////////
	}


}

?>
