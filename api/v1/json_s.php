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

    $servername = "localhost:3306";
    $username = "jace";
    $password = "Ghost797";
    $dbname = "hpd2";
    $rec_limit = 9;
    $conn = new mysqli($servername, $username,$password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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
    $result = $conn->query($sql);
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
}

