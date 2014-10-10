<?php
	class mencoba extends CI_Controller{
		function index(){ ?>
			

		<html>
			<head>
				<title>Membuat Select Berdasarkan select sebelumnya</title>
				<meta name="author" content="Chabib Nurozak">
				<meta charset="UTF-8">
				<script src='localhost/creativepro/js/jquery.js'></script>
				<script>
				   jQuery(document).ready(function(){
						jQuery("#category").change(function(){
							var getValue= jQuery(this).val();
							if(getValue == 0)
							{
								jQuery("#subcategory").html("<option>Pilih Category Dulu</option>");
							}
							else
							{
								jQuery.getJSON('localhost/creativepro/mencoba/getdata/?',{'idx' : getValue},function(data){
									var showData;
									jQuery.each(data,function(index,value){
										showData += "<option>"+value.subcategory+"</option>";
									})
									jQuery("#subcategory").html(showData)
								})
							}
						})
					})
		</script>
			</head>
			<body>
				<strong>Pilih Provinsi :</strong><br/>
				<select name="category" id="category">
					<option value="0">Pilih Provinsi</option>
					<?php
					$query  = "SELECT idx,category FROM category";
					$result = mysql_query($query);
					$output = '';
					while($hasil = mysql_fetch_assoc($result))
					{
						$output .= "<option value='".$hasil['idx']."'>".$hasil['category']."</option> \n";
					}
					echo $output;
					?>
				</select><br/>
				<strong>Pilih Kota :</strong><br/>
				<select name="subcategory" id="subcategory">
					<option>Pilih Provinsi Dulu</option>
				</select>
			</body>
		</html>

		<script type="javascript">
		$(function(){
			$("#category").change(function(){
				var getValue= $(this).val();
				if(getValue == 0)
				{
					$("#subcategory").html("<option>Pilih Category Dulu</option>");
				}
				else
				{
					$.getJSON('localhost/creativepro/mencoba/getdata/?',{'idx' : getValue},function(data){
						var showData;
						$.each(data,function(index,value){
							showData += "<option>"+value.subcategory+"</option>";
						})
						$("#subcategory").html(showData)
					})
				}
			})
		})
		</script>

			
			
			
		<?php	
		}
		function getdata(){	
			$idx = isset($_GET['idx']) ? intval($_GET['idx']) : 0;
			$query = "SELECT idsubcategory,subcategory FROM subcategory WHERE idx='$idx'";
			$result = mysql_query($query);
			$respon = array();
			while ($hasil = mysql_fetch_array($result))
			{
				$respon[] = $hasil;
			}
			echo json_encode($respon);

		}
	}

?>
