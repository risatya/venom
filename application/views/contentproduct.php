<section id="content">
		<div class="padding">
          	<div class="wrapper margin-bot"><strong style="font-size: 25px">
            Case Category<br />
<?php
echo "<table border='0' width='100%'><tr>";
            $i = 0;
foreach($isiSub->result() as $row) :?>
<?php 
if ($i == 0 || $i == 1 || $i == 2){
$panjang='width=30%';	
}else{
$panjang="";	
}
echo "			
			<td align='left' $panjang>
		<br>
			<b>&nbsp;&nbsp;&nbsp;<a href='".base_url()."product/subcategory/$row->idsubcategory' style='color:#F00;text-decoration:none;font-size: 20px'>&raquo; $row->subcategory</a> </b>
		<br><br>
			</td>
		";
		if ($i++ == 2) echo '<br><br></tr><tr>';
?>

<?php endforeach; 
echo "</tr></table>";
?>
            </strong></div>
        </div>
</section>