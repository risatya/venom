<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modeladmin
 *
 * @author ASUS
 */
class modeladmin extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getdataLogin($username, $passwd) {
        $xstr = "Select * from contact Where username='".$username."' and passwd='".$passwd."'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
     function getdatauser($idx) {
        $xstr = "Select * from contact Where idx='".$idx."'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

}

?>
