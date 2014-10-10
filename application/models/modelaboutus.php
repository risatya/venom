<?php

class modelaboutus extends CI_Model {

    function getdetailaboutus($idx) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM aboutus WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
    function getaboutus($idx) {
        $xstr = "SELECT * FROM aboutus WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListaboutusbytitle($start, $end, $mode, $title = "") {
        if (!empty($title)) {
            $title = " WHERE title Like '%" . $title . "%'";
        }
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM aboutus $title order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }

    function getorderdetailaboutus($start, $end, $mode, $idx) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM aboutus WHERE idx='" . $idx . "' order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getlastabaouus($start,$end,$mode) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore,SUBSTRING_INDEX(description,'<p>',-1) as readmore2 FROM aboutus order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function insertaboutus($idx, $title, $img, $description) {
        $xstr = "INSERT INTO aboutus(idx,title,img,description) VALUES('" . $idx . "','" . $title . "','" . $img . "','" . $description . "')";

        $query = $this->db->query($xstr);
    }

    function updateaboutus($idx, $title, $img, $description) {
        $xstr = "Update aboutus set " .
                "idx='" . $idx . "'," .
                "title='" . $title . "'," .
                "img='" . $img . "'," .
                "description='" . $description . "'" .
                " WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
    }

    function deleteaboutus($idx) {
        $xstr = "DELETE from aboutus WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
    }

}

?>
