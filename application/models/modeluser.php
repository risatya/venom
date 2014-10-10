<?php

class modeluser extends CI_Model {

    function getdetailuser($idx) {
        $xstr = "SELECT * FROM user WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListuserbyusername($start, $end, $mode, $username = "") {
        if (!empty($username)) {
            $username = " WHERE nama Like '%" . $username . "%'";
        }
        $xstr = "SELECT * FROM user $username order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }

    function getorderdetailuser($start, $end, $mode, $idx) {
        $xstr = "SELECT * FROM user WHERE idx='" . $idx . " order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function insertuser($idx, $username, $passwd, $email, $randcode, $nama) {
        $xstr = "INSERT INTO user(idx,username,passwd,email,randcode,nama) VALUES('" . $idx . "','" . $username . "','" . $passwd . "','" . $email . "','" . $randcode . "','" . $nama . "')";

        $query = $this->db->query($xstr);
    }

    function getSumuser() {
        $xstr = "SELECT COUNT(idx) as jumlah From user";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function updateuser($idx, $username, $passwd, $email, $randcode, $nama) {
        $xstr = "Update user set " .
                "idx='" . $idx . "'," .
                "username='" . $username . "'," .
                "passwd='" . $passwd . "'," .
                "email='" . $email . "'," .
                "randcode='" . $randcode . "'," .
                "nama='" . $nama . "'" .
                " WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
    }

    function deleteuser($idx) {
        $xstr = "DELETE from user WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
    }

}

?>