<?php
class modelproductshow extends CI_Model{
	function getAll(){
		$query=$this->db->query("select * from productshow");
		return $query->result();
	}
	function getdetail($idproduct){
		$query=$this->db->query("select * from productshow where idproduct='$idproduct'");
		return $query->row();
	}
	function update($data,$idproduct){
		$this->db->where('idproduct',$idproduct);
		$this->db->update('productshow',$data);
	}
	function delete($idproduct){
		$this->db->where('idproduct',$idproduct);
		$this->db->delete('productshow');
	}
	function insert($data){
		$this->db->insert('productshow',$data);
	}
	function getSumproduct() {
        $query = $this->db->query("SELECT COUNT(idproduct) as jumlah From productshow");
        $row = $query->row();
        return $row;
    }
    function getListproductbyproduct($start, $end, $mode, $product = "") {
        if (!empty($product)) {
            $product = " WHERE product Like '%" . $product . "%'";
        }
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM productshow $product order by idproduct $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }
	function getImagesGallery($product) {

        $xstr = "SELECT * FROM galery WHERE productKode='$product'";
        $query = $this->db->query($xstr);
        return $query;
    }
	function deleteimage($idproduct){
		$this->db->where('galeryKode',$idproduct);
		$this->db->delete('galery');
	}
	function getdetailproduct($idproduct) {
        $xstr = "SELECT * FROM productshow WHERE idproduct = '$idproduct'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
	
	function insertimage($data){
		$this->db->insert('galery',$data);
	}
}


?>
