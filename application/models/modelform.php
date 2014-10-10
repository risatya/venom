<?php
class modelform extends CI_Model{
	function getAll(){
		$query=$this->db->query("select * from form");
		return $query->result();
	}
	function getByIdForm($id_form){
		$query=$this->db->query("select * from form");
		return $query->row_array();
	}
	function updateForm($id_form,$data){
		$this->db->where('id_form',$id_form);
		$this->db->update('form',$data);
	}
	function deleteForm($id_form){
		$this->db->delete('form',$id_form);
	}
	function insertForm(){
		$this->db->insert('form',$data);
	}
}


?>
