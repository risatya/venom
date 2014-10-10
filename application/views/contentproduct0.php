 <?php 
            $pageid=$this->uri->segment(3);
            if(!empty($pageid)){ 
               $title=@$this->modelproduct->getdetailproduct($this->uri->segment(3))->product;
               $description=@$this->modelproduct->getdetailproduct($this->uri->segment(3))->description;
               $img=@$this->modelproduct->getdetailproduct($this->uri->segment(3))->img;
            } else {
                $title=@$this->modelproduct->getdetailproductbyidcategory($this->uri->segment(2))->product; 
                $description=@$this->modelproduct->getdetailproductbyidcategory($this->uri->segment(2))->description;
                $img=@$this->modelproduct->getdetailproductbyidcategory($this->uri->segment(2))->img;
            }
?>

<div id="bluebar">
    <div id="bluebar-content">
        <div id="hero-container">
            <div id="hero-tl"></div>
            <div id="hero-tr"></div>
            <div id="hero-bl"></div>
            <div id="hero-br"></div>
            <div id="hero-strip-top"></div>
            <div id="hero-strip-bottom"></div>
            <div id="hero-items">
                
                    <div class="hero-item" style="background: url(<?php echo $img; ?>) no-repeat;"></div>
               
            </div>
            <div id="hero-details"></div>

        </div>
    </div>
</div>
<div id="header" style="height: auto; margin-bottom: 21px;">
   
</div>
<div style="clear: both;"></div>

    <div id="bluebar-content"></div>
    <div id="body-content">
        <div id="page-left">
           

            <div class="title"><h1><?php echo $title; ?> </h1></div>
        </div>
        <div id="page-right">
           
            <?php echo @$description; ?>
            <!--<h2> Selebihnya tentang kemampuan kami</h2>-->
            <div class="clear"></div>
         
        </div>
    </div>


</div>