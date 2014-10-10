<section id="content">
		<div class="padding">
          	<div class="wrapper margin-bot">

<?php  
if ($ada > 0){
echo "<table class='body-tabel' border='1'><tr>";
$i = 0;
foreach($isiSub->result() as $row) :?>
<?php 

echo "			
			<td align=center>
			<a href='".base_url()."product/detail/$row->idproduct'>
			<img src='$row->img' width='220px' height='200'>
			</a>
			<br>
			<br>
			<b><a href='".base_url()."product/detail/$row->idproduct' style='color:#000;text-decoration:none'>$row->product</a> </b>&nbsp;&nbsp;&nbsp;
			</td>
		";
		if ($i++ == 3) echo '</tr><tr>';
?>

<?php endforeach; 
echo "</tr></table>";
}else{
	echo "<div align='center'>No Data</div>";	
}
?>

       	  </div>
         </div>
</section>

<a href="" style='color:#000; text-decoration:none'></a>
