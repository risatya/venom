<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelcategory 
 * @author ASUS
 */
class modelcategory extends CI_Model {

    //put your code here
    function getArraycategory() {
        $xStr = "Select * From category";
        $query = $this->db->query($xStr);
        $xBufResult[0] = '- Nama Category -';
        foreach ($query->result() as $row) {
            $xBufResult[$row->idx] = $row->category;
        }
        return $xBufResult;
    }

    function getArraycategorytop() {
        $xStr = "Select * From category WHERE parent='0'";
        $query = $this->db->query($xStr);
        $xBufResult[0] = '- Nama Category -';
        foreach ($query->result() as $row) {
            $xBufResult[$row->idx] = $row->category;
        }
        return $xBufResult;
    }

    function getArraycategoryproduct() {
        $xStr = "Select * From category WHERE idx!='4'";
        $query = $this->db->query($xStr);
        $xBufResult[0] = '- Nama Category -';
        foreach ($query->result() as $row) {
            $xBufResult[$row->idx] = $row->category;
        }
        return $xBufResult;
    }

    function getListcategory($start, $end, $title = '', $mode) {
        if (!empty($title)) {
            $title = "WHERE category like '%" . $title . "%'";
        }
        $xstr = "Select * from category $title order by  idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }
    function getListcategorybybaret($start, $end, $parent, $mode){
        $xstr = "Select * from category WHERE parent='".$parent."' and isnav='Y' order by  sort_order $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }
    function getsumcategory() {
        $xstr = "SELECT COUNT(idx) as jumlah From category";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getDetailcategory($idx) {
        $xstr = "Select * from category WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
     function getDetailcategoryparent($parent) {
        $xstr = "Select * from category WHERE parent='" . $parent . "' order by idx DESC limit 0,1";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getDetailcategorybyparent($parent) {
        $xstr = "Select * from category WHERE parent='" . $parent . "'";
        $query = $this->db->query($xstr);
        return $query;
    }

    function insertcategory($idx, $category, $parent, $isnav, $sort_order, $link, $is_parent,$bentuk_tampilan) {
        $xstr = "insert into category " .
                "(idx, " .
                "category, " .
                "parent, " .
                "isnav, " .
                "sort_order, " .
                "link, " .
                "is_parent,bentuk_tampilan" .
                ") values" .
                "('" . $idx . "', " .
                "'" . $category . "', " .
                "'" . $parent . "', " .
                "'" . $isnav . "', " .
                "'" . $sort_order . "', " .
                "'" . $link . "', " .
                "'" . $is_parent . "','".$bentuk_tampilan."')";
        $query = $this->db->query($xstr);
    }

    function updatecategory($idx, $category, $parent, $isnav, $sort_order, $link, $is_parent) {
        $xstr = "update category set " .
                "idx = '" . $idx . "' , " .
                "category = '" . $category . "' , " .
                "parent = '" . $parent . "' , " .
                "isnav = '" . $isnav . "' , " .
                "sort_order = '" . $sort_order . "' ," .
                "link = '" . $link . "' , " .
                "is_parent = '" . $is_parent . "' where idx = '" . $idx . "'";
        $query = $this->db->query($xstr);
    }

    function detelecategory($idx) {
        $xstr = "DELETE FROM category WHERE idx= '" . $idx . "' and idx>5";
        $query = $this->db->query($xstr);
        return $query;
    }
     //////////////////////////////////////////*Tambahan Soma*//////////////////////////////////////////////////
	function getSubCat($idx){
        $xstr = "Select * from subcategory WHERE idx=".$idx;
        $query = $this->db->query($xstr);
        return $query;
    }
	
		function getCat($idx){
        $xstr = "Select * from category";
        $query = $this->db->query($xstr);
        return $query;
    }
	///////////////////////////////////////////////////////////////////////////////////////////////////////

}

?>
