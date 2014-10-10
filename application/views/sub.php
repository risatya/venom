<section id="content">
		<div class="padding">
          	<div class="wrapper margin-bot">

<?php  
echo "<table  border='0' cellspacing='10px'><tr>";
$i = 0;
foreach($isiSub->result() as $row) :?>
<?php 

echo "			
			<td align=center>
			<table class='body-tabel' border='1'><tr><td>
			<a href='".base_url()."product/detail/$row->idproduct'>
			<img src='$row->img' width='220px' height='200'>
			</a>
			<br>
			<br>
			<b><div align='center'><a href='".base_url()."product/detail/$row->idproduct' style='color:#000;text-decoration:none'>$row->product</a></div> </b>&nbsp;&nbsp;&nbsp;</td></tr></table> 
			</td>
			<td>
			&nbsp;
			</td>
		";
		if ($i++ == 3) echo '</tr><tr>';
?>

<?php endforeach; 
echo "</tr></table>";
?>

       	  </div>
         </div>
</section>

<a href="" style='color:#000; text-decoration:none'></a>
