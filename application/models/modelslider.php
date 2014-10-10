<?php

class modelslider extends CI_Model {

    function getdetailslider($idx) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM slider WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListsliderbyTitle($start, $end, $mode, $Title = "") {
        if (!empty($Title)) {
            $Title = " WHERE Title Like '%" . $Title . "%'";
        }
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM slider $Title order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }

    function getorderdetailslider($start, $end, $mode, $idx) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM slider WHERE idx='" . $idx . " order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
    function getSumslider() {
        $xstr = "SELECT COUNT(idx) as jumlah From slider";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function insertslider($idx, $Title, $image, $link, $sort_order, $description) {
        $xstr = "INSERT INTO slider(idx,Title,image,link,sort_order,description) VALUES('" . $idx . "','" . $Title . "','" . $image . "','" . $link . "','" . $sort_order . "','" . $description . "')";

        $query = $this->db->query($xstr);
    }

    function updateslider($idx, $Title, $image, $link, $sort_order, $description) {
        $xstr = "Update slider set " .
                "idx='" . $idx . "'," .
                "Title='" . $Title . "'," .
                "image='" . $image . "'," .
                "link='" . $link . "'," .
                "sort_order='" . $sort_order . "'," .
                "description='" . $description . "'" .
                " WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
    }

    function deleteslider($idx) {
        $xstr = "DELETE from slider WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
    }

}

?>