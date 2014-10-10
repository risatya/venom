<?php
class modelformlist extends CI_Model{
	function getAll(){
		$query=$this->db->query("select * from form_list");
		return $query->result();
	}
	function getByIdFormList($id_form_list){
		$query=$this->db->query("select * from form_list");
		return $query->row_array();
	}
	function updateFormList($id_form,$data){
		$this->db->where('id_form_list',$id_form);
		$this->db->update('form_list',$data);
	}
	function deleteFormList($id_form){
		$this->db->delete('form_list',$id_form);
	}
	function insertFormList(){
		$this->db->insert('form_list',$data);
	}
}


?>
