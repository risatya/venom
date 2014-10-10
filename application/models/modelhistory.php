<?php

class modelhistory extends CI_Model {

    public function fetch_history($start, $end, $mode, $history = ""){
        if (!empty($history)) {
            $history = " WHERE history Like '%" . $history . "%'";
        }
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM history $history order by idx $mode limit " . $start . "," . $end;
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
        return $this->db->count_all("history");
    }

    function getdetailhistory($idx) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM history WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListhistorybyhistory($start, $end, $mode, $history = "") {
        if (!empty($history)) {
            $history = " WHERE history Like '%" . $history . "%'";
        }
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM history $history order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }

    function getorderdetailhistory($start, $end, $mode, $idx) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM history WHERE idx='" . $idx . " order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getorderdetailhistoryishome($start, $end, $mode, $is_home) {
        $xstr = "SELECT *,SUBSTRING_INDEX(description,'</p>',1) as readmore FROM history WHERE ishome='" . $is_home . "' order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getSumhistory() {
        $xstr = "SELECT COUNT(idx) as jumlah From history";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function inserthistory($idx, $history, $ishome, $img, $description) {
        $xstr = "INSERT INTO history(idx,history,ishome,img,description) VALUES('" . $idx . "','" . $history . "','" . $ishome . "','" . $img . "','" . $description . "')";

        $query = $this->db->query($xstr);
    }

    function updatehistory($idx, $history, $ishome, $img, $description) {
        $xstr = "Update history set " .
                "idx='" . $idx . "'," .
                "history='" . $history . "'," .
                "ishome='" . $ishome . "'," .
                "img='" . $img . "'," .
                "description='" . $description . "'" .
                " WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
    }

    function deletehistory($idx) {
        $xstr = "DELETE from history WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
    }

}

?>