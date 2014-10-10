<?php
class Modelfaq extends CI_model{
	function getListfaq($start, $end, $mode, $question = "") {
        if (!empty($question)) {
            $question = " WHERE question Like '%" . $question . "%'";
        }
        $xstr = "SELECT *,SUBSTRING_INDEX(question,'</p>',1) as readmore FROM faq $question order by idfaq $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }
    function getSumfaq() {
        $query = $this->db->query("SELECT COUNT(idfaq) as jumlah From faq");
        $row = $query->row();
        return $row;
    }
    function getallfaq(){
		$query=$this->db->query("select * from faq");
		return $query->result();
	}
	function getdetail($idfaq){
		$query=$this->db->query("select * from faq where idfaq='$idfaq'");
		return $query->row();
	}
	function update($data,$idfaq){
		$this->db->where('idfaq',$idfaq);
		$this->db->update('faq',$data);
	}
	function delete($idfaq){
		$this->db->where('idfaq',$idfaq);
		$this->db->delete('faq');
	}
	function insert($data){
		$this->db->insert('faq',$data);
	}
}

?>
