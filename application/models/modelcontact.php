<?php

class modelcontact extends CI_Model {

    function getdetailcontact($idx) {
        $xstr = "SELECT * FROM contact WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListcontactbyalamat($start, $end, $mode, $alamat = "") {
        if (!empty($alamat)) {
            $alamat = " WHERE alamat Like '%" . $alamat . "%'";
        }
        $xstr = "SELECT * FROM contact $alamat order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }

    function getorderdetailcontact($start, $end, $mode, $idx) {
        $xstr = "SELECT * FROM contact WHERE idx='" . $idx . " order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getlastcontact($start, $end, $mode) {
        $xstr = "SELECT *  FROM contact order by idx $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function insertcontact($idx, $alamat, $no_tlp1, $name_company, $email, $pin, $no_tlp2, $hp1, $hp2, $hp3, $fb, $twitter, $gplus,$username,$passwd) {
        $xstr = "INSERT INTO contact(idx,alamat,no_tlp1,name_company,email,pin,no_tlp2,hp1,hp2,hp3,fb,twitter,gplus,username,passwd) VALUES('" . $idx . "','" . $alamat . "','" . $no_tlp1 . "','" . $name_company . "','" . $email . "','" . $pin . "','" . $no_tlp2 . "','" . $hp1 . "','" . $hp2 . "','" . $hp3 . "','" . $fb . "','" . $twitter . "','" . $gplus . "','".$username."','".$passwd."')";

        $query = $this->db->query($xstr);
    }

    function updatecontact($idx, $alamat, $no_tlp1, $name_company, $email, $pin, $no_tlp2, $hp1, $hp2, $hp3, $fb, $twitter, $gplus,$username,$passwd) {
        $xstr = "Update contact set " .
                "idx='" . $idx . "'," .
                "alamat='" . $alamat . "'," .
                "no_tlp1='" . $no_tlp1 . "'," .
                "name_company='" . $name_company . "'," .
                "email='" . $email . "'," .
                "pin='" . $pin . "'," .
                "no_tlp2='" . $no_tlp2 . "'," .
                "hp1='" . $hp1 . "'," .
                "hp2='" . $hp2 . "'," .
                "hp3='" . $hp3 . "'," .
                "fb='" . $fb . "'," .
                "twitter='" . $twitter . "'," .
                "gplus='" . $gplus . "'," .
                "username='" . $username . "'," .
                "passwd='" . $passwd . "'" .
                " WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
    }

    function deletecontact($idx) {
        $xstr = "DELETE from contact WHERE idx='" . $idx . "'";
        $query = $this->db->query($xstr);
    }

}

?>