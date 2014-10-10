<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author PT.SYDECO
 */
class home extends CI_Controller {

    //put your code here'
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
        $this->load->model('modelslider');
        $this->load->model('modelmenu');
        $this->load->model('modelcontact');
        $pageid = $this->uri->segment(2);
        $content['menu'] = $this->modelmenu->getmenuhome(19);

        $script = '<script type="text/javascript"> Cufon.now(); </script><script type="text/javascript">';
        $script.="$(function(){
			$('.slider')._TMS({
				prevBu:'.prev',
				nextBu:'.next',
				playBu:'.play',
				duration:800,
				easing:'easeOutQuad',
				preset:'simpleFade',
				pagination:false,
				slideshow:3000,
				numStatus:false,
				pauseOnHover:true,
				banners:true,
				waitBannerAnimation:false,
				bannerShow:function(banner){
					banner
						.hide()
						.fadeIn(400)
				},
				bannerHide:function(banner){
					banner
						.show()
						.fadeOut(400)
				}
			});
		})
	</script>";
        $content['script'] = $script;
        $content['slider']=  $this->getslider2();
		$content['isiCat']=  $this->modelproduct->getCat();
        $this->load->view('head', $content);
        $this->load->view('contenthome',$content);
        $this->load->view('footer', $content);
    }

    function getslider() {
        $this->load->model('modelslider');
        $xcontent = '';
        $query = $this->modelslider->getListsliderbyTitle(0, 100, 'DESC', "");
        $xcontent.=' <div class="row-3">
                        <div class="slider-wrapper">
                            <div class="slider">
                                <ul class="items">';
        foreach ($query->result()as $row) {
            $xcontent.='<li><img src = "'.$row->image.'" alt = "" style="height: 403px;width: 948px;">
        <strong class = "banner">
        <strong class = "b1">'.$row->Title.'</strong>
        
        <strong class = "b3">'.$row->description.' </strong>
        </strong>
        </li >';
        }
        $xcontent.='</ul>
        <a class="prev" href="#">prev</a>
                                <a class="next" href="#">prev</a>
                            </div>
        </div>';
        $xcontent.='</div>';
        return $xcontent;
    }
    function getslider2(){
		$this->load->model('modelslider');
		$query = $this->modelslider->getListsliderbyTitle(0, 100, 'DESC', "");
		
		$xcontent='
		<div class="row-3">
			<div class="slider-wrapper">
				<div class="slider">
                                                              
					<div class="quake-slider">
						<div class="quake-slider-images">';
						foreach ($query->result()as $row) {
							$xcontent.='<a target="_blank" href="javascript:">
							<img src="'.$row->image.'" alt="" />
							</a>';
						}
		
				$xcontent.='</div>
						<div class="quake-slider-captions">';
						foreach ($query->result()as $row) {
							$xcontent.='<div class="quake-slider-caption">
							'.$row->description.'	
							</div>';
						}
							
						$xcontent.='</div>
					</div>
					
			</div></div></div></br>';
			return $xcontent;
	}

}

?>
