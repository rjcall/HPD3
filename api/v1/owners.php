<?php 
/**
 * User: rjcal
 * Date: 10/12/2018
 * Time: 11:45 AM
 */

function createOwner($fname, $lname, $street1, $street2, $city, $state, $zip, $policy, $expiration) {

  global $mysqli;
  $sqlcreate = "INSERT INTO Owners(fname, lname, street1, street2, city, state, zip, policy, expiration) 
  VALUES('$fname', '$lname', '$street1', '$street2', '$city', '$state', '$zip', '$policy', '$expiration')";
  $result = $mysqli->query($sqlcreate);
  $createAffected = $mysqli->affected_rows;
  if (!$result)
    die("query didn't work bud");
  header("Status: 201 CREATED");
}

function readOwner($id) { 
  global $mysqli;

  $sql1 = "SELECT * FROM owners WHERE owner_id = $id";
      $result = $mysqli->query($sql1);
      if (!$result)
      die("query didn't work bud");
      $results = array();
      while ($row = $result->fetch_row()) {
        array_push($results, $row); 
    }
    return json_encode($results);
}




function updateOwner($ownerId, $fname, $lname, $street1, $street2, $city, $state, $zip, $policy, $expiration) {

  global $mysqli;

  $sqlcreate = "UPDATE Owners
                      SET 
                      fname='$fname', 
                      lname='$lname', 
                      street1='$street1', 
                      street2='$street2', 
                      city='$city', 
                      state='$state', 
                      zip='$zip', 
                      policy='$policy', 
                      expiration='$expiration'
                      WHERE owner_id='$ownerId'";

  $result = $mysqli->query($sqlcreate);
  $createAffected = $mysqli->affected_rows;
  if (!$result)
    die("query didn't work bud");
}

function deleteOwner($id) {
  global $mysqli;
  $sql1 = "DELETE FROM owners WHERE owner_id = $id";
      $result = $mysqli->query($sql1);
      if (!$result)
      die("query didn't work bud");
}


function listOwners($column, $filter, $offset) {

  global $mysqli;
  if ($offset == ""){$offset = 0;}

  $sql1 = "SELECT * FROM owners $filter ORDER BY $column LIMIT $offset, 10";
      $result = $mysqli->query($sql1);
      if (!$result)
      die("query didn't work bud");
      $results = array();
      while ($row = $result->fetch_row()) {
        array_push($results, $row); 
    }
    return json_encode($results);
}
?>