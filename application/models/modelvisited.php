<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelvisited
 *
 * @author PT.SYDECO
 */
class modelvisited extends CI_Model {

    //put your code here
    function getSum_visited($mountyear) {
        $xstr = "SELECT COUNT(idx) as jumlah From visitpage WHERE DATE_FORMAT(dateadd,'%m-%Y')='" . $mountyear . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function insertvisited($idx, $ipaddr,$dateadd) {
        $xstr = "insert into visitpage (idx, ipaddr,dateadd) values('" . $idx . "', '" . $ipaddr . "','".$dateadd."')";
        $query = $this->db->query($xstr);
    }

}

?>
