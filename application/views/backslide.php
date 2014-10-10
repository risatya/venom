
<link rel="stylesheet" href="<?php echo base_url(); ?>assetslide/style.css" />

<section id="content">
      <div class="padding">
    <table width="100%" border="0">
      <tr>
        <td width="60%">
        
        <div class="padding">
          <div class="wrapper margin-bot">
            <ul id="slideshow">
            <?php  foreach($isiSub->result() as $row) :?>
            <?php
			if ($row->img == ""){
				
			}else{
				echo "
				<li>
					<h3>$row->product</h3>
					<span>$row->img</span>
					<p>$row->product</p>
					<a href='#'><img src='$row->img' width='125px' height='75px'></a>
				</li>
				";
			}
			foreach($isiGallery->result() as $rowGallery) :
			echo "
				<li>
					<h3>anu</h3>
					<span>$rowGallery->galeryImage</span>
					<p>$row->product</p>
					<a href='#'><img src='$rowGallery->galeryImage' width='125px' height='75px'></a>
				</li>
				";
			?>
            <?php endforeach; ?>
            
            
             <?php endforeach; ?>
            </ul>
            <div id="wrapper">
              <div id="fullsize">
                <div id="imgprev" class="imgnav" title="Previous Image"></div>
                <div id="imglink"></div>
                <div id="imgnext" class="imgnav" title="Next Image"></div>
                <div id="image"></div>
                <div id="information">
                  <h3></h3>
                  <p></p>
                </div>
              </div>
              <div id="thumbnails">
                <div id="slideleft" title="Slide Left"></div>
                <div id="slidearea">
                  <div id="slider"></div>
                </div>
                <div id="slideright" title="Slide Right"></div>
              </div>
            </div>
            <script type="text/javascript" src="<?php echo base_url(); ?>assetslide/compressed.js"></script>
            <script type="text/javascript">

	$('slideshow').style.display='none';
	$('wrapper').style.display='block';
	var slideshow=new TINY.slideshow("slideshow");
	window.onload=function(){
		slideshow.auto=true;
		slideshow.speed=5;
		slideshow.link="linkhover";
		slideshow.info="information";
		slideshow.thumbs="slider";
		slideshow.left="slideleft";
		slideshow.right="slideright";
		slideshow.scrollSpeed=4;
		slideshow.spacing=5;
		slideshow.active="#fff";
		slideshow.init("slideshow","image","imgprev","imgnext","imglink");
	}
        </script>
          </div>
        </div></td>
        <td valign="top">
        <table width="100%" border="0">
          <tr>
            <td><h2>Product Info</h2></td>
          </tr>
          <tr>
            <td><hr></td>
          </tr>
          <tr>
            <td>
            <?Php
			echo "<br>";
			echo "$row->specification";
			?>
            </td>
          </tr>
          </table>
        </td>
        <td valign="top" width="1%">&nbsp;</td>
      </tr>
    </table>
</div>
</content>
