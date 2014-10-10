<?php

class Backup extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loads the database setting 
    }

    public function backup_db() {
        /* Store All Table name in an Array */


        $return = "";
        $allTables = array();
        $result = mysql_query('SHOW TABLES');
        while ($row = mysql_fetch_row($result)) {
            $allTables[] = $row[0];
        }

        foreach ($allTables as $table) {
            $result = mysql_query('SELECT * FROM ' . $table);

            $num_fields = mysql_num_fields($result);

            $return.= 'DROP TABLE IF EXISTS ' . $table . ';';

            $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));

            $return.= "\n\n" . $row2[1] . ";\n\n";

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysql_fetch_row($result)) {
                    $return.= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);

                        if (isset($row[$j])) {
                            $return.= '"' . $row[$j] . '"';
                        } else {
                            $return.= '""';
                        }

                        if ($j < ($num_fields - 1)) {
                            $return.= ',';
                        }
                    }
                    $return.= ");\n";
                }
            }
            $return.="\n\n";
        }// Create Backup Folder


        foreach ($allTables as $table) {
            $result = mysql_query('SELECT * FROM ' . $table);

            $num_fields = mysql_num_fields($result);

            $return.= 'DROP TABLE IF EXISTS ' . $table . ';';

            $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));

            $return.= "\n\n" . $row2[1] . ";\n\n";

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysql_fetch_row($result)) {
                    $return.= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);

                        if (isset($row[$j])) {
                            $return.= '"' . $row[$j] . '"';
                        } else {
                            $return.= '""';
                        }

                        if ($j < ($num_fields - 1)) {
                            $return.= ',';
                        }
                    }
                    $return.= ");\n";
                }
            }
            $return.="\n\n";
        }// Create Backup Folder

        $folder = 'Database_Backup/';

        if (!is_dir($folder))
            mkdir($folder, 0755, true);
        chmod($folder, 0755);

        $date = date('m-d-Y-H-i-s', time());
        $filename = $folder . "Medi_Hospi-" . $date;

        $handle = fopen($filename . '.sql', 'w+');

        fwrite($handle, $return);
        fclose($handle);

        echo "Backup of Database Taken";
    }

    function generatemodel() {
        $allTables = array();
        $result = mysql_query('SHOW TABLES');
        while ($row = mysql_fetch_row($result)) {
            $allTables[] = $row[0];
        }
        $folder = 'generate_model/';

        if (!is_dir($folder))
            mkdir($folder, 0755, true);
        chmod($folder, 0755);
        $return = '';
        $filename = '';
        foreach ($allTables as $table) {


            $result = mysql_query('SELECT * FROM ' . $table);
            $id = mysql_field_name($result, 0);
            $title = mysql_field_name($result, 1);
            $return.= "<?php ";
            $return.="\n";
            $return.="class model" . $table . " extends CI_Model {";
            $return.="\n";

            $return.="\n";
            $return.='function getdetail' . $table . '($' . $id . '){';
            $return.="\n";
            $return.='$xstr="SELECT * FROM ' . $table;
            $return.=' WHERE ' . $id . '=';
            $return.="'";
            $return.='".';
            $return.='$' . $id . '."';
            $return.="'";
            $return.='";';
            $return.="\n";
            $return.='$query=$this->db->query($xstr);';
            $return.="\n";
            $return.=' $row = $query->row();';
            $return.="\n";
            $return.=' return $row;';
            $return.="\n";
            $return.='}';
            $return.="\n\n";
            $return.='function getList' . $table . 'by' . $title . '($start,$end,$mode,$' . $title . '=""){';
            $return.="\n";
            $return.='if(!empty($' . $title . ')){';
            $return.="\n";
            $return.='$' . $title . '=';
            $return.='"';
            $return.=' WHERE ' . $title . ' Like ';
            $return.="'%";
            $return.='".';
            $return.='$' . $title . '."';
            $return.="%'";
            $return.='";';
            $return.="\n";
            $return.='}';
            $return.="\n";
            $return.='$xstr="SELECT * FROM ' . $table . ' $' . $title . ' order by ' . $id . ' $mode limit " . $start . "," . $end;';
            $return.="\n";
            $return.='$query=$this->db->query($xstr);';
            $return.="\n";
            $return.=' return $query;';
            $return.="\n";
            $return.='}';
            $return.="\n\n";
            $return.='function getorderdetail' . $table . '($start,$end,$mode,$' . $id . '){';
            $return.="\n";
            $return.='$xstr="SELECT * FROM ' . $table;
            $return.=' WHERE ' . $id . '=';
            $return.="'";
            $return.='".';
            $return.='$' . $id . '." order by ' . $id . ' $mode limit " . $start . "," . $end;';
            $return.="\n";
            $return.='$query=$this->db->query($xstr);';
            $return.="\n";
            $return.=' $row = $query->row();';
            $return.="\n";
            $return.=' return $row;';
            $return.="\n";
            $return.='}';
            $return.="\n\n";
            $return.='function insert' . $table . '(';
            $num_fields = mysql_num_fields($result);
            for ($i = 0; $i < $num_fields; $i++) {
                $return.='$' . mysql_field_name($result, $i) . '';
                if ($i < ($num_fields - 1)) {
                    $return.= ',';
                }
            }
            $return.= "){\n";
            $return.= '$xstr="INSERT INTO ' . $table . '';
            $return.='(';
            for ($j = 0; $j < $num_fields; $j++) {
                $return.='' . mysql_field_name($result, $j) . '';
                if ($j < ($num_fields - 1)) {
                    $return.= ',';
                }
            }
            $return.=')';
            $return.=' VALUES(';
            for ($j = 0; $j < $num_fields; $j++) {
                $return.="'";
                $return.='".$' . mysql_field_name($result, $j) . '."';
                $return.="'";
                if ($j < ($num_fields - 1)) {
                    $return.= ',';
                }
            }
            $return.= ")";
            $return.='";';
            $return.="\n\n";
            $return.='$query=$this->db->query($xstr);';
            $return.="}";
            $return.="\n\n";
            $return.='function update' . $table . '(';
            for ($i = 0; $i < $num_fields; $i++) {
                $return.='$' . mysql_field_name($result, $i) . '';
                if ($i < ($num_fields - 1)) {
                    $return.= ',';
                }
            }
            $return.= "){\n";
            $return.= '$xstr="Update ' . $table . ' set ".';
            $return.="\n";
            for ($j = 0; $j < $num_fields; $j++) {
                $return.='"' . mysql_field_name($result, $j) . '=';
                $return.="'";
                $return.='".$' . mysql_field_name($result, $j) . '."';
                $return.="'";
                if ($j < ($num_fields - 1)) {
                    $return.= ',';
                }
                $return.='".';
                $return.="\n";
            }
            $return.='" WHERE ' . mysql_field_name($result, 0) . '=';
            $return.="'";
            $return.='".$' . mysql_field_name($result, 0) . '."';
            $return.="'";
            $return.='";';
            $return.="\n";
            $return.='$query=$this->db->query($xstr);';
            $return.="}";
            $return.="\n\n";
            $return.='function delete' . $table . '($' . mysql_field_name($result, 0) . '){';
            $return.="\n";
            $return.='$xstr="DELETE from ' . $table;
            $return.=' WHERE ' . mysql_field_name($result, 0) . '=';
            $return.="'";
            $return.='".$' . mysql_field_name($result, 0) . '."';
            $return.="'";
            $return.='";';
            $return.="\n";
            $return.='$query=$this->db->query($xstr);';
            $return.="}";
            $return.="\n\n";
            $return.="}";
            $return.="\n\n";
            $return.="?>";

            $filename = $folder . 'model' . $table;
            $handle = fopen($filename . '.php', 'w+');

            fwrite($handle, $return);
            $return = '';
            fclose($handle);
        }
    }

    function generatecontroller() {
        $xcontent = '';

        $allTables = array();
        $result = mysql_query('SHOW TABLES');
        while ($row = mysql_fetch_row($result)) {
            $allTables[] = $row[0];
        }
        $folder = 'generate_control/';

        if (!is_dir($folder))
            mkdir($folder, 0755, true);
        chmod($folder, 0755);
        $filename = '';
        foreach ($allTables as $table) {
            $xcontent.='<?php';
            $xcontent.="\n\n";
            $xcontent.='class input' . $table . ' extends CI_Controller {';
            $xcontent.="\n\n";
            $xcontent.=' public function index() {';
            $xcontent.="\n\n";
            $xcontent.='$head';
            $xcontent.="['ajax'] = '<script";
            $xcontent.='language="javascript" type="text/javascript" src="';
            $xcontent.=". base_url() .ajax/ajaxinput" . $table . ".js";
            $xcontent.= '"></script>';
            $xcontent.="';";
            $xcontent.="\n\n";
            $xcontent.=' $this->load->view("", $head);';
            $xcontent.="\n";
            $xcontent.="}";
            $xcontent.="\n\n";
            $result = mysql_query('SELECT * FROM ' . $table);
            $xcontent.='function save(){';
            $xcontent.="\n";
            $xcontent.='$this->load->model("model' . $table . '");';
            $xcontent.="\n";
            $num_fields = mysql_num_fields($result);
            for ($i = 0; $i < $num_fields; $i++) {
                $xcontent.='$' . mysql_field_name($result, $i) . '=$_POST[';
                $xcontent.="'";
                $xcontent.=mysql_field_name($result, $i);
                $xcontent.="'];";
                $xcontent.="\n";
            }

            $xcontent.='if($' . mysql_field_name($result, 0) . '==0){';
            $xcontent.="\n";
            $xcontent.='$this->model' . $table . '->insert' . $table . '(';
            for ($i = 0; $i < $num_fields; $i++) {
                $xcontent.='$' . mysql_field_name($result, $i);
                if ($i < ($num_fields - 1)) {
                    $xcontent.= ',';
                }
            }
            $xcontent.=');';
            $xcontent.="\n";
            $xcontent.="}else{";
            $xcontent.="\n";
            $xcontent.='$this->model' . $table . '->update' . $table . '(';
            for ($i = 0; $i < $num_fields; $i++) {
                $xcontent.='$' . mysql_field_name($result, $i);
                if ($i < ($num_fields - 1)) {
                    $xcontent.= ',';
                }
            }
            $xcontent.=');';
            $xcontent.="\n";
            $xcontent.="}";
            $xcontent.="\n";
            $xcontent.="}";
            $xcontent.="\n";
            $xcontent.='function detele($' . mysql_field_name($result, 0) . '){';
            $xcontent.="\n";
            $xcontent.='$this->load->model("model' . $table . '");';
            $xcontent.="\n";
            $xcontent.='$' . mysql_field_name($result, 0) . '=$_POST[';
            $xcontent.="'";
            $xcontent.=mysql_field_name($result, 0);
            $xcontent.="'];";
            $xcontent.="\n";
            $xcontent.="\n";
            $xcontent.='$this->model' . $table . '->delete' . $table . '($' . mysql_field_name($result, 0) . ');';
            $xcontent.="\n";
            $xcontent.="}";
            $xcontent.="\n\n";
            $xcontent.="}";
            $xcontent.="\n\n";
            $xcontent.="?>";

            $filename = $folder . 'input' . $table;
            $handle = fopen($filename . '.php', 'w+');

            fwrite($handle, $xcontent);
            $xcontent = '';
            fclose($handle);
        }
    }

}

?>