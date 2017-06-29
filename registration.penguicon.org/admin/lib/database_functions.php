<?php 

function insert_into_database($table,$items) {

    $sql_fields = "";
    $sql_values = "";
    foreach ($items as $field => $value) {
        if ($sql_fields != "") { 
            $sql_fields .= ",";
        }
        $sql_fields .= $field;
        if ($sql_values != "") { 
            $sql_values .= ",";
        }
        $sql_values .= "'".mysql_real_escape_string($value)."'";
    }

    $sql = "INSERT into ".$table." (".$sql_fields.") VALUES (".$sql_values.")";
    mysql_query($sql);
}

?>