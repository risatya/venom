
<section id="content">
    <div class="padding">
         <div class="box-bg margin-bot">
         <h2 class="p0">FAQ</h2><hr />
        </div>
       
		<div style="width:900px;margin-left:30px;padding-bottom:20px;">
           <?php 
			foreach($faq as $row){?>
			   <b> <?php echo "$row->question"; ?> </b></br></br>
			       <?php echo $row->answer; ?> </br></br></br>
			 <?php
			 }
			 ?>  
        </div>

    </div>
</section>
