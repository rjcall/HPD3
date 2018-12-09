<?php
/**
 * User: rjcal
 * Date: 10/12/2018
 * Time: 11:29 AM
 */
require_once "owners.php";
header("Content-Type: application/json; charset=UTF-8");
if(isset($_GET{"x"})){
    $obj = json_decode($_GET{"x"}, false);
    $host = "localhost";
    $usr = "jace";
    $pwd = "Ghost797";
    $db = "hpd";

    $mysqli = new mysqli($host, $usr, $pwd, $db);

    $dir = $obj->sort_dir;
    $cols = array("fname", "lname", "street1", "street2", "city", "state", "zip", "policy", "expiration");
    if(in_array($obj->sort,$cols)){
        if($dir == "down"){
            $sql = "SELECT * FROM {$obj->table} ORDER BY {$obj->sort} desc LIMIT {$obj->offset}, {$obj->limit}";
        }
        else{
            $sql = "SELECT * FROM {$obj->table} ORDER BY {$obj->sort} asc LIMIT {$obj->offset}, {$obj->limit}";
        }
    }
    else{
        $sql = "SELECT * FROM {$obj->table} LIMIT {$obj->offset}, {$obj->limit}";

    }
    $result = $mysqli->query($sql);
     if (!$result)
      die("query didn't work bud");
      $results = array();
      while ($row = $result->fetch_row()) {
        array_push($results, $row); 
    }
    echo json_encode($results);
}