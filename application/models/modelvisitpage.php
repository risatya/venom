<?php 
class modelvisitpage extends CI_Model {

function getdetailvisitpage($idx){
$xstr="SELECT * FROM visitpage WHERE idx='".$idx."'";
$query=$this->db->query($xstr);
 $row = $query->row();
 return $row;
}

function getListvisitpagebyipaddr($start,$end,$mode,$ipaddr=""){
if(!empty($ipaddr)){
$ipaddr=" WHERE ipaddr Like '%".$ipaddr."%'";
}
$xstr="SELECT * FROM visitpage $ipaddr order by idx $mode limit " . $start . "," . $end;
$query=$this->db->query($xstr);
 return $query;
}

function getorderdetailvisitpage($start,$end,$mode,$idx){
$xstr="SELECT * FROM visitpage WHERE idx='".$idx." order by idx $mode limit " . $start . "," . $end;
$query=$this->db->query($xstr);
 $row = $query->row();
 return $row;
}

function insertvisitpage($idx,$ipaddr,$dateadd){
$xstr="INSERT INTO visitpage(idx,ipaddr,dateadd) VALUES('".$idx.",''".$ipaddr.",''".$dateadd."')";

$query=$this->db->query($xstr);}

function updatevisitpage($idx,$ipaddr,$dateadd){
$xstr="Update visitpage set ".
"idx='".$idx."',".
"ipaddr='".$ipaddr."',".
"dateadd='".$dateadd."'".
" WHERE idx='".$idx."'";
$query=$this->db->query($xstr);}

function deletevisitpage($idx){
$xstr="DELETE from visitpage WHERE idx='".$idx."'";
$query=$this->db->query($xstr);}

}

?>