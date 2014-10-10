<?php

class modelproduct extends CI_Model {

    function getdetailproduct($idx) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',3) as readmore FROM product WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
    function getdetailproductbyidcategory($idcategory) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',3) as readmore FROM product WHERE idcategory='" . $idcategory . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    public function fetch_product($start, $end, $mode, $history = "") {
        if (!empty($history)) {
            $history = " WHERE product Like '%" . $history . "%'";
        }
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM product $history order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function fetch_products($start, $end, $mode, $history = "") {
        if (!empty($history)) {
            $history = " WHERE idcategory = '" . $history . "'";
        }
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM product $history order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function record_count() {
//        return $this->db->count_all("product");
        $xstr = "SELECT COUNT(idx) as jumlah From product";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function record_counts($idcategory) {
//        return $this->db->count_all("product");
        $xstr = "SELECT COUNT(idx) as jumlah From product WHERE idcategory ='" . $idcategory . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListproductbyproduct($start, $end, $mode, $product = "") {
        if (!empty($product)) {
            $product = " WHERE product Like '%" . $product . "%'";
        }
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM product $product order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }

    function getorderdetailproduct($start, $end, $mode, $idx) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM product WHERE idx='" . $idx . " order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getorderdetailproductishome($start, $end, $mode, $is_home) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM product WHERE is_home='" . $is_home . "' order by is_home $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
     function getorderListproductidcategory($start, $end, $mode, $idcategory) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM product WHERE idcategory='" . $idcategory . "' order by idcategory $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }
    
    function getorderListproductishome($start, $end, $mode, $is_home) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM product WHERE is_home='" . $is_home . "' order by is_home $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }
    function getorderListproductishomeslide($start, $end, $mode, $is_home) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM product WHERE is_sliderhome='" . $is_home . "' order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }

    function getlastproduct($start, $end, $mode) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM product  order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getSumproduct() {
        $xstr = "SELECT COUNT(idx) as jumlah From product";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function insertproduct($idx, $product, $img, $is_home, $description, $idcategory,$is_sliderhome,$tgl_input) {
        $xstr = "INSERT INTO product(idx,product,img,is_home,description,idcategory,is_sliderhome,tgl_input) VALUES('" . $idx . "','" . $product . "','" . $img . "','" . $is_home . "','" . $description . "','" . $idcategory . "','".$is_sliderhome."','".$tgl_input."')";

        $query = $this->db->query($xstr);
    }

    function updateproduct($idx, $product, $img, $is_home, $description, $idcategory,$is_sliderhome,$tgl_input) {
        $xstr = "Update product set " .
                "idx='" . $idx . "'," .
                "product='" . $product . "'," .
                "img='" . $img . "'," .
                "is_home='" . $is_home . "'," .
                "description='" . $description . "'," .
                "idcategory='" . $idcategory . "'," .
                "is_sliderhome='".$is_sliderhome."',".
                "tgl_input='".$tgl_input."'".
                " WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
    }

    function deleteproduct($idx) {
        $xstr = "DELETE from product WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
    }
     function getSubProduct($productId) {
//        return $this->db->count_all("product");
        $xstr = "SELECT * FROM productshow WHERE idsubcategory='$productId'";
        $query = $this->db->query($xstr);
       
        return $query;

    }
	
	function getPro($cari) {
//        return $this->db->count_all("product");
        $xstr = "SELECT * FROM productshow WHERE product LIKE '%$cari%' OR description LIKE '%$cari%'";
        $query = $this->db->query($xstr);
       
        return $query;

    }
	
	function getTotalCari($cari) {
//        return $this->db->count_all("product");
		
		return $query = $this->db->query("SELECT COUNT(*) as jumlah FROM productshow WHERE product LIKE '%$cari%' OR description LIKE '%$cari%'");	

    }
	
	function getSubProductDetail($productId) {
//        return $this->db->count_all("product");
        $xstr = "SELECT * FROM productshow WHERE idproduct='$productId'";
        $query = $this->db->query($xstr);
       
        return $query;

    }
	
	 function getTotalSubProduct($productId) {
//        return $this->db->count_all("product");
		
		return $query = $this->db->query("SELECT COUNT(*) as jumlah FROM productshow WHERE idsubcategory='$productId'");	

    }
	
	function getSub($productId) {
//        return $this->db->count_all("product");
        $xstr = "SELECT * FROM subcategory sc JOIN productshow ps ON (sc.idsubcategory = ps.idsubcategory) WHERE sc.idx='$productId'";
        $query = $this->db->query($xstr);
       
        return $query;

    }
	
	function getTotalSub($productId) {
//        return $this->db->count_all("product");
        return $query = $this->db->query( "SELECT COUNT(*) as jumlah FROM subcategory sc JOIN productshow ps ON (sc.idsubcategory = ps.idsubcategory) WHERE sc.idx='$productId'");
        

    }
	
	function getCat(){
        $xstr = "Select * from category";
        $query = $this->db->query($xstr);
        return $query;
    }
	
		function getSubCat($idx){
        $xstr = "Select * from subcategory where idx = '$idx' ";
        $query = $this->db->query($xstr);
        return $query;
    }
	
	function getImageGallery($productId) {
//        return $this->db->count_all("product");
        $xstr = "SELECT * FROM galery WHERE productKode='$productId'";
        $query = $this->db->query($xstr);
       
        return $query;

    }

}

?>
