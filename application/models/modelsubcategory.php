<?php
class modelsubcategory extends CI_Model{
	function getAllSubcategory(){
		$query=$this->db->get('subcategory');
		$data=$query->result();
		return $data;
	}
	function getListsubcategory($start, $end, $title = '', $mode) {
        if (!empty($title)) {
            $title = "WHERE subcategory like '%" . $title . "%'";
        }
        $xstr = "Select * from subcategory $title order by  idsubcategory $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }
    function getsumsubcategory() {
        $xstr = "SELECT COUNT(idsubcategory) as jumlah From subcategory";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
    function getDetailsubcategory($idsubcategory) {
        $xstr = "Select * from subcategory WHERE idsubcategory='" . $idsubcategory . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
    function insertsubcategory($data) {
        $this->db->insert('subcategory',$data);
    }
    function updatesubcategory($data,$idsubcategory){
		$this->db->where('idsubcategory',$idsubcategory);
		$this->db->update('subcategory',$data);
	}
	function detelesubcategory($idsubcategory) {
        $xstr = "DELETE FROM subcategory WHERE idsubcategory= '$idsubcategory'";
        $query = $this->db->query($xstr);
        return $query;
    }
    function getarraysubcategory($idx) {
        $xStr = "Select * From subcategory WHERE idx='$idx'";
        $query = $this->db->query($xStr);
        $xBufResult[0] = '- Pilih Subcategory -';
        foreach ($query->result() as $row) {
            $xBufResult[$row->idsubcategory] = $row->subcategory;
        }
        return $xBufResult;
    }
    function getarraysubcategoryblank() {
        $xBufResult[0] = '- Pilih Subcategory -';
        return $xBufResult;
    }

}
?>
